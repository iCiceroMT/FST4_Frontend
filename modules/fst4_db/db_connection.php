<?php
/**
 * Created by PhpStorm.
 * User: Cicero
 * Date: 19.04.2018
 * Time: 08:23
 */

defined('_JEXEC') or die;
class database{
    
   protected function connectdb(){ 
    $host = 's567507373.online.de';
    $db   = 'FST4';
    $user = 'FST4';
    $pass = 'adminfst4';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    return $pdo;
    
   }
   
   protected function GUID()
        {
            if (function_exists('com_create_guid') === true)
            {
                return trim(com_create_guid(), '{}');
            }

            return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        }
   
   public function getAllArticle(){
       $pdo = $this->connectdb();
       $data = $pdo->query('SELECT * FROM article')->fetchAll(PDO::FETCH_ASSOC);
       return $data;
   }
   
   public function getArticleDetail($id){
       $pdo = $this->connectdb();
       $data = $pdo->query('SELECT * FROM article 
                                     LEFT JOIN rating using(article_id)
                                     WHERE article_id = ' . $id)->fetchAll(PDO::FETCH_ASSOC);
       return $data;
   }
   
      public function getAllPackage(){
       $pdo = $this->connectdb();
       $data = $pdo->query('SELECT * FROM package')->fetchAll(PDO::FETCH_ASSOC);
       return $data;
   }
   
      public function getPackageDetail($id){
       $pdo = $this->connectdb();
       $data = $pdo->query('SELECT * FROM package WHERE package_id = ' . $id)->fetchAll(PDO::FETCH_ASSOC);
       return $data;
   }
   
   public function insertNewVoucher($voucher, $code, $date){
      $pdo = $this->connectdb();
      //$query = "INSERT INTO `voucher` (`voucher_id`, `amount`, `code`, `used`, `date`) VALUES (NULL, ".$voucher.",'".$code."',b'0','".$date."')";
    $query = 'INSERT INTO voucher (amount, code, used, date) VALUES ("' .$voucher. '","' .$code. '", 0 ,"' .$date. '")';
      $pdo ->prepare($query)->execute();
     
   }
   
   public function regNewUser($data){
       $pdo = $this->connectdb();
       //checken ob stadt bereits vorhanden
       $city = $pdo->query('SELECT name FROM city WHERE zip_code = ' . $data['plz'])->fetchAll(PDO::FETCH_ASSOC);
       $guid = $this->GUID();
      if($city[0]['name'] == ''){
                $query_city = 'INSERT INTO city (zip_code, name) VALUES ("' .$data['plz']. '","' .$data['stadt']. '")';
                $pdo ->prepare($query_city)->execute();}
                
       $typeid = '1010bed3-55e6-11e8-8245-aadf6043312a';
       $pw = sha1($data['pw1']);
       $query = 'INSERT INTO person (`person_id`, `firstname`, `lastname`, `e-mail`, `password`, `birthdate`, `street`, `country`, `zip_code`, `type_id`) VALUES (NULL,"' .$data['vorname']. '","' .$data['nachname']. '","' .$data['mail']. '","' .$pw. '","' .$data['bdate']. '","' .$data['addresse']. '","' .$data['country']. '","' .$data['plz']. '","' .$typeid. '")';
     
       return $pdo ->prepare($query)->execute();
   }
      public function getSpecUser($email){
       $pdo = $this->connectdb();
       $data = $pdo->query('SELECT * FROM person JOIN city using(`zip_code`) WHERE `e-mail` = "' . $email . '"')->fetchAll(PDO::FETCH_ASSOC);
       return $data;
   }   
      public function changeUserData($data){
       $pdo = $this->connectdb();
       $city = $pdo->query('SELECT name FROM city WHERE zip_code = ' . $data['plz'])->fetchAll(PDO::FETCH_ASSOC);
       if($city[0]['name'] == ''){
                $query_city = 'INSERT INTO city (zip_code, name) VALUES ("' .$data['plz']. '","' .$data['stadt']. '")';
                $pdo ->prepare($query_city)->execute();}
       
       $query = 'UPDATE person SET `firstname` = "' .$data['vorname']. '", `lastname` = "' .$data['nachname']. '", `birthdate` = "' .$data['bdate']. '", `street` = "' .$data['addresse']. '", `country` = "' .$data['country']. '", `zip_code` = "' .$data['plz']. '", `e-mail` = "' .$data['mail']. '" WHERE  `e-mail` = "' .$data['mail_orig'] . '"';
         return $pdo ->prepare($query)->execute();
       
       
       
       }   
    public function checkUserPw($pw){
        $pdo = $this->connectdb();
        $pw_sha = sha1($pw);
   
        $data = $pdo->query('SELECT * FROM person WHERE password = "' . $pw_sha . '"')->fetchAll(PDO::FETCH_ASSOC);
        if($data[0]['e-mail'] != ''){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function newUserPw($pw, $mail){
        $pdo = $this->connectdb();
        $pw_sha = sha1($pw);
        $query = 'UPDATE person SET `password` = "' .$pw_sha. '" WHERE  `e-mail` = "' .$mail . '"';
        return $pdo ->prepare($query)->execute();
        
        
    }
}




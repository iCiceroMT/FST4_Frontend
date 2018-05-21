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
   
   protected function makeSync($type, $tablename, $pkeyname, $pkeyvalue, $columns, $values){
       //die Spaltennamen in einen String und jeweils in einen <string> tag
       $columnnames = "";
       $string_o = "<string>";
       $string_c = "</string>";
       foreach($columns as $column){
           $columnnames .= $string_o . $column . $string_c;
       }
       //die Werte in einen String und jeweils in einen <string> tag
       $columnvalues = "";
       foreach($values as $value){
           $columnvalues .= $string_o . $value . $string_c;
       }
       
       $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_PORT => "80",
              CURLOPT_URL => "http://localhost/FST4_Sync/CreateWebService.asmx",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",

              CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: text/xml",
                "Postman-Token: 567c2fff-d9a9-46c0-a548-a694fc974e37"
              ),
            ));

            //Hier wird das Soap XML zusammengebaut
            $data = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><InsertStatement xmlns="http://tempuri.org/"><statementModel><Type>'
                    //Type (Insert, etc)
                    . $type
                    . '</Type><TableName>'
                    //Tablename
                    . $tablename
                    . '</TableName><PrimaryKeyName>'
                    //Primary Key Name
                    . $pkeyname
                    . '</PrimaryKeyName><PrimaryKeyValue>'
                    //Primary Key Value
                    . $pkeyvalue
                    //Spaltennamen
                    . '</PrimaryKeyValue><Columns>'
                    . $columnnames
                    //Werte
                    . '</Columns><Values>'
                    . $columnvalues
                    . '</Values><Sender>'
                    //Sender
                    . 'App'
                    .'</Sender></statementModel></InsertStatement></soap:Body></soap:Envelope>';
            
          // return $data;
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              return "cURL Error #:" . $err;
            } else {
              return $response;
            }
       
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
                                     WHERE article_id = "' .$id . '"')->fetchAll(PDO::FETCH_ASSOC);
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
      $guid = $this->GUID();
      //$query = "INSERT INTO `voucher` (`voucher_id`, `amount`, `code`, `used`, `date`) VALUES (".$voucher.", ".$voucher.",'".$code."',b'0','".$date."')";
    $query = 'INSERT INTO voucher (`voucher_id`,`amount`, `code`, `used`, `date`) VALUES ("'.$guid. '", "' .$voucher. '","' .$code. '", 0 ,"' .$date. '")';
      $pdo ->prepare($query)->execute();
      
     //Sync
     $cols = array(); $vals = array();
     array_push($cols, "amount", "code", "used", "date");
     array_push($vals, $voucher, $code, 0, $date);
     return $this->makeSync("INSERT", "voucher", "voucher_id", $guid, $cols, $vals);
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
    
    public function remUser($mail){
        $pdo = $this->connectdb();
        $query = 'DELETE * FROM person WHERE  `e-mail` = "' .$mail . '"';
        return $pdo ->prepare($query)->execute();     
    }
}




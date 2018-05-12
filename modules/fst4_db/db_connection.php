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
   
}




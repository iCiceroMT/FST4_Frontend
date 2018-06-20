<?php

/**
 * Created by PhpStorm.
 * User: Cicero
 * Date: 19.04.2018
 * Time: 08:23
 */
defined('_JEXEC') or die;

class database {

    protected function connectdb() {
        /* $host = 's567507373.online.de';
          $db = 'FST4';
          $user = 'FST4';
          $pass = 'adminfst4';
          $charset = 'utf8mb4'; */

        $host = 'localhost';
        $db = 'fst4';
        $user = 'root';
        $pass = 'adminfst4';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);
        return $pdo;
    }

    protected function makeSync($type, $tablename, $pkeyname, $pkeyvalue, $columns, $values) {
        //die Spaltennamen in einen String und jeweils in einen <string> tag
        $columnnames = "";
        $string_o = "<string>";
        $string_c = "</string>";
        foreach ($columns as $column) {
            $columnnames .= $string_o . $column . $string_c;
        }
        //die Werte in einen String und jeweils in einen <string> tag
        $columnvalues = "";
        foreach ($values as $value) {
            $columnvalues .= $string_o . $value . $string_c;
        }

        //primarykeys zusammenbauen
        $pkeynames = "";
        $pkeyvalues = "";
        if (sizeof($pkeyname) > 0) {

            foreach ($pkeyname as $value) {
                $pkeynames .= $string_o . $value . $string_c;
            }

            foreach ($pkeyvalue as $value) {
                $pkeyvalues .= $string_o . $value . $string_c;
            }
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
                . '</TableName><PrimaryKeyNames>'
                //Primary Key Name
                . $pkeynames
                . '</PrimaryKeyNames><PrimaryKeyValues>'
                //Primary Key Value
                . $pkeyvalues
                //Spaltennamen
                . '</PrimaryKeyValues><Columns>'
                . $columnnames
                //Werte
                . '</Columns><Values>'
                . $columnvalues
                . '</Values><Sender>'
                //Sender
                . 'Frontend'
                . '</Sender></statementModel></InsertStatement></soap:Body></soap:Envelope>';

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

    protected function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function getAllArticle() {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM article')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getFrontpageArticle() {
        $pdo = $this->connectdb();
        $type = "Kuchen";
        $data = $pdo->query('SELECT a.article_id, a.price, a.description, a.creation, a.visible, a.shape_id, a.article_type_id, c.stars FROM article a
                                     LEFT JOIN article_type b using(article_type_id)
                                     LEFT JOIN rating c using(article_id)
                                     WHERE b.description = "' . $type . '" ORDER BY stars DESC')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getFrontpageArticleNew() {
        $pdo = $this->connectdb();
        $type = "Kuchen";
        $data = $pdo->query('SELECT a.article_id, a.price, a.description, a.creation, a.visible, a.shape_id, a.article_type_id, a.timestamp, c.stars FROM article a
                                     LEFT JOIN article_type b using(article_type_id)
                                     LEFT JOIN rating c using(article_id)
                                     WHERE b.description = "' . $type . '" ORDER BY a.timestamp DESC')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getAllArticleWithType($type) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT a.article_id, a.price, a.description, a.creation, a.visible, a.shape_id, a.article_type_id FROM article a
                                     LEFT JOIN article_type b using(article_type_id)
                                     WHERE b.description = "' . $type . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getArticleDetail($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM article 
                                     LEFT JOIN rating using(article_id)
                                     WHERE article_id = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getAllPackage() {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM package')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getPackageDetail($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM package WHERE package_id = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function insertNewVoucher($voucher, $code, $date) {
        $pdo = $this->connectdb();
        $guid = $this->GUID();
        //$query = "INSERT INTO `voucher` (`voucher_id`, `amount`, `code`, `used`, `date`) VALUES (".$voucher.", ".$voucher.",'".$code."',b'0','".$date."')";
        $query = 'INSERT INTO voucher (`voucher_id`,`amount`, `code`, `used`, `date`) VALUES ("' . $guid . '", "' . $voucher . '","' . $code . '", 0 ,"' . $date . '")';
        $pdo->prepare($query)->execute();
    }

    public function getVoucherValue($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT amount FROM `voucher` WHERE code = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function regNewUser($data) {
        $pdo = $this->connectdb();
        //checken ob stadt bereits vorhanden
        $city = $pdo->query('SELECT name FROM city WHERE zip_code = ' . $data['plz'])->fetchAll(PDO::FETCH_ASSOC);
        $guid = $this->GUID();
        if ($city[0]['name'] == '') {
            $query_city = 'INSERT INTO city (zip_code, name) VALUES ("' . $data['plz'] . '","' . $data['stadt'] . '")';
            $pdo->prepare($query_city)->execute();
        }

        $typeid = '1010bed3-55e6-11e8-8245-aadf6043312a';
        $pw = sha1($data['pw1']);
        $query = 'INSERT INTO person (`person_id`, `firstname`, `lastname`, `e-mail`, `password`, `birthdate`, `street`, `country`, `zip_code`, `type_id`) VALUES (NULL,"' . $data['vorname'] . '","' . $data['nachname'] . '","' . $data['mail'] . '","' . $pw . '","' . $data['bdate'] . '","' . $data['addresse'] . '","' . $data['country'] . '","' . $data['plz'] . '","' . $typeid . '")';

        return $pdo->prepare($query)->execute();
    }

    public function getSpecUser($email) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM person JOIN city using(`zip_code`) WHERE `e-mail` = "' . $email . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function changeUserData($data) {
        $pdo = $this->connectdb();
        $city = $pdo->query('SELECT `name` FROM `city` WHERE `zip_code` = ' . $data['plz'])->fetchAll(PDO::FETCH_ASSOC);

        if (empty($city)) {
            $query_city = 'INSERT INTO city (zip_code, name) VALUES ("' . $data['plz'] . '","' . $data['stadt'] . '")';
            $pdo->prepare($query_city)->execute();

            //SYNC*******************************************************************************
            $cols = array();
            $vals = array();
            $pknames = array();
            $pkvals = array();

            array_push($pknames, "zip_code");
            array_push($pkvals, $data['plz']);
            array_push($cols, "name");
            array_push($vals, $data['stadt']);

            return $this->makeSync("INSERT", "city", $pknames, $pkvals, $cols, $vals);
            //SYNC*******************************************************************************        
        }
        return "jo";
        $query = 'UPDATE person SET `firstname` = "' . $data['vorname'] . '", `lastname` = "' . $data['nachname'] . '", `birthdate` = "' . $data['bdate'] . '", `street` = "' . $data['addresse'] . '", `country` = "' . $data['country'] . '", `zip_code` = "' . $data['plz'] . '", `e-mail` = "' . $data['mail'] . '" WHERE  `e-mail` = "' . $data['mail_orig'] . '"';


        //SYNC*******************************************************************************
        /*       $cols = array(); $vals = array(); $pknames = array(); $pkvals = array();


          array_push($cols, "firstname", "lastname", "birthdate", "street", "country", "zip_code", "e-mail");
          array_push($vals, $data['stadt']);

          $erg = $this->makeSync("UPDATE", "person", $pknames, $pkvals, $cols, $vals); */
        //SYNC*******************************************************************************
        return $pdo->prepare($query)->execute();
    }

    public function checkUserPw($pw) {
        $pdo = $this->connectdb();
        $pw_sha = sha1($pw);

        $data = $pdo->query('SELECT * FROM person WHERE password = "' . $pw_sha . '"')->fetchAll(PDO::FETCH_ASSOC);
        if ($data[0]['e-mail'] != '') {
            return true;
        } else {
            return false;
        }
    }

    public function newUserPw($pw, $mail) {
        $pdo = $this->connectdb();
        $pw_sha = sha1($pw);
        $query = 'UPDATE person SET `password` = "' . $pw_sha . '" WHERE  `e-mail` = "' . $mail . '"';
        return $pdo->prepare($query)->execute();
    }

    public function remUser($mail) {

        $pdo = $this->connectdb();
        $query = 'UPDATE person SET `valid` = 0 WHERE  `e-mail` = "' . $mail . '"';
        return $pdo->prepare($query)->execute();
    }

    public function getCakeConf() {

        $pdo = $this->connectdb();
        $data = array();
        $data['Kuchenteig'] = $pdo->query('SELECT a.mass_id, a.mass_description, b.amount, c.price
                FROM mass a
                JOIN mass_has_ingredient b on a.mass_id = b.fk_mass_id
                JOIN ingredient c on b.fk_ingredient_id = c.ingredient_id
                
                ')->fetchAll(PDO::FETCH_ASSOC);
        $persid = 0;
        $user = JFactory::getUser();        // Get the user object
        $app = JFactory::getApplication();
        $username = $user->username;
        if (strlen($username) > 0) {
            $userdat = $this->getSpecUser($username);
            $persid = $userdat[0]['person_id'];
        }
        $data['Form'] = $pdo->query('SELECT * FROM shape')->fetchAll(PDO::FETCH_ASSOC);
        $data['Füllung'] = $pdo->query('SELECT a.ingredient_id, a.description, a.price FROM ingredient a
                                     LEFT JOIN ingredient_type b on a.fk_ingredient_type_id = b.ingredient_type_id
                                     WHERE b.description = "Kuchenfüllung"')->fetchAll(PDO::FETCH_ASSOC);
        $data['Dekoration'] = $pdo->query('SELECT a.ingredient_id, a.description, a.price FROM ingredient a
                                     LEFT JOIN ingredient_type b on a.fk_ingredient_type_id = b.ingredient_type_id
                                     WHERE b.description = "Kuchendekoration"')->fetchAll(PDO::FETCH_ASSOC);
        $data['Verpackung'] = $pdo->query('SELECT a.article_id, a.description, a.details, a.price, a.person_id FROM article a
                                     LEFT JOIN article_type b using(article_type_id)
                                     WHERE b.description = "Verpackung"
                                     UNION
                                     SELECT a.article_id, a.description, a.details, a.price, a.person_id FROM article a
                                     LEFT JOIN article_type b using(article_type_id)
                                     WHERE b.description = "Kundenverpackung" AND a.person_id = "' . $persid . '"
                                       ')->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getCakeMassDesc($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT `mass_description` FROM `mass` WHERE mass_id = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getConfigDetailsDesc($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT `description` FROM `ingredient` WHERE `ingredient_id` ="' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCakeWrapping($name) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT a.ingredient_id, a.description, a.price, b.description as descri FROM ingredient a
                LEFT JOIN ingredient_type b on a.fk_ingredient_type_id = b.ingredient_type_id
                WHERE b.description = "' . $name . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCakeIngredient() {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT a.ingredient_id, a.description, a.price, a.ing_available, a.unit FROM ingredient a
                            JOIN ingredient_type b on a.fk_ingredient_type_id = b.ingredient_type_id
                            WHERE ing_available = 1 AND b.description = "Kuchenzutat"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getUnit($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM ingredient WHERE ingredient_id = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getArticlesRating($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM rating WHERE article_id = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getFormDetail($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT * FROM shape WHERE shape_id = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCakeInPackage($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT article_id FROM `package`join`package_has_articles` USING (package_id) WHERE package_id ="' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getWrappingDesc($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT description FROM `article` WHERE article_id ="' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]['description'];
    }

    public function getRecipeDetails($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT amount, description, price, unit FROM `article_has_ingredient` JOIN ingredient USING (`ingredient_id`) WHERE `article_id` = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getPackagePrice($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT price FROM `package` WHERE package_id ="' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getPackageDescr($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT description FROM `package` WHERE package_id ="' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getArticlePrice($id) {
        $pdo = $this->connectdb();
        $data = $pdo->query('SELECT `price` FROM `article` WHERE `article_id` = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]['price'];
    }

    public function insertNewOrder($deliveryDate, $totalAmount, $personId, $voucherId, $cart, $configs, $packages) {
        $pdo = $this->connectdb();
        $guid = $this->GUID();
        $date = date("Y-m-d");
        $query = "INSERT INTO `order` (`order_id`, `order_date`, `delivery_date`, `total_amount`, `status`, `person_id`, `voucher_id`) "
                . "VALUES ('" . $guid . "', '" . $date . "', '" . $deliveryDate . "', '" . $totalAmount . "', 'open', '" . $personId . "', " . $voucherId . ")";
        $pdo->prepare($query)->execute();

        if ($packages != null) {
            foreach ($packages as $array) {
                for ($i = 0; $i < count($array); $i++) {
                    $sum = 0;
                    foreach ($array[$i] as $cake) {
                        $sum += $this->getArticlePrice($cake);
                    }
                    $package_guid = $this->GUID();
                    $query9 = "INSERT INTO `package`(`package_id`, `description`, `details`, `price`, `pack_active`, `creation`) "
                            . "VALUES ('" . $package_guid . "','Kundenkreation',NULL,'" . $sum . "',0,1)";
                    $pdo->prepare($query9)->execute();
                    foreach ($array[$i] as $cake) {
                        $query10 = "INSERT INTO `package_has_articles`(`package_id`, `article_id`) "
                                . "VALUES ('" . $package_guid . "', '" . $cake . "')";
                        $pdo->prepare($query10)->execute();
                    }
                }
            }
        }

        if ($cart != null) {
            foreach ($cart['items'] as $product) {
                if ($product['type'] == 'cake' || $product['type'] == 'recipe') {
                    $query2 = "INSERT INTO `order_has_articles` (`order_id`, `article_id`, `amount`, `wrapping`) "
                            . "VALUES ('" . $guid . "', '" . $product['id'] . "', '" . $product['quantity'] . "','" . $product['wrapping'] . "')";
                    $pdo->prepare($query2)->execute();
                }
                if ($product['type'] == 'package') {
                    $query3 = "INSERT INTO `order_has_package` (`fk_package_id`, `fk_order_id`, `amount`) "
                            . "VALUES ('" . $product['id'] . "', '" . $guid . "', '" . $product['quantity'] . "')";
                    $pdo->prepare($query3)->execute();
                }
            }
        }
        
        if ($configs != null) {
            foreach ($configs as $cakes) {
                foreach ($cakes as $config) {
                    $article_guid = $this->GUID();
                    $query4 = "INSERT INTO `article`(`article_id`, `description`, `details`, `price`, `creation`, `preperation_description`, `extras`, `person_id`, `visible`, `shape_id`, `article_type_id`, `timestamp`) "
                            . "VALUES ('" . $article_guid . "','Kundenkreation',NULL,'" . $config['Gesamtpreis'] . "',1,NULL,NULL,'" . $personId . "',0,'" . $config['Form'] . "','8f283061-5d38-11e8-9cbb-229588e6eae0','" . $date . "')";
                    $query5 = "INSERT INTO `article_has_mass`(`fk_mass_id`, `fk_article_id`) "
                            . "VALUES ('" . $config['Teigart'] . "','" . $article_guid . "')";
                    $query6 = "INSERT INTO `article_has_ingredient`(`article_id`, `ingredient_id`, `amount`) "
                            . "VALUES ('" . $article_guid . "','" . $config['Befuellung'] . "',1)";
                    $query7 = "INSERT INTO `article_has_ingredient`(`article_id`, `ingredient_id`, `amount`) "
                            . "VALUES ('" . $article_guid . "','" . $config['Dekoration'] . "',1)";
                    $query8 = "INSERT INTO `order_has_articles` (`order_id`, `article_id`, `amount`, `wrapping`) "
                            . "VALUES ('" . $guid . "', '" . $article_guid . "', 1,'" . $config['Verpackung'] . "')";
                    $pdo->prepare($query4)->execute();
                    $pdo->prepare($query5)->execute();
                    $pdo->prepare($query6)->execute();
                    $pdo->prepare($query7)->execute();
                    $pdo->prepare($query8)->execute();
                }
            }
        }

        return "success";
    }

    public function newWrapping($karton, $masche, $bild, $pfad, $username, $bez) {
        $pdo = $this->connectdb();
        $article_guid = $this->GUID();
        //Preis berechnen - Bild kostet immer 4€
        $maschepreis = $pdo->query('SELECT price FROM ingredient WHERE ingredient_id = "' . $masche . '"')->fetchAll(PDO::FETCH_ASSOC);
        $kartonpreis = $pdo->query('SELECT price FROM ingredient WHERE ingredient_id = "' . $karton . '"')->fetchAll(PDO::FETCH_ASSOC);
        $preis = $maschepreis[0]['price'] + $kartonpreis[0]['price'] + 4;
        //mal die id von article_typ holen
        $art_type = "Kundenverpackung";
        $article_type_id = $pdo->query('SELECT article_type_id FROM article_type WHERE description = "' . $art_type . '"')->fetchAll(PDO::FETCH_ASSOC);

        $person_id = $pdo->query('SELECT person_id FROM person WHERE `e-mail` = "' . $username . '"')->fetchAll(PDO::FETCH_ASSOC);

        //article erzeugen
        $query = 'INSERT INTO article (`article_id`, `description`, `details`, `price`, `creation`, `visible`, `article_type_id`, `person_id`) VALUES ("' . $article_guid . '","' . $bez . '","Kundenverpackung","' . $preis . '",1,1,"' . $article_type_id[0]['article_type_id'] . '", "' . $person_id[0]['person_id'] . '")';

        $pdo->prepare($query)->execute();

        //id von ingredient type für sticker holen
        $ing_type = "Sticker";
        $ing_type_id = $pdo->query('SELECT ingredient_type_id FROM ingredient_type WHERE description = "' . $ing_type . '"')->fetchAll(PDO::FETCH_ASSOC);
        //bild als neue ingredient hinzufügen
        $query = 'INSERT INTO ingredient (`ingredient_id`, `description`, `price`, `unit`, `path`, `fk_ingredient_type_id`) VALUES ("' . $bild . '","Kundensticker",4,"Stück","' . $pfad . '","' . $ing_type_id[0]['ingredient_type_id'] . '")';
        $pdo->prepare($query)->execute();
        //article_has_ingredient
        $query = 'INSERT INTO article_has_ingredient (`ingredient_id`, `article_id`, `amount`) VALUES ("' . $karton . '","' . $article_guid . '",1)';
        $pdo->prepare($query)->execute();
        $query = 'INSERT INTO article_has_ingredient (`ingredient_id`, `article_id`, `amount`) VALUES ("' . $masche . '","' . $article_guid . '",1)';
        $pdo->prepare($query)->execute();
        $query = 'INSERT INTO article_has_ingredient (`ingredient_id`, `article_id`, `amount`) VALUES ("' . $bild . '","' . $article_guid . '",1)';
        $pdo->prepare($query)->execute();
        return "succccc";
        //return $pdo ->prepare($query)->execute();
    }

    public function newRecipe($data, $guid) {

        $pdo = $this->connectdb();
        $article_guid = $guid;

        $user = JFactory::getUser();        // Get the user object
        $app = JFactory::getApplication(); // Get the application
        $username = "";
        if ($user->id != 0) {
            $username = $user->username;
        } else {
            return "not logged in";
        }

        //mal die id von article_typ holen
        $art_type = "Kundenrezept";
        $article_type_id = $pdo->query('SELECT article_type_id FROM article_type WHERE description = "' . $art_type . '"')->fetchAll(PDO::FETCH_ASSOC);
        $person_id = $pdo->query('SELECT person_id FROM person WHERE `e-mail` = "' . $username . '"')->fetchAll(PDO::FETCH_ASSOC);

        $bez = $data[1]['bez'];
        $gprice = $data[1]['gprice'];
        $anm = $data[1]['anm'];
        $zub = $data[1]['zub'];


        $query = 'INSERT INTO article (`article_id`, `description`, `details`, `price`, `preperation_description`, `extras`, `creation`, `visible`, `article_type_id`, `person_id`) VALUES ("' . $article_guid . '","' . $bez . '","Kundenrezept","' . $gprice . '","' . $zub . '","' . $anm . '",1,1,"' . $article_type_id[0]['article_type_id'] . '", "' . $person_id[0]['person_id'] . '")';
        $pdo->prepare($query)->execute();

        $anz = count($data);

        for ($i = 1; $i < $anz; $i++) {
            //alle zutaten in article_has_ingredient
            $ingid = $data[$i]['id'];
            $amount = $data[$i]['amount'];
            $query = 'INSERT INTO article_has_ingredient (`article_id`, `ingredient_id`, `amount`) VALUES ("' . $article_guid . '","' . $ingid . '","' . $amount . '")';
            $pdo->prepare($query)->execute();
        }


        return $article_guid;
    }

    public function getCustomerWrappings($username) {
        $pdo = $this->connectdb();
        //get "Kundenverpackungsid"
        $art_type = "Kundenverpackung";
        $article_type_id = $pdo->query('SELECT article_type_id FROM article_type WHERE description = "' . $art_type . '"')->fetchAll(PDO::FETCH_ASSOC);

        //get customer id
        $customer_id = $pdo->query('SELECT person_id FROM person WHERE `e-mail` = "' . $username . '"')->fetchAll(PDO::FETCH_ASSOC);

        //jetzt alle Kundenverpackungen entsprechend §id

        $data = $pdo->query('SELECT a.article_id, a.description, a.details, a.price, c.description as ing_desc, c.price as ing_price, c.path, d.description as ing_type_desc FROM article a 
                LEFT JOIN article_has_ingredient b on a.article_id = b.article_id
                LEFT JOIN ingredient c on b.ingredient_id = c.ingredient_id 
                LEFT JOIN ingredient_type d on c.fk_ingredient_type_id = d.ingredient_type_id
                WHERE article_type_id ="' . $article_type_id[0]['article_type_id'] . '" AND person_id = "' . $customer_id[0]['person_id'] . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getWrappings() {
        $pdo = $this->connectdb();
        //get "Verpackungsid"
        $art_type = "Verpackung";
        $article_type_id = $pdo->query('SELECT article_type_id FROM article_type WHERE description = "' . $art_type . '"')->fetchAll(PDO::FETCH_ASSOC);

        //jetzt alle Verpackungen entsprechend §id

        $data = $pdo->query('SELECT a.article_id, a.description, a.details, a.price, c.description as ing_desc, c.price as ing_price FROM article a 
                LEFT JOIN article_has_ingredient b on a.article_id = b.article_id
                LEFT JOIN ingredient c on b.ingredient_id = c.ingredient_id    
                WHERE article_type_id ="' . $article_type_id[0]['article_type_id'] . '"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCustomerOrders($username) {
        $pdo = $this->connectdb();

        //get customer id
        $customer_id = $pdo->query('SELECT person_id FROM person WHERE `e-mail` = "' . $username . '"')->fetchAll(PDO::FETCH_ASSOC);

        //jetzt alle Kundenverpackungen entsprechend §id

        $data = $pdo->query('SELECT * FROM `order` WHERE `person_id` = "' . $customer_id[0]['person_id'] . '" ORDER BY `order_date` DESC')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCustomerRecipes($username) {
        $pdo = $this->connectdb();

        //get customer id
        $customer_id = $pdo->query('SELECT person_id FROM person WHERE `e-mail` = "' . $username . '"')->fetchAll(PDO::FETCH_ASSOC);

        //jetzt alle Kundenverpackungen entsprechend §id

        $data = $pdo->query('SELECT * FROM `article` WHERE `person_id` = "' . $customer_id[0]['person_id'] . '" AND `details` = "Kundenrezept"')->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getOrderDetail($id) {
        $pdo = $this->connectdb();
        //fürs rating person id holen
        $customer_id = $pdo->query('SELECT person_id FROM `order` WHERE `order_id` = "' . $id . '"')->fetchAll(PDO::FETCH_ASSOC);


        $data = $pdo->query('SELECT b.article_id, b.description, b.details, a.amount, a.wrapping, b.price, a.order_id, c.person_id, c.stars, c.comment, c.visible  FROM `order_has_articles` a
            LEFT JOIN article b using(article_id)
            LEFT JOIN rating c using(article_id)
            WHERE order_id = "' . $id . '" 
                ')->fetchAll(PDO::FETCH_ASSOC);
        //wrapping hinzufügem
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['wrapname'] = "";
            if (strlen($data[$i]['wrapping']) > 8) {

                $data2 = $pdo->query('SELECT description FROM `article` 
            WHERE article_id = "' . $data[$i]['wrapping'] . '"
                ')->fetchAll(PDO::FETCH_ASSOC);


                $data[$i]['wrapname'] = $data2[0]['description'];
            }
        }

        return $data;
    }

    public function getRecipeDetail($id) {
        $pdo = $this->connectdb();

        $data = $pdo->query('SELECT b.description, b.price, a.amount, c.preperation_description, c.extras, b.unit FROM `article_has_ingredient` a
            LEFT JOIN ingredient b on a.ingredient_id = b.ingredient_id
            LEFT JOIN article c on a.article_id = c.article_id
            WHERE a.article_id = "' . $id . '"
                ')->fetchAll(PDO::FETCH_ASSOC);
        /* $data2 = array();
          for($i = 0; $i < count($data); $i++){

          $tmp = $pdo->query('SELECT * FROM `ingredient`
          WHERE ingredient_id = "' . $data[$i]['ingredient_id'] . '"
          ')->fetchAll(PDO::FETCH_ASSOC);

          array_push($data2, $tmp);

          } */

        return $data;
    }

    public function getRatingDetail($artid, $persid) {
        $pdo = $this->connectdb();

        $data = $pdo->query('SELECT * FROM rating
            WHERE article_id = "' . $artid . '" AND person_id = "' . $persid . '"
                ')->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
    
    public function doRating($artid, $stars, $comment, $persid) {
        $pdo = $this->connectdb();
//prüfen ob rating schon vorhanden
        
        $pruf = $pdo->query('SELECT stars FROM rating WHERE person_id = "' . $persid . '" AND article_id = "' . $artid . '"')->fetchAll(PDO::FETCH_ASSOC);
       
        if(count($pruf) == 0){
             $query = 'INSERT INTO rating (`article_id`, `person_id`, `stars`, `comment`, `visible`) VALUES ("' . $artid . '","' . $persid . '","' . $stars . '","' . $comment . '", 0)';
             $pdo->prepare($query)->execute();
        /******************************************************************/
          $cols = array(); $vals = array(); $pknames = array(); $pkvals = array();
          array_push($pknames, "article_id", "person_id");
          array_push($pkvals, $artid, $persid);
          array_push($cols, "stars", "comment", "visible");
          array_push($vals, $stars, $comment, "0");
          $erg = $this->makeSync("INSERT", "rating", $pknames, $pkvals, $cols, $vals);
          return $erg;
        /******************************************************************/
        }else{
            $query = 'UPDATE rating SET `stars` = "' . $stars . '", `comment` = "' . $comment . '" WHERE person_id = "' . $persid . '" AND article_id = "' . $artid . '"';
            $pdo->prepare($query)->execute();
        /******************************************************************/
          $cols = array(); $vals = array(); $pknames = array(); $pkvals = array();
          array_push($pknames, "article_id", "person_id");
          array_push($pkvals, $artid, $persid);
          array_push($cols, "stars", "comment", "visible");
          array_push($vals, $stars, $comment, "0");
          $erg = $this->makeSync("UPDATE", "rating", $pknames, $pkvals, $cols, $vals);
          return $erg;
        /******************************************************************/
        }
        
        
        
        
        
        return $comment;
    }

}

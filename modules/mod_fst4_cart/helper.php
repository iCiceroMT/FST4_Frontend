<?php

/**
 * @package         Fst4-Cart.Module
 * @subpackage      mod_fst4_cart
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;

include_once './modules/fst4_db/db_connection.php';

abstract class modFst4CartHelper {

    public static function getCart() {
        $session = JFactory::getSession();
        $cart = $session->get('cart');
        return $cart;
    }

    public static function getPackages() {
        $session = JFactory::getSession();
        $package = $session->get('package');
        return $package;
    }

    public static function getConfig() {
        $session = JFactory::getSession();
        $config = $session->get('cakeconfig');
        return $config;
    }

    public static function connectToDb() {
        $db = new database();
        return $db;
    }

    public static function getUser() {
        $user = JFactory::getUser();
        if ($user->username != NULL) {
            $email = $user->get('email');
            $db = new database();
            $data = $db->getSpecUser($email);
            return $data;
        }
        $user = 0;
        return $user;
    }

    public static function addToCartAjax() {

        $session = JFactory::getSession();
        $cart = $session->get('cart');
        if ($cart == NULL) {
            $cart = array();
            $cart['items'] = array();
        }
        $control = 0;

        if (count($cart['items']) > 0) {
            foreach ($cart['items'] as &$product) {
                if ($product['id'] == $_POST['id'] && $product['wrapping'] == $_POST['wrapping']) {
                    $product['quantity'] += $_POST['amount'];
                    $control = 1;
                    break;
                }
            }unset($product);
        }

        if ($control == 0) {
            $product = array('id' => $_POST['id'], 'type' => $_POST['type'], 'quantity' => $_POST['amount'], 'wrapping' => $_POST['wrapping']);
            array_push($cart['items'], $product);
        }

        $session->set('cart', $cart);
        return "success";
    }

    public static function removeFromCartAjax() {
        $session = JFactory::getSession();
        $id = $_POST['id'];
        $cart = modFst4CartHelper::getCart();
        $i = 0;
        foreach ($cart['items'] as $product) {
            if ($product['id'] == $id) {
                $i = array_search($product, $cart['items']);
                unset($cart['items'][$i]);
            }
        }
        $session->set('cart', $cart);
        return $cart['items'];
    }

    public static function removeCakeConfigFromCartAjax() {
        $session = JFactory::getSession();
        $config = modFst4CartHelper::getConfig();
        $id = $_POST['id'];
        unset($config['items'][$id]);

        if (count($config['items']) == 0) {
            unset($config['items']);
        }

        $session->set('cakeconfig', $config);
        return $config;
    }

    public static function removePackageFromCartAjax() {
        $session = JFactory::getSession();
        $packageconfig = modFst4CartHelper::getPackages();
        $id = $_POST['id'];
        unset($packageconfig['cakes'][$id]);

        if (count($packageconfig['cakes']) == 0) {
            unset($packageconfig['cakes']);
        }

        $session->set('package', $packageconfig);
        return $packageconfig;
    }

    public static function changeAmountAjax() {
        $session = JFactory::getSession();
        $id = $_POST['id'];
        $amount = $_POST['amount'];
        $cart = modFst4CartHelper::getCart();
        $i = 0;
        foreach ($cart['items'] as &$product) {
            if ($product['id'] == $id) {
                $product['quantity'] += (int) $amount;
                if ($product['quantity'] <= 0) {
                    $i = array_search($product, $cart['items']);
                    unset($cart['items'][$i]);
                }
                break;
            }
        }
        unset($product);
        $session->set('cart', $cart);
        return "success";
    }

    public static function checkoutAjax() {
        $deliveryDate = $_POST['deliveryDate'];
        $totalAmount = $_POST['totalAmount'];
        $voucherId = $_POST['voucherId'];
        if ($voucherId == "") {
            $voucherId = "null";
        }
        $person = modFst4CartHelper::getUser();
        $personId = $person[0]['person_id'];
        $cart = modFst4CartHelper::getCart();
        $configs = modFst4CartHelper::getConfig();
        $packages = modFst4CartHelper::getPackages();
        //TO DO DB
        $db = new database();
        if ($cart != null) {
            foreach ($cart['items'] as $product) {
                if (strpos($product['type'], "voucher") !== false) {
                    modFst4CartHelper::createNewVoucher($product['id']);
                }
            }
        }
        $response = $db->insertNewOrder($deliveryDate, $totalAmount, $personId, $voucherId, $cart, $configs, $packages);
        //TO DO E-MAIL
        return $response;
    }

    public static function createNewVoucher($value) {
        $dbclass = new database();
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double) microtime() * 1000000);
        $i = 0;
        $pass = '';


        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        //echo "<script> console.log( ".$code." ); </script>";
        $date = date("Y-m-d");
        //echo "<script> console.log( 'Code: " . $code . " Date: ".$date."' ); </script>";
        return $dbclass->insertNewVoucher($value, $pass, $date);
    }

    public static function getVoucherValueAjax() {
        $code = $_POST['voucherCode'];
        $db = new database();
        $value = $db->getVoucherValue($code);
        return $value[0];
    }

    public static function getDesc($id) {
        $array = array();
        $db = new database();
        $details = $db->getArticleDetail($id);
        foreach ($details as $data) {
            return $data['description'];
        }
    }

    public static function getPic($id) {
        if (strpos($id, "voucher") !== false) {
            return "../images/artikelbilder/voucher/" . $id . ".jpg";
        } else {
            return "../images/artikelbilder/artikel/" . $id . ".jpg";
        }
    }

    public static function getPrice($id) {
        $db = new database();
        $det = $db->getArticleDetail($id);
        foreach ($det as $prod) {
            return $prod['price'];
        }
    }

    public static function getForm($id) {
        $db = new database();
        $det = $db->getFormDetail($id);
        foreach ($det as $form) {
            return $form['description'];
        }
    }

    public static function getWrapping($id) {
        $db = new database();
        $det = $db->getWrappingDesc($id);
        return $det;
    }

    public static function getRecipeDetails($id) {
        $db = new database();
        $det = $db->getRecipeDetails($id);
        return $det;
    }

    public static function getAmount() {
        $cart = modFst4CartHelper::getCart();
        $summAmount = 0;
        $config = modFst4CartHelper::getConfig();
        $packages = modFst4CartHelper::getPackages();
        if ($cart != null) {
            foreach ($cart['items'] as $product) {
                $summAmount += $product['quantity'];
            }
        }if ($packages != null) {
            foreach ($packages as $package) {
                $summAmount++;
            }
        }if ($config != null) {
            foreach ($config['items'] as $cake) {
                $summAmount++;
            }
        }
        return $summAmount;
    }

    public static function getSum() {
        $summ = 0;

       
        $summ += modFst4CartHelper::getCakeSum();
        $summ += modFst4CartHelper::getPackageSum();
        $summ += modFst4CartHelper::getVoucherSum();
        $summ += modFst4CartHelper::getConfigSum();
        $summ += modFst4CartHelper::getPackageConfigSum();
        $summ += modFst4CartHelper::getRecipeSum();

        return $summ;
    }

    public static function getCakeSum() {
        $cart = modFst4CartHelper::getCart();
        $db = new database();
        $summ = 0;
        if ($cart != null) {
            foreach ($cart['items'] as $product) {
                if ($product['type'] == "cake") {
                    $det = $db->getArticleDetail($product['id']);
                    $summ += $det[0]['price'] * $product['quantity'];
                }
            }
        }
        return $summ;
    }

    public static function getRecipeSum() {
        $cart = modFst4CartHelper::getCart();
        $db = new database();
        $summ = 0;
        if ($cart != null) {
            foreach ($cart['items'] as $product) {
                if ($product['type'] == "recipe") {
                    $summ += modFst4CartHelper::getPrice('0200A5B0-55D8-4581-9A99-9DE542609F78') * (int) $product['quantity'];
                }
            }
        }
        return $summ;
    }

    public static function getPackageSum() {
        $cart = modFst4CartHelper::getCart();
        $db = new database();
        $summ = 0;
        if ($cart != null) {
            foreach ($cart['items'] as $product) {
                if ($product['type'] == "package") {
                    $summ += modFst4CartHelper::getPackagePrice($product['id']) * $product['quantity'];
                }
            }
        }
        return $summ;
    }

    public static function getVoucherSum() {
        $cart = modFst4CartHelper::getCart();
        $db = new database();
        $summ = 0;

        if ($cart != null) {
            foreach ($cart['items'] as $product) {
                if (strpos($product['type'], "voucher") !== false) {
                    $summ += $product['id'] * $product['quantity'];
                }
            }
        }
        return $summ;
    }

    public static function getConfigSum() {
        $summ = 0;
        $config = modFst4CartHelper::getConfig();
        if ($config != null) {
            foreach ($config as $array) {
                foreach ($array as $item) {
                    $summ += $item['Gesamtpreis'];
                }
            }
        }
        return $summ;
    }

    public static function getPackageConfigSum() {
        $summ = 0;
        $packages = modFst4CartHelper::getPackages();
        if ($packages != null) {
            foreach ($packages as $array) {
                for ($i = 0; $i < count($array); $i++) {
                    foreach ($array[$i] as $cake) {
                        $summ += modFst4CartHelper::getPrice($cake) * 0.85;
                    }
                }
            }
        }
        return $summ;
    }

    public static function getPackageDesc($id) {
        $db = new database();
        $desc = $db->getPackageDescr($id);
        return $desc[0]['description'];
    }

    public static function getPackagePic($id) {
        return "../images/artikelbilder/package/" . $id . ".jpg";
    }

    public static function getPackagePrice($id) {
        $db = new database();
        $price = $db->getPackagePrice($id);
        return $price[0]['price'];
    }

    public static function getDoughDes($id) {
        $db = new database();
        $desc = $db->getCakeMassDesc($id);
        return $desc[0]['mass_description'];
    }

    public static function getConfigDetailDesc($id) {
        $db = new database();
        $desc = $db->getConfigDetailsDesc($id);
        return $desc[0]['description'];
    }

    /* public static function getItems(&$params)
      {
      // init db
      // ===========================================================================
      $db     = JFactory::getDbo();
      $q      = $db->getQuery(true) ;


      // get Joomla! API
      // ===========================================================================
      $app     = JFactory::getApplication() ;
      $user    = JFactory::getUser() ;
      $date    = JFactory::getDate( 'now' , JFactory::getConfig()->get('offset') ) ;
      $uri     = JFactory::getURI() ;
      $doc     = JFactory::getDocument();



      // get Params and prepare data.
      // ===========================================================================
      $catid         = $params->get('catid', 1) ;
      $order         = $params->get('orderby', 'a.created') ;
      $dir           = $params->get('order_dir', 'DESC') ;



      // Category
      // =====================================================================================
      // if Choose all category, select ROOT category.
      if(!in_array(1, $catid)) {
      // if is array, implode it.
      if(is_array($catid)) $catid = implode(',', $catid) ;

      $q->where("a.catid IN ({$catid})") ;
      }



      // Published
      // =====================================================================================
      $q->where('a.published > 0') ;

      $nullDate = $db->Quote($db->getNullDate());
      $nowDate = $db->Quote($date->toSql(true));

      $q->where('(a.publish_up   = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
      $q->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');



      // View Level
      // =====================================================================================
      $groups    = implode(',', $user->getAuthorisedViewLevels());
      $q->where('a.access IN ('.$groups.')');



      // Language
      // =====================================================================================
      if ($app->getLanguageFilter()) {
      $lang_code = $db->quote( JFactory::getLanguage()->getTag() ) ;
      $q->where("a.language IN ('{$lang_code}', '*')");
      }



      // Load Data
      // ===========================================================================
      $items = array() ;

      $q->select("a.*, b.*")
      ->from('#__example_items AS a')
      ->join('LEFT', '#__categories AS b ON a.catid = b.id')
      //->where("")
      ->order("{$order} {$dir}")
      ;

      $db->setQuery($q);
      $items = $db->loadObjectList();



      // Handle Data
      // ===========================================================================
      if( $items ):

      foreach( $items as $key => &$item ):
      $item->link = JRoute::_("index.php?option=com_example&view=item&id={$item->id}&alias={$item->alias}&catid={$item->catid}") ;
      endforeach;

      else:

      $items = range(1, 5) ;
      foreach( $items as $key => &$item ):

      $item = new JObject();
      $item->a_title   = 'Example data - ' . ( $key +1 );
      $item->link      = '#' ;
      $item->a_created = $date->toSQL(true) ;

      endforeach;

      endif ;


      return $items ;
      } */
}

<?php

/**
 * @package         User Administration.Module
 * @subpackage      mod_fst4_useradm
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;

include_once './modules/fst4_db/db_connection.php';

abstract class modFst4UserAdmHelper {

    public static function getUserDetails($email){
         $dbclass = new database();
        return $dbclass->getSpecUser($email);
    }
    
    public static function changeUserData($data){
         $dbclass = new database();
        return $dbclass->changeUserData($data);

    }
    public static function changeUserJoomla($mail, $mail_orig){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $fields = array(
                $db->quoteName('username') . ' = "' . $mail . '"',
                $db->quoteName('email') . ' = "' . $mail . '"'
            );
            $conditions = array(
                $db->quoteName('email') . ' = "' . $mail_orig . '"'
            );

            $query->update($db->quoteName('#__users'))->set($fields)->where($conditions);

            $db->setQuery($query);

            return $result = $db->execute();

    }
    
    public static function checkUserPw($pw){
        $dbclass = new database();
        return $dbclass->checkUserPw($pw);
        
    }
    
    public static function remUser($mail){
        jimport('joomla.user.helper');
        $val = 1;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('#__users'))
              ->set($db->quoteName('block') . ' = ' . $db->quote($val))
              ->where($db->quoteName('email') . ' = ' . $db->quote($mail));
        $db->setQuery($query);
        $result = $db->execute();
        //log out user
        $app = JFactory::getApplication();              
        $user = JFactory::getUser();
        $user_id = $user->get('id');            
        $app->logout($user_id, array());
        //execute DB Func
        $dbclass = new database();
        return $dbclass->remUser($mail);
        
    }
    public static function newUserPw($pw, $mail){
        //zuerst für joomla
        jimport('joomla.user.helper');
        $password = $pw;
        $hash = JUserHelper::hashPassword($password);
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update($db->quoteName('#__users'))
              ->set($db->quoteName('password') . ' = ' . $db->quote($hash))
              ->where($db->quoteName('email') . ' = ' . $db->quote($mail));

        $db->setQuery($query);
        //jetzt die hauptdb
        $result = $db->execute();
        $dbclass = new database();
        return $dbclass->newUserPw($pw, $mail);
        
    }
    
    public static function getCustomerOrders($username){
        $dbclass = new database();
        return $dbclass->getCustomerOrders($username);
        
    }
    public static function getCustomerWrappings($username){
        $dbclass = new database();
        return $dbclass->getCustomerWrappings($username);
        
    }
    public static function getCustomerRecipes($username){
        $dbclass = new database();
        return $dbclass->getCustomerRecipes($username);
        
    }
    
    public static function getOrderDetailAjax(){
        $dbclass = new database();
        $data = $_POST['id'];
        return $dbclass->getOrderDetail($data);
        
    }
    
    public static function getRecipeDetailAjax(){
        $dbclass = new database();
        $data = $_POST['id'];
        return $dbclass->getRecipeDetail($data);
        
    }
    
    public static function getRatingDetailAjax(){
        $dbclass = new database();
        $artid = $_POST['artid'];
        $persid = $_POST['persid'];

        return $dbclass->getRatingDetail($artid, $persid);
        
    }
    
    public static function doRatingAjax(){
        $dbclass = new database();
        $artid = $_POST['artid'];
        $stars = $_POST['stars'];
        $comment = $_POST['comment'];
        $persid = $_POST['persid'];
      
        return $dbclass->doRating($artid, $stars, $comment, $persid);
        
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

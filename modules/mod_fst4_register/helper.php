<?php

/**
 * @package         Fst4-Login.Module
 * @subpackage      mod_fst4_login
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;

include_once './modules/fst4_db/db_connection.php';
//include_once './handleUser.php';

abstract class modFst4RegisterHelper {

    public static function regUser($data){
        if($data['pw1'] != $data['pw2']){
            return "Registrierung fehlgeschlagen! Ihre Passwörter müssen ident sein!";
        }
        foreach ($data as $item){
            if($item == ''){
                return "Registrierung fehlgeschlagen! Bitte füllen Sie alle Felder aus!";
            }
        }
        //check if email is already registered
        //$check_mail = 
        //joomla reg
        $name = $data['vorname'] . ' ' . $data['nachname'];
        $udata = array(
            'name'=>$name,
            'username'=>$data['mail'],
            'password'=>$data['pw1'],
            'email'=>$data['mail'],
            'groups'=>array(2), 
            );
        $user = new JUser;

            try{
                $user->bind($udata);         
                $user->save();
               // $app->login( array('username'=>$params['username'],'password'=>$params['password']) ) ;

            } catch (Exception $ex) {

                return 'Exception: ' .  $e->getMessage();
            }
        //db registrierung
           
        $dbclass = new database();
        return $dbclass->regNewUser($data);
    
       return "Sie wurden erfolgreich registriert!";
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

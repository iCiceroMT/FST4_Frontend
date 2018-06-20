<?php

/**
 * @package         Fst4-Product.Module
 * @subpackage      mod_fst4_product
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;

include_once './modules/fst4_db/db_connection.php';

abstract class modFst4PackageHelper {

    public static function getPackagesAjax() {
        $dbclass = new database();
        return $dbclass->getAllPackage();
    }

    public static function getPackageDetailAjax() {
        $data = array();
        $cakeDesc = array();
        $id = $_POST['id'];
        $dbclass = new database();
        $details = $dbclass->getPackageDetail($id);
        $cakes = $dbclass->getCakeInPackage($details[0]['package_id']);

        foreach ($cakes as $cake) {
            foreach ($cake as $cake_id) {
                $desc = modFst4PackageHelper::getDesc($cake_id);
                array_push($cakeDesc, $desc);
            }
        }
        array_push($data, $details);
        array_push($data, $cakeDesc);
        return ($data);
    }

    public static function getCakes() {
        $db = new database();
        return $db->getAllArticleWithType('Kuchen');
    }

    public static function getDesc($id) {
        $array = array();
        $db = new database();
        $details = $db->getArticleDetail($id);
        foreach ($details as $data) {
            return $data['description'];
        }
    }

    public static function addToCartAjax() {
        $data = $_POST['data'];
        $session = JFactory::getSession();
        $package = $session->get('package');

        if ($package == NULL) {
            $package = array();
            $package['cakes'] = array();
        }

        array_push($package['cakes'], $data);

        $session->set('package', $package);
        return "success";
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

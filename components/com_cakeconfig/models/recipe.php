<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_cakeconfig
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
include_once './modules/fst4_db/db_connection.php';
/**
 * CakeConfig Model
 *
 * @since  0.0.1
 */
class CakeConfigModelRecipe extends JModelItem
{
    public static function getCakeConf(){
        $dbclass = new database();
        return $dbclass->getCakeConf();
    }
    
    public static function getCakeIngredient(){
        $dbclass = new database();
        return $dbclass->getCakeIngredient();
    }
    
   
}
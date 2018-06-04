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
/**
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
include_once './modules/fst4_db/db_connection.php';
class CakeConfigController extends JControllerLegacy
{
       public function getUnit()
	{
        $x = $_POST['id'];
        $id = trim($x);
       
	$dbclass = new database();
        $data = $dbclass->getUnit($id);	
        echo json_encode($data);
	}
        
        public function toWK(){
            $data = $_POST['data'];
            $cakeconfig = array
                    (
                    array("Teigart",$data[0]),
                    array("Form",$data[1]),
                    array("Befuellung",$data[2]),
                    array("Dekoration",$data[3]),
                    array("Verpackung",$data[4]),
                    array("Abmessung",$data[5]),
                    array("Gesamtpreis",$data[6])
                    );
            //und jetzt in die session damit
            $session = JFactory::getSession();
            $session->set('cakeconfig', json_encode($cakeconfig));

        }
}
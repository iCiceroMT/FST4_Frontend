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

class CakeConfigController extends JControllerLegacy {

    public function getUnit() {
        $x = $_POST['id'];
        $id = trim($x);

        $dbclass = new database();
        $data = $dbclass->getUnit($id);
        echo json_encode($data);
    }

    public function toWK() {
        $session = JFactory::getSession();
        $cakeconfig = $session->get('cakeconfig');
        
        if($cakeconfig == null){
            $cakeconfig = array();
        }
        
        $data = $_POST['data'];

        $cakeconfig['items'][] = array
            (
            'Teigart' => $data[0],
            'Form' => $data[1],
            'Befuellung' => $data[2],
            'Dekoration' => $data[3],
            'Verpackung' => $data[4],
            'Gesamtpreis' => $data[5]);

        //und jetzt in die session damit
        $session = JFactory::getSession();
        $session->set('cakeconfig', $cakeconfig);
        
        //, json_encode($cakeconfig)
    }
    
    public function doWrapping() 
{
        $masche = $_POST['masche'];
        $karton = $_POST['karton'];
        $bez = $_POST['bez'];
        $bild = $_POST['bild'];
        $pfad = $_POST['pfad'];
        $username = $_POST['username'];
        
       $dbclass = new database();
       $data = $dbclass->newWrapping($karton, $masche, $bild, $pfad, $username, $bez);
        echo $data;
}

    public function recipeToWK() {

        $input = $_POST['data'];
        $guid = $_POST['guid'];

        /*$myArr = array($data[0], "Mary", "Peter", "Sally");
        $myJSON = json_encode($myArr);
        echo $myJSON;
*/
        $dbclass = new database();
        $res = $dbclass->newRecipe($input, $guid);
        $data = json_encode($res);
        echo $data;
        
       // $data = json_encode($input);
       // echo $data;

    }

}

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


$user = JFactory::getUser();        // Get the user object
$app  = JFactory::getApplication(); // Get the application

if ($user->id != 0)
{
    $username = $user->username;
}else{
    //echo "<div style=\"margin-top:50px;\"><h3>Melden Sie sich bitte an, um den Kuchenkonfigurator nutzen zu können</h3></div>";
    echo '<script> jQuery(function(){
      jQuery("#cakeconfig_user_msg").show();
      jQuery("#cakeconfig_verp_erst").removeClass("fp_btn_all");
      jQuery("#cakeconfig_rec_erst").removeClass("fp_btn_all");
      jQuery("#cakeconfig_verp_erst").addClass("btn_fp_btn_all_disabled");
      jQuery("#cakeconfig_rec_erst").addClass("btn_fp_btn_all_disabled");

   
}); </script>'; 
}



$data = CakeConfigModelCakeConfig::getCakeConf();
$teig = $data['Kuchenteig'];
$data2 = array();
$tmp = array();

for($i = 0; $i < count($teig); $i++){
    $tmp_des = $teig[$i]['mass_description'];
    $tmp_price = $teig[$i]['amount'];
    $tmp_amount = $teig[$i]['price'];  
    $tmp_id = $teig[$i]['mass_id'];  

   $pruef = false;
    foreach($data2 as $item){
        
        if($item['mass_description'] == $tmp_des){$pruef = true;}
        
    }

    if($pruef == false){$data2[$i]['mass_description'] = $tmp_des;$data2[$i]['price'] = $tmp_price * $tmp_amount; $data2[$i]['mass_id'] = $tmp_id;}
    else{

        for($b = 0; $b < count($data2); $b++){
            if($data2[$b]['mass_description'] == $tmp_des){$data2[$b]['price'] = $data2[$b]['price'] + ($tmp_price * $tmp_amount);}

        }
    }
    
}   

?>
<div id="main_cont" style="display:block;">
<div><h2>Kuchen Konfigurator</h2>
</div>
<div class="row">
  <div class="col-md-6">
                <form class="form-horizontal">
                <fieldset>

                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Teigart</label>
                  <div class="col-md-4">
                    <select id="cakecreation_select" name="selectbasic" class="form-control cakecreation_select selection_1">
                        <option value="0" price="0" selected>Bitte wählen...</option>
                       <?php
                       foreach($data2 as $item){
                           $price = $item['price'];
                           if($item['price'] == NULL || $item['price'] == 0){$price = 20;}
                       echo'
                       <option price="'.$price.'" value="'.$item['mass_id'].'">'
                       . $item['mass_description'] .
                       '</option>
                       ';
                       }
                       
                       ?>
                    </select>
                  </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Form</label>
                  <div class="col-md-4">
                    <select id="selectbasic" name="selectbasic" class="form-control cakecreation_select selection_2">
            <?php
                       foreach($data['Form'] as $item){
                       echo'
                       <option price="-" value="'.$item['shape_id'].'">'
                       . $item['description'] .
                       '</option>
                       ';
                       }
                       
                       ?>
                    </select>
                  </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Befüllung</label>
                  <div class="col-md-4">
                    <select id="selectbasic" name="selectbasic" class="form-control cakecreation_select selection_3">
                        <option price="0" value="none">Keine</option>
            <?php
                       foreach($data['Füllung'] as $item){
                       echo'
                       <option price="'.$item['price'].'" value="'.$item['ingredient_id'].'">'
                       . $item['description'] .
                       '</option>
                       ';
                       }
                       
                       ?>
                    </select>
                  </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Dekoration</label>
                  <div class="col-md-4">
                    <select id="selectbasic" name="selectbasic" class="form-control cakecreation_select selection_4">
                         <option price="0" value="none">Keine</option>
            <?php
                       foreach($data['Dekoration'] as $item){
                       echo'
                       <option price="'.$item['price'].'" value="'.$item['ingredient_id'].'">'
                       . $item['description'] .
                       '</option>
                       ';
                       }
                       
                       ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Verpackung</label>
                  <div class="col-md-4">
                    <select id="selectbasic" name="selectbasic" class="form-control cakecreation_select selection_5">
            <?php
                       foreach($data['Verpackung'] as $item){
                       echo'
                       <option price="'.$item['price'].'" value="'.$item['article_id'].'">'
                       . $item['description'] .
                       '</option>
                       ';
                       }
                       
                       ?>
                    </select>
                  </div>
                </div>
                </fieldset>
                </form>

    </div>
    <div class="col-md-6">
                                    <div id="cake_berechnung">
                          <div class="row">
                              <div class="col-md-4">
                                  <p>Teigart</p>
                                  <p>Form</p>
                                  <p>Befüllung</p>
                                  <p>Dekoration</p>
                                  <p>Verpackung</p>
                                  <p><strong>Gesamtpreis</strong></p>
                              </div>
                              <div class="col-md-4">
                                  <p id="p_cakecreation_1">-</p>
                                  <p id="p_cakecreation_2">-</p>
                                  <p id="p_cakecreation_3">-</p>
                                  <p id="p_cakecreation_4">-</p>
                                  <p id="p_cakecreation_5">-</p>
                                  <p id="p_cakecreation_6">-</p>
                                  
                              </div>
                              <div class="col-md-4">
                                  <p id="p_price_1">-</p>
                                  <p id="p_price_2">-</p>
                                  <p id="p_price_3">-</p>
                                  <p id="p_price_4">-</p>
                                  <p id="p_price_5">-</p>
                                  <p id="p_price_6">-</p>
                                  
                              </div>
                              
                                    <div id="kk_wk_btn">
                                        <div class="fp_btn_all">
                                                 <a  href="#" class="cakeconf_cake_btn">Zum Warenkorb hinzufügen</a> 
                                        </div>
                                    </div>
                          </div>
                      </div>
    
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        
    </div>

</div>


<div><h2>Weitere Funktionen</h2>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="fp_btn_all" id="cakeconfig_verp_erst">
            <a href="index.php?option=com_cakeconfig&view=wrapping">Eigene Verpackung erstellen</a>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="fp_btn_all" id="cakeconfig_rec_erst">
            <a class="link_recipe" href="index.php?option=com_cakeconfig&view=recipe">Eigenes Rezept erstellen</a>
        </div>
    </div>
</div>


</div>

<div id="cakeconfig_user_msg" style="margin:0px auto; text-align:center; color:grey; display:none;">
    <h4>Loggen Sie sich bitte ein, um eigene Verpackungen und Rezepte erstellen zu können</h4>
</div>
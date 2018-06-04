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
$data = CakeConfigModelCakeConfig::getCakeConf();

?>
<div id="main_cont">
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
                       foreach($data['Kuchen'] as $item){
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
                       <option price="'.$item['price'].'" value="'.$item['article_id'].'">'
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
        <form class="form-horizontal">
                <fieldset>

                <!-- Select Basic -->
                <div class="form-group">
                  <label class="col-md-4 control-label" for="selectbasic">Abmessung</label>
                  <div class="col-md-4">
                    <select id="selectbasic" name="selectbasic" class="form-control cakecreation_select selection_6">
                      <?php
                       foreach($data['Abmessung'] as $item){
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
</div>

<div class="row">
    <div class="col-md-6">
        <a class="link_recipe" href="index.php?option=com_cakeconfig&view=recipe">Eigenes Rezept erstellen</a>
    </div>

</div>


<div><h2>Verpackung</h2>
</div>
<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal">
                <fieldset>

                <!-- Select Basic -->
                <div class="form-group">
                  
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
        
        <a href="index.php?option=com_cakeconfig&view=wrapping">Eigene Verpackung erstellen</a>
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
                                  <p>Abmessung</p>
                                  <p><strong>Gesamtpreis</strong></p>
                              </div>
                              <div class="col-md-4">
                                  <p id="p_cakecreation_1">-</p>
                                  <p id="p_cakecreation_2">-</p>
                                  <p id="p_cakecreation_3">-</p>
                                  <p id="p_cakecreation_4">-</p>
                                  <p id="p_cakecreation_5">-</p>
                                  <p id="p_cakecreation_6">-</p>
                                  <p id="p_cakecreation_7"></p>
                              </div>
                              <div class="col-md-4">
                                  <p id="p_price_1">-</p>
                                  <p id="p_price_2">-</p>
                                  <p id="p_price_3">-</p>
                                  <p id="p_price_4">-</p>
                                  <p id="p_price_5">-</p>
                                  <p id="p_price_6">-</p>
                                  <p id="p_price_7">-</p>
                              </div>
                          </div>
                      </div>
    </div>
</div>

<div id="kk_wk_btn">
    <div class="fp_btn_all">
             <a  href="#" class="cakeconf_cake_btn">Zum Warenkorb hinzufügen</a> 
    </div>
</div>
</div>
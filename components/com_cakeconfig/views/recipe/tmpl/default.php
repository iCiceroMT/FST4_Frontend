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

$ing = CakeConfigModelRecipe::getCakeIngredient();
$wrap = CakeConfigModelRecipe::getWrapping();
$verp = $wrap[0];
$verp_cust = $wrap[1];
?>
<div id="main_cont">
<div><h2>Eigenes Rezept erstellen</h2></div>

                    <div class="row">
                        
                            <div class="col-md-12" style="float:left;">
                                <h4>Rezeptname</h4>
                                 <textarea id="rezept_bez" value="0" price="0" cols="20" rows="1"></textarea>
                           </div>
                             </div>
    <div id="recipe_ingredients" style="margin-top:50px;">
        <div class="row">
            <div class="col-md-4"><h4>Zutaten</h4></div>
            <div class="col-md-4">
                <div class="col-sm-6">
                    <h4>Menge</h4>
                </div>
                <div class="col-sm-6">
                    <h4>Einheit</h4>
                </div>
            </div>
            <div class="col-md-4"><h4>Preis</h4></div>
        </div>
            <form class="form-horizontal" id="recipe_form">
                <fieldset class="recipe_fieldset">


                    <div class="row">
                        <div class="col-md-4">
                            
                                <select id="select_ingredient" name="select_ingredient" class="form-control recipe_selectbox select_1">
                                    <option value="0" selected="selected">
                                        Bitte wählen...
                                        </option>
                                        <?php
                                            foreach($ing as $item){
                                                echo'
                                                    <option value=" ' . $item['ingredient_id'] . ' ">
                                                        ' . $item['description'] . '
                                                    </option>
                                                ';
                                            }
                                        ?>
                                  </select>
                        </div>
                        <div class="col-md-4">
                             
                            <div class="form-group">
                                <div class="col-sm-6">
                                 <input id="recipe_amount" name="recipe_amount" style="max-width:100px;" placeholder="0" class="form-control input-md amount_1" type="number" min="0">
                                </div>
                                <div class="col-sm-6">
                                    <div id="show_unit" class="unit_1">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                            <div id="show_price" class="price_1">-</div>
                        </div>
                    </div>
                </fieldset>
                
                        <!--<button id="recipe_addbtn" type="button" disabled>Add</button>-->
                        <div class="btn_fp_btn_all_disabled" style="text-align:center; width:200px; float:left; padding:10 20 10 20px; margin:0px;" id="recipe_btn_box">
                                                 <a id="recipe_addbtn"  class="">Hinzufügen</a> 
                                        </div>
                <fieldset >        
                <div class="row" style="margin-top:50px;">
                  
                    <div class="col-md-6" style="margin-top:50px;">
                        <h4>Zubereitung</h4>
                     
                              <textarea class="form-control" id="recipe_text_zub" name="textarea" placeholder="Auf was wir achten müssen..."></textarea>

                          </div>
                    
                    <div class="col-md-6" style="margin-top:50px;">
                        <h4>Sonderwünsche</h4>
                        <textarea class="form-control" id="sonderwunsch" name="textarea" placeholder="Haben Sie noch weitere Wünsche?"></textarea>
                    </div>
               
                </div>
                </fieldset>
                             <fieldset >        
                <div class="row" style="margin-top:50px;">
                  
                    <div class="col-md-6">
                        <h4>Gesamtkosten</h4>
                        <div id="fullcost" style="text-align:right;">
                            <div class="row">
                                <div class="col-md-6">Grundpreis</div>
                                <div class="col-md-6">30 €</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Zutaten</div>
                                <div class="col-md-6" id="gzutatpreis">0 €</div>
                            </div>
                            <div id="sonder" class="row" style="display:none;">
                                <div class="col-md-6">Sonderwünsche</div>
                                <div class="col-md-6" id="sonderpreis">0 €</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><strong>Gesamtsumme</strong></div>
                                <div class="col-md-6" id="gpreis">30 €</div>
                            </div>
                        </div>
                              

                          </div>
                    
                    <div class="col-md-6">
                                                            <div class="row">
                                         <div class="col-md-2"></div>
                                         <div class="col-md-5">
                                     <!--<div class="fp_btn_all"  style="padding-top:30px; min-width:250px;">
                                                 <a  class="cakeconf_recipe_btn">In den Warenkorb</a> 
                                        </div>-->
                                     <div class="fp_btn_all" style="margin-top:40px;"> 
                                                            <button type="button" class="btn_fp_btn_all cakeconf_recipe_btn" data-toggle="modal" data-target="#exampleModal">
                                                        In den Warenkorb
                                                      </button>
                                                      </div>
                                     
                                     
                                         </div>
                                         <div class="col-md-2"style="float:left;">
                                         <div class="fp_btn_back" style="padding-top:30px;">
                                                <a  href="http://wi-gate.technikum-wien.at:60336/index.php/kuchenkonfigurator" class="">Zurück</a> 
                                         </div> 
                                         </div>
                                         <div class="col-md-3"></div>
                                     </div>
                        
                        
                        
                        
                    </div>
               
                </div>
                </fieldset>           
                        
                        
            </form>
        

    </div>
</div>
    <!-- verstecktes fieldset zwecks vorlage -->
    
      <div class="row full_recipe_row" style="display:none;">
                        <div class="col-md-4">
                            
                                <select id="select_ingredient" name="select_ingredient" class="form-control recipe_selectbox select_x">
                                    <option value="0" selected="selected">
                                        Bitte wählen...
                                        </option>
                                        <?php
                                            foreach($ing as $item){
                                                echo'
                                                    <option value=" ' . $item['ingredient_id'] . ' ">
                                                        ' . $item['description'] . '
                                                    </option>
                                                ';
                                            }
                                        ?>
                                  </select>
                        </div>
                        <div class="col-md-4">
                             
                            <div class="form-group">
                                <div class="col-sm-6">
                                 <input id="recipe_amount" name="recipe_amount" placeholder="0" style="max-width:100px;" class="form-control input-md amount_x" type="number" min="0">
                                </div>
                                <div class="col-sm-6">
                                    <div id="show_unit" class="unit_x">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                            <div id="show_price" class="price_x">-</div>
                        </div>
                    </div>
    
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verpackung wählen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"  style="min-height:150px;">
          <p>Bitte wählen Sie eine Verpackung für Ihr Produkt.</p>
          
          <div class="form-group">
                <label class="col-md-4 control-label" for="selectpdetail">Verpackungen</label>
                <div class="col-md-4">
                  <select id="selectpdetail_verp" name="verpackung" class="form-control">
                     <option value="0" price="0" selected>Bitte wählen...</option>
                                     <?php
                                     $i = 0;
                                     
                                     foreach($verp as $item){
                                         if($i % 3 == 0 ){
                                          echo'
                                          <option  value="'.$item['article_id'].'">'
                                          . $item['description'] .
                                          '</option>
                                         ';}
                                          
                                          $i++;



                                     }
                                     $i = 0;
                                     foreach($verp_cust as $item){
                                          if($i % 3 == 0 ){
                                          echo'
                                          <option  value="'.$item['article_id'].'">'
                                          . $item['description'] .
                                          '</option>
                                          ';
                                          }
                                          $i++;


                                     }

                                     ?>
                  </select>
                </div>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="recipe" verp_id="" id="addToCartBtn" class="btn_fp_btn_all_disabled recipe_redirect" item_id="">In den Warenkorb</button>
      </div>
    </div>
  </div>
</div>
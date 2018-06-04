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

?>
<div id="main_cont">
<div><h2>Eigenes Rezept erstellen</h2></div>


    <div id="recipe_ingredients">
        <div class="row">
            <div class="col-md-4"><h4>Zutaten</h4></div>
            <div class="col-md-4"><h4>Menge</h4></div>
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
                                 <input id="recipe_amount" name="recipe_amount" placeholder="0" class="form-control input-md amount_1" type="number" min="0">
                                </div>
                                <div class="col-sm-6">
                                    <div id="show_unit" class="unit_1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                            <div id="show_price" class="price_1">-</div>
                        </div>
                    </div>
                </fieldset>
                
                        <button id="recipe_addbtn" type="button" disabled>Add</button>
                <fieldset >        
                <div class="row">
                  
                    <div class="col-md-6">
                        <h4>Zubereitung</h4>
                     
                              <textarea class="form-control" id="textarea" name="textarea" placeholder="Auf was wir achten müssen..."></textarea>

                          </div>
                    
                    <div class="col-md-6">
                        <h4>Anmerkungen</h4>
                        <textarea class="form-control" id="textarea" name="textarea" placeholder="Haben Sie noch weitere Wünsche?"></textarea>
                    </div>
               
                </div>
                </fieldset>
                             <fieldset >        
                <div class="row">
                  
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
                            <div class="row">
                                <div class="col-md-6"><strong>Gesamtsumme</strong></div>
                                <div class="col-md-6" id="gpreis">30 €</div>
                            </div>
                        </div>
                              

                          </div>
                    
                    <div class="col-md-6">
                        <button type="button">Bestellen</button>
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
                                 <input id="recipe_amount" name="recipe_amount" placeholder="0" class="form-control input-md amount_x" type="number" min="0">
                                </div>
                                <div class="col-sm-6">
                                    <div id="show_unit" class="unit_x"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                            <div id="show_price" class="price_x">-</div>
                        </div>
                    </div>
    
    
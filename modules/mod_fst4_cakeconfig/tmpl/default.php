<?php
/**
 * @package         Kuchenkonfigurator.Module
 * @subpackage      mod_fst4_cakeconfig
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;
$data = modFst4CakeConfigHelper::getCakeConf();

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
                    <select id="selectbasic" name="selectbasic" class="form-control">
                       <?php
                       foreach($data['Kuchen'] as $item){
                       echo'
                       <option value="'.$item['article_id'].'">'
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
                    <select id="selectbasic" name="selectbasic" class="form-control">
            <?php
                       foreach($data['Form'] as $item){
                       echo'
                       <option value="'.$item['shape_id'].'">'
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
                    <select id="selectbasic" name="selectbasic" class="form-control">
                        <option value="none">Keine</option>
            <?php
                       foreach($data['Füllung'] as $item){
                       echo'
                       <option value="'.$item['article_id'].'">'
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
                    <select id="selectbasic" name="selectbasic" class="form-control">
                         <option value="none">Keine</option>
            <?php
                       foreach($data['Dekoration'] as $item){
                       echo'
                       <option value="'.$item['article_id'].'">'
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
                    <select id="selectbasic" name="selectbasic" class="form-control">
                      <option value="1">Standard</option>
                      <option value="2">Klein</option>
                      <option value="2">Groß</option>
                    </select>
                  </div>
                </div>
                </fieldset>
        </form>
    
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <a class="link_recipe" href="#">Eigenes Rezept erstellen</a>
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
                    <select id="selectbasic" name="selectbasic" class="form-control">
            <?php
                       foreach($data['Verpackung'] as $item){
                       echo'
                       <option value="'.$item['article_id'].'">'
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
        
        <a href="#">Eigene Verpackung erstellen</a>
    </div>
    <div class="col-md-6">
        
    </div>
</div>

<div id="kk_wk_btn">
    <div class="fp_btn_all">
             <a href="">Zum Warenkorb hinzufügen</a>
    </div>
</div>
</div>
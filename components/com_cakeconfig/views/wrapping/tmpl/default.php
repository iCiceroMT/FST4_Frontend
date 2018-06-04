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

//$data = CakeConfigModelCakeConfig::getCakeConf();

?>
<div id="main_cont">
<div><h2>Verpackung erstellen</h2>
</div>
<div class="row">
    <div class="col-md-8">
    <form class="form-horizontal">
<fieldset>



<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Material</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Form</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="0">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Farbe</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="0" selected>Weiß</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Muster</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="0" selected>Kein Muster</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Sticker</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="0" selected>Kein Sticker</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Beschriftung</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="0" selected>Keine Beschriftung</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

</fieldset>
</form>
    
    
    </div>
    <div class="col-md-4"></div>
</div>
    <div id="wrap_btn">
        <button type="button">Verpackung erstellen</button>
    </div>
</div>
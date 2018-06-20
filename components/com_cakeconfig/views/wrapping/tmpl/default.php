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

$karton = CakeConfigModelWrapping::getCakeWrapping("Karton");
$masche = CakeConfigModelWrapping::getCakeWrapping("Masche");
$user = JFactory::getUser();        // Get the user object
$app  = JFactory::getApplication();
$username = $user->username;

if(JRequest::getVar('guid')){
$guid = JRequest::getVar('guid');
$ext = JRequest::getVar('ext');
$masche2 = JRequest::getVar('masche');
$karton2 = JRequest::getVar('karton');
$bez2 = JRequest::getVar('bez');
echo '<script> jQuery(function(){
      jQuery("#wrapping_pic_upload").hide();
    jQuery("#wrapping_pic").show();
      jQuery("#wrap_btn_dis").hide();
    jQuery("#wrap_btn").show();
    var optionValue = "' . $karton2  .'";
    var optionValue2 = "' . $masche2  .'";
       
    var kart = jQuery(\'#selectbasic_karton option[value="\'+optionValue+\'"]\').text();
    var masch = jQuery(\'#selectbasic_masche option[value="\'+optionValue2+\'"]\').text(); 
    
    jQuery("#selectbasic_karton").val("' . $karton2 . '");
        
    jQuery("#selectbasic_masche").val("' . $masche2 . '");
        
jQuery("#selectbasic_bez").val("' . $bez2 . '");

   
}); </script>'; 
}


?>
<div id="main_cont">
     <form class="form-horizontal" action="http://wi-gate.technikum-wien.at:60336/index.php/kuchenkonfigurator?view=wrapping" method="POST">
<div><h2>Verpackung erstellen</h2>
</div>
<div class="row">
     
    <div class="col-md-8">
  
<fieldset>

<div class="form-group">
    <label class="col-md-4 control-label" for="selectbasic">Verpackungsname</label>
  <div class="col-md-4">
        <textarea id="selectbasic_bez" value="0" price="0" cols="20" rows="1"></textarea>
  </div>
</div>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Karton</label>
  <div class="col-md-4">
    <select id="selectbasic_karton" name="karton" class="form-control">
       <option value="0" price="0" selected>Bitte wählen...</option>
                       <?php
                       foreach($karton as $item){
                    
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
  <label class="col-md-4 control-label" for="selectbasic">Masche</label>
  <div class="col-md-4">
    <select id="selectbasic_masche" name="masche" class="form-control">
<option value="0" price="0" selected>Bitte wählen...</option>
                       <?php
                       foreach($masche as $item){
                    
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
  <label class="col-md-4 control-label" for="selectbasic">Sticker</label>
  <div class="col-md-4">
      <div id="wrapping_pic_upload" style="display: block;">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                Bild hochladen...
                                </button>
      </div>
      <div id="wrapping_pic" style="display: none;">
          <img src="<?php if(JRequest::getVar('guid')){ echo JURI::root() . '/images/kundensticker/' . $guid .  $ext; } ?>" width="200">
      </div>
  </div>
</div>



</fieldset>
    
    
    </div>

    <div class="col-md-4"></div>
</div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3">
    <div class="fp_btn_all"  id="wrap_btn" style="float:right;    display:none;">
        
                                             
        <a id="wrapping_do_creation" >Verpackung erstellen</a>
    </div> 
        
        <div id="wrap_btn_dis" style="float:right; margin-top:15px; display:block;">
        
        <button type="button"  class="btn_fp_btn_all_disabled" disabled>Verpackung erstellen</button>
        </div>
        </div>
        <div class="col-md-2"style="float:left;">
        <div class="fp_btn_back">
               <a  href="http://wi-gate.technikum-wien.at:60336/index.php/kuchenkonfigurator" class="">Zurück</a> 
        </div> 
        </div>
        <div class="col-md-4"></div>
    </div>
                   </form>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bild hochladen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="<?php echo JRoute::_('../components/com_cakeconfig/post/post.php'); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-body">
          Hier können Sie ein Bild hochladen,</br> welches dann auf Ihre Verpackung gedruckt wird.
          
          <div class="container" style="width:500px;">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Upload Image</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse… <input type="file" id="imgInp" name="fileToUpload">
                                 
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <img id='img-upload'/>
                    </div>
                </div>
              <input type="hidden" id="wrapping_modal_karton" name="karton" value="0">
              <input type="hidden" id="wrapping_modal_masche" name="masche" value="0">
              <input type="hidden" id="wrapping_modal_bez" name="bez" value="0">
              <input type="hidden" id="guid_ready_pic" value="<?php if(JRequest::getVar('guid')){echo $guid;} ?>">
              <input type="hidden" id="pfad_ready_pic" value="<?php if(JRequest::getVar('guid')){echo $guid . $ext;} ?>">
              <input type="hidden" id="username_ready_pic" value="<?php if(JRequest::getVar('guid')){echo $username;} ?>">
                </div>
          
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" class="btn btn-info" value="Hochladen">
      </div>
        </form>
    </div>
  </div>
</div>
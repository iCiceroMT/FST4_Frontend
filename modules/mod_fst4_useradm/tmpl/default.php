<?php
/**
 * @package         User Administration.Module
 * @subpackage      mod_fst4_useradm
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;
$userToken = JSession::getFormToken();
$user = JFactory::getUser();
$userdata = modFst4UserAdmHelper::getUserDetails($user->email);
$url = JUri::getInstance();
$orders = modFst4UserAdmHelper::getCustomerOrders($userdata[0]['e-mail']); 
$verpackungen = modFst4UserAdmHelper::getCustomerWrappings($userdata[0]['e-mail']);
$rezepte = modFst4UserAdmHelper::getCustomerRecipes($userdata[0]['e-mail']);
$userid = $userdata[0]['person_id'];


if(ISSET($_POST['mail_user'])){
    $mail_del = $_POST['mail_user'];
    $url = JURI::root();
    modFst4UserAdmHelper::remUser($mail_del);
    
    header('Location: ' . $url);
}
if(ISSET($_POST['vorname'])){
        $data = array(
            "vorname" => $_POST['vorname'],
            "nachname" => $_POST['nachname'],
            "addresse" => $_POST['addresse'],
            "stadt" => $_POST['stadt'],
            "plz" => $_POST['plz'],
            "tel" => $_POST['tel'],
            "mail" => $_POST['mail'],
            "bdate" => $_POST['bdate'],
            "country" => $_POST['country'],
            "mail_orig" => $_POST['mail_orig']
            );
        //Daten in die Joomla DB
        $name = $_POST['vorname'] . ' ' . $_POST['nachname'];
        $mail = $_POST['mail'];
        $mail_orig = $_POST['mail_orig'];
       $user->set('name', $name);
       modFst4UserAdmHelper::changeUserJoomla($mail, $mail_orig);

       //Daten in die HauptDB
       $erg = modFst4UserAdmHelper::changeUserData($data);

       
}
if(ISSET($_POST['pw_old'])){
    $pw = $_POST['pw_old'];
    $msg = '';
   if(modFst4UserAdmHelper::checkUserPw($pw) != TRUE){
        $msg = "Fehler - Passwort nicht korrekt!";
        header('Location: ' . $url . '?msg=' . $msg);
    }else{
       $pw1 = $_POST['pw_new1'];
       $pw2 = $_POST['pw_new2'];
            if($pw1 == '' | $pw2 == '' | $pw1 != $pw2){
                $msg = "Fehler - Passwörter stimmen nicht überein oder zu kurz!";
                 header('Location: ' . $url . '?msg=' . $msg);
            }
            $mail = $user->email;
           modFst4UserAdmHelper::newUserPw($pw1, $mail);
           $msg = "Passwort erfolgreich geändert!";
             header('Location: ' . $url . '?msg=' . $msg);
    }
}

if(ISSET($_GET['msg'])){
    echo $_GET['msg'];
}

?>

    <h2 class="h2_useradmin">Account von <?php echo $user->name; ?></h2>
    
<ul class="nav nav-tabs fp_btn_all" id="zentriert">
  <li id="usadm_allg" role="presentation" class="active"><a href="#">Allgemein</a></li>
  <li id="usadm_persDat" role="presentation"><a href="#">Persönliche Daten</a></li>
  <li id="usadm_bestDat" role="presentation"><a href="#">Meine Bestellungen</a></li>
  <li id="usadm_verpDat" role="presentation"><a href="#">Meine Verpackungen</a></li>
  <li id="usadm_rezDat" role="presentation"><a href="#">Meine Rezepte</a></li>
</ul>
    
    <div id="usadm_allg_div" style="display:block;">
        <div style="margin-top:50px;" class="fp_btn_all">
         <a  href="index.php?option=com_users&task=user.logout&<?php echo $userToken;?>=1" role="button"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>Logout</a>
        </div>
    </div>  
    
 
    
    <div id="usadm_persDat_div" style="display:none;">
    <form class="form-horizontal"  method="post" action="#">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Vorname</label>
                            <input name="vorname" type="text" class="form-control" value="<?php echo $userdata[0]["firstname"]; ?>">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Nachname</label>
                            <input name="nachname" type="text" class="form-control" value="<?php echo $userdata[0]["lastname"]; ?>">
                        </div>
                    </div>					
                    <div class="form-group">
                        <label>Addresse</label>
                        <textarea name="addresse" rows="3" class="form-control"><?php echo $userdata[0]["street"]; ?></textarea>
                    </div>	
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label>Stadt</label>
                            <input name="stadt" type="text" class="form-control" value="<?php echo $userdata[0]["name"]; ?>">
                        </div>	
                        <div class="col-sm-4 form-group">
                            <label>Postleitzahl</label>
                            <input name="plz" type="text" class="form-control" value="<?php echo $userdata[0]["zip_code"]; ?>">
                        </div>		
                    </div>
                    <div class="row">
                    <div class="col-sm-4 form-group">
                        <label>Telefonnummer</label>
                        <input name="tel" type="text" class="form-control" value="<?php echo $userdata[0]["phone_number"]; ?>">
                    </div>	
                     <div class="col-sm-4 form-group">
                        <label>Geburtsdatum</label>
                        <input name="bdate" type="date" class="form-control" value="<?php echo $userdata[0]["birthdate"]; ?>">
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-4 form-group">
                        <label>Email-Addresse</label>
                        <input name="mail" type="text" class="form-control" value="<?php echo $userdata[0]["e-mail"]; ?>">
                    </div>
                      <div class="col-sm-4 form-group">
                        <label for="sel1">Land</label>
                        <select class="form-control" name="country" id="sel1">
                            <option selected="selected">
                                <?php echo $userdata[0]["country"]; ?>
                                </option>
                          <option>Österreich</option>
                          <option>Deutschland</option>
                          <option>Schweiz</option>
                        </select>
                      </div> 
                    </div>
                    <input type="hidden" name="mail_orig" value="<?php echo $userdata[0]["e-mail"];?>">
                  
</form>
        <div class="row">
          <button type="submit" class="btn_fp_btn_all">Änderungen speichern</button>
<button type="button" class="btn_fp_btn_all" data-toggle="modal" data-target="#pwModal">
    Passwort ändern
</button>
        <form method="POST" action="#">
            <input type="hidden" name="mail_user" value="<?php echo $user->email;  ?>">
            <button type="submit" class="btn_fp_btn_all delete" id="btnRemUserAccount">Account löschen</button>
        </form>
        </div>
</div>

</div>
    
            
        
        
<!-- Modal -->
<div class="modal fade" id="pwModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="PwdChange">Passwortänderung</h5>
        <!--<button type="button" class="close " data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
        <form class="form-horizontal"  method="post" action="#">
      <div class="modal-body">
        
        <div class="form-group">
            <label>Altes Passwort</label>
            <input name="pw_old" type="password" class="form-control">
        </div>
          
        <div class="form-group">
            <label>Neues Passwort</label>
            <input name="pw_new1" type="password" class="form-control">
        </div>
          
        <div class="form-group">
            <label>Neues Passwort wiederholen</label>
            <input name="pw_new2" type="password" class="form-control">
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn_fp_btn_all" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_fp_btn_all">Passwort ändern</button>
      </div>
        </form>
    </div>
  </div>
</div>

<div id="usadm_verp_div" style="display:none;">
        <div style="margin-top:50px;">
         
 <?php  
          if(count($orders) == 0){
              echo'
                  <p style="margin:0px auto;"><h3>Keine Bestellungen vorhanden!</h3></p>
              ';              
          }else{
              echo '
            <table class="table table-bordered table-striped">
                <tr>
                <th>Name</th>
                <th>Karton</th>
                <th>Masche</th>
                <th>Sticker</th>
                <th>Verpackung entfernen</th>
                </tr>
          ';
              //ACHTUNG: ich nehme an, dass die Verpackungen immer zusammengehörig (3x) im array vorkommen ... sollte man testen ... es ist spät
              $i = 0;
               $name = "";
               $karton = "";
               $masche = "";
               $sticker = "";
           foreach($verpackungen as $verpackung){
              
               $name = $verpackung['description'];
               if($verpackung['ing_type_desc'] == "Sticker"){$sticker = $verpackung['path'];}
               if($verpackung['ing_type_desc'] == "Masche"){$masche = $verpackung['ing_desc'];}
               if($verpackung['ing_type_desc'] == "Karton"){$karton = $verpackung['ing_desc'];}
               $i++;
               
               if($i == 3){
                   $i = 0;
                   
                     echo'
                    <tr>
                    <td>' . $name . '</td>
                    <td>' . $karton . '</td>
                    <td>' . $masche . '</td>
                    <td><img src="../images/kundensticker/' . $sticker . '"></td>
                    <td><img src="../images/delete.png" class="delete_verp" id="' . $verpackung['article_id'] . '" width="40px"></td>
                    </tr>
                    ';
                   
                   
               }
               
               
           }
          }
          
                        
          
          ?>
          </table>

            
            
        </div>
    </div> 

<div class="modal fade" id="order_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bestelldetails</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="order_modal_detail">
        
      </div>
      <div class="modal-footer">

          <button type="button" class="btn_fp_btn_all" id="rat_confirm_btn" data-dismiss="modal" style="display:none;">Änderungen speichern</button>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<div id="usadm_best_div" userid="<?php echo $userid; ?>" style="display:none;">
     <div style="margin-top:50px;">
         
 <?php  
          if(count($orders) == 0){
              echo'
                  <p style="margin:0px auto;"><h3>Keine Bestellungen vorhanden!</h3></p>
              ';              
          }else{
              echo '
            <table class="table table-bordered table-condensed table-striped table-hover" style="cursor:pointer;">
                <tr>
                <th>Datum der Bestellung</th>
                <th>Liefertermin</th>
                <th>Gesamtsumme</th>
                <th>Status</th>
                </tr>
          ';
              
           foreach($orders as $item){
               echo'
               <tr class="order_row" data-href="' . $item['order_id'] . '" status="' . $item['status'] . '">
               <td>' . $item['order_date'] . '</td>
               <td>' . $item['delivery_date'] . '</td>
               <td>' . $item['total_amount'] . ' €</td>
               <td>' . $item['status'] . '</td>
               </tr>
               ';
           }   
          
          }
          
          ?>
          </table>

            
            
        </div>
</div>

<div id="usadm_rez_div" style="display:none;">
     <div style="margin-top:50px;">
         
 <?php  
          if(count($rezepte) == 0){
              echo'
                  <p style="margin:0px auto;"><h3>Keine Rezepte vorhanden!</h3></p>
              ';              
          }else{
              echo '
            <table class="table table-bordered table-condensed table-striped table-hover" style="cursor:pointer;">
                <tr>
                <th>Rezeptname</th>
                <th>Gesamtsumme</th>
                <th>Datum der Erstellung</th>
                </tr>
          ';
              
           foreach($rezepte as $item){
               echo'
               <tr class="recipe_row" data-href="' . $item['article_id'] . '">
               <td>' . $item['description'] . '</td>
               <td>' . $item['price'] . ' €</td>
               <td>' . $item['timestamp'] . '</td>
               </tr>
               ';
           }   
          
          }
          
          ?>
          </table>

            
            
        </div>
</div>

<div class="modal fade" id="recipe_detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rezeptdetails</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="recipe_modal_detail">
        
      </div>
      <div class="modal-footer">
          
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
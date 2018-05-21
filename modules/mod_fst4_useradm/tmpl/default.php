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
       modFst4UserAdmHelper::changeUserData($data);
       
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
<h1>User Administration</h1>
    <h2>Account von <?php echo $user->name; ?></h2>
    
<ul class="nav nav-tabs">
  <li id="usadm_allg" role="presentation" class="active"><a href="#">Allgemein</a></li>
  <li id="usadm_persDat" role="presentation"><a href="#">Persönliche Daten</a></li>
</ul>
    
    <div id="usadm_allg_div" style="display:block;">
        <div style="margin-top:50px;">
         <a class="btn btn-danger" href="index.php?option=com_users&task=user.logout&<?php echo $userToken;?>=1" role="button">Logout</a>
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
                    <button type="submit" class="btn btn-success">Änderungen speichern</button>
</form>
        
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#pwModal">
  Passwort ändern
</button>
        <form method="POST" action="#">
            <input type="hidden" name="mail_user" value="<?php echo $user->email;  ?>">
<button type="submit" class="btn btn-danger" id="btnRemUserAccount">Account löschen</button>
        </form>
</div>

</div>
    
            
        
        
<!-- Modal -->
<div class="modal fade" id="pwModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Passwortänderung</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Passwort ändern</button>
      </div>
        </form>
    </div>
  </div>
</div>
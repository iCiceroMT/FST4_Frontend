<?php
/**
 * @package         Fst4-Register.Module
 * @subpackage      mod_fst4_register
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;

$uri = JUri::getInstance(); 
if(ISSET($_GET['do']) && $_GET['do'] == 'reg' ){

$data = array(
    "vorname" => $_POST['vorname'],
    "nachname" => $_POST['nachname'],
    "addresse" => $_POST['addresse'],
    "stadt" => $_POST['stadt'],
    "plz" => $_POST['plz'],
    "tel" => $_POST['tel'],
    "mail" => $_POST['mail'],
    "pw1" => $_POST['pw1'],
    "pw2" => $_POST['pw2'],
    "bdate" => $_POST['bdate'],
    "country" => $_POST['country']
    );
    modFst4RegisterHelper::regUser($data);
    header('Location: ./index.php');
}    
?>

<div class="container" id="RegDiv" style="">
    <h1 class="well" id="registry" text-align="center">Registrierung</h1>
    <div class="col-lg-12 well">
        <div class="row">
            <form  action="<?php echo $uri; ?>?do=reg" method="post">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label class="Registrierung">Vorname</label>
                            <input name="vorname" type="text" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="Registrierung">Nachname</label>
                            <input name="nachname" type="text" class="form-control">
                        </div>
                    </div>					
                    <div class="form-group">
                        <label class="Registrierung">Addresse</label>
                        <textarea name="addresse" rows="3" class="form-control"></textarea>
                    </div>	
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="Registrierung">Stadt</label>
                            <input name="stadt" type="text" class="form-control">
                        </div>	
                        <div class="col-sm-4 form-group">
                            <label class="Registrierung">Postleitzahl</label>
                            <input name="plz" type="text" class="form-control">
                        </div>		
                    </div>
                    <div class="row">
                    <div class="col-sm-4 form-group">
                        <label class="Registrierung">Telefonnummer</label>
                        <input name="tel" type="text" class="form-control">
                    </div>	
                     <div class="col-sm-4 form-group">
                        <label class="Registrierung">Geburtsdatum</label>
                        <input name="bdate" type="date" class="form-control">
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-4 form-group">
                        <label class="Registrierung">Email-Addresse</label>
                        <input name="mail" type="text" class="form-control">
                    </div>
                      <div class="col-sm-4 form-group">
                        <label class="Registrierung" for="sel1">Land</label>
                        <select class="form-control" name="country" id="sel1">
                          <option>Österreich</option>
                          <option>Deutschland</option>
                          <option>Schweiz</option>
                        </select>
                      </div> 
                    </div>
                    <div class="form-group">
                        <label class="Registrierung">Passwort</label>
                        <input name="pw1" type="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="Registrierung">Passwort wiederholen</label>
                        <input name="pw2" type="password" class="form-control">
                    </div>
             <div class="fp_btn_all">
                    <a type="submit">Registrieren</a>
             </div>
                </div>
            </form> 
        </div>
    </div>
</div>
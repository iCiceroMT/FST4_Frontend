<?php
/**
 * @package         Fst4-Login.Module
 * @subpackage      mod_fst4_login
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;
$user = JFactory::getUser();
echo "Dein Name: " . $user->name;
$uri = JUri::getInstance(); 
if(ISSET($_GET['do']) && $_GET['do'] == 'login' ){
if(!ISSET($_POST['user']) || !ISSET($_POST['pw'])){echo "Benutzername und/oder Passwort dürfen nicht leer sein!";}
else{
$data = array(
    "user" => $_POST['user'],
    "pw" => $_POST['pw']
   
    );
    echo modFst4LoginHelper::loginUser($data);
}
}    
?>
<div class="container" id="LoginDiv" style="display: block;">
    <h1>Anmelden</h1><br>
    <form  action="<?php echo $uri; ?>?do=login" method="post">
        <div class="form-group row">
            <label for="mail" name="user" class="col-sm-2 col-form-label">E-Mail-Addresse</label>
            <div class="col-sm-10">
                <input type="text" id="mail">
            </div>
        </div>
        <div class="form-group row">
            <label for="passwd" name="pw" class="col-sm-2 col-form-label">Passwort</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="passwd">
            </div>
        </div>
        <a href="#" id="RegLink">Noch kein Kunde? Hier geht's zur Registrierung!</a>
        <button type="submit" id="loginBtn">Anmelden</button>
    </form>
</div>
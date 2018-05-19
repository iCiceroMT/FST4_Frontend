<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(ISSET($_POST['pdetails'])){
    $pdetails = $_POST['pdetails'];
    $tempid = $pdetails[0]["package_id"] + 1;
 
}else{header('Location: http://wi-gate.technikum-wien.at:60336/index.php');}


echo '
<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <p>Bezeichnung: ' . $pdetails[0]["description"] . '</p>
            <p>Preis: ' . $pdetails[0]["price"] . '</p>

        </div>
        <div class="col-md-3">
        <img src="./images/artikelbilder/package/'. $tempid .'.jpg" />
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<div>
<button type="button" class="btn btn-success">In den Warenkorb</button>
<a class="btn btn-info" href="./index.php" role="button">Zurück</a>
</div>



   ';  


        ?>
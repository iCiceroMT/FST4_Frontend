<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(ISSET($_POST['pdetails'])){
    $pdetails = $_POST['pdetails'];
    //rating berechnen
    $rating = 0;
    $cnt = 0;
    foreach($pdetails as $item){
        $rating += $item["stars"];
        $cnt ++;
    }

 
}else{header('Location: http://wi-gate.technikum-wien.at:60336/index.php');}


echo '
<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <p>Bezeichnung: ' . $pdetails[0]["description"] . '</p>
            <p>Preis: ' . $pdetails[0]["price"] . '</p>
            <p>Rating: '; for($i = 1; $i <= 5; $i++ ){if($i <= ($rating / $cnt)){ echo '<span class="fa fa-star checked"></span>'; }else{ echo '<span class="fa fa-star"></span>';}}  echo '</p>

        </div>
        <div class="col-md-3">
        <img src="./images/artikelbilder/artikel/' . $pdetails[0]["article_id"] . '.jpg" />
        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>

<div>
<button type="button" class="btn btn-success">In den Warenkorb</button>
<a class="btn btn-info" href="./index.php" role="button">Zurück</a>
</div>



   ';  


        ?>
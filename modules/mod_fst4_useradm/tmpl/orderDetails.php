<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(ISSET($_POST['odetails'])){
    $odetails1 = $_POST['odetails'];
    $userid = $_POST['userid'];
    $status = $_POST['status'];

    //alles aussortieren, wo die Person_id nicht richtig ist :)
    $odetails = array();
    foreach($odetails1 as $item){
        if($item['person_id'] == "" || $item['person_id'] == $userid){
            array_push($odetails, $item);
        }
    }

}
?>

<div id="product_detail_div">
<?php
if(strlen($odetails[0]['order_id']) == 0){
    echo "<h3>Diese Bestellung enthält keine Produkte</h3>";
}else{
              echo '
            <table class="table table-bordered table-condensed table-striped table-hover" style="cursor:pointer;">
                <tr>
                <th>Artikelname</th>
                <th>Details</th>
                <th>Menge</th>
                <th>Preis</th>
                <th>Verpackung</th>
                <th>Bewertung</th>
                </tr>
          ';
              
           foreach($odetails as $item){
               echo'
               <tr id="pdetail_row" artid="' . $item['article_id'] . '" persid="'. $userid . '" status="' . $status . '">
               <td id="pdetail_desc">' . $item['description'] . '</td>
               <td id="pdetail_det">' . $item['details'] . '</td>
               <td id="pdetail_amount">' . $item['amount'] . '</td>
               <td id="pdetail_price">' . $item['price'] . ' €</td>
               <td>'; if($item['wrapname'] == ""){echo "-";}else{ echo $item['wrapname'];}  echo '</td>
               <td>'; if($item['person_id'] == ""){echo "Noch keine Berwertung vorhanden";}else{for($i = 1; $i <= 5; $i++ ){if($i <= $item['stars']){ echo '<span class="fa fa-star checked"></span>'; }else{ echo '<span class="fa fa-star"></span>';}}}  echo '</td>
               </tr>
               
               ';
           } 
}
?>

</div>
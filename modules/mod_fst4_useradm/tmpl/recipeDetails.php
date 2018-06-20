<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(ISSET($_POST['rdetails'])){
    $rdetails = $_POST['rdetails'];
 
   
}

if(strlen($rdetails[0]['description']) == 0){
    echo "<h3>Dieses Rezept enthält keine Produkte</h3>";
}else{
              echo '
            <table class="table table-bordered table-condensed table-striped table-hover" style="cursor:pointer;">
                <tr>
                <th>Zutat</th>
                <th>Preis</th>
                <th>Menge</th>

                </tr>
          ';
              
           foreach($rdetails as $item){
               echo'
               <tr>
               <td>' . $item['description'] . '</td>
               <td>' . $item['price'] . " €/" . $item['unit'] . '</td>
               <td>' . $item['amount'] . ' ' . $item['unit'] .'</td>

               </tr>
               ';
           } 
           
           echo '
               </table>
               
           <div class="row">
            <div class="col-md-6">
            <label for="exampleInputEmail1">Zubereitung</label>
                    <textarea class="form-control" rows="10" disabled>'; echo $rdetails[0]['preperation_description'];   echo'</textarea>
            </div>
            <div class="col-md-6">
            <label for="exampleInputEmail1">Sonderwünsche</label>
                    <textarea class="form-control" rows="10" disabled>';  echo $rdetails[0]['extras'];  echo'</textarea>
            </div>

            </div>
           
           
           
           ';
           
}
?>
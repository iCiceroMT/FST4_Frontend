<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$data = $_POST['ratDetails'];

$status = $_POST['status'];

$artid = $_POST['artid'];
$persid = $_POST['persid'];

if($status == "abgeschlossen"){
echo '
<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-6">
             <div class="form-group">
                <label for="comment">Rating:</label> </br>';
                for($i = 1; $i <= 5; $i++ ){if($i <= $data[0]['stars']){ echo '<span class="fa fa-star checked rating_yes rating ratingnr'. $i .'" ratnr="'.$i.'" id="ratid'.$i.'"></span>'; }else{ echo '<span class="fa fa-star ratin_no rating ratingnr'. $i .'" ratnr="'.$i.'" id="ratid'.$i.'"></span>';}}
              echo '</div> 
        </div>
        
        <div class="col-md-6">
              <div class="form-group">
                <label for="comment">Kommentar:</label>
                <textarea class="form-control" stars2="'.$data[0]['stars'].'" stars="1" artid="'. $artid .'" persid="'. $persid .'" rows="5" id="rat_comment">'; if($data[0]['comment'] == ""){echo "Noch kein Kommentar vorhanden!";}else{echo $data[0]['comment'];}  echo'</textarea>
              </div> 
        </div>
    </div>

';}

else{
    echo '
<div class="container" style="margin-top:50px;">
    <h3>Bitte schließen Sie die Bestellung ab, bevor Sie Bewertungen vornehmen können.</h3>
</div>    
    ';
}
?>
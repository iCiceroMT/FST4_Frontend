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
 


//anzahl von ratings herausfinden
$rat_tmp = array();
$anz_rat = 0;
foreach($pdetails as $item){
        if($item[0]['article_id'] != ""){$anz_rat++;}else{
            array_push($rat_tmp, $item);
        }
    }
foreach($rat_tmp as $item){
        $rating += $item["stars"];
        $cnt ++;
    } 
    

if($anz_rat == 1){
   $verp = $pdetails[count($pdetails)-1]; 
}else{
$verp_cust = $pdetails[count($pdetails)-1]; 
$verp = $pdetails[count($pdetails)-2]; 

}   


 
}else{header('Location: http://wi-gate.technikum-wien.at:60336/index.php');}


echo '
<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <div id="div_pdetail_des"><h2 id="productdetail">' . $pdetails[0]["description"] . '</h2></div><br/>
            <div id="div_pdetail_preis"><h2 id="productdetail_preis">Preis in €: </h2> ' . $pdetails[0]["price"] . '</div><br/>
            <div id="div_pdetail_rat"><h2 id="productdetail_rating">Rating: </h2>'; for($i = 1; $i <= 5; $i++ ){if($i <= ($rating / $cnt)){ echo '<span class="fa fa-star checked"></span>'; }else{ echo '<span class="fa fa-star"></span>';}}  echo '</div><br/>
              <div id="div_pdetail_anz"><h2 id="productdetail_anzahl">Anzahl: </h2>  </div>    
               <div class="input-group spinner">
                    <input type="text" class="form-control" id="amount" value="1">
                    <div class="input-group-btn-vertical">
                      <button id="btn_spinner_up" class="btn btn-default btn_spinner_up" type="button"><i class="fa fa-caret-up"></i></button>
                      <button class="btn btn-default btn_spinner_down" type="button"><i class="fa fa-caret-down"></i></button>
                    </div>
                </div>
                <div id="div_pdetail_besch"><h2 id="productdetail_beschreibung">Beschreibung: </h2><br/>' . $pdetails[0]["details"] . '<br/>';
                    if($pdetails[0]["details"] == ""){echo 'Leider noch keine Beschreibung vorhanden <br /><br />';}
                    echo '</div>
                <div id="div_pdetail_komm"><h2 id="productdetail_kommentare">Kommentare: </h2><br/>';
                $ratcnt1 = 0;
                foreach($pdetails as $item){
                        if(count($item['comment']) > 0){
                               echo $item['comment'] . '<br/>';
                               if($item['comment'] != ""){$ratcnt1++;}
                        }
                    }
                if($ratcnt1 == 0){echo 'Leider noch keine Kommentare vorhanden';}    
echo '</div>
        </div>
        <div class="col-md-3">
        <img src="../images/artikelbilder/artikel/' . $pdetails[0]["article_id"] . '.jpg" />
        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>

<div id="pdetails_button">
<div class="row">
<div class="fp_btn_all"> 
  
      <button type="button" class="btn_fp_btn_all" data-toggle="modal" data-target="#exampleModal">
  In den Warenkorb
</button>
</div>
<div class="fp_btn_back">    
    <a class="" href="./index.php/fertige-kuchen?do=reload" role="button">Zurück</a>
</div>
</div>
</div>



   ';  


        ?>  <!--<button type="cake"   class="btn_fp_btn_all" article_id="" id="addToCartBtn" item_id="'. $pdetails[0]["article_id"] .'">In den Warenkorb</button>-->
        
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verpackung wählen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"  style="min-height:150px;">
          <p>Bitte wählen Sie eine Verpackung für Ihr Produkt.</p>
          
          <div class="form-group">
                <label class="col-md-4 control-label" for="selectpdetail">Verpackungen</label>
                <div class="col-md-4">
                  <select id="selectpdetail_verp" name="verpackung" class="form-control">
                     <option value="0" price="0" selected>Bitte wählen...</option>
                                     <?php
                                     $i = 0;
                                     
                                     foreach($verp as $item){
                                         if($i % 3 == 0 ){
                                          echo'
                                          <option  value="'.$item['article_id'].'">'
                                          . $item['description'] .
                                          '</option>
                                         ';}
                                          
                                          $i++;



                                     }
                                     $i = 0;
                                     foreach($verp_cust as $item){
                                          if($i % 3 == 0 ){
                                          echo'
                                          <option  value="'.$item['article_id'].'">'
                                          . $item['description'] .
                                          '</option>
                                          ';
                                          }
                                          $i++;


                                     }
                                     

                                     ?>
                  </select>
                </div>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="cake" verp_id="" id="addToCartBtn" class="btn_fp_btn_all_disabled" item_id="<?php echo $pdetails[0]["article_id"]; ?>">In den Warenkorb</button>
      </div>
    </div>
  </div>
</div>
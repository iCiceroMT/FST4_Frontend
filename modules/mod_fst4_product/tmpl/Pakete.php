<?php

 $items = $_POST['items'];
$tempPak = $items[0]["package_id"] + 1;
?>
<h1>Fertige Pakete</h1>
<div class="container">
    <?php 
    $x = 0;
    for($i = 0; $i < ceil(count($items) / 4); $i++){  
        echo '<div class="row">';
        
                    for($o = 0; $o < 4; $o++){    
                     if($x < count($items)){ echo '<div class="col-md-3"><div class="productbox" ><img class="paketBilder" src="/./images/artikelbilder/package/' . $items[$x]["package_id"] . '.jpg" width="200px">' . $items[$x]["description"] . '</br><p>Preis: ' . $items[$x]["price"] . ' €</p> </br><div class="fp_btn_all"><a type="button" onclick="showDetailsPackage(' . $items[$x]["package_id"] . ')" id="productdetailbtn_articleid_' . $items[$x]["package_id"] . '>Details</a></div></div>';} 
                      $x++;
                    }

        echo '</div>';
            } ?>
</div>
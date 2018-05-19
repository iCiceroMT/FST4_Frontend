<?php

 $items = $_POST['items'];

?>
<h1>Fertige Pakete</h1>
<div class="container">
    <?php 
    $x = 0;
    for($i = 0; $i < ceil(count($items) / 4); $i++){  
        echo '<div class="row">';
        
                    for($o = 0; $o < 4; $o++){    
                     if($x < count($items)){ echo '<div class="col-md-3"><div class="productbox" >' . $items[$x]["description"] . '</br>Preis: ' . $items[$x]["price"] . '</br><button type="button" onclick="showDetailsPackage(' . $items[$x]["package_id"] . ')" id="productdetailbtn_articleid_' . $items[$x]["package_id"] . '"class="btn btn-warning">Details</button>' . '</div></div>';} 
                      $x++;
                    }

        echo '</div>';
            } ?>
</div>
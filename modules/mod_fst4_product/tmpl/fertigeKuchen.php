<?php
/**
 * Created by PhpStorm.
 * User: Cicero
 * Date: 09.04.2018
 * Time: 20:22
 */
$items = $_POST['items'];
echo "a";
?>


<div class="container" id="main_product_load">
    <?php 
    $x = 0;
    for($i = 0; $i < ceil(count($items) / 4); $i++){  
        echo '<div class="row">';
        
                    for($o = 0; $o < 4; $o++){    
                     if($x < count($items)){ echo '<div class="col-md-3"><div class="productbox" >' . $items[$x]["description"] . '</br>Preis: € ' . $items[$x]["price"] . '</br><button class="fp_btn_fertigeKuchen" type="button" onclick="showDetailsArticle(\'' . $items[$x]["article_id"] . '\')" id="productdetailbtn_articleid_' . $items[$x]["article_id"] . '"class="btn btn-warning">Details</button>' . '</div></div>';} 
                      $x++;
                    }

        echo '</div>';
            } ?>
</div>
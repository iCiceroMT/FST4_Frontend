<?php
/**
 * @package         Fst4-Product.Module
 * @subpackage      mod_fst4_product
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die;

$items = modFst4ProductHelper::getArticlesAjax();
if(ISSET($_GET['do'])){
    if($_GET['do'] == "reload"){
            
                header('Location: http://wi-gate.technikum-wien.at:60336/index.php/fertige-kuchen');
        
            }

    }
?>

<h1>Fertige Kuchen</h1>


<div class="container" id="main_product_load">
    <?php 
    $x = 0;
    for($i = 0; $i < ceil(count($items) / 4); $i++){  
        echo '<div class="row" id="fertigeKuchen">';
            
                    for($o = 0; $o < 4; $o++){    
                     if($x < count($items)){
                         $rating = modFst4ProductHelper::getArticlesRating($items[$x]["article_id"]);
                         $cntrating = 0;
                         $cnti = 1;
                         foreach($rating as $iitem){$cntrating += $iitem['stars']; $cnti++;}
                         if($cnti > 1){$cnti --;};
                         echo '<div class="col-md-3">'
                         . '<div class="productbox" ><img class="fertigekuchenBilder" src="/./images/artikelbilder/artikel/' . $items[$x]["article_id"] . '.jpg" width="200px">' .'</br>'.'<h4 class=producttitle>'. $items[$x]["description"] .'</h4>';
                          echo  '<p class="productprice">Preis: € ' . $items[$x]["price"].'</p>' ;
                         for($ii = 1; $ii <= 5; $ii++ ){if($ii <= $cntrating / $cnti){ echo '<span class="fa fa-star checked"></span>'; }else{ echo '<span class="fa fa-star"></span>';}}
                          echo '</br><div class="fp_btn_all"><a type="button"  id="' . $items[$x]["article_id"] . '"  class="btn btn-warning do_product_detail">Details</a></div>' . '</div></div>';} 
                      $x++;
                    }

        echo '</div>';
            } ?>
</div>

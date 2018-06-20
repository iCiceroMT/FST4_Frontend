<?php
/**
 * @package         Front>Page2.Module
 * @subpackage      mod_fst4_frontpage
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;
$data = modFst4FrontPage2Helper::getArticleFrontpageNew();
 defined('_JEXEC') or die;
?>

<div id="main_frontpage" style="width:100%;">
    <div id="seperator">       
        <h3>Neue Produkte</h3>  
        <div id="cake_icon_sep">
            <img class="cake_icon_img" src="./images/icons/cake_icon.png">
        </div>
     
    </div>
</div>

<div>
 <div class="row">
     <?php
     for($i = 0; $i<=3; $i++){
         $rating = $data[$i]['stars'];
         echo '<div class="col-md-3" id="frontpage_article_div">';
         echo'
           <div class="row" >
           <div class="fp_btn_container">
                <img class="fp_image" src="./images/artikelbilder/artikel/' .$data[$i]['article_id']. '.jpg">
                    
            </div>
<h2><a href="./index.php/fertige-kuchen">'. $data[$i]['description'] . '</a></h2>

            <div id="fp_rating">
                ';
                for($x = 1; $x <= 5; $x++ ){if($x <= $rating){ echo '<span class="fa fa-star checked"></span>'; }else{ echo '<span class="fa fa-star"></span>';}}
            echo '
                
            </div>
            
              
           </div>

         ';
         
         
         
         echo'</div>';   
     }     
     ?>

</div>
    <div class="fp_btn_all"><a href="./index.php/fertige-kuchen">Alle Produkte</a></div>
</div>


	                            

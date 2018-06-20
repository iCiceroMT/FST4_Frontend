<?php
/**
 * @package         Front>Page.Module
 * @subpackage      mod_fst4_frontpage
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;
$data = modFst4FrontPageHelper::getArticleFrontpage();

?>
<section class="section box_featured" style="">    
<div id="main_shortmenu" class="container">
    
        <div class="row">
            <div class="col-sm-4">
                <a href="./index.php/fertige-kuchen">
                    <div class="addon addon-feature text-left">
                        <div class="addon-content">
                            <div class="media ">
                                <div class="pull-left auswahlpic cupcakes" id="apic1">
                                    <span style="display:inline-block">                    
                                 <img src="/images/main_pics/iconbox1.jpg">
                                    </span>
                                </div>
                                
                                <div class="media-body main_auswahl_text">
                                    <p id="cupcake_text1">Unser Konditor empfiehlt..</p>
                                    <p class="addon-text">
                                        Beste Torten, Kuchen und andere Leckereien mit viel Liebe gebacken<br>                      
                                    </p>                   
                            </div>
                            </div>
                        </div>
                   
                </div>
                </a>
            </div>
            
            
            <div class="col-sm-4">
               <a href="./index.php/fertige-kuchen">
                    <div class="addon addon-feature text-left">
                        <div class="addon-content">
                            <div class="media">
                                <div class="pull-left auswahlpic cupcakes" id="apic2">
                                    <span style="display:inline-block">                    
                                 <img src="/images/main_pics/iconbox2.jpg">
                                    </span>
                                </div>
                                
                                <div class="media-body main_auswahl_text">
                                    <p id="cupcake_text2">Beliebte Kuchen</p>
                                    <div class="addon-text">
                                        Die beliebtesten Kuchen unserer Kunden! <br>                  
                                    </div>                   
                            </div>
                            </div>
                        </div>
                    </div>
               </a>
            </div>
            
            
            <div class="col-sm-4">
               <a href="./index.php/fertige-kuchen">
                    <div class="addon addon-feature text-left">
                        <div class="addon-content">
                            <div class="media">
                                <div class="pull-left auswahlpic cupcakes" id="apic3">
                                    <span style="display:inline-block">                    
                                 <img src="/images/main_pics/iconbox3.jpg">
                                    </span>
                                </div>
                                
                                <div class="media-body main_auswahl_text">
                                    <p id="cupcake_text3">Wir stellen uns vor...</p>
                                    <div class="addon-text">
                                        Das Team rund um GetYourCake <br>                  
                                    </div>                   
                            </div>
                            </div>
                        </div>
                    </div>
               </a>
   
        </div>
    </div>
</div>
</section>   

<div id="main_frontpage" style="width:100%;">
    <div id="seperator">       
        <h3>Für Sie empfohlen</h3>  
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

<div><h2><a href="">'. $data[$i]['description'] . '</a></h2></div>
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


	                            
 
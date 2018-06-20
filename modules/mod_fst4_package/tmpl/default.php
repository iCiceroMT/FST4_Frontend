<?php
/**
 * @package         Fst4-Product.Module
 * @subpackage      mod_fst4_product
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access

$items = modFst4PackageHelper::getPackagesAjax();
$cakes = modFst4PackageHelper::getCakes();
?>

<div class="container" id="overview" style="display: block">
    <div class="card col-md-5">
        <div class="card-body" >
            <h2 class="card-title" >Fertige Packages</h2>
            <p class="card-text">Stöbern Sie in der Auswahl von Packages, welche von unseren Konditormeistern 
                sorgfältig gebacken und zusammengestellt wurden. Hier finden Sie garantiert das Richtige für Sie!
            </p>
            <div class="fp_btn_all">
                <a type="button" id="preMadePackages" class="btn btn-warning">Weiter</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body col-md-5" >
            <h2 class="card-title">Individuelles Package</h2>
            <p class="card-text">Sie lieben Individualität und haben einen ganz eigenen Geschmack. Dann werden Sie doch selbst kreativ 
                und stellen Sie Ihr eigenes Paket aus bis zu 5 Kuchen zusammen!</p>
            <div class="fp_btn_all">
                <a type="button" id="selfMadePackages" class="btn btn-warning">Weiter</a>
            </div>
        </div>
    </div>
</div>



<div class="container" id="packageList" style="display: none">
    <h1 class="h1_fertigePakete" >Fertige Pakete</h1>
    <?php
    $x = 0;
    for ($i = 0; $i < ceil(count($items) / 4); $i++) {
        ?><div class="row">
        <?php
        for ($o = 0; $o < 4; $o++) {
            if ($x < count($items)) {
                ?>
                    <div class="col-md-3">
                        <div class="productbox" > 
                            <img src="../images/artikelbilder/package/<?php echo $items[$x]['package_id'] ?>.jpg" height="150" width="200"/>
                            <?php echo $items[$x]["description"] ?></br>
                            Preis:<?php echo $items[$x]["price"] ?>€</br>
                            <div class="fp_btn_all">
                                <!--<button type="button" id="packageDetailsBtn" class="btn btn-warning">Details</button>-->
                                <button onclick="showDetailOfPackage('<?php echo $items[$x]["package_id"] ?>')" id="packageDetailsBtn" class="btn_fp_btn_all">Details</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                $x++;
            }
        }
        ?>

    </div></div>

<div class="container" id="packageConf" style="display: none">
    <h1>Geschenkspaket zusammenstellen</h1>
    <?php foreach ($cakes as $cake) { ?>
        <div class="col-md-3">
            <div class="productbox">
                <img src="../images/artikelbilder/artikel/<?php echo $cake['article_id'] ?>.jpg" height="150" width="200"/>
                <label class="producttitle"><?php echo $cake['description'] ?></label></br>
                Hinzufügen: <input name="packageCakes" type="checkbox" value="<?php echo $cake['article_id'] ?>"/><br/>
                Preis: <label name="cakePrices"><?php echo ($cake['price'] * 0.85) ?></label> €
            </div>
        </div>
    <?php }
    ?>
    Gesamtpreis: <label id="completeSum">0</label>€
    <div class="row">
        <div class="fp_btn_back">
            <a  href="index.php/pakete" role="button">Zurück</a>
        </div>
        <button class="btn_fp_btn_all" id="addToPackageToCartBtn">Zum Warenkorb hinzufügen</button>
    </div>
</div>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (ISSET($_POST['pdetails'])) {
    $pdetails = $_POST['pdetails'];
    $tempid = $pdetails[0][0]["package_id"];
    $cakes = $_POST['pdetails'][1];
} else {
    header('Location: http://wi-gate.technikum-wien.at:60336/index.php');
}
?>

<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <h2 id="productdetail"> <?php echo $pdetails[0][0]["description"] ?> <br/>
                <h2 id="productprice">Preis: <?php echo $pdetails[0][0]["price"] ?> €<br/>
                    Menge: <input type="number" id="amount" value="1"/>
                    <p>Dieses Geschenkspaket enthält: </p>
                    <?php
                    foreach ($cakes as $cake) {
                        ?>
                    <li><label><?php echo $cake ?></label></li>
                        <?php
                    }
                    ?>
                    </div>
                    <div class="col-md-3">
                        <img src="../images/artikelbilder/package/<?php echo $tempid ?>.jpg" height="150" width="200"/>
                    </div>
                    <div class="col-md-3">
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-md-offset-2">
                            <div class=" fp_btn_all">                               
                                <a type="package" class="fp_btn_all" id="addToCartBtn" item_id="<?php echo $pdetails[0][0]["package_id"] ?>" class="" width="100">In den Warenkorb</a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class=" fp_btn_back">
                                <a class="fp_btn_back" href="./pakete" role="button">Zurück</a>
                            </div>
                        </div>

                    </div>
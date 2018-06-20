<?php
/**
 * @package         Fst4-Cart.Module
 * @subpackage      mod_fst4_cart
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access

defined('_JEXEC') or die;



$control = 0;
$generalcontrol = 0;
$configcontrol = 0;
$detailcontrol = 0;
$packageControl = 0;
$vouchercontrol = 0;
$recipecontrol = 0;
$cart = modFst4CartHelper::getCart();
$user = modFst4CartHelper::getUser();
$config = modFst4CartHelper::getConfig();
$packageconifg = modFst4CartHelper::getPackages();


if (count($cart['items']) > 0) {
    foreach ($cart['items'] as $product) {
        if (strpos($product['type'], "voucher") !== false) {
            $vouchercontrol = 1;
            break;
        }if ($product['type'] == 'cake' || $product['type'] == 'package') {
            $generalcontrol = 1;
        }if ($product['type'] == 'recipe') {
            $recipecontrol = 1;
        }
    }
}


if ($cart != null && count($cart['items']) > 0) {
    $control = 1;
}
if ($config != null && count($config) > 0) {
    $configcontrol = 1;
}
if ($packageconifg != null && count($packageconifg) > 0) {
    $packageControl = 1;
}
$compAmount = modFst4CartHelper::getAmount();
$compSum = modFst4CartHelper::getSum();
?>
<div id="ShopppingCartDiv" style="display: block">
    <h1>Warenkorb </h1>
    <?php
    if ($control == 0 && $configcontrol == 0 && $packageControl == 0) {
        echo "<p>Es befinden sich keine Produkte im Warenkorb</p>";
    }
    ?>
    <div class="container" id="productDiv">
        <?php
        $i = 0;
        if ($control == 1) {
            if ($generalcontrol == 1) {
                echo "<h2>Ihre Produkte</h2>";
                foreach ($cart['items'] as $product) {
                    if ($product['type'] == "cake") {
                        $desc = modFst4CartHelper::getDesc($product['id']);
                        $quant = $product['quantity'];
                        $pic = modFst4CartHelper::getPic($product['id']);
                        $price = modFst4CartHelper::getPrice($product['id']);
                        $wrapping = modFst4CartHelper::getWrapping($product['wrapping']);
                        $detailcontrol = 1;
                    } else if ($product['type'] == "package") {
                        $desc = modFst4CartHelper::getPackageDesc($product['id']);
                        $pic = modFst4CartHelper::getPackagePic($product['id']);
                        $price = modFst4CartHelper::getPackagePrice($product['id']);
                        $quant = $product['quantity'];
                        $detailcontrol = 1;
                    }if ($detailcontrol == 1 && ($product['type'] == "cake" || $product['type'] == "package")) {
                        ?>
                        <div id="productBox<?php echo $i ?>" style="display: block">
                            <ul class="list-group">
                                <input id="prodId" hidden value="<?php echo $product['id'] ?>">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $desc ?>
                                    <button id="addAmountBtn" class="plusBtn<?php echo $i ?>">+</button>
                                    <span class="badge badge-primary badge-pill" id="prodQuant<?php echo $i ?>"><?php echo $quant ?></span>
                                    <button id="decrementAmountBtn" class="minusBtn<?php echo $i ?>">-</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <img src="<?php echo $pic ?>" height ="100" widht ="150"/>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Preis: <label id="productPrice<?php echo $i ?>"><?php echo $price ?></label>€
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Verpackung: <label id="wrapping"><?php echo $wrapping ?></label>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <button id="removeFromCartBtn" class="btn_fp_btn_back productBtn<?php echo $i ?>">Produkt löschen</button>
                                </li>
                            </ul>
                        </div>
                        <?php
                    }
                    $i++;
                }
            }
            ?>
        </div>
        <?php if ($vouchercontrol == 1) { ?>
            <div class="container" id="voucherDiv">
                <h2>Ihre Gutscheine</h2>
                <?php
                foreach ($cart['items'] as $product) {
                    if (strpos($product['type'], "voucher") !== false) {
                        $amount = $product['quantity'];
                        $wert = $product['id'];
                        $pic = modFst4CartHelper::getPic($product['type']);
                        ?>
                        <div id="voucherBox<?php echo $i ?>" style="display: block">
                            <ul class="list-group list-group-flush">
                                <input id="voucherId" hidden value="<?php echo $wert ?>">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Gutscheinwert: <?php echo $wert ?>€
                                    <!--<button id="addAmountBtn">+</button>-->
                                    <span class="badge badge-primary badge-pill"><?php echo $amount ?></span>
                                    <!--<button id="decrementAmountBtn">-</button>-->
                                </li>

                                <li class="list-group-item">
                                    <img src="<?php echo $pic ?>" width="200" height="100"/>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <button id="removeVoucherFromCartBtn" class="btn_fp_btn_back voucherBtn<?php echo $i ?>">Produkt löschen</button>
                                </li>
                            </ul>
                        </div>
                        <?php
                    }$i++;
                }
            }if ($recipecontrol == 1) {
                ?>
                <div class="container" id="recipeDiv">
                    <h2>Ihre erstellten Rezepte</h2>
                    <?php
                    foreach ($cart['items'] as $product) {
                        if ($product['type'] == 'recipe') {
                            //$product['id'] = '0200A5B0-55D8-4581-9A99-9DE542609F78';
                            $desc = modFst4CartHelper::getDesc($product['id']);
                            $price = modFst4CartHelper::getPrice($product['id']);
                            $wrapping = modFst4CartHelper::getWrapping($product['wrapping']);
                            $details = modFst4CartHelper::getRecipeDetails($product['id']);
                            $quant = 1;
                            ?>
                            <div id="productBox<?php echo $i ?>" style="display: block">
                                <ul class="list-group">
                                    <input id="prodId" hidden value="<?php echo $product['id'] ?>">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo $desc ?>
                                        <button id="addAmountBtn" class="plusBtn<?php echo $i ?>">+</button>
                                        <span class="badge badge-primary badge-pill prodQuant<?php echo $i ?>" id="quantity"><?php echo $quant ?></span>
                                        <button id="decrementAmountBtn" class="minusBtn<?php echo $i ?>">-</button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Preis: <label id="productPrice" class="productPrice<?php echo $i ?>"><?php echo $price ?></label>€
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Verpackung: <label id="wrapping"><?php echo $wrapping ?></label>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Zutat</th>
                                                    <th>Menge</th>
                                                    <th>Preis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($details as $detail) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $detail['description'] ?></td>
                                                        <td><?php
                                                            echo $detail['amount'];
                                                            echo " ";
                                                            echo $detail['unit']
                                                            ?></td>
                                                        <td><?php echo $detail['amount'] * $detail['price'] ?>€</td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <button id="removeFromCartBtn" class="btn_fp_btn_back productBtn<?php echo $i ?>">Produkt löschen</button>
                                    </li>
                                </ul>
                            </div>
                            <?php
                        }$i++;
                    }
                    ?>
                </div>
                <?php
            }
        }
        if ($configcontrol == 1) {
            $k = 0;
            foreach ($config as $array) {
                echo "<h2>Ihre Kuchenkreation</h2>";
                foreach ($array as $item) {
                    echo "<h3>Kreation</h3>";
                    $teig = modFst4CartHelper::getDoughDes($item['Teigart']);
                    $form = modFst4CartHelper::getForm($item['Form']);
                    $fuelle = modFst4CartHelper::getConfigDetailDesc($item['Befuellung']);
                    $deko = modFst4CartHelper::getConfigDetailDesc($item['Dekoration']);
                    $verp = modFst4CartHelper::getDesc($item['Verpackung']);
                    //$abmessung = modFst4CartHelper::getDesc($item['Abmessung']);
                    $preis = $item['Gesamtpreis'];
                    ?>
                    <div id="cakeConfigBox<?php echo $k ?>" style="display: block">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Teigart: <?php echo $teig ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Form: <?php echo $form ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Füllung: <?php echo $fuelle ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Deko: <?php echo $deko ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Verpackung: <?php echo $verp ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Preis: <label id="cakeConfigPrice<?php echo $k ?>"><?php echo $preis ?></label>€
                            </li>
                        </ul>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <button id="removeConfigFromCartBtn" class="btn_fp_btn_back cakeConfigBtn<?php echo $k ?>">Produkt löschen</button>
                        </li>
                    </div>
                    <?php
                    $k++;
                }
            }
        }if ($packageControl == 1) {
            $j = 0;
            foreach ($packageconifg as $array) {
                echo "<h2>Ihre Geschenkspakete</h2>";
                for ($i = 0; $i < count($array); $i++) {
                    $sum = 0;
                    ?><div id="packageConfigBox<?php echo $j ?>" style="display: block"> <?php
                    echo"<h3>Geschenkspaket</h3>";
                    echo "<ul class='list-group list-group-flush'>";
                    foreach ($array[$i] as $cake) {
                        $sum += modFst4CartHelper::getPrice($cake) * 0.85
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo modFst4CartHelper::getDesc($cake) ?>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo modFst4CartHelper::getPrice($cake) * 0.85 ?>€
                            </li>
                        <?php }
                        ?>
                        <li class = "list-group-item d-flex justify-content-between align-items-center">
                            <button id = "removePackageConfigFromCartBtn" class = "btn_fp_btn_back packageConfigBtn<?php echo $j ?>">Produkt löschen</button>
                        </li>
                        <?php
                        echo "Summe: <label id='packageConfigPrice" . $j . "'>" . $sum . "</label>€";
                        echo"</ul></div>";
                    }
                }
            }
            ?>
        </div>
        <?php
        echo "Gesamtsumme: <label id='overallSum'>" . $compSum . "</label>€<br/>";
        echo "Gesamtanzahl: <label id='overallAmount'>" . $compAmount . "</label><br/>";
        if ($control == 0 && $configcontrol == 0 && $packageControl == 0) {
            echo'<button type="button" id="checkoutBtn" disabled>Zur Kassa</button>';
        } else {
            echo'<button type="button" id="checkoutBtn" class="btn_fp_btn_all">Zur Kassa</button>';
        }
        ?>
    </div>
    <div id="CheckoutDiv" style="display: none">
        <h1>Kassa</h1>
        <h2>Ihre Bestellung</h2>
        <?php
        if ($control == 1) {
            foreach ($cart['items'] as $product) {
                if ($product['type'] == "Product") {
                    $desc = modFst4CartHelper::getDesc($product['id']);
                    $quant = $product['quantity'];
                    $pic = modFst4CartHelper::getPic($product['id']);
                    $price = modFst4CartHelper::getPrice($product['id']);
                } else if (strpos($product['type'], "voucher") !== false) {
                    $desc = "Gutschein";
                    $quant = $product['quantity'];
                    $price = $product['id'];
                    $pic = modFst4CartHelper::getPic($product['type']);
                } else if ($product['type'] == "package") {
                    $desc = modFst4CartHelper::getPackageDesc($product['id']);
                    $pic = modFst4CartHelper::getPackagePic($product['id']);
                    $price = modFst4CartHelper::getPackagePrice($product['id']);
                    $quant = $product['quantity'];
                }
                ?>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $desc ?>
                        <span class="badge badge-primary badge-pill"><?php echo $quant ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <img src="<?php echo $pic ?>" height ="100" widht ="150"/>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Preis: <?php echo $price ?>€
                    </li>
                </ul>
                <?php
            }
        }if ($configcontrol == 1) {
            foreach ($config as $array) {
                echo "<h3>Kreation</h3>";
                foreach ($array as $item) {
                    $teig = modFst4CartHelper::getDoughDes($item['Teigart']);
                    $form = modFst4CartHelper::getForm($item['Form']);
                    $fuelle = modFst4CartHelper::getConfigDetailDesc($item['Befuellung']);
                    $deko = modFst4CartHelper::getConfigDetailDesc($item['Dekoration']);
                    $verp = modFst4CartHelper::getDesc($item['Verpackung']);
                    //$abmessung = modFst4CartHelper::getDesc($item['Abmessung']);
                    $preis = $item['Gesamtpreis'];
                    ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Teigart: <?php echo $teig ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Form: <?php echo $form ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Füllung: <?php echo $fuelle ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Deko: <?php echo $deko ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Verpackung: <?php echo $verp ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Preis: <?php echo $preis ?>€
                        </li>
                    </ul>
                    <?php
                }
            }
        } if ($packageControl == 1) {
            foreach ($packageconifg as $array) {
                for ($i = 0; $i < count($array); $i++) {
                    $sum = 0;
                    echo"<h3>Geschenkspaket</h3>";
                    echo "<ul class='list-group list-group-flush'>";
                    foreach ($array[$i] as $cake) {
                        $sum += modFst4CartHelper::getPrice($cake) * 0.85
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo modFst4CartHelper::getDesc($cake) ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo round(modFst4CartHelper::getPrice($cake) * 0.85, 2) ?>€
                        </li>
                        <?php
                    }
                    echo "Summe: " . round($sum, 2) . "€";
                    echo"</ul>";
                }
            }
        }
        ?>
        Gesamtanzahl: <label><?php echo $compAmount ?></label><br/>
        <!--Summe von fertigen Kuchen: <label><?php echo modFst4CartHelper::getCakeSum(); ?></label><br/>
        Summe von Geschenkspaketen: <label><?php echo modFst4CartHelper::getPackageSum(); ?></label><br/>
        Summe von Gutscheinen: <label><?php echo modFst4CartHelper::getVoucherSum(); ?></label><br/>
        Summe von konfigurierten Kuchen: <label><?php echo modFst4CartHelper::getConfigSum(); ?></label><br/>
        Summe von konfigurierten Geschenkspaketen: <label><?php echo modFst4CartHelper::getPackageConfigSum(); ?></label><br/>-->
        <div id="insertVoucherDiv" style="display: none">
            - eingelöster Gutschein <label id="voucherPrice">0</label>€
        </div>
        Gesamtsumme: <label id="compSum"><?php echo round($compSum, 2) ?></label>€<br/>
        <?php if ($user == 0) {
            ?>
            <div>
                <p>Bitte legen Sie einen Account an oder melden Sie sich an, um den Bestellvorgang beenden zu können.</P>
                <a href="http://wi-gate.technikum-wien.at:60336/index.php/anmeldung">Zur Anmeldung</a>
            </div>
        <?php } else {
            ?>
            <input id="voucher_input" placeholder="Gutscheincode"/><button class="btn_fp_btn_back" id="addVoucherBtn">Gutschein einlösen</button><br/>
            Lieferdatum auswählen: <input id="deliveryDate" type="date"/>
            <h2>Zahlungsmethode</h2>
            <form>
                <fieldset>
                    <image src="../images/etc/paypal.png" height="40" width="50"/>
                    <input type="radio" name="payment" id="payment" value="paypal"/>
                    <image src="../images/etc/visa.gif" height="40" width="50"/>
                    <input type="radio" name="payment" id="payment" value="visa"/>
                    <image src="../images/etc/mastercard.png" height="40" width="50"/>
                    <input type="radio" name="payment" id="payment" value="mastercard"/>
                </fieldset>
            </form>
            <div id="creditCardDiv" style="display: none">
                <form>
                    <label>Karteninhaber</label>
                    <input type="text"/>
                    <label>Kartennummer</label>
                    <input type="text"/>
                    <label>Gültig bis </label>
                    <input type="text"/>
                    <label>CVC</label>
                    <input type="text"/>
                </form>
            </div>
            <div id="payPalDiv" style="display: none">
                <p>Sie werden anschließend zu Paypal weitergeleitet.</p>
            </div>
            <div>
                <h2>Rechnungsadresse</h2>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputFirstname">Vorname</label>
                            <input type="text" class="form-control" id="inputFirstname" value="<?php echo $user[0]['firstname'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputLastname">Nachname</label>
                            <input type="text" class="form-control" id="inputLastname" value="<?php echo $user[0]['lastname'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Adresse</label>
                        <input type="text" class="form-control" id="inputAddress" value="<?php echo $user[0]['street'] ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Stadt</label>
                            <input type="text" class="form-control" id="inputCity" value="<?php echo $user[0]['name'] ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Postleitzahl</label>
                            <input type="text" class="form-control" id="inputZip" value="<?php echo $user[0]['zip_code'] ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Land</label>
                            <input type="text" class="form-control" id="inputState" value="<?php echo $user[0]['country'] ?>">
                        </div>
                    </div>
                </form>
                <label for = "billAddress">Lieferadresse weicht von Rechnungsadresse ab </label>
                <input type = "checkbox" name = "billAddress" id="billAddressChbx" />
                <div id="billAddressDiv">
                </div>
            </div>
        <?php } ?>
        <div id="AlterAddress" style="display: none">
            <div class="form-group col-md-12">
                <h1 class="well">Lieferadresse</h1>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputFirstname">Vorname</label>
                            <input type="text" class="form-control" id="inputFirstname" placeholder="Max">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputLastname">Nachname</label>
                            <input type="text" class="form-control" id="inputLastname" placeholder="Musterfrau">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputAddress">Adresse</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Musterstraße 35" width="80%">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputCity">Stadt</label>
                            <input type="text" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Postleitzahl</label>
                            <input type="text" class="form-control" id="inputZip">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Land</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>Österreich</option>
                                <option>Schweiz</option>
                                <option>Deutschland</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="fp_btn_back">
                <a class="fp_btn_back" href="index.php/warenkorb" role="button">Zurück</a>
            </div>
            <button id="orderBtn" data-toggle="modal" data-target="#pwModal" disabled class="btn_fp_btn_all">Jetzt Bestellen!</button>
        </div>

        <div class="modal fade" id="pwModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Danke für Ihre Bestellung!</h5>
                    </div>
                    <div class="modal-body">
                        <p>Sie finden Ihre Bestellung unter "Mein Account".</p>
                    </div>
                </div>
            </div>
        </div>



    </div>
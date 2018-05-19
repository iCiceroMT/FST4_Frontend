<?php
/**
 * @package         Fst4-Product.Module
 * @subpackage      mod_fst4_product
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;

?>
<div><h1>Gutschein erstellen</h1>
    <p>Wählen Sie eine Verpackung aus und geben Sie einen Wert ein</p>
    <p>
    <form>
        <!--ID FÜR GUTSCHEINVERPACKUNG WIRD AN WARENKORB ÜBERGEBEN UND DORT DARGESTELLT, NICHT IN DB GESPEICHERT-->
        <fieldset>
            <p>
            <image src="https://cdn-ec.niceshops.com/upload/image/product/large/default/eccoverde-geburtstag-download-gutschein-1-stk-963177-de.jpg" width="200" height="100"/>
            <input type="radio" id="geb" name="Verpackung" value="Geburtstag"/>
            <label for="geb"> Geburtstag</label>
            </p>
            <P>
            <image src="https://de-assets.personello.com/gutscheine/gutschein-muttertag/collage-1294-gutschein-col4.jpg" width="200" height="100"/>
            <input type="radio" id="mutt" name="Verpackung" value="Muttertag"/>
            <label for="mutt"> Muttertag</label>
            </P>
            <p>
            <image src="https://www.cake-stuff.com/images/vouchers/1496244592gift_vouchers3.jpg" width="200" height="100"/>
            <input type="radio" id="cake" name="Verpackung" value="Kuchen"/>
            <label for="cake"> Blumen</label>
            </p>
        </fieldset>
        <label for="value">Wert: </label>
        <input id="voucherValue" name="Wert"/>
        <input id="type" type="hidden" value="voucher"/>
        <button type="button" id="addToCartBtn" >Zum Warenkorb hinzufügen</button>

    </form> </p>
</div>
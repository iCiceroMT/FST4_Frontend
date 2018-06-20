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
<div><h1>Gutscheine</h1>  
    <div display="inline"> 
        <?php for ($i = 1; $i < 4; $i++) { ?>
            <div class="col-md-4" class="gutscheine">  
                <!-- <label for="geb" class="Gutscheinbeschreibung"> Geburtstag</label><br>-->
                <image class="gutscheinBilder" src="../images/artikelbilder/voucher/voucher<?php echo $i ?>.jpg"  /><br> 
                <form>
                    <div class="form-group voucher_formgroup">
                        <!-- <label for="voucher_value">Wert: </label>-->
                        <input type="number" class="form-control" id="amount<?php echo $i?>" placeholder="Anzahl (Stück)" value="1"><br>
                        <input type="number" class="form-control" id="value_voucher<?php echo $i?>" placeholder="Gutscheinwert in €">
                        </form>
                        <div class="fp_btn_all">
                            <a type="voucher<?php echo $i ?>" id="addVoucherToCartBtn" >Zum Warenkorb hinzufügen</a>
                        </div>
                    </div>
            </div>
        <?php } ?>
</div>

</div>
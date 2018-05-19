<?php
/**
 * @package         Fst4-Cart.Module
 * @subpackage      mod_fst4_cart
 * @copyright       Copyright (C) 2018 Bernhauser All rights reserved.
 * @license         GNU General Public License version 2 or later;
 */
// no direct access
defined('_JEXEC') or die;

$session = JFactory::getSession();
$cart = array();

$cart['items'][] = array(
    'id' => 1,
    'type' => "voucher",
    'quantity' => 5);
$cart['items'][] = array(
    'id' => 3,
    'type' => "voucher",
    'quantity' => 5);

$session->set('cart', $cart);

$cart = $session->get('cart');


?>
<div><h1>Warenkorb</h1>
    <h2>Ihre Produkte</h2>
    <?php
    $summAmount = 0;
    foreach ($cart as $array) {
        foreach ($array as $product) {
            echo"<li>Produkt-Nr.:".$product['id']."</li>";
            
            echo"<li>Produkt-Typ:".$product['type']."</li>";
            echo"<li>Anzahl:".$product['quantity']."</li>";
            echo"--------------------------";
            $summAmount += $product['quantity'];
        }
    }
    echo"<br/>Gesamtanzahl: ".$summAmount;
    ?>
</div>
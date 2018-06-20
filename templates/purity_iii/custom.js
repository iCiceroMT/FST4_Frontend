
//Hier wird custom_ritschi.js eingebunden
var script = document.createElement("script"); // Make a script DOM node
script.src = "../templates/purity_iii/custom_ritschi.js"; // Set it's src to the provided URL
var script1 = document.createElement("script");
script1.src = "../templates/purity_iii/js/notify.js";
document.head.appendChild(script);
document.head.appendChild(script1);
////////////////////////////////////


jQuery(function ($) {


    $('.auswahlpic').hover(function () {


        $(this).addClass('transition_auswahlpic');
    }, function () {
        $(this).removeClass('transition_auswahlpic');
    });
//Wenn Startseite geladen, dann Produktinfo in Container
    /* $.ajax({
     url: "index.php?option=com_ajax&ignoreMessages&module=fst4_product&method=getArticles&format=json&Itemid=101",
     method: "POST",
     data: {
     product_name: "product", // Second add quotes on the value.
     },
     success: function (response) {
     
     $("#main_product_load").load("../modules/mod_fst4_product/tmpl/fertigeKuchen.php", {items: response['data']});
     
     },
     error: function (xhr, textStatus, error) {
     console.log(xhr.statusText);
     console.log(textStatus);
     console.log(error);
     }
     
     });*/


    $("#apic1").click(function () {


        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_product&method=getArticles&format=json&Itemid=101",
            method: "POST",
            data: {
                product_name: "product", // Second add quotes on the value.
            },
            success: function (response) {

                $("#main_product_load").load("../modules/mod_fst4_product/tmpl/fertigeKuchen.php", {items: response['data']});
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });
    $("#apic2").click(function () {
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_product&method=getPackages&format=json&Itemid=101",
            method: "POST",
            data: {
                product_name: "product", // Second add quotes on the value.
            },
            success: function (response) {

                $("#main_product_load").load("../modules/mod_fst4_product/tmpl/Pakete.php", {items: response['data']});
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });
    //Gutschein   


    $("#addVoucherToDBtn").click(function () {
        console.log("uu");
        var voucherValue = document.getElementById("voucherValue").value;
        jQuery.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_voucher&method=insertNewVoucher&format=json&Itemid=107",
            method: "POST",
            data: {
                value: voucherValue
                        // Second add quotes on the value.
            },
            success: function (response) {

                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;

                console.log(response);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });
    
    $(document).on("click", "#addVoucherToCartBtn", function () {
        var type = jQuery(this).attr('type');
        var id = type.slice(-1);
        console.log(id);
        var amount = document.getElementById("amount".concat(id)).value;
        var value = document.getElementById("value_voucher".concat(id)).value;
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=addToCart&format=json&Itemid=117",
            method: "POST",
            data: {
                id: value,
                type: type,
                amount: amount,
                wrapping: null
                        // Second add quotes on the value.
            },
            success: function (response) {

                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });
    $(document).on("click", "#addToCartBtn", function () {
        var id = jQuery(this).attr('item_id');
        var type = jQuery(this).attr('type');
        if (!document.getElementById('amount')) {
            var amount = 1;
        } else {
            var amount = document.getElementById("amount").value;
        }
        var wrapping = jQuery(this).attr('verp_id');
        console.log(id);
        console.log(type);
        console.log(amount);
        jQuery.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=addToCart&format=json&Itemid=117",
            method: "POST",
            data: {
                id: id,
                type: type,
                amount: amount,
                wrapping: wrapping,
                // Second add quotes on the value.
            },
            success: function (response) {

                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });
    $(document).on("click", "#addAmountBtn", function () {
        var id = document.getElementById("prodId").value;
        var amount = 1;
        var boxid = jQuery(this).attr('class');
        boxid = boxid.slice(-1);
        var productQuant = 'prodQuant'.concat(boxid);
        var productPrice = 'productPrice'.concat(boxid);
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=changeAmount&format=json&Itemid=117",
            method: "POST",
            data: {
                id: id,
                amount: amount
                        // Second add quotes on the value.
            },
            success: function (response) {
                console.log(response);
                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                var amount = parseInt(document.getElementById(productQuant).innerHTML);
                amount += 1;
                var compAmount = parseInt(document.getElementById("overallAmount").innerHTML);
                compAmount += 1;
                var productPrc = parseFloat(document.getElementById(productPrice).innerHTML);
                var compSum = parseInt(document.getElementById("overallSum").innerHTML);
                compSum += productPrc;
                document.getElementById(productQuant).innerHTML = amount;
                document.getElementById("overallAmount").innerHTML = compAmount;
                document.getElementById("overallSum").innerHTML = compSum;
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });

    $(document).on("click", "#decrementAmountBtn", function () {
        var id = document.getElementById("prodId").value;
        var amount = -1;
        var boxid = jQuery(this).attr('class');
        boxid = boxid.slice(-1);
        var productQuant = 'prodQuant'.concat(boxid);
        var productPrice = 'productPrice'.concat(boxid);
        var productBox = 'productBox'.concat(boxid);
        jQuery.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=changeAmount&format=json&Itemid=117",
            method: "POST",
            data: {
                id: id,
                amount: amount
                        // Second add quotes on the value.
            },
            success: function (response) {
                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
                var amount = parseInt(document.getElementById(productQuant).innerHTML);
                amount -= 1;
                if (amount <= 0) {
                    document.getElementById(productBox).style.display = "none";
                }
                var compAmount = parseInt(document.getElementById("overallAmount").innerHTML);
                compAmount -= 1;
                if (compAmount <= 0) {
                    compAmount = 0;
                }
                var productPrc = parseFloat(document.getElementById(productPrice).innerHTML);
                var compSum = parseInt(document.getElementById("overallSum").innerHTML);
                compSum -= productPrc;
                document.getElementById(productQuant).innerHTML = amount;
                document.getElementById("overallAmount").innerHTML = compAmount;
                document.getElementById("overallSum").innerHTML = compSum;
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });

    $(document).on("click", "#removeVoucherFromCartBtn", function () {
        //GET AMOUNT das gelöscht wird
        var id = document.getElementById("voucherId").value;
        var boxid = jQuery(this).attr('class');
        boxid = boxid.slice(-1);
        var productBox = 'voucherBox'.concat(boxid);
        console.log(id);
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=removeFromCart&format=json&Itemid=117",
            method: "POST",
            data: {
                id: id,
                // Second add quotes on the value.
            },
            success: function (response) {
                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
                console.log(productBox);
                document.getElementById(productBox).style.display = "none";
                var productAmount = parseInt(document.getElementById("voucherQuantity").innerHTML);
                console.log(productAmount);
                var overallAmount = parseInt(document.getElementById("overallAmount").innerHTML);
                console.log(overallAmount);
                overallAmount -= productAmount;
                console.log(overallAmount);
                var productPrice = parseFloat(document.getElementById("voucherId").value);
                var compSum = parseInt(document.getElementById("overallSum").innerHTML);
                compSum -= productPrice * productAmount;
                document.getElementById("overallAmount").innerHTML = overallAmount;
                document.getElementById("overallSum").innerHTML = compSum;
                //gesamtanzahl innerhtml - amount
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });

    $(document).on("click", "#removeFromCartBtn", function () {
        //GET AMOUNT das gelöscht wird
        var id = document.getElementById("prodId").value;
        var boxid = jQuery(this).attr('class');
        boxid = boxid.slice(-1);
        var productBox = 'productBox'.concat(boxid);
        console.log(id);
        var productQuant = 'prodQuant'.concat(boxid);
        var productPrice = 'productPrice'.concat(boxid);
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=removeFromCart&format=json&Itemid=117",
            method: "POST",
            data: {
                id: id,
                // Second add quotes on the value.
            },
            success: function (response) {
                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
                console.log(productBox);
                document.getElementById(productBox).style.display = "none";
                var productAmount = parseInt(document.getElementById(productQuant).innerHTML);
                var overallAmount = parseInt(document.getElementById("overallAmount").innerHTML);
                var productPrce = parseFloat(document.getElementById(productPrice).innerHTML);
                var compSum = parseInt(document.getElementById("overallSum").innerHTML);
                compSum -= productPrce * productAmount;
                overallAmount -= productAmount;
                document.getElementById("overallAmount").innerHTML = overallAmount;
                document.getElementById("overallSum").innerHTML = compSum;
                //gesamtanzahl innerhtml - amount
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });

    $(document).on("click", "#removePackageConfigFromCartBtn", function () {
        //GET AMOUNT das gelöscht wird
        //var id = document.getElementById("prodId").value;
        var boxid = jQuery(this).attr('class');
        boxid = boxid.slice(-1);
        var productBox = 'packageConfigBox'.concat(boxid);
        var productPrice = 'packageConfigPrice'.concat(boxid);
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=removePackageFromCart&format=json&Itemid=117",
            method: "POST",
            data: {
                id: boxid,
                // Second add quotes on the value.
            },
            success: function (response) {
                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
                console.log(productBox);
                document.getElementById(productBox).style.display = "none";
                var overallAmount = parseInt(document.getElementById("overallAmount").innerHTML);
                var productPrce = parseFloat(document.getElementById(productPrice).innerHTML);
                var compSum = parseFloat(document.getElementById("overallSum").innerHTML);
                compSum -= productPrce;
                overallAmount -= 1;
                document.getElementById("overallAmount").innerHTML = overallAmount;
                document.getElementById("overallSum").innerHTML = compSum;
                //gesamtanzahl innerhtml - amount
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });

    $(document).on("click", "#removeConfigFromCartBtn", function () {
        //GET AMOUNT das gelöscht wird
        //var id = document.getElementById("prodId").value;
        var boxid = jQuery(this).attr('class');
        boxid = boxid.slice(-1);
        var productBox = 'cakeConfigBox'.concat(boxid);
        var cakeConfigPrice = 'cakeConfigPrice'.concat(boxid);

        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=removeCakeConfigFromCart&format=json&Itemid=117",
            method: "POST",
            data: {
                id: boxid,
                // Second add quotes on the value.
            },
            success: function (response) {
                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
                console.log(productBox);
                var overallAmount = parseInt(document.getElementById("overallAmount").innerHTML);
                var productPrce = parseFloat(document.getElementById(cakeConfigPrice).innerHTML);
                console.log(cakeConfigPrice);
                var compSum = parseInt(document.getElementById("overallSum").innerHTML);
                compSum -= productPrce;
                overallAmount -= 1;
                document.getElementById("overallAmount").innerHTML = overallAmount;
                document.getElementById("overallSum").innerHTML = compSum;
                document.getElementById(productBox).style.display = "none";
                //gesamtanzahl innerhtml - amount
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });

    //TO DO LÖSCHEN VON KREATIONEN 4x

    $("#checkout_load").on("click", "#billAddressChbx", function () {
        alert("success");
    });
    $("#checkoutBtn").click(function () {
        document.getElementById("ShopppingCartDiv").style.display = "none";
        document.getElementById("CheckoutDiv").style.display = "block";
    });
    $("#billAddressChbx").click(function () {
        var checkboxStyle = document.getElementById("AlterAddress").style;
        console.log(checkboxStyle);
        if (checkboxStyle.display == "none") {
            checkboxStyle.display = "block";
        } else {
            checkboxStyle.display = "none";
        }
    });
    $("input[name=packageCakes]").change(function () {
        var checked = document.getElementsByName("packageCakes");
        var prices = document.getElementsByName("cakePrices");
        var sum = 0;
        for (var i = 0, length = checked.length; i < length; i++) {
            if (checked[i].checked) {
                var price = parseFloat(prices[i].innerHTML);
                sum += price;
            }
        }
        document.getElementById("completeSum").innerHTML = sum;
    });
    $("#addToPackageToCartBtn").click(function () {
        var data = [];
        var cakes = document.getElementsByName("packageCakes");
        for (var i = 0, length = cakes.length; i < length; i++) {
            if (cakes[i].checked) {
                data.push(cakes[i].value);
            }
        }
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_package&method=addToCart&format=json&Itemid=106",
            method: "POST",
            data: {
                data: data,
                // Second add quotes on the value.
            },
            success: function (response) {
                //  <p>Erfolgreich zum Warenkorb hinzugefügt</p>;
                console.log(response);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });
    $("input:radio[id=payment]").click(function () {
        document.getElementById("orderBtn").disabled = false;
        var radios = document.getElementsByName("payment");
        var pay = "";
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                pay = radios[i].value;
                break;
            }
        }
        if (pay == "paypal") {
            document.getElementById("creditCardDiv").style.display = "none";
            document.getElementById("payPalDiv").style.display = "block";
        } else if (pay == "visa") {
            document.getElementById("payPalDiv").style.display = "none";
            document.getElementById("creditCardDiv").style.display = "block";
        } else if (pay == "mastercard") {
            document.getElementById("payPalDiv").style.display = "none";
            document.getElementById("creditCardDiv").style.display = "block";
        }
    });
    $("a#RegLink").click(function () {
        document.getElementById("LoginDiv").style.display = "none";
        document.getElementById("RegDiv").style.display = "block";
    });
    $("#preMadePackages").click(function () {
        document.getElementById("overview").style.display = "none";
        document.getElementById("packageList").style.display = "block";
    });
    $("#selfMadePackages").click(function () {
        document.getElementById("overview").style.display = "none";
        document.getElementById("packageConf").style.display = "block";
    });

    $("#addVoucherBtn").click(function () {
        var voucherCode = document.getElementById("voucher_input").value;
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=getVoucherValue&format=json&Itemid=117",
            method: "POST",
            data: {
                voucherCode: voucherCode,
                // Second add quotes on the value.
            },
            success: function (response) {
                var value = response.data['amount'];
                var sum = document.getElementById("compSum").innerHTML;
                var newSum = sum - value;
                document.getElementById("compSum").innerHTML = newSum.toFixed(2);
                document.getElementById("voucherPrice").innerHTML = value.toFixed(2);
                document.getElementById("insertVoucherDiv").style.display = "block";
                document.getElementById("addVoucherBtn").disabled = true;
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });

    $("#orderBtn").click(function () {
        var deliveryDate = document.getElementById('deliveryDate').value;
        var totalAmount = document.getElementById('compSum').innerHTML;
        var voucherId = document.getElementById('voucher_input').value;
        if (voucherId == "" || voucherId == null) {
            voucherId = null;
        }
        $.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=checkout&format=json&Itemid=117",
            method: "POST",
            data: {
                deliveryDate: deliveryDate,
                totalAmount: totalAmount,
                voucherId: voucherId
                // Second add quotes on the value.
            },
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });


});
function showDetailOfPackage(aid) {
    jQuery.ajax({
        url: "index.php?option=com_ajax&ignoreMessages&module=fst4_package&method=getPackageDetail&format=json&Itemid=106",
        method: "POST",
        data: {
            id: aid // Second add quotes on the value.
        },
        success: function (response) {
            jQuery("#packageList").load("../modules/mod_fst4_package/tmpl/packageDetail.php", {pdetails: response['data']});
        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
}



////////////////////////////////






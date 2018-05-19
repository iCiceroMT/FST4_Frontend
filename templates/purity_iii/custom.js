
//Hier wird custom_ritschi.js eingebunden
var script = document.createElement("script"); // Make a script DOM node
script.src = "../templates/purity_iii/custom_ritschi.js"; // Set it's src to the provided URL
document.head.appendChild(script);
////////////////////////////////////


jQuery(function ($) {

    $('.auswahlpic').hover(function () {


        $(this).addClass('transition_auswahlpic');

    }, function () {
        $(this).removeClass('transition_auswahlpic');
    });

//Wenn Startseite geladen, dann Produktinfo in Container
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
        console.log("btn pressed");
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
    
    jQuery("#addToCartBtn").click(function () {
        console.log("btn pressed");
        var type = document.getElementById("type").value;
        var id = document.getElementById("id").value;
        var amount = document.getElementById("amount").value;
        jQuery.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_cart&method=addToCart&format=json&Itemid=117",
            method: "POST",
            data: {
                type: type,
                id: id,
                amount: amount
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


    //alert(document.getElementById("voucherValue").value); 



    $("a#RegLink").click(function () {
        document.getElementById("LoginDiv").style.display = "none";
        document.getElementById("RegDiv").style.display = "block";
    });


    $("#loginBtn").click(function () {
        console.log("btn pressed");
        var user = document.getElementById("mail").value;
        var passwrd = document.getElementById("passwd").value;
        jQuery.ajax({
            url: "index.php?option=com_ajax&ignoreMessages&module=fst4_login&method=login&format=json&Itemid=108",
            method: "POST",
            data: {
                user: user,
                pw: passwrd
                        // Second add quotes on the value.
            },
            success: function (response) {
                //TO DO call function
                //to do nav bar anpassen

            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }

        });
    });


/////////////////////////////////
});

////////////////////////////////






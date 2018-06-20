
jQuery('.do_product_detail').click(function () {


    var aid = jQuery(this).attr('id');

   

    jQuery.ajax({
        url: "index.php?option=com_ajax&ignoreMessages&module=fst4_product&method=getArticleDetail&format=json&Itemid=101",
        method: "POST",

        data: {
            id: aid
            // Second add quotes on the value.
        },
        success: function (response) {

            jQuery("#main_product_load").load("../modules/mod_fst4_product/tmpl/productDetail.php", {pdetails: response['data']});

        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
});

jQuery("#selectpdetail_verp").live('change', function () {
    var verp_id = jQuery("#selectpdetail_verp").find(":selected").val();
    jQuery("#addToCartBtn").attr({verp_id: verp_id});
    jQuery('#addToCartBtn').removeClass('btn_fp_btn_all_disabled')
    jQuery('#addToCartBtn').addClass('btn_fp_btn_all');
    if(verp_id == "0"){
        jQuery('#addToCartBtn').removeClass('btn_fp_btn_all')
    jQuery('#addToCartBtn').addClass('btn_fp_btn_all_disabled');
    }
});


function showDetailsPackage(aid) {
    jQuery.ajax({
        url: "index.php?option=com_ajax&ignoreMessages&module=fst4_product&method=getPackageDetail&format=json&Itemid=101",
        method: "POST",

        data: {
            id: aid // Second add quotes on the value.
        },
        success: function (response) {

            jQuery("#main_product_load").load("../modules/mod_fst4_product/tmpl/packageDetail.php", {pdetails: response['data']});

        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
}

//notifys
function notifyMeGreen(msg) {
    $.notify(msg);

}

jQuery(function ($) {





    $('button.notifytest').click(function () {
        alertify.error('Error notification message.');
    });
});
//nav for user adm

jQuery('#usadm_allg').click(function () {
    jQuery('#usadm_allg').addClass('active');
    jQuery('#usadm_bestDat').removeClass('active');
    jQuery('#usadm_persDat').removeClass('active');
    jQuery('#usadm_rezDat').removeClass('active');
    jQuery('#usadm_verpDat').removeClass('active');
    jQuery('#usadm_allg_div').css("display", "block");
    jQuery('#usadm_persDat_div').css("display", "none");
    jQuery('#usadm_best_div').css("display", "none");
    jQuery('#usadm_rez_div').css("display", "none");
    jQuery('#usadm_verp_div').css("display", "none");
});

jQuery('#usadm_persDat').click(function () {

    jQuery('#usadm_allg').removeClass('active');
    jQuery('#usadm_bestDat').removeClass('active');
    jQuery('#usadm_persDat').addClass('active');
    jQuery('#usadm_rezDat').removeClass('active');
    jQuery('#usadm_verpDat').removeClass('active');
    jQuery('#usadm_allg_div').css("display", "none");
    jQuery('#usadm_best_div').css("display", "none");
    jQuery('#usadm_persDat_div').css("display", "block");
    jQuery('#usadm_rez_div').css("display", "none");
    jQuery('#usadm_verp_div').css("display", "none");
});

jQuery('#usadm_bestDat').click(function () {

    jQuery('#usadm_allg').removeClass('active');
    jQuery('#usadm_persDat').removeClass('active')
    jQuery('#usadm_bestDat').addClass('active');
    jQuery('#usadm_rezDat').removeClass('active');
    jQuery('#usadm_verpDat').removeClass('active');
    jQuery('#usadm_allg_div').css("display", "none");
    jQuery('#usadm_persDat_div').css("display", "none");
    jQuery('#usadm_best_div').css("display", "block");
    jQuery('#usadm_rez_div').css("display", "none");
    jQuery('#usadm_verp_div').css("display", "none");
});

jQuery('#usadm_rezDat').click(function () {

    jQuery('#usadm_allg').removeClass('active');
    jQuery('#usadm_persDat').removeClass('active')
    jQuery('#usadm_bestDat').removeClass('active');
    jQuery('#usadm_rezDat').addClass('active');
    jQuery('#usadm_verpDat').removeClass('active');
    jQuery('#usadm_allg_div').css("display", "none");
    jQuery('#usadm_persDat_div').css("display", "none");
    jQuery('#usadm_best_div').css("display", "none");
    jQuery('#usadm_rez_div').css("display", "block");
    jQuery('#usadm_verp_div').css("display", "none");
});

jQuery('#usadm_verpDat').click(function () {

    jQuery('#usadm_allg').removeClass('active');
    jQuery('#usadm_persDat').removeClass('active')
    jQuery('#usadm_bestDat').removeClass('active');
    jQuery('#usadm_rezDat').removeClass('active');
    jQuery('#usadm_verpDat').addClass('active');
    jQuery('#usadm_allg_div').css("display", "none");
    jQuery('#usadm_persDat_div').css("display", "none");
    jQuery('#usadm_best_div').css("display", "none");
    jQuery('#usadm_rez_div').css("display", "none");
    jQuery('#usadm_verp_div').css("display", "block");
});



//Kuchenkonfigurator
jQuery(".recipe_selectbox").live('change', function () {

    //get ID from selectbox
    var x = this.className;

    var id = x.substr(x.length - 1);
    //get ingredient ID from selection
    var ingid = this.value;
    //get unit and price & write generate things

    jQuery.ajax({
        url: "index.php?option=com_cakeconfig&task=getUnit&format=raw",
        method: "POST",

        data: {
            id: ingid // Second add quotes on the value.
        },
        success: function (response) {
            var anz = document.forms["recipe_form"].getElementsByTagName("select").length;

            var x = JSON.parse(response);
            var unit = x[0]['unit'];
            var price = x[0]['price'];
            
            var unit2 = unit;
            var price2 = price;
            if(unit == 'g'){unit2 = "kg"; price2 = price * 1000;price2 = (Math.round(price2 * 100) / 100);}
            if(unit == 'ml'){unit2 = "l"; price2 = price * 1000;price2 = (Math.round(price2 * 100) / 100);}

            jQuery(".unit_" + anz).empty();
            jQuery(".unit_" + anz).append(unit);
            var z = jQuery(".amount_" + anz).val();
            var amount = 0;
            if (z != "") {
                amount = z * price;
            }
            var price_txt = amount + " (" + price2 + "€ / " + unit2 + ")";
            jQuery(".price_" + anz).empty();
            jQuery(".price_" + anz).append(price_txt);

        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
    //btn prüfen

    checkRecipeButton();
});

jQuery("#sonderwunsch").live('change', function () {
    var text = jQuery(this).val();
    if(text.length > 0){jQuery("#sonder").show();
       var check =  jQuery("#sonderpreis").text().charAt(0);
      
       if(check == 0){
           jQuery("#sonderpreis").text("20 €");
           var newprice = jQuery("#gpreis").text();
           newprice = newprice.substr(0, newprice.indexOf(' ')); 
           
           var tmp = +newprice + +20;
           jQuery("#gpreis").text(tmp + " €");
       }
    
    }else{
        jQuery("#sonder").hide();
    jQuery("#sonderpreis").text("0 €");
    var newprice = jQuery("#gpreis").text();
           newprice = newprice.substr(0, newprice.indexOf(' ')); 
           
           var tmp = +newprice - +20;
           jQuery("#gpreis").text(tmp + " €");
    }
    
});

jQuery("#recipe_amount").live('change', function () {
    //var anz = document.forms["recipe_form"].getElementsByTagName("select").length;
    var bez = jQuery(this).attr('class');
    var anz = bez.substr(bez.length - 1);
    var amount = jQuery(this).val();
    var txt = jQuery(".price_" + anz).text();
    var value = txt.substr(0, txt.indexOf(' '));
    var x = txt.substr(0, txt.indexOf('€'));
    var pos = x.indexOf('(') + 1;
    var price = x.substr(pos, x.length);
    var y = txt.indexOf('/') + 1;
    var z = txt.substr(y, txt.length);
    var unit = z.substr(0, z.length - 1);
    
    var price2 = price;
    if(unit.substr(unit.length-2,2) == "kg"){price = price / 1000; console.log(unit);}
    if(unit.substr(unit.length-1,1) == "l"){price = price / 1000; console.log(unit);}
    
    if (txt != "-") {

        var newprice = amount * price;
        newprice = (Math.round(newprice * 100) / 100);

        var price_txt = newprice + " (" + price2 + "€ / " + unit + ")";
        jQuery(".price_" + anz).empty();
        jQuery(".price_" + anz).append(price_txt);
    }
    //preis neu berechnen
    doPriceCalc();
});



//button add
jQuery("#recipe_addbtn").live('click', function () {
    //anzahl formeinträge holen
    var anz = document.forms["recipe_form"].getElementsByTagName("select").length;

    var anz2 = anz + 1;
    //versteckte row einfügen
    jQuery(".full_recipe_row").clone().addClass('clonedClass').appendTo(".recipe_fieldset");

    //row anzeigen
    jQuery(".clonedClass").show("slow");

    //alles andere umbenennen
    var select = "form-control recipe_selectbox select_" + anz2;
    var amount = "form-control input-md amount_" + anz2;
    var unit = "unit_" + anz2;
    var price = "price_" + anz2;
    jQuery(".clonedClass").find(".select_x").attr('class', select);

    jQuery(".clonedClass").find(".amount_x").attr('class', amount);
    jQuery(".clonedClass").find(".unit_x").attr('class', unit);
    jQuery(".clonedClass").find(".price_x").attr('class', price);
    //row umbenennen
    var newname = "row full_recipe_row_" + anz2;
    jQuery(".clonedClass").attr('class', newname);
    checkRecipeButton();
});

//button disable/enable wenn im letzten was drinnensteht
function checkRecipeButton() {
//anzahl der selects
    var x = document.forms["recipe_form"].getElementsByTagName("select").length;
//prüfen ob im letzten ein Eintrag ist
    var bez = ".select_" + x;
    var e = jQuery(bez).val();
    if (e == 0) {
        //btn disablen
        jQuery("#recipe_btn_box").removeClass("fp_btn_all");
        jQuery("#recipe_btn_box").addClass("btn_fp_btn_all_disabled");

    } else {
        jQuery("#recipe_btn_box").addClass("fp_btn_all");
        jQuery("#recipe_btn_box").removeClass("btn_fp_btn_all_disabled");
    }
}
;
//preisberechnung
function doPriceCalc() {
    //anzahl selectboxen
    var anz = document.forms["recipe_form"].getElementsByTagName("select").length;
    //preise addieren
    var zutatpreis = 0;
    for (var i = 1; i <= anz; i++) {
        var x = jQuery(".price_" + i).text();
        var y = x.substr(0, x.indexOf(' '));
        zutatpreis = +zutatpreis + +y;
    }
    //zutatengesamtpreis erstgellen
    jQuery("#gzutatpreis").empty();
    var z = zutatpreis + " €";
    jQuery("#gzutatpreis").append(z);
    //gesamtpreis erstellen
    var z1 = +zutatpreis + +30 + " €";
    jQuery("#gpreis").empty();
    jQuery("#gpreis").append(z1);
}

//Kuchenkreation JS
jQuery(".cakecreation_select").live('change', function () {
    //Daten einfügen
    var gesamt = 0;
    for (var i = 1; i <= 5; i++) {
        var x = ".selection_" + i;
        var y = jQuery(x + " option:selected").attr("price");
        var text = jQuery(x + " option:selected").text();
        jQuery("#p_cakecreation_" + i).empty();
        jQuery("#p_cakecreation_" + i).append(text);
        jQuery("#p_price_" + i).empty();
        jQuery("#p_price_" + i).append(y);
        if (i == 1 || i == 3 || i == 4 || i == 5) {
            gesamt = +gesamt + +y;
        }

    }
    //größe einbauen

    var gesamt2 = Math.round(gesamt * 100) / 100;
    jQuery("#p_price_6").empty();
    jQuery("#p_price_6").append(gesamt2);
});

//Kuchenkreation button
//Zeugs in eine Session schreiben und dann Kathrin-WK-Funktion triggern
//array erzeugen
jQuery(".cakeconf_cake_btn").click(function () {

    var data = [];
    for (var i = 1; i <= 5; i++) {
        var x = ".selection_" + i;
        data.push(jQuery(x + " option:selected").val());
    }
    data.push(jQuery("#p_price_6").text());

//ajax call um daten weiterzuverarbeiten
    jQuery.ajax({
        url: "index.php?option=com_cakeconfig&task=toWK&format=raw",
        method: "POST",

        data: {
            data: data // Second add quotes on the value.
        },
        success: function (response) {



        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
//kathrin wk funktion triggern



});



//spinner button
jQuery(".btn_spinner_up").live('click', function () {

    jQuery(".spinner input").val(parseInt(jQuery('.spinner input').val(), 10) + 1);
});
jQuery(".btn_spinner_down").live('click', function () {
    if (jQuery('.spinner input').val() > 1) {
        jQuery(".spinner input").val(parseInt(jQuery('.spinner input').val(), 10) - 1);
    }
});


//pic upload
jQuery(document).on('change', '.btn-file :file', function () {
    var input = jQuery(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
});

jQuery('.btn-file :file').on('fileselect', function (event, label) {

    var input = jQuery(this).parents('.input-group').find(':text'),
            log = label;

    if (input.length) {
        input.val(log);
    } else {
        if (log)
            alert(log);
    }

});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#img-upload').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

jQuery("#imgInp").change(function () {
    readURL(this);
});
jQuery("#selectbasic_karton").live('change', function () {
    var karton = jQuery("#selectbasic_karton").find(":selected").val();
    jQuery("#wrapping_modal_karton").val(karton);

});

jQuery("#selectbasic_masche").live('change', function () {
    var masche = jQuery("#selectbasic_masche").find(":selected").val();
    jQuery("#wrapping_modal_masche").val(masche);

});

jQuery("#selectbasic_bez").live('change', function () {
    var bez = jQuery("#selectbasic_bez").val();
    jQuery("#wrapping_modal_bez").val(bez);

});

jQuery('#wrapping_do_creation').click(function () {


    var masche = jQuery("#selectbasic_masche").val();
    
    var bez = jQuery("#selectbasic_bez").val();
    console.log(bez);

    var karton = jQuery("#selectbasic_karton").val();

    var bild = jQuery("#guid_ready_pic").val();

    var pfad = jQuery("#pfad_ready_pic").val();

    var username = jQuery("#username_ready_pic").val();

    jQuery.ajax({
      url: "index.php?option=com_cakeconfig&task=doWrapping&format=raw",
      method: "POST",

        data: {
            masche: masche,
            karton: karton,
            bild: bild,
            pfad: pfad,
            username: username,
            bez: bez// Second add quotes on the value.
        },
        success: function (response) {


           console.log(response);
          // var url = "http://wi-gate.technikum-wien.at:60336/index.php";
          //  window.location.href = "http://wi-gate.technikum-wien.at:60336/index.php";
          //  jQuery(location).attr("href", url);

        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
    
    
});

jQuery(".cakeconf_recipe_btn").click(function () {
  
    var guid = (S4() + S4() + "-" + S4() + "-4" + S4().substr(0,3) + "-" + S4() + "-" + S4() + S4() + S4()).toLowerCase();
    jQuery("#addToCartBtn").attr({item_id: guid});


    var data = [];
    var zub = jQuery("#recipe_text_zub").val();
    var anm = jQuery("#sonderwunsch").val();
    var gprice = jQuery("#gpreis").text();
    var rezept_bez = jQuery("#rezept_bez").val();
var questions = new Array();
    gprice = gprice.substr(0, gprice.indexOf(' '));
    for (var i = 1; i <= 100; i++) {
        var x = ".select_" + i;
        var y = ".amount_" + i;
        var id = jQuery(x + " option:selected").val();
        var amount = jQuery(y).val();

        if (id != null) {
            var temp = new Array();
            temp['id'] = id.trim();
            temp['amount'] = amount;
            temp['zub'] = zub;
            temp['anm'] = anm;
            temp['gprice'] = +gprice;
            temp['bez'] = rezept_bez;
            
            data.push(temp);
            
            questions[i] = {
            id:   id.trim(),
            amount: amount,
            zub: zub,
            anm: anm,
            gprice: +gprice,
            bez: rezept_bez
            };


        }

    }
console.log(data);
//ajax call um daten weiterzuverarbeiten
    jQuery.ajax({
        url: "index.php?option=com_cakeconfig&task=recipeToWK&format=json",
        method: "POST",

        data: {
            data:questions,
            guid:guid// Second add quotes on the value.
        },
        success: function (response) {
            console.log(response);
            //jQuery("#addToCartBtn").attr({item_id: response});
            
            
            //var url = "http://wi-gate.technikum-wien.at:60336/index.php";
            //window.location.href = "http://wi-gate.technikum-wien.at:60336/index.php";
            //jQuery(location).attr("href", url);

        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
//kathrin wk funktion triggern



});

jQuery(".recipe_redirect").click(function () {
             var url = "http://wi-gate.technikum-wien.at:60336/index.php";
            window.location.href = "http://wi-gate.technikum-wien.at:60336/index.php";
            jQuery(location).attr("href", url);
    
});

//orders

jQuery(".order_row").live('click', function () {
    
    var id = jQuery(this).data("href");
    var userid = jQuery("#usadm_best_div").attr('userid');
    var status = jQuery(this).attr('status');
    
    jQuery.ajax({
        url: "index.php?option=com_ajax&ignoreMessages&module=fst4_useradm&method=getOrderDetail&format=json&Itemid=116",
        method: "POST",

        data: {
            id: id // Second add quotes on the value.
        },
        success: function (response) {
            console.log(response);
            jQuery("#order_modal_detail").load("../modules/mod_fst4_useradm/tmpl/orderDetails.php", {odetails: response['data'], userid:userid, status:status});
            jQuery('#order_detail_modal').modal('show');
        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
});

//recipes
jQuery(".recipe_row").live('click', function () {
    
    var id = jQuery(this).data("href");
    jQuery.ajax({
        url: "index.php?option=com_ajax&ignoreMessages&module=fst4_useradm&method=getRecipeDetail&format=json&Itemid=116",
        method: "POST",

        data: {
            id: id // Second add quotes on the value.
        },
        success: function (response) {
            console.log(response);
            jQuery("#recipe_modal_detail").load("../modules/mod_fst4_useradm/tmpl/recipeDetails.php", {rdetails: response['data']});
            jQuery('#recipe_detail_modal').modal('show');
        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
});

function S4() {
    return (((1+Math.random())*0x10000)|0).toString(16).substring(1); 
}

jQuery("#pdetail_row").live('click', function () {
    var artid = jQuery(this).attr('artid');
    var persid = jQuery(this).attr('persid');
    var status = jQuery(this).attr('status');

    
    jQuery.ajax({
        url: "index.php?option=com_ajax&ignoreMessages&module=fst4_useradm&method=getRatingDetail&format=json&Itemid=116",
        method: "POST",

        data: {
            artid: artid,
            persid:persid
            // Second add quotes on the value.
        },
        success: function (response) {
console.log(response);
            jQuery("#product_detail_div").load("../modules/mod_fst4_useradm/tmpl/ratingDetail.php", {ratDetails:response['data'], status:status, artid:artid, persid:persid});

        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
    
});

jQuery(".rating").live('mouseover', function () {
    jQuery('#rat_confirm_btn').css("display", "block");
    var id = jQuery(this).attr("ratnr");
    for(i = 1; i <= id; i++){
        jQuery('#ratid'+ i).removeClass('ratgrey');
        jQuery('#ratid'+ i).addClass('ratblue');
    }
    jQuery('#rat_comment').attr({stars: i});
    for(i = 5; i > id; i--){
        jQuery('#ratid'+ i).removeClass('ratblue');
        jQuery('#ratid'+ i).addClass('ratgrey');
    }
    
});

jQuery("#rat_comment").live('change', function () {
     jQuery('#rat_confirm_btn').css("display", "block");
    
});

jQuery("#rat_confirm_btn").live('click', function () {
    var stars = jQuery('#rat_comment').attr("stars");
    stars --;
    if(stars != 1 && stars != 2 && stars != 3 && stars != 4 && stars != 5){
        stars = jQuery('#rat_comment').attr("stars2");
    }

    var artid = jQuery('#rat_comment').attr("artid");
    var persid = jQuery('#rat_comment').attr("persid");
    
    var comment = jQuery('#rat_comment').val();
    
    if(comment == "Noch kein Kommentar vorhanden!"){comment = "";}
    
    console.log(stars);
    console.log(comment);
    
    jQuery.ajax({
        url: "index.php?option=com_ajax&ignoreMessages&module=fst4_useradm&method=doRating&format=json&Itemid=116",
        method: "POST",

        data: {
            stars: stars,
            comment:comment,
            artid:artid,
            persid:persid
            // Second add quotes on the value.
        },
        success: function (response) {
console.log(response);
            //jQuery("#product_detail_div").load("../modules/mod_fst4_useradm/tmpl/ratingDetail.php", {ratDetails:response['data'], status:status});

        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }

    });
    
    
    
    
});
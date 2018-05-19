
function showDetailsArticle(aid){
    jQuery.ajax({
                url:"index.php?option=com_ajax&ignoreMessages&module=fst4_product&method=getArticleDetail&format=json&Itemid=101",
                method:"POST", 
         
                data:{
                id: aid // Second add quotes on the value.
                },
                success:function(response) {

                 jQuery( "#main_product_load" ).load( "../modules/mod_fst4_product/tmpl/productDetail.php",{pdetails:response['data']});
                 
               },
                 error: function(xhr, textStatus, error){
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                    }

              });    
}

function showDetailsPackage(aid){
    jQuery.ajax({
                url:"index.php?option=com_ajax&ignoreMessages&module=fst4_product&method=getPackageDetail&format=json&Itemid=101",
                method:"POST", 
         
                data:{
                id: aid // Second add quotes on the value.
                },
                success:function(response) {

                 jQuery( "#main_product_load" ).load( "../modules/mod_fst4_product/tmpl/packageDetail.php",{pdetails:response['data']});
                 
               },
                 error: function(xhr, textStatus, error){
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                    }

              });    
}
//nav for user adm

    jQuery('#usadm_allg').click(function () {
        jQuery('#usadm_allg').addClass('active');
        jQuery('#usadm_persDat').removeClass('active');
        jQuery('#usadm_allg_div').css("display", "block");
        jQuery('#usadm_persDat_div').css("display", "none");
    });
    
    jQuery('#usadm_persDat').click(function () {
        jQuery('#usadm_allg').removeClass('active');
        jQuery('#usadm_persDat').addClass('active');
        jQuery('#usadm_allg_div').css("display", "none");
        jQuery('#usadm_persDat_div').css("display", "block");
    });


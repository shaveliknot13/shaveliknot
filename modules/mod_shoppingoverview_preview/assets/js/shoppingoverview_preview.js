jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";
    var amxCount = 0;



    jQuery('.block-mod-js-ru').hide();
    jQuery('.block-mod-js-en').hide();
    jQuery('.block-mod-js-he').hide();


    var aaaaamx = jQuery('.so_tags .so_tags_items').html();

    var eachProductContent = jQuery(aaaaamx).filter('span').clone();

    if(eachProductContent.length > 0){
        jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').html('');
        eachProductContent.each(function(){
            if(jQuery(this).text() != ''){
                jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').append('<a href="#">#'+jQuery(this).text()+'</a> ');
            }
        });
    }else{
        jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
    }

    var textAmxRu = jQuery.trim(jQuery('#jform_myFieldset_product').val()+' - '+jQuery('#jform_myFieldset_title_ru').val());
    var textAmxEn = jQuery.trim(jQuery('#jform_myFieldset_product').val()+' - '+jQuery('#jform_myFieldset_title_en').val());
    var textAmxHe = jQuery.trim(jQuery('#jform_myFieldset_product').val()+' - '+jQuery('#jform_myFieldset_title_he').val());
    if(textAmxRu == '-'){
        jQuery('.mod_shoppingoverview_preview .block-mod-js-ru .shoppingoverview-page-item-titles a').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
    }else{
        jQuery('.mod_shoppingoverview_preview .block-mod-js-ru .shoppingoverview-page-item-titles a').html(textAmxRu);
    }

    if(textAmxEn == '-'){
        jQuery('.mod_shoppingoverview_preview .block-mod-js-en .shoppingoverview-page-item-titles a').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
    }else{
        jQuery('.mod_shoppingoverview_preview .block-mod-js-en .shoppingoverview-page-item-titles a').html(textAmxEn);
    }

    if(textAmxHe == '-'){
        jQuery('.mod_shoppingoverview_preview .block-mod-js-he .shoppingoverview-page-item-titles a').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
    }else{
        jQuery('.mod_shoppingoverview_preview .block-mod-js-he .shoppingoverview-page-item-titles a').html(textAmxHe);
    }

    var activeTab = jQuery('.mod_shoppingoverview_preview .content-tabs .active').attr('date-lang');
    jQuery('.mod_shoppingoverview_preview .block-mod-js-'+activeTab).show();

    jQuery('.mod_shoppingoverview_preview .content-tabs .item-tab').live( "click", function() {

        jQuery('.mod_shoppingoverview_preview .content-tabs .item-tab').removeClass('active');
        jQuery(this).addClass('active');

        var datalang = jQuery(this).attr('date-lang');
        jQuery('.block-mod-js-ru').hide();
        jQuery('.block-mod-js-en').hide();
        jQuery('.block-mod-js-he').hide();
        jQuery('.mod_shoppingoverview_preview .block-mod-js-'+datalang).show();
    });

    jQuery('#jform_myFieldset_product, #jform_myFieldset_title_ru, #jform_myFieldset_title_en, #jform_myFieldset_title_he').live( "keyup change", function() {

        var textAmxRu = jQuery.trim(jQuery('#jform_myFieldset_product').val()+' - '+jQuery('#jform_myFieldset_title_ru').val());
        var textAmxEn = jQuery.trim(jQuery('#jform_myFieldset_product').val()+' - '+jQuery('#jform_myFieldset_title_en').val());
        var textAmxHe = jQuery.trim(jQuery('#jform_myFieldset_product').val()+' - '+jQuery('#jform_myFieldset_title_he').val());

        if(textAmxRu == '-'){
            jQuery('.mod_shoppingoverview_preview .block-mod-js-ru .shoppingoverview-page-item-titles a').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
        }else{
            jQuery('.mod_shoppingoverview_preview .block-mod-js-ru .shoppingoverview-page-item-titles a').html(textAmxRu);
        }

        if(textAmxEn == '-'){
            jQuery('.mod_shoppingoverview_preview .block-mod-js-en .shoppingoverview-page-item-titles a').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
        }else{
            jQuery('.mod_shoppingoverview_preview .block-mod-js-en .shoppingoverview-page-item-titles a').html(textAmxEn);
        }

        if(textAmxHe == '-'){
            jQuery('.mod_shoppingoverview_preview .block-mod-js-he .shoppingoverview-page-item-titles a').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
        }else{
            jQuery('.mod_shoppingoverview_preview .block-mod-js-he .shoppingoverview-page-item-titles a').html(textAmxHe);
        }

    });



    jQuery('.so_tags .so_tags_items').live("DOMSubtreeModified",function(){

        var aaaaamx = jQuery('.so_tags .so_tags_items').html();

        var eachProductContent = jQuery(aaaaamx).filter('span').clone();

        if(eachProductContent.length > 0){
            jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').html('');
            eachProductContent.each(function(){
                if(jQuery(this).text() != ''){
                    jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').append('<a href="#">#'+jQuery(this).text()+'</a> ');
                }
            });
        }else{
            jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">');
        }

    });

    jQuery('.so_tag_remove').live("click",function(){
        var aaaaamx = jQuery('.so_tags .so_tags_items').html();

        var eachProductContent = jQuery(aaaaamx).filter('span').clone();

        if(eachProductContent.length > 0){
            jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').html('');
            eachProductContent.each(function(){
                if(jQuery(this).text() != ''){
                    jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').append('<a href="#">#'+jQuery(this).text()+'</a> ');
                }
            });
        }else{
            jQuery('.mod_shoppingoverview_preview .shoppingoverview-page-item-tags').html('<img src="/modules/mod_shoppingoverview_preview/assets/img/tags.jpg">');
        }
    });




    window.onload = function () {

        if(jQuery(window).width() >= 980 ) {

            var off = jQuery(".mod_shoppingoverview_preview").offset();

            jQuery(window).scroll(function () {

                var topAmx = jQuery(window).scrollTop();

                if (topAmx >= off.top) {
                    jQuery(".mod_shoppingoverview_preview").offset({top: topAmx});
                }else{
                    jQuery(".mod_shoppingoverview_preview").offset({top: off.top});
                }

            });
        }

    }




});
jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

    jQuery(document).live('click', function(event) {
        if(!jQuery(event.target).closest('.top-border-login .jlslogin').length) {

            if(jQuery('.jlslogin .logout-cabinet-base').is(":visible")) {
                jQuery('.jlslogin .logout-cabinet-base').hide();
                jQuery('.jlslogin').removeClass('active');
            }

        }
    });

    jQuery('.shoppingoverview-users-login a').live('click', function(event) {
        jQuery('.shoppingoverview-users-login a').removeClass('active');
        jQuery(this).addClass('active');
    });


    // открытие модулей в мобильной версии
    jQuery('.name-modul-head-mobile').live('click', function(event) {



        if(jQuery(this).parent('div').find('.name-modul-body-mobile').is(":visible")){
            jQuery(this).parent('div').find('.name-modul-body-mobile').hide();
            jQuery(this).css("cssText", "margin-bottom: 0px;");
        }else{
            jQuery(this).parent('div').find('.name-modul-body-mobile').show();
            jQuery(this).css("cssText", "margin-bottom: 15px;");
            autoHeightIfram();
        }

    });


    jQuery('.top-border-login .jlslogin').live('mouseover mouseout click', function(event) {

            if (event.type == 'mouseover') {
                jQuery(this).addClass('active');
                clearTimeout(jQuery.data(this, 'timer'));
                jQuery('.logout-cabinet-base', this).stop(true, true).show();
            } else if (event.type == 'mouseout') {
                jQuery(this).removeClass('active');
                jQuery.data(this, 'timer', setTimeout(jQuery.proxy(function () {
                    jQuery('.logout-cabinet-base', this).stop(true, true).hide();
                }, this), 1));
            }

    });

    jQuery('.click_left_bar').live('click', function() {
        click_left_bar(jQuery(this));
    });


    jQuery('#sidebar .close-mobile-sidebar').live('click', function() {
        click_left_bar(jQuery('.click_left_bar'));
    });

    function click_left_bar (amx){

        if(jQuery('.click_right_bar').hasClass('active')){
            jQuery('.click_right_bar').removeClass('active');
            jQuery("#aside").css("cssText", "margin-right: -100% !important;");
        }

        if(amx.hasClass('active')){
            amx.removeClass('active');
            jQuery("#sidebar").css("cssText", "margin-left: -100% !important;");
        }else{
            amx.addClass('active');
            jQuery("#sidebar").css("cssText", "margin-left: 0px !important;");
        }
    }

    jQuery('.click_right_bar').live('click', function() {
        click_right_bar(jQuery(this));
    });

    jQuery('#aside .close-mobile-sidebar').live('click', function() {
        click_right_bar(jQuery('.click_right_bar'));
    });

    function click_right_bar (amx){

        if(jQuery('.click_left_bar').hasClass('active')){
            jQuery('.click_left_bar').removeClass('active');
            jQuery("#sidebar").css("cssText", "margin-left: -100% !important;");

        }

        if(amx.hasClass('active')){
            amx.removeClass('active');
            jQuery("#aside").css("cssText", "margin-right: -100% !important;");
        }else{
            amx.addClass('active');
            jQuery("#aside").css("cssText", "margin-right: 0px !important;");
        }
    }




    jQuery('.shoppingoverview-page-item-sharing, .shoppingoverview-page-item-show-sharing').live('mouseover mouseout click', function(event) {

        if (event.type == 'mouseover') {
            clearTimeout(jQuery.data(this, 'timer'));
            jQuery(this).find('.me-share').stop(true, true).show();
        } else if (event.type == 'mouseout') {
            jQuery.data(this, 'timer', setTimeout(jQuery.proxy(function () {
                jQuery(this).find('.me-share').stop(true, true).hide();
            }, this), 1));
        }

    });



});
jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

    function shoppingoverview_navigational_list(){
        jQuery('.mod_shoppingoverview_navigational .list_block ul').hide();

        jQuery('.mod_shoppingoverview_navigational .list_block .list_item, .mod_shoppingoverview_navigational .list_block .fast_click_item').live( "click", function() {
            var qwerty = jQuery(this).attr('date-comunitction');
            jQuery('.mod_shoppingoverview_navigational .list_block ul').stop().slideUp();

            if(jQuery('.mod_shoppingoverview_navigational .list_block .fast_click_item[date-comunitction='+qwerty+']').hasClass('active')){
                jQuery('.mod_shoppingoverview_navigational .list_block .fast_click_item[date-comunitction='+qwerty+']').removeClass('active');
            }else{
                jQuery('.mod_shoppingoverview_navigational .list_block .fast_click_item').removeClass('active');
                jQuery('.mod_shoppingoverview_navigational .list_block .fast_click_item[date-comunitction='+qwerty+']').addClass('active');
            }

            if (jQuery('.mod_shoppingoverview_navigational .list_block ul[date-ul-comunitction='+qwerty+']').is(':visible')) {
                jQuery('.mod_shoppingoverview_navigational .list_block ul[date-ul-comunitction='+qwerty+']').stop().slideUp();
            }else{
                jQuery('.mod_shoppingoverview_navigational .list_block ul[date-ul-comunitction='+qwerty+']').stop().slideDown();
            }

        });
    }

    jQuery('.mod_shoppingoverview_navigational .select_block select, .mod_shoppingoverview_navigational .date_block select').live( "change", function() {

        var qwerty1 = jQuery('.mod_shoppingoverview_navigational .date_block select').val();
        var qwerty2 = jQuery('.mod_shoppingoverview_navigational .select_block select').val();

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_ajax&module=shoppingoverview_navigational&format=json',
            data: 'date='+qwerty1+'&cat_id='+qwerty2,
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (response) {
                if(response.error == 1){
                    alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_DATA_SENT_INCORRECTLY'));
                }else{
                    jQuery('.mod_shoppingoverview_navigational .list_block').html(response.result);
                    jQuery('.mod_shoppingoverview_navigational .list_block ul').hide();
                }
            }
        });


    });

    shoppingoverview_navigational_list();

});
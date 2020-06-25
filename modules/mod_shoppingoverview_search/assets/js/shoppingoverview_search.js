jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

    function search(){
        var qwerty1 = jQuery('.mod_shoppingoverview_search input').val();
        var qwerty2 = jQuery('.mod_shoppingoverview_search select').val();

        if(qwerty1.length >= 2) {

            jQuery.ajax({
                type: "POST",
                url: baseUrl + 'index.php?option=com_shoppingoverview&controller=search&task=searchAjax',
                data: 'search=' + qwerty1 + '&type=' + qwerty2,
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (response) {
                    if (response.error == 1) {
                        alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_DATA_SENT_INCORRECTLY'));
                    } else {
                        jQuery('.mod_shoppingoverview_search .result_search').html(response.result);
                    }
                }
            });
        }
    }

    jQuery('.mod_shoppingoverview_search select').live( "change", function() {
        search();
    });

    jQuery('.mod_shoppingoverview_search input').keyup(function(key) {
        search();
    });

    jQuery(document).live('click', function (event) {

        if (!(jQuery(event.target).parents().andSelf().is('.mod_shoppingoverview_search .result_search ul'))) {
            jQuery(".mod_shoppingoverview_search .result_search ul").remove();
        }

    });

    jQuery('.mod_shoppingoverview_search .input-search').live( "click", function() {
        jQuery( ".mod_shoppingoverview_search form" ).submit();
    });

});
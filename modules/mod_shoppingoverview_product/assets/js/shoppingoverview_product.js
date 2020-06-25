jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

    // чекед выбраного заголовка
    jQuery(".mod_shoppingoverview_product .titles .title").live( "click", function() {

        var par = jQuery(this).parent(".titles");
        par.find('.title').removeClass('active');
        jQuery(this).addClass('active');

        shoppingoverview_product();
    });

    function shoppingoverview_product(){

        var cat_alias = jQuery(".mod_shoppingoverview_product .titles").attr('data-cat_alias');
        var count = jQuery(".mod_shoppingoverview_product .titles").attr('data-count');
        var filter = jQuery(".mod_shoppingoverview_product .titles .active").attr('data-filter');

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_ajax&module=shoppingoverview_product&format=json',
            data: 'cat_alias='+cat_alias+'&count='+count+'&filter='+filter,
            dataType: 'json',
            beforeSend: function () {
                jQuery(".mod_shoppingoverview_product .content").html('<img  style="width: 100%;" src="/images/load.gif">');
            },
            success: function (response) {
                if(response.error == 1){
                    alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_DATA_SENT_INCORRECTLY'));
                }else{
                    jQuery(".mod_shoppingoverview_product .content").html(response.result);
                }

                autoHeightIfram();
            }
        });
    }

});
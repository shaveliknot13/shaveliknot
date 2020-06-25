jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

    // чекед для выбора
    jQuery(".globalfilterCat ul li:not(.nav-header,.noClickCat)").live( "click", function() {

        var par = jQuery(this).parent("ul");
        par.find('li').removeClass('active');
        jQuery(this).addClass('active');

        ajaxSiteCategories_left_bar();
    });

    // чекед для выбора
    jQuery(".panel-my-cat .panel-my-cat-right").live( "click", function() {

        jQuery(".panel-my-cat .panel-my-cat-right").removeClass('active');
        jQuery(this).addClass('active');

        ajaxSiteCategories_left_bar();
    });

    // чекед для выбора
    jQuery(".globalfilterCat ul.filterSoVideo li").live( "click", function() {

        if(jQuery(this).hasClass('active')){
            jQuery(this).removeClass('active');
            jQuery(this).attr('data-filterso','0');
        } else {
            jQuery(this).addClass('active');
            jQuery(this).attr('data-filterso','1');
        }

        ajaxSiteCategories_left_bar();
    });

    // чекед для выбора
    jQuery(".globalfilterCat .filterSoPrice .input-button").live( "click", function() {

        ajaxSiteCategories_left_bar();
    });

    function ajaxSiteCategories_left_bar(){

        var filterSoPrice1 = jQuery(".globalfilterCat ul.filterSoPrice input.input-text-1").val();
        var filterSoPrice2 = jQuery(".globalfilterCat ul.filterSoPrice input.input-text-2").val();
        var filterSoDelivery = jQuery(".globalfilterCat ul.filterSoDelivery li.active").attr('data-filterSo');
        var filterSoVideo = jQuery(".globalfilterCat ul.filterSoVideo li.active").attr('data-filterSo');
        var cat_alias = jQuery("#ajaxSiteCategories").attr('data-cat_alias');
        var ordering = jQuery(".panel-my-cat span.active").attr('data-filterSo');

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&task=ajaxSiteCategories2',
            data: 'cat_alias='+cat_alias+'&filterSoPrice1='+filterSoPrice1+'&filterSoPrice2='+filterSoPrice2+'&filterSoDelivery='+filterSoDelivery+'&filterSoVideo='+filterSoVideo+'&ordering='+ordering,
            dataType: 'json',
            beforeSend: function () {
                jQuery(".ajaxSiteCategories").html('<img style="width: 100%;" src="/images/load.gif">');

            },
            success: function (response) {
                if(response.error == 1){
                    alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_DATA_SENT_INCORRECTLY'));
                }else{
                    jQuery("#ajaxSiteCategories").attr('data-count',response.count);
                    jQuery(".ajaxSiteCategories").html(response.result);
                }

                autoHeightIfram();
            }
        });
    }


});
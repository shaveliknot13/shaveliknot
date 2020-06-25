jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

    // чекед для категорий
    jQuery(".shoppingoverview_publications_left_bar ul.filterSoCat li:not(.nav-header,.noClickCat)").live( "click", function() {

        var par = jQuery(this).parent("ul");

        if(jQuery(this).hasClass('active')){
            jQuery(this).removeClass('active');
        }else{
            jQuery(this).addClass('active');
            if(jQuery(this).index() > 1){
                par.find('li:eq(1)').removeClass('active');
            }else{
                par.find('li').removeClass('active');
            }
        }

        if(!par.find('li').hasClass('active')){
            par.find('li:eq(1)').addClass('active');
        }

        shoppingoverview_publications_left_bar();
    });

    // чекед для всего остального
    jQuery(".shoppingoverview_publications_left_bar ul:not(.filterSoCat) li:not(.nav-header,.noClickCat)").live( "click", function() {

        var par = jQuery(this).parent("ul");
        par.find('li').removeClass('active');
        jQuery(this).addClass('active');

        shoppingoverview_publications_left_bar();
    });

    // чекед для выбора
    jQuery(".globalfilterPub ul.filterSoVideo li").live( "click", function() {

        if(jQuery(this).hasClass('active')){
            jQuery(this).removeClass('active');
            jQuery(this).attr('data-filterso','0');
        } else {
            jQuery(this).addClass('active');
            jQuery(this).attr('data-filterso','1');
        }

        shoppingoverview_publications_left_bar();
    });

    // чекед для выбора
    jQuery(".globalfilterPub .filterSoPrice .input-button").live( "click", function() {

        shoppingoverview_publications_left_bar();
    });

    function shoppingoverview_publications_left_bar(){

        var filterSoCat = jQuery(".globalfilterPub ul.filterSoCat li.active");
        var filterSoDay = jQuery(".globalfilterPub ul.filterSoDay li.active").attr('data-filterSo');
        var filterSoPrice1 = jQuery(".globalfilterPub ul.filterSoPrice input.input-text-1").val();
        var filterSoPrice2 = jQuery(".globalfilterPub ul.filterSoPrice input.input-text-2").val();
        var filterSoDelivery = jQuery(".globalfilterPub ul.filterSoDelivery li.active").attr('data-filterSo');
        var filterSoVideo = jQuery(".globalfilterPub ul.filterSoVideo li.active").attr('data-filterSo');

        var filterSoCatArr = filterSoCat.map(function(){
            return jQuery(this).attr('data-filterSo');
        }).get();

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_ajax&module=shoppingoverview_publications&format=json',
            data: 'filterSoCat='+filterSoCatArr+'&filterSoDay='+filterSoDay+'&filterSoPrice1='+filterSoPrice1+'&filterSoPrice2='+filterSoPrice2+'&filterSoDelivery='+filterSoDelivery+'&filterSoVideo='+filterSoVideo,
            dataType: 'json',
            beforeSend: function () {
                jQuery(".shoppingoverview_publications_right_bar").html('<img  style="width: 100%;" src="/images/load.gif">');
            },
            success: function (response) {
                if(response.error == 1){
                    alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_DATA_SENT_INCORRECTLY'));
                }else{
                    jQuery(".shoppingoverview_publications_right_bar").html(response.result);
                }
                autoHeightIfram();
            }
        });
    }


});
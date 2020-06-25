jQuery(document).ready(function(){

var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";
var players = [];

// ДОБОВЛЕНИЕ МАТЕРИАЛА

// Выделение мини изображения

function addMarkerSetka() {

    var imgAll = jQuery('.photo img');
    imgAll.each(function(){
        var imgOrigin = jQuery(this);

        imgOrigin.imgAreaSelect({
            aspectRatio: '1:1',
            handles: true,
            imageWidth: imgOrigin.parent('.photo').find('.clouse_img_so').attr('date-width'),
            imageHeight: imgOrigin.parent('.photo').find('.clouse_img_so').attr('date-height'),
            minHeight:320,
            minWidth:320,
            onSelectChange: photoPreviewModule,
            onSelectEnd: function ( image, selection ) {

                var amxAll = jQuery(imgOrigin).parents('.addblock').attr('class').replace("addblock ","");
                amxAll = '.'+amxAll;

                jQuery(amxAll).find('.coordinates_x1').val(selection.x1);
                jQuery(amxAll).find('.coordinates_x2').val(selection.x2);
                jQuery(amxAll).find('.coordinates_y1').val(selection.y1);
                jQuery(amxAll).find('.coordinates_y2').val(selection.y2);
                jQuery(amxAll).find('.coordinates_width').val(selection.width);
                jQuery(amxAll).find('.coordinates_height').val(selection.height);

                if(isFirstImg(image) == true){
                    AddPhotoPreviewModule('ru');
                    AddPhotoPreviewModule('en');
                    AddPhotoPreviewModule('he');
                }

            }
        });

    });
}


function showMarkerSetka(){

    var imgAll = jQuery('.photo img');

    imgAll.each(function(){
        var imgOrigin1 = jQuery(this);
        var x1 = imgOrigin1.parents('.addblock').find('.coordinates_x1').val();
        var x2 = imgOrigin1.parents('.addblock').find('.coordinates_x2').val();
        var y1 = imgOrigin1.parents('.addblock').find('.coordinates_y1').val();
        var y2 = imgOrigin1.parents('.addblock').find('.coordinates_y2').val();
        var widthAmx = imgOrigin1.parents('.addblock').find('.coordinates_width').val();
        var heightAmx = imgOrigin1.parents('.addblock').find('.coordinates_height').val();

        if(widthAmx != 0 && heightAmx != 0) {
            if (x1 != 0 || x2 != 0 || y1 != 0 || y2 != 0) {
                if (imgOrigin1.is(':visible')) {
                    var imgOrigin = imgOrigin1.imgAreaSelect({instance: true});
                    imgOrigin.setSelection(x1, y1, x2, y2, false);
                    imgOrigin.setOptions({show: true});
                    imgOrigin.setOptions({handles: true});
                    imgOrigin.setOptions({aspectRatio: '1:1'});
                    imgOrigin.setOptions({minHeight: 320});
                    imgOrigin.setOptions({minWidth: 320});
                    imgOrigin.setOptions({imageWidth: imgOrigin1.parent('.photo').find('.clouse_img_so').attr('date-width')});
                    imgOrigin.setOptions({imageHeight: imgOrigin1.parent('.photo').find('.clouse_img_so').attr('date-height')});
                    imgOrigin.update();
                }
            }
        }

    });
}


function hideMarkerSetkaAll() {

    jQuery('.photo img').imgAreaSelect({
        hide: true
    });

}

function hideMarkerSetka(imgQaq) {

    imgQaq.parents('.addblock').find('.coordinates_width').val('0');
    imgQaq.parents('.addblock').find('.coordinates_height').val('0');

    imgQaq.imgAreaSelect({
        hide: true
    });

}

addMarkerSetka();

// конец выделения мини изображения

// <-- Аякс для перевода заголовков -->

jQuery('.button-arhw').click(function(){
    adminAjaxGetTitle(jQuery(this));
});

function adminAjaxGetTitle(arhw){

    var ruIc = jQuery('#jform_myFieldset_title_ru');
    var enIc = jQuery('#jform_myFieldset_title_en');
    var heIc = jQuery('#jform_myFieldset_title_he');

    jQuery.ajax({
        type: "POST",
        url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=ajaxGetTitle',
        data: 'title_ru='+ruIc.val()+'&title_en='+enIc.val()+'&title_he='+heIc.val(),
        dataType: 'json',
        beforeSend: function () {
            arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
        },
        success: function (response) {
            if(response.error == 1){
                alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE'));
            }else{

                if(response.title_ru.length > 0){
                    ruIc.val(response.title_ru);
                }

                if(response.title_en.length > 0){
                    enIc.val(response.title_en);
                }

                if(response.title_he.length > 0){
                    heIc.val(response.title_he);
                }


            }
            arhw.html('<i class="fal fa-globe"></i> ' + Joomla.JText._('COM_SHOPPINGOVERVIEW_EDIT_FILD_18'));
            button_arhw();
        }
    });

}

// <-- конец -->

jQuery('.button-arhw2').click(function(){
    adminAjaxGetText(jQuery(this));
});

function adminAjaxGetText(arhw){

    var text = jQuery('.addtext');
    var cq = text.serialize();

    cq = cq+'&jform[myFieldset][mini_text_ru]='+jQuery('#jform_myFieldset_mini_text_ru').val();
    cq = cq+'&jform[myFieldset][mini_text_en]='+jQuery('#jform_myFieldset_mini_text_en').val();
    cq = cq+'&jform[myFieldset][mini_text_he]='+jQuery('#jform_myFieldset_mini_text_he').val();
    cq = cq+'&jform[myFieldset][hwp_text_ru]='+jQuery('#jform_myFieldset_hwp_text_ru').val();
    cq = cq+'&jform[myFieldset][hwp_text_en]='+jQuery('#jform_myFieldset_hwp_text_en').val();
    cq = cq+'&jform[myFieldset][hwp_text_he]='+jQuery('#jform_myFieldset_hwp_text_he').val();

    jQuery.ajax({
        type: "POST",
        url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=ajaxGetText',
        data: cq,
        dataType: 'json',
        beforeSend: function () {
            arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
        },
        success: function (response) {
            arhw.html('<i class="fal fa-globe"></i> '+Joomla.JText._('COM_SHOPPINGOVERVIEW_EDIT_FILD_22'));
            if(response.error.length  > 0){
                alert(response.error);
            }else{

                if(response.text_ru.length > 0){
                    var inRu = 1;
                    jQuery.each( response.text_ru, function( key, value ) {
                        if(value.length > 1){
                            jQuery('.original_ru .addblock_'+inRu+' .addtext').val(value);
                            jQuery('.original_ru .addblock_'+inRu).show();
                        }
                        inRu++;
                    });
                }

                if(response.mini_text_ru.length > 0){
                    jQuery('#jform_myFieldset_mini_text_ru').val(response.mini_text_ru);
                }
                if(response.hwp_text_ru.length > 0){
                    jQuery('#jform_myFieldset_hwp_text_ru').val(response.hwp_text_ru);
                }

                if(response.text_en.length > 0){
                    var inEn = 1;
                    jQuery.each( response.text_en, function( key, value ) {
                        if(value.length > 1){
                            jQuery('.original_en .addblock_'+inEn+' .addtext').val(value);
                            jQuery('.original_en .addblock_'+inEn).show();
                        }
                        inEn++;
                    });
                }

                if(response.mini_text_en.length > 0){
                    jQuery('#jform_myFieldset_mini_text_en').val(response.mini_text_en);
                }
                if(response.hwp_text_en.length > 0){
                    jQuery('#jform_myFieldset_hwp_text_en').val(response.hwp_text_en);
                }

                if(response.text_he.length > 0){
                    var inHe = 1;
                    jQuery.each( response.text_he, function( key, value ) {
                        if(value.length > 1){
                            jQuery('.original_he .addblock_'+inHe+' .addtext').val(value);
                            jQuery('.original_he .addblock_'+inHe).show();
                        }
                        inHe++;
                    });
                }

                if(response.mini_text_he.length > 0){
                    jQuery('#jform_myFieldset_mini_text_he').val(response.mini_text_he);
                }
                if(response.hwp_text_he.length > 0){
                    jQuery('#jform_myFieldset_hwp_text_he').val(response.hwp_text_he);
                }

            }
        }
    });

}

// анализирует и показывает или скрывает пустые блоки
function analisAndShow(){
    jQuery('.addphotooriginal').hide();

    jQuery('.original .addblock').each(function(){

        var imgq = jQuery(this).find('.photo img');
        var textq = jQuery(this).find('.addtext').val();

        if(imgq.length || textq.length > 0){
            jQuery(this).show();
            if(imgq.length){
                jQuery(this).find('.addphoto').hide();
            }
        }
    });

    jQuery('.original .addblock_10').each(function(){
        var imgq = jQuery(this).find('.photo img');
        var textq = jQuery(this).find('.addtext').val();

        if(!imgq.length && textq.length == 0){
            jQuery(this).parent('.original').find('.addphotooriginal').show();
        }
    });

    jQuery('.original .addblock_1').each(function(){
        var imgq = jQuery(this).find('.photo img');
        var textq = jQuery(this).find('.addtext').val();

        if(!imgq.length && textq.length == 0){
            jQuery(this).parent('.original').find('.addphotooriginal').hide();
        }
    });

}

var addphotooriginal = jQuery(".original .addphotooriginal");
jQuery(".addblock").hide();
jQuery(".addblock_1").show();
var countaddblock = addphotooriginal.attr('data-count');
analisAndShow();
    isNotImgPreviewModule('ru');
    isNotImgPreviewModule('en');
    isNotImgPreviewModule('he');

    AddPhotoPreviewModule('ru');
    AddPhotoPreviewModule('en');
    AddPhotoPreviewModule('he');

addphotooriginal.live( "click", function() {
    jQuery(".original .addblock_"+countaddblock).show();
    addphotooriginal.hide();
    countaddblock++;
});

jQuery('.addphoto').live( "click", function(){
    var parent = jQuery(this).parent('.addblock').find('.hidefile');
    parent.click();
});


jQuery('.clouse_img_so').live( "click", function() {

    var amxAll = jQuery(this).parents('.addblock').attr('class').replace("addblock ","");
    amxAll = '.'+amxAll;

    hideMarkerSetka(jQuery(amxAll).find('.photo').find('img'));
    jQuery(amxAll).find('.photo').find('img').remove();
    var parentAdd = jQuery(amxAll).find('.photo').parent('.addblock').find('.addphoto').show(1);
    jQuery(amxAll).find('.photo').parent('.addblock').find('.imageUrl').val('');
    parentAdd.text(Joomla.JText._('COM_SHOPPINGOVERVIEW_EDIT_FILD_24'));

    jQuery(amxAll).find('.photo').find('.clouse_img_so').hide();

    window.setTimeout( showMarkerSetka, 100 );

    isNotImgPreviewModule('ru');
    isNotImgPreviewModule('en');
    isNotImgPreviewModule('he');

    AddPhotoPreviewModule('ru');
    AddPhotoPreviewModule('en');
    AddPhotoPreviewModule('he');
});

jQuery('.hidefile').change(function(){

    var file = this.files[0];
    var fileSize = file.size/1000/1000;

    if(fileSize < 10) {

        var amxAll = jQuery(this).parent('.addblock').attr('class').replace("addblock ","");
        amxAll = '.'+amxAll;

        var addphoto = jQuery(amxAll).find('.addphoto');
        var photo = jQuery(amxAll).find('.photo');
        var imagesId = jQuery(amxAll).find('.imageUrl');
        var addphotooriginal = jQuery(amxAll).parent('.original').find('.addphotooriginal');

        var data = new FormData();
        data.append('file', this.files[0]);

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=ajaxUpload',
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function () {
                addphoto.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
                photo.html('<img style="width: 100%;" src="/images/load.gif">');
            },
            success: function (response) {
                if(response.error){
                    alert(response.error);
                    addphoto.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_EDIT_FILD_24'));
                    photo.html('');
                }else{
                    addphoto.hide();
                    addphotooriginal.show();
                    photo.html('<img src="/images/upload/'+response.img+'">');
                    photo.append('<div  date-width="'+response.imgWidth+'" date-height="'+response.imgHeight+'" class="clouse_img_so">&times;</div>');
                    imagesId.val(response.id);
                    addMarkerSetka();
                    AddPhotoPreviewModule('ru');
                    AddPhotoPreviewModule('en');
                    AddPhotoPreviewModule('he');
                    window.setTimeout( showMarkerSetka, 100 );
                }

                autoHeightIfram();
            }
        });
    }else{
        alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_DO_NOT_UPLOAD_PHOTOS_MORE_10_MEGABYTES'));
    }

});


    // Если нет картинки то уберает картинку с модуля
    function isNotImgPreviewModule(lang){
        if(jQuery("#editForm .original_"+lang+" .addblock .photo img").length == 0){
            jQuery(".mod_shoppingoverview_preview .block-mod-js-"+lang+" .shoppingoverview-page-item-imgs").html('<img src="/modules/mod_shoppingoverview_preview/assets/img/photo.jpg">');
        }
    }

    // Меняет позицую превьев картинки если это первая картинка
    function photoPreviewModule(img, selection) {
        if (!selection.width || !selection.height){
            return;
        }

        if(isFirstImg(img) == false) {
            return;
        }

        var lang = jQuery(img).parents('.original').attr('class');

        if(lang == 'original original_ru'){
            lang = 'ru';
        }else if(lang == 'original original_en'){
            lang = 'en';
        }else if(lang == 'original original_he'){
            lang = 'he';
        }else{
            lang = 'ru';
        }

        var dateLang = jQuery(".mod_shoppingoverview_preview .content-tabs .active").attr('date-lang');
        var scaleX = jQuery(".mod_shoppingoverview_preview .block-mod-js-"+dateLang+" .shoppingoverview-page-item-imgs").width() / selection.width;
        var scaleY = scaleX;

        jQuery('.mod_shoppingoverview_preview .block-mod-js-'+lang+' .shoppingoverview-page-item-imgs img').css({
            width: Math.round(scaleX * jQuery(img).parent('.photo').find('.clouse_img_so').attr('date-width')),
            height: Math.round(scaleY * jQuery(img).parent('.photo').find('.clouse_img_so').attr('date-height')),
            marginLeft: -Math.round(scaleX * selection.x1),
            marginTop: -Math.round(scaleY * selection.y1)
        });

    }

    // Добавляет первую картинку в модуль превью и оцентровывает или устанавливат нужные кординаты
    function AddPhotoPreviewModule(langFlag){

                if(jQuery("#editForm .original_"+langFlag+" .addblock .photo img").length == 0){
                    return;
                }

                var img = jQuery("#editForm .original_"+langFlag+" .addblock .photo img").eq(0);

                jQuery(".mod_shoppingoverview_preview .block-mod-js-"+langFlag+" .shoppingoverview-page-item-imgs").html(img.clone());

                var imgWidth = parseInt(img.parent('.photo').find('.clouse_img_so').attr('date-width'));
                var imgHeight = parseInt(img.parent('.photo').find('.clouse_img_so').attr('date-height'));
                var x1 = img.parents('.addblock').find('.coordinates_x1').val();
                var x2 = img.parents('.addblock').find('.coordinates_x2').val();
                var y1 = img.parents('.addblock').find('.coordinates_y1').val();
                var y2 = img.parents('.addblock').find('.coordinates_y2').val();
                var widthAmx = img.parents('.addblock').find('.coordinates_width').val();
                var heightAmx = img.parents('.addblock').find('.coordinates_height').val();

                if(widthAmx == 0 || heightAmx == 0){
                    var selection = imgWidth;

                    if(imgWidth < imgHeight){ selection = imgWidth; }
                    if(imgWidth > imgHeight){ selection = imgHeight; }

                    var dateLang = jQuery(".mod_shoppingoverview_preview .content-tabs .active").attr('date-lang');
                    var scaleX = jQuery(".mod_shoppingoverview_preview .block-mod-js-"+dateLang+" .shoppingoverview-page-item-imgs").width() / selection;
                    var scaleY = scaleX;

                    var marginLeft =0 ,marginTop = 0;

                    if((scaleX * imgWidth) > (scaleY * imgHeight)){
                        marginLeft = ((scaleX * imgWidth) - (scaleY * imgHeight)) / 2;
                    }

                    if((scaleX * imgWidth) < (scaleY * imgHeight)){
                        marginTop = ((scaleY * imgHeight) - (scaleX * imgWidth)) / 2;
                    }
                }else{
                    var selection = widthAmx;
                    var dateLang = jQuery(".mod_shoppingoverview_preview .content-tabs .active").attr('date-lang');
                    var scaleX = jQuery(".mod_shoppingoverview_preview .block-mod-js-"+dateLang+" .shoppingoverview-page-item-imgs").width() / selection;
                    var scaleY = scaleX;

                    marginLeft = scaleX * x1;
                    marginTop = scaleY * y1;
                }

                jQuery(".mod_shoppingoverview_preview .block-mod-js-"+langFlag+" .shoppingoverview-page-item-imgs img").css({
                    width: Math.round(scaleX * imgWidth),
                    height: Math.round(scaleY * imgHeight),
                    marginLeft: -Math.round(marginLeft),
                    marginTop: -Math.round(marginTop)
                });

    }


    function isFirstImg(img){
        var qwer = jQuery(img).parents('.original').find('img:first');

        if(qwer[0] == jQuery(img)[0]) {
            return true;
        }else{
            return false;
        }
    }

    jQuery('#jform_myFieldset_product').keyup(function(key) {
        var etot = jQuery(this);
        var regV = /[^a-zA-Z0-9\s!@#\$%\^&\*\(\)=_\-\+\?א-ת]/gim;

        var resultText = etot.val().replace(regV,'');
        resultText.trim();

        etot.val(resultText);
    });


// КОНЕЦ ДОБОВЛЕНИЕ МАТЕРИАЛА

// ТЕГИ

// добовление тега

jQuery('.so_tags_input input').keyup(function(key) {

    var etot = jQuery(this);
    var regV = /[^а-яА-Яa-zA-Z0-9\s!@\$%\^&\*\(\)=_\-\+\?א-ת]/gim;

    var resultText = etot.val().replace(regV,'');
    resultText.trim();

    etot.val(resultText);
    var error = 0;
    var textAr = etot.val();

    if(key.key == "Enter"){


        if(textAr.length > 35 || textAr.length < 1){
            alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_NO_MORE_THAN_35_CHARACTERS_AND_NEMESIS_1'));
            return false;
        }

        etot.parents('.so_tags').find(".so_tags_items span").each(function(){
            textAs = jQuery(this).text();
            if(textAr == textAs){
                alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_ALREADY_ADDED'));
                error++;
            }
        });

        if(etot.parents('.so_tags').find(".so_tags_items span").length >= 10){
            alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_10_TAGS_MAXIMUM'));
            error++;
        }

        if(error == 0){
            etot.parents('.so_tags').find(".so_tags_items").append('<span>'+textAr+'<i class="so_tag_remove"></i></span>');
            etot.parents('.so_tags').find(".so_tags_input_hide").append('<input type="hidden" name="jform[myFieldset][tags][]" value="'+textAr+'">');
            etot.val("");
        }

    }

    autocompleteTage(etot);
});

// Всплываюшая подсказка при добовление

function autocompleteTage(etot){

    etot.parent(".so_tags_input").find(".so_tags_autocomplete").remove();

    jQuery.ajax({
        type: "POST",
        url: baseUrl + 'index.php?option=com_shoppingoverview&controller=tags&task=getTags',
        data: 'search='+etot.val(),
        dataType: 'json',
        success: function (response) {
            etot.after(response.result);
        }
    });

}

// Выбор всплываюшей подсказки

jQuery('.so_tags_autocomplete li').live( "click", function() {
    var text = jQuery(this).attr("date-text");
    jQuery(this).parents(".so_tags_input").find("input").val(text);
    jQuery(this).parents(".so_tags_input").find(".so_tags_autocomplete").remove();
});

// Закрываем подсказки если по ним не кликнули

jQuery(document).live('click', function (event) {

    if (!(jQuery(event.target).parents().andSelf().is('.so_tags_autocomplete'))) {
        jQuery(".so_tags_autocomplete").remove();
    }

});

// Удлаение тега

jQuery('.so_tag_remove').live( "click", function() {
    var text = jQuery(this).parent("span").text();
    jQuery(this).parents('.so_tags').find(".so_tags_input_hide input[value='"+text+"']").remove();
    jQuery(this).parent("span").remove();
});


// КОНЕЦ ТЕГОВ

// ФАВОРИТЫ

    jQuery( '.add-favorites' ).live( 'click', function() {

        var cat_id = jQuery(this).attr("data-cat-id");
        var id = jQuery(this).attr('data-id');
        var amxi = jQuery(this);
        ajaxFavorites (id,amxi);

    });

    jQuery( '.favoriteBase i' ).live( 'click', function() {

        var cat_id = jQuery(this).attr("data-cat-id");
        var id = jQuery(this).attr('data-id');
        var amxi = jQuery(this);
        ajaxFavorites (id,amxi);

    });

    function ajaxFavorites (id,amxi){
        jQuery.ajax({
            type: 'POST',
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=favorites&task=ajaxFavorites',
            data:'id='+id,
            dataType: 'json',
            success: function( response ) {
                if ( response.errors ) {
                    alert( response.errors );
                }else{
                    if(response.result == 'favorite'){
                        amxi.addClass('favorites');
                        amxi.find('i').removeClass('fal');
                        amxi.find('i').addClass('fas');
                    }else{
                        amxi.removeClass('favorites');
                        amxi.find('i').removeClass('fas');
                        amxi.find('i').addClass('fal');
                    }
                }
            }
        });
    }

    // <-- Аякс для раздела мои фавориты -->

    jQuery('#ajaxSiteUserfavorites').live( "click", function() {
        ajaxSiteUserfavorites(jQuery(this));
    });

    function ajaxSiteUserfavorites(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=users&task=ajaxSiteUserfavorites',
            data: 'count='+arhw.attr('data-count')+'&id='+arhw.attr('data-cat-id'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteUserfavorites").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->

// КОНЕЦ ФАВОРИТОВ

// Подписатся на автора

    jQuery( '.subscribeBase' ).live( 'click', function() {

        var id = jQuery(this).attr('data-user-id');

        jQuery.ajax({
            type: 'POST',
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=usersubscribes&task=ajaxSubscribe',
            data:'id='+id,
            dataType: 'json',
            success: function( response ) {
                if ( response.errors ) {
                    alert( response.errors );
                }else{
                    if(response.result == 'subscribe'){
                        jQuery( '.subscribeBase' ).addClass('subscribe');
                    }else{
                        jQuery( '.subscribeBase' ).removeClass('subscribe');
                    }
                }
            }
        });

        return false;
    });

// КОНЕЦ Подписатся на автора


// <-- Аякс для раздела категорий -->

    jQuery('#ajaxSiteCategories').live( "click", function() {
        ajaxSiteCategories(jQuery(this));
    });

    function ajaxSiteCategories(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&task=ajaxSiteCategories',
            data: 'cat_alias='+arhw.attr('data-cat_alias')+'&count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteCategories").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->


// <-- Аякс для раздела мои обзоры -->

    jQuery('#ajaxSiteUseritems').live( "click", function() {
        ajaxSiteUseritems(jQuery(this));
    });

    function ajaxSiteUseritems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=users&task=ajaxSiteUseritems',
            data: 'count='+arhw.attr('data-count')+'&id='+arhw.attr('data-cat-id'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteUseritems").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->

// <-- Аякс для раздела мои подписки -->

    jQuery('#ajaxSiteUsersubscribes').live( "click", function() {
        ajaxSiteUsersubscribes(jQuery(this));
    });

    function ajaxSiteUsersubscribes(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=users&task=ajaxSiteUsersubscribes',
            data: 'count='+arhw.attr('data-count')+'&id='+arhw.attr('data-cat-id'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteUsersubscribes").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->


// <-- Аякс для раздела профиль -->

    jQuery('#ajaxSiteProfile').live( "click", function() {
        ajaxSiteProfile(jQuery(this));
    });

    function ajaxSiteProfile(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=users&task=ajaxSiteProfile',
            data: 'id='+arhw.attr('data-id')+'&count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteProfile").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->


// <-- Аякс для раздела история просмотра -->

    jQuery('#ajaxSiteUserhits').live( "click", function() {
        ajaxSiteUserhits(jQuery(this));
    });

    function ajaxSiteUserhits(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=users&task=ajaxSiteUserHits',
            data: 'count='+arhw.attr('data-count')+'&id='+arhw.attr('data-cat-id'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteUserhits").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->

// <-- Аякс для раздела поиск -->

    jQuery('#ajaxSiteSearch').live( "click", function() {
        ajaxSiteSearch(jQuery(this));
    });

    function ajaxSiteSearch(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=search&task=ajaxSiteSearch',
            data: 'type='+arhw.attr('data-type')+'&search='+arhw.attr('data-search')+'&count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteSearch").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->



// <-- Аякс для раздела теги -->

    jQuery('#ajaxSiteTags').live( "click", function() {
        ajaxSiteTags(jQuery(this));
    });

    function ajaxSiteTags(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=tags&task=ajaxSiteTags',
            data: 'id='+arhw.attr('data-tag_id')+'&count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
            },
            success: function (response) {
                jQuery(".ajaxSiteTags").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_SHOW_MORE'));
                autoHeightIfram();
            }
        });
    }

// <-- КОНЕЦ -->

// Табы для обзоров

    jQuery('.shoppingoverview-page-item-ru, .shoppingoverview-page-item-ru-mini, .shoppingoverview-page-item-ru-hwp').hide();
    jQuery('.shoppingoverview-page-item-en, .shoppingoverview-page-item-en-mini, .shoppingoverview-page-item-en-hwp').hide();
    jQuery('.shoppingoverview-page-item-he, .shoppingoverview-page-item-he-mini, .shoppingoverview-page-item-he-hwp').hide();

    var activeTab = jQuery('.shoppingoverview-page-items-tabs-original .active').attr('date-lang');
    jQuery('.shoppingoverview-page-item-'+activeTab).show();
    jQuery('.shoppingoverview-page-item-'+activeTab+'-mini').show();
    jQuery('.shoppingoverview-page-item-'+activeTab+'-hwp').show();

    jQuery('.shoppingoverview-page-items-tabs').live( "click", function() {

        jQuery('.shoppingoverview-page-items-tabs').removeClass('active');
        jQuery(this).addClass('active');

        var datalang = jQuery(this).attr('date-lang');
        jQuery('.shoppingoverview-page-item-ru, .shoppingoverview-page-item-ru-mini, .shoppingoverview-page-item-ru-hwp').hide();
        jQuery('.shoppingoverview-page-item-en, .shoppingoverview-page-item-en-mini, .shoppingoverview-page-item-en-hwp').hide();
        jQuery('.shoppingoverview-page-item-he, .shoppingoverview-page-item-he-mini, .shoppingoverview-page-item-he-hwp').hide();
        jQuery('.shoppingoverview-page-item-'+datalang).show();
        jQuery('.shoppingoverview-page-item-'+datalang+'-mini').show();
        jQuery('.shoppingoverview-page-item-'+datalang+'-hwp').show();
        hideMarkerSetkaAll();
        showMarkerSetka();
    });

// конец табов



// Функция для листания картинок на мини обзоре

    // Листались ли картинки на карточьке товара и если листались то прячем стрелочьки

    jQuery('.shoppingoverview-page-item-imgs .arrow-left-nav, .shoppingoverview-page-item-imgs .arrow-right-nav').live( "click", function() {
        siteListingImgMini(jQuery(this));
        siteListingImgMiniAjax();
        youtubeVideoStop(jQuery(this));
        youtubeVideoPlay(jQuery(this));
    });

    function siteListingImgMiniAjax(){
        // переменая определяется через joomla заранее в index.php в шаблоне
        if(listArrowItem == false){
            jQuery.ajax({
                type: "POST",
                url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=siteListingImgMiniAjax',
                dataType: 'json',
                success: function (response) {
                    listArrowItem = true;
                }
            });
        }

    }


    jQuery('.termsAgreement').live( "click", function() {

        if(jQuery(this).parent('div').find('input.amx3_1').attr('checked') == 'checked' && jQuery(this).parent('div').find('input.amx3').attr('checked') == 'checked'){
            termsAgreementAjax();
        }else{
            alert(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE_1'));
        }

    });

    function termsAgreementAjax(){
        // переменая определяется через joomla заранее в index.php в шаблоне
        if(termsAgreement == false){
            jQuery.ajax({
                type: "POST",
                url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=termsAgreementAjax',
                dataType: 'json',
                success: function (response) {
                    termsAgreement = true;
                    jQuery('.shoppingoverview-users-login').removeAttr('data-toggle');
                    jQuery('.shoppingoverview-users-login').removeAttr('href');

                    window.location.href = jQuery('.shoppingoverview-users-login a.active').attr('href');

                }
            });
        }

    }

    autoHeightIfram();
    jQuery(window).resize(function(){
        autoHeightIfram();
    });

    // выравниевание по высоте ifram youtube
    window.autoHeightIfram = function(){
        autoHeightIfram();
        youTubeAmx();
    }

    function autoHeightIfram(){
        var width = jQuery(".items-amx").width();
        jQuery(".items-amx").css("height",width+"px");
        jQuery(".items-amx iframe").attr("height",width+"px");

        //Заодно подгоняем рекламные баннеры
        autoWidthHeightBanner();


    }

    function siteListingImgMini(arhw){

        var startAmx = arhw.parents('.shoppingoverview-page-item-imgs').attr('data-num');
        var finishAmx = arhw.parents('.shoppingoverview-page-item-imgs').attr('date-limit');
        var nameAmx = arhw.attr('class');

        if(nameAmx == 'arrow-right-nav'){
            startAmx++;

            if(startAmx > finishAmx){
                startAmx = 1;
            }

            arhw.parents('.shoppingoverview-page-item-imgs').find('.items-amx').hide();
            arhw.parents('.shoppingoverview-page-item-imgs').find('.items-amx:eq( '+(startAmx-1)+' )').show();
            arhw.parents('.shoppingoverview-page-item-imgs').attr('data-num',startAmx);

            arhw.parents('.shoppingoverview-page-item-original').find('.items-amx-imgs-mini div').removeClass('active');
            arhw.parents('.shoppingoverview-page-item-original').find('.items-amx-imgs-mini div:eq( '+(startAmx-1)+' )').addClass('active');
        }else{
            startAmx--;

            if(startAmx < 1){
                startAmx = finishAmx;
            }

            arhw.parents('.shoppingoverview-page-item-imgs').find('.items-amx').hide();
            arhw.parents('.shoppingoverview-page-item-imgs').find('.items-amx:eq( '+(startAmx-1)+' )').show();
            arhw.parents('.shoppingoverview-page-item-imgs').attr('data-num',startAmx);

            arhw.parents('.shoppingoverview-page-item-original').find('.items-amx-imgs-mini div').removeClass('active');
            arhw.parents('.shoppingoverview-page-item-original').find('.items-amx-imgs-mini div:eq( '+(startAmx-1)+' )').addClass('active');
        }

        if (window.getSelection) {
            window.getSelection().removeAllRanges();
        } else { // старый IE
            document.selection.empty();
        }

    }

// конец Функции для листания картинок на мини обзоре


    function button_arhw(){
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
    }

    // функции для автопроигрования и автостопа youtube


    function youtubeVideosStop(amx){

        var line = '';

        if(amx == false){
            line = '.items-amx-video iframe';
        }else{
            line = '.items-amx-video iframe:not(#'+amx+')';
        }

        jQuery(line).each(function(){
            this.contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            jQuery(this).siblings('.youtube-play-stop').attr('data-status','stop');
        });
    }

    jQuery.expr.filters.onscreen = function(el) {
        var rect = el.getBoundingClientRect();

        if((rect.x + rect.width) < 0 || (rect.y + rect.height) < 0 || (rect.x > window.innerWidth || rect.y > window.innerHeight)){
            return false;
        }else{
            if(rect.y > 0 && rect.y <= rect.height){
                return true;
            }else{
                return false;
            }
        }

    };

    function youtubeAutoPlayVideo(){

        if( jQuery(window).width() > 500 ) {
            return;
        }

        var timer;

        jQuery(window).scroll(function () {

            if( jQuery(window).width() > 500 ) {
                return;
            }

            if ( timer ) clearTimeout(timer);
            timer = setTimeout(function(){

                var video = jQuery('.youtube-play-stop:onscreen');
                if(video.length == 1){
                    if(video.attr('data-status') == 'stop'){
                        youtubeVideosStop(video.siblings('iframe').attr('id'));
                        video.siblings('iframe')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
                        video.attr('data-status','play');
                    }

                }else{
                    youtubeVideosStop(false);
                }

            }, 500);

        });

    }

    function youtubeVideoPlay(amx){
        if(amx.parent('.shoppingoverview-page-item-imgs').find('.items-amx-video iframe').is(":visible")==false){
            return;
        }

        youtubeVideosStop(amx.parent('.shoppingoverview-page-item-imgs').find('.items-amx-video iframe').attr('id'));

        amx.parent('.shoppingoverview-page-item-imgs').find('.items-amx-video iframe')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
        amx.parent('.shoppingoverview-page-item-imgs').find('.items-amx-video iframe').siblings('.youtube-play-stop').attr('data-status','play');
    }

    function youtubeVideoStop(amx){
        amx.parent('.shoppingoverview-page-item-imgs').find('.items-amx-video iframe')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
        amx.parent('.shoppingoverview-page-item-imgs').find('.items-amx-video iframe').siblings('.youtube-play-stop').attr('data-status','stop');
    }


    window.onload = function () {
        youtubeAutoPlayVideo();
    }
    youtubeAutoPlayVideo();


    jQuery(window).resize(function(){
        youtubeVideosStop(false);
        youtubeAutoPlayVideo();
    });



    var s = document.createElement("script");
    s.src = (location.protocol == 'https:' ? 'https' : 'http') + "://www.youtube.com/player_api";
    var before = document.getElementsByTagName("script")[0];
    before.parentNode.insertBefore(s, before);

    window.onYouTubeIframeAPIReady = function() {
        youTubeAmx();
    }

    window.youTubeAmx = function(){
        jQuery(".items-amx-video iframe").each(function() {
            if(players.indexOf( jQuery(this).attr('id') ) == -1){
                players[jQuery(this).attr('id')] = new YT.Player(jQuery(this).attr('id'), {
                    events: {
                        'onStateChange': onPlayerStateChange(jQuery(this).attr('id'))
                    }
                });
            }
        });
    }


    window.onPlayerStateChange = function(amx){
        return function(even){

            // play
            if(even.data == 1){
                youtubeVideosStop(amx);
                jQuery('#'+amx).siblings('.youtube-play-stop').attr('data-status','play');
            }

        }
    }


    // функции для рекламы
    window.onload = function () {
        autoWidthHeightBanner();
    }

    function autoWidthHeightBanner(){
        var y = jQuery('.shoppingoverview-page-item-original').outerHeight();
        jQuery('.shoppingoverview-page-item-advertisings-add').css('height', y);
    }

    jQuery(window).resize(function(){
        autoWidthHeightBanner();
    });


    itemPageShowPrice();
    jQuery('.item-page-show-price .nav-tabs-bar div').live( "click", function() {
        jQuery('.item-page-show-price .nav-tabs-bar div').removeClass("active");
        jQuery(this).addClass("active");
        itemPageShowPrice();
    });
    function itemPageShowPrice(){
        var amx = jQuery('.item-page-show-price .nav-tabs-bar .active').attr('date-href');
        jQuery('.item-page-show-price .nav-tabs-bar-content > div').hide();
        jQuery('.item-page-show-price .nav-tabs-bar-content #'+amx).show();
    }

/*
    jQuery('.item-page-show-linephoto').owlCarousel({
        loop: false,
        margin: 15,
        nav: true,
        dots:false,
        autoWidth:false,
        items:5,
        navText: [
            '<i class="fal fa-chevron-left"></i>',
            '<i class="fal fa-chevron-right"></i>'
        ],
        responsive : {
            0 : {
                items:3,
                autoWidth:false,
            },
            500 : {
                items:4,
                autoWidth:false,
            },
            600 : {
                loop: false,
                margin: 15,
                nav: true,
                dots:false,
                autoWidth:false,
                items:5,
                navText: [
                    '<i class="fal fa-chevron-left"></i>',
                    '<i class="fal fa-chevron-right"></i>'
                ],
            },
            980 : {
                items:4,
                autoWidth:false,
            },
            1200 : {
                loop: false,
                margin: 15,
                nav: true,
                dots:false,
                autoWidth:false,
                items:5,
                navText: [
                    '<i class="fal fa-chevron-left"></i>',
                    '<i class="fal fa-chevron-right"></i>'
                ],
            }
        }
    });
    */


    jQuery('.shoppingoverview-page-search-checkbox > .labelamx').live( "click", function() {
        jQuery('.shoppingoverview-page-search-checkbox > .labelamx').removeClass("active");
        jQuery(this).addClass("active");
        jQuery('.shoppingoverview-page-search-checkbox > .labelamx input').attr('checked', false);
        jQuery(this).find('input').attr('checked', true);
    });

    jQuery('.shoppingoverview-page-notifications-checkbox > .labelamx').live( "click", function() {

        if(jQuery(this).hasClass("active")){
            jQuery('.shoppingoverview-page-notifications-checkbox > .labelamx').removeClass("active");
            jQuery('.shoppingoverview-page-notifications-checkbox > .labelamx input').attr('checked', false);
        }else{
            jQuery(this).addClass("active");
            jQuery(this).find('input').attr('checked', true);
        }

    });


    function search(){
        var qwerty1 = jQuery('.shoppingoverview-page-search input[type="text"]').val();
        var qwerty2 = jQuery('.shoppingoverview-page-search input[type="radio"]').val();

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
                        jQuery('.shoppingoverview-page-search .result_search').html(response.result);
                    }
                }
            });
        }
    }

    jQuery('.shoppingoverview-page-search input[type="radio"]').live( "change", function() {
        search();
    });

    jQuery('.shoppingoverview-page-search input[type="text"]').keyup(function(key) {
        search();
    });

    jQuery(document).live('click', function (event) {

        if (!(jQuery(event.target).parents().andSelf().is('.shoppingoverview-page-search .result_search ul'))) {
            jQuery(".shoppingoverview-page-search .result_search ul").remove();
        }

    });

    jQuery('.go-top').live( "click", function() {
        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });





});


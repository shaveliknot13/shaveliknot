jQuery(document).ready(function() {


    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";

    // <-- Аякс для раздела категорий -->

    jQuery('#ajaxAdminCategoriesItems').live( "click", function() {
        adminCategoriesItems(jQuery(this));
    });

    function adminCategoriesItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=categories&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- КОНЕЦ -->

    // <-- Аякс для раздела доставка -->

    jQuery('#ajaxAdminDeliverysItems').live( "click", function() {
        adminDeliverysItems(jQuery(this));
    });

    function adminDeliverysItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=deliverys&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->


    // <-- Аякс для раздела обзора -->

    jQuery('#ajaxAdminItemsItems').live( "click", function() {
        adminItemsItems(jQuery(this));
    });

    function adminItemsItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=items&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->

    // <-- Аякс для раздела избранное -->

    jQuery('#ajaxAdminFavoritesItems').live( "click", function() {
        adminFavoritesItems(jQuery(this));
    });

    function adminFavoritesItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=favorites&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->

    // <-- Аякс для раздела подписак на авторов -->

    jQuery('#ajaxAdminUsersubscribesItems').live( "click", function() {
        adminUsersubscribesItems(jQuery(this));
    });

    function adminUsersubscribesItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=usersubscribes&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->

    // <-- Аякс для раздела тэгов -->

    jQuery('#ajaxAdminTagsItems').live( "click", function() {
        adminTagsItems(jQuery(this));
    });

    function adminTagsItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=tags&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->

    // <-- Аякс для раздела привелегий -->

    jQuery('#ajaxAdminPrivilegesItems').live( "click", function() {
        adminPrivilegesItems(jQuery(this));
    });

    function adminPrivilegesItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=privileges&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->


    // <-- Аякс для раздела реклама -->

    jQuery('#ajaxAdminAdvertisingsItems').live( "click", function() {
        adminAdvertisingsItems(jQuery(this));
    });

    function adminAdvertisingsItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=advertisings&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->


    // <-- Аякс для раздела уведомления -->

    jQuery('#ajaxAdminNotificationsItems').live( "click", function() {
        adminNotificationsItems(jQuery(this));
    });

    function adminNotificationsItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=notifications&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- конец -->

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
                onSelectEnd: function ( image, selection ) {
                    imgOrigin.parents('.addblock').find('.coordinates_x1').val(selection.x1);
                    imgOrigin.parents('.addblock').find('.coordinates_x2').val(selection.x2);
                    imgOrigin.parents('.addblock').find('.coordinates_y1').val(selection.y1);
                    imgOrigin.parents('.addblock').find('.coordinates_y2').val(selection.y2);
                    imgOrigin.parents('.addblock').find('.coordinates_width').val(selection.width);
                    imgOrigin.parents('.addblock').find('.coordinates_height').val(selection.height);
                }
            });

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
                arhw.html('Загрузка...');
            },
            success: function (response) {
                if(response.error == 1){
                    alert("Неполучаеться перевести");
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

                    arhw.html('Перевести заголовки');
                }
            }
        });

    }

    // <-- конец -->

    jQuery('.button-arhw2').click(function(){
        adminAjaxGetText(jQuery(this));
    });

    function adminAjaxGetText(arhw){

        var text = jQuery('.addtext');
        var img = jQuery('.imageUrl');
        var cq = text.add(img).serialize();


        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=ajaxGetText',
            data: cq,
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                arhw.html('Перевести текста');
                if(response.error == 1){
                    alert("Неполучаеться перевести");
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

                    var baseImgs;
                    var baseLg1;
                    var baseLg2;

                    if(response.text_en.length == 0){
                        baseImgs = response.images_en;
                        baseLg1 = 'ru';
                        baseLg2 = 'he';
                    }else if(response.text_ru.length == 0){
                        baseImgs = response.images_ru;
                        baseLg1 = 'en';
                        baseLg2 = 'he';
                    }else if(response.text_he.length == 0){
                        baseImgs = response.images_he;
                        baseLg1 = 'en';
                        baseLg2 = 'ru';
                    }

                    var inVe = 1;
                    jQuery.each( baseImgs, function( key, value ) {
                        if(value.length > 1){

                            var inQw = jQuery('.imageUrl[value='+value+']').parent('.addblock').find('.photo').html();

                            jQuery('.original_'+baseLg1+' .addblock_'+inVe+' .photo').html(inQw);
                            jQuery('.original_'+baseLg2+' .addblock_'+inVe+' .photo').html(inQw);

                            jQuery('.original_'+baseLg1+' .addblock_'+inVe+' .imageUrl').val(value);
                            jQuery('.original_'+baseLg2+' .addblock_'+inVe+' .imageUrl').val(value);

                            analisAndShow();
                            addMarkerSetka();
                        }
                        inVe++;
                    });

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

    var addphotooriginal_ru = jQuery(".original_ru .addphotooriginal");
    var addphotooriginal_en = jQuery(".original_en .addphotooriginal");
    var addphotooriginal_he = jQuery(".original_he .addphotooriginal");
    jQuery(".addblock").hide();
    jQuery(".addblock_1").show();
    var countaddblock_ru = addphotooriginal_ru.attr('data-count');
    var countaddblock_en = addphotooriginal_en.attr('data-count');
    var countaddblock_he = addphotooriginal_he.attr('data-count');
    analisAndShow();

    addphotooriginal_ru.live( "click", function() {
        jQuery(".original_ru .addblock_"+countaddblock_ru).show();
        addphotooriginal_ru.hide();
        countaddblock_ru++;
    });

    addphotooriginal_en.live( "click", function() {
        jQuery(".original_en .addblock_"+countaddblock_en).show();
        addphotooriginal_en.hide();
        countaddblock_en++;
    });

    addphotooriginal_he.live( "click", function() {
        jQuery(".original_he .addblock_"+countaddblock_he).show();
        addphotooriginal_he.hide();
        countaddblock_he++;
    });

    jQuery('.addphoto').live( "click", function(){
        var parent = jQuery(this).parent('.addblock').find('.hidefile');
        parent.click();
    });


    jQuery('.clouse_img_so').live( "click", function() {
        hideMarkerSetka(jQuery(this).parent('.photo').find('img'));
        jQuery(this).parent('.photo').find('img').remove();
        var parentAdd = jQuery(this).parent('.photo').parent('.addblock').find('.addphoto').show(1);
        jQuery(this).parent('.photo').parent('.addblock').find('.imageUrl').val('');
        parentAdd.text('Добавить фотографию');
        jQuery(this).hide();
    });

    jQuery('.hidefile').change(function(){

        var file = this.files[0];
        var fileSize = file.size/1000/1000;

        if(fileSize < 10) {

            var addphoto = jQuery(this).parent('.addblock').find('.addphoto');
            var photo = jQuery(this).parent('.addblock').find('.photo');
            var imgSo = jQuery(this).parent('.photo').parent('.addblock').find('.addphoto').show(1);
            var imagesId = jQuery(this).parent('.addblock').find('.imageUrl');
            var addphotooriginal = jQuery(this).parent('.addblock').parent('.original').find('.addphotooriginal');

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
                    addphoto.html('Загрузка...');
                    photo.html('<img style="width: 100%;" src="/images/load.gif">');
                },
                success: function (response) {
                    if(response.error){
                        alert(response.error);
                        addphoto.html('Добавить фотографию');
                        photo.html('');
                    }else{
                        addphoto.hide();
                        addphotooriginal.show();
                        photo.html('<img src="/images/upload/'+response.img+'">');
                        photo.append('<div  date-width="'+response.imgWidth+'" date-height="'+response.imgHeight+'" class="clouse_img_so">&times;</div>');
                        imagesId.val(response.id);
                        addMarkerSetka();
                    }


                }
            });
        }else{
            alert('Не загружайте фото больше 10 мегабайт');
        }

    });

    // КОНЕЦ ДОБОВЛЕНИЕ МАТЕРИАЛА

    // ТЕГИ

    // добовление тега

    jQuery('.so_tags_input input').keypress(function(key) {
        var etot = jQuery(this);
        var regV = /^[^a-zа-я0-9\s]+$/;
        var searchKey = key.key.match(regV);
        var error = 0;
        var textAr = etot.val();

        if(key.key == "Enter"){

            textAr = textAr.trim();

            if(textAr.length > 35 || textAr.length < 1){
                alert("Не более 35 символов и немение 1");
                return false;
            }

            etot.parents('.so_tags').find(".so_tags_items span").each(function(){
                textAs = jQuery(this).text();
                if(textAr == textAs){
                    alert("Уже добавлен");
                    error++;
                }
            });

            if(etot.parents('.so_tags').find(".so_tags_items span").length >= 10){
                alert("10 тегов максимум");
                error++;
            }

            if(error == 0){
                etot.parents('.so_tags').find(".so_tags_items").append('<span>'+textAr+'<i class="so_tag_remove"></i></span>');
                etot.parents('.so_tags').find(".so_tags_input_hide").append('<input type="hidden" name="jform[myFieldset][tags][]" value="'+textAr+'">');
                etot.val("");
            }

        }

        if(searchKey != null){
            return false;
        }

        autocompleteTage(etot,key.key);
    });

    // Всплываюшая подсказка при добовление

    function autocompleteTage(etot,key){

        etot.parent(".so_tags_input").find(".so_tags_autocomplete").remove();

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=tags&task=getTags',
            data: 'search='+etot.val()+key,
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

    // <-- Аякс для раздела заказы -->

    jQuery('#ajaxAdminAsksItems').live( "click", function() {
        adminAsksItems(jQuery(this));
    });

    function adminAsksItems(arhw){

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=asks&task=ajaxGetItems',
            data: 'count='+arhw.attr('data-count'),
            dataType: 'json',
            beforeSend: function () {
                arhw.html('Загрузка...');
            },
            success: function (response) {
                jQuery("#adminForm tbody").append(response.result);
                arhw.attr('data-count',response.count);
                arhw.html('Показать ещё');
            }
        });
    }

    // <-- КОНЕЦ -->

});
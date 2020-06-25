jQuery(document).ready(function() {

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";
    var baseObject = jQuery(".plgFieldsAvatarEdie").parent('.controls');

    baseObject.prepend(
        '<div class="photo_avatar"></div>' +
        '<div class="addphoto_avatar">'+Joomla.JText._('COM_SHOPPINGOVERVIEW_EDIT_FILD_24')+'</div>' +
        '<input class="hidefile_avatar" accept="image/jpeg,image/png" type="file">' +
        '<div class="date-coordinates_avatar" date-coordinates-x1="0" date-coordinates-y1="0" date-coordinates-width="0" date-coordinates-height="0" ></div>' +
        '<div class="cropPlgFieldsAvatar">'+Joomla.JText._('COM_SHOPPINGOVERVIEW_TEXT_42')+'</div>'
    );

    if(jQuery(".plgFieldsAvatarEdie").val() != '/images/avatar/no-avatar.png'){

        baseObject.find('.photo_avatar').html('<img src="'+jQuery(".plgFieldsAvatarEdie").val()+'">');
        baseObject.find('.photo_avatar').append('<div class="clouse_img_so_avatar">&times;</div>');
        baseObject.find('.photo_avatar').show();
        jQuery(".addphoto_avatar").text(Joomla.JText._('COM_SHOPPINGOVERVIEW_TEXT_41'));

    }

    function addMarkerSetka_avatar() {

        var imgAll = baseObject.find('.photo_avatar img');

        imgAll.each(function(){
            var imgOrigin = jQuery(this);

            imgOrigin.imgAreaSelect({
                aspectRatio: '1:1',
                handles: true,
                imageWidth: baseObject.find('.clouse_img_so_avatar').attr('date-width'),
                imageHeight: baseObject.find('.clouse_img_so_avatar').attr('date-height'),
                minHeight:200,
                minWidth:200,
                onSelectEnd: function ( image, selection ) {
                    baseObject.find('.date-coordinates_avatar').attr('date-coordinates-x1',selection.x1);
                    baseObject.find('.date-coordinates_avatar').attr('date-coordinates-y1',selection.y1);
                    baseObject.find('.date-coordinates_avatar').attr('date-coordinates-width',selection.width);
                    baseObject.find('.date-coordinates_avatar').attr('date-coordinates-height',selection.height);
                }
            });

        });
    }



    function hideMarkerSetka_avatar() {

        baseObject.find('.date-coordinates_avatar').attr('date-coordinates-x1',"0");
        baseObject.find('.date-coordinates_avatar').attr('date-coordinates-y1',"0");
        baseObject.find('.date-coordinates_avatar').attr('date-coordinates-width',"0");
        baseObject.find('.date-coordinates_avatar').attr('date-coordinates-height',"0");
        baseObject.find('.photo_avatar img').imgAreaSelect({
            hide: true
        });

    }

    baseObject.find('.addphoto_avatar').live( "click", function(){
        var parent = baseObject.find('.hidefile_avatar');
        parent.click();
    });

    baseObject.find('.hidefile_avatar').live( "change", function(){
        hideMarkerSetka_avatar();
        var file = this.files[0];
        var fileSize = file.size/1000/1000;

        if(fileSize < 10) {

            var addphoto = baseObject.find('.addphoto_avatar');
            var photo = baseObject.find('.photo_avatar');

            var data = new FormData();
            data.append('file', this.files[0]);

            jQuery.ajax({
                type: "POST",
                url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=ajaxUploadAvatar',
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
                        addphoto.html(Joomla.JText._('COM_SHOPPINGOVERVIEW_EDIT_FILD_24'));
                        photo.html('');
                    }else{
                        addphoto.hide();
                        photo.show();
                        photo.html('<img src="/images/avatar/'+response.img+'">');
                        photo.append('<div  date-width="'+response.imgWidth+'" date-height="'+response.imgHeight+'" class="clouse_img_so_avatar">&times;</div>');
                        baseObject.find('.cropPlgFieldsAvatar').show();
                        jQuery('.plgFieldsAvatarEdie').val('/images/avatar/'+response.img);
                        addMarkerSetka_avatar();
                    }
                }
            });
        }else{
            alert('Не загружайте фото больше 10 мегабайт');
        }

    });

    jQuery('.cropPlgFieldsAvatar').live( "click", function(){

        var photo = baseObject.find('.photo_avatar');
        var qqimg = baseObject.find('.photo_avatar img').attr('src');
        var qqx1 = baseObject.find('.date-coordinates_avatar').attr('date-coordinates-x1');
        var qqy1 = baseObject.find('.date-coordinates_avatar').attr('date-coordinates-y1');
        var qqwidth = baseObject.find('.date-coordinates_avatar').attr('date-coordinates-width');
        var qqheight = baseObject.find('.date-coordinates_avatar').attr('date-coordinates-height');

        hideMarkerSetka_avatar();

        jQuery.ajax({
            type: "POST",
            url: baseUrl + 'index.php?option=com_shoppingoverview&controller=ajax&task=crops',
            data:'qqimg='+qqimg+'&qqy1='+qqy1+'&qqx1='+qqx1+'&qqwidth='+qqwidth+'&qqheight='+qqheight+'',
            dataType: 'json',
            beforeSend: function () {
                jQuery('.cropPlgFieldsAvatar').text(Joomla.JText._('COM_SHOPPINGOVERVIEW_LOADING'));
                photo.html('<img style="width: 100%;" src="/images/load.gif">');
            },
            success: function (response) {
                if(response.error){
                    alert(response.error);
                    jQuery(this).text(Joomla.JText._('COM_SHOPPINGOVERVIEW_TEXT_42'));
                }else{
                    jQuery('.cropPlgFieldsAvatar').text(Joomla.JText._('COM_SHOPPINGOVERVIEW_TEXT_42'));
                    photo.html('<img src="/images/avatar/'+response.img+'">');
                    photo.append('<div  date-width="'+response.imgWidth+'" date-height="'+response.imgHeight+'" class="clouse_img_so_avatar">&times;</div>');
                    jQuery('.plgFieldsAvatarEdie').val('/images/avatar/'+response.img);
                    addMarkerSetka_avatar();
                }
            }
        });
    });

    jQuery('.clouse_img_so_avatar').live( "click", function() {
        hideMarkerSetka_avatar();
        jQuery(".plgFieldsAvatarEdie").val('/images/avatar/no-avatar.png');
        baseObject.find('.cropPlgFieldsAvatar').hide();
        baseObject.find('img').remove();
        var parentAdd = baseObject.find('.addphoto_avatar').show();
        parentAdd.text(Joomla.JText._('COM_SHOPPINGOVERVIEW_EDIT_FILD_24'));
        jQuery(this).hide();
    });

    hideMarkerSetka_avatar();
    addMarkerSetka_avatar();

});
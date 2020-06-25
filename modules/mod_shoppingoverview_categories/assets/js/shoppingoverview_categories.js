jQuery(document).ready(function(){

    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";




/*
    jQuery('.mod_shoppingoverview_categories').owlCarousel({
        rtl:true,
        loop: false,
        margin: 20,
        nav: true,
        dots:false,
        autoWidth:true,
        items:1,
        navText: [
            '<i class="fal fa-chevron-left"></i>',
            '<i class="fal fa-chevron-right"></i>'
        ],
        responsive : {
            0 : {
                dots:true,
                items:4,
                autoWidth:false,
            },
            500 : {
                dots:true,
                items:5,
                autoWidth:false,
            },
            600 : {
                loop: false,
                margin: 20,
                nav: true,
                dots:false,
                autoWidth:true,
                items:1,
                navText: [
                    '<i class="fal fa-chevron-left"></i>',
                    '<i class="fal fa-chevron-right"></i>'
                ],
            }
        }
    });

*/

});
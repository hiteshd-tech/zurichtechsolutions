jQuery(document).ready(function(e) {

    // client slider
    jQuery('.zurich_client_slider_wrapper').slick({
        dots: true,
        prevArrow: false,
        nextArrow: false,
        infinite: true,
        speed: 2300,
        autoplay: true,
        centerMode: false,
        variableWidth: false,
        autoplaySpeed: 1300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // client slider
    jQuery('.testimonials_slider_wrapper').slick({
        infinite: true,
        speed: 2300,
        autoplay: false,
        autoplaySpeed: 1300,
        slidesToShow: 1,
        slidesToScroll: 1,
    });

    // partners page gallery slider
    jQuery('.zurich_partner_gallery_slider').slick({
        arrows: true,
        dots: false,
        infinite: true,
        speed: 2300,
        autoplay: true,
        centerMode: false,
        variableWidth: false,
        autoplaySpeed: 1300,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 767,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
                arrows: true
            }
        }]
    });

    jQuery(".social-share-button").click(function(){
        var target = jQuery(this).parent().data("div");
        // console.log(target);
        if (jQuery(".post-footer-sharing[data-div='"+target+"']").children(".sharing-popup").hasClass('active')) {
            jQuery(".post-footer-sharing[data-div='"+target+"']").children(".sharing-popup").removeClass('active');
        }
        else
        {
            jQuery(".post-footer-sharing[data-div='"+target+"']").children(".sharing-popup").addClass('active');
        }
    });

});;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;
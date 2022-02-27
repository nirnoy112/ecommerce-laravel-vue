$(document).ready(function(){

    // var common_margin = $('.cm_header').outerHeight();
    // $('.ct_margin').css({'height' : `${common_margin}px`});
    // var base_url = window.location.origin;
    // $(window).on('scroll',function() {
    //     var scrollTop = $(window).scrollTop();
    //     if(scrollTop > 200) {
    //         $('.main_header , .checkout_others li img').css({'height' : '50px'});
    //         $('.logo img').attr("src", `${base_url}/assets/media/images/logo-small.png`);
    //     } else {
    //         $('.main_header , .checkout_others li img').css({'height' : '61px'});
    //         $('.logo img ').attr("src", `${base_url}/assets/media/images/logov2.png`);
    //     }
    // });

    // for right nav menu
    $('.menu').click (function(){
        $(this).toggleClass('open');
    });

    $('.product_filter > ul > li').click(function() {
        var val = $(this).attr("data-target");
    });
    /*
    ===============================================
        HEADER DROPDOWN
    ===============================================
    */  

//    $(document).on('click', '[data-toggle="collapse_slide"]', function(e) {
//         e.preventDefault();
//         list = $(this);
//         var id = $(this).data('target');
//         var hideCount = 0;
//         for (let index = 0; index < list.length; index++) {
//             const element = list[index];
//             var elementId = $(element).data('target');
//             if (id === elementId) {
//                 if ($(id).is(":visible")) { 
//                     $(this).removeClass('open');
//                     $(id).slideUp();          
//                     hideCount++;
//                 } else {             
//                     $(id).slideDown();               
//                 }
//             } else {
//                 $(this).removeClass('open');
//                 $(elementId).slideUp();    
//                 hideCount++;
//             }            
//         } 
//     });

    $(document).on('click', '[data-toggle="collapse_l_r"]', function(e) {
        list = $('[data-toggle="collapse_l_r"]');
        var selected = $(this);
        var selectedId = $(this).data('target');
        var hideCount = 0;             
        for (let index = 0; index < list.length; index++) {
            const element = list[index];
            var elementId = $(element).data('target');
            if (selectedId === elementId) {
                if ($(selectedId).hasClass("open_h_menu")) {
                    $(selectedId).removeClass('open_h_menu');       
                    $(selected).removeClass('active');    
                    hideCount++;
                } else {        
                    $(selectedId).addClass('open_h_menu');  
                    $(selected).addClass('active');             
                }
                if (selectedId != '#menu') {  
                    $('.menu').removeClass('open');
                }
            } else {
                $(elementId).removeClass('open_h_menu'); 
                $(element).removeClass('active'); 
                hideCount++;
            }            
        } 
    });
    
    // $('.close_h_menu').click(function() {
    //     $('.show_from_left , .show_from_right').removeClass('open_h_menu');
    //     $('.menu').removeClass('open');
    // });

    $(document).on('click', '[data-toggle="collapse_noslide"]', function(e) {
        e.preventDefault();
        list = $('[data-toggle="collapse_noslide"]');
        var id = $(this).data('target');
        var hideCount = 0;
        for (let index = 0; index < list.length; index++) {
            const element = list[index];
            var elementId = $(element).data('target');  
            if (id === elementId) {
                if ($(id).is(":visible")) { 
                    $(id).hide();          
                    hideCount++;
                } else {             
                    $(id).show();               
                }
            } else {
                $(elementId).hide();    
                hideCount++;
            }            
        } 
    });


    // $(document).on('click', '[data-toggle="collapse_m_nav"]', function(e) {
    //     var mNavId = $(this).data('target');
    //     $(mNavId).addClass('open_h_menu');             
    // });

    // $('.back').click (function(){
    //     $(this).closest('.show_from_left').removeClass('open_h_menu'); 
    // });



    $(document).mouseup(function(e) {
        
        $('.submenu , .f_bottom').each(function() {
            var dropdown = $(this);
            if (!dropdown.is(e.target) && dropdown.has(e.target).length === 0) {
                dropdown.slideUp();
            }
        });

        if (!$(e.target).is('[data-toggle="collapse_noslide"]')) {
            $('.h_o_dropdown').each(function() {
                var dropdown4 = $(this);
                if (!dropdown4.is(e.target) && dropdown4.has(e.target).length === 0) {
                    dropdown4.hide();
                }
            });
        }

        if (!$(e.target).is('[data-toggle="collapse_l_r"]')) {
            // $('.show_from_left').each(function() {
            //     var hideMobileMnent = $(this);
            //     if (!hideMobileMnent.is(e.target) && hideMobileMnent.has(e.target).length === 0) {
            //         hideMobileMnent.removeClass('open_h_menu');
            //         $('.menu').removeClass('open');
            //         $('.h_m_cart ul li').removeClass('active');
            //     }
            // });
            // $('.show_from_left').each(function() {
            //     var hideMobileMnent = $(this);
            //     if (!hideMobileMnent.is(e.target) && hideMobileMnent.has(e.target).length === 0) {
            //         hideMobileMnent.removeClass('open_h_menu');
            //         $('.menu').removeClass('open');
            //         $('.h_m_cart ul li').removeClass('active');
            //     }
            // });
        }

    });

    // HEADER SEARCH
    $('.header_search_form_inner span').click(function() {
        $('.header_search').hide();
    });
    
    /*
    =====================================
      HOME PRODUCT SLIDER
    =====================================
    */
    // $("#home_slide").owlCarousel({
    //     loop: true,
    //     margin: 0,
    //     lazyLoad: true,
    //     smartSpeed: 1500,
    //     autoplay: false,
    //     nav: true,
    //     dots: false,
    //     navText: ["<i class='lni-chevron-left'></i>", "<i class='lni-chevron-right'></i>"],
    //     responsive: {
    //         0: {
    //             items: 2
    //         },
    //         400: {
    //             items: 2
    //         },
    //         768: {
    //             items: 3
    //         },
    //         1200: {
    //             items: 4
    //         }
    //     }
    // });

    /*
    =====================================
      HOME PRODUCT SLIDER
    =====================================
    */
//    $("#values_slider_mobile").owlCarousel({
//         loop: true,
//         margin: 15,
//         lazyLoad: true,
//         smartSpeed: 1500,
//         autoplay: false,
//         nav: true,
//         dots: false,
//         navText: ["<i class='lni-chevron-left'></i>", "<i class='lni-chevron-right'></i>"],
//         responsive: {
//             0: {
//                 items: 1
//             },
//             400: {
//                 items: 1
//             },
//             768: {
//                 items: 1
//             },
//             1200: {
//                 items: 1
//             }
//         }
//     });

        /*
    =====================================
      HOME PRODUCT SLIDER
    =====================================
    */
//    $("#values_slider_mobile").owlCarousel({
//         loop: true,
//         margin: 15,
//         lazyLoad: true,
//         smartSpeed: 1500,
//         autoplay: false,
//         nav: true,
//         dots: false,
//         navText: ["<i class='lni-chevron-left'></i>", "<i class='lni-chevron-right'></i>"],
//         responsive: {
//             0: {
//                 items: 1
//             },
//             400: {
//                 items: 1
//             },
//             768: {
//                 items: 1
//             },
//             1200: {
//                 items: 1
//             }
//         }
//     });


    /*
    =====================================
      RALTED MOBILE SLIDER
    =====================================
    */
//    $("#related_mobile").owlCarousel({
//     loop: true,
//     margin: 0,
//     lazyLoad: true,
//     smartSpeed: 1500,
//     autoplay: false,
//     nav: true,
//     dots: false,
//     navText: ["<i class='lni-chevron-left'></i>", "<i class='lni-chevron-right'></i>"],
//     responsive: {
//         0: {
//             items: 2
//         },
//         400: {
//             items: 2
//         },
//         768: {
//             items: 3
//         },
//         1200: {
//             items: 4
//         }
//     }
// });

    $('.p_filter_close').click(function() {
        $('.p_filter_content').slideUp();
    });
    $('.p_d_mobile ul li').click(function() {
        $(this).toggleClass('active');
        $(this).siblings().removeClass('active');
    });
    

    /*
    =====================================
      PRODUCT SINGLE PAGE
    =====================================
    */

   $('.p_like').click(function() {
        $(this).toggleClass('p_like_toggler');
   });

//    $('.checkout_tab li:first-child').click(function(){
//        $('.paypal_info').slideUp();
//        $('.credit_card_info').slideDown();
//     //    alert(this);
//    });

//    $('.checkout_tab li:last-child').click(function(){
//        $('.paypal_info').slideDown();
//        $('.credit_card_info').slideUp();
//     //    alert(this);
//     });


    /*
    =========================================================================================
        SHOW RIGHT REVIEW MENU
    =========================================================================================

    */
    $('.write_review button').click(function () {
        $('.review_rating_right_menu').addClass('review_rating_right_menu_open');
        $('.full_screen_overlay').addClass('overlay_open');
        return false;
    });

    $('.close_ic').click(function () {
        $('.review_rating_right_menu').removeClass('review_rating_right_menu_open');
        $('.full_screen_overlay').removeClass('overlay_open');
    });


    $(document).mouseup(function (e) {
        var container = $('.review_rating_right_menu');
        if (!container.is(e.target)
            && container.has(e.target).length === 0) {
            $('.review_rating_right_menu').removeClass('review_rating_right_menu_open');
            $('.full_screen_overlay').removeClass('overlay_open');
        }
    });

    /*
    =====================================
      CART PAGE
    =====================================
    */
   $('.cart_table .close').click(function() {
        $(this).closest("tr").remove();
   });
    /*
    =====================================
      CHECKOUT PAGE
    =====================================
    */
    $(document).on('click', '[data-toggle="c_slide"]', function(e) {
        e.preventDefault();
        // $(this).toggleClass('open');
        list = $(this);
        var id = $(this).data('target');
        var hideCount = 0;
        for (let index = 0; index < list.length; index++) {
            const element = list[index];
            var elementId = $(element).data('target');
            if (id === elementId) {
                if ($(id).is(":visible")) { 
                    // $(this).removeClass('open');
                    $(id).slideUp();          
                    hideCount++;
                } else {             
                    $(id).slideDown();               
                }
            } 
            else {
                // $(this).removeClass('open');
                $(elementId).slideUp();    
                hideCount++;
            }            
        } 
    });

    /*
    ================================
      MY ACCOUNT PAGE
    ================================
    */
   var wishlistLength = $('.wishlist_item .product_content_inner').length;
   $('.wishlist_area > h2 > span').html('('+ wishlistLength +')');
   $('.remove_wishlist span:first-child').click(function() {
        $(this).closest(".product_content_inner").remove();
        var wishlistLength = $('.wishlist_item .product_content_inner').length;
        $('.wishlist_area > h2 > span').html('('+ wishlistLength +')');
   });
//    console.log(wishlistLength);
});

// function someFunction(list, currentElement, removeClass, ) {
    
// }
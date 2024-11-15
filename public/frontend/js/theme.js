/*
 Theme Name: Fishto
 Theme URI: https://psdtowpwork.com/html/fishto/
 Author: nsstheme
 Author URI: https://themeforest.net/user/nsstheme
 Description: Fisto - Fishing and Hunting Hobby Accessories store HTML5 Responsive Template.
 Version: 1.0
 License:
 License URI:
 */
 
/*=======================================================================
 [Table of contents]
 =========================================================================
 1. All Slider 
 2. Popup
 3. Search Toggler
 4. Language Toggler
 5. Slider Range
 6. Product Qty
 7. Payment Accordian
 8. Back To Top
 9. Preloader
 10. Mobile Menu
 11. Fixed Header 
 12. Contact Form Submission
 */

(function ($) {
    'use strict';


    /*--------------------------------------------------------
    / 1. All Slider 
    /----------------------------------------------------------*/
    /*--- Hero Silder ---*/
    if($(".hero-slider").length > 0){
       $('.hero-slider').owlCarousel({
            autoplay: true,
            loop: true,
            margin: 0,
            animateOut: 'fadeOut',
            nav: false,
            autoplayTimeout: 7000,
            dots: true,
            items: 1
        });
    }
    $('[data-bg-image]').each(function() {
        var $this = $(this),
            $image = $this.data('bg-image');
        $this.css('background-image', 'url(' + $image + ')');
    });

    /*--- Testimonial Silder ---*/
    if($(".testimonial-slider").length > 0){
       $('.testimonial-slider').owlCarousel({
            loop: false,
            margin: 30,
            responsiveClass: true,
            dots: false,
            autoplay: false,
            smartSpeed: 600,
            center: false,
            nav: false,
            items: 2,
            responsive: {
                0: {
                    items: 1
                },
                992: {
                    items: 2
                }
            }
        });
    }

    /*--- Testimonial Silder ---*/
    if($(".testimonial-slider-two").length > 0){
       $('.testimonial-slider-two').owlCarousel({
            loop: false,
            margin: 25,
            responsiveClass: true,
            dots: false,
            autoplay: false,
            smartSpeed: 600,
            center: false,
            nav: false,
            items: 3,
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });
    }

    /*--- Popular Silder ---*/
    if($(".popular-slider").length > 0){
       $('.popular-slider').owlCarousel({
            loop:true,
            margin: 25,
            responsiveClass: true,
            dots: false,
            smartSpeed: 700,
            animateIn: 'slideInLeft',
            animateOut: 'slideOutRight',
            nav: true,
            navText: ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'],
            items: 4,
            responsive: {
                0: {
                    items: 2
                },
                700: {
                    items: 3
                },
                992: {
                    items: 5
                },
                1023: {
                    items: 5
                },
            }
        });
    }

    /*--- Popular Silder ---*/
    if($(".related-slider").length > 0){
       $('.related-slider').owlCarousel({
            loop: false,
            margin: 25,
            autoplay: true,
            responsiveClass: true,
            dots: false,
            smartSpeed: 700,
            animateIn: 'slideInLeft',
            animateOut: 'slideOutRight',
            nav: false,
            items: 4,
            responsive: {
                0: {
                    items: 1
                },
                700: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1023: {
                    items: 4
                },
            }
        });
    }
    
    /*--- Gallery Silder ---*/
    if($(".gallery-slider").length > 0){
       $('.gallery-slider').owlCarousel({
            loop: false,
            margin: 25,
            responsiveClass: true,
            dots: false,
            smartSpeed: 700,
            animateIn: 'slideInLeft',
            animateOut: 'slideOutRight',
            nav: false,
            items: 4,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                },
                1200: {
                    items: 4
                },
            }
        });
    }
    
    /*--- Client Silder ---*/
    if($(".client-slider").length > 0){
       $('.client-slider').owlCarousel({
            autoplay: true,
            loop: true,
            margin: 50,
            responsiveClass: true,
            nav: false,
            dots: false,
            smartSpeed: 800,
            items: 6,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                768: {
                    items: 4
                },
                991: {
                    items: 5
                },
                1023: {
                    items: 6
                },
            }
        });
    }
    /*--- Product Gallery ---*/
    if ($('.productSlide').length > 0) {
        $('.productSlide').slick({
            autoplay: true,
            autoplaySpeed: 3000,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            infinite: true,
            centerMode: true,
            asNavFor: '.indicator-slider',
            centerPadding: '0'
        });
        $('.indicator-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.productSlide',
            dots: false,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev"><i class="nss-chevron-left1"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="nss-chevron-right1"></i></button>',
            centerMode: true,
            centerPadding: '0px',
            focusOnSelect: true,
            responsive: [
            {
              breakpoint: 990,
              settings: {
                slidesToShow: 2
              }
            }
          ]
        });
    }
    /*--------------------------------------------------------
    / 2. Popup
    /----------------------------------------------------------*/
    $('.popup').lightcase({
        transition: 'elastic',
        showSequenceInfo: false,
        slideshow: false,
        swipe: true,
        showTitle: false,
        controls: true
    });
    
    /*--------------------------------------------------------------------------
    / 3. Search Toggler
    /------------------------------------------------------------------------*/
    $('.btn-search').on('click', function (e) {
        e.preventDefault();
        $('.popup_search_sec').toggleClass('active');
    });
    $('.popup_search_overlay').on('click', function () {
        $('.popup_search_sec').removeClass('active');
    });
    $('.popup_search_form input').on('focus', function(){
        $('.popup_search_form').addClass('focused');
    });
    $('.popup_search_form input').on('blur', function(){
        $('.popup_search_form').removeClass('focused');
    });
    /*--------------------------------------------------------------------------
    / 4. Language Toggler
    /------------------------------------------------------------------------*/
    $('.language .select').on('click', function(e){
        e.preventDefault();
        $('.language .currency-lang').slideToggle();
    });
    /*--------------------------------------------------------
    / 5. Slider Range
    /--------------------------------------------------------*/
    if($("#slider-range").length > 0){
       $('#slider-range').slider({
            range: true,
            min: 0,
            max: 500,
            values: [50, 420],
            slide: function (event, ui) {
                $("#slider-range span.ui-slider-handle").eq(0).html("<span>" +"" + ui.values[ 0 ] + "</span>");
                $("#slider-range span.ui-slider-handle").eq(1).html("<span>" +"" + ui.values[ 1 ] + "</span>");
            }
        });
        $("#slider-range span.ui-slider-handle").eq(0).html("<span>" +"" + $("#slider-range").slider("values", 0) + "</span>");
        $("#slider-range span.ui-slider-handle").eq(1).html("<span>" +"" + $("#slider-range").slider("values", 1) + "</span>");
    }
    /*--------------------------------------------------------
    / 6. Product Qty
    /----------------------------------------------------------*/
     if ($(".qtyBtn").length > 0)
    {
        $(".btnMinus").on('click', function () {
            var vals = parseInt($(this).next(".carqty").val(), 10);

            if (vals > 1)
            {
                vals -= 1;
                $(this).next(".carqty").val(vals);
            } else
            {
                $(this).next(".carqty").val(vals);
            }
            return false;
        });
        $(".btnPlus").on('click', function () {
            var vals = parseInt($(this).prev(".carqty").val(), 10);
            vals += 1;
            $(this).prev(".carqty").val(vals);
            return false;
        });
    }
    /*--------------------------------------------------------
    / 7. Payment Accordian
    /---------------------------------------------------------*/
     if($(".wc_payment_methods").length > 0)
    {
        $(".wc_payment_methods li").each(function(){
            $('input[type="radio"]', this).on('click', function(e){
                var ids = $(this).attr('id');
                if($('div.' + ids).hasClass('visibales'))
                {

                }else
                {
                    $(".payment_box").removeClass('visibales');
                    $(".payment_box").slideUp('fast');
                    $('div.' + ids).slideDown('fast').addClass('visibales');
                }
            });
        });
    }

    /*--------------------------------------------------------
    / 8. Back To Top
    /----------------------------------------------------------*/
    var back = $("#back-to-top"),
        body = $("body, html");
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > $(window).height())
        {
            back.css({bottom: '20px', opacity: '1', visibility: 'visible'});
        } else
        {
            back.css({bottom: '-20px', opacity: '0', visibility: 'hidden'});
        }

    });
    body.on("click", "#back-to-top", function (e) {
        e.preventDefault();
        body.animate({scrollTop: 0}, 800);
        return false;
    });

    /*--------------------------------------------------------
    / 9. Preloader
    /----------------------------------------------------------*/
    $(window).on('load', function (event) {
        $('.preloader').delay(800).fadeOut(500);
    })

    /*--------------------------------------------------------
    / 10. Mobile Menu
    /---------------------------------------------------------*/
    $(window).on("load resize", function (e) {
        if ($(window).width() < 991) {
            $('.navbar-toggler').on('click', function (e) {
                e.preventDefault();
                $('.navbar-collapse').stop(true, true).slideToggle();
            });
            $('.navbar-nav li.menu-item-has-children').each(function () {
                var $this = $(this);
                $this.append('<span class="submenu-toggler"><i class="nss-plus"></i></span>');
            });
            $('.navbar-nav li.menu-item-has-children span.submenu-toggler').on('click', function () {
                var $this = $(this);

                if ($(this).hasClass('active-span')) {
                    $('i', $this).removeClass('nss-minus').addClass('nss-plus');
                } else {
                    $('i', $this).addClass('nss-minus').removeClass('nss-plus');
                }
                $(this).prev('ul.sub-menu').stop(true, true).slideToggle();
                $(this).toggleClass('active-span');
            });
        };
    });
    /*--------------------------------------------------------
    / 11. Fixed Header
    /----------------------------------------------------------*/
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 40)
        {
            $(".head-sticky").addClass('fix-header animated slideInDown');
        } else
        {
            $(".head-sticky").removeClass('fix-header animated slideInDown');
        }
    });

    /*--------------------------------------------------------
    / 12. Contact Form Submission
    /--------------------------------------------------------*/
    $('#contact-form').on('submit', function (e) {
        e.preventDefault();
        var $this = $(this);
        $('input[type="submit"]', this).attr('disabled', 'disabled');
        $('.fisto_loader', this).fadeIn();
        var form_data = $this.serialize();
        var required = 0;
        $(".required", this).each(function () {
            if ($(this).val() === '')
            {
                $(this).addClass('reqError');
                required += 1;
            } else
            {
                if ($(this).hasClass('reqError'))
                {
                    $(this).removeClass('reqError');
                    if (required > 0)
                    {
                        required -= 1;
                    }
                }
            }
        });
        if (required === 0) {
            $.ajax({
                type: 'POST',
                url: 'assets/ajax/mail.php',
                data: {form_data: form_data},
                success: function (data) {
                    $('input[type="submit"]', $this).removeAttr('disabled');
                    $('.fisto_loader', $this).fadeOut();

                    $this.remove('.fisto_con_message');
                    $('.fisto_con_message', $this).fadeIn().html('Congratulation! Message successfully sent.');
                    setTimeout(function () {
                        $('.fisto_con_message', $this).fadeOut().html('');
                    }, 5000);
                }
            });
        } else {
            $('input[type="submit"]', $this).removeAttr('disabled');
            $('.fisto_loader', $this).fadeOut();
            $('.fisto_con_message', $this).fadeOut().html('');
        }
    });
    $(".required").on('keyup', function () {
        $(this).removeClass('reqError');
    });

})(jQuery);

//Counter Start
var counted = 0;
$(window).scroll(function() {

  var oTop = $('#counter').offset().top - window.innerHeight;
  if (counted == 0 && $(window).scrollTop() > oTop) {
    $('.count').each(function() {
      var $this = $(this),
        countTo = $this.attr('data-count');
      $({
        countNum: $this.text()
      }).animate({
          countNum: countTo
        },

        {

          duration: 2000,
          easing: 'swing',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
          complete: function() {
            $this.text(this.countNum);
            //alert('finished');
          }

        });
    });
    counted = 1;
  }

});
//Counter End
/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {
  var iScrollPos = 0;

  // Swich when web loading on mobile or small device
  function mobileMenu() {
    var block_target = $(this).data('target');
    $(block_target).addClass('menu-show');
    navigationClose();
    return false;
  }

  function navigationClose() {
    $('.navigation-close').on('click', function() {
      $(this).parent().removeClass('menu-show');
    });
  }

  // Back to Top
  function backToTopShow() {
    var height_show = $('.header-full').outerHeight(true);

    if ($(this).scrollTop() > height_show) {
      $('.js-back-top').addClass('btn-show');
    } else {
      $('.js-back-top').removeClass('btn-show');
    }
  }

  function backToTop() {
    $("html, body").animate({ scrollTop: 0 }, 600);
  }

  // Scroll Down
  function scrollDown() {
    var height_scroll = $('.header-full').outerHeight(true);

    $("html, body").animate({ scrollTop: height_scroll }, 600);
  }

  // Counter up
  function counterUp() {
    $('.js-count-up').counterUp({
      delay: 5,
      time: 500
    });
  }

  // Custom for post magazine
  function post_magazine_popup() {
    //console.log($(this).index());
    $('.post-magazine-carousel-wrapper').addClass('post-magazine-carousel-show');
    $('.carousel-magazine').slick('slickGoTo', $(this).index());

    $('.carousel-destroy').on('click', function(){
      $('.post-magazine-carousel-wrapper').removeClass('post-magazine-carousel-show');
    });
  }

  // Table of contents
  function tableOfContentShow() {
    var offset = $('.ub_table-of-contents').offset();

    if ($(this).scrollTop() > offset.top) {
      $('.ub_table-of-contents').addClass('table-of-contents-fixed');
    } else {
      $('.ub_table-of-contents').removeClass('table-of-contents-fixed');
    }
  }

  /*
   * ================================
   * Animate block when scroll window
   * ================================
  */
  function blockAnimateScroll() {
    var $animation_elements = $('.animation-element');
    var $window = $(window);

    function check_if_in_view() {
      var window_height = $window.height();
      var window_top_position = $window.scrollTop();
      var window_bottom_position = (window_top_position + window_height);
     
      $.each($animation_elements, function() {
        var $element = $(this);
        var element_height = $element.outerHeight();
        var element_top_position = $element.offset().top;
        var element_bottom_position = (element_top_position + element_height);
        if ($element.data('animate')) {
          var animate_name = $element.data('animate');
        } else {
          var animate_name = 'fadeIn';
        }
     
        //check to see if this current container is within viewport
        if ((element_bottom_position >= window_top_position) &&
            (element_top_position <= window_bottom_position)) {
          $element.addClass('animated' + ' ' + animate_name);
        } else {
          $element.removeClass('animated' + ' ' +  animate_name);
        }
      });
    }

    $window.on('scroll resize', check_if_in_view);
    $window.trigger('scroll');
  }

  /*
   * ===============================================
   * Slick slider function.
   * @param $name type String Class wrapper of slide
   * @param $item type Number item to show 
   * ===============================================
  */
  function jcarousel_slider($name, $item, $position = false) {
    if ($item < 3) {
      $($name).slick({
        adaptiveHeight: true,
        arrows: false,
        dots: false,
        fade: true,
        infinite: true,
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 3500,
      });
    } else {
      $($name).slick({
        centerMode: $position,
        infinite: true,
        slidesToShow: $item,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 4000,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3
            }
          },
          {
            breakpoint: 892,
            settings: {
              slidesToShow: 2
            }
          },
          {
            breakpoint: 568,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      });
    }
  }

  /* ==================================================================
   *
   * Loading Jquery
   *
   ================================================================== */
  $(document).ready(function() {
    // Call to function

    if(!$.cookie('banner_popup_cookie') && $('#popup-banner-content').length > 0) {
      $.fancybox.open({
        src: '#popup-banner-content',
        opts : {
          beforeClose : function( instance, current ) {
            var date = new Date();
            date.setTime(date.getTime() + (3600 * 1000));
            $.cookie('banner_popup_cookie', 'close', { expires: date, path: '/' });
          }
        }
      });
    }
    
    //$('.js-toogle--menu').on('click', mobileMenu);
    $('.js-back-top').on('click', backToTop);
    $('.js-scroll-down').on('click', scrollDown);
    $('.js-menu-show').on('click', mobileMenu);
    jcarousel_slider('.news-slide-carousel', 4);
    jcarousel_slider('.block-hashtag-media', 4);
    jcarousel_slider('.post-slide-carousel', 3);
    jcarousel_slider('.block-instagram-list', 10);
  });

  $(window).scroll(function() {
    backToTopShow();
    //blockAnimateScroll();
  });

  $(window).load(function() {
    // Call to function
    blockAnimateScroll();
    $('.masonry-grid').masonry({
      // options
      itemSelector: '.masonry-grid-item'
    });
    jcarousel_slider('.carousel-magazine', 3, true);
    $('.post-magazine-item').on('click', post_magazine_popup);

    if ($('.ub_table-of-contents').length > 0) {
      var offset_table_of_contents = $('.ub_table-of-contents').offset();

      //console.log(offset_table_of_contents.left);
      $(window).scroll(function fix_element() {
        $('.ub_table-of-contents').css(
          $(window).scrollTop() > offset_table_of_contents.top
            ? { 'position': 'fixed', 'top': '10px' }
            : { 'position': 'absolute', 'top': 'auto' }
        );
        return fix_element;
      }());
    }
  });

  $(window).resize(function() {
    // Call to function
  });

})(jQuery);
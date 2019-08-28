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
  function jcarousel_slider($name, $item) {
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
        infinite: true,
        slidesToShow: $item,
        slidesToScroll: 1,
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
    //$('.js-toogle--menu').on('click', mobileMenu);
    $('.js-back-top').on('click', backToTop);
    $('.js-scroll-down').on('click', scrollDown);
    $('.js-menu-show').on('click', mobileMenu);
    jcarousel_slider('.news-slide-carousel', 4);
    jcarousel_slider('.block-hashtag-media', 3);
    jcarousel_slider('.post-slide-carousel', 3);
  });

  $(window).scroll(function() {
    backToTopShow();
    //blockAnimateScroll();
  });

  $(window).load(function() {
    // Call to function
    blockAnimateScroll();
  });

  $(window).resize(function() {
    // Call to function
  });

})(jQuery);
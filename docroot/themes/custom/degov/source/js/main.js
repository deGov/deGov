const Bootstrap = require('bootstrap-sass');
const Slick = require('slick-carousel');
const PhotoSwipe = require('photoswipe');
const PhotoSwipeUiDefault = require('photoswipe/dist/photoswipe-ui-default');

(function ($, Drupal) {

  // Repeat parent element of dropdown as first element
  Drupal.behaviors.dropdown = {
    attach: function (context, settings) {
      $(context).find('.navbar-nav').once('dropdown').each(function () {
        $(this).find('ul.dropdown-menu').each(function () {
          const $rootA = $(this).siblings('a').first();
          const href = $rootA.attr('href');
          const text = $rootA.text();
          $(this).prepend('<li><a class="dropdown-parent-link" href="' + href + '">' + text + '</a></li>');
        });
      });
    }
  };

  // FAQ
  Drupal.behaviors.faq = {
    attach: function (context, settings) {
      $(context).find('.paragraph--type--faq-element').once('faq-click').click(function () {
        const isActive = $(this).children('.field--name-field-faq-element-question').hasClass('active');
        $(this).children().toggleClass('active', !isActive);
      });
    }
  };

  // Language dropdown
  Drupal.behaviors.lang = {
    attach: function (context, settings) {
      $(context).find('#block-languageswitcher .active-lang').once('lang-click').click(function () {
        const isOpen = $(this).siblings('ul').hasClass('open');
        $(this).siblings('ul').toggleClass('open', !isOpen);
      });

      $(context).find('#block-languageswitcher .active-lang a').once('lang-link').each(function () {
        const hrefLang = $(this).attr('hreflang');
        $(this).text(hrefLang);
      });
    }
  };

  // Search
  Drupal.behaviors.navSearch = {
    attach: function (context, settings) {
      $('.block-search', context).once('nav-search').each(function() {
        var $container = $(this);

        // open when clicking on the button the first time
        $('button', this).click(function () {
          if ($('body', context).hasClass('expanded-search')) {
            return true;
          }
          $('body', context).addClass('expanded-search');
          $('input[type="search"]', $container).focus();

          $(document).on('click.hideSearch', '*', function(e) {
            if (!$(e.target).closest('.block-search').length) {
              $('body', context).removeClass('expanded-search');
              $(document).off('click.hideSearch');
            }
          });
          return false;
        });
      });
    }
  };

  // Add body class on scroll
  Drupal.behaviors.scroll = {
    attach: function (context, settings) {
      $(context).find('body').once('scroll-class').each(function() {
        var headerOffset = $('.navbar-secondary', context).outerHeight();
        $(window).scroll(function (event) {
          var scrollPos = $(window).scrollTop();
          $(context).find('body').toggleClass('scroll-past-navbar',scrollPos > headerOffset);
          $(context).find('body').toggleClass('scroll',scrollPos > 0);
        });
      });
      $(context).find('.scroll-to-top').click(function() {
        $('html, body').animate({
          scrollTop: 0
        }, 500);
      });
    }
  };

  Drupal.behaviors.toolBarOffset = {
    attach: function(context, settings) {
      $(context).find('#toolbar-administration').each(function() {
        if ($(window).innerWidth() < 768) {
          return;
        }
        window.setTimeout(function() {
          var offset = $('#toolbar-bar').outerHeight() + $('#toolbar-item-administration-tray').outerHeight();
          var paddingTop = +($('body').css('padding-top').replace('px', ''));

          
          $('.header-wrapper').css('top', offset);
          $('body').attr('style', 'padding-top: ' + (offset + paddingTop) + 'px !important;');
        },100);
      });
    }
  };

  Drupal.behaviors.sliderParagraph = {
    attach: function(context, settings) {
      $(context).find('.banner-wrapper').once('slider-paragraph-frontpage').each(function() {
        var $slider = $(this);
        $slider.slick({arrows: false});
        $slider.find('.slider-prev').click(function(){
          $slider.slick('slickPrev');
        });
        $slider.find('.slider-next').click(function(){
          $slider.slick('slickNext');
        });
      });
    }
  };

  Drupal.behaviors.photoswipe = {
    attach: function(context, settings) {
      $(context).find('.field--name-field-gallery-element-images').once('photoswipe-processed').each(function() {
        var modalContainer = document.querySelectorAll('.pswp')[0];
        var $fields = $(this).find('.field--item');
        var items = [];
        $fields.each(function(i) {
          var $link = $(this).find('a');
          var $img = $link.find('img');
          var width = $img.attr('width') * 3;
          var height = $img.attr('height') * 3;
          var href= $link.attr('href');
          items.push({
            w: width,
            h: height,
            src: href
          });
          $link.click(function(e) {

            var gallery = new PhotoSwipe(modalContainer, PhotoSwipeUiDefault, items, {
              index: i,
              getThumbBoundsFn: function(index) {
                var thumbnail = $(context).find('.field--name-field-gallery-element-images .field--item').eq(index).find('img')[0];
                console.log(thumbnail);
                const pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
                const rect = thumbnail.getBoundingClientRect();
                return {
                  x: rect.left,
                  y: rect.top + pageYScroll,
                  w: rect.width
                };
              }
            });
            gallery.init();
            e.preventDefault();
          });
        });
      });
    }
  };

})(jQuery, window.Drupal);
//state class should be ".is-*****"

/* eslint-disable no-unused-vars, lines-around-comment*/
const Bootstrap = require('bootstrap-sass');
const Slick = require('slick-carousel');
/* eslint-enable no-unused-vars, lines-around-comment */

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
      $(context).find('.paragraph__content').once('faq-click').click(function () {
        const isActive = $(this).children('.field--name-field-faq-element-question').hasClass('active');
        $(this).children().toggleClass('active', !isActive);
      });
    }
  };

  // Language dropdown
  Drupal.behaviors.lang = {
    attach: function (context, settings) {
      $(context).find('#block-languageswitcher .active-lang').once('lang-click').click(function () {
        const isOpen = $(this).hasClass('open');
        $(this).toggleClass('open', !isOpen);
        $(this).siblings('ul').toggleClass('open', !isOpen);
      });

      $(context).find('#block-languageswitcher a').once('lang-link').each(function () {
        const hrefLang = $(this).attr('hreflang');
        $(this).text(hrefLang);
      });
    }
  };

  // Search
  Drupal.behaviors.navSearch = {
    attach: function (context, settings) {
      $('.block-search', context).once('nav-search').each(function () {
        const $container = $(this);

        // open when clicking on the button the first time
        $container.find('button').click(function () {
          if ($('body', context).hasClass('expanded-search')) {
            return true;
          }
          $(context).find('body').addClass('expanded-search');
          $container.find('input[type="search"]', $container).focus();

          $(document).on('click.hideSearch', '*', function (e) {
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
      $(context).find('body').once('scroll-class').each(function () {
        const headerOffset = $('.navbar-secondary', context).outerHeight();
        const $body = $(this);
        $(window).scroll(function (event) {
          const scrollPos = $(window).scrollTop();
          $body.toggleClass('is-scrolling-past-navbar', scrollPos > headerOffset);
          $body.toggleClass('is-scrolling', scrollPos > 0);
        });
      });
      $(context).find('.scroll-to-top').click(function () {
        $('html, body').animate({
          scrollTop: 0
        }, 500);
      });
    }
  };

  Drupal.behaviors.toolBarOffset = {
    attach: function (context, settings) {
      $(context).find('#toolbar-administration').each(function () {
        if ($(window).innerWidth() < 768) {
          return;
        }
        window.setTimeout(function () {
          const offset = $('#toolbar-bar').outerHeight() + $('#toolbar-item-administration-tray').outerHeight();
          const paddingTop = +($('body').css('padding-top').replace('px', ''));

          $('.header-wrapper').css('top', offset);
          $('body').attr('style', 'padding-top: ' + (offset + paddingTop) + 'px !important;');
        }, 100);
      });
    }
  };

  Drupal.behaviors.sliderParagraph = {
    attach: function (context, settings) {
      $(context).find('.banner-wrapper').once('slider-paragraph-frontpage').each(function () {
        const $slider = $(this);
        $slider.slick({
          arrows: false
        });

        // arrows are within the slide, which is why we need to hook them up to
        // the slick nav methods
        $slider.find('.inslide-slider-prev').click(function () {
          $slider.slick('slickPrev');
        });
        $slider.find('.inslide-slider-next').click(function () {
          $slider.slick('slickNext');
        });
      });

      $('.slick__pause').on('click', function() {
        $('.slideshow__slides').slick('slickPause');
        $(this).hide().siblings('.slick__play').show();
      });
      $('.slick__play').on('click', function() {
        $('.slideshow__slides').slick('slickPlay');
        $(this).hide().siblings('.slick__pause').show();
      });
    }
  };

  // language selector
  Drupal.behaviors.languageSelector = {
    attach: function (context, settings) { 
      $('.language').once('language-selector').each(function () {
        $(this).find('a.selector').click(function () {    
          $('.language .options').toggleClass('is-open is-hidden');
        });
      });
    }
  };

  Drupal.behaviors.photoswipe = {
    attach: function (context, settings) {
      $(context).find('.field--name-field-gallery-element-images').once('photoswipe-processed').each(function () {
        const modalContainer = document.querySelectorAll('.pswp')[0];
        const $fields = $(this).find('.field--item');
        const items = [];
        $fields.each(function (i) {
          const $link = $(this).find('a');
          const $img = $link.find('img');
          const width = $img.attr('width') * 3;
          const height = $img.attr('height') * 3;
          const href = $link.attr('href');
          items.push({
            w: width,
            h: height,
            src: href
          });
          $link.click(function (e) {

            const gallery = new PhotoSwipe(modalContainer, PhotoSwipeUiDefault, items, {
              index: i,
              getThumbBoundsFn: function (index) {
                const thumbnail = $(context).find('.field--name-field-gallery-element-images .field--item').eq(index).find('img')[0];
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

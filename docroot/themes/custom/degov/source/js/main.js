const Bootstrap = require('bootstrap-sass');
const Slick = require('slick-carousel');

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
      $(context).find('#block-languageswitcher').once('lang-click').click(function () {
        const isOpen = $(this).children('ul').hasClass('open');
        $(this).children().toggleClass('open', !isOpen);
      });

      $(context).find('#block-languageswitcher a').once('lang-link-click').click(function () {
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
        $(window).scroll(function (event) {
          var scrollPos = $(window).scrollTop();
          $(context).find('body').toggleClass('scroll',scrollPos > 0);
        });
      });
    }
  };

  Drupal.behaviors.toolBarOffset = {
    attach: function(context, settings) {
      $(context).find('#toolbar-administration').each(function() {
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
        $(this).slick();
      });
    }
  };

})(jQuery, window.Drupal);
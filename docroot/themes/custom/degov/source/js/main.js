const jQuery = require('jquery');
const Bootstrap = require('bootstrap-sass');
const jQueryOnce = require('jquery-once');
const Slick = require('slick-carousel');

(function ($, Drupal) {

  // Repeat parent element of dropdown as first element
  Drupal.behaviors.dropdown = {
    attach: function (context, settings) {
      $('.navbar-nav').once('dropdown').each(function () {
        $(this).find('ul.dropdown-menu').each(function () {
          var $rootA = $(this).siblings('a').first();
          var href = $rootA.attr('href');
          var text = $rootA.text();
          $(this).prepend(`<li><a class="dropdown-parent-link" href="${href}">${text}</a></li>`);
        });
      });
    }
  };

  // FAQ
  Drupal.behaviors.faq = {
    attach: function (context, settings) {
      $('.paragraph--type--faq-element').click(function () {
        if($(this).children('.field--name-field-faq-element-question').hasClass('active')) {
          $(this).children().removeClass('active');
        }
        else {
          $(this).children().addClass('active');
        }
      });
    }
  };

  // Language dropdown
  Drupal.behaviors.lang = {
    attach: function (context, settings) {
      $('#block-languageswitcher').click(function () {
        if($(this).children('ul').hasClass('open')) {
          $(this).children().removeClass('open');
        }
        else {
          $(this).children().addClass('open');
        }
      });
      $('#block-languageswitcher a').once('language-processed').each(function() {
        var hreflang = $(this).attr('hreflang');
        $(this).text(hreflang)
      });
    }
  };

  // Search
  Drupal.behaviors.search = {
    attach: function (context, settings) {
      $('#block-searchform').click(function (e) {
        if($(this).hasClass('active')) {
          $(this).children().removeClass('active');
        }
        else {
          e.preventDefault();
          $(this).addClass('active');
        }
      });
    }
  };

})(jQuery, window.Drupal);

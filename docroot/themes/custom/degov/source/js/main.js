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
  Drupal.behaviors.faq = {
    attach: function (context, settings) {
      $('#block-languageswitcher').click(function () {
        console.info("Click");
        if($(this).children('ul').hasClass('open')) {
          $(this).children().removeClass('open');
          console.info('Remove open');
        }
        else {
          $(this).children().addClass('open');
          console.info('Add open');
        }
      });
    }
  };

})(jQuery, window.Drupal);

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

})(jQuery, window.Drupal);

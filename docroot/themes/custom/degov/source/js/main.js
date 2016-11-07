const jQuery = require('jquery');
const Bootstrap = require('bootstrap-sass');
const jQueryOnce = require('jquery-once');
const Slick = require('slick-carousel');

(function ($, Drupal) {

  // Repeat parent element of dropdown as first element
  Drupal.behaviors.dropdown = {
    attach: function (context, settings) {
      $('.navbar-nav').once('dropdown', function () {
        console.info("ADFSASDF");
        $(this).find('ul.dropdown-menu').each(function () {
          var href = $(this).siblings('a').first().attr('href');
          var text = $(this).siblings('a').first().text();
          var link = '<a href="' + href + '">text</a>';
          console.info("This is the line: " + link);
          $(this).prepend('<li>' + link + '</li>');
        });
      });
    }
  };

})(jQuery, window.Drupal);

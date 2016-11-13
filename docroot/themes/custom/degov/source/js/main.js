const jQuery = require('jquery');
const Bootstrap = require('bootstrap-sass');
const jQueryOnce = require('jquery-once');
const Slick = require('slick-carousel');
const matchHeight = require('jquery-match-height');
const stick = require('jquery-sticky');

(function ($, Drupal) {

  // Repeat parent element of dropdown as first element
  Drupal.behaviors.dropdown = {
    attach: function (context, settings) {
      $('.navbar-nav').once('dropdown').each(function () {
        $(this).find('ul.dropdown-menu').each(function () {
          var $rootA = $(this).siblings('a').first();
          var href = $rootA.attr('href');
          var text = $rootA.text();
          $(this).prepend('<li><a class="dropdown-parent-link" href="' + href +  '">' + text + '</a></li>');
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
          $(this).find('#edit-keys').focus();
        }
      });
    }
  };

  // Adapt height of certain elements
  Drupal.behaviors.heights = {
    attach: function (context, settings) {
      // Related content
      $('.view-related-content .view-content .views-row .views-field').matchHeight();
      // Homepage content
      $('.field--name-field-home-page-contents .field--item').matchHeight();
      //$('.field--name-field-home-page-contents .field--item article').css("background-color", "red");
      //$('.field--name-field-home-page-contents .field--item article').matchHeight();
    }
  };

  // Adapt height of certain elements
  Drupal.behaviors.sticky = {
    attach: function (context, settings) {
      if (window.matchMedia('(min-width: 768px)').matches) {
        $('.header-wrapper').sticky();
      }
      $(window).resize(function(){
        if (window.matchMedia('(min-width: 768px)').matches) {
          $('.header-wrapper').sticky();
        }
        else {
          $('.header-wrapper').unstick();
        }
      });
    }
  };

})(jQuery, window.Drupal);

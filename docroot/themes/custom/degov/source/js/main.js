const Bootstrap = require('bootstrap-sass');
/*
const Slick = require('slick-carousel');
const matchHeight = require('jquery-match-height');
const stick = require('jquery-sticky'); */

(function ($, Drupal) {

  // Repeat parent element of dropdown as first element
  Drupal.behaviors.dropdown = {
    attach: function (context, settings) {
      $(context).find('.navbar-nav').once('dropdown').each(function () {
        $(this).find('ul.dropdown-menu').each(function () {
          const $rootA = $(this).siblings('a').first();
          const href = $rootA.attr('href');
          const text = $rootA.text();
          $(this).prepend('<li><a class="dropdown-parent-link" href="${href}">' + text + '</a></li>');
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
        const hreflang = $(this).attr('hreflang');
        $(this).text(hreflang);
      });
    }
  };

  // Search
  Drupal.behaviors.search = {
    attach: function (context, settings) {
      $(context).find('#block-searchform').once('search-click').click(function (e) {
        if ($(this).hasClass('active')) {
          $(this).children().removeClass('active');
        } else {
          e.preventDefault();
          $(this).addClass('active');
          $(this).find('#edit-keys').focus();
        }
      });
    }
  };

  // Add body class on scroll
  Drupal.behaviors.search = {
    attach: function (context, settings) {
      $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        if(scroll > 0) {
          $('body').addClass('scroll');
        }
        else {
          $('body').removeClass('scroll');
        }
      });
    }
  };

  // Adapt height of certain elements
  //  Drupal.behaviors.heights = {
  //  attach: function (context, settings) {
  //    // Related content
  //    $('.view-related-content .view-content .views-row .views-field').matchHeight();
  //    // Homepage content
  //    $('.field--name-field-home-page-contents .field--item').matchHeight();
  //    //$('.field--name-field-home-page-contents .field--item article').css("background-color", "red");
  //    //$('.field--name-field-home-page-contents .field--item article').matchHeight();
  //  }
  //  };

})(jQuery, window.Drupal);

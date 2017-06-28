/**
 * @file slideshow.js
 *
 * Defines the behavior of the Slideshow paragraph.
 */
(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Initializes the slideshow paragraph with Slick.
   */
  Drupal.behaviors.slideshow = {
    attach: function (context, settings) {
      $(".slideshow__slides").slick({
        dots: true
      });
    }
  }

})(jQuery, Drupal, drupalSettings);
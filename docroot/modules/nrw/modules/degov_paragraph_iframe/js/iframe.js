/**
 * @file iframe.js
 *
 * Defines the behavior of the Iframe paragraph.
 */
(function ($, Drupal) {

  'use strict';

  /**
   * Resize the Iframe height.
   */
  Drupal.behaviors.degov_paragraph_iframe = {
    attach: function () {
      $('.iframe--autoheight iframe').once('iframe-autoheight-processed').each(function () {
        $(this).iFrameResize();
      });
    }
  }

})(jQuery, Drupal);

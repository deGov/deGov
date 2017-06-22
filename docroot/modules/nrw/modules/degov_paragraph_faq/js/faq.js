/**
 * @file faq.js
 *
 * Defines the behavior of the FAQ paragraph.
 */
(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Hide/shows a FAQ paragraph text by clicking on the title.
   */
  Drupal.behaviors.faq = {
    attach: function (context, settings) {
      if ($('.faq', context).length == 0) {
        return;
      }
      $('.faq', context).once('faq-element-processed').each(function () {
        var wrapper = $(this);
        $('.faq__question', wrapper).click(function () {
          if (wrapper.hasClass('opened')) {
            $('.faq__answer', wrapper).slideUp();
            wrapper.removeClass('opened');
          } else {
            $('.faq__answer', wrapper).slideDown();
            wrapper.addClass('opened');
          }
        });
      });
    }
  }

})(jQuery, Drupal, drupalSettings);

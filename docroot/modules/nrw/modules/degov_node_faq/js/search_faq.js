/**
 * @file search_faq.js
 *
 * Defines the behavior of the FAQ search page.
 */
(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Expands all search results that have one of the search terms in question or answer.
   */
  Drupal.behaviors.degov_node_faq = {
    attach: function (context) {
      var faqs = $('.faq', context);
      var terms = drupalSettings.degov_node_faq.search_faq;

      if (faqs.length && terms.length) {
        faqs.once('faq-term-found').each(function () {
          var faq = $(this);
          var text = faq.text().toLowerCase();

          $.each(terms, function (index, term) {
            if (text.indexOf(term) !== -1) {
              $('.faq_answer', faq).slideDown();
              faq.addClass('is-openend');
              return false;
            }
          });
        });
      }
    }
  };

})(jQuery, Drupal, drupalSettings);

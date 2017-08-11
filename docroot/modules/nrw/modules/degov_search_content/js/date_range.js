/**
 * @file
 * Date range facet block functions.
 */

(function ($) {

  'use strict';

  /**
   * Initialize the Drupal facets.
   * @type {{}}
   */
  Drupal.facets = Drupal.facets || {};

  /**
   * Attache the behaviour.
   *
   * @type {{attach: Drupal.behaviors.dateInputRange.attach}}
   */
  Drupal.behaviors.dateInputRange = {
    attach: function (context, settings) {
      Drupal.facets.dateInputRange(context, settings);
    }
  };

  /**
   * Behaviour for date range block with datepicker.
   *
   * @param context
   * @param settings
   */
  Drupal.facets.dateInputRange = function (context, settings) {
    // Initialize the datepicker.
    $('input[type="date"]').datepicker({ dateFormat: 'yy-mm-dd' }).attr('type','text');
    // Check for default values.
    if (typeof settings.dateFilter != 'undefined') {
      $('.date-filter-wrapper .date-from').val(settings.dateFilter.min);
      $('.date-filter-wrapper .date-to').val(settings.dateFilter.max);
    }
    // Add date pop-up
    $('.date-filter').on('click', function () {
      var dateFrom = $('.date-filter-wrapper .date-from').val();
      var dateTo = $('.date-filter-wrapper .date-to').val();
      // If the value is empty set to any (*).
      if (dateFrom == ''){
        dateFrom = '*';
      }
      if (dateTo == ''){
        dateTo = '*';
      }
      var href = settings.dateFilter.facetUrl.replace('date_min', dateFrom);
      href = href.replace('date_max', dateTo);
      // Redirect to search page with correct query parameters.
      window.location.href = href;
    });
  }

})(jQuery);

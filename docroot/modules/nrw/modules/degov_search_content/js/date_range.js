/**
 * @file
 * Transforms links into a dropdown list.
 */

(function ($) {

  'use strict';

  Drupal.facets = Drupal.facets || {};
  Drupal.behaviors.dateInputRange = {
    attach: function (context, settings) {
      Drupal.facets.dateInputRange(context, settings);
    }
  };

  Drupal.facets.dateInputRange = function (context, settings) {
    $('input[type="date"]').datepicker({ dateFormat: 'yy-mm-dd' }).attr('type','text');
    if (typeof settings.dateFilter != 'undefined') {
      $('.date-filter-wrapper .date-from').val(settings.dateFilter.min);
      $('.date-filter-wrapper .date-to').val(settings.dateFilter.max);
    }
    $('.date-filter').on('click', function () {
      var dateFrom = $('.date-filter-wrapper .date-from').val();
      var dateTo = $('.date-filter-wrapper .date-to').val();
      if(dateFrom == ''){
        dateFrom = '*';
      }
      if(dateTo == ''){
        dateTo = '*';
      }
      var href = settings.dateFilter.facetUrl.replace('date_min', dateFrom);
      href = href.replace('date_max', dateTo);
      window.location.href = href;
    });
  }

})(jQuery);

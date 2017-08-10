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

    $('.date-filter').click(function(){
      if($('.date-to').val() == ''){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; 
        var yyyy = today.getFullYear();
        if(dd<10) 
        {
            dd='0'+dd;
        } 

        if(mm<10) 
        {
            mm='0'+mm;
        }
        today = yyyy+'-'+mm+'-'+dd;
        $('.date-to').val(today);
      }
      
    });
  }

})(jQuery);

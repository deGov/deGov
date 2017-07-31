/**
 * @file events.js
 *
 * Defines the behavior of the calendar widget.
 */
(function ($, Drupal, drupalSettings) {

    'use strict';

    /**
     * Hide/shows a FAQ paragraph text by clicking on the title.
     */
    Drupal.behaviors.degov_events = {
        attach: function (context, settings) {
            if ($('.calendar-calendar', context).length == 0 ) {
                return;
            }
            $('.has-events .mini-day-on', context).click(function(){
                var parent = $(this).parent();
                var date = parent.attr('id').replace('events-', '');
                var view_wrapper = $(this).closest('.view-display-id-events_page_list');
                $('input[name="from"]', view_wrapper).val(date);
                var toDate = new Date(date);
                toDate.setDate(toDate.getDate() + 1);
                $('input[name="to"]', view_wrapper).val(toDate.toISOString().substr(0, 10));
                $('form', view_wrapper).submit();
            });
        }
    }

})(jQuery, Drupal, drupalSettings);
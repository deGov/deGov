/**
 * @file nrw_menu.js
 *
 * Defines the behavior of the NRW Menu module.
 */
(function ($, Drupal) {

    'use strict';

    /**
     * Collapsible/Expandable menu behaviour
     */
    Drupal.behaviors.nrw_menu = {
        attach: function (context, settings) {
            // do nothing if there is no menu__header on the page
            if ($('.nrw-menu__header', context).length == 0) {
                return;
            }
            // on click add the class to sibling
            $('.nrw-menu__header', context).click(function () {
                // remove the class from all the content containers in the menu
                $('.nrw-menu__content', context).each(function(){
                    $(this).removeClass('is-expanded');
                });
                // add the class only to the sibling of the active menu__header
                var parent = $(this).parent();
                $('.nrw-menu__content', parent).addClass('is-expanded');
            });
        }
    }

})(jQuery, Drupal);
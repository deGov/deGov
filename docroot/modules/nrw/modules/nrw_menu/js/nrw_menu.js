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
            // on click add the class to siblings
            $('.nrw-menu__col .nrw-menu__header', context).click(function (e) {
                e.preventDefault();
                // remove the class from all the content containers in the menu
                // add the class only to the sibling of the active menu__header                
                var parent = $(this).closest('.nrw-menu__col');
                if( $(this).siblings('.nrw-menu__content').hasClass( "is-expanded" ) ){
                    $(this).parent().removeClass('is-open');
                    $(this).siblings('.nrw-menu__content').removeClass("is-expanded");
                }else {
                    $('.nrw-menu__col').removeClass('is-open');
                    $('.nrw-menu__content').removeClass("is-expanded");
                    $(this).parent().addClass('is-open');
                    $(this).siblings('.nrw-menu__content').addClass("is-expanded");
                }                
            });
            $('.nrw-menu__content-close a', context).click(function (e) {
                $(this).parent().parent().parent().removeClass('is-expanded');
            });
        }
    }

})(jQuery, Drupal);
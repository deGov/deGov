/**
 * @file slider.js
 *
 * Defines the behavior of the Slideshow paragraph.
 */
(function ($, Drupal, drupalSettings) {

    'use strict';

    // Slick slider in press list
    Drupal.behaviors.slickPress = {
        attach: function (context, settings) {
            $('.view-latest-press .view-content').slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        }
    };

})(jQuery, Drupal, drupalSettings);

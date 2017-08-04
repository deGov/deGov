/**
 * @file slideshow.js
 *
 * Defines the behavior of the Slideshow paragraph.
 */
(function ($, Drupal, drupalSettings) {

    'use strict';

    // Slick slider in Twitter block
    Drupal.behaviors.slickTweets = {
        attach: function (context, settings) {
            $('.tweets-slideshow .tweets').slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 2,
                slidesToScroll: 2,
                autoplay: true,
                responsive: [
                    {
                        breakpoint: 720,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.slick__pause').on('click', function () {
                $('.tweets__slides').slick('slickPause');
                $(this).hide().siblings('.slick__play').show();
            });
            $('.slick__play').on('click', function () {
                $('.tweets__slides').slick('slickPlay');
                $(this).hide().siblings('.slick__pause').show();
            });
        }
    };

})(jQuery, window.Drupal);

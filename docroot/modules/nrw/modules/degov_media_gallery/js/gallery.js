/**
 * @file gallery.js
 *
 * Defines the behavior of the media bundle gallery.
 */
(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Initializes the slideshow with Slick and PhotoSwipe.
   */
  Drupal.behaviors.gallery = {
    attach: function (context, settings) {
      var $slider = $('.media-gallery__images .slideshow__slides');
      var $images = $slider.find('img');
      $slider.slick({
        dots: false,
        autoplay: true,
        arrows: true,
        swipeToSlide: true
      });
      $('.media-gallery__preview .image').click(function() {
        $slider.slick('slickGoTo', $(this).parent().data('index'));
      });

      var $pswpElement = document.querySelectorAll('.pswp__media-gallery')[0];

      var $pswpItems = [];
      $.each($images, function(k, img) {
        var $pswpItem = {
          src: drupalSettings.degov_media_gallery.imagesDownloadLinks[k].uri,
          w: drupalSettings.degov_media_gallery.imagesDownloadLinks[k].width,
          h: drupalSettings.degov_media_gallery.imagesDownloadLinks[k].height
        };
        $pswpItems.push($pswpItem);
      });
      $('.slick-controls__gallery').append('<span class="slick__download"><a href="' + drupalSettings.degov_media_gallery.imagesDownloadLinks[$slider.slick('slickCurrentSlide')].uri + '"><i class="fa fa-download"></i>' + Drupal.t('Download') + '</a></span>');

      $slider.find('article').click(function() {
        var $index = parseInt($slider.slick('slickCurrentSlide'));
        var $options = {
          index: $index
        };
        // Initializes and opens PhotoSwipe.
        var $pswp = new PhotoSwipe($pswpElement, PhotoSwipeUI_Default, $pswpItems, $options);
        $pswp.init();
      });
      $('.media-gallery-js-open-lightroom').click(function() {
        $images.get($slider.slick('slickCurrentSlide')).click();
      });
      $slider.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
        var i = (currentSlide ? currentSlide : 0) + 1;
        $('.slick__counter__current').text(i);
        $('.slick__counter__total').text(slick.slideCount);
      });

    }
  }

})(jQuery, Drupal, drupalSettings);

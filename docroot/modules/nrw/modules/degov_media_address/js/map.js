/**
 * @file map.js
 *
 * Defines the behavior of the Address paragraph.
 */
(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Initializes the Map with Leaflet.
   */
  Drupal.behaviors.address = {
    attach: function (context, settings) {
      if (typeof settings.maps == "undefined" || settings.maps.length == 0) {
        return;
      }

      var maps = [];

      // Loop through all available maps.
      $.each( settings.maps, function( index, value ){
        var selector = '#' + index;
        if (!$(selector).hasClass('leaflet-container')) {
          // Create map and set center and zoom.
          maps[index] = L.map( index, {
              scrollWheelZoom: true,
              zoomControl: false,
              center: [value.lat, value.lon],
              zoom: 18
          });

          // Add basemap tiles and attribution.
          L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
          }).addTo(maps[index]);

          // Add pin.
          var customPin = new L.Icon({iconUrl: value.pin});
          L.marker([value.lat, value.lon], {icon: customPin}).addTo(maps[index]);
        }
      });
    }
  }

})(jQuery, Drupal, drupalSettings);
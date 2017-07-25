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
      // Add basemap tiles and attribution.
      var baseLayer = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
      });

      // Create map and set center and zoom.
      var map = L.map('osm-map', {
        scrollWheelZoom: true,
        zoomControl: false,
        center: [settings.map.lat, settings.map.lon],
        zoom: 18
      });

      // Add basemap.
      map.addLayer(baseLayer);

      // Add pin.
      var customPin = new L.Icon({iconUrl: settings.map.pin});
      L.marker([settings.map.lat, settings.map.lon], {icon: customPin}).addTo(map);
    }
  }

})(jQuery, Drupal, drupalSettings);
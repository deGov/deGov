/**
 * @file
 * Attaches the library to load maps.
 */
(function ($) {
    "use strict";

    Drupal.behaviors.itnrw_map = {
        attach: function (context, settings) {
            var s = document.createElement("script");
            s.type = "text/javascript";
            s.src = "https://www.gis-rest.nrw.de/geocoding_map/v110/init.js";
            $("head").once('itnrw_map').append(s);
            console.log("attached");

        }
    };
})(jQuery);

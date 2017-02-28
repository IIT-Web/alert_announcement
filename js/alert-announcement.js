/**
 * @file
 */
(function ($) {

  "use strict";

  Drupal.behaviors.alertAnnouncement = {
    attach: function (context, settings) {
      console.log('alert-announcement.js loaded with behavior: ' + settings.alertAnnouncement.jsonPath);
    }
  };

})(jQuery);

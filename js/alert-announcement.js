/**
 * @file
 */
;(function ($) {

  "use strict";

  // Get jQuery version number as an array
  var jqv = $.fn.jquery.split('.');

  Drupal.behaviors.alertAnnouncement = {
    attach: function (context, settings) {
      //console.log('alert-announcement.js loaded with behavior: ' + settings.alertAnnouncement.jsonPath);
      if($('#alert-announcement-wrapper', context).length > 0) {
        //console.log('wrapper exists in context');

        if (sessionStorage.alertAnnouncement && sessionStorage.alertAnnouncementCacheExpires) {
          //console.log('var exists in session storage');
          var expires = new Date(Number(sessionStorage.alertAnnouncementCacheExpires));
          if (new Date() > expires) {
            //console.log('client cache expired');
            callJSON(settings);
          } else {
            //console.log('client cache good');
            buildAlertMessage(JSON.parse(sessionStorage.alertAnnouncement));
          }
        } else {
          //console.log('expires var does not exist');
          callJSON(settings);
        }
        
      }
    }
  };

  function callJSON (settings) {
    if (jqv[0] > 1 || (jqv[0] == 1 && jqv[1] >= 5)) {
      $.ajax({
        url: '/' + settings.alertAnnouncement.jsonPath,
        dataType: 'json'
      }).done(buildAlertMessage);
    } else {
      $.ajax({
        url: '/' + settings.alertAnnouncement.jsonPath,
        dataType: 'json',
        success: buildAlertMessage
      });
    }
  }

  function buildAlertMessage (data) {
    //console.dir(data);
    if (data.length > 0) {
      switch (data[0].severity) {
        case '0':
          $('#alert-announcement-wrapper').addClass('info');
          break;
        case '1':
          $('#alert-announcement-wrapper').addClass('warning');
          break;
        case '2':
          $('#alert-announcement-wrapper').addClass('danger');
          break;
      }

      $('#alert-announcement-wrapper').attr('data-key', data[0].key);
      $('#alert-announcement-wrapper .alert-headline').html(data[0].headline);
      $('#alert-announcement-wrapper .alert-updated-date').html('Updated: ' + data[0].updated);
      $('#alert-announcement-wrapper .alert-subhead').html(data[0].subhead);
      $('#alert-announcement-wrapper .alert-body').html(data[0].body);

      if (data[0].dismissible) {
        $('#alert-announcement-wrapper button.close').off('click').on('click', function(){
          $('#alert-announcement-wrapper').hide();
          sessionStorage.alertAnnouncementDismissed = $('#alert-announcement-wrapper').attr('data-key');
        });
      } else {
        $('#alert-announcement-wrapper button.close').hide();
      }

      if (!(sessionStorage.alertAnnouncementDismissed === data[0].key)) {
        $('#alert-announcement-wrapper').show();
      }
    }

    sessionStorage.alertAnnouncement = JSON.stringify(data);
    var now = new Date();
    var cacheExpires = Number(sessionStorage.alertAnnouncementCacheExpires);
    if (cacheExpires < now.getTime() || isNaN(cacheExpires)) {
      if (data[0] && data[0].clientCacheTime) {
        sessionStorage.alertAnnouncementCacheExpires = now.getTime() + 1000 * data[0].clientCacheTime;
      } else {
        sessionStorage.alertAnnouncementCacheExpires = now.getTime() + 1000 * 0;
      }
    }
  }

})(jQuery);

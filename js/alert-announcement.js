/**
 * @file
 */
;(function ($) {

  "use strict";

  Drupal.behaviors.alertAnnouncement = {
    attach: function (context, settings) {
      console.log('alert-announcement.js loaded with behavior: ' + settings.alertAnnouncement.jsonPath);
      if($('#alert-announcement-wrapper', context).length > 0) {
      	console.log('wrapper exists');
      	$.getJSON('/' + settings.alertAnnouncement.jsonPath, function (data) {
      		console.dir(data);
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

      			$('#alert-announcement-wrapper .alert-headline').html(data[0].headline);
      			$('#alert-announcement-wrapper .alert-subhead').html(data[0].subhead);
      			$('#alert-announcement-wrapper .alert-body').html(data[0].body);
      		} else {
      			$('#alert-announcement-wrapper .alert-body').html('no alert');
      		}
      	});
      }
    }
  };

})(jQuery);

function fetch_calendars() {
	$.ajax({
	   dataType: 'json',
	   url: '../modules/owncloud_calendar_import/assets/updateCalendars.php',
	   success: function(data) {
		   if(data.name) $('#oc_calendars').html('<b>Aktiver Kalender: ' + data.name +'</b>')
	   }
	});
/*
	// alle 5 Sekunden aktualiseren
	window.setTimeout(function() {
		getDummyParameter()
	}, 5000);
*/	
}

$(document).ready(function () {
	fetch_calendars()
});
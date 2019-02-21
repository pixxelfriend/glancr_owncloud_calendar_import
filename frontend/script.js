function fetch_calendars() {
  $.ajax({
    dataType: 'json',
    url: '../modules/owncloud_calendar_import/assets/updateCalendars.php',
    success: function(data) {
      if(data && Array.isArray(data) && data.length > 0) {
        build_calendar_info(data)
      }
    }
  });
}

function build_calendar_info(data){
  const content = data.map(calendar => {
    const date = new Date(calendar.last_update*1000)
    let status = "&#128472; " +  date.toLocaleDateString() + " - "  + date.getHours() + ":" + date.getMinutes()
    if(calendar.error) status = "Fehler:" + calendar.error;
    return "<p><b>" + calendar.name + ":</b> <i>" + status + "</i></p>";
  }).join('')
  $('#oc_calendars').html(content);
  window.setTimeout(fetch_calendars,60*1000);
}

$(document).ready(function () {
	fetch_calendars()
});

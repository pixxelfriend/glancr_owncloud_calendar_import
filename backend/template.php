
<?php 
  $oc_calendars = getConfigValue('oc_calendars');
  $calendars = json_decode($oc_calendars);
  $base_url =  "http://" . $_SERVER["HTTP_HOST"] . "/modules/owncloud_calendar_import/assets/getCalendar.php?name=";
?>

<script type="text/javascript">
  const oc_calendar_settings = {
    calendars :<?=$oc_calendars?>,	
    baseUrl : "<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/modules/owncloud_calendar_import/assets/getCalendar.php?name="; ?>"
  }
</script>

<div class="oc_calendar_list">
  <p>add a new calendar <a class="oc_calendar_import__add">here</a></p>
  <ul id="oc_calendar_list"></ul>
</div>

<form id="oc_calendar_import">
  <h4 class="add">ADD NEW CALENDAR</h4>
  <h4 class="edit hidden">EDIT CALENDAR</h4>
  <div class="oc_calendar_group">
    <input type="text" name="name" class="oc_calendar_change" placeholder="Bezeichnung" required />
    <input type="text" name="user" class="oc_calendar_change"  placeholder="Username" required />
    <input type="password" name="password" class="oc_calendar_change"  placeholder="Passwort" required />
    <input type="url" name="url" class="oc_calendar_change"  placeholder="https://example.com/remote.php/dav/calendars/username/CalendarName?export" required />
  </div>
  <div id="oc_calendar_import__edit">
    <button class="button oc_calendar_import__edit">
      <span><?php echo _('save'); ?></span>
    </button>
    <button type="reset" class="button oc_calendar_import__reset">
      <span><?php echo _('abort'); ?></span>
    </button>
  </div>
</form>

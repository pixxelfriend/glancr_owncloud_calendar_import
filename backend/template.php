
<?php 
//$oc_calendar_url = getConfigValue('oc_calendar_url');
#$oc_calendar_name = getConfigValue('oc_calendar_name');
#$oc_calendar_user = getConfigValue('oc_calendar_user');
#$oc_calendar_password = getConfigValue('oc_calendar_password');
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
		<input type="text" class="oc_calendar_change" name="oc_calendar_name" placeholder="Bezeichnung" value="">
		<input type="text" class="oc_calendar_change" name="oc_calendar_user" placeholder="Username" value="">
		<input type="password" class="oc_calendar_change" name="oc_calendar_password" placeholder="Passwort" value="">
		<input type="text" class="oc_calendar_change" name="oc_calendar_url" placeholder="url<?php echo _('oc_importer_url');?>" value=""/>
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

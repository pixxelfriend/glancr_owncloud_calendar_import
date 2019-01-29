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

<ul class="oc_calendar_list"></ul>
ADD NEW CALENDAR

<form id="oc_calendar_import">

	<div class="oc_calendar_group">
		<input type="text" class="oc_calendar_change" name="oc_calendar_name" placeholder="Bezeichnung" value="">
		<input type="text" class="oc_calendar_change" name="oc_calendar_user" placeholder="Username" value="">
		<input type="password" class="oc_calendar_change" name="oc_calendar_password" placeholder="Passwort" value="">
		<input type="text" class="oc_calendar_change" name="oc_calendar_url" placeholder="url<?php echo _('oc_importer_url');?>" value=""/>
	</div>

</form>
<div class="block__add" id="oc_calendar_import__edit">
	<button class="oc_calendar_import__edit--button" href="#">
		<span><?php echo _('save'); ?></span>
	</button>
</div>
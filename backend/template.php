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
<?php
	if(count($calendars) > 10){
		foreach ($calendars as $key => $calendar){ ?>
			<div class="oc_calendar_group">
				<input type="text" class="oc_calendar_change" name="oc_calendar_name" placeholder="Bezeichnung" value="<?php echo $calendar->oc_calendar_name; ?>">
				<input type="text" class="oc_calendar_change" name="oc_calendar_user" placeholder="Username" value="<?php echo $calendar->oc_calendar_user; ?>">
				<input type="text" class="oc_calendar_change" name="oc_calendar_password" placeholder="Passwort" value="<?php echo $calendar->oc_calendar_password; ?>">
				<input type="text" class="oc_calendar_change" name="oc_calendar_url" placeholder="url<?php echo _('oc_importer_url');?>" value="<?php echo $calendar->oc_calendar_url; ?>"/>
				<p class="oc_calendar_export">
					Copy2Cal: <span><?php echo $base_url . urlencode($calendar->oc_calendar_name);?></span>
					<br />
					<button class="oc_calendar__delete" type="button">
						<span class="fi-trash"></span>
						<?php echo _('oc_importer_delete');?>
					</button>
				</p>
			</div>
		<?php } 
	}
?>
<div class="oc_calendar_group">
	<input type="text" class="oc_calendar_change" name="oc_calendar_name" placeholder="Bezeichnung" value="">
	<input type="text" class="oc_calendar_change" name="oc_calendar_user" placeholder="Username" value="">
	<input type="text" class="oc_calendar_change" name="oc_calendar_password" placeholder="Passwort" value="">
	<input type="text" class="oc_calendar_change" name="oc_calendar_url" placeholder="url<?php echo _('oc_importer_url');?>" value=""/>
</div>

</form>
<div class="block__add" id="oc_calendar_import__edit">
	<button class="oc_calendar_import__edit--button" href="#">
		<span><?php echo _('save'); ?></span>
	</button>
</div>
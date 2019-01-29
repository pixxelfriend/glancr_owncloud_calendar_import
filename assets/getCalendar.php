<?php

include('../../../config/glancrConfig.php');

$oc_calendars = getConfigValue('oc_calendars');
$requested_name = $_GET["name"];
if($oc_calendars){
	$calendars = json_decode($oc_calendars);	
	//find key of calendar in config array
	$id = array_search($requested_name, array_column($calendars, 'oc_calendar_name'));
	if($id == 0 || $id > 0){
		$file = file_get_contents("./" . urlencode($calendars[0]->oc_calendar_name) . ".cal");
		if($file) {
			echo $file;
		} else {
			exit("file does not exist");
		}
		
	} else {
		exit("NO ID FOUND");
	}
} else {
	exit("config_empty");
}

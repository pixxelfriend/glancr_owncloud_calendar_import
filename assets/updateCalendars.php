<?php

include('../../../config/glancrConfig.php');

print_r($_GET);
$oc_calendars = getConfigValue('oc_calendars');

//print_r($oc_calendars);
if($oc_calendars){
	$calendars = json_decode($oc_calendars);
	if(count($calendars) > 0){
		
		foreach($calendars as $calendar){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $calendar->oc_calendar_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

			curl_setopt($ch, CURLOPT_USERPWD,  $calendar->oc_calendar_user . ':' . $calendar->oc_calendar_password);

			$result = curl_exec($ch);

			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close ($ch);

			$cal_file = fopen(urlencode($calendar->oc_calendar_name).".cal", "w");
			fwrite($cal_file, $result);
			fclose($cal_file);
		}
	} 
}

echo json_encode($oc_calendars);
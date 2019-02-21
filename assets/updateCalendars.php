<?php

include('../../../config/glancrConfig.php');

$oc_calendars = getConfigValue('oc_calendars');
$oc_folder = '../tmp/';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // The request is using the POST method
  if($_POST['method'] === 'delete' && $_POST['key']){
    $filename = $oc_folder . urlencode($_POST['key']).".cal";
    if(file_exists($oc_folder.$filename)){
      unlink($filename);
      exit('DELETED');
    } else {
      exit('NOT FOUND:'.$filename);
    }
  }
  
} else {
  if($oc_calendars){
    $calendars = json_decode($oc_calendars);
    if(count($calendars) > 0){
        
      foreach($calendars as $index => $calendar){
        
        $update = false;
        $filename = $oc_folder . urlencode($calendar->key).".cal";
        
        //check if file should be updated
        if(file_exists($filename)) {
          $filetime = filemtime($filename);
          if($filetime < time() - $calendar->interval*3600){
            $update = true;
          } else {
            $calendars[$index]->last_update = $filetime;
          }
        } else {
          $update = true;
        }
      
        //fetch file from url
        if($update){
          $cal_file = fopen($filename, "w");
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $calendar->url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
          curl_setopt($ch, CURLOPT_USERPWD,  $calendar->user . ':' . $calendar->password);
          
          $result = curl_exec($ch);
          if (curl_errno($ch)) {
            $error = "Calendar could not be fetched";
            #'Error:' . curl_error($ch);
          }
          curl_close ($ch);
          //check if resource is calendar! 
          if($result){
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if($finfo->buffer($result) == "text/calendar"){
              //if yes, update file
              fwrite($cal_file, $result);
              fclose($cal_file);
              $calendars[$index]->last_update = time();
            } else {
              $error = "File is not a calendar";
            }
          }
        }
        if($error) {
          $calendars[$index]->error = $error;
        }
      }
    } else {
     // print_r("error:" .json_last_error());
      exit("no Calendars found");
    }
  }
  echo json_encode($calendars);  
}

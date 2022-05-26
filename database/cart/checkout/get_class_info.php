<?php
/**
 * Return 2 "timestones"(milestones in time): (stored as an associative array named $class_info)
 * +, start_datetime
 * +, end_datetime
 */
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");

if (!isset($user_info['classCode'])) {
    exit("class info from user haven't been set yet");
}

$query = "SELECT * FROM Classes WHERE classCode = '".$user_info['classCode']."'";
$result = run_mysql_query($query);

if ($result->num_rows == 1) {
    $class_info = $result->fetch_array();
}

// handle date
// week day number in php is decreased by 1 compares to it in database with the same day
$current_day_of_week = date('w') + 1;
$date_interval = $class_info['weekdayNumber'] - $current_day_of_week;

// Get today's DateTime object.
$date = date_create();
// Calculate the nearest day ($start_datetime) that the class is going to take place.
if ($date_interval >= 0) {
    $date = date_add($date, date_interval_create_from_date_string("$date_interval days"));
} else {
    $date = date_add($date, date_interval_create_from_date_string((7 + $date_interval) ." days"));
}

$start_datetime = new DateTime(date_format($date, "Y-m-d") . " " . $class_info['startTime']);

// Default format for applying datetime value to datetime-local input tag.
$class_info['start_datetime'] = $start_datetime->format('Y-m-d\TH:i:s');

// Get DateInterval object from studyTime.
$study_time = explode(":", $class_info['studyTime']); //equivalent to split function.
$study_time = date_interval_create_from_date_string($study_time[0]." hours ".$study_time[1]." minutes ".$study_time[2]." seconds");

// Default format for applying datetime value to datetime-local input tag.
// Calculate the end datetime by following expression: end_datetime = start_datetime + study_time
$class_info['end_datetime'] = $start_datetime->add($study_time)->format('Y-m-d\TH:i:s');

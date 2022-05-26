<?php
/**
 * Get student information from the Students table.
 * Return the following information: (stored as an associative array named $user_info)
 * +, start_datetime
 * +, end_datetime
 */
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/cart/manager.php");

$query = "SELECT * FROM Students WHERE studentID = ".$_SESSION[USERID];
$result = run_mysql_query($query);

if ($result->num_rows == 1) {
    $user_info = $result->fetch_array();
}

// handle name
if ($user_info['firstName'] === NULL) {
    $user_info['fullName'] = $user_info['lastName'];
} else {
    $user_info['fullName'] = $user_info['firstName'] . " " . $user_info['lastName'];
}

// handle school name (can convert into a table)
switch ($user_info['school']) {
    case "UET":
        $user_info['school'] = "ĐHCN";
        break;
    case "ULIS":
        $user_info['school'] = "ĐHNN";
        break;
    case "IS":
        $user_info['school'] = "Trường Quốc Tế";
        break;
    case "UEd":
        $user_info['school'] = "ĐHGD";
        break;
    case "UEB":
        $user_info['school'] = "ĐHKT";
        break;
    case "SoL":
        $user_info['school'] = "Khoa Luật";
        break;
}

// // handle phone number
// $user_info['phoneNumber'] = "0" . $user_info['phoneNumber'];

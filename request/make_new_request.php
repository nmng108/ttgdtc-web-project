<?php
/**
 * Get 5 fields for making a new request: 
 * studen_id -> studentID
 * start_datetime -> startTime
 * end_datetime -> endTime
 * class_code -> classCode
 * note -> note
 */
$root_dir = "..";

include_once("$root_dir/database/manager.php");
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/request/manager.php");


if (!isset($_POST)) exit("info is not sent by post method");

$response = [];
$response['message'] = '';
$response['hasSucceeded'] = false;

if (is_requests_larger_than_limit('CLASS', $_POST['class_code'])) {
    $response['message'] = "Tạo yêu cầu mượn thất bại. Đã có tối đa số yêu cầu cho 1 lớp.";
    echo json_encode($response);
    exit();
} else {
    // Check like above for STUDENT_REQUEST_LIMIT
    if (is_requests_larger_than_limit('STUDENT', $_POST['student_id'])) {
        $response['message'] = "Tạo yêu cầu mượn thất bại. Đã có tối đa số yêu cầu cho 1 học sinh.";
        echo json_encode($response);
        exit();
    }
}

//Replace 'T' by ' ' to fill in DATETIME columns in database.
$_POST['start_datetime'] = str_replace("T", " ", $_POST['start_datetime']);
$_POST['end_datetime'] = str_replace("T", " ", $_POST['end_datetime']);

$last_request_number = make_new_request($_POST['student_id'], $_POST['start_datetime'], 
                        $_POST['end_datetime'], $_POST['class_code'], $_POST['note']);

if ($last_request_number !== false) {
    $response['message'] = "Tạo yêu cầu mượn thành công";
    $response['hasSucceeded'] = true;
    $response['request_number'] = $last_request_number;
    echo json_encode($response);
} else {
    $response['message'] = "(by query)Tạo yêu cầu mượn thất bại";
    echo json_encode($response);
}

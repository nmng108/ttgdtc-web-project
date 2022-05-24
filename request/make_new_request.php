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

include_once("../database/manager.php");
include_once("../includes/utilities.php");

const CLASS_REQUEST_LIMIT = 3;
const STUDENT_REQUEST_LIMIT = 3;

if (!isset($_POST)) exit("info is not sent by post method");

$response = [];
$response['message'] = '';
$response['hasSucceeded'] = false;

// If student's borrowing for their class, we'll check whether the number of request 
// for that class(in SENT/APPROVED status) is greater than LIMIT or not.
$query = "SELECT COUNT(classCode) totalRequests 
        FROM Requests r JOIN RequestStatus rs ON r.statusID = rs.statusID
        WHERE classCode = '".$_POST['class_code']."' AND `statusName` IN ('SENT', 'APPROVED')";
$result = run_mysql_query($query);

if ($result->num_rows == 1) {
    if ($result->fetch_array()['totalRequests'] >= CLASS_REQUEST_LIMIT) {
        $response['message'] = "Tạo yêu cầu mượn thất bại. Đã có tối đa số yêu cầu cho 1 lớp.";
        echo json_encode($response);
        exit();
    } else {
        // Check like above for STUDENT_REQUEST_LIMIT
        $query = "SELECT COUNT(studentID) totalRequests 
                FROM Requests r JOIN RequestStatus rs ON r.statusID = rs.statusID
                WHERE studentID = ".$_POST['student_id']. " AND `statusName` IN ('SENT', 'APPROVED')";
        $result = run_mysql_query($query);
    
        if ($result->num_rows == 1) {
            if ($result->fetch_array()['totalRequests'] >= STUDENT_REQUEST_LIMIT) {
                $response['message'] = "Tạo yêu cầu mượn thất bại. Đã có tối đa số yêu cầu cho 1 học sinh.";
                echo json_encode($response);
                exit();
            }
        } else {
            $response['message'] = "Tạo yêu cầu mượn thất bại. Truy vấn lỗi.";
            echo json_encode($response);
            exit();
        }
    }
}  else {
    $response['message'] = "Tạo yêu cầu mượn thất bại. Truy vấn lỗi.";
    echo json_encode($response);
    exit();
}

//Replace 'T' by ' ' to fill in DATETIME columns in database.
$_POST['start_datetime'] = str_replace("T", " ", $_POST['start_datetime']);
$_POST['end_datetime'] = str_replace("T", " ", $_POST['end_datetime']);

$query = "INSERT INTO Requests(`studentID`, `startTime`, `endTime`, `classCode`, `note`)
        VALUE ('".$_POST['student_id']."', '".$_POST['start_datetime']."', '".$_POST['end_datetime']."', '".$_POST['class_code']."', '".$_POST['note']."')";
$result = run_mysql_query($query);

if ($result == true) {
    $query = "SELECT MAX(requestNumber) `lastRequestNumber` FROM requests WHERE studentID = ".$_POST['student_id'];
    $result = run_mysql_query($query);
    if ($result->num_rows == 1) {
        $last_request_number = $result->fetch_array()['lastRequestNumber'];
    }

    $response['message'] = "Tạo yêu cầu mượn thành công";
    $response['hasSucceeded'] = true;
    $response['request_number'] = $last_request_number;
    echo json_encode($response);
} else {
    $response['message'] = "(by query)Tạo yêu cầu mượn thất bại";
    echo json_encode($response);
}

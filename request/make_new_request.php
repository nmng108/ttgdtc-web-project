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

const CLASS_REQUEST_LIMIT = 4;
const STUDENT_REQUEST_LIMIT = 4;

$result_array = [];

    // If student's borrowing for their class, we'll check whether the number of request 
    // for that class(in SENT/APPROVED status) is greater than 2 or not.
    $query = "SELECT COUNT(classCode) totalRequests FROM Requests WHERE classCode = '".$_POST['class_code']."'";
    $result = run_mysql_query($query);

    if ($result->num_rows == 1 && $result->fetch_array()['totalRequests'] > CLASS_REQUEST_LIMIT) {
        
        $result_array['msg'] = "Tạo yêu cầu mượn thất bại. Đã có tối đa số yêu cầu cho 1 lớp.";
        $result_array['isSuccessful'] = false;
        echo json_encode($result_array);
        exit();
    } else {
        $query = "SELECT COUNT(studentID) totalRequests FROM Requests WHERE studentID = ".$_POST['student_id'];
        $result = run_mysql_query($query);

        if ($result->num_rows == 1 && $result->fetch_array()['totalRequests'] > STUDENT_REQUEST_LIMIT) {
            
            $result_array['msg'] = "Tạo yêu cầu mượn thất bại. Đã có tối đa số yêu cầu cho 1 học sinh.";
            $result_array['isSuccessful'] = false;
            echo json_encode($result_array);
            exit();
        }
    }

    //Replace 'T' by ' ' in the strings to fill in DATETIME columns in database.
    $_POST['start_datetime'] = str_replace("T", " ", $_POST['start_datetime']);
    $_POST['end_datetime'] = str_replace("T", " ", $_POST['end_datetime']);

    $query = "INSERT INTO Requests(`studentID`, `startTime`, `endTime`, `classCode`, `note`)
            VALUE ('".$_POST['student_id']."', '".$_POST['start_datetime']."', '".$_POST['end_datetime']."', '".$_POST['class_code']."', '".$_POST['note']."')";
    $result = run_mysql_query($query);
    if ($result == true) {
        // header("Location: ./");
        $result_array['msg'] = "Tạo yêu cầu mượn thành công";
        $result_array['isSuccessful'] = true;
        echo json_encode($result_array);
    } else {
        $result_array['msg'] = "(query)Tạo yêu cầu mượn thất bại";
        $result_array['isSuccessful'] = false;
        echo json_encode($result_array);
    }

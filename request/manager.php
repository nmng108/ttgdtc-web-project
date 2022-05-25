<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

function get_all_requests($student_id) {
    $query = "SELECT * FROM Requests r LEFT JOIN RequestStatus rs ON r.statusID = rs.statusID 
            WHERE studentID = $student_id ORDER BY r.statusID";
    $result = run_mysql_query($query);
    
    if ($result !== false) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return NULL;
}

function make_user_request(int $student_id, string $start_datetime, string $end_datetime, string $note) {
    $query = "SELECT COUNT(`studentID`) totalRequests FROM Requests WHERE studentID = $student_id";
    $result = run_mysql_query($query);
    //limit the maximum number of requests to 3
    if ($result->num_rows == 3) {
        return false;
    }

    $query = "INSERT INTO `Requests`(`studentID`, `startTime`, `endTime`, `note`)
                VALUES ($student_id, $start_datetime, $end_datetime, $note)";
    
    return run_mysql_query($query);
}

function cancel_request($request_number) {

}
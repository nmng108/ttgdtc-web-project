<?php
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

const CLASS_REQUEST_LIMIT = 99;
const STUDENT_REQUEST_LIMIT = 99;

function get_all_requests($student_id) {
    $query = "SELECT * FROM Requests r LEFT JOIN RequestStatus rs ON r.statusID = rs.statusID 
            WHERE studentID = $student_id ORDER BY r.statusID";
    $result = run_mysql_query($query);
    
    if ($result !== false) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return NULL;
}

function make_new_request(int $student_id, string $start_datetime, string $end_datetime, string $class_code, string $note) {
    $query = "INSERT INTO Requests(`studentID`, `startTime`, `endTime`, `classCode`, `note`)
        VALUE ('$student_id', '$start_datetime', '$end_datetime', '$class_code', '$note')";
    $result = run_mysql_query($query);

    if ($result == true) {
        $query = "SELECT MAX(requestNumber) `lastRequestNumber` FROM requests WHERE studentID = ".$_POST['student_id'];
        $result = run_mysql_query($query);
        if ($result->num_rows == 1) {
            return $result->fetch_array()['lastRequestNumber'];
        }
    }

    return false;
}

function cancel_request($request_number) {
    $query = 
        "UPDATE Requests
        SET statusID = (SELECT statusID FROM RequestStatus WHERE statusName = 'CANCELED')
        WHERE requestNumber = $request_number";
    return run_mysql_query($query);
}

function delete_request($request_number) {
    $query = "DELETE FROM Requests WHERE requestNumber = $request_number";
    return run_mysql_query($query);
}

function decrease_quantity_in_inventory_by_cart($student_id) {
    $query = 
        "UPDATE Products p JOIN Carts c ON p.itemCode = c.itemCode
        SET availableQuantity = availableQuantity - c.quantity
        WHERE userID = $student_id AND category = '".SPORT_EQUIPMENT."'";
    
    return run_mysql_query($query);
}

function decrease_quantity_in_inventory_by_request($request_number) {
    $query = 
        "UPDATE Products p JOIN RequestDetails rd ON p.itemCode = rd.itemCode
        SET availableQuantity = availableQuantity - rd.quantity
        WHERE requestNumber = '".$request_number."'";
    
    return run_mysql_query($query);
}

function increase_quantity_in_inventory_by_request($request_number) {
    $query = 
        "UPDATE Products p JOIN RequestDetails rd ON p.itemCode = rd.itemCode
        SET availableQuantity = availableQuantity + rd.quantity
        WHERE requestNumber = $request_number";

    return run_mysql_query($query);
}

function create_request_details_by_cart($student_id) {
    $query = "INSERT INTO RequestDetails (requestNumber, itemCode, quantity)
            SELECT ".$_POST['request_number'].", c.itemCode, c.quantity 
            FROM Carts c JOIN Products p ON c.itemCode = p.itemCode
            WHERE category = '".SPORT_EQUIPMENT."' AND c.userID =  $student_id";
    
    return run_mysql_query($query);
}

/**
 * The value of $type IS IN ('CLASS', 'STUDENT')
 * The $value variable contains value that appropriate to $type.(CLASS->class_code; STUDENT->student_id)
 */
function is_requests_larger_than_limit(string $type, $val) {
    switch ($type) {
        case 'CLASS': 
            $query = "SELECT COUNT(classCode) totalRequests 
                FROM Requests r JOIN RequestStatus rs ON r.statusID = rs.statusID
                WHERE classCode = '$val' AND `statusName` IN ('SENT', 'APPROVED')";
            $result = run_mysql_query($query);

            if ($result->num_rows == 1) {
                if ($result->fetch_array()['totalRequests'] >= CLASS_REQUEST_LIMIT) {
                    return true;
                } else {

                }
            } else {

            }
            break;
        
        case 'STUDENT': 
            $query = "SELECT COUNT(classCode) totalRequests 
                FROM Requests r JOIN RequestStatus rs ON r.statusID = rs.statusID
                WHERE studentID = $val AND `statusName` IN ('SENT', 'APPROVED')";
            $result = run_mysql_query($query);

            if ($result->num_rows == 1) {
                if ($result->fetch_array()['totalRequests'] >= STUDENT_REQUEST_LIMIT) {
                    return true;
                } else {

                }
            } else {

            }
            break;
        
        default : throw new Exception("Unmatch type in comparison", 1);
            
    }

    return false;
}
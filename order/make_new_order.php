<?php
/**
 * Get 2 fields for making a new order: 
 * payment_method -> payment_method
 * note -> note
 */
$root_dir = "..";

include_once("../database/manager.php");
include_once("../includes/utilities.php");

const CLASS_ORDER_LIMIT = 3;
const STUDENT_ORDER_LIMIT = 3;

if (!isset($_POST)) exit("info is not sent by post method");

$response = [];
$response['message'] = '';
$response['hasSucceeded'] = false;

// If student's borrowing for their class, we'll check whether the number of order 
// for that class(in SENT/PREPARING status) is greater than LIMIT or not.
$query = "SELECT COUNT(studentID) totalOrders 
        FROM Orders r JOIN OrderStatus rs ON r.statusID = rs.statusID
        WHERE studentID = ".$_POST['student_id']. " AND `statusName` IN ('SENT', 'PREPARING')";
$result = run_mysql_query($query);

if ($result->num_rows == 1) {
    if ($result->fetch_array()['totalOrders'] >= STUDENT_ORDER_LIMIT) {
        $response['message'] = "Tạo đơn thất bại. Đã có tối đa số đơn cho 1 học sinh.";
        echo json_encode($response);
        exit();
    }
}  else {
    $response['message'] = "Tạo đơn thất bại. Truy vấn lỗi.";
    echo json_encode($response);
    exit();
}

$query = "INSERT INTO Orders(`studentID`, `paymentMethod`, `note`)
        VALUE ('".$_POST['student_id']."', '".$_POST['payment_method']."', '".$_POST['note']."')";
$result = run_mysql_query($query);

if ($result == true) {
    $query = "SELECT MAX(orderNumber) `lastOrderNumber` FROM orders WHERE studentID = ".$_POST['student_id'];
    $result = run_mysql_query($query);
    if ($result->num_rows == 1) {
        $last_order_number = $result->fetch_array()['lastOrderNumber'];
    }

    $response['message'] = "Tạo đơn thành công";
    $response['hasSucceeded'] = true;
    $response['order_number'] = $last_order_number;
    echo json_encode($response);
} else {
    $response['message'] = "(by query)Tạo đơn thất bại";
    echo json_encode($response);
}

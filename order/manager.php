<?php
include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

function get_all_orders($student_id) {
    $query = "SELECT * FROM Orders r LEFT JOIN OrderStatus rs ON r.statusID = rs.statusID 
            WHERE studentID = $student_id ORDER BY r.statusID";
    $result = run_mysql_query($query);
    
    if ($result !== false) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    echo "GET ERROR<br>";
    return NULL;
}

function get_order_total_price($order_number) {
    $query = "SELECT SUM(priceEach * quantity) AS totalPrice 
        FROM orderDetails o, Uniforms u
        WHERE o.itemCode = u.itemCode AND orderNumber = $order_number";
    $result = run_mysql_query($query);

    if ($result->num_rows == 1) {
        return $result->fetch_array()['totalPrice'];
    }
    echo "GET ERROR<br>";
    return NULL;
}

// unused
function make_user_order(int $student_id, string $payment_method, string $note) {
    $query = "SELECT COUNT(`studentID`) totalOrders FROM Orders WHERE studentID = $student_id";
    $result = run_mysql_query($query);
    //limit the maximum number of orders to 3
    if ($result->num_rows == 3) {
        return false;
    }

    $query = "INSERT INTO `Orders`(`studentID`, `paymentMethod`, `note`)
                VALUES ($student_id, $payment_method, $note)";
    
    return run_mysql_query($query);
}

// unused
function cancel_order($order_number) {

}
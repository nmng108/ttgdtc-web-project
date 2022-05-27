<?php
/**
 * Input includes 5 values:
 * current_status
 * next_status
 * request_number (contains current status if query the database)
 * old_note
 * new_note
 */
$root_dir = "../..";

include_once($root_dir."/includes/utilities.php");
include_once($root_dir."/database/manager.php");
include_once($root_dir."/request/manager.php");

$response = array();
$response['hasSucceeded'] = false;
$response['message'] = "";

if(!isset($_POST)){
    $response['message'] = "do nothing";
    echo json_encode($response);
    exit();
}

$current_status = $_POST['current_status'];
$next_status = $_POST['next_status'];
$request_number = $_POST['request_number'];
$old_note = $_POST['old_note'];
$new_note = $_POST['new_note'];

$need_note_update = false;

if ($old_note != $new_note) {
    $need_note_update = true;
}

function update_note($new_note, $request_number) {
    $query = "UPDATE Requests SET note = '$new_note' WHERE requestNumber = ".$request_number;
    return run_mysql_query($query);
}


// only old note is different from new note
if ($current_status == $next_status) {
    if ($need_note_update) {
        if (update_note($new_note, $request_number) === true) {
            $response['hasSucceeded'] = true;
            $response['message'] = "Cập nhật thành công";
            echo json_encode($response);
        } else {
            $response['message'] = "Cập nhật thất bại";
            echo json_encode($response);
        }
    } else {
        $response['hasSucceeded'] = true;
        $response['message'] = "Không có cập nhật mới";
        echo json_encode($response);
    }
    exit();
}

if ($current_status == 'SENT') {
    if ($next_status == 'CANCELED') {
        $query = "UPDATE requests 
                SET statusID = 
                        (SELECT statusID FROM RequestStatus 
                        WHERE statusName = '".$next_status."'), note = '".$new_note."' 
                WHERE requestNumber = '".$request_number."'";
        $result = run_mysql_query($query);

        if ($result === true) {
            $response['hasSucceeded'] = true;
            $response['message'] = "Yêu cầu ".$request_number." đã bị hủy";
            echo json_encode($response);
            exit();
        } else {
            $response['message'] = "Yêu cầu ".$request_number." huỷ không thành công";
            echo json_encode($response);
            exit();
        }
    }
    if ($next_status == 'APPROVED') {
        // Check if quantities of items in the request valid or not.
        $isValid = true;

        $query = "SELECT rd.itemCode, rd.quantity, availableQuantity, itemName
                FROM RequestDetails rd JOIN Products p ON rd.itemCode = p.itemCode
                WHERE requestNumber = ".$request_number;
        $result = run_mysql_query($query);
        
        if ($result->num_rows > 0) {
            $result = $result->fetch_all(MYSQLI_ASSOC);
            for ($i = 0; $i < count($result); $i++) {
                $item = $result[$i];

                if ($item['quantity'] > $item['availableQuantity']) {
                    $isValid = false;
                    break;
                }
            }
        }

        if ($isValid) {
            if (decrease_quantity_in_inventory_by_request($request_number) == true) {
                // Update status after succesfully decreasing quantities.
                $query = "UPDATE requests 
                        SET statusID = (SELECT statusID FROM RequestStatus WHERE statusName = '".$next_status."'), note = '".$new_note."' 
                        WHERE requestNumber = '".$request_number."'";
                $result = run_mysql_query($query);

                if ($result === true) {
                    $response['hasSucceeded'] = true;
                    $response['message'] = "Yêu cầu ".$request_number.": chuyển từ Chưa xử lý sang Đang mượn thành công";
                    echo json_encode($response);
                    exit();
                } else {
                    increase_quantity_in_inventory_by_request($request_number);
                    $response['message'] = "Yêu cầu ".$request_number." không thể cập nhật sang đang mượn.";
                    echo json_encode($response);
                    exit();
                }
            } else {
                $response['message'] = "Yêu cầu ".$request_number." không thể cập nhật giảm số lượng.";
                echo json_encode($response);
                exit();
            }
        } else {
            $response['message'] = "Yêu cầu ".$request_number." có số lượng dụng cụ không hợp lệ. Cập nhật số lượng trước khi mượn.";
            echo json_encode($response);
            exit();
        }
    }
}

if ($current_status == 'APPROVED') {
    if ($next_status == 'RETURNED') {
        if (increase_quantity_in_inventory_by_request($request_number) == true) {
            $query = "UPDATE requests 
                    SET statusID = (SELECT statusID FROM RequestStatus WHERE statusName = '".$next_status."'), note = '".$new_note."' 
                    WHERE requestNumber = '".$request_number."'";
            $result = run_mysql_query($query);
            
            if ($result === true) {
                $response['hasSucceeded'] = true;
                $response['message'] = "Yêu cầu ".$request_number.": dụng cụ đã được hoàn trả.";
                echo json_encode($response);
            }
        } else {
            $response['message'] = "error db update";
            echo json_encode($response);
        }
    }
}


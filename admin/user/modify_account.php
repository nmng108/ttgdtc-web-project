<?php
$root_dir = "../..";

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

// Planning to use this array as a result returns after submission by ajax.
$result_array = array();
$result_array['hasSucceeded'] = false;
$result_array['message'] = "";

if(isset($_POST)) {
	$student_id = $_POST['student_id'];
	$username = $_POST['username'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_number = $_POST['phone_number'];
	$password = $_POST['password'];
	$school = $_POST['school'];

    $query = 
        "SELECT studentID, email, phoneNumber, username FROM Students 
        WHERE studentID <> $student_id 
            AND (email = '$email' OR phoneNumber = '$phone_number' OR username = '$username')";
    $result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

    if(count($result) >= 1) {
        foreach ($result as $row) {
            if ($result['email'] == $email) {
                $result_array['message'] = "Đã có tài khoản sử dụng email này";
                exit();
            }
            if ($result['phoneNumber'] == $phone_number) {
                $result_array['message'] = "Đã có tài khoản sử dụng SĐT này";
                exit();
            }
            if ($result['username'] == $username) {
                $result_array['message'] = "Đã có tài khoản sử dụng username này";
                exit();
            }
        }
    } else {
        // only set new password if the input contains characters.
        $assign_password = ($password != "") ? "password = '$password'," : "";
        
        $query = 
                "UPDATE Students 
                SET username = '$username', firstName = '$first_name', lastName = '$last_name', 
                    email = '$email', phoneNumber = '$phone_number', $assign_password school = '$school' 
                WHERE studentID = $student_id";
        $result = run_mysql_query($query);

        if ($result === true) {
            $result_array['message'] = "Chỉnh sửa thành công";
            $result_arry['hasSucceeded'] = true;
        } else {
            $result_array['message'] = "Chỉnh sửa thất bại";
        }
    }
} else {
    $result_array['message'] = "Didn't get data from POST method";
}

header("Location: $root_dir/admin/user");
<?php
$root_dir = "../..";

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

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
        WHERE studentID = $student_id OR email = $email 
            OR phoneNumber = $phone_number OR username = $username";
    $result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

    if(count($result) >= 1) {
        foreach ($result as $student) {
            if ($student['studentID'] == $student_id) {
                $result_array['message'] = "Đã có tài khoản sử dụng MSV này";
                exit();
            }
            if ($student['email'] == $email) {
                $result_array['message'] = "Đã có tài khoản sử dụng email này";
                exit();
            }
            if ($student['phoneNumber'] == $phone_number) {
                $result_array['message'] = "Đã có tài khoản sử dụng SĐT này";
                exit();
            }
            if ($student['username'] == $username) {
                $result_array['message'] = "Đã có tài khoản sử dụng username này";
                exit();
            }
        }
    } else {
        $query = 
            "INSERT INTO Students (studentID, username, firstName, lastName, email, phoneNumber, password, school)
            VALUES ($student_id, $username, $first_name, $last_name, $email, $phone_number, $password, $school)";
        $result = run_mysql_query($query);

        if ($result === true) {
            $result_array['message'] = "Thêm thành công";
            $result_array['hasSucceeded'] = true;
        } else {
            $result_array['message'] = "Thêm thất bại";
        }
    }
} else {
    $result_array['message'] = "Didn't get data from POST method";
}
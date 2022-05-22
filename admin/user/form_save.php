<?php
/* 
 * No longer use this file
 */
$root_dir = "../..";

include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");

if(isset($_POST)) {
	$student_id = $_POST['student_id'];
	$fullname = $_POST['firstName'];
	$fullname = $_POST['lastName'];
	$email = $_POST['email'];
	$phone_number = $_POST['phone_number'];
	// $address = $_POST['address'];
	$password = $_POST['password'];

	if($student_id > 0) {
		//update
		$query = "select * from Users where email = '$email' and id <> $id";
		$userItem = executeResult($sql, true);

		if($userItem != null) {
			$msg = 'Email này đã tồn tại trong tài khoản khác, vui lòng kiểm tra lại!!!';
		} else {
			if($password != '') {
				$sql = "update Users set f_name = '$fullname', email = '$email', phone_number = '$phone_number', address_ = '$address', password_ = '$password', student_ID = '$student_ID', updated_at = '$updated_at', role_id = $role_id where id = $id";
			} else {
				$sql = "update Users set f_name = '$fullname', email = '$email', phone_number = '$phone_number', address_ = '$address', updated_at = '$updated_at', student_ID = '$student_ID', role_id = $role_id where id = $id";
			}
			execute($sql);
			header('Location: index.php');
			die();
		}
	} else {
		$sql = "select * from Users where email = '$email'";
		$userItem = executeResult($sql, true);
		//insert
		if($userItem == null) {
			//insert
			$sql = "insert into Users(f_name, email, phone_number, address_, student_ID password_, role_id, created_at, updated_at, deleted) values ('$fullname', '$email', '$phone_number', '$address', '$student_ID' '$password', '$role_id', '$created_at', '$updated_at', 0)";
			execute($sql);
			header('Location: index.php');
			die();
		} else {
			//Tai khoan da ton tai -> failed
			$msg = 'Email đã được đăng ký, vui lòng kiểm tra lại!!!';
		}
	}
}
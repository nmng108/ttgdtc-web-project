<?php 
session_start();
include "register.html";

require_once ('../utils/utility.php');
require_once ('../database/dbhelper.php');
$user = getUserToken();
if($user != null) {
        header('Location:index.php');
        die();
    }
//day DL da nhap len server
$email = $student_id = $cf_password = $password = $school = $firstname = $lastname = $phone_number = $msg='';
if(!empty($_POST)) {
    $email = getPost('email');
    $school = getPost('school');
    $password = getPost('password');
    $firstname = getPost('firstname');
    $lastname = getPost('lastname');
    $cf_password = getPost('cf_password');
    $student_id= getPost('student_id');
    $phone_number = getPost('phone_number');

    $userExist = executeResult("select * from students where studentID = '$student_id' or username = '$email'", true);
    if($userExist != null) {
        echo '<script >
        $(function() {         
        alert("Tài khoản đã tồn tại trên hệ thống!!")    
        })	
    </script>';
    } else {
        $sql = "insert into students (email, password, studentID, school, firstName, lastName, phoneNumber) 
        values ( '$email', '$password', '$student_id', '$school', '$firstname', '$lastname', '$phone_number')";
        execute($sql);  
        header('Location: login.php');
    }
    
} 
?>


<!-- GET: dữ liệu sẽ được đẩy lên URL, dữ liệu đẩy lên khá nhỏ -->
<!-- POST: không đẩy lên URL nên che dấu được thông tin, dữ liệu đẩy lên lớn -->
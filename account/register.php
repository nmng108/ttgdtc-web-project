<?php include "register.html";
session_start();
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
    $aschool = getPost('school');
    $password = getPost('password');
    $firstname = getPost('firstname');
    $lastname = getPost('lastname');
    $cf_password = getPost('cf_password');
    $student_id= getPost('student_id');
    $phone_number = getPost('phone_number');
    $userExist = executeResult("select * from students where studentID = '$student_id' and username = '$email'", true);
    if($userExist != null) {
        $msg = 'Email đã được đăng ký trên hệ thống';
        echo '<script >
        $(function() {         
        alert("Email đã tồn tại trên hệ thống!!")    
        })	
    </script>';
    } else {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        $sql = "insert into students (username, password, studentID, school, firstName, lastName, phoneNumber) 
        values ( '$email', '$password', '$student_id', '$school', '$firstname', '$lastname', '$phoneNumber')";
        execute($sql);  
        header('Location: login.php');
        die();
    }
    
} 
    
?>


<!-- GET: dữ liệu sẽ được đẩy lên URL, dữ liệu đẩy lên khá nhỏ -->
<!-- POST: không đẩy lên URL nên che dấu được thông tin, dữ liệu đẩy lên lớn -->

<?php include "register.html";

session_start();
require_once ('../../utils/utility.php');
require_once ('../../database/dbhelper.php');
$user = getUserToken();
if($user != null) {
    header('Location: ../');
    die();
}

//day DL da nhap len server
$email = $student_id = $cf_password = $password = $address = $name= $phone_number=$msg='';
if(!empty($_POST)) {
    $email = getPost('email');
    $address = getPost('address');
    $password = getPost('password');
    $name = getPost('name');
    $cf_password = getPost('cf_password');
    $student_id= getPost('student_id');
    $phone_number = getPost('phone_number');
    $userExist = executeResult("select * from users where email = '$email'", true);
    if($userExist != null) {
        $msg = 'Email đã được đăng ký trên hệ thống';
    } else {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        //Su dung ma hoa 1 chieu -> md5 -> hack
        // $password = getSecurityMD5($password);

        $sql = "insert into users (f_name, email, phone_number, password_, address_, student_ID, role_id, created_at) 
        values ('$name', '$email', '$phone_number', '$password', '$address', '$student_id', 2, '$created_at')";
        execute($sql);
        header('Location: login.php');
        die();
    }
    
} 
    
?>


<!-- GET: dữ liệu sẽ được đẩy lên URL, dữ liệu đẩy lên khá nhỏ -->
<!-- POST: không đẩy lên URL nên che dấu được thông tin, dữ liệu đẩy lên lớn -->

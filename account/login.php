<?php include "login.html";
session_start();
require_once ('../utils/utility.php');
require_once('../database/dbhelper.php');
$user = getUserToken();
if($user != null) {
        header('Location:../index.php');
} 
$user_name = $pass = $msg = '';
$res = false;
$user_name = getPost('email');
$pass = getPost('password');
$sql = "select * from students where username = '$user_name' and password = '$pass' ";
$userExist = executeResult($sql, true);
if($userExist == null ) {
    $msg = 'Đăng nhập không thanh công, vui long kiểm tra email hoặc mật khẩu!!!';    
    
}  else {
    $token = getSecurityMD5($userExist['username'].time());
    setcookie('token', $token, time() + 60*24*60*7, '/');
    $created_at = date('Y-m-d H:i:s');
    $_SESSION['user'] = $userExist;
    $userId = $userExist['studentID'];
    $sql = "insert into Tokens (user_id, token, created_at) values ('$userId', '$token', '$created_at')";
    execute($sql);
    header('Location: ../index.php');
    die();
}

?>

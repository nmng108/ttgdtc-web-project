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
$username = getPost('username');
$pass = getPost('password');
$sql = "select * from students where (email = '$username' OR studentID = $username OR username = $username) and password = '$pass' ";
$userExist = executeResult($sql, true);
if($userExist == null ) {
    $msg = 'Đăng nhập không thành công, vui lòng kiểm tra email hoặc mật khẩu!!!';    
    
}  else {
    $token = getSecurityMD5($userExist['username'].time());
    setcookie('token', $token, time() + 60*24*60*7, '/');
    $created_at = date('Y-m-d H:i:s');
    $_SESSION['user'] = $userExist;
    $userId = $userExist['studentID'];
    $sql = "insert into UserTokens (userId, token) values ('$userId', '$token')";
    execute($sql);
    header('Location: ../index.php');
    die();
}

?>

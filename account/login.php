<?php include "login.html";
session_start();
require_once ('../utils/utility.php');
require_once('../database/dbhelper.php');
$user = getUserToken();
if($user != null) {
        header('Location:../index.php');
} 
$user_name = $pass = $msg  = '';
$user_name = getPost('email');
$pass = getPost('password');
$sql = "select * from students where email = '$user_name' and password = '$pass' ";
$userExist = executeResult($sql, true);
$sql1 = "select * from admins where email = '$user_name' and password = '$pass' ";
$userExist1 = executeResult($sql1, true);

if($userExist == null ) {
    if ($userExist1 == null) {
        if (!empty($_POST)) {
            echo '<script >
            $(function() {       
            alert("Đăng nhập không thanh công, vui lòng kiểm tra email hoặc mật khẩu!!!")      
            })	
            </script>';
        }
    } else {
        $token = getSecurityMD5($userExist1['username'].time());
        setcookie('token', $token, time() + 60*24*60*7, '/');
        $created_at = date('Y-m-d H:i:s');
        $_SESSION['admin'] = $userExist;
        $userId = $userExist['adminID'];
        $sql = "insert into Tokens (user_id, token, created_at) values ('$userId', '$token', '$created_at')";
        execute($sql);
        header('Location: ../admin');
        die();

    }
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

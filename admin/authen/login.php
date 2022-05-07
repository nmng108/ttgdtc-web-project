<?php include "login.html";
session_start();

// if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'true') {
//     header('Location: user.php');
//     die();
// }
require_once ('../../utils/utility.php');
require_once('../../database/dbhelper.php');

$user = getUserToken();
if($user != null) {
    header('Location: ../');
    die();
}

$user_name = $pass = '';
$res = false;
$user_name = getPost('email');
$pass = getPost('password');
// $pass = getSecurityMD5($pass);


$sql = "select * from users where email = '$user_name' and password_ = '$pass' and role_id = '1'";
$userExist = executeResult($sql, true);
if($userExist == null) {
    $msg = 'Đăng nhập không thanh công, vui long kiểm tra email hoặc mật khẩu!!!';
} else {
    //login thanh cong
    $token = getSecurityMD5($userExist['email'].time());
    setcookie('token', $token, time() + 60*24*60*7, '/');
    $created_at = date('Y-m-d H:i:s');

    $_SESSION['user'] = $userExist;
    $userId = $userExist['id'];
    $sql = "insert into Tokens (user_id, token, created_at) values ('$userId', '$token', '$created_at')";
    execute($sql);
    header('Location: ../');
    die();
}

?>

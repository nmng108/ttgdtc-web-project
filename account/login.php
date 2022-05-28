<?php include "login.html";
session_start();

$root_dir = "..";

require_once ('../utils/utility.php');
require_once('../database/dbhelper.php');
require_once('../database/manager.php');
include_once('../includes/utilities.php');

$user = getUserToken();
if($user != null) {
        header('Location:../index.php');
} 

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $pass = $msg  = '';
    $username = getPost('username');
    $pass = getPost('password');

    $sql = "select * from students where (email = '$username' OR studentID = '$username' OR username = '$username') and password = '$pass' ";
    $student_info = executeResult($sql, true);
    $sql1 = "select * from admins where (email = '$username' OR adminID = '$username' OR username = '$username') and password = '$pass' ";
    $admin_info = executeResult($sql1, true);

    if($student_info == null ) {
        if ($admin_info == null) {
            if (!empty($_POST)) {
                echo '<script >
                $(function() {       
                alert("Đăng nhập không thành công, vui lòng kiểm tra email hoặc mật khẩu!!!")      
                })	
                </script>';
            }
        } else {
            $token = getSecurityMD5($admin_info['lastName'].time());
            setcookie('token', $token, time() + 60*24*60*7, '/');

            $_SESSION['admin'] = $admin_info; 
            $_SESSION[USERID] = $admin_info['adminID'];

            $sql = "insert into UserTokens (userId, token) values (".$_SESSION[USERID].", '$token')";
            execute($sql);
            header('Location: ../admin');

        }
    }  else {
        $token = getSecurityMD5($student_info['lastName'].time());
        setcookie('token', $token, time() + 60*24*60*7, '/');

        $_SESSION['student'] = $student_info; 
        $_SESSION[USERID] = $student_info['studentID'];

        $sql = "insert into UserTokens (userId, token) values (".$_SESSION[USERID].", '$token')";
        execute($sql);
        header('Location: ../index.php');
    }
}

?>

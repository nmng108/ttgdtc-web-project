<?php
 session_start();
 require_once('../utils/utility.php');
 require_once('../database/dbhelper.php');
//  require('../account/login.php');
 $user = getUserToken();
if($user == null) {
    header('Location: ../account/login.php');
    die();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../assets/css/style_user.css">
	

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<style type="text/css">
		.main {
			min-height: 700px;
		}
	</style>
</head>
<body>
	<!-- header START -->
	<!-- Grey with black text -->
	<div class="container">
            <div class="navbar" >
                <div class="logo">
                    <img src = "../image/logovnu.png" width = "150px">
                </div>
                <nav  >
                    <ul>
                        <li><a style="text-decoration: none;" href="index.php">Trang chủ</a> </li>
                        <li><a style="text-decoration: none;" href="../index.php">Dụng cụ</a> </li>
                        <li><a  style="text-decoration: none;" href="../shopping.php">Đồng phục</a></li>
                        <li><a style="text-decoration: none;" href="../account/logout.php"> Thoát</a> </li>
                        <li> <a style="text-decoration: none;" href="account.php">Tài khoản</a></li>
                     </ul>
                     
                </nav>
            </div>
    </div>

	<!-- header END -->

	
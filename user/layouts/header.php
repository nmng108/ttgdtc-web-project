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
<nav class="navbar navbar-expand-sm navbar-dark sticky-top py-1" style="background-color:b3d8ba;">
        <a class="navbar-brand" href="<?=$root_dir?>/">
            <img src="<?=$root_dir?>/assets/images/logovnu.png" width="120px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav" >
                <li class="nav-item">
                    <a class="nav-link" style="color: black;" href="<?="$root_dir/"?>">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: black;" href="<?=$root_dir?>/request">Tài khoản</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: black;" href="<?=$root_dir?>/cart">Giỏ hàng</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" style="color: black;" href="<?=$root_dir?>/account/logout.php">Đăng xuất</a>
                </li>    
            </ul>
        </div>  
    </nav>
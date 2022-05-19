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
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="../assets/css/style_user.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body style="font-family: 'Roboto', sans-serif;">
<style>   
    body{
        text-align: center;   
        font-family: 'Roboto', sans-serif;                 
    }
    button{
        margin: 30px 0;
        margin-left: 90px;
        width: 120px;
        height: 50px;
        background-color: rgb(245, 249, 245);
        border: 1px solid;
        cursor: pointer;
        border-radius: 15px;
    }
    button:hover {
        transition: 0.5s;
        background-color: rgb(213, 235, 217);
    }

    input{
        width: 50%;
        height: 40px;
        text-align: center;
        vertical-align: middle;
        margin: 8px 0;
        margin-left: 25px;
        border: 2px solid rgb(189, 197, 189);
        border-radius: 25px;
    }
    .row{
        width: 100%;
        margin-bottom: auto;
    }
    .infor{

        text-align: left;
        width: 600px; 
        margin: 0px auto; 
        margin-top: 10px; 
        margin-left: 30px;
        margin-bottom: 50px; 
        background-color: white; 
        padding: 10px; 
        border-radius: 5px; 
        box-shadow: 2px 2px 2px 2px #53925f;
    }
    .title_account{
        font-size: 23px;
        color: #53925f;
    }
    
 
	</style>
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
                        <li><a style="text-decoration: none;" href="index.php">Dụng cụ</a> </li>
                        <li><a  style="text-decoration: none;" href="order.php">Đồng phục</a></li>
                        <li><a style="text-decoration: none;" href="../account/logout.php"> Thoát</a> </li>
                        <li> <a style="text-decoration: none;" href="account.php">Tài khoản</a></li>
                     </ul>
                     
                </nav>
            </div>
    </div>

	<!-- header END -->

	
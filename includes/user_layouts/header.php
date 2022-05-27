<?php
// Specify the correct variables $root_dir and $title base on the calling file before requiring/including this file. -->
session_start();

include_once("$root_dir/includes/utilities.php");
require_once("$root_dir/database/manager.php");
require_once("$root_dir/utils/utility.php");
require_once("$root_dir/database/dbhelper.php"); 
//giữ đăng nhập
$user = getUserToken();
if($user == null) {
   header('Location: account/login.php');
   die();
}
$student_name = $user['lastName'];

?>


<!DOCTYPE html>
<html>
<head>
	<?php include_once("$root_dir/includes/headtag.php"); ?>
    <link rel="stylesheet" href="<?=$root_dir?>/assets/css/style_user.css">
	<style type="text/css">
		.main {
			min-height: 700px;
		}
        body {
            font: 15px Arial, sans-serif;
        }
        .infor{

                text-align: left;
                width: 600px; 
                margin: 0px auto; 
                margin-top: 10px; 
                margin-left: 75px;
                margin-bottom: 50px; 
                background-color: white; 
                padding: 10px; 
                border-radius: 5px; 
                box-shadow: 2px 2px 2px 2px #53925f;
}
	</style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top py-1" style="background-color:lightseagreen;">
        <a class="navbar-brand" href="<?=$root_dir?>/">
            <img src="<?=$root_dir?>/assets/images/logovnu.png" width="120px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="homepage" href="<?=$root_dir?>">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="request" href="<?=$root_dir?>/request">Yêu cầu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cart" href="<?=$root_dir?>/cart">Giỏ hàng</a>
                </li>    
            </ul>
        </div> 
        <div class="justify-content-end collapse navbar-collapse">
            <a  href = "<?=$root_dir?>/infor_account" class="" style="color:lightgray; margin-right:15px">Xin chào, <?=$student_name?></a> 
            <a class="nav-link btn btn-secondary" href="<?=$root_dir?>/account/logout.php" style="background-color:dimgray">Đăng xuất</a>
        </div>

    </nav>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>Trung tâm giáo dục thể chất, ĐHQGHN</h1>
        <h3>Web site cho thuê mượn dụng cụ thể thao</h3> 
    </div>
	<!-- header END -->

    <script>
        var current_page = document.location.href.split('/')[4];
        if (current_page == '') current_page = 'homepage';

        document.getElementById(current_page).style.fontWeight = 'bold';
        document.getElementById(current_page).style.fontSize += 1;
        document.getElementById(current_page).style.color = 'white';
    </script>
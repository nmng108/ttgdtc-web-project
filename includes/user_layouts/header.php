<?php
// Specify the correct variables $root_dir and $title base on the calling file before requiring/including this file. -->
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
<body style="color: black;">
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top py-1" style="background-color:  #9fc5a6; color: black;">
        <a class="navbar-brand" href="<?=$root_dir?>/">
            <img src="<?=$root_dir?>/assets/images/logovnu.png" width="120px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul style="color: black;" class="navbar-nav">
                <li class="nav-item">
                    <a style="color: black;" class="nav-link" href="<?=$root_dir?>">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a style="color: black;" class="nav-link" href="<?=$root_dir?>/request">Yêu cầu</a>
                </li>
                <li class="nav-item">
                    <a style="color: black;" class="nav-link" href="<?=$root_dir?>/cart">Giỏ hàng</a>
                </li>    
                <li class="nav-item">
                    <a style="color: black;" class="nav-link" href="<?=$root_dir?>/account/logout.php">Đăng xuất</a>
                </li>    
            </ul>
        </div>  
    </nav>
	<!-- header END -->
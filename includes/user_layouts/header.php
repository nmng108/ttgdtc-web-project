<!-- Specify the correct variables $root_dir and $title base on the calling file before requiring/including this file. -->
<?php

include_once("$root_dir/includes/headtag.php");
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
	<style type="text/css">
		
	</style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top py-1" style="background-color:b3d8ba;margin-top:0px;">
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
                    <a class="nav-link" style="color: black;" href="#">Tài khoản</a>
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
    
	<!-- header END -->
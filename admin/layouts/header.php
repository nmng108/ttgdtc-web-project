<?php
  session_start();
  
  require_once($root_dir.'/utils/utility.php');
  require_once($root_dir.'/includes/utilities.php');
  require_once($root_dir.'/database/manager.php');
  // $admin = getUserToken();
  // if($admin == null ) {
  //   header('Location: '.$root_dir.'account/login.php');
  //   die();
  // }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$root_dir?>/assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>
<body>
<nav class="navbar fixed-top flex-md-nowrap p-0 shadow" style="background: #53925f;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#" style="color:white; ">ADMIN</a>
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link " style="color: white;" href="<?=$root_dir?>/account/logout.php">Thoát</a>
    </li>
  </ul>
</nav>	
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="width: 15%;">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="<?=$root_dir?>/admin">
              <i class="bi bi-house-fill"></i>
              Dashboard
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="<?=$root_dir?>/admin/product">
              <i class="bi bi-file-earmark-text"></i>
              Dụng Cụ
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$root_dir?>/admin/request">
              <i class="bi bi-minecart" ></i>
              Quản Lý Yêu Cầu
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$root_dir?>/admin/order">
              <i class="bi bi-minecart" ></i>
              Quản Lý Đơn Đặt Đồng Phục
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="<?=$root_dir?>/admin/user">
              <i class="bi bi-people-fill"></i>
              Quản Lý Người Dùng
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
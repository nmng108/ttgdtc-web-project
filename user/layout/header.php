
<?php
  session_start();
  require_once('../utils/utility.php');
  require_once('../database/dbhelper.php');
  $user = getUserToken();
  if($user == null) {
    header('Location: ../account/login.php');
    die();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ĐHQGHN Management</title>
    <link rel ="stylesheet" href = "../assets/css/style_user.css">
    
<link rel="stylesheet" type="text/css" href="<?=$baseUrl?>../assets/css/style.css">

</head>
<body>
        <div class="container">
            <div class="navbar"?>
                <div class="logo">
                    <img src = "../image/logovnu.png" width = "250px">
                </div>
                <nav>
                    <ul>
                        <li><a href=".../index.php"> Home</a> </li>
                        <li><a href="borrow.php"> Borrowing</a> </li>
                        <li><a href="shopping.php">Shopping</a></li>
                        <li><a href="account.php"> Account</a> </li>
                        <li><a href="../account/logout.php">Exit</a></li>
                     </ul>
                     
                <img src = "../image/cart.png" width = "40px" height = "30px">
                <img src = "../image/menu.png" class = "menu-icon">
                </nav>
            </div>
        </div>
<?php

$root_dir = "..";
$title = 'Trang chủ';
include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/utilities.php");



$firstName = $lastName = $email = $phoneNumber = $msg = "";
if(!(empty($_POST))) {
    $firstName = getPost('firstName');
    $lastName = getPost('lastName');
    $id = $_SESSION[USERID];
    $email = getPost('email');
    $phoneNumber = getPost('phoneNumber');
    $query ="UPDATE students 
    SET firstName = '" . $_POST['firstName'] . "', 
    lastName = '" . $_POST['lastName'] . "',
    email = '" . $_POST['email'] . "'
        WHERE studentID = $id"
    ;
    $result = run_mysql_query($query);
    $msg = "*Cập nhật thành công!";
}
?>
<style>
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
}

</style>
<div class="infor" >
    <h4>Thay đổi thông tin</h4>
    <h5 style="color: green;"><?=$msg?></h5>

        <!-- common fields -->
        <form action="" method="post">
        <div class="form-group">
        <label for="full_name">Họ:</label>
        <input class="form-control" type="text" name="firstName" >
        </div>
        <div class="form-group">
        <label for="full_name">Tên:</label>
        <input class="form-control" type="text" name="lastName" >
        </div>
        <div class="form-group">
        <label for="school">Email </label>
        <input class="form-control"type="text" name="email"  >
        </div>
        <div class="form-group">
        <label for="phone_number">Số điện thoại </label>
        <input class="form-control" type="number" name="phone_number" >
        </div>
        <button>
           Cập nhật
        </button>
        <a href="../index.php">
            Thoát
        </a>
        </form>
</div>


<?php
include_once("$root_dir/includes/user_layouts/footer.php");
include_once("$root_dir/includes/user_layouts/cart_icon_bubble.php");
?>

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
    header("Location: ./");
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
<?php
$query = "SELECT * FROM Students WHERE studentID = " . $_SESSION[USERID];
$student_info = run_mysql_query($query)->fetch_array();
?>

<div class="infor" >
    <h4>Thay đổi thông tin</h4>
    <h5 style="color: green;"><?=$msg?></h5>

        <!-- common fields -->
        <form action="" method="post">
        <div class="form-group">
        <label for="full_name">Họ:</label>
        <input class="form-control" type="text" name="firstName" value="<?=$student_info['firstName']?>" required>
        </div>
        <div class="form-group">
        <label for="full_name">Tên:</label>
        <input class="form-control" type="text" name="lastName" value="<?=$student_info['lastName']?>" required>
        </div>
        <div class="form-group">
        <label for="school">Email </label>
        <input class="form-control"type="text" name="email" value="<?=$student_info['email']?>" required>
        </div>
        <div class="form-group">
        <label for="phone_number">Số điện thoại </label>
        <input class="form-control" type="number" name="phone_number" value="<?=$student_info['phoneNumber']?>" required>
        </div>
        <button>
           Cập nhật
        </button>
        <a href="./">
            Thoát
        </a>
        </form>
</div>


<?php
include_once("$root_dir/includes/user_layouts/footer.php");
include_once("$root_dir/includes/user_layouts/cart_icon_bubble.php");
?>

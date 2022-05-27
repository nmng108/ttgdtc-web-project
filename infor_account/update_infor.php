<?php
session_start();

$root_dir = "..";
$title = 'Trang chủ';
include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/utilities.php");



$firstName = $lastName = $email = $phoneNumber = $msg = "";
if(!(empty($_POST))) {
    $firstName = getPost('firstName');
    $lastName = getPost('lastName');
    $id = $_SESSION['studentID'];
    $email = getPost('email');
    $phoneNumber = getPost('phoneNumber');
    if ($firstName == $user_info['firstName'] && $lastName == $user_info['lastName'] && $email == $user_info['email']) {
        $msg = "Không có thay đổi nào được thực hiện";
    } else {
        $query ="UPDATE students 
		SET firstName = '" . $_POST['firstName'] . "', 
        lastName = '" . $_POST['lastName'] . "',
        email = '" . $_POST['email'] . "'
			WHERE studentID = $id"
		;
        $result = run_mysql_query($query);
        

    }

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
<div class="infor">
    <h4>Thay đổi thông tin</h4>
        <!-- common fields -->
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
</div>


<?php
include_once("$root_dir/includes/user_layouts/footer.php");
include_once("$root_dir/includes/user_layouts/cart_icon_bubble.php");
?>

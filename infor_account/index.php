<?php

$root_dir = "..";
$title = 'Trang chủ';
include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/utilities.php");
$query = "SELECT * FROM Students WHERE studentID = ".$_SESSION[USERID];
$result = run_mysql_query($query);

if ($result->num_rows == 1) {
    $user_info = $result->fetch_array();
}
// handle name
if ($user_info['firstName'] === NULL) {
    $user_info['fullName'] = $user_info['lastName'];
} else {
    $user_info['fullName'] = $user_info['firstName'] . " " . $user_info['lastName'];
}
// handle school name (can convert into a table)
switch ($user_info['school']) {
    case "UET":
        $user_info['school'] = "Đại học Công nghệ";
        break;
    case "ULIS":
        $user_info['school'] = "Đại học Ngoại ngữ";
        break;
    case "IS":
        $user_info['school'] = "Trường Quốc Tế";
        break;
    case "UEd":
        $user_info['school'] = "Đại học Giáo dục";
        break;
    case "UEB":
        $user_info['school'] = "Đại học Kinh tế";
        break;
    case "SoL":
        $user_info['school'] = "Khoa Luật";
        break;
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
    <h4>Thông tin người mượn</h4>
        <!-- common fields -->
        <div class="form-group">
        <label for="student_id">Mã sinh viên </label>
        <input class="form-control" type="text" name="student_id" value="<?=$_SESSION[USERID]?>" disabled>
        </div>
        <div class="form-group">
        <label for="full_name">Họ Tên </label>
        <input class="form-control" type="text" name="full_name" value="<?=$user_info['fullName']?>" disabled>
        </div>
        <div class="form-group">
        <label for="school">Email</label>
        <input class="form-control"type="text" name="email" value="<?=$user_info['email']?>" disabled>
        </div>
        <div class="form-group">
        <label for="phone_number">Số điện thoại </label>
        <input class="form-control" type="number" name="phone_number" value="<?=$user_info['phoneNumber']?>" disabled>
        </div>
        <a href="update_infor.php">
        <button>
            Thay đổi thông tin
        </button>
        </a>
        <a href="update_psw.php">
        <button>
        Đổi mật khẩu
        </button>
        </a>
        <a href="../index.php">
            Thoát
        </a>
</div>


<?php
include_once("$root_dir/includes/user_layouts/footer.php");
include_once("$root_dir/includes/user_layouts/cart_icon_bubble.php");
?>

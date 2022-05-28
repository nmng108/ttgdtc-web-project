<?php
$root_dir = "..";
$title = 'Trang chủ';
include_once("$root_dir/includes/user_layouts/header.php");
include_once("$root_dir/includes/utilities.php");
$firstName = $lastName = $email = $phoneNumber = $msg = "";
if(!(empty($_POST))) {
    $query = "SELECT * FROM Students WHERE studentID = ".$_SESSION[USERID];
    $result = run_mysql_query($query);

    if ($result->num_rows == 1) {
        $user_info = $result->fetch_array();
    }
    $oldpass = getPost('oldpass');
    $newpass = getPost('newpass');
    $id = $user_info['studentID'];
    $cfnewpass = getPost('cfnewpass');
    if($oldpass != $user_info['password']) {
        echo '<script >
        $(function() {       
        alert("Mật khẩu cũ không chính xác, vui lòng nhập lại!")      
        })	
        </script>';

    } else {
        
        if($newpass != $cfnewpass) {
            echo '<script >
            $(function() {       
            alert("Mật khẩu mới không khớp, vui lòng nhập lại!")      
            })	
            </script>';

        } else {
            $query ="UPDATE students 
            SET password = '" . $_POST['newpass'] . "'
                WHERE studentID = $id"
            ;
            $result = run_mysql_query($query);
            $msg = "*Cập nhật thành công!";
        }
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
<div class="infor" >
    <h4>Thay đổi mật khẩu</h4>
    <h5 style="color: green;"><?=$msg?></h5>
        <!-- common fields -->
        <form action="" method="post">
        <div class="form-group">
        <label for="full_name">Mật khẩu cũ:</label>
        <input class="form-control" type="text" name="oldpass" >
        </div>
        <div class="form-group">
        <label for="full_name">Mật khẩu mới:</label>
        <input class="form-control" type="text" name="newpass" >
        </div>
        <div class="form-group">
        <label for="school">Xác nhận mật khẩu mới: </label>
        <input class="form-control"type="text" name="cfnewpass"  >
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

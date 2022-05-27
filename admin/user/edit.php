<?php
$title = 'Sửa Tài Khoản Người Dùng';
$root_dir = '../..';

require_once("$root_dir/admin/layouts/header.php");


if (!isset($_GET['id'])) {
	header("Location: $root_dir/admin/user");
}

$id = $msg = $fullname = $email = $phone_number = $student_ID = $address = $role_id = '';
// require_once('form_save.php');

$id = $_GET['id'];
// Still only available for student account.
if($id != '' && $id > 0) {
	$query = "SELECT *, 'Student' AS `role` from Students where studentID = '$id'";
	$user = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC)[0];
	if($user != null) {
		$student_id = $user['studentID'];
		$first_name = $user['firstName'];
		$last_name = $user['lastName'];
		$username = $user['username'];
		$email = $user['email'];
		$phone_number = $user['phoneNumber'];
		$school = $user['school'];
		$role = $user['role'];
	} else {
		$id = 0;
	}
} else {
	$id = 0;
}

// $sql = "select * from Role";
// $roleItems = executeResult($sql);
?>
<style>
    .infor{
        text-align: left;
        width: 900px; 
        margin: 0px auto; 
        margin-top: 10px; 
        margin-left: 55px;
        margin-bottom: 50px; 
        background-color: white; 
        padding: 10px; 
        border-radius: 5px; 
        box-shadow: 2px 2px 2px 2px #53925f;
    }
</style>

<div class="row" style="margin-top: 20px;">
	<div >
		<h3 style="text-align: center;">Sửa thông tin tài khoản người dùng</h3>
		<div class="infor">
			<div class="panel-heading">
				<h5 style="color: red;"><?=$msg?></h5>
			</div>
			<div class="panel-body">
				<form method="post" action="modify_account.php" onsubmit="return validateForm();">
					
					<div class="form-group">
						<label for="first_name">Họ: </label>
						<input type="text" class="form-control" id="first_name" name="first_name" value="<?=$first_name?>">
						<label for="last_name">Tên: </label>
						<input type="text" class="form-control" id="last_name" name="last_name" value="<?=$last_name?>" required>
					</div>
					
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" name="email" value="<?=$email?>" required>
					</div>
					<div class="form-group">
						<label for="phone_number">SĐT:</label>
						<input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?=$phone_number?>" required>
					</div>
					
					<div class="form-group">
						<label for="username">Tên đăng nhập: </label>
						<input type="tel" class="form-control" id="username" name="username" value="<?=$username?>">
					</div>
		
					<button type="submit" class="btn btn-success">Cập nhật</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const PASSWORD_INPUT = document.getElementById("password");
	const PASSWORD_RETYPE_INPUT = document.getElementById("confirmation_password");

	PASSWORD_INPUT.addEventListener("keyup", ()=>{
		console.log(PASSWORD_INPUT.value);
		if (PASSWORD_INPUT.value != "") {
			set_password_required(true);
		} else {
			set_password_required(false);
		}
	});

	function set_password_required(is_required) {
		if (is_required === true) {
			PASSWORD_INPUT.required = true;
			PASSWORD_INPUT.setAttribute('minlength', 6);

			PASSWORD_RETYPE_INPUT.disabled = false;
			PASSWORD_RETYPE_INPUT.setAttribute('required', true);
			PASSWORD_RETYPE_INPUT.setAttribute('minlength', 6);
		} else if (is_required === false) {
			PASSWORD_INPUT.required = false;
			PASSWORD_INPUT.setAttribute('minlength', 0);
			// removing attribute doesn't work??
			PASSWORD_RETYPE_INPUT.disabled = true;
			PASSWORD_RETYPE_INPUT.required = false;
			PASSWORD_RETYPE_INPUT.setAttribute('minlength', 0);
		}
	}

	function validateForm() {
		$password = $('#password').val();
		$confirmPwd = $('#confirmation_password').val();
		
		if ($password == "" && $confirmPwd == "") return true;

		if ($password !== $confirmPwd) {
			alert("Mật khẩu không khớp, vui lòng kiểm tra lại");
			return false;
		}

		return true;
	}
</script>

<?php
	require_once('../layouts/footer.php');
?>
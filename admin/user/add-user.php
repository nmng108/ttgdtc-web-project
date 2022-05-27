<?php
$title = 'Thêm Tài Khoản Người Dùng';
$root_dir = '../..';

require_once("$root_dir/admin/layouts/header.php");
require_once("../../utils/utility.php");
$email = $student_id = $cf_password = $password = $school = $firstname = $lastname = $phone_number = $msg='';
if(!empty($_POST)) {
    $email = getPost('email');
    $school = getPost('school');
    $password = getPost('password');
    $firstname = getPost('firstname');
    $lastname = getPost('lastname');
    $cf_password = getPost('cf_password');
    $student_id= getPost('student_id');
    $phone_number = getPost('phone_number');
    switch($school) {
        case "Đại Học Công Nghệ": 
            $sc = "UET";
            break;
        case "Đại Học Ngoại Ngữ": 
            $sc = "ULIS";
            break;
        case "Đại Học Giáo DỤc": 
            $sc = "UEd";
            break;
        case "Đại Học Kinh Tế": 
            $sc = "UEB";
        break;
        
        case "Quốc Tế": 
            $sc = "IS";
            break;
    }
    $userExist = run_mysql_query("select * from students where studentID = '$student_id' or username = '$email'", true);
    if($userExist != null) {
        $msg = "*Tài khoản đã tồn tại trên hệ thống";
    } else {
        $created_at = $updated_at = date('Y-m-d H:i:s');
        $sql = "insert into students (email, password, studentID, school, firstName, lastName, phoneNumber) 
        values ( '$email', '$password', '$student_id', '$sc', '$firstname', '$lastname', '$phoneNumber')";
        execute($sql);  
        header('Location: index.php');
        die();
    }
    
} 
    
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
	<div class="col-md-12 table-responsive">
		<h3 style="text-align: center; margin-bottom: 20px;">Thêm Tài Khoản Người Dùng</h3>
		<div class="infor">
			<div class="panel-heading">
				<h5 style="color: brown;font-style: italic;"><?=$msg?></h5>
			</div>
			<div class="panel-body container" >
				<form method="post" action="" onsubmit="return validateForm();">
					<div class="form-group">
						<label for="student_ID">Mã sinh viên: </label>
						<input type="tel" class="form-control" id="student_id" name="student_id" required>
					</div>
					<div class="form-group">
						<label for="first_name">Họ: </label>
						<input type="text" class="form-control" id="first_name" name="first_name" >
						<label for="last_name">Tên: </label>
						<input type="text" class="form-control" id="last_name" name="last_name"  required>
			
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" name="email"  required>
					</div>
					<div class="form-group">
						<label for="phone_number">SĐT:</label>
						<input type="tel" class="form-control" id="phone_number" name="phone_number"  required>
					</div>
					<div class = "form-group">
						<label for="school">Trường: </label>
						<select  name="school" class="form-control" required>
							<option value="UET">Đại Học Công Nghệ</option>
							<option value="ULIS">Đại Học Ngoại Ngữ</option>
							<option value="IS">Trường Quốc Tế</option>
							<option value="SoL">Khoa Luật</option>
							<option value="UEB">Đại Học Kinh Tế</option>
							<option value="UEd">Đại Học Giáo Dục</option>
						</select>
					</div>
					<div class="form-group">
						<label for="username">Tên đăng nhập: </label>
						<input type="tel" class="form-control" id="username" name="username" >
					</div>
					<div class="form-group">
						<label for="password">Mật Khẩu:</label>
						<input type="password" class="form-control" id="password" name="password">
					</div>
					<div class="form-group">
						<label for="confirmation_pwd">Xác Minh Mật Khẩu:</label>
						<input type="password" class="form-control" id="confirmation_password" disabled>
					</div>
					<button type="submit" class="btn btn-success">Đăng Ký</button>
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
<!-- // hiển thị danh sách người dùng đã đk trong hệ thống
// nếu người dùng chưa đăng nhập thì tự động chuyển sang trang login
1. tìm hiểu về cookie:
so sánh cookie và localstorage
- giống nhau: cùng được lưu trữ và quản lí bởi trình duyệt web
-khác biệt:
+cookie: 
        có thể thiết lập một thời gian sống->tới giới hạn->tự động xoá đi
        thêm sửa xoá bằng php hoặc js
        khi gửi yêu cầu lên server(request URL) thì nó sẽ gửi toàn bộ các cookie tương ứng gửi kèm lên server

DU AN
DATABASE:
- email
- name
- student ID
- password
- dia chi
- so dien thoai
 -->
 <?php
 if (!isset($_COOKIE['login']) || $_COOKIE['login'] != 'true') {
	header('Location: login.php');
	die();
}

require_once ('C:\xampp\htdocs\testphp\database\dbhelper.php');
// require_once ('../utils/utility.php');



$sql      = "select * from users";
$userList = executeResult($sql);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Users Page</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Users Page</h2>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Full Name</th>
							<th>Email</th>
							<th>Student_ID</th>
							<th>Address</th>
							<th style="width: 50px;"></th>
							<th style="width: 50px;"></th>
						</tr>
					</thead>
					<tbody>
<?php
$count = 0;
foreach ($userList as $item) {
	echo '<tr>
			<td>'.(++$count).'</td>
			<td>'.$item['f_name'].'</td>
			<td>'.$item['email'].'</td>
			<td>'.$item['student_ID'].'</td>
			<td>'.$item['address_'].'</td>
			<td><button class="btn btn-warning">Edit</button></td>
			<td><button class="btn btn-danger">Delete</button></td>
		</tr>';
}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>


<?php 
$title = 'Trang yêu cầu';
include_once('layouts/header.php');
?>
 <!-- THÔNG TIN YEU CẦU MƯỢN -->
<div class="panel-body" style="color: red;"> THÔNG TIN ĐƠN MƯỢN
	<form method="post">
		<!-- thời gian mượn -->
		<div class="form-group">
			<label >Thời gian mượn:</label>
			<input type="time" class=""  name="time" required>
		</div>
		<!-- ngày mượn -->
		<div class = "form-group">
			<label >Ngày mượn:</label>
			<input type="date" class=""  name="date" required >   
		</div>	
		<!-- lớp hp -->
		<div class = "form-group">
			<label >Tên lớp học phần:</label>
			<input type="text" class=""  name="class" required >   
		</div>	
		<div class="row">
			<div class="col-md-7">
				<table class="table table-bordered">
					<thead>
						<tr>
						<th>STT</th>
						<th>Hình ảnh</th>
						<th>Tên</th>
						<th>Số lượng</th>
						</tr>
					</thead>
					<tbody>
<?php
	$cart = [];
	if(isset($_SESSION['cart'])) {
		$cart = $_SESSION['cart'];
	}
	$count = 0;
	$total = 0;
	foreach ($cart as $item) {
		$total += $item['num'];
		if ($item['id'] != 12) {
			echo '
				<tr>
					<td>'.(++$count).'</td>
					<td><img src="'.$item['thumbnail'].'" style="width: 100px"></td>
					<td>'.$item['title'].'</td>
					<td>'.$item['num'].'></td>
				</tr>';
		}
	}
?>
					</tbody>
				</table>
				<button class="" >Complete</button>
			</div>
		</div>
	</form>
</div>
<?php
// lấy ra các thông tin về đơn mượn và up lên dtb
if(!empty($_POST)) {
	$date = getPost('date');
	$time = getPost('time');
	$class =getPost('class');
	$order_date = date('Y-m-d H:i:s');
	$fullname = $user['f_name'];
	$email = $user['email'];
	$student_ID = $user['student_ID'];
	$id = $user['id'];
	$cart = [];
	if(isset($_SESSION['cart'])) {
		$cart = $_SESSION['cart'];
	}
	if($cart == null || count($cart) == 0) {
		header('Location: index.php');
		die();
	}
	$sql = "insert into requests (full_name, email, student_ID, borrow_date, borrow_time, order_date, user_id, status, class) values ('$fullname', '$email','$student_ID','$date', '$time', '$order_date','$id', 1, '$class')";
	execute($sql);
	$sql = "select * from requests where order_date = '$order_date'";
	$order = executeResult($sql, true);
	$orderId = $order['id'];
	foreach ($cart as $item) {
		if ($item['id'] != 12) {
			$product_id = $item['id'];
			$num = $item['num'];
			$sql = "insert into requestdetails(order_id, product_id, num) values ($orderId, $product_id, $num)";
			execute($sql);
		}
	}
	unset($_SESSION['cart']);
	header('Location: complete.php');
	die();
}
include_once('layouts/footer.php');
?>
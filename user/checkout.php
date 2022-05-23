<?php 
$title = 'Trang yêu cầu';
include('layouts/layout.php');
include_once('layouts/header.php');
?>
<div class="panel-body">
	<form method="post">
		<div class="form-group">
			<label >Thời gian mượn:</label>
			<input type="time" class=""  name="time" required>
		</div>

		<!-- mật khẩu -->
		<div class = "form-group">
			<label >Ngày mượn:</label>
			<input type="date" class=""  name="date" required >   
		</div>	
<!-- body START -->
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
// var_dump($cart);die();
$count = 0;
$total = 0;
foreach ($cart as $item) {
	$total += $item['num'];
	echo '
		<tr>
			<td>'.(++$count).'</td>
			<td><img src="'.$item['thumbnail'].'" style="width: 100px"></td>
			<td>'.$item['title'].'</td>
			<td>'.$item['num'].'></td>
		</tr>';
}


?>
			</tbody>
		</table>
		
		<button class="" >Complete</button>
	</div>
</div>
</form>
</div>
<!-- body END -->
<?php
if(!empty($_POST)) {
	$date = getPost('date');
	$time = getPost('time');
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
		header('Location: products.php');
		die();
	}

	$sql = "insert into orders (full_name, email, student_ID, borrow_date, borrow_time, order_date, user_id, status) values ('$fullname', '$email','$student_ID','$date', '$time', '$order_date','$id', 1)";
	execute($sql);

	$sql = "select * from orders where order_date = '$order_date'";
	$order = executeResult($sql, true);

	$orderId = $order['id'];

	foreach ($cart as $item) {
		$product_id = $item['id'];
		$num = $item['num'];
		$sql = "insert into order_details(order_id, product_id, num) values ($orderId, $product_id, $num)";
		execute($sql);
	}

	unset($_SESSION['cart']);

	header('Location: complete.php');
	die();
}
include_once('layouts/footer.php');
?>
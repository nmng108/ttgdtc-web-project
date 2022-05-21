<?php

if(!empty($_POST)) {
	$date = getPost('date');
	$time = getPost('time');
	$class = getPost('class');
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
		$product_id = $item['id'];
		$num = $item['num'];
		$sql = "insert into requestdetails(order_id, product_id, num) values ($orderId, $product_id, $num)";
		execute($sql);
	}

	unset($_SESSION['cart']);

	header('Location: complete.php');
	die();
}
?>
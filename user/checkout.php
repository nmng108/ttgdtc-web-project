<?php 
$title = 'Trang yêu cầu';
include_once('layouts/header.php');
require_once('api/form-checkout.php');

?>
<div class="panel-body">
	<form method="post">
		<div class="form-group">
			<label >Thời gian mượn:</label>
			<input type="time" class=""  name="time" required>
		</div>
		<div class = "form-group">
			<label >Ngày mượn:</label>
			<input type="date" class=""  name="date" required >   
		</div>	
		<div class = "form-group">
		<label for="address">Address <font color="red">*</font>:</label>
		  <input required="true" type="text" class="form-control" id="address" name="class">
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

include_once('layouts/footer.php');
?>
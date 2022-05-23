
<?php 
$title = 'Giỏ đồ';
include('layouts/layout.php');
include_once('layouts/header.php');
?>
<!-- body START -->
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover" style="width: 800px; margin-left:90px;">
			<thead class="table-success">
				<tr>
					<th>STT</th>
					<th>Hình ảnh</th>
					<th>Tên dụng cụ</th>
					<th>Số lượng</th>
					<th></th>
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
	echo '
		<tr>
			<td>'.(++$count).'</td>
			<td><img src="'.$item['thumbnail'].'" style="width: 100px"></td>
			<td>'.$item['title'].'</td>
            <td>'.$item['num'].'</td>
			<td><button class="" onclick="deleteItem('.$item['id'].')">Delete</button></td>
		</tr>';

	
}
?>
			</tbody>
		</table>
		<p style="font-size: 26px; color: red">
		</p>
		<a href="checkout.php">
			<button class="" >Tiếp tục</button>
		</a>
	</div>
</div>
<!-- body END -->
<script type="text/javascript">
	function deleteItem(id) {
		$.post('api/api-product.php', {
			'action': 'delete',
			'id': id
		}, function(data) {
			location.reload()
		})
	}
</script>
<?php
require_once('layouts/footer.php');
?>

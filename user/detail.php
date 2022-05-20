<?php 
$title = 'Chi tiết dụng cụ';
include_once('layouts/header.php');
//lấy id của sản phẩm
$id = getGet('id');
// truy vấn trong database
$sql = "select * from products where id = $id";
$product = executeResult($sql, true);
?>
<!-- body START -->
<div class="row">
	<div class="col" style="border: solid 1px rgb(213, 235, 217); width:400px">
		<img src="<?=$product['thumbnail']?>" style="width: 60%; ">
		<p style="font-size: 26px;">Số lượng trong kho: <?=$product['quantityInStock']?></p>

	</div>
	
	<div class="col" >
	<h2  style="text-align: left;"><?=$product['title']?></h2>

		<button class="" onclick="addToCart(<?=$id?>, $('[name = num').val())" style="width: 50%; font-size: 26px;">Thêm vào giỏ</button>
		<a href="cart.php">
			<button type="button" class="" style="width: 50%; font-size: 26px; margin-top: 10px;">Xem giỏ hàng</button>
		</a>
		<div style="text-align: left;">
			Số lượng
			<input type = "number" value = "1" style="width:60px;" name = "num" class="form-control" step ="1" onchange="fixCartNum()" required> 
		</div>
	</div>
	
</div>

<!-- body END -->
<script type="text/javascript">
	function fixCartNum() {
		$('[name = num').val(Math.abs($('[name = num').val()));
	}
	function addToCart(id,num) {
		$.post('api/api-product.php', {
			'action': 'add',
			'id': id,
			'num': num
		}, function(data) {
			location.reload()
		})
	}
</script>
<?php
include_once('layouts/footer.php');
?>
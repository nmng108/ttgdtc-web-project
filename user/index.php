<?php
$title = 'Trang mượn đồ';
include_once('layouts/header.php');
$productList = executeResult('select * from products');
?>
<!-- body START -->
<div class="row" style="background-color: rgb(142, 186, 139);">
<?php
foreach ($productList as $item) {
	if ($item['id']!= 12) {
	echo '<div class="col-4" style="text-decoration: none;">
			<a href="detail.php?id='.$item['id'].'" style="text-decoration: none;"><img src="'.$item['thumbnail'].'" style="width: 50%"></a>
			<a href="detail.php?id='.$item['id'].'" style="text-decoration: none;"><p style="font-size: 26px;">'.$item['title'].'</p></a>
			<a href="detail.php?id='.$item['id'].'" style="text-decoration: none;"><p style="font-size: 26px;"> Số lượng:'.$item['quantityInStock'].'</p></a>
		</div>';
	}
}
?>
</div>
<!-- body END -->
<?php
include_once('layouts/footer.php');
?>
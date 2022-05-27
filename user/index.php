<?php

$title = 'Trang mượn đồ';
include_once('layouts/header.php');
$productList = executeResult('select * from products');
?>
<!-- body START -->
<div class="row" style="background-color: rgb(142, 186, 139);">
<?php
foreach ($productList as $item) {
	echo '<div class="col-1">
			<a href="detail.php?id='.$item['id'].'"><img src="'.$item['thumbnail'].'" style="width: 50%"></a>
			<a href="detail.php?id='.$item['id'].'"><p style="font-size: 26px;">'.$item['title'].'</p></a>
			<a href="detail.php?id='.$item['id'].'"><p style="font-size: 26px;"> Số lượng:'.$item['quantityInStock'].'</p></a>

		</div>';
}
?>
</div>
<!-- body END -->
<?php
include_once('layouts/footer.php');
?>
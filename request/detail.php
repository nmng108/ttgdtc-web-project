<?php
$title = 'Quản Lý Yêu Cầu';
$root_dir = '..';

include_once("$root_dir/includes/user_layouts/header.php");

if (!isset($_GET['id'])) {
    header("Location: $root_dir/");
}

$query = 
    "SELECT rd.requestNumber, rd.itemCode, p.primaryImage, p.itemName, rd.quantity, rs.statusName, 
            r.classCode, r.studentID, CONCAT(s.firstName, ' ', s.lastName) AS studentName
    FROM RequestDetails rd
    JOIN Requests r ON r.requestNumber = rd.requestNumber 
    LEFT JOIN Products p ON rd.itemCode = p.itemCode
    LEFT JOIN RequestStatus rs ON rs.statusID = r.statusID
    LEFT JOIN Students s ON r.studentID = s.studentID
    WHERE r.requestNumber = ".$_GET['id'];
$result = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

if (count($result) == 0) {
    ?>
    Không có dụng cụ được yêu cầu
    <br>
    <a href="./" class="btn btn-primary">Trở về</a>
    <?php
    exit();
}
?>

<div id="category_<?=SPORT_EQUIPMENT?>" class="container">
	<div class="card">
		<div class="card-header">
			<b style="font-size: 18px">Yêu cầu mượn [<?=$_GET['id'] . "] của " . $result[0]['studentName'] . " - " . $result[0]['studentID']?></b>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="container table-responsive-lg" style="width: 75vw;">
					<table class="table table-hover" style="width: 95%; text-align: center;">
						<thead class="table-info">
							<tr>
								<th class="col-sm-1 sequence-number">STT</th>
								<th class="col-sm-2 item-name">Tên dụng cụ</th>
								<th class="col-sm-2 item-image">Hình ảnh</th>
								<th class="col-sm-2 item-quantity" style="width:15%;">Số lượng</th>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($result); $i++) { 
								$item = $result[$i];
								?>
								<tr class="" id="item_row_<?=$item['itemCode']?>">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-name"><?=$item['itemName']?></td>
									
									<td class="item-image"><img src="<?=get_uploaded_image_link($item['primaryImage'])?>" style="width: 100%"></td>

									<td class="item-quantity">
										<input type="number" name="quantity" id="quantity_input_<?=$item['itemCode']?>" value="<?=$item['quantity']?>" style="height: 35px;" disabled>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
					<p id="notif_<?=SPORT_EQUIPMENT?>" style="font-size: 26px; color: red">
					
					</p>
				</div>
			</div>

		</div>
        <div class="card-footer">
            <a href="./" class="btn btn-primary">Trở về</a>
        </div>
	</div>
</div>
<?php
include_once("$root_dir/includes/user_layouts/footer.php");
?>

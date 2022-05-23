<?php
$title = 'Thêm/Sửa Tài Khoản Người Dùng';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");

// Handle form inputs sent from this file.
if(!empty($_POST)){
    $query = 
		"UPDATE requests 
		SET statusID = '" . $_POST['status'] . "', 
			note = '".$_POST['note']."' 
		WHERE requestNumber = '".$_POST['request_number']."'";
	$request = run_mysql_query($query);
	if ($request === true) {
		header('Location: ./');
	} else {
		die("Cannot update the request");
	}
}
?>
<br>
<br>

<?php
if (isset($_GET['request'])) {
	$requestNumber = $_GET["request"];
} else {
	exit("REQUEST NUMBER IS NULL");
}


if($requestNumber != '') {
	$query = "SELECT * FROM Requests r JOIN RequestStatus rs ON r.statusID = rs.statusID 
			WHERE requestNumber = $requestNumber";
	$request = run_mysql_query($query)->fetch_all(MYSQLI_ASSOC);

	if(count($request) == 1) {
		$request = $request[0];
	} else {
		?>
		<script>
			console.log("NULL RESULT");
		</script>
		<?php
	}
}

// Get all status to create status options.
$sql = "SELECT * FROM RequestStatus ORDER BY statusID";
$all_status = run_mysql_query($sql)->fetch_all(MYSQLI_ASSOC);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Trạng thái yêu cầu</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">
			</div>
			<div class="panel-body">
				<form method="post">
                    <div class="form-group">
						<label for="usr">Trạng thái:</label>
						<select class="form-control" name="status" id="status" value="<?=$request['statusName']?>" required>
							<?php
							foreach($all_status as $status) {
								?>
								<option id="status_option_<?=$status['statusName']?>" value="<?=$status['statusID']?>">
									<?=$status['statusName']?>
								</option>
								<?php
							}
							?>
							<script>
								$("#status_option_<?=$request['statusName']?>").attr('selected', true);
							</script>
						</select>
					</div>
                    <div class="form-group">
						<label for="usr">Ghi chú:</label>
						<input type="text" class="form-control" name="note" value="<?=$request['note']?>" required>
						<input type="text" name="request_number" value="<?=$request['requestNumber']?>" hidden>
					</div>
					<button class="btn btn-success">Xác nhận</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
require_once('../layouts/footer.php');
?>
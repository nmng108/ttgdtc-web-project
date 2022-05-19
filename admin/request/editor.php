<?php
	$title = 'Thêm/Sửa Tài Khoản Người Dùng';
	$baseUrl = '../';
	require_once('../layouts/header.php');
	$status = $note = '';
	$id = getGet('id');
	if($id != '' && $id > 0) {
		$sql = "select * from requests where id = '$id'";
		$userItem = executeResult($sql, true);
		if($userItem != null) {
			$status = $userItem['status'];
			$note = $userItem['Note'];
		} else {
			$id = 0;
		}
	} else {
		$id = 0;
	}
    $sql = "select * from status";
	$statusItems = executeResult($sql);
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
					  <select class="form-control" name="status_id" id="status_id" required="true">
					  	<option value="">-- Chọn --</option>
					  	<?php
					  		foreach($statusItems as $status) {
					  			echo '<option value="'.$status['status_id'].'">'.$status['status_name'].'</option>';
					  		}
					  	?>
					  </select>
					</div>
                    <div class="form-group">
					  <label for="usr">Ghi chú:</label>
					  <input required="true" type="text" class="form-control" id="usr" name="note" value="<?=$note?>">
					  <input type="text" name="id" value="<?=$id?>" hidden="true">
					</div>
					<button class="btn btn-success">Cofirm</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
if(!empty($_POST) ){
    $status2 = getPost('status_id');
    $note2 = getPost('note');
    $sql2 = "update requests set status = '$status2', Note = '$note2' where id = $id";
    execute($sql2);
    header('Location: index.php');
    die();
}
require_once('../layouts/footer.php');
?>
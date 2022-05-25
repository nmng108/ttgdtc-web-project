<?php
$title = 'Quản Lý Yêu Cầu';
$root_dir = '../..';

include_once("$root_dir/admin/layouts/header.php");

if (!isset($_GET['id'])) {
    header("Location: $root_dir/admin/request");
}

$query = 
    "SELECT rd.requestNumber, rd.itemCode, p.primaryImage, p.itemName, rd.quantity, rs.statusName, 
            r.classCode, r.studentID, CONCAT(s.firstName, ' ', s.lastName) AS studentName, availableQuantity
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
								<th class="col-sm-2 available-quantity">Kho</th>
                                <th class="col-sm-2 delete-button"></th>
                                <th class="col-sm-2 edit-button"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($result); $i++) { 
								$item = $result[$i];
								$class_value = "";
								if ($item['statusName'] == 'SENT' && $item['quantity'] > $item['availableQuantity']) {
									$class_value = "table-danger";
								}
								?>
								<tr class="<?=$class_value?>" id="item_row_<?=$item['itemCode']?>">
									<td class="sequence-number"><?=$i + 1?></td>
									
									<td class="item-name"><?=$item['itemName']?></td>
									
									<td class="item-image"><img src="<?=get_uploaded_image_link($item['primaryImage'])?>" style="width: 100%"></td>

									<td class="item-quantity">
										<input type="number" name="quantity" id="quantity_input_<?=$item['itemCode']?>" value="<?=$item['quantity']?>" style="height: 35px;" disabled>
									</td>

                                    <td class="available-quantity"><?=$item['availableQuantity']?></td>
                                    
									<?php
                                    if ($item['statusName'] == 'SENT') {
                                        ?>
                                        <td class="delete-button">
                                            <button class="btn btn-danger" id="delete_button_<?=$item['itemCode']?>" onclick="delete_item(this)" hidden>Xóa</button>
                                        </td>
                                        
                                        <td class="edit-button">
                                            <button class="btn btn-warning" id="edit_button_<?=$item['itemCode']?>" onclick="edit_mode(this)">Sửa</button>
                                        </td>
                                        <?php
                                    }
                                    ?>
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
include_once("$root_dir/admin/layouts/footer.php");

if ($result[0]['statusName'] != 'SENT') {
    ?>
    <script>
        $(".available-quantity").each(function(){
            $(this).remove();
        })

        $(".delete-button").each(function(){
            $(this).remove();
        })
        $(".edit-button").each(function(){
            $(this).remove();
        })
    </script>
    <?php
}
?>
<script>
// similar code to the cart features due to using the common id name set.
var request_number = <?=$_GET['id']?>;

function edit_mode(button_element) {
    if (request_number == null) return;

    let split_id =  button_element.id.split('_');
    const ITEM_CODE = split_id[2];
    const DELETE_BUTTON = document.getElementById('delete_button_' + ITEM_CODE);
    const QUANTITY_INPUT = document.getElementById('quantity_input_' + ITEM_CODE);
    
    var quantity_validation = function() {
        if (QUANTITY_INPUT.value === "0")  {
            $("#quantity_warning_" + ITEM_CODE).html("Số lượng tối thiểu là 1");
            button_element.disabled = true;
        } else if (QUANTITY_INPUT.value == "") {
            button_element.disabled = true;
        } else {
            $.ajax({
                type : "POST",
                url  : "validate_quantity.php", 
                data : { item_code : ITEM_CODE },
                success: function(res){ 
                    if (+res < +QUANTITY_INPUT.value) {
                        $("#quantity_warning_" + ITEM_CODE).html("Số lượng lớn hơn hiện có");
                        button_element.disabled = true;
                    } else {
                        $("#quantity_warning_" + ITEM_CODE).html("");
                        button_element.disabled = false;
                    }
                }
            });
        }
    };
        
    if (split_id[0] == "edit"){
        button_element.innerHTML = 'Xong';
        button_element.id = "confirm_button_" + ITEM_CODE;
        
        DELETE_BUTTON.hidden = false;
        QUANTITY_INPUT.disabled = false;
        
        QUANTITY_INPUT.addEventListener("keyup", quantity_validation);

    } else if (split_id[0] == "confirm") {
        var new_quantity = QUANTITY_INPUT.value;

        if(new_quantity.trim() == "") {
            document.getElementById("quantity_warning_" + ITEM_CODE).innerHTML("Nhập trước khi xác nhận");
            return;
        }
    
        $.ajax({
            type : "POST",  // type of method
            url  : "adjust_quantity.php",  // your page
            data : { item_code : ITEM_CODE, request_number : request_number, new_quantity : new_quantity }, // passing the values
            success: function(res){ 
                console.log(res); 
                if (res == true) {
                    button_element.innerHTML = 'Sửa';
                    button_element.id = "edit_button_" + ITEM_CODE;
                    
                    DELETE_BUTTON.hidden = true;
                    QUANTITY_INPUT.disabled = true;
                    QUANTITY_INPUT.removeEventListener("keyup", quantity_validation);
                    $("#item_row_" + ITEM_CODE).removeClass("table-danger");
                } else {
                    button_element.disabled = true;
                }
            }
        });
    }
}

var delete_item = function(element) {
    const ITEM_CODE = element.id.split('_')[2];

    element.parentElement.parentElement.hidden = true;
    $.ajax({
        type : "POST",
        url  : "delete_item.php",
        data : { item_code : ITEM_CODE, request_number : <?=$_GET['id']?> },
        dataType : "json",
        success: function(response){ 
            console.log(response);
            if (response['hasSucceeded'] = true && response['itemCount'] == 0) {
                document.getElementById("category_" + "<?=SPORT_EQUIPMENT?>").remove();
            }
        }
    });
}

</script>
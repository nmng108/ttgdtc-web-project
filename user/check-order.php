<!-- header -->
<?php
$title = 'Kiểm tra đơn đặt đồng phục';
include_once('layouts/header.php');
?>

<?php 
    if(!empty($_POST)) {
        $sizeM = getPost('sizeM');
        $sizeL = getPost('sizeL');
        $sizeXL = getPost('sizeXL');
        $sizeXXL = getPost('sizeXXL');
        $sizeXXXL = getPost('sizeXXXL');
        $size0 = getPost('size0');
        $total = $sizeXXXL + $size0 +$sizeM + $sizeL +  $sizeXL + $sizeXXL;
        $bill = $total * 340000;
        $order_date = date('Y-m-d H:i:s');
        $fullname = $user['f_name'];
        $email = $user['email'];
        $user_id = $user['id'];
        $student_id = $user['student_ID'];
        if ($total != 0) {
        $sql = "insert into orderdetails (full_name, email, student_ID, status, quantum_M, quantum_L, quantum_XL, quantum_XXL, quantum_XXXL, quantum_oversize, order_date, amount, user_id) 
            values ('$fullname', '$email', '$student_id',1, '$sizeM', '$sizeL', '$sizeXL', '$sizeXXL', '$sizeXXXL', '$size0', '$order_date', '$bill','$user_id')";
        execute($sql);  
        } else { 
            echo '<script >
        $(function() {       
        alert("Email đã tồn tại trên hệ thống!!")      
        })	
    </script>';
            header('Location: order.php');
            die();
        }
    }   
?>

<!-- body -->
<h3 >Chi tiết đơn đặt đồng phục</h3>
<div class="row" style="margin-bottom:20px;">
    <table class= "table table-bordered table-hover" style="width: 200px;" >
        <tr class="table-success">
            <th>Size M</th>
            <th> Size L</th>
            <th>Size XL</th>
            <th>Size XXL</th>
            <th> Size XXXL</th>
            <th>Oversize</th>
            <th>Tổng số lượng</th>
            <th>Đơn giá</th>
        </tr>
        <body>
            <th><?=$sizeM?></th>
            <th><?=$sizeL?></th>
            <th><?=$sizeXL?></th>
            <th><?=$sizeXXL?></th>
            <th><?=$sizeXXXL?></th>
            <th><?=$size0?></th>
            <th><?=$total?></th>
            <th><?=$bill?> VND</th>
        </body>
    </table>
</div>
	<div class="infor" >
        <h3>Yêu cầu sẽ được xử lí trong 3-5 ngày tới</h3>
		<h4>Nếu có bất kì vấn đề gì vui lòng liên hệ:<br></h4>
		<ul style="margin-left: 10px;font-style: italic;">
			<li>Cô Hương(SĐT: 0911911199)</li>
			<li>Thầy Huyền(SĐT: 0984838166)</li>
			<li>Hoặc đến gặp trực tiếp giáo viên tại: Phòng 101 </li>
		</ul>
		<h4>Phòng nhận đồng phục: Phòng 104</h4>
		<h6 style="color: brown;font-style: italic;">*Địa chỉ: Nhà đa năng khu GDTC số 2 Phạm Văn Đồng</h6>
	</div>

<!-- footer -->
<?php
include_once('layouts/footer.php');
?>
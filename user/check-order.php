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
            header('Location: order.php');
            die();
        }
    }   
?>

<!-- body -->
<h3 >Chi tiết đơn đặt đồng phục</h3>
<div class="row" style="margin-bottom:200px;">
    <table class= "table table-bordered table-hover" >
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

<!-- footer -->
<?php
include_once('layouts/footer.php');
?>
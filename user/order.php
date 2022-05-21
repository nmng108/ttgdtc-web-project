<?php 
$title = 'Trang đặt đồng phục theo lớp';
include_once('layouts/header.php');
?> 
 <!-- THÔNG TIN ĐẶT ĐÔNG PHỤC -->
<form method="post" action = "check-order.php">
    <div class="row">
        <div class="col" style="border: solid 1px rgb(213, 235, 217); "> 
        <h2>ĐÔNG PHỤC THỂ CHẤT</h2>
            <img src="..\image\đồng phục vnu.jpeg" style="width: 50%; ">
            <p style="font-size: 26px;">Giá: 340.000 VND</p>
        </div>
        <div class="col" style="margin-top: 10px;">
        <h2>Số lượng</h2>
            <div> Size M:
                <input type="number" value="0" name = "sizeM" style="width:60px;" onchange="fixNum1()" required >
            </div>
            <div> Size L:
                <input type="number" value="0" name="sizeL" step="1" id="" style="width: 60px;" onchange="fixNum2()" required>
            </div>
            <div> Size XL:
                <input type="number" value="0" name="sizeXL" step="1" id="" style="width: 60px;" onchange="fixNum3()" required>
            </div>
            <div> Size XXL:
                <input type="number" value="0" name="sizeXXL" step="1" id="" style="width: 60px;" onchange="fixNum4()" required>
            </div>
            <div> Size XXXL:
                <input type="number" value="0" name="sizeXXXL" step="1" id="" style="width: 60px;" onchange="fixNum5()" required>
            </div>
            <div> Oversize:
                <input type="number" value="0" name="size0" step="1" id="" style="width: 60px;" onchange="fixNum()" required>
            </div>
        </div>
        <div class="col">
        <h3>Bảng size</h3>
            <table class="table table-bordered table-hover">
                <tr class="table-success">
                    <th>SIZE</th>
                    <th>CHIỀU CAO</th>
                </tr>
                <tbody>
                    <th>M</th>
                    <th>dưới 1.55m</th>
                </tbody>
                <tbody>
                    <th>L</th>
                    <th>1.55m - 1.62m</th>
                </tbody>
                <tbody>
                    <th>XL</th>
                    <th>1.63m - 1.69m</th>
                </tbody>
                <tbody>
                    <th>XXL</th>
                    <th>1.70m - 1.78m</th>
                </tbody>
                <tbody>
                    <th>XXXL</th>
                    <th>1.78m - 1.80m</th>
                </tbody>
                <tbody>
                    <th>Ngoại cỡ</th>
                    <th>trên 1.80m</th>
                </tbody>
            </table>
        </div>
    </div>
    
    <button>Xác nhận</button>

</form>
<script type="text/javascript">
    function fixNum1() {
		$('[name = sizeM').val(Math.abs($('[name = sizeM').val()));
	}
    function fixNum2() {
		$('[name = sizeL').val(Math.abs($('[name = sizeL').val()));
	}
    function fixNum3() {
		$('[name = sizeXL').val(Math.abs($('[name = sizeXL').val()));
	}
    function fixNum4() {
		$('[name = sizeXXL').val(Math.abs($('[name = sizeXXL').val()));
	}
    function fixNum5() {
		$('[name = sizeXXXL').val(Math.abs($('[name = sizeXXXL').val()));
	}
    function fixNum() {
		$('[name = size0').val(Math.abs($('[name = size0').val()));
	}
   
</script>

<?php
include('layouts/footer.php');
?>

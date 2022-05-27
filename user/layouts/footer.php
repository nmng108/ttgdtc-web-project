<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col-1">
                <img src ="../image/logovnu.png" width="250px">
            </div>
            <div class="footer-col-1">
                <h5>Follow us</h5>
                <ul class="">
                    <li><a href="https://www.facebook.com/VNU.DHQG">Fanpage ĐHQGHN</a> </li>
                    <li><a href="https://www.facebook.com/SupportGroupUET">Fanpage SGUET</a> </li>
                    <li><a href="http://ttgdtc.vnu.edu.vn/">Fanpage TTGDTC </a> </li>
                </ul>
            </div>
            <div class="footer-col-1">
                <h5>Connect with us</h5>
                 <div> 
                     <h6 class="text-uppercase">Address</h6>
                     <p> 144 Xuân Thuỷ, Cầu Giấy, Hà Nội </p>
                 </div>
                 <div> 
                   <h6 class="text-uppercase">Phone</h6>
                   <p> 0956234678 </p>
               </div>
               <div> 
                   <h6 class="text-uppercase">Email</h6>
                   <p> Ttgdtc@gmail.com</p>
               </div>
                   
            </div>
        </div>
    </div>
</div>
<?php
$cart = [];
if(isset($_SESSION['cart'])) {
	$cart = $_SESSION['cart'];
}
$count = 0;
foreach ($cart as $item) {
	$count += $item['num'];
}
?>
	<span class="cart_icon">
	<span class="cart_count"><?=$count?></span>
	<a href="cart.php"><img src="https://gokisoft.com/img/cart.png"></a>
</span>
</body>
</html>
   
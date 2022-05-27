<?php
$root_dir = ".";
$title = 'Trang chủ';

include_once('includes/user_layouts/header.php');
include_once("includes/utilities.php");
require_once("database/manager.php");

$_SESSION[USERID] = $user['studentID'];
$_SESSION[EMAIL] = $user['email'];
$_SESSION[NAME] = $user['username'];
$_SESSION[ROLE] = "STUDENT";


$product_list = get_products_by_category(SPORT_EQUIPMENT);
?>
<!-- body START -->
<!-- <div class="row" style="background-color: rgb(142, 186, 139);">

</div> -->
<!-- slide show -->
<div id="demo" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  <div style="text-align: center; margin-top:10px;">
  <div class="carousel-inner" >
    <div class="carousel-item active">
      <img src="assets\images\slide1.jpg" >
    </div>
    <div class="carousel-item" >
      <img src="assets\images\slide2.jpg" >
    </div>
    <div class="carousel-item">
      <img src="assets\images\slide3.jpg" >
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev"  >
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
</div>

<div class="album py-3 bg-light">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <b style="color: green;">DỤNG CỤ THỂ THAO</b>
            </div>
            <div class="card-body">
                <div style="display: flex; align-items:center; flex-wrap: wrap;">
                    <!--show all products from the database-->
                    <?php
                    foreach ($product_list as $item) {
                    ?>
                        <div class="col-sm-4 " style="width: 20rem;">
                            <div class="card mb-4 box-shadow" style="background-color:darkseagreen;">
                                <img class="card-img-top" src="<?=get_uploaded_image_link($item['primaryImage'])?>">
                                <div class="card-body" style="text-align: center;">
                                    <h5 class="card-title"> <?=$item['itemName']?> </h5>
                                    <div class="d-flex" style="text-align: center;">
                                        <!--  handle quantity input -->
                                        <div class="mr-sm-2 row" style="text-align: center;">
                                            <label for="quantity_input_<?=$item["itemCode"]?>">Số lượng: </label>
                                            <input type="number" class="ml-2 form-control col mb-2 mr-sm-2" name="quantity" id="quantity_input_<?=$item["itemCode"]?>" min="1" max="<?=$item['availableQuantity']?>" value="1" required/>
                                            <span id="quantity_<?=$item["itemCode"]?>" class="mb-2 mr-sm-2">(còn lại: <?=$item['availableQuantity']?>)</span>
                                        </div>
                                        <br>
                                        <div class="mb-2 mr-sm-2">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-<?php 
                                                        if ($item['availableQuantity'] > 0 && isset($_SESSION[USERID])) {
                                                        echo "primary";
                                                        } else {
                                                        echo "disabled";
                                                        }
                                                        ?> col"
                                                    id="add_button_<?=$item['itemCode']?>"
                                                    onclick="return process_form(<?=$item['itemCode']?>, '<?=SPORT_EQUIPMENT?>')">
                                                Thêm
                                            </button>
                                        </div>
                                    </div>
                                    <span id="notif_<?=$item['itemCode']?>" style="font-size: 12"></span>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <br>
        <hr>
        <br>
        
        <?php
        $product_list = get_products_by_category(UNIFORM);
        ?>
        <div class="card">
            <div class="card-header">
                <b style="color: green;">ĐỒNG PHỤC</b>
            </div>
            <div class="card-body">
            <div style="display: flex; align-items:center; flex-wrap: wrap;">
                    <!--show all products from the database-->
                    <?php
                    foreach ($product_list as $item) { // Bỏ group by, in mỗi item 1 lần để lấy số lượng/size
                    ?>
                        <div class="col-sm-4 " style="width: 20rem;">
                            <div class="card mb-4 box-shadow" style="background-color:darkseagreen;">
                                <img class="card-img-top" src="<?=get_uploaded_image_link($item['primaryImage'])?>">
                                
                                <div class="card-body">
                                    <h5 class="card-title"> <?=$item['itemName']?> </h5>
                                    <div class="d-flex" style="text-align: center;">
                                        <!--  handle quantity input -->
                                        <form method="post" class="form-inline" onsubmit="return false">
                                            <div class="form-group form-inline">
                                                <label for="quantity_input_<?=$item["itemCode"]?>">Số lượng: </label>
                                                <input class=" form-control" name="quantity" id="quantity_input_<?=$item["itemCode"]?>" type="number" min="1" max="<?=$item['availableQuantity']?>" value="1" required/>
                                                <span id="quantity_<?=$item["itemCode"]?>" style="margin-left:5px">(còn lại: <?=$item['availableQuantity']?>) </span>
                                            </div>
                                            <div class="form-group form-inline">
                                                <br>
                                                <label for="size">Kích cỡ: </label>
                                                <br>
                                                <select class=" form-control" name="size" id="item_size_<?=$item["itemCode"]?>" type="number" min="1" max="<?=$item['availableQuantity']?>" value="" required>
                                                    <option value="" selected disabled hidden>Chọn size</option>
                                                    <option value="XS">XS</option>
                                                    <option value="S">S</option>
                                                    <option value="M">M</option>
                                                    <option value="L">L</option>
                                                    <option value="XL">XL</option>
                                                </select>
                                            </div>
                                                <script>
                                                    document.getElementById("item_size_<?=$item["itemCode"]?>").addEventListener("change", function() {
                                                        let item_code = <?=$item["itemCode"]?>;
                                                        let size = document.getElementById("item_size_<?=$item["itemCode"]?>").value;

                                                        $.ajax({
                                                            type : "POST",  
                                                            url  : "database/get_quantity_by_size.php",  
                                                            data : { item_code : item_code, size : size }, // passing the values
                                                            success: function(res){ 
                                                                console.log("res");
                                                                $("#quantity_" + item_code).html("(còn lại: " + res + ")"); 
                                                            }
                                                        });
                                                    });
                                                    
                                                </script>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-<?php 
                                                        if ($item['availableQuantity'] > 0 && isset($_SESSION[USERID])) {
                                                        echo "primary";
                                                        } else {
                                                        echo "disabled";
                                                        }
                                                        ?> col"
                                                    id="add_button_<?=$item['itemCode']?>" style="margin-left:5%"
                                                    onclick="return process_form(<?=$item['itemCode']?>, '<?=UNIFORM?>')">
                                                Thêm
                                            </button>

                                        </form>
                                    </div>
                                    <span id="notif_<?=$item['itemCode']?>" style="font-size: 12"></span>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- body END -->

<?php
include_once('includes/user_layouts/footer.php');
include_once("includes/user_layouts/cart_icon_bubble.php");
?>

<script>
    function process_form(item_code, category) {
        let quantity = document.getElementById("quantity_input_" + item_code).value;

        if(quantity.trim() == "") {
            console.log("Insert before submission");
            return false;
        }

        if (category == '<?=UNIFORM?>') {
            let size = document.getElementById("item_size_" + item_code).value;
            if (size == "") {
                $("#notif_" + item_code).html("Chọn kích cỡ trước khi thêm");
                setTimeout(function() {
                        $("#notif_" + item_code).html("");
                }, 2000);
                
                return false;
            }   

            $.ajax({
                type : "POST",
                url  : "./cart/add_to_cart.php",
                data : { item_code : item_code, size : size, quantity : quantity, category : category },
                success: function(res) { 
                    console.log(res);
                    $("#notif_" + item_code).html(res);
                    
                    setTimeout(function() {
                        $("#notif_" + item_code).html("");
                    }, 2000);
                    document.querySelector(".cart_count").innerHTML = <?=++$count?>;
                }
            });
        } else if (category == '<?=SPORT_EQUIPMENT?>') {
            $.ajax({
                type : "POST",
                url  : "./cart/add_to_cart.php",
                data : { item_code : item_code, quantity : quantity, category : category },
                success: function(res) { 
                    console.log(res);
                    $("#notif_" + item_code).html(res);
                    
                    setTimeout(function() {
                        $("#notif_" + item_code).html("");
                    }, 2000);
                    document.querySelector(".cart_count").innerHTML = <?=++$count?>;
                }
            });
        }
        

        return true;
    }

</script>

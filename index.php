<?php
$root_dir = ".";
$title = 'Trang chủ';

include_once('includes/user_layouts/header.php');
include_once("includes/utilities.php");
require_once("database/manager.php");

session_start();
$_SESSION[USERID] = 20020001;
$_SESSION[EMAIL] = "qwe@gmail.com";
$_SESSION[NAME] = "rty";
$_SESSION[ROLE] = "STUDENT";

$product_list = get_data_from_all_columns("Products", "`category` = 'SPORT EQUIPMENT';");
?>
<!-- body START -->
<!-- <div class="row" style="background-color: rgb(142, 186, 139);">

</div> -->

<div class="album py-3 bg-light">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <b>Dụng cụ thể thao</b>
            </div>
            <div class="card-body">
                <div class="row justify-content-center align-self-center">
                    <!--show all products from the database-->
                    <?php
                    foreach ($product_list as $item) {
                    ?>
                        <div class="col-sm-4 " style="width: 20rem;">
                            <div class="card mb-4 box-shadow bg-info">
                                <img class="card-img-top" src="<?=$item['primaryImage']?>">
                                
                                <div class="card-body">
                                    <h5 class="card-title"> <?=$item['itemName']?> </h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!--  handle quantity input -->
                                        <form method="post" onsubmit="return false">
                                            <div class="btn-group row">
                                                <label for="quantity">Số lượng: </label>
                                                <input class="ml-2 form-control col" name="quantity" id="item_quantity_<?=$item["itemCode"]?>" type="number" min="1" max="<?=$item['availableQuantity']?>" value="1" required/>
                                                <span>(còn lại: <?=$item['availableQuantity']?>)</span>
                                                <button type="<?php 
                                                            if ($item['availableQuantity'] > 0 && isset($_SESSION[USERID])) {
                                                                echo "submit";
                                                            } else {
                                                                echo "button";
                                                            }
                                                            ?>"
                                                        class="btn btn-sm btn-outline-<?php 
                                                            if ($item['availableQuantity'] > 0 && isset($_SESSION[USERID])) {
                                                            echo "primary";
                                                            } else {
                                                            echo "disabled";
                                                            }
                                                            ?> col"
                                                        id="add_button_<?=$item['itemCode']?>"
                                                        onclick="process_form(<?=$item['itemCode']?>)">
                                                    Add to Cart
                                                </button>
                                            </div>
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

        <br>
        <hr>
        <br>
        
        <?php
        $product_list = get_data_from_all_columns("Products", "`category` = 'UNIFORM';");
        ?>
        <div class="card">
            <div class="card-header">
                <b>Đồng phục</b>
            </div>
            <div class="card-body">
                <div class="row justify-content-center align-self-center">
                    <!--show all products from the database-->
                    <?php
                    foreach ($product_list as $item) {
                    ?>
                        <div class="col-sm-4 " style="width: 20rem;">
                            <div class="card mb-4 box-shadow bg-info">
                                <img class="card-img-top" src="<?=$item['primaryImage']?>">
                                
                                <div class="card-body">
                                    <h5 class="card-title"> <?=$item['itemName']?> </h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!--  handle quantity input -->
                                        <form method="post" onsubmit="return false">
                                            <div class="btn-group row">
                                                <label for="quantity">Số lượng: </label>
                                                <input class="ml-2 form-control col" name="quantity" id="item_quantity_<?=$item["itemCode"]?>" type="number" min="1" max="<?=$item['availableQuantity']?>" value="1" required/>
                                                <span>(còn lại: <?=$item['availableQuantity']?>)</span>

                                                <button type="<?php 
                                                            if ($item['availableQuantity'] > 0 && isset($_SESSION[USERID])) {
                                                                echo "submit";
                                                            } else {
                                                                echo "button";
                                                            }
                                                            ?>"
                                                        class="btn btn-sm btn-outline-<?php 
                                                            if ($item['availableQuantity'] > 0 && isset($_SESSION[USERID])) {
                                                            echo "primary";
                                                            } else {
                                                            echo "disabled";
                                                            }
                                                            ?> col"
                                                        id="add_button_<?=$item['itemCode']?>"
                                                        onclick="process_form(<?=$item['itemCode']?>)">
                                                    Add to Cart
                                                </button>
                                            </div>
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
?>

<script>
    function process_form(item_code) {
        let quantity = document.getElementById("item_quantity_" + item_code).value;

        if(quantity.trim() == "") {
            console.log("Insert before submission");
            return false;
        }

        $.ajax({
            type : "POST",  // type of method
            url  : "./cart/add_to_cart.php",  // your page
            data : { item_code : item_code, quantity : quantity }, // passing the values
            success: function(res) { 
                $("#notif_" + item_code).html(res);
                
                setTimeout(function() {
                    $("#notif_" + item_code).html("");
                }, 2000);
            }
        });
        
        document.querySelector(".cart_count").innerHTML = <?=++$count?>;

        return true;
    }

</script>

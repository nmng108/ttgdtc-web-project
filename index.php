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

$product_list = run_mysql_query('SELECT * FROM Products;');
?>
<!-- body START -->
<div class="row" style="background-color: rgb(142, 186, 139);">

</div>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center align-self-center">
            <!--show all products from the database-->
            <?php
            foreach ($product_list as $item) {
            ?>

            <div class="col-md-4 " style="width: 20rem;">
                <div class="card mb-4 box-shadow bg-info">
                    <img class="card-img-top" src="<?=$item['primaryImage']?>">
                    
                    <div class="card-body">
                        <h5 class="card-title"> <?=$item['itemName']?> </h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <!--  handle quantity input -->
                            <form action="cart/add_to_cart.php" method="POST">
                                <div class="btn-group row">
                                    <input name="itemCode" value="<?=$item["itemCode"]?>" hidden>
                                    <label for="quantity">Số lượng: </label>
                                    <input class="ml-2 form-control col" name="quantity" type="number" min="1" max="<?=$item['availableQuantity']?>" value="1" required/>
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
                                                ?> col">
                                        Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                    <!--  display item status according to inventory -->
                    <?php 
                        // if($item['quantityInStock'] < 1) {
                        //     echo '<p class= "alert alert-warning text-center" > The item is Out of Stock </p>';
                        // } else {
                        // echo '<p class= "alert alert-success text-center" > The item is Available </p>';
                        // }
                    ?>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- body END -->
<script>
// validate the quantities typed above.
</script>
<?php
include_once('includes/user_layouts/footer.php');
?>
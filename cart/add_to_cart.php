<?php
session_start();

$root_dir = "..";
include_once("$root_dir/includes/utilities.php");
include_once("$root_dir/database/manager.php");
include_once("$root_dir/cart/manager.php");

if (isset($_POST['quantity']) && isset($_POST['itemCode']) && isset($_SESSION[USERID])) {
    
    $result = get_data_from_all_columns("Carts", "`itemCode` = ".$_POST['itemCode']." AND `userID` = ".$_SESSION[USERID]);

    if ($result->num_rows == 1 
            && increase_quantity($_SESSION[USERID], $_POST['itemCode'], $_POST['quantity'])) {
        ?>
        <script>console.log('add quantity successfully');</script>
        <?php
        header("Location: ./");
    } else if (add_item_to_cart($_SESSION[USERID], $_POST['itemCode'], $_POST['quantity']) == true) {
        ?>
        <script>console.log('add to cart successfully');</script>
        <?php
        header("Location: ./");
    } else { 
        ?>
        <script>console.log('add to cart failed');</script>
        <?php
        header('Location: ../');
    }
} else {
    header('Location: ../');
}
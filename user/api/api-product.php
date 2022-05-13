<?php
session_start();
require_once('../../database/dbhelper.php');
require_once('../../utils/utility.php');
$action = getPost('action');
switch ($action) {
	case 'add':
		addToCart();
		break;
	case 'delete':
		deleteItem($id);
		break;
}


function deleteItem() {
	$id = getPost('id');
	$cart = [];
	if(isset($_SESSION['cart'])) {
		$cart = $_SESSION['cart'];
	}
	for ($i=0; $i < count($cart); $i++) {
		if($cart[$i]['id'] == $id) {
			array_splice($cart, $i, 1);
			break;
		}
	}
	//update session
	$_SESSION['cart'] = $cart;
}

function addToCart() {
	$id = getPost('id');
	$num = getPost('num');
	
	$cart = [];
	if(isset($_SESSION['cart'])) {
		$cart = $_SESSION['cart'];
	}
	$isFind = false;

	for ($i=0; $i < count($cart); $i++) {
		if($cart[$i]['id'] == $id) {
			$cart[$i]['num']+= $num;
			$isFind = true;
			break;
		}

	}
	if(!$isFind) {
		$product = executeResult('select * from products where id = '.$id, true);
		$product['num'] =$num;
		$cart[] = $product;

	}
	//update session
	$_SESSION['cart'] = $cart;
}
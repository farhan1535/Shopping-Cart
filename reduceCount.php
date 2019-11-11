<?php
session_start();
$count=$_SESSION['itemCount'];
$id=$_POST['itemId'];
$check=$_POST['checkQty'];
$qty=$_POST['quantity'];
if($check == 1){
    unset($_SESSION['qty'][$id]);
}
else{
    $_SESSION['qty'][$id]=$qty;
}
$count--;
$_SESSION['itemCount']=$count;
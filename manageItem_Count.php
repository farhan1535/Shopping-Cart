<?php
session_start();
$count=$_SESSION['itemCount'];
$count++;
$_SESSION['itemCount']=$count;
$id=$_POST['itemId'];
$quantity=$_POST['qty'];
$_SESSION['ids'][$id]=$id;
$_SESSION['qty'][$id]=$quantity;
echo $count;
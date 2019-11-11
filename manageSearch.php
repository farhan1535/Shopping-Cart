<?php
session_start();
$quantities=$_SESSION['qty'];
$servername="localhost";
$username = "root";
$password= "coeus123";
$dbname = "phpPROJECT";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $search=$_POST['search'];
    $stmt =$conn->prepare("SELECT * FROM product where name  like '%".$search."%' or cost like '%".$search."%' or brand_name like '%".$search."%'");
    $stmt->execute();
    $result=$stmt->fetchAll();
    $message['result']=$result;
    $message['quantity']=$quantities;
    echo json_encode($message,true);
}catch (PDOException $e){
    echo $sql . "<br>" .$e->getMessage();
}
$conn = null;
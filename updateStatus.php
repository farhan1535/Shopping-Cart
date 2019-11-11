<?php
$orderId=$_GET['status'];
$servername = "localhost";
$username = "root";
$password = "coeus123";
$dbname = "phpPROJECT";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE order_table SET 
            status = 1
            WHERE id = ".$orderId;
    $conn->exec($sql);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
header("Location: admin.php");

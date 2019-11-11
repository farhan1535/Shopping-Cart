<?php
session_start();
$servername="localhost";
$username = "root";
$password= "coeus123";
$dbname = "phpPROJECT";
try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $firstName=$_POST["FirstName"];
    $lastName=$_POST["LastName"];
    $phoneNumber=$_POST["PhoneNumber"];
    $email=$_POST["Email"];
    $address=$_POST["Address"];
    $sql = "UPDATE user SET 
            first_name = '".$firstName."',
            last_name = '".$lastName."',
            phone_no = '".$phoneNumber."',
            email = '".$email."',
            address = '".$address."'
            WHERE email = '".$_SESSION["email"]."'";
        $conn->exec($sql);
    $_SESSION["first_name"]=$firstName;
    $_SESSION["last_name"]=$lastName;
    $_SESSION["phone_number"]=$phoneNumber;
    $_SESSION["email"]=$email;
    $_SESSION["address"]=$address;
}
catch (PDOException $e){
    echo $sql . "<br>" .$e->getMessage();
}
$conn = null;
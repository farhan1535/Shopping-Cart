<?php
$servername="localhost";
$username = "root";
$password= "coeus123";
$dbname = "phpPROJECT";
try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $email=$_POST["email"];
    $password=$_POST["password"];
    if ($email != "" and $password != "") {
        $sql = "INSERT INTO user (email,password,reg_date,role ) 
            VALUES('$email','$password',current_timestamp(),'user')";
        $conn->exec($sql);
        session_start();
        $_SESSION["email"]=$email;
        $_SESSION["isAlive"]="true";
        header("Location: DashBoard.php");
    }
}
catch (PDOException $e){
    echo $sql . "<br>" .$e->getMessage();
}
$conn = null;
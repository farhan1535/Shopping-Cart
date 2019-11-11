<?php
    session_start();
    $_SESSION['pageCount']=0;
    $servername="localhost";
    $username = "root";
    $password= "coeus123";
    $dbname = "phpPROJECT";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT count(*) as countrows, role FROM user where email = '" . $email . "' and password = '" . $password."'";
        $temp = $conn->query($sql)->fetch();
        if($temp['countrows']>0 and $temp['role'] == 'admin'){
            $_SESSION["email"]=$email;
            $_SESSION["isAlive"]="true";
            header("Location: admin.php");
        }else{
            if ($temp['countrows'] > 0 and $temp['role']=='user'){
                $_SESSION["email"]=$email;
                $_SESSION["isAlive"]="true";
                header("Location: DashBoard.php");
            }else{
                header("Location: login.php?error=1");
            }
        }
    }
    catch (PDOException $e){
        echo $sql . "<br>" .$e->getMessage();
    }
$conn = null;

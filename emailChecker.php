
<?php
$servername="localhost";
$username = "root";
$password= "coeus123";
$dbname = "phpPROJECT";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $email = $_POST['email'];
    $sql = "SELECT count(*) as countOfUser FROM user where email  like '" . $email . "%'";
    $temp = $conn->query($sql)->fetch();
    echo json_encode($temp['countOfUser'] == 0 ? 1 : 0);
    }
catch (PDOException $e){
    echo $sql . "<br>" .$e->getMessage();
}
$conn = null;

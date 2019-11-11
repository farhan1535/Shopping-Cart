<?php
session_start();
$_SESSION["itemCount"]=0;
if ($_SESSION["isAlive"] == NULL){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Categories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="catagory.css">
</head>
<body>
<div class="page-header">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h2 id="UserName">
                <?php
                echo  $_SESSION["email"];
                ?>
            </h2>
        </div>
        <div class="col-md-2 col-md-offset-2">
            <button class="btn btn-info" id="logOUt" onclick="location.href='manageLogout.php'"> Logout</button>
        </div>
    </div>
</div>
<div class="container">
    <?php
    $servername="localhost";
    $username = "root";
    $password= "coeus123";
    $dbname = "phpPROJECT";
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM category";
        $result=$conn->query($sql);
        echo '<div class=row">';
        $count=1;
        while ($category_rows = $result->fetch(PDO::FETCH_ASSOC)){
            echo '<div class="col-md-4">';
            $cover = "images/".$category_rows['category_image'];
            $id=$category_rows['id'];
            $name=$category_rows['name'];
            if($count<=3){
                echo "<h3>$name</h3>";
                echo "<img src='$cover' class='imgClass' id='$id'>";

            }else{
                echo "<h3>$name</h3>";
                echo "<img src='$cover' class='newRow' id='$id'>";
            }
            $count+=1;
            echo '</div>';
        }
        echo '</div>';
    }
    catch (PDOException $e){
        echo $sql . "<br>" .$e->getMessage();
    }
    $conn = null;
    ?>
</div>
<script>
    $('img').on('click',function () {
        var id=$(this).attr('id');
        window.location.replace("product.php?q="+id);
    });
</script>
</body>
</html>

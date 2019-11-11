<?php
session_start();
if ($_SESSION["isAlive"] == NULL){
    header("Location: login.php");
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Shopping Cart</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="showCart.css">
    </head>
<body>
    <div class="page-header">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h2 id="sessionEmail">
                    <?php
                    echo  $_SESSION["email"];
                    ?>
                </h2>
            </div>
            <div class="col-md-2 col-md-offset-2 ">
                <button class="btn btn-info" id="logOUt" onclick="location.href='manageLogout.php'">Logout</button>
            </div>
        </div>
    </div>
    <div class="container" id="parentDiv">
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Product Name</th>
                <th>Brand Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
<?php
try {
    $items = [];
    $items = $_SESSION['ids'];
    $qty=$_SESSION['qty'];
    if ($items != null) {
        $servername = "localhost";
        $username = "root";
        $password = "coeus123";
        $dbname = "phpPROJECT";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $product_id = $_GET["q"];
        $_SESSION['cat_id'] = $product_id;
        $stmt = $conn->prepare("SELECT * FROM product where id IN(" . implode(',', $items) . ")");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $product_rows) {
            $cover = "images/" . $product_rows['product_image'];
            $pro_id = $product_rows['id'];
            $pro_name = $product_rows['name'];
            $pro_cost = $product_rows['cost'];
            $pro_brand = $product_rows['brand_name'];
            if ($qty[$pro_id]!=0){
                echo "<tr>";
                echo "<td>$pro_id</td>";
                echo "<td>$pro_name</td>";
                echo "<td>$pro_brand</td>";
                echo "<td>$pro_cost</td>";
                echo "<td><img src='$cover' class='imgClass' id='$pro_id'></td>";
                echo "<td><button type='button' class='btn btn-danger'>Delete</button></td>";
                echo "<td>$qty[$pro_id]</td>";
                echo "</tr>";
            }
        }
    }
}
catch (PDOException $e){
    echo $sql . "<br>" .$e->getMessage();
}
$conn = null;
?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-info" id="shopNow" onclick="location.href='checkout.php'">CHECK OUT<img src="images/shopping-cart.png" id="cartLogo" ></button>
        </div>
    </div>
<script>
    $('.btn').on('click',function (){
        var currentRow=$(this).closest("tr");
        var item_id=currentRow.find("td:eq(0)").text();
        var count=currentRow.find("td:eq(6)").text();
        var check=0;
        if (count == 1){
            currentRow.remove();
            count--;
            check=1;
        }
         else {
             count--;
         }
        currentRow.find("td:eq(6)").html(count);
        $.ajax({
            url: "reduceCount.php",
            type:"post",
            data: {
                itemId:item_id,
                quantity:count,
                checkQty:check
            },
            success: function (response){
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus,errorThrown);
            }
        });
    });
</script>
</body>
</html>

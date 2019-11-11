<?php
session_start();
if ($_SESSION["isAlive"] == NULL){
    header("Location: login.php");
}
try {
    $items = [];
    $items = $_SESSION['ids'];
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
        $total_cost=0;
        $quantity_array=$_SESSION['qty'];
        foreach ($result as $product_rows) {
            $pro_cost = $product_rows['cost'];
            $quantity=$quantity_array[$product_rows['id']];
            $pro_cost=$pro_cost*$quantity;
            $total_cost=$total_cost+$pro_cost;
        }
        $email=$_SESSION['email'];
        $stmt1=$conn->query("SELECT id from user WHERE email='".$email."'");
        $personId=$stmt1->fetch();
        $id=$personId['id'];
        $stmt1=$conn->query("SELECT first_name,last_name from user WHERE email='".$email."'");
        $personName=$stmt1->fetch();
        $firstName=$personName['first_name'];
        $lastName=$personName['last_name'];
        $sql = "INSERT INTO order_table (person_id,status,total_cost,place_date )
            VALUES($id,0,$total_cost,current_timestamp())";
        $conn->exec($sql);
        $stmt2=$conn->query("SELECT id from order_table WHERE person_id=".$id." order by id desc");
        $orderId=$stmt2->fetch();
        $order_id=$orderId['id'];
        foreach ($result as $product_rows) {
            $pro_id = $product_rows['id'];
            $pro_cost = $product_rows['cost'];
            if($quantity_array[$pro_id]!= 0 or $quantity_array[$pro_id]!= null){
                $sql1="INSERT INTO order_detail(order_id,product_id,cost,quantity)
                   VALUES($order_id,$pro_id,$pro_cost,$quantity_array[$pro_id])";
                $conn->exec($sql1);
            }
        }
    }
}
catch (PDOException $e){
    echo $sql . "<br>" .$e->getMessage();
}
unset($_SESSION['qty']);
echo "
    <html>
        <head>
          <title>Checkout</title>
          <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
          <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css\">  
        </head>
        <body>
            <div class='page-header'>
                <div class='row'>
                    <div class='col-md-4 col-md-offset-5'>
                        <h2>Order detail</h2>
                    </div> 
                </div>
            </div>
            <div class='container'>
                <div class='row'>
                    <div class='col-md-2'>
                        <h4><b>Order No. </b>$order_id</h4>    
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        <h4><b>Customer name. </b>$firstName $lastName</h4>    
                    </div>
                </div>
            </div>
            <div class='container'>
                <table class='table table-hover'>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                    ";
                        $stmt = $conn->prepare("SELECT product_id,cost,quantity FROM order_detail INNER JOIN order_table ON order_table.id=order_detail.order_id where order_detail.order_id=".$order_id);
                        $stmt->execute();
                        $result1 = $stmt->fetchAll();
                        foreach ($result1 as $product_rows) {
                            echo "<tr>";
                            $pro_id = $product_rows['product_id'];
                            $stmt1=$conn->query("SELECT name from product WHERE id='".$pro_id."'");
                            $productName=$stmt1->fetch();
                            $name=$productName['name'];
                            echo "<td>$name</td>";
                            $qty=$product_rows['quantity'];
                            $pro_cost = $product_rows['cost'];
                            echo "<td>$qty</td>";
                            echo "<td>$pro_cost</td>";
                            $total=$qty*$pro_cost;
                            echo "<td>$total</td>";
                            echo "</tr>";
                        }
                        echo "
                    </tbody>
                </table>
            </div>
            <div class='row'>
                <div class='col-md-4 col-md-offset-8'>
                    <h4><b>Grand Total:</b> $total_cost</h4>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2 col-md-offset-1'>
                    <button class='btn btn-info' onclick=\"location.href='DashBoard.php'\">Done Shoping</button>
                </div>
            </div>
        </body>
    </html>
";
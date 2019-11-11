<?php
session_start();
if ($_SESSION["isAlive"] == NULL){
    header("Location: login.php");
}
?>
<html>
<head>
    <title>admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="showDetails.css">
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
        <div class="col-md-2 col-md-offset-2">
            <button class="btn btn-info" id="logOUt" onclick="location.href='manageLogout.php'">Logout</button>
        </div>
    </div>
</div>
<?php
$orderId=$_GET['orderId'];
$servername = "localhost";
$username = "root";
$password = "coeus123";
$dbname = "phpPROJECT";
echo "<div class='row'>
        <div class='col-md-4 col-md-offset-1'>
            <h4 id='orderId'><b>order id:</b> $orderId</h4>  
        </div>
      </div>
";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("select date(order_table.place_date)as place_date,order_detail.product_id as product_id,user.first_name,user.last_name,user.phone_no,
                                                        order_detail.quantity as qty
                                                        from order_table
                                                        inner join user on order_table.person_id = user.id
                                                        inner join order_detail on order_table.id = order_detail.order_id 
                                                        where order_table.id=".$orderId);
    $stmt->execute();
    $result1 = $stmt->fetchAll();
    foreach ($result1 as $temp){
        $personFirstName=$temp['first_name'];
        $personLastName=$temp['last_name'];
        $phoneNumber=$temp['phone_no'];
        $date_=$temp['place_date'];
    }
    echo "<div class='row'>
        <div class='col-md-4 col-md-offset-1'>
            <h4><b>customer name:</b> $personFirstName $personLastName</h4>  
        </div>
      </div>
      <div class='row'>
        <div class='col-md-4 col-md-offset-1'>
            <h4><b>place date:</b> $date_</h4>
        </div>
      </div>
      <div class='row'>
        <div class='col-md-4 col-md-offset-1'>
            <h4><b>phone no:</b> $phoneNumber</h4>
        </div>
      </div>
      <div class='row'>
        <div class='col-md-4 col-md-offset-3'>
            <h4 id='items'><b>ordered items</h4>
        </div>
      </div>
      <div class='container'>
        <table class='table table-hover' id='tid'>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Cost</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>";
                    foreach ($result1 as $product_rows) {
                        echo "<tr>";
                        $pro_id = $product_rows['product_id'];
                        $stmt1=$conn->query("SELECT name,cost from product WHERE id='".$pro_id."'");
                        $temp=$stmt1->fetch();
                        $name=$temp['name'];
                        $cost=$temp['cost'];
                        echo "<td>$name</td>";
                        $qty=$product_rows['qty'];
                        echo "<td>$qty</td>";
                        echo "<td>$cost</td>";
                        $total=$qty*$cost;
                        echo "<td>$total</td>";
                        echo "</tr>";
                    }
echo "</tbody>
        </table>
      </div>      
      <div class='row'>
        <div class='col-md-2 col-md-offset-1'>
            <button class='btn btn-success' id='approved' onclick=\"location.href='updateStatus.php?status=$orderId'\"'>Approve</button>
        </div>
        <div class='col-md-2'>
            <button class='btn btn-danger' id='decline' onclick=\"location.href='admin.php'\">Decline</button>
        </div>
      </div>
      ";
    $stmt = $conn->prepare("SELECT * FROM order_detail where order_id = ".$orderId);
    $stmt->execute();
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>
</body>
</html>

<?php
session_start();
if ($_SESSION["isAlive"] == NULL){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dash Board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="dashBoard.css">
</head>
<body>
    <div class="page-header">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h2 id="userName">
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
        <div class="row">
            <div class="col-md-4">
                <div class="myTable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <?php
                            $servername="localhost";
                            $username = "root";
                            $password= "coeus123";
                            $dbname = "phpPROJECT";
                            try{
                                $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                $sql = "SELECT id FROM user WHERE email ='".$_SESSION["email"] . "'";
                                $temp = $conn->query($sql)->fetch();
                                $userId=$temp["id"];
                                $stmt =$conn->prepare( "SELECT order_table.id, order_table.status FROM order_table INNER JOIN user ON order_table.person_id=user.id where user.id=".$userId);
                                $stmt->execute();
                                $result=$stmt->fetchAll();
                                foreach ($result as $order_rows) {
                                    echo "<tr>";
                                    echo "<td>".$order_rows["id"]."</td>";
                                    if($order_rows["status"] == 0){
                                        echo "<td>Pending</td>";
                                    }
                                    else{
                                        echo "<td>Approved</td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                            catch (PDOException $e){
                                echo $sql . "<br>" .$e->getMessage();
                            }
                            $conn = null;
                        ?>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <h2>General Info</h2>
                <form action="">
                    <div class="form-group">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" value="<?php echo $_SESSION["first_name"] ?>" placeholder="First Name" name="first_name">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name:</label>
                        <input type="text" class="form-control" id="lastName" value="<?php echo $_SESSION["last_name"] ?>" placeholder="Last Name" name="last_name">
                    </div>
                    <div class="form-group">
                        <label for="Phone_no">Phone#:</label>
                        <input type="text" class="form-control" id="phoneNo" value="<?php echo $_SESSION["phone_number"] ?>" placeholder="Phone#" name="PhoneNumber">
                    </div>
                    <div class="form-group">
                        <label for="email_">Email:</label>
                        <input type="email" class="form-control" id="email_" value="<?php echo $_SESSION["email"] ?>" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="address_">Address:</label>
                        <input type="text" class="form-control" id="address_" value="<?php echo $_SESSION["address"] ?>" placeholder="Address" name="address">
                    </div>
                    <button  class="btn btn-info" onclick="updateData()">Update</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-success" id="shopNow" onclick="location.href='productCatagory.php'">Shop Now<img src="images/shopping-cart.png" id="cartLogo" ></button>
            </div>
        </div>
    </div>
    <script>
        function updateData() {
            var first_name=$('#firstName').val();
            var last_name=$('#lastName').val();
            var phone_no=$('#phoneNo').val();
            var address=$('#address_').val();
            var email_=$('#email_').val();
            $.ajax({
                url: "updateUser.php",
                type:"post",
                data: {
                    FirstName: first_name,
                    LastName: last_name,
                    PhoneNumber: phone_no,
                    Email: email_,
                    Address: address
                },
                success: function (response) {
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus,errorThrown);
                }
            });
        }
    </script>
</body>
</html>
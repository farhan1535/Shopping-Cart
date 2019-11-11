<?php
session_start();
if ($_SESSION["isAlive"] == NULL){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="product.css">
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
        <div class="col-md-2">
            <img src="images/shopping-cart.png" id="shopIcon">
            <span class="badge badge-notify" id="badge">
                <?php
                echo  $_SESSION["itemCount"];
                ?>
            </span>
        </div>
        <div class="col-md-2 ">
            <button class="btn btn-info" id="logOUt" onclick="location.href='manageLogout.php'">Logout</button>
        </div>
    </div>
</div>
<div class="container" id="parentDiv">
    <div class="row">
        <input class=" col-5 form-control" type="text" placeholder="Search" id="searchBar">
    </div>
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
            $servername="localhost";
            $username = "root";
            $password= "coeus123";
            $dbname = "phpPROJECT";
            try{
                $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $product_id=$_GET["q"];
                $_SESSION['cat_id']=$product_id;
                $stmt =$conn->prepare( "SELECT * FROM product where category_id = ".$product_id);
                $stmt->execute();
                $result=$stmt->fetchAll();
                $qty=$_SESSION['qty'];
                $totalCost=0;
                foreach ($result as $product_rows) {
                    $cover = "images/" . $product_rows['product_image'];
                    $pro_id = $product_rows['id'];
                    $pro_name = $product_rows['name'];
                    $pro_cost = $product_rows['cost'];
                    $pro_brand = $product_rows['brand_name'];
                    $prod_quantity  = empty($qty[$pro_id]) ? 0 : $qty[$pro_id];
                    echo "<tr>";
                    echo "<td>$pro_id</td>";
                    echo "<td>$pro_name</td>";
                    echo "<td>$pro_brand</td>";
                    echo "<td>$pro_cost</td>";
                    echo "<td><img src='$cover' class='imgClass' id='$pro_id'></td>";
                    echo "<td><button type='button' class='btn btn-success addButton'>Add to cart</button></td>";
                    echo "<td>" . $prod_quantity . "</td>";
                    echo "</tr>";
                    $total=$pro_cost*$prod_quantity;
                    $totalCost=$totalCost+$total;
                }
            }
            catch (PDOException $e){
                echo $sql . "<br>" .$e->getMessage();
            }
            $conn = null;
            ?>
        </tbody>
    </table>
        <?php
        echo '<div class="row">
                        <div class="col-md-4 col-md-offset-10">
                            <h4>Total Cost: '.$totalCost.'</h4>
                        </div>
                      </div>';
        ?>
</div>
<script>
    $('#searchBar').on('keyup', function () {
        var searchText = $('#searchBar').val();
        var totalCost=0;
        $.ajax({
            url: "manageSearch.php",
            type:"post",
            data: {
                search: searchText
            },
            success: function (response) {
                $('.table').remove();
                var table = document.createElement("table");
                table.setAttribute('class','table');
                table.setAttribute('id','tid');
                var head=document.createElement("thead");
                var row1=document.createElement("tr");
                var th1=document.createElement("th");
                th1.innerText="id";
                row1.appendChild(th1);
                var th2=document.createElement("th");
                th2.innerText="Product Name";
                row1.appendChild(th2);
                var th3=document.createElement("th");
                th3.innerText="Brand Name";
                row1.appendChild(th3);
                var th4=document.createElement("th");
                th4.innerText="Price";
                row1.appendChild(th4);
                var th5=document.createElement("th");
                th5.innerText="Image";
                row1.appendChild(th5);
                var th6=document.createElement("th");
                th6.innerText="Action";
                row1.appendChild(th6);
                var th7=document.createElement("th");
                th7.innerText="Qty";
                row1.appendChild(th7);
                head.appendChild(row1);
                table.appendChild(head);
                var parent = document.getElementById("parentDiv");
                parent.appendChild(table);
                var array1=JSON.parse(response);
                var tbody=document.createElement("tbody");
                var array=array1['result'];
                var qty=array1['quantity'];
                for (var i =0; i < array.length; i++) {
                    var row=document.createElement("tr");
                    var col1=document.createElement("td");
                    col1.innerText=array[i][0];
                    row.appendChild(col1);
                    var col2=document.createElement("td");
                    col2.innerText=array[i][1];
                    row.appendChild(col2);
                    var col3=document.createElement("td");
                    col3.innerText=array[i][4];
                    row.appendChild(col3);
                    var col4=document.createElement("td");
                    col4.innerText=array[i][2];
                    row.appendChild(col4);
                    var col5=document.createElement("td");
                    var cover="images/" + array[i][5];
                    var image=document.createElement("img");
                    image.setAttribute('src',cover);
                    image.setAttribute('class','imgClass');
                    col5.appendChild(image);
                    row.appendChild(col5);
                    var col6=document.createElement("td");
                    var button=document.createElement("button");
                    button.setAttribute('class','btn btn-success addButton');
                    button.innerHTML='Add to cart';
                    col6.appendChild(button);
                    row.appendChild(col6);
                    var value;
                    var col7=document.createElement("td");
                    if (qty[array[i][0]] == undefined){
                        col7.innerHTML=0;
                        value=col7.innerHTML;
                    }else {
                        col7.innerHTML=qty[array[i][0]];
                        value=qty[array[i][0]];
                    }
                    row.appendChild(col7);
                    var subTotal;
                    tbody.appendChild(row);
                    table.appendChild(tbody);
                    subTotal=array[i][2]*value;
                    totalCost=totalCost+subTotal;
                }
                parent.appendChild(table);
                $("h4").remove();
                var total_cost=document.createElement("h4");
                total_cost.setAttribute('class','col-md-2 col-md-offset-10');
                total_cost.innerText="Total cost: "+totalCost;
                parent.appendChild(total_cost);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus,errorThrown);
            }
        });
        });
    $('.addButton').on('click',function () {
        var currentRow=$(this).closest("tr");
        var item_id=currentRow.find("td:eq(0)").text();
        var count = currentRow.find("td:eq(6)").text();
        var cost = currentRow.find("td:eq(3)").text();
         var oldValue=$("h4").html();
        oldValue=oldValue.split(":");
         var sum=parseInt(oldValue[1])+parseInt(cost);
          $("h4").html(oldValue[0]+": "+sum);
        count++;
        currentRow.find("td:eq(6)").html(count);
        $.ajax({
            url: "manageItem_Count.php",
            type:"post",
            data: {
                itemId:item_id,
                qty:count
            },
            success: function (response) {
                $("#badge").text(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus,errorThrown);
            }
        });
        });
    $('#shopIcon').on('click',function (){
        location.href="showCart.php";
    });
</script>
</body>
</html>

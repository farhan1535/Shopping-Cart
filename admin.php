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
        <link rel="stylesheet" href="admin_.css">
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
        <div class="container">
            <h2 id="tableHeader">Placed orders</h2>
            <div id="parentDiv">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>order id</th>
                        <th>address</th>
                        <th>number of items</th>
                        <th>order detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "coeus123";
                    $dbname = "phpPROJECT";
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt=$conn->prepare("select order_table.*,user.address,user.email,count(order_detail.quantity) as total
                                                        from order_table
                                                        inner join user on order_table.person_id = user.id
                                                        inner join order_detail on order_table.id = order_detail.order_id 
                                                        where order_table.status=0 
                                                        group by order_detail.order_id limit 8");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        echo "<tr>";
                        foreach ($result as $order_rows) {
                            $orderId = $order_rows['id'];
                            echo "<td>$orderId</td>";
                            $personId = $order_rows['person_id'];
                            $address=$order_rows['address'];
                            echo "<td>$address</td>";
                            $totalQty=$order_rows['total'];
                            echo "<td>$totalQty</td>";
                            echo "<td><a href=\"#\" class=\"showDetail\">show detail</a></td>";
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo $sql . "<br>" . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-8">
                    <ul class="pager">
                        <li><a href="#" class="link pre">Previous</a></li>
                        <li><a href="#" class="link next">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    <script>
        $('.link').on('click',function (){
            var checkPage=$(this).text();
            $.ajax({
                url: "pagination.php",
                type:"post",
                data: {
                    pagination:checkPage
                },
                success: function (response) {
                    $('.table').remove();
                    var table = document.createElement("table");
                    table.setAttribute('class','table');
                    table.setAttribute('id','tid');
                    var head=document.createElement("thead");
                    var row1=document.createElement("tr");
                    var th1=document.createElement("th");
                    th1.innerText="order id";
                    row1.appendChild(th1);
                    var th2=document.createElement("th");
                    th2.innerText="address";
                    row1.appendChild(th2);
                    var th3=document.createElement("th");
                    th3.innerText="number of items";
                    row1.appendChild(th3);
                    var th4=document.createElement("th");
                    th4.innerText="order detail";
                    row1.appendChild(th4);
                    head.appendChild(row1);
                    table.appendChild(head);
                    var parent = document.getElementById("parentDiv");
                    parent.appendChild(table);
                    var array1=JSON.parse(response);
                    var tbody=document.createElement("tbody");
                    var order_ids=array1['orderIds'];
                    for (var i =0; i < order_ids.length; i++) {
                        var row=document.createElement("tr");
                        var col1=document.createElement("td");
                        col1.innerText=array1['orderIds'][i];
                        row.appendChild(col1);
                        var col2=document.createElement("td");
                        col2.innerText=array1['addresses'][i];
                        row.appendChild(col2);
                        var col3=document.createElement("td");
                        col3.innerText=array1['totalItems'][i];
                        row.appendChild(col3);
                        var col5=document.createElement("td");
                        var anchor=document.createElement("a");
                        anchor.innerText="show details";
                        anchor.setAttribute("class","showDetail");
                        anchor.setAttribute("href","showDetails.php?orderId="+col1.innerText);
                        col5.appendChild(anchor);
                        row.appendChild(col5);
                        tbody.appendChild(row);
                        table.appendChild(tbody);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus,errorThrown);
                }
            });
        });
        $('.showDetail').on('click',function () {
            var currentRow=$(this).closest("tr");
            location.href="showDetails.php?orderId="+currentRow.find("td:eq(0)").text();
        });
    </script>
    </body>
</html>

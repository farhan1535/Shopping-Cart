<?php
session_start();
$check=$_POST['pagination'];
$value=$_SESSION['pageCount'];
if($check == "Previous" and $value>0){
    $value=$value-1;
}
else{
    if($check == "Next"){
        $value=$value+1;
    }
}
$servername = "localhost";
$username = "root";
$password = "coeus123";
$dbname = "phpPROJECT";
try {
    $_SESSION['pageCount']=$value;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $value=$value*8;
    $stmt = $conn->prepare("select order_table.*,user.address,user.email,count(order_detail.quantity) as total
                                                        from order_table
                                                        inner join user on order_table.person_id = user.id
                                                        inner join order_detail on order_table.id = order_detail.order_id 
                                                        where order_table.status=0 
                                                        group by order_detail.order_id limit 8 offset ".$value);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $order_ids=[];
    $addresses=[];
    $totalItems=[];
    $i=0;
        foreach ($result as $order_rows) {
        $orderId = $order_rows['id'];
        $order_ids[$i]=$orderId;
        $personId = $order_rows['person_id'];
        $address=$order_rows['address'];
        $addresses[$i]=$address;
        $totalQty=$order_rows['total'];
        $totalItems[$i]=$totalQty;
        $i++;
    }
        $message['orderIds']=$order_ids;
        $message['addresses']=$addresses;
        $message['totalItems']=$totalItems;
        echo json_encode($message,true);
    } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
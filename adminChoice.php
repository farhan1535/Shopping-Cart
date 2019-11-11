<?php
session_start();
//if ($_SESSION["isAlive"] == NULL){
//    header("Location: login.php");
//}?>
<!DOCTYPE html>
<html>
    <head>
        <title>admin choice</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="admin_choice.css">
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
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <button class="btn btn-info" id="addItems"> add items</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <button class="btn btn-info" id="manageOrders">manage orders</button>
                </div>
            </div>
        </div>
    </body>
</html>
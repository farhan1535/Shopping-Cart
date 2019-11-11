<?php
session_start();
if ($_SESSION["isAlive"] == "true"){
    header("Location: DashBoard.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SignUp</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="signUp.css">
        <link rel="stylesheet" href="footer.css">
    </head>
    <body>
            <div class="page-header">
                <div class="row">
                    <div class="col-md-offset-4 col-md-6">
                        <h2 id="i"><b>SIGN UP FOR SHOPPING</b></h2>
                    </div>
                    <div class="col-md-2">
                        <img src="images/logo2.png">
                    </div>
                </div>
            </div>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <form action="signUp.php" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="eml">Email address:</label>
                                    <input type="email" class="form-control" name="email" id="email_" required>
                                </div>
                                <div class="col-md-2">
                                    <img src="images/cross.png" class="image" id="crossMark">
                                <img src="images/tick.png" class="image" id="tickMark">
                                </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="row">
                            <div class="col-md-8">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" name="password" id="pwd" required>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info">Register</button>
                            </div>
                            <div class="col-md-offset-2 col-md-4">
                                <a href="login.php">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script>
             $(document).ready(function () {
                 $('#tickMark').hide();
                 $('#crossMark').hide();
           });
        </script>
        <script>
            $('#email_').on('keyup', function () {
                var email_=$('#email_').val();
                $.ajax({
                    url: "emailChecker.php",
                    type:"post",
                    data: {
                        email: email_
                    },
                    success: function (response) {
                        if(response == 1){
                            $('#crossMark').hide();
                            $('#tickMark').show();
                        }else {
                            $('#tickMark').hide();
                            $('#crossMark').show();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus,errorThrown);
                    }
                });
            });
        </script>
    </body>
</html>


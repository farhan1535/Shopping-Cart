<?php
session_start();
if ($_SESSION["isAlive"] == "true"){
    header("Location: DashBoard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css" type="text/css">
    <link rel="stylesheet" href="footer.css" type="text/css">
</head>
<body class="bd">
<div class="container">
    <div class="row">
        <div class="col-sm-offset-4 col-md-offset-5 col-xs-offset-3 col-lg-offset-5 col-sm-4">
            <img src="images/coeusLogo.png" id="logo">
        </div>
    </div>
<div class="row">
    <div class="col-md-offset-4 col-sm-offset-3 col-xs-offset-0 col-sm-4">
        <div class="container" id="login">
            <?php if (isset($_GET['error'])) {?>
            <div class="alert-danger">Invalid Username or Password</div>
            <?php } ?>
            <form class="form-inline" action="testLogin.php" method="post">
                <div id="inputFields">
                    <div class="form-group required" id="eml">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="email" id="emailLabel">Email</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control form-rounded" id="email_" required="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group required" id="pwd">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-sm-8">
                            <input type="password" name="password" class="form-control form-rounded" id="password" required="true">
                            </div>
                        </div>
                        </div>
                </div>
                <div id="buttons">
                    <button type="submit" class="btn btn-info" id="loginBtn"">Login</button>
                    <button type="button" class="btn btn-success" id="signUpBtn" onclick="window.location.href='Register.php'">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php include 'footer.php' ?>
</body>
</html>

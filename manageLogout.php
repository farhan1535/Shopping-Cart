<?php
session_start();
unset($_SESSION['qty']);
unset($_SESSION['itemCount']);
unset($_SESSION['ids']);
unset($_SESSION['email']);
unset($_SESSION['pageCount']);
session_destroy();
header("Location: login.php");

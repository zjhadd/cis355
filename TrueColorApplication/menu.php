<!doctype HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
<?php
session_start(); //required for every php file
//if user id is not set then call login screen
if (empty($_SESSION['userid']))
{
    //echo 'User Not Set';
    login();
    exit();
}
else
{
	header("Location: home.php");
}

//enables user to log in
function login(){
	echo '<div class="container">';
    echo '<form action="login.php" method= "POST">';
    echo '<p>Username:';
    echo '<input type = "text" name = "username"><br>';
    echo '<p>Password:';
    echo '<input type = "password" name = "password"><br>';
    echo '<input type = "submit" value = "Submit">';
    echo '</form>';
    echo '<a href="createCustomer.php"><button>Create Account</button></a>';
	echo '</div>';
}
?>
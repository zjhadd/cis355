<!doctype HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$loginApproved = false;
include 'database.php';
//Find record w/ Email adress
   $pdo = Database::connect();
   $sql = 'SELECT * FROM customers WHERE username = "'.$username.'"';
   foreach ($pdo->query($sql) as $row) {
	   if(strcmp($row['password'], $password) == 0){
		   $loginApproved = true;
		   $_SESSION['userid'] = $row['customersID'];
		   $_SESSION['username'] = $username;
		   $_SESSION['firstname'] = $row['fName'];
		   $_SESSION['lastname'] = $row['lName'];
		   if($row['admin'] == 1)
			   $_SESSION['isAdmin'] = true;
		   }
		   else
		   {
			   $_SESSION['isAdmin'] = false;
		   }
   }
   Database::disconnect();
   if($_SESSION['isAdmin']){
	   header("Location: admin.php");
   }
   else{
		header("Location: home.php");
   }
?>

 
<?php  
	include 'usercontrol.php';
	require 'database.php';
	$id = 0;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	if ( !empty($_POST)) {
		$id = $_POST['id'];
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM customers  WHERE customersID = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		
		$id = $_POST['id'];
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM projects  WHERE cust_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		if ($_SESSION[isAdmin]){
				header("Location: admin.php");
			}
			else{
				header("Location: home.php");
			}
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    	<div class="span10 offset1">
    		<div class="row">
		   		<h3>Deleting a Customer Profile</h3>
		   	</div>
	    	<form class="form-horizontal" action="deleteCustomer.php" method="post">
				<input type="hidden" name="id" value="<?php echo $id;?>"/>
				<p class="alert alert-error">Are you sure to delete this customer profile? All customer information will be lost.</p>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger">Yes</button>
					<?php
						if ($_SESSION[isAdmin]){
							echo '<a class="btn" href="admin.php">No</a>';
						}
						else{
							echo '<a class="btn" href="home.php">No</a>';
						}
					?>
				</div>
			</form>
		</div>
    </div>
  </body>
</html>
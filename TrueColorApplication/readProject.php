<?php
	include 'usercontrol.php';
	require 'database.php';
	$id = null;
	if (!empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	if (null == $id) {
		header("Location: home.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM projects 
				LEFT JOIN customers ON projects.cust_id=customers.customersID
				LEFT JOIN paints ON projects.paint_id=paints.paintsID
				WHERE projectsID = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="span10 offset1">
				<div class="row">
					<h3>Project Information</h3>
				</div>
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Customer ID:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['fName']; ?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Paint ID:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['paintName']; ?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Date:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['date']; ?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Quantity:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['quantity']; ?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Items Painted:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['itemsPainted']; ?>
							</label>
						</div>
					</div>
					<div class="form-actions">
						<?php
							if ($_SESSION[isAdmin]){
								echo '<a class="btn" href="admin.php">Back</a>';
							}
							else{
								echo '<a class="btn" href="home.php">Back</a>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
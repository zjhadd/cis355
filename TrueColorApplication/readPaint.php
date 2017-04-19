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
		$sql = "SELECT * FROM paints where paintsID = ?";
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
					<h3>Paint Information</h3>
				</div>
				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Name:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['paintName']; ?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Size:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['paintSize']; ?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Finish:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['paintFinish']; ?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Code:</label>
						<div class="controls">
							<label class="checkbox">
								<?php echo $data['paintCode']; ?>
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
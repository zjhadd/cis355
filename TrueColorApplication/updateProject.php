<?php
	include 'usercontrol.php';
    require 'database.php';
    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    if (null == $id) {
        if ($_SESSION[isAdmin]){
			header("Location: admin.php");
		}
		else{
			header("Location: home.php");
		}
    }
    if (!empty($_POST)) {
         // keep track validation errors
		$cust_idError = null;
		$paint_idError = null;
		$dateError = null;
		$quantityError = null;
		$itemsPaintedError = null;
	
	
		// keep track post values
		$cust_id = $_POST['cust_id'];
		$paint_id = $_POST['paint_id'];
		$date = $_POST['date'];
		$quantity = $_POST['quantity'];
		$itemsPainted = $_POST['itemsPainted'];
		
		// validate input
		$valid = true;
		if (empty($cust_id)) {
			$cust_idError = 'Please enter valid customer ID';
			$valid = false;
		}
		if (empty($paint_id)) {
			$paint_idError = 'Please enter valid paint ID';
			$valid = false;
		}
		if (empty($date)) {
			$dateError = 'Please enter valid date';
			$valid = false;
		}
		if (empty($quantity)) {
			$quantityError = 'Please enter a quantity';
			$valid = false;
		}
		if (empty($itemsPainted)) {
			$itemsPaintedError = 'Please enter the item(s) painted';
			$valid = false;
		}
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE projects set cust_id=?, paint_id=?, date=?, quantity=?, itemsPainted=? WHERE projectsID=$id";
			$q = $pdo->prepare($sql);
			$q->execute(array($cust_id, $paint_id, $date, $quantity, $itemsPainted));
			Database::disconnect();
			if ($_SESSION[isAdmin]){
				header("Location: admin.php");
			}
			else{
				header("Location: home.php");
			}
		}
    } 
	else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM projects where projectsID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $cust_id = $data['cust_id'];
		$paint_id = $data['paint_id'];
		$date = $data['date'];
		$quantity = $data['quantity'];
		$itemsPainted = $data['itemsPainted'];
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
                    <h3>Update Project Information</h3>
                </div>
                <form class="form-horizontal" action="updateProject.php?id=<?php echo $id ?>" method="post">
                    <div class="control-group <?php echo !empty($cust_idError) ? 'error' : ''; ?>">
                        <label class="control-label">Customer Name:</label>
                        <div class="controls">
							<?php
							if ($_SESSION[isAdmin]){
								$pdo = Database::connect();
								$sql = 'SELECT * FROM customers ORDER BY customersID';
								echo "<select class='form-control' name='cust_id' id='customersID'>";
								foreach ($pdo->query($sql) as $row){
									if ($row['customersID'] == $cust_id){
										echo '<option value=' . $row['customersID'] . ' selected>' . $row['fName'] . " " . $row['lName'] . '</option>';
									}
									else{
										echo "<option value='" . $row['customersID'] . " '>" . $row['fName'] . " " . $row['lName'] . "</option>";
									}
								}
								echo "</select>";
								Database::disconnect();
							}
							else
							{
								$pdo = Database::connect();
								$sql = 'SELECT * FROM customers WHERE customersID = "'.$_SESSION['userid'].'" ORDER BY customersID';
								echo "<select class='form-control' name='cust_id' id='customersID'>";
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['customersID'] . " '>" . $row['fName'] . " " . $row['lName'] . "</option>";
								}
								echo "</select>";
								Database::disconnect();
							}
							?>
					    </div>	<!-- end controls -->
                    </div>
                    <div class="control-group <?php echo !empty($paint_idError) ? 'error' : ''; ?>">
                        <label class="control-label">Paint Name:</label>
                        <div class="controls">
							<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM paints ORDER BY paintName DESC';
							echo "<select class='form-control' name='paint_id' id='paintsID'>";
							foreach ($pdo->query($sql) as $row) {
								if ($row['paintsID'] == $paint_id){
									echo '<option value= ' . $row['paintsID'] . ' selected>' . $row['paintName'] . " - " . $row['paintFinish'] . " - " . $row['paintSize'] . '</option>';
								}else{
									echo "<option value='" . $row['paintsID'] . " '>" . $row['paintName'] . " - " . $row['paintFinish'] . " - " . $row['paintSize'] . "</option>";
								}
							}
							echo "</select>";
							Database::disconnect();
							?>
					    </div>	<!-- end controls -->
                    </div>
                    <div class="control-group <?php echo !empty($dateError) ? 'error' : ''; ?>">
                        <label class="control-label">Date:</label>
                        <div class="controls">
                            <input name="date" type="text" placeholder="0000-00-00"
                                   value="<?php echo !empty($date) ? $date : ''; ?>">
                            <?php if (!empty($dateError)): ?>
                                <span class="help-inline"><?php echo $dateError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($quantityError) ? 'error' : ''; ?>">
                        <label class="control-label">Quantity:</label>
                        <div class="controls">
                            <input name="quantity" type="text" placeholder="Quantity"
                                   value="<?php echo !empty($quantity) ? $quantity : ''; ?>">
                            <?php if (!empty($quantityError)): ?>
                                <span class="help-inline"><?php echo $quantityError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
					<div class="control-group <?php echo !empty($itemsPaintedError) ? 'error' : ''; ?>">
                        <label class="control-label">Items Painted:</label>
                        <div class="controls">
                            <input name="itemsPainted" type="text" placeholder="Describe what you painted."
                                   value="<?php echo !empty($itemsPainted) ? $itemsPainted : ''; ?>">
                            <?php if (!empty($itemsPaintedError)): ?>
                                <span class="help-inline"><?php echo $itemsPaintedError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Update</button>
                        <?php
							if ($_SESSION[isAdmin]){
								echo '<a class="btn" href="admin.php">Back</a>';
							}
							else{
								echo '<a class="btn" href="home.php">Back</a>';
							}
						?>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
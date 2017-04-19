<?php
	include 'ooPicture.php';
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
    $sql = "SELECT * FROM customers where customersID = ?";
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
	<table>
		<tbody>
		<td>
        <div class="row">
            <h3>Customer Information</h3>
        </div>

        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label">First Name:</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['fName']; ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Last Name:</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['lName']; ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone Number:</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['phone']; ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email Address:</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['email']; ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Password:</label>
                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['password']; ?>
                    </label>
                </div>
            </div>
			</td>
			<td>
			<div class="control-group">
					<label class="checkbox">
						<?php   
							Picture::getPicture();
						?>
					</label>
			</div>
			</td>
			</tbody>
			</table>
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
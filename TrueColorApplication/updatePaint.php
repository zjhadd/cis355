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
        $nameError = null;
        $sizeError = null;
        $finishError = null;
        $codeError = null;

        // keep track post values
        $name = $_POST['paintName'];
        $size = $_POST['paintSize'];
        $finish = $_POST['paintFinish'];
        $code = $_POST['paintCode'];

        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Paint Name';
            $valid = false;
        }
        if (empty($size)) {
            $sizeError = 'Please enter Size';
            $valid = false;
        }
        if (empty($finish)) {
            $finishError = 'Please enter the type of finish';
            $valid = false;
        }
        if (empty($code)) {
            $codeError = 'Please enter a Paint Code';
            $valid = false;
        }
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE paints set paintName=?, paintSize=?, paintFinish=?, paintCode=? WHERE paintsID=$id";
            $q = $pdo->prepare($sql);
            $q->execute(array($name, $size, $finish, $code));
            Database::disconnect();
            if ($_SESSION[isAdmin]){
				header("Location: admin.php");
			}
			else{
				header("Location: home.php");
			}
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM paints where paintsID = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['paintName'];
        $size = $data['paintSize'];
        $finish = $data['paintFinish'];
        $code = $data['paintCode'];
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
                    <h3>Update Customer Information</h3>
                </div>
                <form class="form-horizontal" action="updatePaint.php?id=<?php echo $id ?>" method="post">
                    <div class="control-group <?php echo !empty($nameError) ? 'error' : ''; ?>">
                        <label class="control-label">Paint Name:</label>
                        <div class="controls">
                            <input name="paintName" type="text" placeholder="Name"
                                   value="<?php echo !empty($name) ? $name : ''; ?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($sizeError) ? 'error' : ''; ?>">
                        <label class="control-label">Paint Size:</label>
                        <div class="controls">
                            <input name="paintSize" type="text" placeholder="Size"
                                   value="<?php echo !empty($size) ? $size : ''; ?>">
                            <?php if (!empty($sizeError)): ?>
                                <span class="help-inline"><?php echo $sizeError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($finishError) ? 'error' : ''; ?>">
                        <label class="control-label">Paint Finish:</label>
                        <div class="controls">
                            <input name="paintFinish" type="text" placeholder="Finish"
                                   value="<?php echo !empty($finish) ? $finish : ''; ?>">
                            <?php if (!empty($finishError)): ?>
                                <span class="help-inline"><?php echo $finishError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($codeError) ? 'error' : ''; ?>">
                        <label class="control-label">Paint Code:</label>
                        <div class="controls">
                            <input name="paintCode" type="text" placeholder="Code"
                                   value="<?php echo !empty($code) ? $code : ''; ?>">
                            <?php if (!empty($codeError)): ?>
                                <span class="help-inline"><?php echo $codeError; ?></span>
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
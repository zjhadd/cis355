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
		$fNameError = null;
		$lNameError = null;
		$phoneError = null;
		$emailError = null;
		$usernameError = null;
		$passwordError = null;
		$password2Error = null;
		
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		$content = file_get_contents($tmpName);

		$types = array('image/jpeg','image/gif','image/png');
		if($filesize > 0) {
			if(in_array($_FILES['userfile']['type'], $types)) {
			}
			else {
				$filename = null;
				$filetype = null;
				$filesize = null;
				$filecontent = null;
				$pictureError = 'improper file type';
				$valid=false;
			}
		}	
		
		// keep track post values
		$fName = $_POST['fName'];
		$lName = $_POST['lName'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		// validate input
		$valid = true;
		if (empty($fName)) {
			$fNameError = 'Please enter First Name';
			$valid = false;
		}
		if (empty($lName)) {
			$lNameError = 'Please enter Last Name';
			$valid = false;
		}		
		if (empty($phone)) {
			$phoneError = 'Please enter Phone Number';
			$valid = false;
		}
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		if (empty($username)) {
			$usernameError = 'Please enter a username';
			$valid = false;
		}
		if (empty($password)) {
			$passwordError = 'Please enter a password';
			$valid = false;
		}
		if (($password == $password2) and ($valid) and (!empty($content))) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE customers set fName=?, lName=?, phone=?, email=?, username=?, password=?, filecontent=? WHERE customersID=$id";
			$q = $pdo->prepare($sql);
			$q->execute(array($fName, $lName, $phone, $email, $username, $password, $content));
			Database::disconnect();
			if ($_SESSION[isAdmin]){
				header("Location: admin.php");
			}
			else{
				header("Location: home.php");
			}
		} else if (($password == $password2) and ($valid)){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE customers set fName=?, lName=?, phone=?, email=?, username=?, password=? WHERE customersID=$id";
			$q = $pdo->prepare($sql);
			$q->execute(array($fName, $lName, $phone, $email, $username, $password));
			Database::disconnect();
			if ($_SESSION[isAdmin]){
				header("Location: admin.php");
			}
			else{
				header("Location: home.php");
			}
		}
		else if ($password != $password2) {
			$password2Error = 'Passwords do not match';
		}
	} 
	else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM customers where customersID = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $fName = $data['fName'];
    $lName = $data['lName'];
    $phone = $data['phone'];
    $email = $data['email'];
	$username = $data['username'];
    $password = $data['password'];
	$password2 = $data['password'];
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
                    <h3>Update Profile Information</h3>
                </div>
                <form class="form-horizontal" action="updateCustomer.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
                    <div class="control-group <?php echo !empty($fNameError) ? 'error' : ''; ?>">
                        <label class="control-label">First Name:</label>
                        <div class="controls">
                            <input name="fName" type="text" placeholder="fName"
                                   value="<?php echo !empty($fName) ? $fName : ''; ?>">
                            <?php if (!empty($fNameError)): ?>
                                <span class="help-inline"><?php echo $fNameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($lNameError) ? 'error' : ''; ?>">
                        <label class="control-label">Last Name:</label>
                        <div class="controls">
                            <input name="lName" type="text" placeholder="lName"
                                   value="<?php echo !empty($lName) ? $lName : ''; ?>">
                            <?php if (!empty($lNameError)): ?>
                                <span class="help-inline"><?php echo $lNameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($phoneError) ? 'error' : ''; ?>">
                        <label class="control-label">Phone:</label>
                        <div class="controls">
                            <input name="phone" type="text" placeholder="Phone"
                                   value="<?php echo !empty($phone) ? $phone : ''; ?>">
                            <?php if (!empty($phoneError)): ?>
                                <span class="help-inline"><?php echo $phoneError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                        <label class="control-label">Email:</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email"
                                   value="<?php echo !empty($email) ? $email : ''; ?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
					<div class="control-group <?php echo !empty($usernameError) ? 'error' : ''; ?>">
                        <label class="control-label">Username:</label>
                        <div class="controls">
                            <input name="username" type="text" placeholder="Username"
                                   value="<?php echo !empty($username) ? $username : ''; ?>">
                            <?php if (!empty($usernameError)): ?>
                                <span class="help-inline"><?php echo $usernameError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($passwordError) ? 'error' : ''; ?>">
                        <label class="control-label">Password:</label>
                        <div class="controls">
                            <input name="password" type="password" placeholder="Password"
                                   value="<?php echo !empty($password) ? $password : ''; ?>">
                            <?php if (!empty($passwordError)): ?>
                                <span class="help-inline"><?php echo $passwordError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($password2Error) ? 'error' : ''; ?>">
                        <label class="control-label">Re-Enter Password:</label>
                        <div class="controls">
                            <input name="password2" type="password" placeholder="Password"
                                   value="<?php echo !empty($password2) ? $password2 : ''; ?>">
                            <?php if (!empty($password2Error)): ?>
                                <span class="help-inline"><?php echo $password2Error; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
					<div class="control-group <?php echo !empty($pictureError)?'error':'';?>">
						<label class="control-label">Picture</label>
						<div class="controls">
							<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
							<input name="userfile" type="file" id="userfile">
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
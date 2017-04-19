<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
    </head>
	<?php 
		include 'database.php';
		include 'ooPicture.php';
	?>
    <body>
        <div class="container">
<!-------------------------------------- This is the "header" for the page ------------------------------------->
            <div class="row">
				<h1 align="center">(ADMIN VIEW)</h1>
                <h1 align="center">True Value "True Color" App Manager
					<h2 style="color:#0020C2">
						Welcome <?php 
							if ($_SESSION[userid] == 13){
								echo $_SESSION['firstname'] . ', you did it! You are finished'; 
							}else if ($_SESSION[userid] == 12){
								echo 'Dr. ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ;
							}
							else{
								echo $_SESSION['firstname'];
							}
						?>!
						<a class="btn btn-success" href="updateCustomer.php?id=<?php echo $_SESSION['userid'] ?>" style="float:right">Update Profile</a>
						<a class="btn btn-danger" href="logout.php" style="float:right">Logout</a>
					</h2>
					<div class="control-group">
						<div class="controls">
							<label class="checkbox">
							<?php   
								Picture::getMyPicture();
							?>
							</label>
						</div>
					</div>
				</h1>
            </div>
			<br><br>
<!---------------------------------------- This is the "Customers" Table --------------------------------------->
            <div class="row">
                <p>
                    
                    <h2 style="color:#0020C2">Customers Table <a href="createCustomer.php" class="btn btn-success"  style="float:right">Create New Customer</a></h2>
                </p>
                <table class="table table-striped table-bordered">
                    <!-- This is the table header -->
					<thead>
					    <tr>
							<th>User ID:</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
							<th>Username</th>
                            <th>Password</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
					<!-- inserting table information -->
                    <tbody>
                        <?php
                            $pdo = Database::connect();
                            $sql = 'SELECT * FROM customers ORDER BY lName';
                            foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
								echo '<td>' . $row['customersID'] . '</td>';
                                echo '<td>' . $row['lName'] . '</td>';
                                echo '<td>' . $row['fName'] . '</td>';
                                echo '<td>' . $row['phone'] . '</td>';
                                echo '<td>' . $row['email'] . '</td>';
								echo '<td>' . $row['username'] . '</td>';
                                echo '<td>' . $row['password'] . '</td>';
                                echo '<td width=250>';
                                echo '<a class="btn" href="readCustomer.php?id=' . $row['customersID'] . '">Read</a>';
                                echo '&nbsp;';
                                echo '<a style="color:blue" class="btn btn-success" href="updateCustomer.php?id=' . $row['customersID'] . '">Update</a>';
                                echo '&nbsp;';
                                echo '<a style="color:black" class="btn btn-danger" href="deleteCustomer.php?id=' . $row['customersID'] . '">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            Database::disconnect();
                        ?>
                    </tbody><!-- end inserting -->
                </table><!-- end of customers table -->
            </div><!-- end of customers table container-->
			
<!----------------------------------------- This is the "Paints" Table ------------------------------------------->
            <div class="row">
                <p>
                    <br><br>
                    <h2 style="color:#0020C2">Paints Table <a href="createPaint.php" class="btn btn-success"  style="float:right">Create New Paint</a></h2>
                </p>
                <table class="table table-striped table-bordered">
                    <!-- This is the table header -->
					<thead>
                        <tr>
                            <th>Paint Name:</th>
                            <th>Paint Size:</th>
                            <th>Paint Finish:</th>
                            <th>Paint Code:</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
					<!-- inserting table information -->
                    <tbody>
                        <?php
                            $pdo = Database::connect();
                            $sql = 'SELECT * FROM paints ORDER BY paintName';
                            foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>' . $row['paintName'] . '</td>';
                                echo '<td>' . $row['paintSize'] . '</td>';
                                echo '<td>' . $row['paintFinish'] . '</td>';
                                echo '<td>' . $row['paintCode'] . '</td>';
                                echo '<td width=250>';
                                echo '<a class="btn" href="readPaint.php?id=' . $row['paintsID'] . '">Read</a>';
                                echo '&nbsp;';
                                echo '<a style="color:blue" class="btn btn-success" href="updatePaint.php?id=' . $row['paintsID'] . '">Update</a>';
                                echo '&nbsp;';
                                echo '<a style="color:black" class="btn btn-danger" href="deletePaint.php?id=' . $row['paintsID'] . '">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            Database::disconnect();
                        ?>
                    </tbody><!-- end inserting -->
                </table><!-- end of paints table -->
            </div><!-- end of paints table container-->
			
<!----------------------------------------- This is the "Projects" Table ----------------------------------------->
            <div class="row">
                <p>
                    <br><br>
                    <h2 style="color:#0020C2">Projects Table <a href="createProject.php" class="btn btn-success" style="float:right">Create New Project</a></h2>
                </p>
                <table class="table table-striped table-bordered">
                    <!-- Column Headings -->
					<thead>
                        <tr>
                            <th>Customer ID:</th>
                            <th>Paint Id:</th>
                            <th>Project Date:</th>
                            <th>Amount of Paint Used:</th>
                            <th>Items Painted:</th>
                        </tr>
                    </thead>
					<!-- inserting table information -->
                    <tbody>
                        <?php
                            $pdo = Database::connect();
                            $sql = 'SELECT * FROM projects ORDER BY date';
                            foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>' . $row['cust_id'] . '</td>';
                                echo '<td>' . $row['paint_id'] . '</td>';
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>' . $row['quantity'] . '</td>';
								echo '<td>' . $row['itemsPainted'] . '</td>';
                                echo '<td width=250>';
                                echo '<a class="btn" href="readProject.php?id=' . $row['projectsID'] . '">Read</a>';
                                echo '&nbsp;';
                                echo '<a style="color:blue" class="btn btn-success" href="updateProject.php?id=' . $row['projectsID'] . '">Update</a>';
                                echo '&nbsp;';
                                echo '<a style="color:black" class="btn btn-danger" href="deleteProject.php?id=' . $row['projectsID'] . '">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            Database::disconnect();
                        ?>
                    </tbody><!-- end inserting -->
                </table><!-- end of projects table -->
            </div><!-- end of projects table container-->
        </div><!-- end of page container -->
    </body>
</html>
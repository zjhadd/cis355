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
                <h1>True Value "True Color" Project Manager <a class="btn btn-success" href="updateCustomer.php?id=<?php echo $_SESSION['userid'] ?>">Update Profile</a><a class="btn btn-danger" href="logout.php" >Logout</a></h1>
            </div>
			<div class="control-group">
				<div class="controls">
					<label class="checkbox">
						<?php   
							Picture::getMyPicture();
						?>
					</label>
				</div>
			</div>
<!----------------------------------------- This is the "Projects" Table ----------------------------------------->
            <div class="row">
                <p>
                    <br><br>
                    <h2 style="color:#0020C2">
						Welcome <?php echo $_SESSION['firstname'] ?>, here are your past "True Color" projects! 
						
					</h2>
					
                </p>
                <table class="table table-striped table-bordered">
                    <!-- Column Headings -->
					<thead>
                        <tr>
                            <th>Project Date:</th> 
                            <th>Paint Name:</th>
                            <th>Amount of Paint Used:</th>
                            <th>Items Painted:</th>
                        </tr>
                    </thead>
					<!-- inserting table information -->
                    <tbody>
                        <?php
                            $pdo = Database::connect();
							$sql = 'SELECT * FROM projects
									LEFT JOIN customers ON projects.cust_id=customers.customersID
									LEFT JOIN paints ON projects.paint_id=paints.paintsID
									WHERE cust_id = "'.$_SESSION['userid'].'"
									ORDER BY date';
                            foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>' . $row['date'] . '</td>';
								echo '<td>' . $row['paintName'] . '</td>';
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
				<a href="createProject.php" class="btn btn-success" style="float:right">Create New Project</a>
            </div><!-- end of projects table container-->
		</div><!-- end of page container -->
    </body>
</html>
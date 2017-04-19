<?php
	include 'database.php';
	
	$pdo = Database::connect();
	if($_GET['id']) 
		$sql = "SELECT * FROM paints WHERE paintsID=" . $_GET['id']; 
	else
		$sql = "SELECT * from paints";

	$arr = array();
	
	foreach ($pdo->query($sql) as $row) {
		$myObj->PaintID = $row['paintsID'];
		$myObj->PaintName = $row['paintName'];
		$myObj->Size = $row['paintSize'];
		$myObj->Finish = $row['paintFinish'];
		$myObj->Code = $row['paintCode'];
		array_push($arr, $myObj);
	}
	
	Database::disconnect();

	echo stripslashes('{"Paint(s)":' . json_encode($arr) . '}');
?>
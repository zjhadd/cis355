<?php
	include 'usercontrol.php';

	class Picture{
		public function getMyPicture(){
			
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM customers where customersID = ".$_SESSION['userid']."";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $data['filecontent'] ).'"/ width="650">';
		}
		
		public function getPicture(){
			$id = null;
			if (!empty($_GET['id'])) {
				$id = $_REQUEST['id'];
			}
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM customers where customersID = $id";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $data['filecontent'] ).'" width="350"/>';
		}
	}
?>






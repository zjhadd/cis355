<?php
session_start();
if (empty($_SESSION['userid']))
	header("Location: menu.php");
?>
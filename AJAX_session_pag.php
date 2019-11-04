<?php 

require_once('config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_SESSION["user_panel"]))

	$_SESSION["start_show"]=$_REQUEST["id"];
	
?>
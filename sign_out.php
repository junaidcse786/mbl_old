<?php 

require_once('config/dbconnect.php');


	$login_time= strtotime(date('Y-m-d H:i:s')) - strtotime($_SESSION["logged_in_time"]);
	
	$sql = "UPDATE ".$db_suffix."user SET user_login_time=user_login_time+$login_time where user_id = '".$_SESSION["front_user_id"]."'";				
	$query = mysqli_query($db, $sql);
	
		
	session_destroy();
	
	header('Location: '.SITE_URL);
?>
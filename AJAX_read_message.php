<?php 
require_once('config/dbconnect.php');

if(((isset($_SESSION["user_panel"]) && isset($_SESSION["front_user_id"])) || (isset($_SESSION["admin_panel"]) && isset($_SESSION["user_id"]))) && isset($_POST['id'])){

	$id = isset($_POST['id'])? $_POST['id']: '0,';
	
	$id.='0';
		
	$sql="UPDATE ".$db_suffix."message SET message_seen='1' WHERE message_id IN (".$id.")";
		
	if(mysqli_query($db,$sql))
	
		$msg = "Updated successfully";
		
	else
	
		$msg = "Failed to Update";
	
}

echo $msg;
?>
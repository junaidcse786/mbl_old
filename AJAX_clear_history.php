<?php
 
require_once('config/dbconnect.php');

if(isset($_SESSION["user_panel"]) && isset($_SESSION["front_user_id"])){

$id = isset($_SESSION["front_user_id"])? $_SESSION["front_user_id"] : 0;

if($id!=0){
	$sql = "DELETE FROM ".$db_suffix."history where user_id ='$id'";				
	$query = mysqli_query($db, $sql);
	
	$sql = "UPDATE ".$db_suffix."user SET user_login_time='0' where user_id ='$id'";				
	$query = mysqli_query($db, $sql);
}

}


?>
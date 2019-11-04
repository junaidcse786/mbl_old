<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["front_user_id"]) && isset($_POST['score'])){
	
	$score = isset($_POST['score'])? $_POST['score']: '0';
	
	$sql = "select user_id from ".$db_suffix."hangman_score where user_id = '".$_SESSION["front_user_id"] ."'";				
			
	$query = mysqli_query($db, $sql);
	
	if(mysqli_num_rows($query)<=0)
	
		mysqli_query($db, "INSERT INTO ".$db_suffix."hangman_score SET hs_score='$score', user_id = '".$_SESSION["front_user_id"] ."'");	
	
	else
		
		mysqli_query($db, "UPDATE ".$db_suffix."hangman_score SET hs_score='$score' WHERE user_id = '".$_SESSION["front_user_id"] ."'");
}
?>
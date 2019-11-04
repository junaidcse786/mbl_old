<?php 
require_once('config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$id = isset($_POST['id'])?$_POST['id']:0;
	
	$sql = "select exercise_title, exercise_id from ".$db_suffix."exercise where exercise_id = (SELECT exercise_id from ".$db_suffix."question where question_id ='$id')";				
	$query = mysqli_query($db, $sql);
	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);	
		$exercise_title       = $content->exercise_title;
		$exercise_id       = $content->exercise_id;
	}
	
	
	$subject='Bericht zur Frage - '.$exercise_title;
	
	$message = $_POST['message'];
	
	$user_id=$_SESSION["user_id"];
		
	$message.='<br /><br /><p><a target="_blank" href="'.SITE_URL.'exercise-trial/'.$exercise_id.'/'.urlencode($exercise_title).'/'.$id.'">Bitte klicken Sie hier, um zur Frage zu gelangen.</a></p>';
	
	if(mysqli_query($db,"INSERT INTO ".$db_suffix."message SET message_subject='$subject', message_receiver='1', message_sender='$user_id', message_report='1', message_text='$message'"))
	{
		$msg = "Delete successfully";
	}else{
		$msg = "Failed to delete";
	}
	echo $msg;
}
?>
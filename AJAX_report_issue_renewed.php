<?php 

require_once('config/dbconnect.php');

echo $id = isset($_POST['id'])? $_POST['id']:0;

if(isset($_SESSION["user_panel"]) && isset($_SESSION["front_user_id"]) && $id!='0'){	
	
	$given_answer = isset($_POST['given_answer'])?$_POST['given_answer']:'';
	
	echo $sql = "select exercise_id , exercise_title from ".$db_suffix."exercise where exercise_id = (SELECT exercise_id from ".$db_suffix."question where question_id ='$id')";				
	$query = mysqli_query($db, $sql);
	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);	
		$exercise_title       = $content->exercise_title;
		$exercise_id       = $content->exercise_id;
	}
	
	
	$sql = "select user_id from ".$db_suffix."user where user_org_name = '".$_SESSION["front_user_org_name"]."' AND user_level='".$_SESSION["front_user_level"]."' AND role_id='15' LIMIT 1";				
	$query = mysqli_query($db, $sql);
	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);	
		$message_receiver       = $content->user_id;
	}
	else
	{
		$message_receiver = 1;
	}
	
	
	$subject='Bericht zur Frage - '.$exercise_title;
	
	$message = $_POST['message'];
	
	$user_id=$_SESSION["front_user_id"];
	
	if(isset($given_answer)){
		
		$message.='<br /><br /><div style="background-color: #fcf8e3; border-color: #faebcc; color: #8a6d3b;  border: 1px solid transparent; border-radius: 4px;"><strong>Eingegebene Antwort:</strong><br /><br /><form action="" class="form-inline">'.$given_answer.'</form></div>';
	}
	
	$message.='<br /><p><a target="_blank" href="'.SITE_URL.'exercise-trial/'.$exercise_id.'/'.urlencode($exercise_title).'/'.$id.'">Bitte klicken Sie hier, um zur Frage zu gelangen.</a></p>';
	
	if(mysqli_query($db,"INSERT INTO ".$db_suffix."message SET message_subject='$subject', message_receiver='$message_receiver', message_sender='$user_id', message_report='1', message_text='$message'"))
	
		$msg = "Report delivered successfully";
		
	else
	
		$msg = "Failed to deliver Report";

}

echo $msg;
?>
<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_GET['id'])){

	$msg='changing batch successful';
	
	$sql = "select * from ".$db_suffix."batch_teacher where id=".$_GET['id'];
    $exists = mysqli_num_rows(mysqli_query($db, $sql));

    if($exists){

        $result1=mysqli_fetch_array(mysqli_query($db, $sql));
						
        $_SESSION["user_org_name"] = $result1["user_org_name"];
			
		$_SESSION["user_level"] = $result1["user_level"];
        
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else{
        $msg='changing batch gone wrong!';
    }
}
?>
<?php 
require_once('../../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_GET['user_id']) && isset($_GET['user_name'])){

	$msg='Impersonating successful';
	
	$sql = "select * from ".$db_suffix."user where user_id=".$_GET['user_id']." AND user_name='".$_GET['user_name']."'";				
    $exists = mysqli_num_rows(mysqli_query($db, $sql));

    if($exists){

        $result1=mysqli_fetch_array(mysqli_query($db, $sql));
						
        $_SESSION["logged_in_time"] = date('Y-m-d H:i:s');
        
        $_SESSION["user_panel"] = 1;

        $_SESSION["front_user_id"] = $result1["user_id"];
        
        $_SESSION["front_user_level"] = $result1["user_level"];
        
        $_SESSION["front_user_org_name"] = $result1["user_org_name"];
        
        header('Location: '.SITE_URL.'my-account/');
    }
    else{
        $msg='Impersonating gone wrong!';
    }
}
?>
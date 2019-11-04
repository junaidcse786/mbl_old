<?php
	
	session_start();
	
	date_default_timezone_get();	
	$db = mysqli_connect("localhost","root","", "test");
	
	if(!($db))
     	trigger_error("Could not connect to the database", E_USER_ERROR);
		
	$db_suffix='ecom_';
	$config_sql = "SELECT * FROM ".$db_suffix."config";
	
    $config_query = mysqli_query($db,$config_sql);
    while($site_obj = mysqli_fetch_object($config_query))
    {    
        if(trim($site_obj->config_name) == 'SITE_NAME')        
            $site_name = $site_obj->config_value;
        if(trim($site_obj->config_name) == 'SITE_URL')    
            $site_url = $site_obj->config_value;
	if(trim($site_obj->config_name) == 'DB_SUFFIX')    
            $db_suffix = $site_obj->config_value;
       define($site_obj->config_name,$site_obj->config_value);
    }  
	
    unset($config_sql,$config_query); 
    define('ROOT_URL', $site_url);	
	
	//header('Location: '.SITE_URL.'page_maintenance_on_hold.php');
	
	if(isset($_SESSION["front_user_id"])){	
		$studs_to_look_for_string_stud="";
		$studs_to_look_for_array_stud=array();
		
		$sql = "SELECT user_id FROM ".$db_suffix."user WHERE user_org_name='".$_SESSION["front_user_org_name"]."' AND user_level='".$_SESSION["front_user_level"]."' AND role_id='16'";					
		$query = mysqli_query($db, $sql);		
		while($row=mysqli_fetch_object($query)){
			array_push($studs_to_look_for_array_stud, $row->user_id);
			$studs_to_look_for_string_stud.=$row->user_id.",";
		}
		$studs_to_look_for_string_stud.="0";	
		define('STUDS_TO_LOOK_FOR_STUD', $studs_to_look_for_string_stud);
		
		$studs_to_look_for_string_stud_trackable="";
		$studs_to_look_for_array_stud_trackable=array();
		
		$sql = "SELECT user_id FROM ".$db_suffix."user WHERE user_org_name='".$_SESSION["front_user_org_name"]."' AND user_level='".$_SESSION["front_user_level"]."' AND role_id='16' AND user_trackability='1'";					
		$query = mysqli_query($db, $sql);		
		while($row=mysqli_fetch_object($query)){
			array_push($studs_to_look_for_array_stud_trackable, $row->user_id);
			$studs_to_look_for_string_stud_trackable.=$row->user_id.",";
		}
		$studs_to_look_for_string_stud_trackable.="0";	
		define('STUDS_TO_LOOK_FOR_STUD_TRACKABLE', $studs_to_look_for_string_stud_trackable);
	}
	if(isset($_SESSION["role_id"]) && $_SESSION["role_id"]=='15'){	
		$studs_to_look_for_string_teacher="";
		$studs_to_look_for_array_teacher=array();
		
		$sql = "SELECT user_id FROM ".$db_suffix."user WHERE user_org_name='".$_SESSION["user_org_name"]."' AND user_level='".$_SESSION["user_level"]."' AND role_id='16'";					
		$query = mysqli_query($db, $sql);		
		while($row=mysqli_fetch_object($query)){
			array_push($studs_to_look_for_array_teacher, $row->user_id);
			$studs_to_look_for_string_teacher.=$row->user_id.",";
		}
		$studs_to_look_for_string_teacher.="0";	
		define('STUDS_TO_LOOK_FOR_TEACHER', $studs_to_look_for_string_teacher);
	}
	
?>
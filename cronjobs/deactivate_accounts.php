<?php 

date_default_timezone_get();	
$db = mysqli_connect("localhost","mblea780_junaid","Junachop123", "mblea780_bl");

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




$query_teacher="SELECT user_level, user_org_name FROM ".$db_suffix."user WHERE role_id='15'";

$query_teacher_exe = mysqli_query($db, $query_teacher);

while($each_record=mysqli_fetch_object($query_teacher_exe)){

$user_level=$each_record->user_level;

$user_org_name=$each_record->user_org_name;

$NO_EXE_LIMIT=3;
$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$user_level ."' AND ts_org_name='".$user_org_name."' AND ts_config_name='NO_EXE_LIMIT'";				
$query = mysqli_query($db, $sql);
$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$NO_EXE_LIMIT = $content->ts_config_value;
}
else

	mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$NO_EXE_LIMIT', ts_config_name='NO_EXE_LIMIT', ts_lang_level = '".$user_level ."', ts_org_name='".$user_org_name."'");


$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP=5;
$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$user_level ."' AND ts_org_name='".$user_org_name."' AND ts_config_name='NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP'";				
$query = mysqli_query($db, $sql);
$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP = $content->ts_config_value;
}
else

	mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', ts_config_name='NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', ts_lang_level = '".$user_level ."', ts_org_name='".$user_org_name."'");
	
	
define('NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', $NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP);	

define('NO_EXE_LIMIT', $NO_EXE_LIMIT);	



	$students_under='0,';
	
	$sql = "SELECT user_id from ".$db_suffix."user u where u.user_level = '".$user_level ."' AND u.role_id='16' AND user_status='1' AND u.user_org_name='".$user_org_name."'";				
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query))
		
		$students_under.=$row->user_id.',';
		
	$students_under=substr($students_under,0,-1);
	
	$students_to_exclude='0,';
	
	$sql = "SELECT distinct user_id from ".$db_suffix."history h where user_id IN (".$students_under.") AND CAST(h.date_taken as DATE) BETWEEN (CURDATE() - INTERVAL ".(NO_EXE_LIMIT+1)." DAY) AND (CURDATE() + INTERVAL 1 DAY)";				
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query))
		
		$students_to_exclude.=$row->user_id.',';
		
	$sql = "SELECT distinct user_id from ".$db_suffix."package_completion_date";
	
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query))
		
		$students_to_exclude.=$row->user_id.',';	
		
	$students_to_exclude.=DUMMY_USERS;
	
	//$students_to_exclude=substr($students_to_exclude,0,-1);
		
	
	$sql = "SELECT user_id, user_email, user_first_name, user_last_name, user_level, user_org_name from ".$db_suffix."user u where u.user_id IN (".$students_under.") AND u.user_id NOT IN (".$students_to_exclude.") AND DATE(user_creation_date) < (NOW() - INTERVAL ".NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP." DAY) AND user_exe_status='0' AND role_id='16' AND u.user_id NOT IN (SELECT user_id FROM ".$db_suffix."package_completion_date)";				
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query)){
	
	
		mysqli_query($db, "UPDATE ".$db_suffix."user SET user_status='0',user_exe_status='1'  where user_id = '$row->user_id'");
		
		$to = $row->user_email;
        $subject = "Konto Deaktivierung auf ".SITE_NAME;
		
		$message="<p>Sehr geehrte(r) ".$row->user_first_name." ".$row->user_last_name." <br /><br />
		
		Ihr Konto wurde deaktiviert, weil Sie ".NO_EXE_LIMIT." Tag(e) lang keine Übungen gemacht haben. Bitte kontaktieren Sie Ihren Lehrer, damit er Ihr Konto reaktiviert.<br /><br />
		
		<br />
		
		Viele Grüße<br />
		
		".SITE_NAME." TEAM
		
		</p>";
		
		 $header = "From: ".SITE_NAME." <".SITE_EMAIL."> \r\n";
		 $header .= "MIME-Version: 1.0\r\n";
		 $header .= "Content-type: text/html; charset=UTF-8\r\n";
		 
		 $retval = mail ($to,$subject,$message,$header);

		echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id.'&user_first_name='.$row->user_first_name.'&user_last_name='.$row->user_last_name.'">Name: '.$row->user_first_name." ".$row->user_last_name.' ORG:['.$row->user_org_name.'] BATCH:['.$row->user_level.']' ;
	
	}
}
		

		 
		 
?>
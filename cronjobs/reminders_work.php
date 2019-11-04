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


$sq1l = "SELECT * FROM ".$db_suffix."reminder r

		LEFT JOIN ".$db_suffix."user u  ON u.user_id=r.user_id WHERE r.r_remind_time<=NOW() AND r.r_seen='0'";

$query_teacher_exe = mysqli_query($db, $sq1l);

while($trow=mysqli_fetch_object($query_teacher_exe)){
			
	$students_under='0,';
		
	$sql = "SELECT user_id, user_first_name, user_last_name, user_email from ".$db_suffix."user u where u.user_id IN (".$trow->r_recipients.")";				
	
	$query = mysqli_query($db, $sql);

	while($row = mysqli_fetch_object($query)){
		
		$title = $trow->r_title;
		$description = $trow->r_desc;
		
		mysqli_query($db, "INSERT INTO ".$db_suffix."message VALUES ('','".$trow->user_id."','".$row->user_id."','0','0',NOW(),'$description','$title','0','0')");
		
		if($trow->r_send_mail){
			
			$to = $row->user_email;
			
			$subject = $title;
			
			$message="<p>Sehr geehrte(r) ".$row->user_first_name." ".$row->user_last_name." <br /><br />
	
			Sie haben eine Erinnerungsmail von Ihrem Lehrer <b>".$trow->user_first_name." ".$trow->user_last_name."</b> erhalten. <br /><br />
			
			".$description."
			
			<br /><br /><br /><br />
			
			Viele Grüße<br />
			
			".SITE_NAME." TEAM
			
			</p>";
			
			 $header = "From: ".SITE_NAME." <".SITE_EMAIL."> \r\n";
			 $header .= "MIME-Version: 1.0\r\n";
			 $header .= "Content-type: text/html; charset=UTF-8\r\n";
			 
			 $retval = mail ($to,$subject,$message,$header);		
		}
	}
	
	mysqli_query($db, "UPDATE ".$db_suffix."reminder SET r_seen='1' WHERE r_id=".$trow->r_id);
	
	$to = $trow->user_email;
	
	$subject = "Erinnerungsmail auf ".SITE_NAME;	
	
	$message="<p>Sehr geehrte(r) ".$trow->user_first_name." ".$trow->user_last_name." <br /><br />
	
	Ihre Erinnerungsmail wurde an die Schüler verschickt. Bitte klicken Sie <a href='".SITE_URL_ADMIN."?mKey=reminder&pKey=edit_reminder&id=".$trow->r_id."'>HIER</a>, um zur Erinnerungsmail zu gelangen.<br /><br />
	
	<br />
	
	Viele Grüße<br />
	
	".SITE_NAME." TEAM
	
	</p>";
	
	 $header = "From: ".SITE_NAME." <".SITE_EMAIL."> \r\n";
	 $header .= "MIME-Version: 1.0\r\n";
	 $header .= "Content-type: text/html; charset=UTF-8\r\n";
	 
	mail ($to,$subject,$message,$header);
}
		

		 
		 
?>
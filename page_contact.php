<?php 
	
require_once('config/dbconnect.php');

require_once("admin/function.php");

$alert_message=""; $alert_box_show="hide"; $alert_type="success";	
$err_easy="has-error";

$name='';
$email='';
$message='';
$subject='';

$err=0;

$messages = array(
					'name' => array('status' => '', 'msg' => ''),
					'email' => array('status' => '', 'msg' => ''),
					'message' => array('status' => '', 'msg' => ''),
					'subject' => array('status' => '', 'msg' => ''),
				);	

if(isset($_POST['Submit'])){	

	extract($_POST);
		
	if(empty($email))
	{
		$messages["email"]["status"]=$err_easy;
		$messages["email"]["msg"]="Dieses Feld muss ausgefüllt werden.";;
		$err++;		
	}
	else if(!isEmail($email)){
		$messages["email"]["status"]=$err_easy;
		$messages["email"]["msg"]="Ungültige E-Mail-Adresse.";;
		$err++;
	
	}
	
	if(empty($name))
	{
		$messages["name"]["status"]=$err_easy;
		$messages["name"]["msg"]="Dieses Feld muss ausgefüllt werden.";;
		$err++;		
	}
	
	if(empty($message))
	{
		$messages["message"]["status"]=$err_easy;
		$messages["message"]["msg"]="Dieses Feld muss ausgefüllt werden.";;
		$err++;		
	}
	
	
	if($subject!='')
	
		$subject1='Inquiry in '.SITE_NAME.' about '.$subject;
		
	else
	
		$subject1='Inquiry in '.SITE_NAME;	
	
	if($err == 0){
		
		/*require_once('phpmailer/class.phpmailer.php');
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->SMTPSecure = "ssl";  
		$mail->Host       = "smtp.gmail.com"; 
		$mail->Port       = 465;

		$mail->Username   = "sahid.info@gmail.com" ;     // SMTP server username
		$mail->Password   = "" ; */           // SMTP server password
			
		$message_content="";
		
		 $to = SITE_EMAIL;
         $subject = $subject1;
         
         $message = "<p>Dear Admin,  <br />Theres'a an inquiry from a user. Please get back to him as soon as possible.</p><p>Name: ".$name."<br />Email: ".$email."<br />Subject: ".$subject."<br />Message: ".$message."<p />";
		 
         
         $header = "From: ".$name." <".$email."> \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html; charset=UTF-8\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
          
		    $alert_box_show="show";
			$alert_type="success";
			$alert_message="Danke schön. Ihre Nachricht wird weitergeleitet.";
         }
		 
		 else {
			 
            echo "Message could not be sent...";
         }
		
		/*

		try 

		{
			$mail->AddReplyTo($email, 'Re: '.$subject);
			$mail->AddAddress(SITE_EMAIL, $subject1);
			$mail->SetFrom($email,$name);
			$mail->Subject = $subject1;
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML($message_content);
			$mail->Send();
		} 
		catch (phpmailerException $e) 
		{
			//echo $msg = $e->errorMessage(); //Pretty error messages from PHPMailer
		} 
		catch (Exception $e) 
		{
			//echo  $msg = $e->getMessage(); //Boring error messages from anything else!
		}*/
		
		$name='';
		$email='';
		$message='';
		$subject='';	
	}
	else
	{
		$alert_box_show="show";
		$alert_type="danger";
		$alert_message="Bitte korrigieren Sie folgenden Fehler.";
	}
}

if(!isset($_POST["Submit"]) && $_GET["s_factor"]==1)
{
	$alert_message="Danke schön. Ihre Nachricht wird weitergeleitet.";		
	$alert_box_show="show";
	$alert_type="success";
}


$content_id = 3;
$page_id=$content_id;

$sql = "select * from ".$db_suffix."content where content_id = $content_id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$title    = $content->content_title;
	$subtitle    = $content->content_sub_title;
	$description = $content->content_desc;
	
	$meta_title  = $content->content_meta_title;
	$meta_key    = $content->content_meta_keywords;
	$meta_desc    = $content->content_meta_desc;
}
	
	
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8">
<title><?php echo $title.' | '.SITE_NAME; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="<?php echo $meta_desc; ?>" name="description">
<meta content="<?php echo $meta_desc; ?>" name="author">
<meta content="<?php echo $meta_title; ?>" name="title">
<meta content="<?php echo $meta_key; ?>" name="key">

<?php require_once('styles.php');	?>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>
<!-- BEGIN HEADER -->
<div class="page-header">
	<?php require_once('page_header.php');	?>
</div>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1><?php echo $title.' <small>'.$subtitle.'</small>' ?></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<div class="row margin-bottom-20">
								<div class="col-md-6">
								<?php echo $description;	?>							
								</div>
								<div class="col-md-6">
									<div class="space20">
									</div>
                                    
                                    <?php 
				
										$content_id=8;
										$sql = "select * from ".$db_suffix."content where content_id = $content_id limit 1";				
										$query = mysqli_query($db, $sql);				
										if(mysqli_num_rows($query) > 0)
										{
											$content     = mysqli_fetch_object($query);
											
											$description = $content->content_desc;
										}
										
										echo $description;
										
										?>
                                    
                                    <div class="form-body">
                                    <div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                        <?php echo $alert_message; ?>
                                    </div>
                                    
									<!-- BEGIN FORM-->
									<form action="<?php echo str_replace('1', '', $_SERVER['REQUEST_URI']);?>" method="post">
										<div class="form-group">
											<div class="input-icon">
												<i class="fa fa-check"></i>
												<input name="subject" value="<?php echo $subject; ?>" type="text" class="form-control" placeholder="Betreff">
                                                <span for="subject" class="help-block"><?php echo $messages["subject"]["msg"] ?></span>
											</div>
										</div>
										<div class="form-group <?php echo $messages["name"]["status"] ?>">
											<div class="input-icon">
												<i class="fa fa-user"></i>
												<input name="name" value="<?php echo $name; ?>" type="text" class="form-control" placeholder="Ihr Name"><span for="name" class="help-block"><?php echo $messages["name"]["msg"] ?></span>
											</div>
										</div>
										<div class="form-group <?php echo $messages["email"]["status"] ?>">
											<div class="input-icon">
												<i class="fa fa-envelope"></i>
												<input name="email" value="<?php echo $email; ?>" type="text" class="form-control" placeholder="Ihre E-mail-adresse"><span for="email" class="help-block"><?php echo $messages["email"]["msg"] ?></span>
											</div>
										</div>
										<div class="form-group <?php echo $messages["message"]["status"] ?>">
											<textarea name="message" class="form-control" rows="3" placeholder="Nachricht"><?php echo $message; ?></textarea><span for="message" class="help-block"><?php echo $messages["message"]["msg"] ?></span>
										</div>
										<button name="Submit" type="submit" class="btn green">Senden</button>
									</form>
                                    </div>
									<!-- END FORM-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->

<?php require_once('footer.php');	?>

<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	?>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<?php 
if($alert_type=='success' && isset($_POST["Submit"]))
{
	//usleep(3000000);
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'1";</script>';
}
?>

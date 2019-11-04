<?php 
	
require_once('config/dbconnect.php');

require_once('authentication.php');	


$content_id = '';
$page_id='';

$meta_title='';
$meta_key='';
$meta_desc='';

$title='Nachricht';
$title1='';
$subtitle='';

$id=$_REQUEST["id"];
$sql = "select * from ".$db_suffix."message where message_id = $id AND (message_sender='".$_SESSION["front_user_id"]."' OR message_receiver='".$_SESSION["front_user_id"]."')limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$message_sender       = $content->message_sender;
	$message_receiver    = $content->message_receiver;
	$message_text    = $content->message_text;
	$message_subject = $content->message_subject;
	$message_created_time = date('d-m-Y H:i', strtotime($content->message_created_time));
}
else
	echo '<script>window.location="'.SITE_URL.'inbox/";</script>';


$sql = "select * from ".$db_suffix."user where user_id = $message_sender";				
$query = mysqli_query($db, $sql);
if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);	
	if($content->role_id!='8'){
		$sender_name       = $content->user_first_name.' '.$content->user_last_name;
		$sender_email    = $content->user_email;
	}
	else{
		$sender_name       = "Administrator";
		$sender_email    = SITE_EMAIL;
	}
	if($content->user_photo!='')
		$sender_photo    = SITE_URL.'data/user/'.$content->user_photo;
	else
		$sender_photo    = SITE_URL_ADMIN."assets/admin/layout/img/avatar.png";	
}

$sql = "select * from ".$db_suffix."user where user_id = $message_receiver";				
$query = mysqli_query($db, $sql);
if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);	
	if($content->role_id!='8'){
		$receiver_name       = $content->user_first_name.' '.$content->user_last_name;
		$receiver_email    = $content->user_email;
	}
	else{
		$receiver_name       = "Administrator";
		$receiver_email    = SITE_EMAIL;
	}
	if($content->user_photo!='')
		$receiver_photo    = SITE_URL.'data/user/'.$content->user_photo;
	else
		$receiver_photo    = SITE_URL_ADMIN."assets/admin/layout/img/avatar.png";	
}

if($message_receiver==$_SESSION["front_user_id"])

	$query = mysqli_query($db, "UPDATE ".$db_suffix."message SET message_seen='1' WHERE message_id=$id");
	
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

<link href="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/css/inbox.css" rel="stylesheet" type="text/css"/>

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
            
            	<div class="porlet-body">
                
                	<div class="row inbox">
						<div class="col-md-2">
							<?php require_once("message_sidebar_left.php"); ?>
						</div>
						<div class="col-md-10">
							<div class="inbox-content">
                            <div class="inbox-header inbox-view-header">
                            <h1 class="pull-left"><?php echo $message_subject; ?></h1>
                            
                        </div>
                        <div class="inbox-view-info">
                            <div class="row">
                                <div class="col-md-12"><strong>An:</strong> 
                                    <img src="<?php echo $receiver_photo ?>" class="img-circle" style="height: 30px; width: 30px;">
                                    <span class="bold">
                                   <?php echo $receiver_name ?> </span>
                                    
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="col-md-12"><strong>Von:</strong> 
                                    <img src="<?php echo $sender_photo ?>" class="img-circle" style="height: 30px; width: 30px;">
                                    <span class="bold">
                                   <?php echo $sender_name ?> </span>
                                    
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="col-md-7"><strong>Gesendet am:</strong> 
                                    <?php echo $message_created_time ?>
                                </div>
                                <div class="col-md-5 inbox-info-btn">
                                    <a href="<?php echo SITE_URL.'send-message/'.$id.'/reply/'.$message_sender; ?>"><button class="btn blue reply-btn">
                                        <i class="fa fa-reply"></i> Antworten </button></a>
                                    <a href="<?php echo SITE_URL.'send-message/'.$id.'/forward/'; ?>"><button class="btn blue reply-btn">
                                        <i class="fa fa-arrow-right"></i> Weiterleiten </button></a>    
                                </div>
                            </div>
                        </div>
                                <div class="inbox-view">
                                    <?php echo $message_text ?>
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
<?php 
	
require_once('config/dbconnect.php');

require_once('authentication.php');		

$content_id = '';
$page_id='send-message';

$meta_title='';
$meta_key='';
$meta_desc='';

$title='Nachricht senden';
$title1='Compose';
$subtitle='';//'Send Message to Users';

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

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

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
<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$title = "";
$description = "";
$parent = "";

$id=isset($_REQUEST["id"])? $_REQUEST["id"] : 0;
$parent=isset($_REQUEST["parent"])? $_REQUEST["parent"] : "";
$keyword=isset($_REQUEST["keyword"])? $_REQUEST["keyword"] : "";

if($id){
	
	if($id!='000'){
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
		
			$sql = "select u.user_first_name, u.user_last_name, u.role_id, r.role_title from ".$db_suffix."user u
					Left Join ".$db_suffix."role r on r.role_id=u.role_id  where u.user_id = $message_sender";				
			$query = mysqli_query($db, $sql);
			if(mysqli_num_rows($query) > 0)
			{
				$content     = mysqli_fetch_object($query);	
				
				$sender_role=$content->role_title;
				
				if($content->role_id!='8'){
					$sender_name       = $content->user_first_name.' '.$content->user_last_name;
					//$sender_email    = $content->user_email;
				}
				else{
					$sender_name       = "Administrator";
					//$sender_email    = SITE_EMAIL;
				}
			}
			
			$sql = "select user_first_name, user_last_name, role_id from ".$db_suffix."user where user_id = $message_receiver";				
			$query = mysqli_query($db, $sql);
			if(mysqli_num_rows($query) > 0)
			{
				$content     = mysqli_fetch_object($query);	
				if($content->role_id!='8'){
					$receiver_name       = $content->user_first_name.' '.$content->user_last_name;
					//$receiver_email    = $content->user_email;
				}
				else{
					$receiver_name       = "Administrator";
					//$receiver_email    = SITE_EMAIL;
				}
			}
			
			
		
			if($keyword=='forward'){
				$title="FW: ".$message_subject;
				$description='<p></p><hr /><p>
							 <strong>Von</strong> : '.$sender_name.'<br />
							 <strong>Gesendet am : </strong> : '.$message_created_time.'<br />
							 <strong>An</strong>   : '.$receiver_name.'<br />
							 <strong>Betreff</strong>   : '.$message_subject.'</p>
							 <blockquote style="font-size:13px; margin:0 0 0 .8ex; border-left:1px #ccc solid; padding-left:1ex">'
							 .$message_text.
							 '</blockquote>';
			}
			if($keyword=='reply'){
				$parent=$message_sender;
				$title="Re: ".$message_subject;
				$description='<p></p><hr /><p>
							 <strong>Von</strong> : '.$sender_name.'<br />
							 <strong>Gesendet am </strong> : '.$message_created_time.'<br />
							 <strong>An</strong>   : '.$receiver_name.'<br />
							 <strong>Betreff</strong>   : '.$message_subject.'</p>
							 <blockquote style="font-size:13px; margin:0 0 0 .8ex; border-left:1px #ccc solid; padding-left:1ex">'
							 .$message_text.
							 '</blockquote>';
			}
		}
	}
	else if($id=='000'){
		$parent=1;
		$title='Account Validity Extension';
	}
	
}


$err=0;

$messages = array(
					'title' => array('status' => '', 'msg' => ''),
					'description' => array('status' => '', 'msg' => ''),
					'parent' => array('status' => '', 'msg' => ''),
					
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($title))
	{
		$messages["title"]["status"]=$err_easy;
		$messages["title"]["msg"]="Dieses Feld muss ausgefüllt werden.";;
		$err++;		
	}
	
	if(empty($parent))
	{
		$messages["parent"]["status"]=$err_easy;
		$messages["parent"]["msg"]="Ein Benutzer muss ausgewählt werden.";;
		$err++;		
	}
	
	if(empty($description))
	{
		$messages["description"]["status"]=$err_easy;
		$messages["description"]["msg"]="Dieses Feld muss ausgefüllt werden.";;
		$err++;		
	}
	
		
	
	if($err == 0)
	{
		$today = date('y-m-d');
	
		$sql = "INSERT INTO ".$db_suffix."message VALUES ('','".$_SESSION["front_user_id"]."','$parent','0','0',NOW(),'$description','$title','0','0')";
		if(mysqli_query($db,$sql))
		{		
			$alert_message="Nachricht erfolgreich gesendet.";		
			$alert_box_show="show";
			$alert_type="success";
			
			$title = "";
			$description = "";
			$parent = "";			
			
		}else{
			$alert_box_show="show";
			$alert_type="danger";
			$alert_message="Database encountered some error while inserting.";
		}
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
	$alert_message="Nachricht erfolgreich gesendet.";		
	$alert_box_show="show";
	$alert_type="success";
}


?>                            
                           
                            
                            <div class="row">
            <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-reorder"></i>Felder mit einem Sternchen <strong>*</strong> müssen ausgefüllt werden.</div>
                  </div>
                  <div class="portlet-body form">
                  
                      <div class="form-body">
                      
                          <div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo $alert_message; ?>
                          </div>
                          
                              
                               <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                               
                               
                                
                              
                              <div class="form-group <?php echo $messages["parent"]["status"] ?>">
                                 <label for="parent" class="control-label col-md-2">Senden an <span class="required">*</span></label>
                                 <div class="col-md-4">
                                    <select class="form-control select2me"  data-placeholder="Nutzer auswählen" tabindex="0" name="parent">
                                       <option value="0">Auswählen</option>
                                       
                                       <?php
									  
									   if($parent==1)
									   
									   		echo'<option selected="selected" value="1">Administrator</option>';
									   
									   $sql_parent_menu = "SELECT u.user_first_name, u.user_last_name, u.user_id FROM ".$db_suffix."batch_teacher bt
									   Left Join ".$db_suffix."user u on u.user_id=bt.user_id where bt.user_org_name='".$_SESSION["front_user_org_name"]."' AND bt.user_level='".$_SESSION["front_user_level"]."' AND u.role_id='15'";	
										$parent_query = mysqli_query($db, $sql_parent_menu);
										while($parent_obj = mysqli_fetch_object($parent_query))
										{	
											if($parent_obj->user_id == $parent)
											
												echo '<option selected="selected" value="'.$parent_obj->user_id.'">'.$parent_obj->user_first_name.' '.$parent_obj->user_last_name.'</option>';
											
											else
												
												echo '<option value="'.$parent_obj->user_id.'">'.$parent_obj->user_first_name.' '.$parent_obj->user_last_name.'</option>';
									
										}
                                        ?>
                                       
                                       
                                    </select>
                                    <span for="parent" class="help-block"><?php echo $messages["parent"]["msg"] ?></span>
                                 </div>
                              </div>                                      
                             
                                                         
                               <div class="form-group <?php echo $messages["title"]["status"] ?>">
                              		<label class="control-label col-md-2" for="title">Betreff <span class="required">*</span></label>
                              		<div class="col-md-9">
                                 		<input type="text" placeholder="" class="form-control" name="title" value="<?php echo $title;?>"/>
                                 		<span for="title" class="help-block"><?php echo $messages["title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-body <?php echo $messages["description"]["status"] ?>">
									<div class="form-group">
										<label class="control-label col-md-2">Nachricht <span class="required">*</span></label>
										<div class="col-md-10">
											<textarea class="ckeditor form-control" name="description" rows="6"><?php echo str_replace('\\','',$description); ?></textarea>
                                            <span for="description" class="help-block"><?php echo $messages["description"]["msg"] ?></span>
										</div>
									</div>
							 </div>
                             
                             
                            <div class="form-actions fluid">
                               <div class="col-md-offset-2 col-md-5">
                                  <button type="submit" name="Submit" class="btn green">Senden</button>
                                  <button type="reset" class="btn default">Zurücksetzen</button>                              
                               </div>
                        	</div>
                            
                            </form>
                      
                      </div>
                      
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
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

    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>


<?php 
if($alert_type=='success' && isset($_POST["Submit"]))
{
	//usleep(3000000);
	echo '<script>window.location="'.SITE_URL.'send-message/1";</script>';
}
?>
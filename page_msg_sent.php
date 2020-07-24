<?php 
	
require_once('config/dbconnect.php');

require_once('authentication.php');	

$meta_title='';
$meta_key='';
$meta_desc='';

$content_id = '';
$page_id='sent';

$title='Gesendete Nachrichten';
$title1='Sent';
$subtitle=''; //'Sent Messages to Admin or Teachers';
	
	
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
                            
                            <?php 
	
/*$sql = "select message_id from ".$db_suffix."message m
		Left Join ".$db_suffix."user u on m.message_receiver=u.user_id where m.message_sender = '".$_SESSION["front_user_id"]."' AND m.sender_delete='0' AND m.message_report='0' ORDER BY m.message_created_time DESC";*/
		
$sql = "select message_id from ".$db_suffix."message m
		Left Join ".$db_suffix."user u on m.message_receiver=u.user_id where m.message_sender = '".$_SESSION["front_user_id"]."' AND m.sender_delete='0' ORDER BY m.message_created_time DESC";
$news_query = mysqli_query($db,$sql);
$num_messages=mysqli_num_rows($news_query);

if(!isset($_SESSION["start_show"]))
	
	$start_show=1;
	
else

	$start_show=$_SESSION["start_show"];	

if($start_show>$num_messages)

$start_show-=PER_PAGE_MSG;
	
if($num_messages<PER_PAGE_MSG)
	
	$end_show=$num_messages;
	
else

	$end_show=$start_show+PER_PAGE_MSG-1;

$next_link=''; $prev_link=''; 


if($end_show>=$num_messages)

	{ $next_link='disabled'; $end_show=$num_messages;}
	
if($start_show<=PER_PAGE_MSG)

	$prev_link='disabled';		

if($num_messages==0)

	$start_show=1;

$sql = "select * from ".$db_suffix."message m
		Left Join ".$db_suffix."user u on m.message_receiver=u.user_id where m.message_sender = '".$_SESSION["front_user_id"]."' AND m.sender_delete='0' AND m.message_report='0' ORDER BY m.message_created_time DESC LIMIT ".($start_show-1).", ".PER_PAGE_MSG;
$news_query = mysqli_query($db,$sql);

if($num_messages==0)

	$start_show=0;


?>
                            
                            <div class="row">
                                <div class="col-md-12">
                                
                                <table class="table table-striped table-advance table-hover">
<thead>
                                <tr>
                                    <th colspan="2">
                                        <input type="checkbox" class="mail-checkbox mail-group-checkbox" />
                                        <div class="btn-group">
                                            <a class="btn btn-sm blue dropdown-toggle" href="javascript:;" data-toggle="dropdown">
                                            Optionen <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#" data-toggle="modal" data-target="#confirmation_all">
                                                    <i class="fa fa-trash-o"></i> Löschen </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </th>
                                    <th class="pagination-control" colspan="2">
                                        <span class="pagination-info">
                                        <?php echo $start_show.' - '.$end_show.' von '.$num_messages; ?></span>
                                        <a <?php echo $prev_link; ?> class="btn btn-sm blue prev-page">
                                        <i class="fa fa-angle-left"></i>
                                        </a>
                                        <a <?php echo $next_link; ?> class="btn btn-sm blue next-page">
                                        <i class="fa fa-angle-right"></i>
                                        </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                	<?php 
										 while($row = mysqli_fetch_object($news_query))
										{
											
									?>
									
									
									
									<tr data-href="<?php echo SITE_URL.'view-message/'.$row->message_id;?>">
										<td class="inbox-small-cells">
											<input value="<?php echo $row->message_id;?>" type="checkbox" class="mail-checkbox" />
										</td>
										<td class="view-message hidden-xs message-show">
											 <?php 
								  
											  if($row->role_id=='8')
											  
												echo 'Administrator';
												
											else
											
												echo $row->user_first_name.' '.$row->user_last_name;	
											  
											  ?>
										</td>
										<td class="view-message text-left message-show">
											 <?php
											 
											 $span='';
											 
											 if($row->message_seen==1)							  
											 	
												$span= '<span class="badge badge-success">Gelesen</span>';
											 
											 
											  echo substr($row->message_subject,0,30).' : '.substr(strip_tags($row->message_text),0,50).' '.$span;
											  
										?></td>
										<td class="view-message text-left message-show">
											 <?php 
								  
											  if(date('d-m-Y')==date('d-m-Y', strtotime($row->message_created_time)))
											  
												echo date('H:i', strtotime($row->message_created_time));
												
											else
											
												echo date('d-m-Y H:i', strtotime($row->message_created_time));	
											  
											  ?>
										</td>
									</tr>
                                
                                <?php } ?>
                                </tbody>
                                </table>
                                   
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

<!-----MODALS FOR THIS PAGE START ---->


         <div class="modal fade" id="confirmation_all">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Bestätigung</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong class="font-red">Hinweis!</strong> Möchten Sie die Nachrichte(n) wirklich löschen?</span>         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn green">Bestätigen</button>
                     <button type="button" class="btn default" data-dismiss="modal">Schließen</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
       
                        <!-- /.modal -->

<!-----MODALS FOR THIS PAGE END ---->

<!-- BEGIN FOOTER -->

<?php require_once('footer.php');	?>

<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	?>

  
    <script>
                $('.next-page').click(function() { 

					$.ajax({
							   type: "POST",
							   url:  '<?php echo SITE_URL?>AJAX_session_pag.php?id=<?php echo $start_show+PER_PAGE_MSG; ?>',
							   success: function(data){ window.location.reload(true); }
							  
					});
				});
				
				$('.message-show').click(function() { 

					window.location.href= $(this).closest("tr").data('href');
				});
				
				
				$('.prev-page').click(function() { 

					$.ajax({
							   type: "POST",
							   url:  '<?php echo SITE_URL?>AJAX_session_pag.php?id=<?php echo $start_show-PER_PAGE_MSG; ?>',
							   success: function(data){ window.location.reload(true); }
							  
					});
				});
				
				
				
				jQuery('body').on('change', '.mail-group-checkbox', function () {
					var set = jQuery('.mail-checkbox');
					var checked = jQuery(this).is(":checked");
					jQuery(set).each(function () {
						$(this).attr("checked", checked);
					});
					jQuery.uniform.update(set);
				});
				
				
				$('#confirmation_all').on('show.bs.modal', function(e) {
					 
					 $(this).find('#delete_button').on('click', function(e) { 
					 
					 var id='';
					 
					 var target='<?php echo SITE_URL; ?>AJAX_delete_message.php';
					 
					 $('input:checkbox[class=mail-checkbox]:checked').each(function(){
						 
						id=id+$(this).val()+',';
					 })
					 
					 	$.ajax({
								   type: "POST",
								   url:  target,
								   dataType: "text",
								   data: {id: id},
								   success: function(data){		
										window.location.reload(true);
								   }								   		   		
						      });
						
					});
		        });
				
				
				
	</script>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
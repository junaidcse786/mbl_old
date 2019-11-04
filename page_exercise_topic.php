<?php 

require_once('config/dbconnect.php');

require_once('authentication.php');	


$exercise_topic = $_REQUEST["title"];

$content_id = $exercise_topic;


$page_id='exercise-page';

$page_id1=isset($_REQUEST["type"])? $_REQUEST["type"] : '';


$meta_desc='&Uuml;bungen zum Thema '.$exercise_topic;

$meta_title='&Uuml;bungen zum Thema '.$exercise_topic;

$meta_key='&Uuml;bungen zum Thema '.$exercise_topic;

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
<title><?php echo '&Uuml;bungen zum Thema '.$exercise_topic.' | '.SITE_NAME; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="<?php echo $meta_desc; ?>" name="description">
<meta content="<?php echo $meta_desc; ?>" name="author">
<meta content="<?php echo $meta_title; ?>" name="title">
<meta content="<?php echo $meta_key; ?>" name="key">

<?php require_once('styles.php');	?>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />

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
				<h1><?php echo '&Uuml;bungen zum Thema <strong>'.$exercise_topic.'</strong>'; ?><small></small></h1>
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
                <div class="portlet-body form">
                    <div class="row">
                    
                    	<div class="col-md-3">
                        		<div class="portlet box blue-hoki">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="glyphicon glyphicon-pushpin"></i>Hinweis
                                    </div>
                                    <!--<div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title="">
                                        </a>
                                    </div>-->
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php 
                                                                                
                                                $content_id=11;
                                                $sql = "select * from ".$db_suffix."content where content_id = $content_id limit 1";				
                                                $query = mysqli_query($db, $sql);				
                                                if(mysqli_num_rows($query) > 0)
                                                {
                                                    $content     = mysqli_fetch_object($query);
                                                    
                                                    $description = $content->content_desc;
                                                }
                                                
                                                echo $description;									
                                            
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    	<div class="col-md-9">
                            <div class="portlet box blue-hoki">
                              <div class="portlet-title">
                                 <div class="caption"><i class="fa fa-table"></i>&Uuml;bungen</div>
                              </div>
                              <div class="portlet-body">
                                 <table class="table table-striped table-bordered table-hover" id="sample_2">
                                    <thead>
                                       <tr>
                                       	  <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                                          <th width="40%">&Uuml;bung</th>
                                          <th width="20%">Stufe</th>
                                          <th width="10%">Fragen</th>
                                          <th width="5%">Niveau</th> 
                                          <th width="30%">Dauer</th>                                       	  <th></th>
                                          
                                       </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php 
		
		$sql = "SELECT * FROM ".$db_suffix."exercise where exercise_status='1' AND exercise_topic like '%$exercise_topic%' ORDER BY exercise_title ASC";
		$news_query = mysqli_query($db,$sql);

                             while($row = mysqli_fetch_object($news_query))
                            {                               
                       			
								$sql = "select exercise_id from ".$db_suffix."exercise where exercise_id='$row->exercise_id' AND DATE(exercise_created_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY)";				
								$query = mysqli_query($db, $sql);
								$has_new_exe=mysqli_num_rows($query);
								
								if($has_new_exe>0)
								
									$span_NEW='<span class="badge badge-danger">NEU</span>';
								
								else{
												
									$sql = "select q.question_id from ".$db_suffix."question q
									LEFT JOIN ".$db_suffix."exercise e ON e.exercise_id=q.exercise_id where e.exercise_id='$row->exercise_id' AND DATE(q.question_creation_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY) LIMIT 1";				
									$query = mysqli_query($db, $sql);
									$has_new_quest=mysqli_num_rows($query);
									
									if($has_new_quest>0)
									
										$span_NEW='<span class="badge badge-danger">AKTUALISIERT</span>';
									else{
									
										$span_NEW='';
									}
								}
								
								
								$selected='';
								
					   			$has_done=mysqli_num_rows(mysqli_query($db,"SELECT exercise_id FROM ".$db_suffix."history where exercise_id='$row->exercise_id' AND user_id='".$_SESSION["front_user_id"]."'"));
					   			if($has_done<=0)
								
									$selected='style="font-weight:bold;"';	
									
								$has_questions=mysqli_num_rows(mysqli_query($db,"SELECT question_id FROM ".$db_suffix."question where exercise_id='$row->exercise_id'"));					   			
								
								?>
                       
                                       <tr <?php echo $selected;?> class="odd gradeX">
                                       
                                       	  <td><input type="checkbox" class="checkboxes" value="" /></td>	
                                       		
                                          <td><?php echo $row->exercise_title.' '.$span_NEW; ?></td>
                                          
                                          <td><?php echo $row->exercise_difficulty;?></td>
                                          
                                          <td><?php echo $row->exercise_pull.' / '.$has_questions;?></td>
                                          
                                          <td><?php echo $row->exercise_level;?></td>
                                          
                                          <td><?php 
										  
										  $duration='';
										  sscanf($row->exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);
										  if($hours!='00')
										  
										  	$duration.=$hours.' Stunde(n) ';
										  
										  if($minutes!='00')
										  
										  	$duration.=$minutes.' Minute(n) ';
											
										  if($seconds!='00')
										  
										  	$duration.=$seconds.' Sekunde(n) ';		
											
										  echo $duration;
										  
										  ?></td> 
                                          
                                          <td><a href="<?php echo SITE_URL.'exercise/'.$row->exercise_id.'/'.urlencode($row->exercise_title); ?>" class="btn default btn-sm green-seagreen">Zur &Uuml;bung</a></td>                                  
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
        
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
   
   <script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/table-managed.js"></script>
   
    <script>
                jQuery(document).ready(function() {    
                    TableManaged.init();				   	   
                });
	</script>

<!--<script>

$(document).ready(function(){

	    setTimeout(function(){

	        $('#form1 #submitButtonID').click();			

			}, 2000);
	});

</script>-->

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php 

require_once('config/dbconnect.php');

require_once('authentication.php');


$key = trim($_GET["key"]);


$content_id = '';

$page_id='';

$page_id1='';


$meta_desc='&Uuml;bungen zum Thema '.$key;

$meta_title='&Uuml;bungen zum Thema '.$key;

$meta_key='&Uuml;bungen zum Thema '.$key;


$where='';

if(count(explode(" ", $key))<=1){

	if(stripos($key,"neu")!== false)
	
		$where=" AND DATE(exercise_created_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY)";
		
	else if(stripos($key,"aktualisiert")!== false)
	
		$where=" AND exercise_id IN (SELECT exercise_id FROM ".$db_suffix."question WHERE DATE(question_creation_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY))";	
		
	else
	
		$where=" AND (exercise_topic LIKE '%".$key."%' OR exercise_type LIKE '%".$key."%' OR exercise_level LIKE '%".$key."%' OR exercise_difficulty LIKE '%".$key."%' OR exercise_title LIKE '%".$key."%')";	
}
else{

	$exercise_level=''; $exercise_type=''; $exercise_difficulty=''; $others='';
	
	$count_exercise_level=0; $count_exercise_type=0; $count_exercise_difficulty=0;
	
	$i_exercise_level=1; $i_exercise_type=1; $i_exercise_difficulty=1;
	
	$where_exercise_level=''; $where_exercise_type=''; $where_exercise_difficulty=''; $where_others=''; 
	
	$sql_parent_menu = "SELECT DISTINCT exercise_type FROM ".$db_suffix."exercise";	
	$parent_query = mysqli_query($db, $sql_parent_menu);
	
	while($row = mysqli_fetch_object($parent_query))
	
		$exercise_type.=$row->exercise_type.' ';
		
	$sql_parent_menu = "SELECT DISTINCT exercise_level FROM ".$db_suffix."exercise";	
	$parent_query = mysqli_query($db, $sql_parent_menu);
	
	while($row = mysqli_fetch_object($parent_query))
	
		$exercise_level.=$row->exercise_level.' ';
		
	
	$sql_parent_menu = "SELECT DISTINCT exercise_difficulty FROM ".$db_suffix."exercise";	
	$parent_query = mysqli_query($db, $sql_parent_menu);
	
	while($row = mysqli_fetch_object($parent_query))
	
		$exercise_difficulty.=$row->exercise_difficulty.' ';
		
	
	
	foreach(explode(" ", $key) as $value){		
		
		if(stripos($exercise_type,$value)!== false)
		
			$count_exercise_type++;
			
		if(stripos($exercise_level,$value)!== false)
		
			$count_exercise_level++;
			
		if(stripos($exercise_difficulty,$value)!== false)
		
			$count_exercise_difficulty++;
	}
	
	
	foreach(explode(" ", $key) as $value){		
		
		if(stripos($exercise_type,$value)!== false){
		
			if($count_exercise_type<=1)
			
				$where_exercise_type.=" AND exercise_type LIKE '%".$value."%'";	
			else{
				
				if($i_exercise_type==1)
				
					$where_exercise_type.=" AND (exercise_type LIKE '%".$value."%'";	
					
				else
				
					$where_exercise_type.=" OR exercise_type LIKE '%".$value."%'";	
					
				if($i_exercise_type==$count_exercise_type)
				
					$where_exercise_type.=")";
					
				$i_exercise_type++;		
			}
		}
		
		else if(stripos($exercise_level,$value)!== false){
		
			if($count_exercise_level<=1)
			
				$where_exercise_level.=" AND exercise_level LIKE '%".$value."%'";	
			else{
				
				if($i_exercise_level==1)
				
					$where_exercise_level.=" AND (exercise_level LIKE '%".$value."%'";	
					
				else
				
					$where_exercise_level.=" OR exercise_level LIKE '%".$value."%'";	
					
				if($i_exercise_level==$count_exercise_level)
				
					$where_exercise_level.=")";
					
				$i_exercise_level++;		
			}
		}
		
		else if(stripos($exercise_difficulty,$value)!== false){
		
			if($count_exercise_difficulty<=1)
			
				$where_exercise_difficulty.=" AND exercise_difficulty LIKE '%".$value."%'";	
			else{
				
				if($i_exercise_difficulty==1)
				
					$where_exercise_difficulty.=" AND (exercise_difficulty LIKE '%".$value."%'";	
					
				else
				
					$where_exercise_difficulty.=" OR exercise_difficulty LIKE '%".$value."%'";	
					
				if($i_exercise_difficulty==$count_exercise_difficulty)
				
					$where_exercise_difficulty.=")";
					
				$i_exercise_difficulty++;		
			}
		}
		
		else if(stripos($value,"neu")!== false && stripos($value," AND DATE(exercise_created_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY)")!== true)
		
			$where.=" AND DATE(exercise_created_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY)";
			
		else
			
			$others.=$value." ";
		
		
	}
	
	$others=trim($others);
	
	if($others!='')
	
		$where_others=" AND (exercise_topic LIKE '%".$others."%' OR exercise_title LIKE '%".$others."%')";	
	$where.=$where_exercise_difficulty." ".$where_exercise_level." ".$where_exercise_type." ".$where_others;

	//echo $where;
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
<title><?php echo '&Uuml;bungen zum Thema  '.$key.' | '.SITE_NAME; ?></title>
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
				<h1><?php echo '&Uuml;bungen zum Thema  %<strong>'.$key.'</strong>%'; ?><small></small></h1>
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
                                          <th width="10%">Frage</th>
                                          <th width="5%">Niveau</th> 
                                          <th width="30%">Dauer</th>                                       	  <th></th>
                                          
                                       </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php 
		
		$sql = "SELECT * FROM ".$db_suffix."exercise where exercise_status='1' $where ORDER BY exercise_title ASC";
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
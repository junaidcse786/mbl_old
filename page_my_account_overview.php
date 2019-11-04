<?php 
	
require_once('config/dbconnect.php');

require_once('authentication.php');	
	

$page_id='my account';
$content_id='';

$meta_desc='';
$meta_title='';
$meta_key='';

$title='Mein Profil';
$subtitle=''; //'You can edit your account information here';


	
$mandate_exe_id=''; 
$sql = "select exercise_id from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["front_user_level"] ."' AND org_name='".$_SESSION["front_user_org_name"]."' AND me_status='1'";				
$query = mysqli_query($db, $sql);
$has_mandate=mysqli_num_rows($query);

if($has_mandate>0) {

	while($damn=mysqli_fetch_object($query))
	
		$mandate_exe_id.=$damn->exercise_id.', ';
	
	$mandate_exe_id=substr($mandate_exe_id,0,-2);	

	$sql = "select h.exercise_id, me.trial_times from ".$db_suffix."history h, ".$db_suffix."mandat_exe me where me.lang_level='".$_SESSION["front_user_level"]."' AND me.me_status='1' AND me.org_name='".$_SESSION["front_user_org_name"]."' AND me.exercise_id=h.exercise_id AND h.user_id='".$_SESSION["front_user_id"]."' AND h.percentage>=me.percentage GROUP BY h.exercise_id HAVING COUNT(h.exercise_id) >=me.trial_times";				
	$query = mysqli_query($db, $sql);
	$has_made=mysqli_num_rows($query);
	
}

else

	$has_made=0;


	
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
<title>Mein Konto | <?php echo SITE_NAME; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="<?php echo $meta_desc; ?>" name="description">
<meta content="<?php echo $meta_desc; ?>" name="author">
<meta content="<?php echo $meta_title; ?>" name="title">
<meta content="<?php echo $meta_key; ?>" name="key">

<?php require_once('styles.php');	?>

<link href="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>

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
			
            <div class="row">
            
            	
				<?php require_once('profile_sidebar_portion.php');	?> 	
            	
                <div class="profile-content">
						
                        <div class="row">
                        
                        <div class="col-md-12">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">History</span>
											
										</div>
										<div class="actions">
                                        	<?php if(1) {  ?> <a data-href="<?php echo SITE_URL.'AJAX_clear_history.php'; ?>" class="btn red hide" data-toggle="modal" href="#" data-target="#confirmation"><i class="fa fa-trash"></i>  Clear History</a> <?php } ?>
                                        
											<div class="btn-group btn-group-devided" data-toggle="buttons">
												<label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
												<input type="radio" value="today" name="today" class="toggle" id="today">Heute</label>
												<label class="btn btn-transparent grey-salsa btn-circle btn-sm">
												<input type="radio" value="week" name="today" class="toggle" id="today">Diese Woche</label>
												<label class="btn btn-transparent grey-salsa btn-circle btn-sm">
												<input type="radio" value="month" name="today" class="toggle" id="today">Von Beginn an</label>
											</div>
										</div>
									</div>
									<div class="portlet-body">
                                    <div class="hide" id="site_activities_loading">
                                        <img src="<?php echo SITE_URL_ADMIN; ?>assets/admin/layout/img/loading.gif" alt="loading"/>
                                    </div>
                                    <div class="row number-stats margin-bottom-20">
											<div class="col-md-3 col-sm-3 col-xs-3">
												<div class="stat-left">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div id="sparkline_bar">
														</div>
													</div>
													<div class="stat-number">
														<div class="title">
															 &Uuml;bungen insgesamt
														</div>
														<div class="number">
															 <?php 
															 echo mysqli_num_rows(mysqli_query($db,"SELECT exercise_id FROM ".$db_suffix."exercise where exercise_status='1'"));
															 ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3">
												<div class="stat-right">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div id="sparkline_bar2">
														</div>
													</div>
													<div class="stat-number">
														<div class="title">
															 Bestandene &Uuml;bungen
														</div>
														<div class="number">
															 <?php 
															 echo mysqli_num_rows(mysqli_query($db,"SELECT exercise_id FROM ".$db_suffix."history where user_id='".$_SESSION["front_user_id"]."' AND percentage>=65 GROUP BY exercise_id"));
															 ?>
														</div>
													</div>
												</div>
											</div>
                                            <div class="col-md-3 col-sm-3 col-xs-3">
												<div class="stat-left">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div id="sparkline_bar2">
														</div>
													</div>
													<div class="stat-number">
														<div class="title">
															 Aufgaben im Paket
														</div>
														<div class="number">
															 <?php 
															 echo $has_mandate;
															 ?>
														</div>
													</div>
												</div>
											</div>
                                            <div class="col-md-3 col-sm-3 col-xs-3">
												<div class="stat-right">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div id="sparkline_bar2">
														</div>
													</div>
													<div class="stat-number">
														<div class="title">
															 Abgeschlossen
														</div>
														<div class="number">
															 <?php 
															 echo $has_made;
															 ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="table-scrollable table-scrollable-borderless">
                                        <div class="hide" id="site_activities_loading">
                                            <img src="<?php echo SITE_URL_ADMIN; ?>assets/admin/layout/img/loading.gif" alt="loading"/>
                                        </div>
                                        <div class="table_exchange">
								<?php 
                                $sql = "SELECT h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='".$_SESSION["front_user_id"]."' AND DATE(date_taken)=CURDATE() ORDER BY h.date_taken DESC";
								$news_query = mysqli_query($db,$sql);
								$no_entry_in_table=mysqli_num_rows($news_query);
                                
                                
                                ?>
											<table class="table table-hover table-light <?php if($no_entry_in_table<=0) echo 'hide';?>">
											<thead>
											<tr class="uppercase">
												<th>
													 &Uuml;bung
												</th>
												<th colspan="2">
													 Zeit
												</th>
												<th colspan="2">
													 Ergebnis
												</th>
												<th>
													 Gemacht am
												</th>
											</tr>
											</thead>
											
                                            <?php 
											
											$sql = "SELECT *, h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='".$_SESSION["front_user_id"]."' AND DATE(date_taken)=CURDATE() ORDER BY h.date_taken DESC";
											$news_query = mysqli_query($db,$sql);
											
											while($row = mysqli_fetch_object($news_query))
			    							{
											
											
											$sql_inside="SELECT AVG(percentage) AS AVG_SCORE, MAX(percentage) AS BEST_SCORE, MIN(percentage) AS MIN_SCORE, AVG(time_taken) AS AVG_TIME, MIN(time_taken) AS BEST_TIME, MAX(time_taken) AS MAX_TIME FROM ".$db_suffix."history where exercise_id='$row->exercise_id'";
				   
										   $query_inside = mysqli_query($db, $sql_inside);
						
											if(mysqli_num_rows($query_inside) > 0)
											{
												$content     = mysqli_fetch_object($query_inside);
																		
												$AVG_SCORE  = round($content->AVG_SCORE, 2);
												$BEST_SCORE    = $content->BEST_SCORE;
												$MIN_SCORE    = $content->MIN_SCORE;
												$AVG_TIME    = round($content->AVG_TIME);
												$BEST_TIME = $content->BEST_TIME;
												$MAX_TIME = $content->MAX_TIME;
												
											}
											
											$time_span='';
											$score_span='';
											
											if($row->percentage>$AVG_SCORE && $row->percentage<$BEST_SCORE)											
												$score_span='<span class="badge badge-success">&Uuml;ber Durchschnitt</span>';
											else if($row->percentage==$AVG_SCORE)											
												$score_span='<span class="badge badge-warning">Durchschnitt</span>';
											else if($row->percentage==$BEST_SCORE)											
												$score_span='<span class="badge badge-success">Bestes Ergebnis</span>';
											
											else if($row->percentage<$AVG_SCORE && $row->percentage>$MIN_SCORE)											
												$score_span='<span class="badge badge-warning">Unter Durchschnitt</span>';
											else if($row->percentage==$MIN_SCORE)											
												$score_span='<span class="badge badge-warning">Niedrigstes Ergebnis</span>';
											//else if($row->percentage<=65)											
												//$score_span='<span class="badge badge-danger">Fail</span>';	
												
											$duration_EXE='';
											$init=$row->time_taken;
										   
											$hours = floor($init / 3600);
											$minutes = floor(($init / 60) % 60);
											$seconds = $init % 60;
											
											if($hours!=0)
																					  
												$duration_EXE.=$hours.' Stunde(n) ';
											
											if($minutes!=0)
											
												$duration_EXE.=$minutes.' Minute(n) ';
											
											if($seconds!=0)
											
												$duration_EXE.=$seconds.' Sekunde(n) ';
											
											
											if($row->time_taken>$AVG_TIME && $row->time_taken<$MAX_TIME)											
												$time_span='<span class="badge badge-warning">Unter Durchschnitt</span>';
											else if($row->time_taken==$AVG_TIME)											
												$time_span='<span class="badge badge-warning">Durchschnitt</span>';
											//else if($row->time_taken==$MAX_TIME)											
												//$time_span='<span class="badge badge-danger">Slowest</span>';
											
											else if($row->time_taken<$AVG_TIME && $row->time_taken>$BEST_TIME)											
												$time_span='<span class="badge badge-success">&Uuml;ber Durchschnitt</span>';
											else if($row->time_taken==$BEST_TIME)											
												$time_span='<span class="badge badge-success">Bestzeit</span>';
											
											
											$style='style="color:green;"';
											if($row->percentage<65)
											{ 
												$time_span='';
												$score_span='';
												$style='style="color:red;"';
											}
											
											
										
											
											?>   
                                                                                     
                                            <tr>
                                            
                                            <td <?php echo $style; ?>><?php echo $row->exercise_title;?></td>
                                            
                                            <td <?php echo $style; ?>><?php echo $duration_EXE;?></td>
                                            
                                            <td <?php echo $style; ?>><?php echo $time_span;?></td>                                            
                                            <td <?php echo $style; ?>><?php echo $row->percentage.'%';?></td>
                                            
                                            <td <?php echo $style; ?>><?php echo $score_span;?></td>                                            
                                            <td <?php echo $style; ?>><?php 
							  
											  if(date('d-m-Y')==date('d-m-Y', strtotime($row->date_taken)))
											  
												echo date('H:i', strtotime($row->date_taken));
												
											else
											
												echo date('d-m-Y H:i', strtotime($row->date_taken));	
											  
											  ?></td> 
                                            
                                            </tr>
											
											<?php } ?>
                                            
											</table>
										</div>
                                        </div>
									</div>
								</div>
								<!-- END PORTLET -->
							</div>
							
                        </div>    
                        
                        
                        <div class="row">
                        
                        <div class="col-md-12">
								<!-- BEGIN PORTLET -->
								<div class="portlet light ">
                                	<div class="portlet-title">
                                     <div class="caption"><i class="fa fa-table"></i>&Uuml;bersicht über deine gemachten &Uuml;bungen</div>
                                     </div>
									<div class="portlet-body">
                                    
                     <table class="table table-striped table-bordered table-hover" id="my_account_page_sample_2">
                        <thead>
                           <tr>
                           	  <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#my_account_page_sample_2 .checkboxes" /></th>
                              <th>&Uuml;bung</th>
                              <th>Ø Ergebnis</th>
                              <th><i class="fa fa-thumbs-up"></i> Ergebnis</th>
                              <th>Ø Zeit</th>
                              <th><i class="fa fa-thumbs-up"></i>  Zeit</th>
                              <th>Versuche</th>
                              <th >Letzter Versuch</th>                           
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
				$sql = "SELECT *, h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='".$_SESSION["front_user_id"]."' GROUP BY h.exercise_id ORDER BY h.date_taken DESC";
				$news_query = mysqli_query($db,$sql);
						
						
		   		 while($row = mysqli_fetch_object($news_query))
			    {
				   
				   $sql_inside1="SELECT date_taken AS LAST_TIME FROM ".$db_suffix."history where user_id='".$_SESSION["front_user_id"]."' AND exercise_id='$row->EXE_ID' ORDER BY date_taken DESC LIMIT 1";
				   
				   $query_inside1 = mysqli_query($db, $sql_inside1);

					if(mysqli_num_rows($query_inside1) > 0)
					{
						$content1     = mysqli_fetch_object($query_inside1);
												
						$LAST_TIME  = date('d-m-Y',strtotime($content1->LAST_TIME));
					}
					
					if($LAST_TIME==date('d-m-Y'))
					
						$LAST_TIME='Heute';
				   
				   
				   $sql_inside="SELECT AVG(percentage) AS AVG_SCORE, MAX(percentage) AS BEST_SCORE, AVG(time_taken) AS AVG_TIME, MIN(time_taken) AS BEST_TIME FROM ".$db_suffix."history where user_id='".$_SESSION["front_user_id"]."' AND exercise_id='$row->EXE_ID'";
				   
				   $query_inside = mysqli_query($db, $sql_inside);

					if(mysqli_num_rows($query_inside) > 0)
					{
						$content     = mysqli_fetch_object($query_inside);
												
						$AVG_SCORE       = round($content->AVG_SCORE, 2).'%';
						$BEST_SCORE    = round($content->BEST_SCORE,2).'%';
						$AVG_TIME    = round($content->AVG_TIME);
						$BEST_TIME =  $content->BEST_TIME;						
					}					
					
		   			$duration_AVG='';
					$init=$AVG_TIME;
				   
					$hours = floor($init / 3600);
					$minutes = floor(($init / 60) % 60);
					$seconds = $init % 60;
					
					if($hours!=0)
															  
						$duration_AVG.=$hours.' Stunde(n) ';
					
					if($minutes!=0)
					
						$duration_AVG.=$minutes.' Minute(n) ';
					
					if($seconds!=0)
					
						$duration_AVG.=$seconds.' Sekunde(n) ';
						
						
					$duration_BEST='';
					$init=$BEST_TIME;
				   
					$hours = floor($init / 3600);
					$minutes = floor(($init / 60) % 60);
					$seconds = $init % 60;
					
					if($hours!=0)
															  
						$duration_BEST.=$hours.' Stunde(n) ';
					
					if($minutes!=0)
					
						$duration_BEST.=$minutes.' Minute(n) ';
					
					if($seconds!=0)
					
						$duration_BEST.=$seconds.' Sekunde(n) ';	
		   ?>
           
                           <tr class="odd gradeX">
                           
                           	  <td><input type="checkbox" class="checkboxes" value="<?php echo $row->user_id;?>" /></td>                              
                              <td><a href="<?php echo SITE_URL.'exercise/'.$row->exercise_id.'/'.urlencode($row->exercise_title); ?>"><?php echo $row->exercise_title;?></a></td>
                              
                              <td><?php echo $AVG_SCORE;?></td>
                              
                              <td><?php echo $BEST_SCORE;?></td>
                              
                              <td><?php echo $duration_AVG;?></td>
                              
                              <td><?php echo $duration_BEST;?></td>
                              
                               <td><?php 
							   
							   $has_done=mysqli_num_rows(mysqli_query($db,"SELECT exercise_id FROM ".$db_suffix."history where exercise_id='$row->EXE_ID' AND user_id='".$_SESSION["front_user_id"]."'"));
								  
							   echo $has_done;
							   
							   ?></td>
                              
                              <td><?php 							  
							  
							  echo $LAST_TIME;
							  
							  if($has_done>1)
							  		echo '<br /><a target="_blank" href="'.SITE_URL.'performance-chart/'.$row->exercise_id.'/'.urlencode($row->exercise_title).'" class="btn default btn-xs yellow-gold">Diagramm</a>';							  
							  ?></td>  
                                                            
                           </tr>
                           
          <?php } ?>       
                        </tbody>
                     </table>
                  
                  </div>
								</div>
								<!-- END PORTLET -->
							</div>
							
                        </div>
                        
                        <?php if($has_mandate>0) { ?>
                        
                        <div class="row"> 
                    	<div class="col-md-12">
                            <div class="portlet box red-thunderbird">
                              <div class="portlet-title">
                                 <div class="caption"><i class="fa fa-table"></i>Pflicht&uuml;bungen</div>
                              </div>
                              <div class="portlet-body">
                                 <table class="table table-striped table-bordered table-hover" id="my_account_page_sample_3">
                                    <thead>
                                       <tr>
                                       <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#my_account_page_sample_3 .checkboxes" /></th>
                                       	  <th ></th>
                                       	  <th width="30%">&Uuml;bung</th>
                                          <th>Sterne</th> 
                                          <th>Prozent</th>
                                          <th>Fragen</th>
                                          <th>Dauer</th>                                       	  <th></th>
                                          
                                       </tr>
                                    </thead>
                                    <tbody>
                                    
									<?php 
									
									
		if($has_made!=$has_mandate)
		
			echo '<div class="alert alert-info alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                        <strong>Hinweis:</strong><br />Du kannst das Aufgabenpaket abschließen, indem du jede Übung bestehst. Wie oft und mit welchem Ergebnis du die Aufgabe bestehen musst, kannst du der dritten und vierten Spalte entnehmen.
                                     </div>';
									 
		else
		
										 							
			echo '<div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                        <strong> Herzlichen Glückwünsch !</strong> Du hast das Aufgabenpaket abgeschlossen. Wenn du möchtest, kannst du die Aufgaben wiederholen.
                                     </div>';						
									
									
									
									
		$exe_order=1;
		
		$sql="SELECT * FROM ".$db_suffix."mandat_exe me
					LEFT JOIN ".$db_suffix."exercise e ON e.exercise_id=me.exercise_id where e.exercise_status='1' AND me.lang_level = '".$_SESSION["front_user_level"] ."' AND me.me_status='1' AND me.org_name='".$_SESSION["front_user_org_name"]."' ORDER BY me.exe_order ASC";
					
		$news_query = mysqli_query($db,$sql);

                             while($row = mysqli_fetch_object($news_query))
                            {                               
                       			$stars_span='';	
								
                                        $has_done=mysqli_num_rows(mysqli_query($db,"SELECT exercise_id FROM ".$db_suffix."history where exercise_id='$row->exercise_id' AND user_id='".$_SESSION["front_user_id"]."' AND percentage>='$row->percentage'"));

                                        if($has_done<$row->trial_times){

                                                $selected='style="color:red;"';
                                                
                                                for($i=1;$i<=$has_done;$i++)

                                                    $stars_span.=' <i class="fa fa-star font-red"></i>';
                                                
                                                for($i=$has_done+1;$i<=$row->trial_times;$i++)

                                                    $stars_span.=' <i class="fa fa-star-o font-red"></i>';
                                        }
                                        else{
                                            
                                            $selected='style="color:green;"';
                                            
                                            for($i=1;$i<=$row->trial_times;$i++)

                                                $stars_span.=' <i class="fa fa-star font-green"></i>';	
                                            
                                        }

                                        $has_questions=mysqli_num_rows(mysqli_query($db,"SELECT question_id FROM ".$db_suffix."question where exercise_id='$row->exercise_id'"));	



                                        $sql1 = "select exercise_id from ".$db_suffix."exercise where exercise_id='$row->exercise_id' AND DATE(exercise_created_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY)";				
                                        $query1 = mysqli_query($db, $sql1);
                                        $has_new_exe=mysqli_num_rows($query1);

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


                                        ?>
                       
                                       <tr class="odd gradeX">
                                       
                                       	  <td <?php echo $selected; ?>><input type="checkbox" class="checkboxes" value="" /></td>
                                       	
                                          <td <?php echo $selected; ?>><?php echo $exe_order; $exe_order++; ?></td>
                                          
                                          <td <?php echo $selected; ?>><?php echo $row->exercise_title.' '.$span_NEW; ?></td>
                                          
                                          <td <?php echo $selected; ?>><?php echo $stars_span;?></td>
                                          
                                          <td <?php echo $selected; ?>><?php echo $row->percentage;?>%</td>
                                          
                                          <td <?php echo $selected; ?>><?php echo $row->exercise_pull.' / '.$has_questions;?></td>
                                          
                                          <td <?php echo $selected; ?>><?php 
										  
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
                        
                        
                        <?php } ?>                    
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


<div class="modal fade" id="confirmation">
    <div class="modal-dialog">
       <div class="modal-content">
          <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
             <h4 class="modal-title">Bestätigung</h4>
          </div>
          <div class="modal-body">
                <span class="danger"><strong>Hinweis!</strong> Sind Sie Ihnen sicher, dass Sie Ihre History löschen möchten? Sobald Sie auf Löschen klicken, alle bisherigen Rekorde von Übungen werden gelöscht.</span>         			</div>
          <div class="modal-footer">
             <button id="delete_button" type="button" class="btn red">Löschen</button>
             <button type="button" class="btn default" data-dismiss="modal">Schließen</button>
          </div>
       </div>
       <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
 </div>


<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	?>

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
        
<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script>
		jQuery(document).ready(function() {
			
			// table 1 config START
			    
			var table = $('#my_account_page_sample_2');

			table.dataTable({
	
				// Internationalisation. For more info refer to http://datatables.net/manual/i18n
				"language": {
					
					"sEmptyTable":      "Keine Daten in der Tabelle vorhanden",
				"sInfo":            "_START_ bis _END_ von _TOTAL_ Einträgen",
				"sInfoEmpty":       "0 bis 0 von 0 Einträgen",
				"sInfoFiltered":    "(gefiltert von _MAX_ Einträgen)",
				"sInfoPostFix":     "",
				"sInfoThousands":   ".",
				"sLengthMenu":      "_MENU_ Einträge anzeigen",
				"sLoadingRecords":  "Wird geladen...",
				"sProcessing":      "Bitte warten...",
				"sSearch":          "Suchen",
				"sZeroRecords":     "Keine Einträge vorhanden.",
				"oPaginate": {
					"sFirst":       "Erste",
					"sPrevious":    "Zurück",
					"sNext":        "Nächste",
					"sLast":        "Letzte"
				},
				"oAria": {
					"sSortAscending":  ": aktivieren, um Spalte aufsteigend zu sortieren",
					"sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
					}
				},
	
				// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
				// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
				// So when dropdowns used the scrollable div should be removed. 
				//"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
	
				//"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
	
				"lengthMenu": [
					[5, 15, 20, -1],
					[5, 15, 20, "Alle"] // change per page values here
				],
				// set the initial value
				"pageLength": 5,
				
				"columnDefs": [{  // set default column settings
					'orderable': false,
					'targets': [0]
				}, {
					"searchable": false,
					"targets": [0]
				}],
				"order": [
					
				] // set first column as a default sort by asc
			});
	
			var tableWrapper = jQuery('#my_account_page_sample_2_wrapper');
	
			table.find('.group-checkable').change(function () {
				var set = jQuery(this).attr("data-set");
				var checked = jQuery(this).is(":checked");
				jQuery(set).each(function () {
					if (checked) {
						$(this).attr("checked", true);
					} else {
						$(this).attr("checked", false);
					}
				});
				jQuery.uniform.update(set);
			});
	
			tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown	
			// table 1 config END
			
			
			// table 2 config START
			    
			var table = $('#my_account_page_sample_3');

			table.dataTable({
	
				// Internationalisation. For more info refer to http://datatables.net/manual/i18n
				"language": {
					
				"sEmptyTable":      "Keine Daten in der Tabelle vorhanden",
				"sInfo":            "_START_ bis _END_ von _TOTAL_ Einträgen",
				"sInfoEmpty":       "0 bis 0 von 0 Einträgen",
				"sInfoFiltered":    "(gefiltert von _MAX_ Einträgen)",
				"sInfoPostFix":     "",
				"sInfoThousands":   ".",
				"sLengthMenu":      "_MENU_ Einträge anzeigen",
				"sLoadingRecords":  "Wird geladen...",
				"sProcessing":      "Bitte warten...",
				"sSearch":          "Suchen",
				"sZeroRecords":     "Keine Einträge vorhanden.",
				"oPaginate": {
					"sFirst":       "Erste",
					"sPrevious":    "Zurück",
					"sNext":        "Nächste",
					"sLast":        "Letzte"
				},
				"oAria": {
					"sSortAscending":  ": aktivieren, um Spalte aufsteigend zu sortieren",
					"sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
					}
				},
	
				// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
				// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
				// So when dropdowns used the scrollable div should be removed. 
				//"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
	
				//"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
	
				"lengthMenu": [
					[5, 15, 20, -1],
					[5, 15, 20, "Alle"] // change per page values here
				],
				// set the initial value
				"pageLength": -1,
				
				"columnDefs": [{  // set default column settings
					'orderable': false,
					'targets': [0]
				}, {
					"searchable": false,
					"targets": [0]
				}],
				"order": [
					
				] // set first column as a default sort by asc
			});
	
			var tableWrapper = jQuery('#my_account_page_sample_3_wrapper');
	
			table.find('.group-checkable').change(function () {
				var set = jQuery(this).attr("data-set");
				var checked = jQuery(this).is(":checked");
				jQuery(set).each(function () {
					if (checked) {
						$(this).attr("checked", true);
					} else {
						$(this).attr("checked", false);
					}
				});
				jQuery.uniform.update(set);
			});
	
			tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
			
			// table 2 config END
			
						   	   
		});				
		
</script>

<script>

$('#confirmation').on('show.bs.modal', function(e) {
					 
	 var target=$(e.relatedTarget).data('href');
	 
	$(this).find('#delete_button').on('click', function(e) { 
	 
		$.ajax({
				   type: "POST",
				   url:  target,
				   success: function(data){		
						window.location.reload(true);
				   },
				   error : function(data){
						window.location.reload(true);
				   }			   		
		   });
	 
	});
});

$('input:radio[name=today]').change(function() {
	
	$('.table_exchange').empty();
	$('#site_activities_loading').toggleClass("hide show");
	
	$.ajax({
	   type: "POST",
	   url:  '<?php echo SITE_URL; ?>AJAX_stat_user.php',
	   data: {id: $(this).val()},
	   success: function(data){		
	   		$('.table_exchange').html(data);
			$('#site_activities_loading').toggleClass("hide show");
	   }								   		   		
    }); 
});

</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
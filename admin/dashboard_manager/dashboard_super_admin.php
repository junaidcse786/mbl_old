<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<!-- BEGIN PAGE header-->

			<h3 class="page-title">
			<?php
			
				echo 'Dashboard <small>System Stats</small>';	
			
			
			?>
            </h3>
            <div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
					</li>
				</ul>
			</div>
<!-- END PAGE HEADER-->

			<!-- BEGIN PAGE CONTENT-->
            
            <!-- FOR ADMIN -->
            
            <div class="row">
            	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php 
								 
								$sql_parent_menu="SELECT exercise_id FROM ".$db_suffix."exercise where exercise_status='1'";	
								$parent_query = mysqli_query($db, $sql_parent_menu);
								
								$num=mysqli_num_rows($parent_query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Active Exercises
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php 
								 
								$sql = "select user_id from ".$db_suffix."user where role_id='16'";				
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Total Learners
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow-gold">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php 
								 
								$sql = "select user_id from ".$db_suffix."user where role_id='15'";				
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Total Teachers
							</div>
						</div>
					</div>
				</div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-seagreen">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php 
								 
								$sql = "select DISTINCT user_org_name from ".$db_suffix."batch_teacher";
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Institutions
							</div>
						</div>
					</div>
				</div>
				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php 
								 
								$sql_parent_menu="SELECT q.question_id FROM ".$db_suffix."question q
								LEFT JOIN ".$db_suffix."exercise e ON q.exercise_id=e.exercise_id WHERE e.exercise_status='1'";	
								$parent_query = mysqli_query($db, $sql_parent_menu);
								
								$num=mysqli_num_rows($parent_query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Active Questions
							</div>
						</div>
					</div>
				</div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php 
								 
								$sql = "select user_id from ".$db_suffix."user where role_id='16' AND user_charge='1'";				
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Total Learners (chargeable)
							</div>
						</div>
					</div>
				</div>
			</div>
			
            
            <div class="row">
            	<div class="col-md-12">
                    <div class="portlet box grey-cascade">
                      <div class="portlet-title">
                         <div class="caption"><i class="fa fa-table"></i>Exercises Review</div>
                      	 <div class="actions">
                        <a data-toggle="modal" href="#" data-target="#confirmation" data-href="<?php echo SITE_URL_ADMIN.'reset_counter.php'; ?>" class="btn red-thunderbird hide"><i class="fa fa-clock-o"></i> Reset Counter</a>
                      </div>
                      
                      </div>
                      <div class="portlet-body">
                         <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                               <tr>
                               <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                                  <th>Title</th>
                                  <th>Hits</th>
                                  <th >Duration</th>
                                  <th >AVG Time</th>
                                  <th >MIN Time</th>
                                  <th >MAX Time</th>
                                  <th >AVG Score</th>
                                  <th >MIN Score</th>
                                  <th >MAX Score</th>
                                  <!--<th ></th>-->
                               </tr>
                            </thead>
                            <tbody>
                            
                            <?php 
							
					$sql_parent_menu="SELECT e.* FROM ".$db_suffix."history h
					LEFT JOIN ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where e.exercise_status='1' GROUP BY h.exercise_id ORDER BY e.exercise_created_time DESC";	
					$parent_query = mysqli_query($db, $sql_parent_menu);		
							
                     while($row = mysqli_fetch_object($parent_query))
                    {
                       
					   //$sql_Exe_hits="SELECT user_id FROM ".$db_suffix."history where exercise_id = '$row->exercise_id' ";	
					   //$Exe_hits_query = mysqli_num_rows(mysqli_query($db, $sql_Exe_hits));
					   
					   
					   $sql_inside="SELECT COUNT(user_id) as EXE_HITS_USER, AVG(percentage) AS AVG_SCORE, MAX(percentage) AS BEST_SCORE, MIN(percentage) AS MIN_SCORE, AVG(time_taken) AS AVG_TIME, MIN(time_taken) AS BEST_TIME, MAX(time_taken) AS MAX_TIME FROM ".$db_suffix."history where exercise_id='$row->exercise_id'";
				   
					   $query_inside = mysqli_query($db, $sql_inside);
	
						if(mysqli_num_rows($query_inside) > 0)
						{
							$content     = mysqli_fetch_object($query_inside);
													
							$AVG_SCORE       = round($content->AVG_SCORE, 2).'%';
							$BEST_SCORE    = round($content->BEST_SCORE,2).'%';
							$MIN_SCORE    = round($content->MIN_SCORE,2).'%';
							$AVG_TIME    = round($content->AVG_TIME);
							$BEST_TIME = $content->BEST_TIME;
							$MAX_TIME = $content->MAX_TIME;
                                                        $Exe_hits_query = $content->EXE_HITS_USER;
							
						}
						
					$duration_AVG='';
					$init=$AVG_TIME;
				   
					$hours = floor($init / 3600);
					$minutes = floor(($init / 60) % 60);
					$seconds = $init % 60;
					
					if($hours>0 && $hours<10)
							
						$hours='0'.$hours;
						
					if($minutes>0 && $minutes<10)
					
						$minutes='0'.$minutes;
						
					if($seconds>0 && $seconds<10)
					
						$seconds='0'.$seconds;
					
					
					if($hours!=0)
															  
						$duration_AVG.=$hours.' : ';
						
					else
							
						$duration_AVG.=' 00 : ';	
					
					if($minutes!=0)
					
						$duration_AVG.=$minutes.' : ';
						
					else
							
						$duration_AVG.=' 00 : ';	
					
					if($seconds!=0)
					
						$duration_AVG.=$seconds;
						
					else
							
						$duration_AVG.=' 00';	
						
						
					$duration_MAX='';
					$init=$MAX_TIME;
				   
					$hours = floor($init / 3600);
					$minutes = floor(($init / 60) % 60);
					$seconds = $init % 60;
					
					if($hours>0 && $hours<10)
							
						$hours='0'.$hours;
						
					if($minutes>0 && $minutes<10)
					
						$minutes='0'.$minutes;
						
					if($seconds>0 && $seconds<10)
					
						$seconds='0'.$seconds;
					
					
					if($hours!=0)
															  
						$duration_MAX.=$hours.' : ';
						
					else
							
						$duration_MAX.=' 00 : ';	
					
					if($minutes!=0)
					
						$duration_MAX.=$minutes.' : ';
						
					else
							
						$duration_MAX.=' 00 : ';	
					
					if($seconds!=0)
					
						$duration_MAX.=$seconds;
						
					else
							
						$duration_MAX.=' 00';		
						
						
					$duration_BEST='';
					$init=$BEST_TIME;
				   
					$hours = floor($init / 3600);
					$minutes = floor(($init / 60) % 60);
					$seconds = $init % 60;
					
					if($hours>0 && $hours<10)
							
						$hours='0'.$hours;
						
					if($minutes>0 && $minutes<10)
					
						$minutes='0'.$minutes;
						
					if($seconds>0 && $seconds<10)
					
						$seconds='0'.$seconds;
					
					
					if($hours!=0)
															  
						$duration_BEST.=$hours.' : ';
						
					else
							
						$duration_BEST.=' 00 : ';	
					
					if($minutes!=0)
					
						$duration_BEST.=$minutes.' : ';
						
					else
							
						$duration_BEST.=' 00 : ';	
					
					if($seconds!=0)
					
						$duration_BEST.=$seconds;	
						
					else
							
						$duration_BEST.=' 00';	
					   
					   
               ?>
               
                               <tr class="odd gradeX">
                               	
                                	<td><input type="checkbox" class="checkboxes" value="<?php echo $row->user_id;?>" /></td>                                	
                                  <td><a target="_blank" href="<?php echo '?mKey=exercise&pKey=editexercise&id='.$row->exercise_id;?>"> <?php echo $row->exercise_title;?></a></td>
                                  
                                  <td><?php echo $Exe_hits_query;?></td>
                                  
                                  <td><?php 
								   
								  sscanf($row->exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);
								  $exercise_duration= $hours * 3600 + $minutes * 60 + $seconds;
								  
								  $duration='';
								  
								  if($hours>0 && $hours<10)
							
									$hours='0'.$hours;
									
									if($minutes>0 && $minutes<10)
									
										$minutes='0'.$minutes;
										
									if($seconds>0 && $seconds<10)
									
										$seconds='0'.$seconds;

									if($hours!=0)
																			  
										$duration.=$hours.' : ';
										
									else
									
										$duration.=' 00 : ';	
									
									if($minutes!=0)
									
										$duration.=$minutes.' : ';
										
									else
									
										$duration.=' 00 : ';		
									
									if($seconds!=0)
									
										$duration.=$seconds;
										
									else
									
										$duration.='00';		
								  
								  echo $duration;							   
								   
								   
								   ?></td>
                                   
                              <td><?php echo $duration_AVG;?></td>
                              
                              <td><?php echo $duration_BEST;?></td>
                              
                              <td><?php echo $duration_MAX;?></td>
                              
                              <td><?php echo $AVG_SCORE;?></td>
                              
                              <td><?php echo $MIN_SCORE;?></td>
                              
                              <td><?php echo $BEST_SCORE;?></td>
                              
                              <!--<td>
                              
                              <a target="_blank" href="<?php echo '?mKey=exercise&pKey=editexercise&id='.$row->exercise_id;?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i> Edit</a>
                              
                              </td>  -->
                                  
                               </tr>
                               
              <?php } ?>       
                            </tbody>
                         </table>
                      
                      </div>
                   </div>
               </div>    
            
            
            
            </div>            
          
			<!--FOR ADMIN END -->            
            <!-- END PAGE CONTENT -->
            
	</div>
</div>    

<!-- END PAGE CONTAINER -->

        
        <!-- BEGIN FOOTER -->
        
        <?php require_once('footer.php'); ?>
        
        <!-- END FOOTER -->
        
        <div class="modal fade" id="confirmation">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Warning !</strong> Are you sure you want to perform this action?</span>         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red">Do it</button>
                     <button type="button" class="btn default" data-dismiss="modal">Close</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
        
        
        
      
        <!-- BEGIN CORE PLUGINS --> 
          
        
		<?php require_once('scripts.php'); ?>
        
        
       <!-----page level scripts start--->
       
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
        
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
   
   <script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/table-managed.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
   
    <script>
                jQuery(document).ready(function() {    
                    TableManaged.init();							   	   
                });
				
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
				
	</script>	
   
       
   
    	<!-----page level scripts end--->
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>      
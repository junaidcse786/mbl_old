<?php 

require_once('config/dbconnect.php');

require_once('authentication.php');	

require_once('functions_exercise_related.php');	
		

$exercise_id = $_REQUEST["id"];

$content_id = $exercise_id;

$page_id='';

$sql = "select exercise_title, exercise_desc, exercise_pull, exercise_duration, exercise_req_percentage from ".$db_suffix."exercise where exercise_id = $exercise_id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0){
	
	$content     = mysqli_fetch_object($query);
	$title    = $content->exercise_title;
	$exercise_desc    = $content->exercise_desc;
	$exercise_pull    = $content->exercise_pull;
	$exercise_duration=  $content->exercise_duration;
	$exercise_req_percentage=  $content->exercise_req_percentage;
}	

$exercise_title = $title;


$meta_desc=$exercise_title;

$meta_title=$exercise_title;

$meta_key=$exercise_title;


sscanf($exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);

$exercise_duration= $hours * 3600 + $minutes * 60 + $seconds;

$exercise_duration_halfway= floor($exercise_duration/2);

$exercise_duration_last= floor($exercise_duration/(4/5));


$duration='';

if($hours!='00')
										  
	$duration.=$hours.' Stunde(n) ';

if($minutes!='00')

	$duration.=$minutes.' Minute(n) ';

if($seconds!='00')

	$duration.=$seconds.' Sekunde(n) ';


$duration_halfway='';
$init = $exercise_duration_halfway;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;

if($hours!=0)
										  
	$duration_halfway.=$hours.' Stunde(n) ';

if($minutes!=0)

	$duration_halfway.=$minutes.' Minute(n) ';

if($seconds!=0)

	$duration_halfway.=$seconds.' Sekunde(n) ';


$duration_last='';
$init = $exercise_duration_last;
$hours = floor($init / 3600);
$minutes = floor(($init / 60) % 60);
$seconds = $init % 60;

if($hours!=0)
										  
	$duration_last.=$hours.' Stunde(n) ';

if($minutes!=0)

	$duration_last.=$minutes.' Minute(n) ';

if($seconds!=0)

	$duration_last.=$seconds.' Sekunde(n) ';
	
		

if(isset($_POST["Submit"]))
{
	$final_marks=0; $num_q_fetched=0;
	
	$sql = "select * from ".$db_suffix."question where question_id IN (".$_POST["list_question"].")";				
	
	$query = mysqli_query($db, $sql); $blank_entry=0;
	
	$total_num_questions=mysqli_num_rows($query);
	
	unset($_SESSION["question_got_wrong"]);
	
	unset($_SESSION["question_got_wrong_case"]);
	
	unset($_SESSION["question_got_wrong_structure"]);
	
	unset($_SESSION["question_got_wrong_punct"]);
	
	$_SESSION["question_got_wrong"]=array();
	
	$_SESSION["question_got_wrong_case"]=array();
	
	$_SESSION["question_got_wrong_structure"]=array();
	
	$_SESSION["question_got_wrong_punct"]=array();
	
	while($row=mysqli_fetch_object($query))
	{
		$question_wrong_hits_user=$row->question_wrong_hits_user;
			
		$question_hits_user=$row->question_hits_user;
		
		if($question_hits_user!='')
	
				$question_hits_user.=' '.$_SESSION["front_user_id"];
		
		else

				$question_hits_user=$_SESSION["front_user_id"];

		$update_hits_user = mysqli_query($db, "UPDATE ".$db_suffix."question SET question_hits_user='$question_hits_user' where question_id = '$row->question_id'");
		
		
		
		$question_real_marks=$row->question_marks;

		if($row->question_type=='Text'){
			
			$question_marks=0; $i=0;
		
			$question_answer=$row->question_answer;
			
			if(substr($question_answer, -1, count($question_answer))=='.')
			
				$question_answer=substr($question_answer, 0, -1);
				
			
			$correct_answer_array=explode('.', $question_answer);
			
			$minus_mark=$question_real_marks/count($correct_answer_array);
			
			$given_answer_array=$_POST["question_".$row->question_id];
			
			$count_correct_answer_array=count($correct_answer_array);
			
			
			$question_given_answer=$given_answer_array[0];
			
			if(substr($question_given_answer, -1, count($question_given_answer))=='.')
			
				$question_given_answer=substr($question_given_answer, 0, -1);
				
			else
			
				{ $question_marks-=$minus_mark; array_push($_SESSION["question_got_wrong_punct"], $row->question_id);	}
			
			
			$count_given_answer_array=count(explode('.', $question_given_answer));
			
			
			$_SESSION["question_".$row->question_id]=$given_answer_array[0];
			
			$blank_entry_q_wise=0;
			
			
			if($count_correct_answer_array!=$count_given_answer_array){
				
				array_push($_SESSION["question_got_wrong_punct"], $row->question_id);
			
				if($count_correct_answer_array>$count_given_answer_array)
				
					for($i=0;$i<($count_correct_answer_array-$count_given_answer_array);$i++)
					
						$question_given_answer.='.';						
			}
			
			$i=0;
			
			while($i<count($correct_answer_array))
			{	
				$num_q_fetched++;
				
				$given_answer_umlauts_added=trim(explode('.', $question_given_answer)[$i]);
				
				if(empty($given_answer_umlauts_added))

						$blank_entry_q_wise++;
				
				else if(QUESTION_CASE_EVALUATE){				
					
					if(trim($given_answer_umlauts_added)==trim($correct_answer_array[$i]))
						
						$question_marks+=$minus_mark;
						
					else{
						
						if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0)
							array_push($_SESSION["question_got_wrong_case"], $row->question_id);
							
						else if(wrong_sentence_structure(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))){	
						
							array_push($_SESSION["question_got_wrong_structure"], $row->question_id);
							$question_marks+=$minus_mark/2;													
						}
					}
				}
				else{
				
					if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0)
							$question_marks+=$minus_mark;
							
					else if(wrong_sentence_structure(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))){	
						
							array_push($_SESSION["question_got_wrong_structure"], $row->question_id);
							$question_marks+=$minus_mark/2;													
					}					
								
				}	
				
				$i++;	
			}
			
			if($question_marks<0)
				
				$question_marks=0;
			
			
			if($question_marks>$question_real_marks)
				
				$question_marks=$question_real_marks;
			
			
			if(($question_marks>0 && $question_marks<$question_real_marks) || $question_marks==0)
			
				array_push($_SESSION["question_got_wrong"], $row->question_id);
				
				
			$blank_entry+=$blank_entry_q_wise;
				
			
			if($question_marks==0 && $blank_entry_q_wise!=count($correct_answer_array))
			{
				//$update_wrong_hits_question = mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits=question_wrong_hits+1 where question_id = '$row->question_id' ");
				
				if($question_wrong_hits_user!='')
				
					$question_wrong_hits_user.=' '.$_SESSION["front_user_id"];
				
				else
				
					$question_wrong_hits_user=$_SESSION["front_user_id"];	
				
				$update_wrong_hits_user = mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits_user='$question_wrong_hits_user' where question_id = '$row->question_id'");		
			}
			
			$final_marks+=$question_marks;
		}
		else{			
					
			$question_marks=0; $i=0; 
			
			$correct_answer_array=explode('+', $row->question_answer);
			
			$minus_mark=$question_real_marks/count($correct_answer_array);
			
			$given_answer_array=$_POST["question_".$row->question_id];
			
			$_SESSION["question_".$row->question_id]='';
			
			$blank_entry_q_wise=0;
			
			while($i<count($correct_answer_array))
			{	
				$got_it_right=0;
				
				$num_q_fetched++;
				
				$given_answer_umlauts_added=trim($given_answer_array[$i]);
				
				if(empty($given_answer_umlauts_added))
				
					 $blank_entry_q_wise++; 
					
				if(QUESTION_CASE_EVALUATE){
				
					if(count(explode('=', trim($correct_answer_array[$i])))>1)
					{
						if(in_array(trim($given_answer_umlauts_added), array_map('trim', explode('=', $correct_answer_array[$i])))){
							$question_marks+=$minus_mark; $got_it_right=1;
						}	
							
						else if(in_array(trim(strtolower($given_answer_umlauts_added)), array_map('trim', explode('=', strtolower($correct_answer_array[$i])))))
							array_push($_SESSION["question_got_wrong_case"], $row->question_id);		
							
							
					}
					else{
						if(trim($given_answer_umlauts_added)==trim($correct_answer_array[$i])){
						
							$question_marks+=$minus_mark; $got_it_right=1;
						}
							
						else if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0)
							array_push($_SESSION["question_got_wrong_case"], $row->question_id);	
							
							
					}
				}
				else{
				
					if(count(explode('=', trim($correct_answer_array[$i])))>1)
					{
						foreach(explode('=', trim($correct_answer_array[$i])) as $note)
							{
								if(strcasecmp(trim($given_answer_umlauts_added), trim($note))== 0)
									
									 { $question_marks+=$minus_mark; $got_it_right=1; break;	}
							}
					}
					else
					{
						if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0){
							$got_it_right=1;
							$question_marks+=$minus_mark;
						}	
					}
				}	
				
				$_SESSION["question_".$row->question_id].=trim($given_answer_array[$i]).'>786>'.$got_it_right.'+ ';
				
				$i++;
				
				substr($_SESSION["question_".$row->question_id], 0, -2);	
			}
			
			
			if($question_marks>$question_real_marks)
				
				$question_marks=$question_real_marks;
			
			
			if(($question_marks>0 && $question_marks<$question_real_marks) || $question_marks==0)
			
				array_push($_SESSION["question_got_wrong"], $row->question_id);
				
				
			$blank_entry+=$blank_entry_q_wise;
				
			
			if($question_marks==0 && $blank_entry_q_wise!=count($correct_answer_array))
			{
				if($question_wrong_hits_user!='')
				
					$question_wrong_hits_user.=' '.$_SESSION["front_user_id"];
				
				else
				
					$question_wrong_hits_user=$_SESSION["front_user_id"];	
                                
                                
                $update_wrong_hits_user = mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits_user='$question_wrong_hits_user' where question_id = '$row->question_id'");		
			}
			
			$final_marks+=$question_marks;
			
		}
	}
        
        $final_marks=($final_marks*100)/$num_q_fetched;	
	
	if($blank_entry<=floor($num_q_fetched/2))
	
		{
			$_SESSION["came_from_exercise_page"]=1;
			
			$_SESSION["list_question"]=$_POST["list_question"];
			
			$_SESSION["time_spent"]=$_POST["time_spent"];
			
			header('Location: '.SITE_URL.'result/'.$exercise_id.'/'.urlencode($exercise_title).'/'.round($final_marks,2));
			
		}
	else
	
		{
			$_SESSION["came_from_exercise_page"]=1;
			
			$_SESSION["list_question"]=$_POST["list_question"];
			
			$_SESSION["time_spent"]=$_POST["time_spent"];
			
			header('Location: '.SITE_URL.'result/'.$exercise_id.'/'.urlencode($exercise_title).'/blank');
		}	
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
				<h1><?php echo $title; ?><small></small></h1>
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
                    
                    
                    <div class="col-md-9">
                            <?php
							$required_exercises_id=array(); $have_exercises_id=array();
							
							$sql = "SELECT e.exercise_id AS EX_ID FROM ".$db_suffix."exe_req er
							Left Join ".$db_suffix."exercise e ON er.req_id=e.exercise_id where er.exercise_id='$exercise_id'";
							$query=mysqli_query($db,$sql);
							
							while($row=mysqli_fetch_object($query)){
								
								array_push($required_exercises_id, $row->EX_ID);								
							}
							
							$required_exe_id_string='';
								
							foreach($required_exercises_id as $value)
							
								$required_exe_id_string.=$value.', ';							
							
							$required_exe_id_string=substr($required_exe_id_string, 0, -2);
							
							if($required_exe_id_string!=''){
								
								$sql = "SELECT exercise_id FROM ".$db_suffix."history where exercise_id IN (".$required_exe_id_string.") AND percentage>='$exercise_req_percentage' AND user_id='".$_SESSION["front_user_id"]."' GROUP BY exercise_id";
								$query=mysqli_query($db,$sql);
								
								while($row=mysqli_fetch_object($query)){
									
									array_push($have_exercises_id, $row->exercise_id);								
								}
							}
							
							$have_exe_id_string='';
								
							foreach($have_exercises_id as $value)
							
								$have_exe_id_string.=$value.', ';							
							
							$have_exe_id_string=substr($have_exe_id_string, 0, -2);
							
							$sys_fucked_up=0;
							
							if(count($required_exercises_id)!=count($have_exercises_id)){
								
								$sys_fucked_up=1;
							
								echo '<div class="alert alert-danger">
                            
                            		Du kannst diese &Uuml;bung noch nicht machen. Um diese Übung machen zu können, musst du zuerst folgende Übung(en) machen und mit mindestens <strong>'.$exercise_req_percentage.'% </strong> bestehen:
                          			  </div>';
							?>		  
									  
							<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
								<thead>
								<tr class="uppercase">
									<th>
										 &Uuml;bung
									</th>
                                    <th>
										 Thema
									</th>
									<th>
										 Niveau
									</th>
									<th>
										 Dauer
									</th>
									<th>
										 Stufe
									</th>
									<th>&nbsp;
									</th>
								</tr>
								</thead>
								<tbody>
                                
                                <?php 
								
								$where='';
								
								if($have_exe_id_string!='')
								
									$where=" AND exercise_id NOT IN (".$have_exe_id_string.")";
								 
								 
								 $sql = "select * from ".$db_suffix."exercise where exercise_id IN (".$required_exe_id_string.") $where";
								 $news_query = mysqli_query($db,$sql);
						
								 while($row = mysqli_fetch_object($news_query))
								{  
								
								
								?>
                                
								  <td><?php echo $row->exercise_title;?></td>
                                  
                                  <td><?php echo $row->exercise_topic;?></td>
                                   
                                  <td><?php echo $row->exercise_level;?></td>
                                          
                                  <td><?php 
                                  
                                  $duration_REQ='';
                                  sscanf($row->exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);
                                  if($hours!='00')
                                  
                                    $duration_REQ.=$hours.' Stunde(n) ';
                                  
                                  if($minutes!='00')
                                  
                                    $duration_REQ.=$minutes.' Minute(n) ';
                                    
                                  if($seconds!='00')
                                  
                                    $duration_REQ.=$seconds.' Sekunde(n) ';		
                                    
                                  echo $duration_REQ;
                                  
                                  ?></td> 
                                  
                                  <td><?php echo $row->exercise_difficulty;?></td>
                                                                    
                                  <td><a href="<?php echo SITE_URL.'exercise/'.$row->exercise_id.'/'.urlencode($row->exercise_title); ?>" class="btn default btn-sm green-seagreen">Zur &Uuml;bung</a></td>                                  
                               </tr>
                                       
								<?php } ?>
                                
								</tbody>
								</table>
							</div>
                            
                            <?php }
							
							else {
								
								echo $exercise_desc;
								
							?>
                            
                            <form id="form1" action="" class="form-inline" method="post">
                            
                            <?php
							
							$list_of_question_id=array(); $i=0; $id_counter=0; //$rand_q_id='';
							
							$sql = "SELECT q.* from ".$db_suffix."question q, (SELECT question_id from ".$db_suffix."question WHERE exercise_id='$exercise_id' order by rand()) as MT WHERE q.question_id = MT.question_id group by q.question_pick ORDER BY q.question_group ASC LIMIT $exercise_pull";				
							/*$query = mysqli_query($db, $sql);
							
							while($content=mysqli_fetch_object($query))
							
								$rand_q_id.=$content->question_id.', ';
							
							$rand_q_id=substr($rand_q_id, 0, -2);
							
							
							$sql = "select * from ".$db_suffix."question where question_id IN (".$rand_q_id.") ORDER BY question_group ASC";*/				
							$query = mysqli_query($db, $sql);
							
							while($content=mysqli_fetch_object($query))
							{
								$list_of_question_id[$i]=$content->question_id; $i++;
								
								$input_field_name="question_".$content->question_id."[]";									
								
								$question_desc    = $content->question_desc;
								
								$question_desc = str_replace('name="question"', 'name="'.$input_field_name.'"', $question_desc);
								
								$question_desc = str_replace('right-answer', '', $question_desc);
								
								echo '<div style="min-width:100%;" class="form-group well col-md-12 margin-bottom-10">';
								echo $question_desc.='<input type="hidden" value="" name="'.$input_field_name.'" />';
								
								echo '</div>';
							 
							 } 
							 
							 
							 ?>
                             <input type="hidden" name="time_spent" id="time_spent" value="asdf" />
                             <input type="hidden" name="list_question" value="<?php echo implode(",", $list_of_question_id);  ?>" />
                            
                            <div class="form-actions boxed">
                               <div class="col-md-offset-4 col-md-9">
                                  <button id="submitButtonID" type="submit" name="Submit" class="btn green">Eingabe prüfen</button>
                                  <button type="reset" class="btn default red">Alles löschen</button>                              
                               </div>
                        	</div>
                            
                            </form>
                            <?php } ?>
                        </div>
                    
                    
                        
                        <div class="col-md-3">
                        <?php if($sys_fucked_up==0) { ?>
                        	<div class="portlet box red-flamingo">
                                <div class="portlet-title">
                                  <div style="padding-left:25%;padding-right:25%;" class="caption timer">
                                  </div>
                                </div>
                            </div>
                        <?php } ?>
                        	<div class="portlet box yellow">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="glyphicon glyphicon-warning-sign"></i>Warnung
                                    </div>
                                    <!--<div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title="">
                                        </a>
                                    </div>-->
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                            <strong>Zeitlimit: <?php echo $duration; ?></strong>
                                            </p>
                                            
                                            <?php 
                                                                                
                                                $content_id=13;
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

<input type="hidden" value="<?php echo $exercise_duration-1; ?>" id="exe_dur">

<?php require_once('footer.php');	?>

<!--
<div class="modal fade" id="confirmation_halfway">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Achtung!</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Beeilung!</strong> Es bleiben noch <?php echo $duration_halfway?>.</span>         			
                  </div>
                  
               </div>
            </div>
         </div>
         
<div class="modal fade" id="confirmation_5_minutes">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Achtung!</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Beeilung!</strong> Es bleiben noch <?php echo $duration_last?>.</span>         			
                  </div>
                  
               </div>
            </div>
         </div>         

<div class="modal fade" id="confirmation_over">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Zeit abgelaufen</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Schade!</strong> Leider hat die Zeit nicht gereicht.</span>         			
                  </div>
                  
               </div>
            </div>
         </div>
-->
<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	

if($sys_fucked_up==0){
	
?>

<script>

	$(document).ready(function(){
    
    	  start = $.now();
		  
		  $( "#submitButtonID" ).click(function() {
               end = $.now();
               damn= end-start;
               $("#time_spent").val(Math.round(damn/1000));
            });

	    /*setTimeout(function(){

	        $('#confirmation_halfway').modal('show');
            
            }, <?php echo $exercise_duration_halfway*1000; ?>);
		
		setTimeout(function(){

	        $('#confirmation_halfway').modal('hide');
            
			}, <?php echo $exercise_duration_halfway*1000+(3*1000); ?>);	
			
		setTimeout(function(){

	        $('#confirmation_5_minutes').modal('show');
            
            }, <?php echo $exercise_duration_last*1000; ?>);	
		
		setTimeout(function(){

	        $('#confirmation_5_minutes').modal('hide');
            
            }, <?php echo $exercise_duration_last*1000+(3*1000); ?>);
			
		setTimeout(function(){

	        $('#confirmation_over').modal('show');
            
            }, <?php echo $exercise_duration*1000; ?>);	*/
		
		setTimeout(function(){

	       $('#form1 #submitButtonID').click();			

			}, <?php echo $exercise_duration*1000+(3*1000); ?>);	
		
	});
	
	window.setInterval(function(){
		
			var seconds=$("#exe_dur").val();
			
			$("#exe_dur").val(seconds-1);
			
			var text="";
			
			var second=0, minute=0, hour=0;
			
			hour = Math.floor(seconds/3600);
			minute = Math.floor((seconds/60) % 60);
			second = seconds % 60;
			
			if(hour>0)
			
				text=hour+" : ";
				
			else
			
				text="00 : ";	
				
			if(minute<10)
			
				minute="0"+minute;	
				
				
			if(minute>0)
			
				text+=minute+" : ";
				
			else
			
				text+="00 : ";
				
			if(second<10)
			
				second="0"+second;
			
			if(second>0)
			
				text+=second;
				
			else
			
				text+="00";	
			
			
			$(".timer").empty();
				  
			$(".timer").html('<i class="glyphicon glyphicon-time"></i><b>'+text+'</b>');
	
	}, 1000);
	
	
	/*$( "#submitButtonID" ).click(function() {
		
		   $(':text').each(function(){
			
			var text=$(this).val();
			
			text = text.replace("^1", "ä"); 
			
			text = text.replace("^2", "ö");
			
			text = text.replace("^3", "ü");
			
			text = text.replace("^4", "ß");
			
			text = text.replace("^5", "Ä");
			
			text = text.replace("^6", "Ö");
			
			text = text.replace("^7", "Ü");
			
			$(this).val(text);
		})
	});*/

	
	$(':text').keyup(function(){
		
		var text=$(this).val();
		
		var start = this.selectionStart,
        
		end = this.selectionEnd;
		
		text = text.replace("^1", "ä"); 
		
		text = text.replace("^2", "ö");
		
		text = text.replace("^3", "ü");
		
		text = text.replace("^4", "ß");
		
		text = text.replace("^5", "Ä");
		
		text = text.replace("^6", "Ö");
		
		text = text.replace("^7", "Ü");
		
		$(this).val(text);
		
		this.setSelectionRange(start, end);
	})
	

</script>

<?php } ?>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
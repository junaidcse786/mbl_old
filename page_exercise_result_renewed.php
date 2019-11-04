<?php 

require_once('config/dbconnect.php');

require_once('authentication.php');	

require_once('functions_exercise_related.php');

if(!isset($_SESSION["came_from_exercise_page"]))

	header('Location: '.SITE_URL);
		

$exercise_id = $_REQUEST["id"];

$content_id = $exercise_id;

$page_id='';

$exercise_title = $_REQUEST["title"];


$meta_desc='Ergebnis : '.$exercise_title;

$meta_title='Ergebnis : '.$exercise_title;

$meta_key='Ergebnis : '.$exercise_title;


$sql = "select exercise_title, exercise_desc, exercise_pull, exercise_duration from ".$db_suffix."exercise where exercise_id = $exercise_id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
$content     = mysqli_fetch_object($query);
$title    = $content->exercise_title;
$exercise_desc    = $content->exercise_desc;
$exercise_pull    = $content->exercise_pull;
$exercise_duration=  $content->exercise_duration;
}	

sscanf($exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);

$exercise_duration= $hours * 3600 + $minutes * 60 + $seconds;


$duration='';

if($hours!='00')
										  
	$duration.=$hours.' Stunde(n) ';

if($minutes!='00')

	$duration.=$minutes.' Minute(n) ';

if($seconds!='00')

	$duration.=$seconds.' Sekunde(n) ';


$alert_message=""; $alert_box_show="hide"; $alert_type="success";

if(1)
{
	$duration_taken='';
	$init = $_SESSION["time_spent"];
	$hours = floor($init / 3600);
	$minutes = floor(($init / 60) % 60);
	$seconds = $init % 60;
	
	if($hours!=0)
											  
		$duration_taken.=$hours.' Stunde(n) ';
	
	if($minutes!=0)
	
		$duration_taken.=$minutes.' Minute(n) ';
	
	if($seconds!=0)
	
		$duration_taken.=$seconds.' Sekunde(n) ';
	
	
	if($_REQUEST["value"]=='blank'){
		
		$alert_box_show="show";
		$alert_type="danger";
		$alert_message="Du hast weniger als die Hälfte der Fragen beantwortet. Daher wird die Aufgabe nicht ausgewertet.";	
	}
	else {
		
		if($_REQUEST["value"]<65){
		
			$alert_box_show="show";
			$alert_type="danger";
			
			//Leider hast du mit 45% das erforderliche Ergebnis von mindestens 80% nicht erreicht.
			
			$alert_message="Dein Ergebnis: <strong>".$_REQUEST["value"]."%</strong>. Leider hast du das erforderliche Ergebnis von mindestens <strong>65%</strong> verfehlt.";
			
			//$alert_message="Sorry. You have failed the exercise with a score of <strong>".$_REQUEST["value"]."%</strong> .";	
		}
		else if($_REQUEST["value"]>=65){
			
			$alert_box_show="show";
			$alert_type="success";
			$alert_message="Herzlichen Glückwunsch! Du hast die &Uuml;bung mit <strong>".$_REQUEST["value"]."%</strong> bestanden.";
			
			$alert_message.="<br /><br /> Zeit : <strong>".$duration_taken."</strong>";				
		}
		
		if($_SESSION["time_spent"]<$exercise_duration)
		
			$exercise_duration=$_SESSION["time_spent"];
			
		
		if(isset($_SESSION["came_from_exercise_page"]) && $_SESSION["came_from_exercise_page"]==1){
			
			$sql = "INSERT INTO ".$db_suffix."history SET exercise_id = $exercise_id, user_id='".$_SESSION["front_user_id"]."', percentage='".$_REQUEST["value"]."', time_taken='$exercise_duration'";				
			$query = mysqli_query($db, $sql);
			
			
			$sql = "select * from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["front_user_level"] ."' AND org_name='".$_SESSION["front_user_org_name"]."' AND me_status='1'";				
			$query = mysqli_query($db, $sql);
			$has_mandate=mysqli_num_rows($query);	
			
			$sql = "select pcd_id from ".$db_suffix."package_completion_date where user_id = '".$_SESSION["front_user_id"] ."'";				
			$query = mysqli_query($db, $sql);
			$has_completion=mysqli_num_rows($query);
			
			if($has_mandate>0 && $has_completion<=0){
									
				$sql = "select h.exercise_id, me.trial_times from ".$db_suffix."history h, ".$db_suffix."mandat_exe me where me.lang_level='".$_SESSION["front_user_level"]."' AND me.me_status='1' AND me.org_name='".$_SESSION["front_user_org_name"]."' AND  me.exercise_id=h.exercise_id AND h.user_id='".$_SESSION["front_user_id"]."' AND h.percentage>=me.percentage GROUP BY h.exercise_id HAVING COUNT(h.exercise_id) >=me.trial_times";
				
				$query = mysqli_query($db, $sql);
				$has_made=mysqli_num_rows($query);
				
				if($has_mandate==$has_made){
				
					$sql1 = "select pcd_id from ".$db_suffix."package_completion_date where user_id='".$_SESSION["front_user_id"]."'";
				
					$query1 = mysqli_query($db, $sql1);
					$already_made_it=mysqli_num_rows($query1);
					
					if($already_made_it<=0)
					
						mysqli_query($db, "INSERT INTO ".$db_suffix."package_completion_date SET user_id='".$_SESSION["front_user_id"] ."'");	
				}					 
			}	
		}
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
<title><?php echo 'Ergebnis : '.$title.' | '.SITE_NAME; ?></title>
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
                            <div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
                            <?php echo $alert_message; ?>
                          </div>
                          <?php if($_REQUEST["value"]!='blank') { ?>
                          
                          	<div class="form-actions boxed">
                               <div class="col-md-offset-3 col-md-12">
									
								<a title="&Uuml;bung Wiederholen" href="<?php echo SITE_URL.'exercise/'.$exercise_id.'/'.urlencode($exercise_title);?>" class="btn blue"> <i style="font-size: 17px;" class="fa fa-chevron-left"></i></a>
							   
                                  <button id="submitButtonID1" type="button" name="Submit" class="btn yellow">Antworten zeigen</button>
                                  
                                   <button id="submitButtonID" type="button" name="Submit" class="btn green">Lösungen zeigen</button>				   
								  
								   
								   <a title="Mein Konto / Mein Profil" href="<?php echo SITE_URL.'my-account/';?>" class="btn blue"> <i style="font-size: 17px;" class="fa fa-chevron-right"></i></a>
								   
                               </div>
                        	</div>
                            
                            <form id="form2" class="form-inline show" method="post">
                            
                            <?php
							
							//mysqli_query($db, "UPDATE ".$db_suffix."exercise SET exercise_hits=exercise_hits+1 where exercise_id = $exercise_id ");
							
							$session_question_list_rplacement = (empty($_SESSION["list_question"]))? "0" : $_SESSION["list_question"];
								
							$sql = "select * from ".$db_suffix."question where  exercise_id = $exercise_id AND question_id IN (".$session_question_list_rplacement.")";				
							$query = mysqli_query($db, $sql);
							
							while($content=mysqli_fetch_object($query))
							{
							    $input_field_name="question_".$content->question_id."[]";									
								
								$question_desc    = $content->question_desc;
								
								$question_desc = str_replace('name="question"', 'name="'.$input_field_name.'" disabled', $question_desc);
								
								$question_desc = str_replace('right-answer', '', $question_desc);
								
								$question_desc = str_replace('type="text"', 'type="text" bomb', $question_desc);
								$question_desc = str_replace('<select', '<select bomb', $question_desc);
								
								$question_desc = get_answer($question_desc, $_SESSION["question_".$content->question_id]);
								unset($_SESSION["question_".$content->question_id]);
								
								$_SESSION["question_".$content->question_id] = "";								
								
								//$question_desc = substr($question_desc,0,-4);
								
								$class='col-md-12'; $dummy_var3='<label class="label label-danger"></label>';
								$dummy_var8=' ';
								
								/*if(in_array($content->question_id, $_SESSION["question_got_wrong"]) || in_array($content->question_id, $_SESSION["question_got_wrong_case"]))
								
									$class='col-md-11';*/ 
									
								
								$damn_color=''; $class_if_answer_is_wrong="";
								if(in_array($content->question_id, $_SESSION["question_got_wrong"])){
								
									$damn_color='border: 1px solid #D91E18 !important;';
									$class_if_answer_is_wrong="contains-wrong-answer";
								}
								
								if(in_array($content->question_id, $_SESSION["question_got_wrong_case"]))
									$dummy_var3.='<span class="label badge-warning yellow">Groß- und Kleinschreibung</span>';	
									
								if(in_array($content->question_id, $_SESSION["question_got_wrong_punct"]))
								
									$dummy_var8.='<label class="label label-danger">Punctuation Error</label> ';	
									
								if(in_array($content->question_id, $_SESSION["question_got_wrong_structure"]))
								
									$dummy_var8.='<label class="label label-warning">Wrong Structure</label> ';		
									
								
								$question_desc.=$dummy_var3.' '.$dummy_var8;
								
								echo '<div style="min-width:100%; '.$damn_color.'" class="form-group well margin-bottom-10 '.$content->question_id.' '.$class_if_answer_is_wrong.'">';
								echo '<div class="row"><div class="'.$class.'">'.$question_desc.'</div>';
								
								/*if($class=='col-md-11')
								
								echo '<div class="col-md-1">								
								<button data-href="'.$content->question_id.'" data-toggle="modal" data-target="#confirmation" type="button" class="btn btn-xs red">Report</button>								
								</div>';*/
								
								echo '</div></div>';
							 
							 } 
							 
							 
							 ?>
                             
                            </form>
                            
                            
                            <form id="form1" class="form-inline hide" method="post">
                            
                            <?php
							$session_question_list_rplacement = (empty($_SESSION["list_question"]))? "0" : $_SESSION["list_question"];
							
							$sql = "select * from ".$db_suffix."question where  exercise_id = $exercise_id AND question_id IN (".$session_question_list_rplacement.")";				
							$query = mysqli_query($db, $sql);
							
							while($content=mysqli_fetch_object($query))
							{
								$input_field_name="correct_question_".$content->question_id."[]";									
								
								$question_desc    = $content->question_desc;
								
								$question_desc = str_replace('name="question"', 'name="'.$input_field_name.'"', $content->question_desc);
								
								$question_desc = str_replace('type="text"', 'type="text" bomb', $question_desc);
								
								$question_desc = str_replace('<select', '<select bomb', $question_desc);
								
								$question_desc = get_answer($question_desc, $content->question_answer, 1);
								//$question_desc = substr($question_desc,0,-4);
								
								$dummy_var3='<label class="label label-danger"></label>';
								
								$class='col-md-11'; 
									
								
								$damn_color='';
								if(in_array($content->question_id, $_SESSION["question_got_wrong"]))
									$damn_color='border: 1px solid #2C3E50 !important;';
								
								/*if(in_array($content->question_id, $_SESSION["question_got_wrong_case"]))
									$dummy_var3.='<span class="label badge-warning yello-gold">Capital/ Small Letter Mistake</span>';	*/
																		
								
								$question_desc.=$dummy_var3;
								
								echo '<div style="min-width:100%; '.$damn_color.'" class="form-group well margin-bottom-10">';
								echo '<div class="row"><div class="'.$class.'">'.$question_desc.'</div>';
								
								echo '<div class="col-md-1">								
								<button data-href="'.$content->question_id.'" data-toggle="modal" data-target="#confirmation" type="button" class="btn btn-xs red">Bericht</button>								
								</div>';
								
								echo '</div>';
								
								if($content->question_title!='')
																
									echo '<div class="row">
											<div class="col-md-12 margin-top-10">
												<div class="alert alert-info">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.$content->question_title.'
												</div>
											</div>								
										  </div>';
								
								echo'</div>';
							 
							 } 
							 
							 
							 ?>
                             
                            </form>
                            
                            
                            <div class="form-actions boxed">
                               <div class="col-md-offset-3 col-md-12">
								
									<a title="&Uuml;bung Wiederholen" href="<?php echo SITE_URL.'exercise/'.$exercise_id.'/'.urlencode($exercise_title);?>" class="btn blue"> <i style="font-size: 17px;" class="fa fa-chevron-left"></i></a>
							   
                                  <button id="submitButtonID3" type="button" name="Submit" class="btn yellow">Antworten zeigen</button>
                                  
                                   <button id="submitButtonID4" type="button" name="Submit" class="btn green">Lösungen zeigen</button>
								   
								   <a title="Mein Konto / Mein Profil" href="<?php echo SITE_URL.'my-account/';?>" class="btn blue"> <i style="font-size: 17px;" class="fa fa-chevron-right"></i></a>
								   
                               </div>
                        	</div>
                            
                            
                            
                            <?php } ?>
                        </div>
                    
                    
                        
                        <div class="col-md-3">
                        
                        	<div class="portlet box red-thunderbird">
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

<?php require_once('footer.php');	?>

<div class="modal fade" id="confirmation">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Bericht/Frage senden</h4>
                  </div>
                  <div class="modal-body">
                        <div class="form-body">
                        	<form action="javascript:;" class="form-horizontal" role="form">
                        	<div class="form-group">
                              		<label class="control-label col-md-3">Formuliere dein Anliegen: </label>
                              		<div class="col-md-9">
                                 		<textarea rows="4" class="form-control" name="message" id="message"></textarea>                                        
                                 	</div>
                           	  </div>
                        	</form>
                        </div>  			
                  </div>
                  <div class="modal-footer pull-center">
                        <button class="btn default" data-dismiss="modal" aria-hidden="true">Schließen</button>
                        <button id="delete_button" class="btn green" data-dismiss="modal">Senden</button>
                  </div>
                  
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
<input type="hidden" value="" id="qq_id" />
<input type="hidden" value="" id="qq_id_given_ans" />
<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	?>

<script>

$( "#submitButtonID1" ).click(function() {	
	
	if($( "#form1" ).hasClass( "show" ))
	
		$('#form1').toggleClass("hide show");
		
	$('#form2').toggleClass("hide show");	
});

$( "#submitButtonID" ).click(function() {	
	
	if($( "#form2" ).hasClass( "show" ))
	
		$('#form2').toggleClass("hide show");
			
	$('#form1').toggleClass("hide show");	
	
});

$( "#submitButtonID3" ).click(function() {	
	
	if($( "#form1" ).hasClass( "show" ))
	
		$('#form1').toggleClass("hide show");
		
	$('#form2').toggleClass("hide show");	
});

$( "#submitButtonID4" ).click(function() {	
	
	if($( "#form2" ).hasClass( "show" ))
	
		$('#form2').toggleClass("hide show");
			
	$('#form1').toggleClass("hide show");	
	
});

$(document).ready(function(){

	$('#confirmation').on('show.bs.modal', function(e) {
						 
		$('#qq_id').val($(e.relatedTarget).data('href')); 
		 
		var tag_field=$('#qq_id').val();
	
		answer=$('#form2').find($('.'+tag_field)).html();
		
		$('#qq_id_given_ans').val(answer);
	});
	
		 
	$('#delete_button').click(function() { 
	
	var message=$('#message').val();
	
	if(message!=''){
	
	var target = $('#qq_id').val();
	
	var given_answer = $('#qq_id_given_ans').val();
	
		$.ajax({
				   type: "POST",
				   url:  '<?php echo SITE_URL?>AJAX_report_issue_renewed.php',
				   dataType: "text",
				   data: {id: target, message: message, given_answer: given_answer},
				   success: function(data){ $('#message').val(''); alert("Dein Bericht wurde weitergeleitet");},
				  
		});
	}
	else{	
		alert("Dieses Feld muss ausgefüllt werden.");
	}
	});
});


</script>



<?php 

$_SESSION["came_from_exercise_page"]=''; 
unset($_SESSION["came_from_exercise_page"]); 

$_SESSION["came_from_exercise_page"]=''; 
$_SESSION["list_question"]=''; 
$_SESSION["time_spent"]=''; 
$_SESSION["question_got_wrong"]=''; 
$_SESSION["question_got_wrong_case"]=''; 
$_SESSION["question_got_wrong_punct"]='';
$_SESSION["question_got_wrong_structure"]='';
unset($_SESSION["came_from_exercise_page"]); 
unset($_SESSION["list_question"]); 
unset($_SESSION["time_spent"]); 
unset($_SESSION["question_got_wrong"]); 
unset($_SESSION["question_got_wrong_case"]); 
unset($_SESSION["question_got_wrong_punct"]);
unset($_SESSION["question_got_wrong_structure"]);


?>

<!-- END JAVASCRIPTS -->

<script>

$('.contains-wrong-answer').each(function() {
	
	var $new = $(this).find('input:checked');
	
	$new.parent().find('.img-border').addClass('wrong-answer');	
	
	console.log($(this).find('input:checked').val());
});

</script>
</body>
<!-- END BODY -->
</html>
<?php

require_once('config/dbconnect.php');

if(!isset($_SESSION["admin_panel"]) && !isset($_SESSION["user_id"])){

		$_SESSION["accessing_url"]=$_SERVER['REQUEST_URI'];

		header('Location: '.SITE_URL_ADMIN);
}
		

require_once('functions_exercise_related.php');


// color issue ; color for each question gruop

$colors = array ( "green-meadow", "blue-hoki", "yellow-crusta", "purple", "grey-gallery");

$sql_parent_menu = "SELECT DISTINCT question_group FROM ".$db_suffix."question where question_group!=''";	
$parent_query = mysqli_query($db, $sql_parent_menu);

$color_counter=0; $group_colors=array();

while($parent_obj = mysqli_fetch_object($parent_query))
	
	{
		if($color_counter>=count($colors))
			$color_counter=0;
		$group_colors[$parent_obj->question_group]=$colors[$color_counter];
		$color_counter++;
	}

// color issue END

$exercise_id = $_GET["id"];

$content_id = $exercise_id;

$page_id='exercise-page';


$sql = "select * from ".$db_suffix."exercise where exercise_id = $exercise_id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
$content     = mysqli_fetch_object($query);
$title    = $content->exercise_title;
$exe_dif    = $content->exercise_difficulty;
$exercise_desc    = $content->exercise_desc;
$exercise_pull    = $content->exercise_pull;
$exercise_duration=  $content->exercise_duration;

$fragen= $exercise_pull.' / '.mysqli_num_rows(mysqli_query($db, "select question_id from ".$db_suffix."question where exercise_id='$exercise_id'"));

$fragen.='<br />Individuelle Gruppen: '.mysqli_num_rows(mysqli_query($db, "select distinct question_pick from ".$db_suffix."question where exercise_id='$exercise_id'"));

$query= mysqli_query($db, "SELECT distinct question_group AS DIFF, (SELECT COUNT(question_id) FROM ".$db_suffix."question WHERE question_group=DIFF AND exercise_id='$exercise_id') AS DAMN FROM ".$db_suffix."question where exercise_id='$exercise_id'");
while($row     = mysqli_fetch_object($query))

	$fragen.='<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right"></i> '.$row->DIFF.': '.$row->DAMN;
		

sscanf($exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);

$exercise_duration= $hours * 3600 + $minutes * 60 + $seconds;


$duration='';

if($hours!='00')
										  
	$duration.=$hours.' Stunde(n) ';

if($minutes!='00')

	$duration.=$minutes.' Minute(n) ';

if($seconds!='00')

	$duration.=$seconds.' Sekunde(n) ';

}


$exercise_title = $title;


$meta_desc=$exercise_title;

$meta_title=$exercise_title;

$meta_key=$exercise_title;


$question_got_wrong=array();

$question_got_wrong_case=array();

$question_got_wrong_structure=array();

$question_got_wrong_punct=array();


if(isset($_POST["Submit"]))
{
	$final_marks=0; $num_q_fetched=0;
	
	$sql = "select * from ".$db_suffix."question where question_id IN (".$_POST["list_question"].")";				
	
	$query = mysqli_query($db, $sql);
	
	$answer_given_right=0; $partial_right=0;
	
								
	while($row=mysqli_fetch_object($query))
	{
		if($row->question_type=='Text'){
			
			$question_marks=0; $i=0;
		
			$question_real_marks=$row->question_marks;
			
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
			
				{ $question_marks-=$minus_mark; array_push($question_got_wrong_punct, $row->question_id);	}
			
			
			$count_given_answer_array=count(explode('.',$question_given_answer));
			
			if($count_correct_answer_array!=$count_given_answer_array){
				
				array_push($question_got_wrong_punct, $row->question_id);
			
				if($count_correct_answer_array>$count_given_answer_array)
				
					for($i=0;$i<$count_correct_answer_array-$count_given_answer_array;$i++)
					
						$question_given_answer.='.';						
			}
			
			$i=0;
			
			while($i<count($correct_answer_array))
			{	
				$num_q_fetched++;
				
				$given_answer_umlauts_added=explode('.', $question_given_answer)[$i];
				
				if(QUESTION_CASE_EVALUATE){				
					
					if(trim($given_answer_umlauts_added)==trim($correct_answer_array[$i]))
						
						$question_marks+=$minus_mark;
						
					else{
						
						if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0)
							array_push($question_got_wrong_case, $row->question_id);
							
						else if(wrong_sentence_structure(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))){	
						
							array_push($question_got_wrong_structure, $row->question_id);
							$question_marks+=$minus_mark/2;													
						}
					}
				}
				else{
				
					if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0)
							$question_marks+=$minus_mark;
							
					else if(wrong_sentence_structure(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))){	
						
							array_push($question_got_wrong_structure, $row->question_id);
							$question_marks+=$minus_mark/2;													
					}					
								
				}	
				
				$i++;	
			}
			
			if($question_marks<0)
				
				$question_marks=0;
			
			if($question_marks>$question_real_marks)
				
				$question_marks=$question_real_marks;
				
			if($question_marks==$question_real_marks)	
			
				$answer_given_right++;
				
			else if($question_marks>0 && $question_marks<$question_real_marks)	
			
				{ $partial_right++;	array_push($question_got_wrong, $row->question_id); }
				
			else if($question_marks==0)
			
				array_push($question_got_wrong, $row->question_id);	
				
			$final_marks+=$question_marks;
		}
		
		else{
			
			$question_marks=0; $i=0;
		
			$question_real_marks=$row->question_marks;
			
			$correct_answer_array=explode('+', $row->question_answer);
			
			$minus_mark=$question_real_marks/count($correct_answer_array);
			
			$given_answer_array=$_POST["question_".$row->question_id];
			
			while($i<count($correct_answer_array))
			{	
				$num_q_fetched++;
				
				$given_answer_umlauts_added=$given_answer_array[$i];
				
				if(QUESTION_CASE_EVALUATE){
				
					if(count(explode('=', trim($correct_answer_array[$i])))>1)
					{
						if(in_array(trim($given_answer_umlauts_added), array_map('trim', explode('=', $correct_answer_array[$i]))))
							$question_marks+=$minus_mark;
							
						else if(in_array(trim(strtolower($given_answer_umlauts_added)), array_map('trim', explode('=', strtolower($correct_answer_array[$i])))))
							array_push($question_got_wrong_case, $row->question_id);		
					}
					else{
						if(trim($given_answer_umlauts_added)==trim($correct_answer_array[$i]))
							
							$question_marks+=$minus_mark;
							
						else if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0)
							array_push($question_got_wrong_case, $row->question_id);	
					}
				}
				else{
				
					if(count(explode('=', trim($correct_answer_array[$i])))>1)
					{
						foreach(explode('=', trim($correct_answer_array[$i])) as $note)
							{
								if(strcasecmp(trim($given_answer_umlauts_added), trim($note))== 0)
									
									 { $question_marks+=$minus_mark; break;	}
							}
					}
					else
					{
						if(strcasecmp(trim($given_answer_umlauts_added), trim($correct_answer_array[$i]))== 0)
							$question_marks+=$minus_mark;
					}
				}	
				
				$i++;	
			}
			
			if($question_marks>$question_real_marks)
				
				$question_marks=$question_real_marks;
				
			if($question_marks==$question_real_marks)	
			
				$answer_given_right++;
				
			else if($question_marks>0 && $question_marks<$question_real_marks)	
			
				{ $partial_right++;	array_push($question_got_wrong, $row->question_id); }
				
			else if($question_marks==0)
			
				array_push($question_got_wrong, $row->question_id);	
				
			$final_marks+=$question_marks;
		}		
	}
	
	$final_marks=($final_marks*100)/$num_q_fetched;
	
	echo '<pre>Ergebnis : '.round($final_marks,2).'%</pre>';
	
	echo '<pre>'.$answer_given_right.' von '.mysqli_num_rows($query).' Frage(n) waren richtig.</pre>';
	
	if($partial_right!=0)
	
		echo '<pre>'.$partial_right.' Frage(n) waren nur teilweise richtig.</pre>';
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
							
							echo $exercise_desc;
								
							?>
                            
                            <form id="form1" action="" class="form-inline" method="post">
                            
                            <?php
							
							$where='';
							
							if(isset($_GET["q_id"]))
							
								$where=" AND question_id IN (".$_GET["q_id"].")";
							
							$list_of_question_id=array(); $i=0; 
							
							$sql = "select * from ".$db_suffix."question where exercise_id = $exercise_id $where ORDER BY question_pick ASC";				
							$query = mysqli_query($db, $sql);
							
							while($content=mysqli_fetch_object($query))
							{
								$list_of_question_id[$i]=$content->question_id; $i++;
								
								$input_field_name="question_".$content->question_id."[]";									
								
								$question_desc    = $content->question_desc;
								
								$question_desc = str_replace('name="question"', 'name="'.$input_field_name.'"', $content->question_desc);
								
								$question_desc = str_replace('type="text"', 'type="text" bomb', $question_desc);
								$question_desc = str_replace('<select', '<select bomb', $question_desc);
								$question_desc = get_answer($question_desc, $content->question_answer);
								
								$dummy_var8='';$dummy_var3=''; $style='';
								
								
								$dummy_var8='<label class="label bg-'.$group_colors[$content->question_group].'">'.$content->question_marks.'</label> <label class="label bg-'.$group_colors[$content->question_group].'">'.$content->question_group.'</label> <label class="label bg-purple">'.$content->question_pick.'</label> ';
								
								if($content->question_case==0)
								
									$dummy_var8.='<label class="label label-danger">NOT CS</label> ';
									
								if(in_array($content->question_id,$question_got_wrong_punct))
								
									$dummy_var8.='<label class="label label-danger">Punctuation Error</label> ';	
								
								
								if(in_array($content->question_id,$question_got_wrong))
								
									$style='border: 1px solid #D91E18 !important;';
									
								
								if(in_array($content->question_id,$question_got_wrong_case))
								
									$dummy_var3='<span class="badge badge-warning">Capital-Small Letter Mistake</span>';
								
								if(in_array($content->question_id,$question_got_wrong_structure))
								
									$dummy_var3=' <span class="badge badge-warning">Wrong Structure</span>';	
								
								echo '<div style="min-width:100%; '.$style.'" class="form-group well margin-bottom-10">';
								echo '<div class="row"><div class="col-md-10">'.$question_desc.'<input type="hidden" value="" name="'.$input_field_name.'" />';
								
								echo ' '.$dummy_var3.' '.$dummy_var8.'</div>';
								
								$dummy_var1='';$dummy_var2=''; 
								
								
								if($_SESSION["role_id"]==15)
								{
									$dummy_var1=' href="#" data-href="'.$content->question_id.'" data-toggle="modal" data-target="#confirmation"';
									$dummy_var2='Bericht';
								}
								
								if($_SESSION["role_id"]==8)
								{
									$dummy_var1=' target="_blank" href="'.SITE_URL_ADMIN.'?mKey=exercise&pKey=editquestion&id='.$content->question_id.'"';
									$dummy_var2='Bearbeiten';
								}
								
								echo '<div class="col-md-2">								
								<a '.$dummy_var1.' class="btn btn-md red">'.$dummy_var2.'</a>								
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
																
								echo '</div>';
							 
							 } 
							 
							 
							 ?>
                             
                             <input type="hidden" name="list_question" value="<?php echo implode(",", $list_of_question_id);  ?>" />
                            
                            <div class="form-actions boxed">
                               <div class="col-md-offset-4 col-md-9">
                                  <button id="submitButtonID" type="submit" name="Submit" class="btn green">Eingabe prüfen</button>
                                  <button type="reset" class="btn default red">Alles löschen</button>                              
                               </div>
                        	</div>
                            
                            </form>
                            
                        </div>
                    
                    
                        
                        <div class="col-md-3">
                        
                            <div class="portlet box blue-hoki">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="glyphicon glyphicon-pushpin"></i>Info
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title="">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>
                                            Zeitlimit: <?php echo $duration; ?>
                                            <br /><br />Stufe: <?php echo $exe_dif; ?>
                                            <br /><br />Fragen: <?php echo $fragen; ?>                                            </strong> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 <?php if($_SESSION["role_id"]!=8) echo 'hide'; ?>">                        
                            <div class="portlet box yellow-lemon">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="glyphicon glyphicon-pushpin"></i>Suchen nach Fragen
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title="">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form class="search-form" action="<?php echo SITE_URL.'search-questions'; ?>" method="GET">
                                                <div class="input-icon">
                                                    <i class="icon-magnifier"></i>
                                                    <input name="keyword" type="text" class="form-control" placeholder="Keyword">
                                                </div>
                                                <!--<span class="help-block">Search the questions in the question description using a keyword</span>-->
                                            </form> 
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

<div class="page-footer">
	<div class="container">
		 <?php echo FOOTER_TEXT; ?>
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>

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


<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	?>

<script>

$(document).ready(function(){

	    $('#confirmation').on('show.bs.modal', function(e) {
					 
		$('#qq_id').val($(e.relatedTarget).data('href')); 
		});

			 
		$('#delete_button').click(function() { 

		var message=$('#message').val();

		var target = $('#qq_id').val();

			$.ajax({
					   type: "POST",
					   url:  '<?php echo SITE_URL?>AJAX_report_issue_teacher.php',
					   dataType: "text",
					   data: {id: target, message: message},
					   success: function(data){ $('#message').val(''); alert("Dein Bericht wurde weitergeleitet");},
					  
			});
		});
	});
	
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

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
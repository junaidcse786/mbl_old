<?php

require_once('config/dbconnect.php');

if(!isset($_SESSION["admin_panel"]) && $_SESSION["user_id"]=!8)

		header('Location: '.SITE_URL_ADMIN);
		

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

$exercise_id = 0;

$content_id = $exercise_id;

$page_id='exercise-page';


$title="Gefundene Fragen";



$meta_desc=$title;

$meta_title=$title;

$meta_key=$title;


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
				<h1><strong><?php echo $title; ?></strong><small></small></h1>
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
                    
                    
                    <div class="col-md-12">
                            
                            <form id="form1" action="" class="form-inline" method="post">
                            
                            <?php
							
							if($_GET["keyword"]!='')
							
								$where="(question_desc like '%".$_GET["keyword"]."%' OR question_pick like '%".$_GET["keyword"]."%')";
								
							else
							
								$where="question_desc like '%asdf%'";	
							
							
							$list_of_question_id=array(); $i=0; 
							
							$sql = "select * from ".$db_suffix."question q
							LEFT JOIN ".$db_suffix."exercise e ON e.exercise_id=q.exercise_id WHERE 1 AND $where ORDER BY exercise_title ASC";				
							$query = mysqli_query($db, $sql);
							
							while($content=mysqli_fetch_object($query))
							{
								$list_of_question_id[$i]=$content->question_id; $i++;
								
								$input_field_name="question_".$content->question_id."[]";									
								
								$question_desc    = $content->question_desc;
								
								$question_desc = str_replace('name="question"', 'name="'.$input_field_name.'"', $content->question_desc);
								
								$question_desc = str_replace('type="text"', 'type="text" bomb', $question_desc);
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
								
								//$question_desc = str_replace( $_GET["keyword"], '<b class="font-red">'.$_GET["keyword"].'</b>', $question_desc);
								
								echo '<div style="min-width:100%; '.$style.'" class="form-group well margin-bottom-10">';
								echo '<div class="row"><div class="col-md-10"><p><strong>&Uuml;bung: '.$content->exercise_title.'</strong></p>'.$question_desc.'<input type="hidden" value="" name="'.$input_field_name.'" />';
								
								echo ' '.$dummy_var3.' '.$dummy_var8.'</div>';
								
								$dummy_var1='';$dummy_var2=''; 
								
								
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
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
													<strong>Diskussion zu dieser Frage : </strong>
												'.$content->question_title.'
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

<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	?>

<script>
	
	$( "#submitButtonID" ).click(function() {
		
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
	});

	
	$(':text').blur(function(){
		
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

</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
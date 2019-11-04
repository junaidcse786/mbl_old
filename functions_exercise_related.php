<?php 

function wrong_sentence_structure($a, $b)
{
	$a = strtolower($a);
	$b = strtolower($b);
		
	$words = explode(" ", $a);
	$result = array_combine($words, array_fill(0, count($words), 0));
	
	foreach($words as $word) {
		$result[$word]++;
	}
	
	arsort($result);
	
	$words1 = explode(" ", $b);
	$result1 = array_combine($words1, array_fill(0, count($words1), 0));
	
	foreach($words1 as $word) {
		$result1[$word]++;
	}
	
	arsort($result1);
	
	if(count($result)==count($result1)){
	
		foreach($result as $word => $count) {
			
			if(array_key_exists($word,$result1)){
			
				if($result1[$word]!=$count)
					
					return 0;}	
			else
			
				return 0;		
		}
		
		return 1;
	}
	else
	
		return 0;	
}	

function str_replace_limit($search, $replace, $string, $limit = 1) {
  if (is_bool($pos = (strpos($string, $search))))
    return $string;

  $search_len = strlen($search);

  for ($i = 0; $i < $limit; $i++) {
    $string = substr_replace($string, $replace, $pos, $search_len);

    if (is_bool($pos = (strpos($string, $search))))
      break;
  }
  return $string;
}

function get_answer($string, $answer, $text_only=0){

	$answer_exploded=explode('+', $answer);
	
	$string=str_replace('selected="selected"','',$string);
	
	$string=str_replace('checked="checked"','',$string);
	
	$damn=explode(' ', $string);
	
	$all_index=array(); $kall=0;
	
	
	$type='<textarea'; $ta_index=array(); $kta=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if(stripos($damn[$i],$type)!== false)
		
			{ $ta_index[$kta]=$i;	$kta++; $all_index[$kall]=$i;	$kall++;}
	}
	
	
	$type='type="text"'; $tf_index=array(); $ktf=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if($damn[$i]==$type)
		
			{ $tf_index[$ktf]=$i;	$ktf++; $all_index[$kall]=$i;	$kall++;}
	}
	
	
	$type='type="radio"'; $rf_index=array(); $krf=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if($damn[$i]==$type)
		
			{ $rf_index[$krf]=$i;	$krf++; $all_index[$kall]=$i;	$kall++;}
	}
	
	
	$type='<select'; $s_index=array(); $ks=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if(strpos($damn[$i],$type)!== false)
		
			{ $s_index[$ks]=$i;	$ks++; $all_index[$kall]=$i;	$kall++;}
	}
	
	sort($all_index, SORT_NUMERIC);
	
	$field_array=array(); $ff=0;
	
	foreach($all_index as $value)
	{
		if(in_array($value, $ta_index))
			
			$field_array[$ff]="textarea";
		
		if(in_array($value, $tf_index))
			
			$field_array[$ff]="text";
			
		if(in_array($value, $rf_index))
			
			$field_array[$ff]="radio";	
			
		if(in_array($value, $s_index))
			
			$field_array[$ff]="select";	
		
		$ff++;		
	}
	$field_array[$ff]="tt";
	
	//print_r($field_array);
	
	$futter=0;
	
	for($i=1;$i<count($field_array);$i++)
	{
		$dummy_data=$field_array[$i-1];
		
		$style_text="";
		
		if(count(explode('>786>',$answer_exploded[$futter]))>1){
		
			$answer_answer_trunc=explode('>786>',$answer_exploded[$futter])[0];
			$right_or_wrong=explode('>786>',$answer_exploded[$futter])[1];
			$answer_answer=trim(explode('=',$answer_answer_trunc)[0]);
		}
		else{
			$right_or_wrong="";
			$answer_answer=trim(explode('=',$answer_exploded[$futter])[0]);
		}
						
		if(($dummy_data=='radio') && $dummy_data!=$field_array[$i])
			{
				$string=str_replace_limit('type="radio" value="'.$answer_answer.'" />', 'type="radio" checked="checked" value="'.$answer_answer.'" />', $string, 1);
				
				$futter++;
			}
		else if($dummy_data=='text'){
			
				if($text_only==1)
				
					$answer_answer=str_replace("=", "/", $answer_exploded[$futter]);	
			
				$strpos1=strpos($string, 'type="text" bomb');
				
				$strpos2=strpos(substr($string,$strpos1),' />');
				
				$string_to_go=substr($string, $strpos1, $strpos2+3);
				
				if($right_or_wrong=='0')
					
					$style_text='style="border: 1px solid red;" ';
				
				$string_to_replace=$style_text.'type="text" value="'.$answer_answer.'" />';
				
				$string=str_replace_limit($string_to_go, $string_to_replace, $string, 1);
				
				$futter++;
		}
		else if($dummy_data=='select'){
			
				$strpos1=strpos($string, '<select bomb');
				$strpos2=strpos(substr($string,$strpos1),'</select>');				
				
				$string_to_go=substr($string, $strpos1, $strpos2+9);
				
				$string_to_replace=str_replace('<option value="'.$answer_answer.'">', '<option selected="selected" value="'.$answer_answer.'">', $string_to_go);
				
				$string=str_replace_limit($string_to_go, $string_to_replace, $string, 1);				
				
				if($right_or_wrong=='0')
					
					$style_text=' style="border: 1px solid red;" ';				
				
				$string=str_replace_limit('<select bomb', '<select'.$style_text, $string, 1);
					
				$futter++;					
		
		}
		else if($dummy_data=='textarea'){
			
				$string=str_replace_limit('></textarea>', '>'.$answer_answer.'</textarea>', $string, 1);
				$futter++;					
		}
		
		$dummy_data=$field_array[$i];	
	}
	
	return $string;
}


if(isset($_SESSION["user_panel"])){

	$ts_config_user_level= $_SESSION["front_user_level"];
	
	$ts_config_org_name= $_SESSION["front_user_org_name"];
}
	
else if	(isset($_SESSION["admin_panel"])){

	$ts_config_user_level= $_SESSION["user_level"];
	
	$ts_config_org_name= $_SESSION["user_org_name"];
}

$QUESTION_CASE=1;
$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$ts_config_user_level."' AND ts_org_name='".$ts_config_org_name."' AND ts_config_name='QUESTION_CASE'";				
$query = mysqli_query($db, $sql);
$has_a_QUESTION_CASE=mysqli_num_rows($query);	
if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$QUESTION_CASE = $content->ts_config_value;
}
define('QUESTION_CASE_EVALUATE', $QUESTION_CASE);

?>
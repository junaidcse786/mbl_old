<?php 
	
require_once('config/dbconnect.php');	

$content_id = '';
$page_id='hangman';

	$title    = 'Galgenmännchen';
	$subtitle    = '';
	
	
	$meta_title  = 'Galgenmännchen';
	$meta_key    = 'Galgenmännchen';
	$meta_desc    = 'Galgenmännchen';
	
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

	                <div class="row">
		                <div class="col-md-6">
		                	<div class="row">							
								<div class="col-md-12  margin-bottom-15">
								
									<div class="well"><h1 class="text-center bold" id="ratefeld"></h1></div>
									
								</div>
		                    
		                    </div>
							
							<div class="clearfix"></div>
							
							<div class="row margin-bottom-15">
							
								<div class="col-md-12 col-md-offset-3">
								
									
									<form name="rateformular">
									
									<div class="form-body">
										
										<div class="form-group">
										
										<div class="input-group margin-bottom-15">
											<div class="input-group-btn">
												<button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Umlaute <i class="fa fa-angle-down"></i></button>
												<ul class="dropdown-menu">
													<li class="auml">
														<a href="javascript:;">
														&auml; </a>
													</li>
													<li class="ouml">
														<a href="javascript:;">
														&ouml; </a>
													</li>
													<li class="uuml">
														<a href="javascript:;">
														&uuml; </a>
													</li>
													<li class="suml">
														<a href="javascript:;">
														&szlig; </a>
													</li>
												</ul>
											</div>
											<!-- /btn-group -->	
											<input autocomplete="off" name="ratezeichen" type="text" maxlength="1" class="form-control input-small damn">			
										</div>
										
										
										<input class="btn btn-default green col-md-offset-2" name="ratebutton" type="submit" value="Prüfen">
										
										</div>
									
									</div>
									
									</form>
									
								</div>
		                    
		                    </div>
							
							<div class="clearfix"></div>
							
							<div class="row">
							
								<div class="col-md-12">
								
									<div class="alert alert-info"><p><b>Oberbegriff: </b><span class="hints"></span></p></div>
									
								</div>
		                    
		                    </div>
							
							<div class="clearfix"></div>
							
							<div class="row">
							
								<div class="col-md-12">
								
									<div class="alert alert-danger bold"><p id="gerateneBuchstaben">Falsche Antworten:</p></div>
									
								</div>
		                    
		                    </div>
						</div>
							<!-- <div class="clearfix"></div> -->
							
						<div class="col-md-6">
							<div class="row">
							
								<div class="col-md-5 col-md-offset-5 well">
								
									<img class="img-responsive" src="<?php echo SITE_URL; ?>hangman_source/hangman0.png" id="hangman">
									
								</div>
		                    
		                    </div>
							
							<div class="clearfix"></div>
							
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-3  col-md-offset-5">
										<div class="alert alert-info bold"><p class="text-center">Punkte</p></div>
									</div>
									<div class="col-md-2">
										<div class="alert alert-info bold"><p id="value" class="text-center points">0</p></div>
									</div>
								</div>
		               		 </div>   
							</div>

							<div class="row">
								<div class="col-md-6 col-md-offset-5">
									<div class="actions">								
										<input class="btn btn-default red" name="refresh" type="button" value="Neu starten" onClick="location.reload()">									
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

<!-- END FOOTER -->

<div class="modal fade" id="dead">
	<div class="modal-dialog">
	   <div class="modal-content">
		  <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			 <h4 class="modal-title font-red">Achtung</h4>
		  </div>
		  <div class="modal-body">
				<div class="alert alert-danger">Lassen Sie sich nicht so h&auml;ngen! Versuchen Sie es gleich noch einmal!</div>         			
		  </div>
		  
	   </div>
	   <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
 </div>
 
 <div class="modal fade" id="success">
	<div class="modal-dialog">
	   <div class="modal-content">
		  <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			 <h4 class="modal-title font-green">Achtung</h4>
		  </div>
		  <div class="modal-body">
				<div class="alert alert-success"><strong>Gut gemacht!</strong> Jetzt kommt das nächste Wort.</div>         			
		  </div>
		  
	   </div>
	   <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
 </div>


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	
$w_h="";
$sql = "SELECT * FROM ".$db_suffix."hangman WHERE h_status='1' ORDER BY h_id DESC";
$news_query = mysqli_query($db,$sql);
while($row = mysqli_fetch_object($news_query))
{
	foreach(explode(',', $row->h_words) as $value)
	{
		//;
		if($value!="")
		
			$w_h.='"'.trim($value).':'.$row->h_topic.'",';
	}	
}

?>

<script>

$("form").submit(function(e){
	
	e.preventDefault();
	
	if($('.damn').val()!="" || $('.damn').val()!=" ")
		
		pruefeZeichen();
});

$('.auml').click(function(){
	
	$('.damn').val("ä");
});

$('.uuml').click(function(){
		
	$('.damn').val("ü");
});

$('.ouml').click(function(){
		
	$('.damn').val("ö");
});

$('.suml').click(function(){
		
	$('.damn').val("ß");
});

var lsgwoerter = [
  <?php echo $w_h; ?> 
];

</script>

<script src="<?php echo SITE_URL; ?>hangman_source/hangman.js" type="text/javascript"></script>

<!-- END JAVASCRIPTS -->

<input class="SITE_URL" type="hidden" value="<?php echo SITE_URL; ?>">

</body>
<!-- END BODY -->
</html>

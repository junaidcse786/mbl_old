<?php 
	
require_once('config/dbconnect.php');	

$content_id = 1;
$page_id=$content_id;

$sql = "select * from ".$db_suffix."content where content_id = $content_id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$title    = $content->content_title;
	$subtitle    = $content->content_sub_title;
	$description = $content->content_desc;
	
	$meta_title  = $content->content_meta_title;
	$meta_key    = $content->content_meta_keywords;
	$meta_desc    = $content->content_meta_desc;
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
				<h1><?php echo 'Feedback <small>'.$subtitle.'</small>' ?></h1>
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
                    
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfUuHHuMuR7DifdZe6vc7ItOUI2On7Mvx3EoOgX6geyNG0bXw/viewform?embedded=true"  height="1500" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
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

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
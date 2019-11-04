<?php 
	
require_once('config/dbconnect.php');

$page_id = "faq";
$content_id = $page_id;
$title = "Hilfe"; 
$subtitle = "FAQ";
$meta_desc = $page_id;
$meta_title = $page_id;
$meta_key = $page_id;

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
<div class="page-content" style="min-height: 300px;">
<div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="portlet light">
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-3">
                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                        <li class="active">
                            <a data-toggle="tab" href="#tab_1">
                            <i class="fa fa-sign-in"></i> Sign up and Sign in </a>
                            <span class="after">
                            </span>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tab_2">
                            <i class="fa fa-graduation-cap"></i> Exercise </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tab_3">
                            <i class="fa fa-leaf"></i> Terms Of usage </a>
                        </li>								
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div id="tab_1" class="tab-pane active">
                            <div id="accordion1" class="panel-group">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1">
                                        1. What is the code? Is that the password that I should use?</a>
                                        </h4>
                                    </div>
                                    <div id="accordion1_1" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-7 text-justify">
                                                The registration code is what your teacher has given you for the purpose of registration. Without that code, you will not be able to register. The code works for only once. Put the code in the red field and your desired password at the blue field. Also do not forget to confirm your password.
                                                </div>	
                                                <div class="col-md-5">
                                                <a href="<?php echo SITE_URL.'images/help_page/sign_up.jpg'; ?>"><img height="50" class="img-responsive" src="<?php echo SITE_URL.'images/help_page/sign_up.jpg'; ?>" /></a>
                                                </div>													
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_2">
                                        2. What is "Online time" and "Learning time"?</a>
                                        </h4>
                                    </div>
                                    <div id="accordion1_2" class="panel-collapse collapse">
                                        <div class="panel-body text-justify">
                                            <strong>Online time</strong> refers to the amount of time you have spent on the system in the state of logged in. <strong>Learning time</strong> is the time you have used doing exercises. <strong>Learning time</strong> is simply the toal amount of time spent for all the exercises you have done online.
                                        </div>
                                    </div>
                                </div>                         
                            </div>
                        </div>
                        <div id="tab_2" class="tab-pane">
                            <div id="accordion2" class="panel-group">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_1">
                                        1. Dummy qustion 1 ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion2_1" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <p>
                                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </p>
                                            <p>
                                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_2">
                                        2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion2_2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_3">
                                        3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion2_3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_4">
                                        4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion2_4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_5">
                                        5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion2_5" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_6">
                                        6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion2_6" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_7">
                                        7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion2_7" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab_3" class="tab-pane">
                            <div id="accordion3" class="panel-group">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_1">
                                        1. Dummy qustion 3 ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion3_1" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <p>
                                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                            </p>
                                            <p>
                                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
                                            </p>
                                            <p>
                                                 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_2">
                                        2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion3_2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_3">
                                        3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion3_3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_4">
                                        4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion3_4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_5">
                                        5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion3_5" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_6">
                                        6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion3_6" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_7">
                                        7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
                                        </h4>
                                    </div>
                                    <div id="accordion3_7" class="panel-collapse collapse">
                                        <div class="panel-body">
                                             3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
                                        </div>
                                    </div>
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

<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php');	?>



<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

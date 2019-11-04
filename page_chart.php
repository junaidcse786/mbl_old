<?php 

require_once('config/dbconnect.php');

require_once('authentication.php');	


$exercise_id = $_GET["exercise_id"];

$content_id = $exercise_id;

$page_id='';

$exercise_title = $_REQUEST["exercise_title"];

$title=$exercise_title;



$meta_desc='Leistungsdiagramm : '.$exercise_title;

$meta_title='Leistungsdiagramm : '.$exercise_title;

$meta_key='Leistungsdiagramm : '.$exercise_title;



$sql = "SELECT percentage FROM ".$db_suffix."history where user_id='".$_SESSION["front_user_id"]."' AND exercise_id='$exercise_id' ORDER BY date_taken ASC";
$news_query = mysqli_query($db,$sql);

$chart_info='';
$perv_val='';
$i=1;
while($row = mysqli_fetch_object($news_query)){

	$chart_info.="['Versuch-".$i."', ".$row->percentage."], "; 
	
	$i++;		
}
	
$chart_info=substr($chart_info,0,-2);	
											

	
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
				<h1><?php echo $title; ?><small> Leistungsdiagramm </small></h1>
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
                        	<div class="portlet solid grey-cararra bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa-bar-chart-o"></i>Leistungsdiagramm 
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="site_activities_loading">
                                        <img src="<?php echo SITE_URL_ADMIN; ?>assets/admin/layout/img/loading.gif" alt="loading"/>
                                    </div>
                                    <div id="site_activities_content" class="display-none">
                                        <div id="site_activities" style="height: 250px;">
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
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->

<?php require_once('footer.php');	?>

<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php require_once('scripts.php'); ?>


<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>


<script>
		jQuery(document).ready(function() { 
		
			function showChartTooltip(x, y, xValue, yValue) {
                $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff'
                }).appendTo("body").fadeIn(200);
            }
			
			if ($('#site_activities').size() != 0) {
                //site activities
                var previousPoint2 = null;
                $('#site_activities_loading').hide();
                $('#site_activities_content').show();

                var data1 = [<?php echo $chart_info; ?>];


                var plot_statistics = $.plot($("#site_activities"),

                    [{
                        data: data1,
                        lines: {
                            fill: 0.2,
                            lineWidth: 0,
                        },
                        color: ['#BAD9F5']
                    }, {
                        data: data1,
                        points: {
                            show: true,
                            fill: true,
                            radius: 4,
                            fillColor: "#9ACAE6",
                            lineWidth: 2
                        },
                        color: '#9ACAE6',
                        shadowSize: 1
                    }, {
                        data: data1,
                        lines: {
                            show: true,
                            fill: false,
                            lineWidth: 3
                        },
                        color: '#9ACAE6',
                        shadowSize: 0
                    }],

                    {
						xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

                $("#site_activities").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + '%');
                        }
                    }
                });

                $('#site_activities').bind("mouseleave", function () {
                    $("#tooltip").remove();
                });
            }
			
						   	   
		});				
		
</script>



<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$id = isset($_REQUEST['id']) ? $_REQUEST['id']: 0;
$sql = "select * from ".$db_suffix."hangman where h_id = $id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	
	$h_topic       = $content->h_topic;
	$h_words    = $content->h_words;
	$h_status    = $content->h_status;
}

$err=0;

$messages = array(
					'h_topic' => array('status' => '', 'msg' => ''),
					'h_words' => array('status' => '', 'msg' => ''),
					'h_status' => array('status' => '', 'msg' => ''),
					
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($h_words))
	{
		$messages["h_words"]["status"]=$err_easy;
		$messages["h_words"]["msg"]="At least one word is Required";
		$err++;		
	}
	
	if(empty($h_topic))
	{
		$messages["h_topic"]["status"]=$err_easy;
		$messages["h_topic"]["msg"]="Topic is Required";
		$err++;		
	}
	
	
	if($err == 0)
	{
		$today = date('y-m-d');
	
		$sql = "UPDATE ".$db_suffix."hangman SET h_words='$h_words', h_topic='$h_topic', h_status='$h_status' WHERE h_id='$id'";
		if(mysqli_query($db,$sql))
		{		
			$alert_message="Data inserted successfully";		
			$alert_box_show="show";
			$alert_type="success";	
			
		}else{
			$alert_box_show="show";
			$alert_type="danger";
			$alert_message="Database encountered some error while inserting.";
		}
	}
	else
	{
		$alert_box_show="show";
		$alert_type="danger";
		$alert_message="Please correct these errors.";
		
	}
}

if(!isset($_POST["Submit"]) && isset($_GET["s_factor"]))
{
	$alert_message="Data inserted successfully";		
	$alert_box_show="show";
	$alert_type="success";
}


?>

<!-----PAGE LEVEL CSS BEGIN--->

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Update Topic <small>Update the superterm and the subterms</small>
                                        </h3>
                                        <div class="page-bar">         
                                        <ul class="page-breadcrumb">
                                                <li>
                                                        <i class="fa fa-home"></i>
                                                        <a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <i class="<?php echo $active_module_icon; ?>"></i>
                                                        <a href="#"><?php echo $active_module_name; ?></a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey=hangman&pKey=hangman_topic'; ?>">Topic List</a>
														<i class="fa fa-angle-right"></i>
                                                </li>
												<li>
                                                        <a  href="#">Update Topic ID: <?php echo $id; ?></a>
                                                </li>
                                        </ul>
                                        <!-- END PAGE TITLE & BREADCRUMB-->
                                </div>
                        <!-- END PAGE HEADER-->
                        
                        
   <!--------------------------BEGIN PAGE CONTENT------------------------->
                                              
                        <div class="row">
            <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-reorder"></i>You have to fill the fields marked with <strong>*</strong></div>
                  </div>
                  <div class="portlet-body form">
                  
                      <div class="form-body">
                      
                          <div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo $alert_message; ?>
                          </div>
                               
                               <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                               
                              
                              <div class="form-group <?php echo $messages["h_topic"]["status"] ?>">
                              		<label class="control-label col-md-3" for="h_topic">Topic name <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="h_topic" value="<?php echo $h_topic;?>"/>
                                 		<span for="h_topic" class="help-block">This will be shown as hint in the hangman page<br /><?php echo $messages["h_topic"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-body <?php echo $messages["h_words"]["status"] ?>">
									<div class="form-group">
										<label class="control-label col-md-3">Words <span class="required">*</span></label>
										<div class="col-md-9">
											<textarea class="ckeditor form-control" name="h_words" rows="6"><?php echo str_replace('\\','',$h_words); ?></textarea>
                                            <span for="h_words" class="help-block">Seperate the words using comma (spaces are allowed)<br /><?php echo $messages["h_words"]["msg"] ?></span>
										</div>
									</div>
							 </div>
                             
                             <div class="form-group last">
                                  <label for="h_status" class="control-label col-md-3">Status</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="h_status">
                                        <option <?php if($h_status==1) echo 'selected="selected"'; ?> value="1">Active</option>
                                        <option <?php if($h_status==0) echo 'selected="selected"'; ?> value="0">InActive</option>
                                     </select>
                                  </div>
                              </div>
                            
                            <div class="form-actions fluid">
                               <div class="col-md-offset-3 col-md-9">
                                  <button type="submit" name="Submit" class="btn green">Submit</button>
                                  <button type="reset" class="btn default">Cancel</button>                              
                               </div>
                        	</div>
                            
                            </form>
                      
                      </div>
                      
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
         
         
         <!--------------------------END PAGE CONTENT------------------------->
         
         
<!-----MODALS FOR THIS PAGE START ---->



<!-----MODALS FOR THIS PAGE END ---->
  




<!-----------------------Here goes the rest of the page --------------------------------------------->

<!-- END PAGE CONTENT-->
                </div>
                <!-- END PAGE -->    
        </div>
        <!-- END CONTAINER -->
        
        <!-- BEGIN FOOTER -->
        
        <?php require_once('footer.php'); ?>
        
        <!-- END FOOTER -->
      
        <!-- BEGIN CORE PLUGINS --> 
          
        
		<?php require_once('scripts.php'); ?>
        
        <!-- END CORE PLUGINS -->
        
        
       <!-----PAGE LEVEL SCRIPTS BEGIN--->
       
       
       
       <!-----PAGE LEVEL SCRIPTS END--->
 
 
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<?php 
if($alert_type=='success' && isset($_POST["Submit"]))
{
	//usleep(3000000);
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'&s_factor=1";</script>';
}
?>
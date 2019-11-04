							
 <?php 
 
$sql = "select message_id from ".$db_suffix."message where message_receiver = '".$_SESSION["front_user_id"]."' AND message_seen='0' AND receiver_delete='0'";				
$query = mysqli_query($db, $sql);
$unseen='';

if(mysqli_num_rows($query) > 0)
{
	$unseen='('.mysqli_num_rows($query).')';
}
 
 ?>                           
                            
                            <ul class="inbox-nav margin-bottom-10">
								<li class="compose-btn">
									<a href="<?php echo SITE_URL.'send-message/'; ?>" data-title="Compose" class="btn green">
									<i class="fa fa-edit"></i> Schreiben </a>
								</li>
								<li class="inbox <?php if($page_id=='message') echo 'active'; ?>">
									<a href="<?php echo SITE_URL.'inbox/'; ?>" class="btn" data-title="Inbox">
									Posteingang <?php echo $unseen; ?></a>
									<b></b>
								</li>
								<li class="sent <?php if($page_id=='sent') echo 'active'; ?>">
									<a class="btn" href="<?php echo SITE_URL.'message-sent/'; ?>" data-title="Sent">
									Gesendet </a>
									<b></b>
								</li>
							</ul>
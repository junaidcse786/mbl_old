<?php 
 
	
$cat_sql = "SELECT * FROM ".$db_suffix."logo";
$cat_query = mysqli_query($db,$cat_sql);
while($row = mysqli_fetch_object($cat_query))
{
$logo=$row->banner_image;
}

if(isset($_SESSION["user_panel"])){
$dd = mysqli_query($db, "select *, DATEDIFF(user_validity_end, user_validity_start) AS validity from ".$db_suffix."user where user_id='".$_SESSION["front_user_id"]."'");

if(mysqli_num_rows($dd)>0){					

	$result1=mysqli_fetch_array($dd);
	
	$user_avatar_login = $result1["user_photo"];
	
	$user_account_validity = $result1["validity"];
	
	$user_account_trackability = $result1["user_trackability"];
	
	$user_language_level = $result1["user_level"];
	
	$user_full_name_login = $result1["user_first_name"].' '.$result1["user_last_name"];
}

$sql = "select message_id from ".$db_suffix."message where message_receiver = '".$_SESSION["front_user_id"]."' AND message_seen='0' AND receiver_delete='0'";				
$query = mysqli_query($db, $sql);
$unseen='';

if(mysqli_num_rows($query) > 0)
{
	$unseen_msg_num=mysqli_num_rows($query);
	$unseen='<span class="badge badge-danger">'.mysqli_num_rows($query).'</span>';
}

}
?>
<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL.'images/'.$logo; ?>" alt="<?php echo SITE_NAME;?>" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
                
                <?php if(!isset($_SESSION["user_panel"])){ ?>
					
                    <li class="droddown">
						<a href="<?php echo SITE_URL.'sign-in/up/' ?>" class="dropdown-toggle">
						<i class="fa fa-pencil-square-o"></i>
						<span class="username">Registrieren</span>
						</a>
					</li>
                    
                    <li class="droddown dropdown-separator">
						<span class="separator"></span>
					</li>
                    
                    <li class="droddown">
						<a href="<?php echo SITE_URL.'sign-in/' ?>" class="dropdown-toggle">
						<i class="fa fa-sign-in"></i>
						<span class="username">Anmelden</span>
						</a>
					</li>
                    
                  <?php }  else { ?>  
                  
                  	<?php if($unseen!='') { ?>
                
                	<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">

						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-envelope-open"></i>
						<?php echo $unseen; ?>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>Sie haben <span class="bold"><?php echo $unseen_msg_num; ?> neue</span> Nachrichte(n)</h3>
								<!--<a href="<?php echo SITE_URL_ADMIN.'?mKey=inbox'; ?>">Alle anzeigen</a>-->
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                
                                <?php 
								
								$sql = "select * from ".$db_suffix."message m
										Left Join ".$db_suffix."user u on m.message_sender=u.user_id where m.message_receiver = '".$_SESSION["front_user_id"]."' AND m.receiver_delete='0' AND m.message_seen='0' ORDER BY m.message_created_time DESC, m.message_seen ASC";
								$news_query = mysqli_query($db,$sql);
								
								while($row = mysqli_fetch_object($news_query))
								{
									if($row->user_photo!='')	
									
										$sender_photo_src=SITE_URL.'data/user/'.$row->user_photo;
										
									else
									
										$sender_photo_src=SITE_URL_ADMIN.'assets/admin/layout/img/avatar.png';									
								?>
									<li>
										<a href="<?php echo SITE_URL.'view-message/'.$row->message_id;?>">
										<span class="photo">
										<img src="<?php echo $sender_photo_src; ?>" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										<?php 
								  
										  if($row->role_id=='1')
										  
											echo 'Administrator';
											
										else
										
											echo $row->user_first_name.' '.$row->user_last_name;	
										  
										  ?>
                                        </span>
										<span class="time"><?php 
								  
										  if(date('d-m-Y')==date('d-m-Y', strtotime($row->message_created_time)))
										  
											echo date('H:i', strtotime($row->message_created_time));
											
										else
										
											echo date('d-m-Y H:i', strtotime($row->message_created_time));	
										  
										  ?>
                                        </span>
										</span>
										<span class="message">
										<?php 
										
										echo '<strong>'.substr($row->message_subject,0,30).' :</strong> '.substr(strip_tags($row->message_text),0,40).'...';
										
										?>
                                        </span>
										</a>
									</li>
                                    
                                <?php } ?>
								
                                </ul>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					<li class="separator">
					</li>
                    
                    <?php } ?>
                    
                    <!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						
                        <?php 
						
						if($user_avatar_login!='')

							$src=SITE_URL.'data/user/'.$user_avatar_login;
						
						else
						
							$src=SITE_URL_ADMIN.'assets/admin/layout/img/avatar.png'; 						
						
						
						?>
						
                        <img class="img-circle" width="46" height="46" alt="" src="<?php echo $src; ?>"/>                   
                        
						<span class="username username-hide-mobile"><?php  
						
						if(!isset($user_avatar_login)) 
						
							echo 'Willkommen, ';
						
						echo $user_full_name_login; 
						
						
						?></span><i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo SITE_URL.'my-account/'; ?>">
								<i class="icon-user"></i> Mein Konto </a>
							</li>
                            
                            <li>
								<a href="<?php echo SITE_URL.'inbox/'; ?>">
								<i class="icon-envelope-open"></i> Postfach <?php echo $unseen; ?></a>
							</li>
                            
                            <!--<li>
								<a href="<?php echo SITE_URL.'help/'; ?>">
								<i class="icon-info"></i> Hilfe </a>
							</li>-->
							
                            <li>
								<a href="<?php echo SITE_URL.'sign-out/'; ?>">
								<i class="icon-key"></i> Abmelden </a>
							</li>
						</ul>
					</li>
                    <?php } ?>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
	</div>
	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu">
		<div class="container">
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
            
            <!-- BEGIN HEADER SEARCH BOX -->
            
            <?php if(isset($_SESSION["user_panel"]))
			
				echo '<form class="search-form" action="'.SITE_URL.'search/'.'" method="GET">
				<div class="input-group" style="background:white;">
					<input style="background:white;" autocomplete="off" type="text" class="form-control" placeholder="Suchen" name="key">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
				</div>
			</form>';
			
			
			
			?>
			
			<!-- END HEADER SEARCH BOX -->

            
            
            
			<div class="hor-menu">
				<ul class="nav navbar-nav">
					<li <?php if($page_id=='1') echo 'class="active"'; ?>>
						<a href="<?php echo SITE_URL; ?>">Startseite</a>
					</li>
                    
                    <?php 
					
					$menu_sql = "SELECT * FROM ".$db_suffix."content where content_published='1' AND content_permalink='0'";
					$menu_query = mysqli_query($db,$menu_sql);
					while($row = mysqli_fetch_object($menu_query))
					{
						$active='';
						
						if($page_id==$row->content_id)
						
							$active='class="active"';
					
					?>
					
					
					<li <?php echo $active; ?>>
						<a href="<?php echo SITE_URL.'page/'.$row->content_id.'/'.$row->content_title; ?>" ><?php echo $row->content_title; ?></a>
					</li>
                    
                    <?php } 
					
					$active='';
					
					if($page_id=='grammar-page')
					
						$active='active';
					
					if(isset($_SESSION["user_panel"])) { ?>
                    
                    
					<!--<li class="menu-dropdown mega-menu-dropdown mega-menu-full <?php echo $active; ?>">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
						Grammar Lessons <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li>
								<div class="mega-menu-content">
									<div class="row">
                                    
                                    <?php 
									
									$sql_parent_menu = "SELECT DISTINCT content_topic FROM ".$db_suffix."content where content_published='1' AND content_topic!='' AND content_permalink='1'";	
									$parent_query = mysqli_query($db, $sql_parent_menu);
									
									while($parent_obj = mysqli_fetch_object($parent_query))
									{
									
									?>
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3><?php echo $parent_obj->content_topic; ?></h3>
												</li>
                                                
                                                <?php 
												
												$sql = "SELECT * FROM ".$db_suffix."content where content_topic = '$parent_obj->content_topic'";
												$news_query = mysqli_query($db,$sql);
												
												while($row = mysqli_fetch_object($news_query))
			    								
												{
													$active='';
					
													if($content_id==$row->content_id)
													
														$active='class="active"';
													
												?>
                                                
                                                <li <?php echo $active; ?>>
													<a href="<?php echo SITE_URL.'grammar-page/'.$row->content_id.'/'.$row->content_title; ?>">
													<i class="fa fa-angle-right"></i>
													<?php echo $row->content_title; ?> </a>
												</li>
                                                
                                                <?php } ?>
											</ul>
										</div>
                                        
									<?php }?>	
                                    	
									</div>
								</div>
							</li>
							
						</ul>
					</li>-->
                    
                    <?php 
						
						if($page_id=='exercise-page')
					
							$active='active';
					
					?>
                    
                    <li class="menu-dropdown classic-menu-dropdown <?php echo $active; ?>">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="#">
						&Uuml;bungen <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
                        	
                            <?php 
									
									$sql_parent_menu = "SELECT DISTINCT exercise_type FROM ".$db_suffix."exercise where exercise_status='1'";	
									$parent_query = mysqli_query($db, $sql_parent_menu);
									
									while($parent_obj = mysqli_fetch_object($parent_query))
									{
										$active='';
										$active1='fa fa-paper-plane-o';
										if(isset($page_id1) && $page_id1==$parent_obj->exercise_type)
											{ $active='active'; $active1='fa fa-paper-plane'; }
									?>
										<li class=" dropdown-submenu <?php echo $active; ?>">
                                        	<a href="#">
                                                <i class="<?php echo $active1; ?>"></i>
                                                <?php echo $parent_obj->exercise_type; ?>
                                            </a>
                                            <ul class="dropdown-menu">
												
                                                <?php 
												
												$topic_arr=array();
												
												$sql = "SELECT DISTINCT exercise_topic, exercise_type FROM ".$db_suffix."exercise where exercise_status='1' AND exercise_type = '$parent_obj->exercise_type'";
												$news_query = mysqli_query($db,$sql);
												
												while($row = mysqli_fetch_object($news_query)){		    								
													if(count(explode(",", $row->exercise_topic))>1){
														
														foreach(explode(",", $row->exercise_topic) as $topic_item){														
															if(trim($topic_item)!="")
																		
																array_push($topic_arr,trim($topic_item));
														}
													}
													else
														array_push($topic_arr,$row->exercise_topic);
												}

												$topic_arr=array_unique($topic_arr);
												
												foreach($topic_arr as $topic_name)
												{
													$active='';
													$active1='fa fa-circle-o';
													
													if($content_id==$topic_name){
													
														$active='class="active"';
														$active1='fa fa-circle';
													}
												
												$sql = "select exercise_id from ".$db_suffix."exercise where exercise_topic like '%$topic_name%' AND exercise_status='1' AND DATE(exercise_created_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY)";				
												$query = mysqli_query($db, $sql);
												$has_new_exe=mysqli_num_rows($query);
												
												if($has_new_exe>0)
												
													$span_NEW='<span class="badge badge-danger">NEU</span>';
												else{
												
													$sql = "select q.question_id from ".$db_suffix."question q
													LEFT JOIN ".$db_suffix."exercise e ON e.exercise_id=q.exercise_id where e.exercise_topic like '$topic_name' AND e.exercise_status='1' AND DATE(q.question_creation_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY) LIMIT 1";				
													$query = mysqli_query($db, $sql);
													$has_new_quest=mysqli_num_rows($query);
													
													if($has_new_quest>0)
													
														$span_NEW='<span class="badge badge-danger">AKTUALISIERT</span>';
													else{
													
														$span_NEW='';
													}
												}
												
												?>
                                                
                                                <li <?php echo $active; ?>>
													<a href="<?php echo SITE_URL.'exercise-topic/'.$parent_obj->exercise_type.'/'.$topic_name; ?>">
                                                    <i class="<?php echo $active1; ?>"></i>
													<?php echo $topic_name.' '.$span_NEW; ?></a>
                                                    
												</li>
                                                
                                                <?php } ?>
											</ul>
                                         </li>
										
									<?php }?>
                        </ul>
					</li>
					
					<?php } ?>
					
					<li <?php if($page_id=='hangman') echo 'class="active"'; ?>>
						<a href="<?php echo SITE_URL.'hangman/'; ?>" >Galgenm&auml;nnchen</a>
					</li>
					
					<!--<li <?php if($page_id=='3') echo 'class="active"'; ?>>
						<a href="<?php echo SITE_URL.'contact-us/'; ?>" >Kontakt</a>
					</li>-->
					
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->


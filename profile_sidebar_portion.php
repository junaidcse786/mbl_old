<?php 

if($user_avatar_login!='')

	$src=SITE_URL.'data/user/'.$user_avatar_login;

else

	$src=SITE_URL_ADMIN.'assets/admin/layout/img/avatar.png';

?>
<div class="profile-sidebar" style="width: 235px;">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic">
								<img src="<?php echo $src; ?>" class="img-responsive" alt="">
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">
									 <?php echo $user_full_name_login; ?>
								</div>
							</div>
							<!-- END SIDEBAR USER TITLE -->
							<!-- SIDEBAR MENU -->
							<div class="profile-usermenu">
                            <?php 
							$active='';
							if($page_id=='my account')
								$active='class="active"';
							
							?>
								<ul class="nav">
									<li <?php echo $active; ?>>
										<a href="<?php echo SITE_URL.'my-account/'; ?>">
										<i class="icon-home"></i>
										Meine Statistik </a>
									</li>
                                    
                                     <?php 
							$active='';
							if($page_id=='my account edit')
								$active='class="active"';
							
							?>
                                    
									<li <?php echo $active; ?>>
										<a href="<?php echo SITE_URL.'edit-my-account/'; ?>">
										<i class="icon-settings"></i>
										Kontoeinstellungen </a>
									</li>
									
							<?php 
							
							if($user_account_trackability==1): 
							
							$active='';
							if($page_id=='rangliste')
								$active='class="active"';
							
							?>
                                    
									<li <?php echo $active; ?>>
										<a href="<?php echo SITE_URL.'rangliste/'; ?>">
										<i class="fa fa-star"></i>
										Rangliste </a>
									</li>
                            
                            <?php endif ?>        
									
							<?php 
							
							    if($_SESSION["front_user_id"]==435): 
							    
							?>
						        	<li <?php echo $active; ?>>
    									<a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfUuHHuMuR7DifdZe6vc7ItOUI2On7Mvx3EoOgX6geyNG0bXw/viewform?usp=sf_link">
    									<i class="fa fa-chevron-circle-right"></i>
    									Rückmeldung </a>
									</li>
									
							<?php endif; ?>		
								
								</ul>
							</div>
							<!-- END MENU -->
						</div>
						<!-- END PORTLET MAIN -->
						<!-- PORTLET MAIN -->
						<div class="portlet light">						
							
                            <?php 
								$exam_date='';
								$sql = "select exam_date, DATEDIFF(exam_date, CURDATE()) AS LEFT_DAYS from ".$db_suffix."exam_date where lang_level = '".$_SESSION["front_user_level"]."' AND org_name='".$_SESSION["front_user_org_name"]."'";				
								$query = mysqli_query($db, $sql);
								$has_a_date=mysqli_num_rows($query);	
								if(mysqli_num_rows($query) > 0)
								{
									$date_to_go=1;
									$content     = mysqli_fetch_object($query);
									$exam_date = date('d.m.Y',strtotime($content->exam_date));
									
									if(strtotime($content->exam_date)<strtotime(date('Y-m-d')))
									
										$date_to_go=0;
									
									$exam_days_left = $content->LEFT_DAYS;
								}
								if($exam_date!='' && $date_to_go==1 && $exam_days_left>=0) {
								?>
                                
                                 <div class="row list-separated profile-stat">
                                    <div class="col-md-12">
                                        <h4 class="profile-desc-title"><?php echo '<strong>'.$exam_date.'</strong><br /><br />Noch <strong>'.$exam_days_left.' Tag(e)</strong> bis zur Abschlusspr체fung.'; ?></h4>
                                    </div>
                                </div>
                            
                            	<div class="row list-separated profile-stat">
                                    <div class="col-md-12">
                                        <h4 class="profile-desc-title">Schule:<br /> <?php echo $_SESSION["front_user_org_name"]; ?></h4>
                                    </div>
                                </div>
                            
                            <?php } ?>
                            
							<div>
								<h4 class="profile-desc-title">Info:</h4>
								<span class="profile-desc-text"> Dein Konto läuft in <strong><?php echo $user_account_validity; ?></strong> Tag(e) aus. <?php if($user_account_validity<=7) { ?>Please contact Admin to extend your account validity using the link below<?php } ?></span>
                                <?php if($user_account_validity<=7) { ?>
								<div class="margin-top-20 profile-desc-link">
									<i class="fa fa-globe"></i>
									<a href="<?php echo SITE_URL.'send-message/000'; ?>">Request Admin</a>
								</div>
								<?php } ?>
							</div>
						</div>
						<!-- END PORTLET MAIN -->
					</div>
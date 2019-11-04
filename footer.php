<!--<div class="page-prefooter">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12 footer-block">
				<?php 
				
				$content_id=4;
				$sql = "select * from ".$db_suffix."content where content_id = $content_id limit 1";				
				$query = mysqli_query($db, $sql);				
				if(mysqli_num_rows($query) > 0)
				{
					$content     = mysqli_fetch_object($query);
					
					$description = $content->content_desc;
				}
				
				echo $description;
				
				?>
			</div>
			<div class="col-md-3 col-sm-6 col-xs12 footer-block">
				<h2>Subscribe Email</h2>
				<div class="subscribe-form">
					<form action="javascript:;">
						<div class="input-group">
							<input type="text" placeholder="mail@email.com" class="form-control">
							<span class="input-group-btn">
							<button class="btn" type="submit">Submit</button>
							</span>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 footer-block">
				<?php 
				
				$content_id=6;
				$sql = "select * from ".$db_suffix."content where content_id = $content_id limit 1";				
				$query = mysqli_query($db, $sql);				
				if(mysqli_num_rows($query) > 0)
				{
					$content     = mysqli_fetch_object($query);
					
					$description = $content->content_desc;
				}
				
				echo $description;
				
				?>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 footer-block">
				<?php 
				
				$content_id=5;
				$sql = "select * from ".$db_suffix."content where content_id = $content_id limit 1";				
				$query = mysqli_query($db, $sql);				
				if(mysqli_num_rows($query) > 0)
				{
					$content     = mysqli_fetch_object($query);
					
					$description = $content->content_desc;
				}
				
				echo $description;
				
				?>
			</div>
		</div>
	</div>
</div>-->
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container">
        <?php echo FOOTER_TEXT; ?>
              <div class="pull-right">
        		Developed By <a target="_blank" href="http://opterra.uk/">Opterra</a>
    		</div>       
	</div>
</div>
<div class="scroll-to-top">
	<i class="icon-arrow-up"></i>
</div>
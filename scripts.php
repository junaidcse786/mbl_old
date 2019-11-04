
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script>
      jQuery(document).ready(function() {    
        Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		});
</script>

<?php if(isset($_SESSION["user_panel"])){ 

/*$dd = mysqli_query($db, "select * from ".$db_suffix."user where user_id='".$_SESSION["front_user_id"]."'");

if(mysqli_num_rows($dd)>0){					

	$result1=mysqli_fetch_array($dd);
	
	if($result1["user_status"]==0)
	
		echo '<script>window.location="'.SITE_URL.'sign-out/";</script>';
}*/

$login_time= strtotime(date('Y-m-d H:i:s')) - strtotime($_SESSION["logged_in_time"]);

$_SESSION["logged_in_time"]=date('Y-m-d H:i:s');
	
$sql = "UPDATE ".$db_suffix."user SET user_login_time=user_login_time+$login_time where user_id = '".$_SESSION["front_user_id"]."'";				
$query = mysqli_query($db, $sql);


?>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery-idle-timeout/jquery.idletimeout.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/jquery-idle-timeout/jquery.idletimer.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {    
        
	var $countdown;

	$('body').append('<div class="modal fade" id="idle-timeout-dialog" data-backdrop="static"><div class="modal-dialog modal-small"><div class="modal-content"><div class="modal-header"><h4 class="modal-title font-red">Warnung!</h4></div><div class="modal-body"><p><i class="fa fa-warning"></i> Ihre Sitzung läuft in <span id="idle-timeout-counter"></span> Sekunde(n) ab.</p><p>Wollen Sie Ihre Sitzung fortsetzen?</p></div><div class="modal-footer"><button id="idle-timeout-dialog-logout" type="button" class="btn btn-default">Nein, Abmelden</button><button id="idle-timeout-dialog-keepalive" type="button" class="btn btn-primary" data-dismiss="modal">Ja, Ich bin hier</button></div></div></div></div>');
			
	// start the idle timer plugin
	$.idleTimeout('#idle-timeout-dialog', '.modal-content button:last', {
		idleAfter: 15*60, // 15 minutes
		timeout: 30000, //30 seconds to timeout
		pollingInterval: 5, // 5 seconds
		keepAliveURL: '<?php echo $_SERVER['REQUEST_URI'];?>',
		serverResponseEquals: 'OK',
		onTimeout: function(){
			window.location = "<?php echo SITE_URL.'sign-out/';?>";
		},
		onIdle: function(){
			$('#idle-timeout-dialog').modal('show');
			$countdown = $('#idle-timeout-counter');

			$('#idle-timeout-dialog-keepalive').on('click', function () { 
				$('#idle-timeout-dialog').modal('hide');
			});

			$('#idle-timeout-dialog-logout').on('click', function () { 
				$('#idle-timeout-dialog').modal('hide');
				$.idleTimeout.options.onTimeout.call(this);
			});
		},
		onCountdown: function(counter){
			$countdown.html(counter); // update the counter
		}
	});		
		

});
</script>

<?php } ?>

<script>

function get_selection() {
    var txt = '';
    if (window.getSelection) {
        txt = window.getSelection();
    } else if (document.getSelection) {
        txt = document.getSelection();
    } else if (document.selection) {
        txt = document.selection.createRange().text;
    }
    return txt;
}

$(document).dblclick(function(e) {
    var t = get_selection();
	
    window.open("http://dict.tu-chemnitz.de/dings.cgi?service=deen&opterrors=0&optpro=0&query="+t+"&iservice=", "_blank", "width=900, height=500, scrollbars=yes");
});

$('.img-border').click(function() {
	
	$(this).closest('.total_question').find('.img-border').each(function( index ) {
	  $(this).removeClass('img-border-permanent');
	  $(this).removeClass('right-answer');
	});	
	$(this).closest('.total_question').find('input[type="radio"]').each(function( index ) {
	  $(this).prop('checked', false);
	  $(this).removeAttr("checked");
	});	
	$(this).addClass('img-border-permanent');
	$(this).closest('.col-xs-12').find('input[type="radio"]').attr('checked', true);	
	$(this).closest('.col-xs-12').find('input[type="radio"]').prop('checked', true);;
	
});

$('.spell-word-type-1-input').keyup(function() {
	
	var hint_text = $(this).parent().parent().find('.spell-word-type-1').text();
	
	if(hint_text.search("#")>=0)
	
		return;
		
	var hint_text_arr = hint_text.split(" ");	
	var string="";
	
	for(j=0;j<hint_text_arr.length;j++){
	
		for(i=0;i<hint_text_arr[j].length;i++)
			
			string+="#";
			
		string+=" ";	
	}	
	$(this).parent().parent().find('.spell-word-type-1').html('<strong>'+string+'</strong>');
});

function setCharAt(str,index,chr) {
    if(index > str.length-1) return str;
    return str.substr(0,index) + chr + str.substr(index+1);
}

$('.spell-word-type-2-input').keyup(function() {
	
	var text=$(this).val();
	
	var to_replace_num = text.length-1;
	
	var hint_text = $(this).parent().parent().find('.spell-word-type-2').text();
	
	var hint_text_arr = hint_text.split(" ");	
	
	var temp = 0; var string="";
	
	for(j=0;j<hint_text_arr.length;j++){
	
		hint_text_arr[j]=hint_text_arr[j].trim();
		
		string = hint_text_arr[j];
		
		if(to_replace_num>hint_text_arr[j].length)
		
			to_replace_num=hint_text_arr[j].length;
		
		if(temp==0){		
		
			for(i=0;i<=to_replace_num && i<hint_text_arr[j].length;i++)					
				
				string=setCharAt(string,i,"#"); 
				
			temp=1;			
		}		
		else{
		
			for(i=to_replace_num;i>=0 && i<hint_text_arr[j].length;i--)	
				
				string=setCharAt(string,i,"#"); 
				
			temp=0;
		}
		hint_text_arr[j]=string;
	}
	
	$(this).parent().parent().find('.spell-word-type-2').html('<strong>'+hint_text_arr.join(' ')+'</strong>');
});

</script>
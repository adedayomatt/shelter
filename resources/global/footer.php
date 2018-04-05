<!--JQuery and Bootstrap tools-->
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/mato/tools/JQuery/jquery.min.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/mato/tools/bootstrap/js/bootstrap.min.js' ?>"></script>

<!--Scripts for apis-->
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/js/suggest_property.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/js/follow.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/js/clip.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/js/popPropertyPhoto.js' ?>"></script>

<!--Scripts from JMatt Library-->
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/mato/lib/JMatt/countdown.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/mato/lib/JMatt/toggle.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/mato/lib/JMatt/tabs.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/mato/lib/JMatt/coloranimation.js' ?>"></script>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});


$(function () {
  $('[data-toggle="popover"]').popover();
});
</script>

<style>
#footer-wrapper{
	color:white;
	background: rgba(0,0,0,0.5) url('<?php echo $tool->relative_url() ?>/resources/images/footer-bg.jpg') repeat-x center; 
}
#footer{
	background-color:rgba(0,0,0,0.8);
	padding:20px 10px
			}
</style>

<div id="footer-wrapper">
<div class="row" id="footer">
<?php
//if(isset($feedback_form) && $feedback_form == true){
	?>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
							<div class="feedback-area">
										<h1>FeedBack</h1>
										<p>We would like to hear from you, leave feed back</p>
										<form class="padding-10">
											<div class="form-group">
												<label>Your E-mail</label>
												<input class="form-control" type="text" placeholder="Enter your E-mail here"/>
											</div>

											<div class="form-group">
												<textarea class="form-control" placeholder="Write your feedback here"></textarea>
											</div>
											
											<div class="form-group">
												<input class="btn-block btn-primary btn-lg" type="submit" value="Send FeedBack">
											</div>
										</form>
							</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
					<p>Some other footer links will appear here</p>
					</div>
	<?php
//}
?>
</div>
</div>
<?php
//update last seen
if($status==1){
	$loggedIn_agent->update_last_seen();
}
else if($status==9){
	$loggedIn_client->update_last_seen();
}

//close mysqli connection
$db->close();
?>

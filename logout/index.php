<?php
require('../resources/master_script.php'); 
?>
<html>
<head>
<?php
$pagetitle = "Logout";
require('../resources/global/meta-head.php'); ?>
</head>
<body class=""> 
<h1 class="padding-10 margin-0 site-color-background white text-left bold">Shelter</h1>

<?php
//$root = "http://192.168.173.1/shelter";
if($status == 1){
	$tool->deleteCookie('user_agent');
	$confirmation_head = "<h2>Logged out</h2>";
	
	$confirmation_body = "<p class=\"text-center\">Your account has been logged out successfully <br/><a class=\"btn btn-lg  btn-primary\" href=\"$root/login\">Login</a></p>";
}
else if($status==9) {
	$tool->deleteCookie('user_client');
		$confirmation_head = "<h2>Checked out</h2>";
		
		$confirmation_body = "<p class=\"text-center\">Your CTA has been checked out successfully<br/> <a class=\"btn btn-lg btn-primary\" href=\"$root/cta/checkin.php\"><b>here</b></a></p>";
}
else{
		$confirmation_head = "<h2>You were not logged/checked in!</h2>";
		
		$confirmation_body="<div class=\"padding-10\">
							<a class=\"btn btn-lg btn-block btn-primary\" href=\"$root/login\">Login as agent </a>
							<a class=\"btn btn-lg btn-block btn-primary\" href=\"$root/signup\">signup an agent account</a>
							<a class=\"btn btn-lg btn-block btn-primary\" href=\"$root/cta/checkin.php\">checkin</a>
							<a class=\"btn btn-lg btn-block btn-primary\" href=\"$root/cta/checkin.php#createnew\">Create new CTA</a>
							</div>";
}
?>
<div class="center-content" style="margin-top:10px">
<div class="contain">
<div class="head f7-background"><?php echo $confirmation_head ?></div>
<div class="body white-background"><?php echo $confirmation_body ?></div>
</div>
</div>	

<?php 
require('../resources/global/footer.php'); 
 ?>
</body>


</html>
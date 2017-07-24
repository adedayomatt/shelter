<?php
require('../phpscripts/masterScript.php'); 
?>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<header>
<style>
@media only screen and (min-device-width: 1000px){
	#all-header-container{
	display:none;
}

#logout-prompt{
	padding:5%;
	background-color:white;
	width:50%;
	margin:auto;
	margin-top:10%;
}
}
@media only screen and (min-device-width: 300px) and (max-device-width: 1000px){
	#all-header-container{
	display:none;
}
.l{
	display:block;
}
#logout-prompt{
	padding:5%;
	background-color:white;
	width:80%;
	margin:auto;
	margin-top:10%;
}
}
h1{
	color:white;
	text-align:center;
}
.l{
	background-color:purple;
	color:white;
}

</style>
<?php
//$root = "http://192.168.173.1/shelter";
if($general->check_cookie('user_agent')==true){
	$general->unset_cookie('user_agent');
	$confirmation = "<h2>Logged out</h2><p>Your account has been logged out successfully <a class=\"inline-block-link l\" href=\"$root/login\">Login</a></p>";
}
else if($general->check_cookie('user_cta')==true) {
	$general->unset_cookie('user_cta');
		$confirmation = "<h2>Checked out</h2><p>Your CTA has been checked out successfully, <a class=\"inline-block-link l\" href=\"$root/cta/checkin.php\"><b>here</b></a></p>";
}
else{
		$confirmation = "<h2>You were not logged/checked in!</h2><br/><br/>
		<a class=\"inline-block-link l\" href=\"$root/login\">Login as agent </a>
		<a class=\"inline-block-link l\" href=\"$root/signup\">signup an agent account</a>
		<a class=\"inline-block-link l\" href=\"$root/cta/checkin.php\">checkin</a>
		<a class=\"inline-block-link l\" href=\"$root/cta/checkin.php#createnew\">Create new CTA</a></p>";
}
?>
</header>
<body class="mixedcolor-background"> 
<h1 align="center">Shelter</h1>
<div class="box-shadow-1" id="logout-prompt" align="center"><?php echo $confirmation; ?></div>	</body>

</html>
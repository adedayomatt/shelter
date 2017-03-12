<html>
<head>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/style_for_login.css" type="text/css" rel="stylesheet">
</head>
<?php
if(isset($switch_prompt)){
	Login_status($switch_prompt);
}
else{
	Login_status('new');
}


function Login_status($prompt_for_login){
if(isset($_COOKIE['name'])){
	loggedIn();
}
else{
	switchprompt($prompt_for_login);
}
}
function switchprompt($status){
	switch($status){
	case 'a':
		LoadLoginPage("please log in first!");
		break;
	case 'z':
		LoadLoginPage("You are logged out!!<br/>provide your login details to login");
		break;		
	default:
	LoadLoginPage("Welcome!!<br/>please provide your login details");
		break;
		
	}
	
}
function loggedIn(){
	$pagetitle = 'Logged in';
	require('../require/user_header.php');
	$prompt = "You are already logged in as '<a href=\"profile.php\"><b> ".$profile_name."</b></a>'";
	echo "<p align=\"center\">".$prompt."</p>";
	//require('footer.html');
}
function LoadLoginPage($msg){
	$pagetitle = 'login';
	require('../require/header.php');
	require('loginform.php');
	require('../require/footer.html');
}

?>
</html>
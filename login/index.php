<?php 

require('../phpscripts/masterScript.php'); 

//$general_obj->unset_cookie('user_agent');

class login{
	function verify_account($username,$password,$remember){
		GLOBAL $general;
		GLOBAL $db;
$user = $db->select('profiles','User_ID',"User_ID ='$username'",null);
if(count($user)==1){
if($db->select('profiles','password',"User_ID ='$username'",null)[0]['password']==$password){
//log CTA out immediadely agent account is logged in
$general->unset_cookie('CTA');
//if user want to remained logged, set the cookie for longer period
if($remember == true){
					setcookie('user_agent',SHA1($_POST['username']),time()+2592000,"/","",0);
					}
					else{
						setcookie('user_agent',SHA1($_POST['username']),0,"/","",0);
					}
return 100;
}
//if password is incorrect
else{
return 'error101';
			}
		}
//if no username matches
else{
return 'error102';
		}
	}
	
} //end of class


if(isset($_POST['login'])){
$log_in = new login();
$remember = (isset($_POST['remember_me']) ? true : false);
$login_feedback = $log_in->verify_account($_POST['username'],$_POST['passw'],$remember);
if($login_feedback==100){
$general->redirect(null);
}
else if($login_feedback=='error101'){
	$loginReport = "<h2>Login Failed!</h2><p>Incorrect password</p>";	

}
else if($login_feedback=='error102'){
	$loginReport = "<h2>Login Failed!</h2><p>user Id <b>'".$_POST['username']."'</b> does not exists<br/>check your input or <a href=\"$root/signup\">create a new account</a></p>";
}

}

?>

<!DOCTYPE html>
<html>
<?php require('../require/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/login_styles.css" type="text/css" rel="stylesheet">
<head>
<title>Shelter | Login</title>
<?php
$pagetitle="Log in";
$ref ='loginpage';
$getuserName=true;
require('../require/plain-header.html');

?>
</head>
<?php

?>

<body class="picture-background">
			<div class="main-login">
<form action="<?php $_PHP_SELF ?>" method="post">
	<fieldset class=" box-shadow-1 login-form">

<?php
//if already logged in
if($general->check_cookie('user_agent')==true){
	echo "<h1>Already logged in</h1><p>You are already logged in <a href=\"../logout\">Logout</a></p>";
	die();
	}		
			 ?>

<?php if(isset($loginReport)){
	echo "<div class=\"operation-report-container operation-fail-container\">$loginReport</div>";
	} ?>
			<div id="login-input-area">
			Provide your login details<br/><br/>
		<input placeholder="Agents ID" class="input" name="username" size="40" maxlength="30" type="text" required="required" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
			<input placeholder="Password" class="input" name="passw" size="30" maxlength="30" type="password" required="required" ></label>
			<label><input name="remember_me" type="checkbox" value="keepme">keep me logged in</label><br/><br/>
			<input  id="login-button" name="login"  type="submit" value="Login">
			</div>
			<span style="float:left"><a  href="#">forgot password?</a></span>
			<span style="float:right"><a href="../signup">create a new account</a></span>
			</fieldset></form>
			</div>	

</body>
</html>
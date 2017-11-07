<?php 
require('../resources/php/master_script.php'); 

class login{
	function verify_account($username,$password,$remember){
		GLOBAL $general;
		GLOBAL $db;
$user = $db->query_object("SELECT User_ID FROM profiles WHERE User_ID = '$username' AND token='".SHA1($username)."'");
if($user->num_rows==1){
	$get_pass = $db->query_object("SELECT password,token FROM profiles WHERE User_ID = '$username'")->fetch_array(MYSQLI_ASSOC);
if($get_pass['password']==$password){
//log CTA out immediadely agent account is logged in
$general->unset_cookie('user_cta');
//if user want to remained logged, set the cookie for longer period
if($remember == true){
					setcookie('user_agent',$get_pass['token'],time()+2592000,"/","",0);
					}
					else{
						setcookie('user_agent',$get_pass['token'],0,"/","",0);
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
	if(isset($_GET['return'])){
	header("location: ".$_GET['return']);
$general->halt_page();	
	}
	else{
	$general->redirect(null);
}
}
else if($login_feedback=='error101'){
	$loginReport = "<h2>Login Failed!</h2><p>Incorrect password</p>";	

}
else if($login_feedback=='error102'){
	$loginReport = "<h2>Login Failed!</h2><p>user Id <b>'".$_POST['username']."'</b> does not exists<br/>check your input or <a href=\"$root/signup\">create a new account</a>
	<br/>Note: <i><em style=\"color:#20435C\">Abc</em> is not the same as <em style=\"color:#20435C\">abc</em> </i></p>";
}

}

?>

<!DOCTYPE html>
<html>
<head>
<?php 
$pagetitle = "Login";
require('../resources/global/meta-head.php'); ?>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/login_styles.css" type="text/css" rel="stylesheet">
</head>
<?php

?>

<body class="login-picture-background">

<?php
$altHeaderContent ="
<div class=\"row\">
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">
Login
</div>
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12\">
<p class=\"font-16\">Don't have an account yet? <a href=\"../signup\"><button class=\"btn btn-primary\">signup</button></a></p>
</div>
</div>";
require('../resources/global/alt_static_header.php');
?>


			<div class="container-fluid body-content">
			<div class="center-content opac-white-background padding-10 box-shadow-1 border-radius-5">
<form action="<?php $_PHP_SELF ?>" method="post">
	<fieldset class="width-90p margin-auto text-center">
	
		<div class="text-center">
			<span class="glyphicon glyphicon-briefcase agent-avatar icon-size-40 site-color"></span>
			</div>
<?php
//if already logged in
if($status==1){
	echo "<h1 align=\"center\">Already logged in</h1><p>You are already logged in <a class=\"btn btn-primary red-background\" href=\"../logout\">Logout</a></p>";
	die();
	}		
			 ?>

<?php if(isset($loginReport)){
	echo "<div class=\"operation-report-container fail\">$loginReport</div>";
	} ?>
			
			Provide your login details
			<div class="form-group">
		<input placeholder="Agents ID" class="form-control more-padding" name="username" maxlength="30" type="text" required value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
			</div>
			
			<div class="form-group">
			<input placeholder="Password" class="form-control more-padding" name="passw" maxlength="30" type="password" required="required" ></label>
			</div>
			
			<div class="checkbox">
			<label>
			<input name="remember_me" type="checkbox" value="keepme"> keep me logged in
			</label>
			</div>
			
			<input  class="btn btn-lg btn-primary btn-block site-color-background" name="login"  type="submit" value="Login" />
			
			
			<span class="margin-5 float-right"><a  href="#">forgot password?</a></span>
			</fieldset>
			</form>
			</div>
</div>	
</body>
</html>
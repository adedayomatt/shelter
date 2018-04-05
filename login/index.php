<?php 
require('../resources/master_script.php'); 

if(isset($_POST['login'])){
$log_in = new login();
$remember = (isset($_POST['remember_me']) ? true : false);
$login_feedback = $log_in->verify_account($_POST['username'],$_POST['passw'],$remember);
if($login_feedback==100){
	if(isset($_GET['return'])){
	$tool->redirect_to($_GET['return']);
	}
	else{
	$tool->redirect_to('home');
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

</head>

<body>

<?php
$altHeaderContent ="
<div class=\"row\">
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">
Agent | Login
</div>
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12\">
<p class=\"font-16\">Don't have an account yet? <a href=\"../signup\"><button class=\"btn btn-primary\">signup</button></a></p>
</div>
</div>";
require('../resources/global/alt_static_header.php');
?>
<style>
@media all and (max-width: 768px),(max-device-width: 768px){
.container-fluid{
	padding-top:120px;
}
</style>

			<div class="container-fluid">
			<div class="center-content">
			<div class="contain remove-side-margin-xs">
			<div class="head f7-background">
			<span class="glyphicon glyphicon-briefcase agent-avatar icon-size-40 site-color"></span><br/>
			<h1 class="site-color margin-3">Login</h1>
			</div>
			<div class="body white-background">
		<form action="<?php $_PHP_SELF ?>" method="post">
			<fieldset class="width-90p margin-auto text-center">
			
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
			
			<p class="grey">Provide your login details</p>
			<div class="form-group ">
		<input placeholder="Agents ID" class="form-control more-padding" name="username" maxlength="30" type="text" required value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
			</div>
			
			<div class="form-group ">
			<input placeholder="Password" class="form-control more-padding" name="passw" maxlength="30" type="password" required="required" ></label>
			</div>
			
			<div class="checkbox">
			<label>
			<input name="remember_me" type="checkbox" value="keepme"  class="site-color"> keep me logged in
			</label>
			</div>
			
			<div class="form-group width-70p margin-auto">
			<input  class="btn btn-lg btn-primary btn-block site-color-background" style="border-radius:0px" name="login"  type="submit" value="Login" />
			</div>
			
			<span class="margin-5 float-right"><a  href="#" class="site-color">forgot password?</a></span>
			</fieldset>
			</form>
			</div>
			</div>
			</div>
</div>	
</body>
</html>
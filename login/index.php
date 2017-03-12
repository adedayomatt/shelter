<!DOCTYPE html>
<html>
<head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/login_styles.css" type="text/css" rel="stylesheet">
<?php
$pagetitle="Log in";
$ref ='loginpage';
$getuserName=true;
$connect=true;
	require('../require/header.php');
	if($status==1){
	$loginReport = "You are already logged in as '<b>".$profile_name."</b>'";
	$case = 1;
	}
?>
</head>
<?php
if(isset($_POST['login'])){
	$ref = "loginpage";
	$verifyUsername = mysql_query("SELECT User_ID FROM profiles WHERE (User_ID='".$_POST['username']."')");
if(mysql_num_rows($verifyUsername)==1){
	$verifyPassword = mysql_query("SELECT password FROM profiles WHERE (User_ID ='".$_POST['username']."')");
	$pass = mysql_fetch_array($verifyPassword,MYSQL_ASSOC);
	if($_POST['passw']==$pass['password']){
		//log CTA out immediadely agent account is logged in
					setcookie('CTA',"",time()-60,"/","",0);
//if user want to remained logged, set the cookie for longer period
		if(isset($_POST['cookietime'])){
					setcookie('name',$_POST['username'],time()+2592000,"/","",0);
					}
					else{
						setcookie('name',$_POST['username'],time()+14400,"/","",0);
					}
//redirect to the homepage and exit this script	
			header("location: $root");
					exit();
	}
//if password is incorrect
	else{
	$loginReport = "Incorrect password";
					$case = 2;	
	}
}
//if no username matches
else{
	$loginReport = "user Id <b>'".$_POST['username']."'</b> does not exists<br/>check your input or <a href=\"$root/signup\">create a new account</a></p>";
				$case = 3;
}
	
}
?>

<body class="pic-background">
<br/>
<?php if(isset($loginReport) && $case==1){
	echo "<p>$loginReport<br/> <a href=\"../logout\">Logout</a></p>";
	exit();
} ?>
			<div class="main">
			<div class="sub_main">
<form action="<?php $_PHP_SELF ?>" method="post">
<h4 align="center">Welcome!<br/>provide your login details below</h4>
<?php if(isset($loginReport) && $case!=1){
	echo "<div id=\"error-container\"><p><i id=\"error-icon\" class=\"white-icon\"></i>$loginReport</p></div>";
} ?>
			<fieldset align="center" class="form"><legend>Login details</legend>
			<label class="form">User ID: <input name="username" size="40" maxlength="30" type="text" required="required" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>"></label><br><br>
			<label class="form">Password: <input name="passw" size="30" maxlength="30" type="password" required="required" ></label><br><br>
			<label><input name="cookietime" type="checkbox" value="keepme">keep me logged in</label><br/><br/>
			<input name="login"  type="submit" value="login">
			<p align="right"><a href="#">forgot password?</a></p>
			<p align="left"><a href="../signup">create a new account</a></p>
			</fieldset></form>
			</div>
			<div class="sub_main">
			<p id="q"align="left">Are you Land and Estate agents?, Do you need a place to advertise your properties on the internet?
			<br/><b>GOOD NEWS!!!</b> <a href="../">shelter.com</a> is all you need.<br/><a href="../signup">sign up</a> today.
			</p></div>
			</div>
</body>
</html>
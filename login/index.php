<!DOCTYPE html>
<html>

<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/login_styles.css" type="text/css" rel="stylesheet">
<header>
<?php
$pagetitle="Log in";
$ref ='loginpage';
$getuserName=true;
$connect=true;
	require('../require/connexion.php');
if(isset($_COOKIE['name'])){
	$loginReport = "<h1>Already logged in</h1>You are already logged in <a href=\"../logout\">Logout</a>";
	$case = 1;
	}
?>
</header>
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
mysql_close($db_connection);
			header("location: $root");
					exit();
	}
//if password is incorrect
	else{
	$loginReport = "<h2>Cannot Log In</h2>Incorrect password";
					$case = 2;	
	}
}
//if no username matches
else{
	$loginReport = "<h2>Cannot Log In</h2>user Id <b>'".$_POST['username']."'</b> does not exists<br/>check your input or <a href=\"$root/signup\">create a new account</a></p>";
				$case = 3;
}
	
}
?>

<body class="special-background">
			<div class="main-login">
			<a id="shelter" href="../"><h1>Shelter</h1></a>
<form action="<?php $_PHP_SELF ?>" method="post">
	<?php if(isset($loginReport) && $case==1){
	echo "<div class=\"operation-report-container\">$loginReport</div>";
		mysql_close($db_connection);
		exit();
	} ?>

	<?php if(isset($loginReport) && $case!=1){
	echo "<div class=\"operation-report-container\" id=\"login-error\">$loginReport</div>";
	} ?>
			<fieldset class="login-form">
			<div id="login-input-area">
			Provide your login details<br/><br/>
		<input placeholder="Agents ID" class="input" name="username" size="40" maxlength="30" type="text" required="required" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
			<input placeholder="Password" class="input" name="passw" size="30" maxlength="30" type="password" required="required" ></label>
			<label><input name="cookietime" type="checkbox" value="keepme">keep me logged in</label><br/><br/>
			<input id="login-button" name="login"  type="submit" value="Login">
			</div>
			<span style="float:left"><a href="#">forgot password?</a></span>
			<span style="float:right"><a href="../signup">create a new account</a></span>
			</fieldset></form>
			
			</div>
			

</body>
</html>
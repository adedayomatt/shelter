 <?php 
require('../resources/master_script.php'); 

//if attempt to checkin
if(isset($_POST['checkin'])){
	$user = htmlentities(trim($_POST['checkinName']));
	$pass = $_POST['checkinPassword'];
	$remember = (isset($_POST['remember_me']) ? true : false);

	$checkin = new checkin();
	$checkin_response = $checkin->verify_cta($user,$pass,$remember);
	
	if($checkin_response == 102){
		$feedback = "<h2>CTA does not exist</h2><p>No CTA is found with the name <strong>\"$user\"</strong>, please check your input and try again</p>";
	}
	else if($checkin_response == 101){
		$feedback = "<h2>Incorrect Password</h2><p>The password you entered is incorrect, please check your input and try again</p>";
	}
	else if($checkin_response == 99){
		$feedback = "<h2>Missing Fields</h2><p>some fields are not filled properly, please enter your registered CTA name and password</p>";
	}
	else if ($checkin_response == 1000){
		$feedback = "<h2>Expired CTA</h2><p>The CTA you are attempting to checkin has expired, <a href=\"\">create new CTA</a></p>";
	}
	else if($checkin_response == 100){
		if(isset($_GET['return'])){
				$tool->redirect_to($_GET['return']);
		}
		else{
				$tool->redirect_to('home');
		}
	}
}
//CTA login ends here


//if attempt to create new
if(isset($_POST['create'])){
//if some necessary fields are empty
	if(empty($_POST['newname']) || !is_numeric($_POST['newphone']) || empty($_POST['newmail']) || empty($_POST['newpass1']) || empty($_POST['newpass2'])){
		$createCTAReport = "<h3> Fields Missing!</h3>
						<p>Some fields are either empty or not filled correctly. Please check your input and try again</p>";
						$success = 0;
	}
//if necessary fields are not empty
	else{
//verify if passwords match
$ctapass = (($_POST['newpass1']==$_POST['newpass2']) ? $_POST['newpass2'] : null);
//if verifypassword does not return null, then add info to database
if($ctapass != null){
//scan name for illegal character
$scanned_ctaname = $db->connection->real_escape_string(htmlentities(trim($_POST['newname'])));
//check if there is no account with this name
if($db->query_object("SELECT ctaid FROM cta WHERE name='$scanned_ctaname'")->num_rows==0){
$prepared_q = "INSERT INTO cta (ctaid,name,phone,email,request,password,datecreated,createdTimestamp,expiryTimestamp,token)
				VALUES (?,?,?,?,?,?,?,?,?,?)";
$create_cta = $db->prepare_statement($prepared_q);
$create_cta->bind_param('isisissiis',$_ctaid,$_ctaname,$_ctaphone,$_ctamail,$_ctarequest,$_ctapassword,$_ctadatecreated,$_ctatimecreated,$_ctaexpirytime,$_ctatoken);

$_ctaid = time() - rand(1000,9999);
$_ctaname = $scanned_ctaname;
$_ctaphone = $_POST['newphone'];
$_ctamail = $_POST['newmail'];
$_ctarequest = 0;
$_ctapassword = $ctapass;
$_ctadatecreated = "NOW()";
$_ctatimecreated = time();
$_ctaexpirytime = time() + 2592000;
$_ctatoken = SHA1($scanned_ctaname);

$create_cta->execute();
if($create_cta->affected_rows == 1){
	$createCTAReport = "<h3>CTA created successfully</h3>
			<p>You can now request your property with preferences and get notifications when they are available
			<a href=\"../cta/checkin.php?a=checkin\">checkin now</a> to explore!</p>";
		$success = 1;
}

else{
	$createCTAReport = "<h3> Failed!</h3>
							<p>CTA could not be created, please try again later</p>";
		$success = 0;
		}	
	}
else{
	$createCTAReport = "<h3> CTA name already exist!</h3>
							<p>Another user is using this name '$scanned_ctaname', please use another name for your CTA</p>";
		$success = 0;
	}
}
//if password do not match
else{
	$createCTAReport = "<h3>Password Inconsistency!</h3>
							<p>passwords do not match</p>";
	$success = 0;
		}
	
	}
}
//CTA creation ends here

?>

<!DOCTYPE html>
<html>
<head>

<?php
$pagetitle = "CTA";
$ref = "ctaPage";
 require('../resources/global/meta-head.php'); ?>
 <style>
@media all and (min-width:768px){
	.center-content{
		width:80% !important;
	}
}
</style>
<script>
function toggle_cta(from,to){
	event.preventDefault();
document.getElementById(from).style.display = 'none';
document.getElementById(to).style.display = 'block';
}
</script>

<?php

//require('../resources/php/header.php');
//if a visitor has attempted an action, and redirect to this page $_GET['_rdr'] would be set
$checkinreminder =((isset($_GET['_rdr'])&&$_GET['_rdr']==1 && !isset($_POST['checkin'])&& !isset($_POST['create'])) ? "You need to checkin first or <a href=\"$root/login\">login</a> as an agent":'');

if($status==1){
	$denialMessage = "<h3> Access Denied!</h3>
						<p>You cannot use Client Temporary Account because you are currently logged in as an agent [".$loggedIn_agent->business_name."] logout first
						<a  href=\"../logout\">Logout</a> </p>";
}
else if($status==9){
$denialMessage = "<h3> Already checked in!</h3>
				<p>A CTA is already checked in as <strong>".$loggedIn_client->name."</strong> <a href=\"../logout\">checkout</a></p>";
}
?>
</head>
<body>
<?php
$altHeaderContent ="
<div class=\"row\">
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">
Client Temporary Account
</div>
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12 hidden-xs\">
<p class=\"font-16\">Don't have a CTA yet?  <a  href=\"?a=create\"><button class=\"btn btn-primary\">create CTA</button></a></p>
</div>
</div>";

if(isset($_GET['a']) && $_GET['a']=='create'){
$altHeaderContent ="
<div class=\"row\">
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">
Client Temporary Account
</div>
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12 hidden-xs\">
<p class=\"font-16\">Already have a CTA?  <a  href=\"?a=checkin\"><button class=\"btn btn-primary\">checkin</button></a></p>
</div>
</div>";
}
require('../resources/global/alt_static_header.php');
?>

<div class="container-fluid">

<div class="center-content">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<style>
<?php 
if(isset($_GET['a']) && $_GET['a']=='checkin'){
?>

#checkin{
	display:block;
}
#createnew{
	display:none;
}
<?php
}
else if(isset($_GET['a']) && $_GET['a']=='create'){

?>
#checkin{
	display:none;
}
#createnew{
	display:block;
}
<?php
}else{
?>
#checkin{
	display:block;
}
#createnew{
	display:none;
}
<?php	
}
?>
</style>

<div id="checkin">
<div class="contain remove-side-margin-xs">
<div class="head f7-background">
<h2 class="site-color"><span class="glyphicon glyphicon-log-in"></span>  Checkin CTA</h2>
</div>
<div class="body white-background text-center">
<?php 
if(isset($denialMessage)){
	echo "<div class=\"operation-report-container fail\" id=\"checkin-denial\">$denialMessage</div>";
	$tool->halt_page();
}?>


<form action="<?php $_PHP_SELF ?>" method="POST" style="padding:0px 20px">
<span class="glyphicon glyphicon-user icon-size-40 site-color client-avatar"></span>
<?php
echo ((!isset($_GET['_rdr']) && !isset($_POST['checkin'])) ? "<div class=\"short-about\"> <p style=\"line-height:150%\" >Client Temporary Account, CTA allows client in need of property to request for their need and get update on availability...<a href=\"#\">learn more about CTA</a></div>": "");
?>
<?php
//if there is error while trying to checkin
if(isset($feedback)){
	echo "<div class=\"operation-report-container fail\">$feedback</div>";
}

?>

<div>
	<?php
if(!empty($checkinreminder) || $checkinreminder != ""){
	echo "<div class=\"operation-report-container success\" ><p><span class=\"glyphicon glyphicon-info-sign red icon-size-25\"></span><br/> $checkinreminder</p></div>";
}
?>
</div>


<p style="color:grey">Provide your registered name or phone number and password</p>
<div class="form-group">
<input class="form-control more-padding" name="checkinName" type="text" value="<?php if(isset($_POST['checkinName'])){ echo $_POST['checkinName'];}?>" size="30" placeholder="Name or Phone number"/>
</div>

<div class="form-group">
<input class="form-control more-padding"  name="checkinPassword" type="password" size="20" maxlength="11" placeholder="Password"/>
</div>

			<div class="checkbox">
			<label>
			<input name="remember_me" type="checkbox" checked="true" value="keepme"> keep me checked in
			</label>
			</div>
<div class="form-group width-70p margin-auto">
<input class="btn btn-block btn-lg site-color-background white" style="border-radius:0px" name="checkin" type="submit" value="checkin"/>
</div>

<p class="font-16 text-right margin-10">Don't have a CTA yet?  <a  href="?a=create" class="site-color">create CTA</a></p>

</form>
</div>
</div>
</div>

<div id="createnew">

<div class="contain remove-margin-xs">
<div class="head f7-background">
<h2 class="site-color"><span class="glyphicon glyphicon-folder-open  client-avatar "></span>  New CTA</h2>
</div>
<div class="body white-background">
	<?php
//if cta creating is successful
 if(isset($createCTAReport) && $success == 1){
	echo "<div class=\"operation-report-container success\"  >$createCTAReport</div>";
	$tool->halt_page();
}?>
<div class="text-center">
<?php
//if there is error while trying to create new CTA
if(isset($createCTAReport) && $success == 0){
	echo "<div class=\"operation-report-container fail\"  >$createCTAReport</div>";
}
?>
</div>
<p class="grey">Field with asterisk <i class="red">*</i> are neccessary</p>
<form action="../cta/checkin.php?a=create" method="POST" >
<div class="form-group">
<label for="name">Your name <i class="red">*</i></label>
<input class="form-control create-new-input" name="newname" type="text" value="<?php if(isset($_POST['newname'])){ echo $_POST['newname'];}?>" size="30" placeholder="Name"/>
</div>

<div class="form-group">
<label for="phone">Active phone number <i class="red">*</i></label>
<input class="form-control create-new-input" name="newphone" type="text" value="<?php if(isset($_POST['newphone'])){ echo $_POST['newphone'];}?>" size="30" maxlength="11" placeholder="Phone No"/>
</div>

<div class="form-group">
<label for="email">Active Email <i>(optional)</i></label>
<input class=" form-control create-new-input" name="newmail" type="email" value="<?php if(isset($_POST['newmail'])){ echo $_POST['newmail'];}?>" size="30" placeholder="email address"/>
</div>

<div class="form-group">
<label for="name">Password <i class="red">*</i></label>
<input class="form-control create-new-input" name="newpass1" type="password" size="30" placeholder="choose password"/>
</div>

<div class="form-group">
<input class="form-control create-new-input" name="newpass2" type="password" size="30" placeholder="Repeat password"/>
</div>

<p>I want to get notifications via</p>

<div class="checkbox">
<label for="phone">
<input  name="phone" type="checkbox"/>Phone</label>
</div>

<div class="checkbox">
<label for="mail">
<input  name="mail" type="checkbox"/>Email</label>
</div>

<div class="form-group width-70p margin-auto">
<input class="btn btn-block btn-lg site-color-background white" style="border-radius:0px" name="create"  type="submit"  value="create"/>
</div>

<p class="font-16 text-right margin-10">Already have a CTA?  <a  href="?a=checkin" class="site-color">checkin</a></p>

</form>
</div>
</div>

</div>

</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="site-color-background padding-5 white border-radius-5">
<h2 class="text-center">Why Client Temporary Account?</h2>
</div>
</div>
</div>

</div>
<?php 
require('../resources/global/footer.php');
?>

</body>

</html>
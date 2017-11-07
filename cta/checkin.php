 <?php 
require('../resources/php/master_script.php'); 

if($status==9){
}
//if attempt to checkin
if(isset($_POST['checkin'])){
//if either or both of the name and password field is empty
if(empty($_POST['checkinName']) || empty($_POST['checkinPassword']) ){
	$checkinReport = "<h3>Fields Missing!</h3>
						<p>Please input your name/phone number and password</p>";
}
//if either or both of the name and password field is not empty
else{
$user = htmlentities(trim($_POST['checkinName']));
$pass = $_POST['checkinPassword'];

//if user want to checkin with number...
if(is_numeric($user)){
	$getCTAquery = "SELECT ctaid, phone,request,password,expiryTime,token FROM cta WHERE (phone=$user AND password='$pass')";
}
//...or name
else{
	$getCTAquery = "SELECT ctaid,name,request,password,expiryTime,token FROM cta WHERE (name='$user' AND password='$pass')";
}
$getCTA = $db->query_object($getCTAquery);
//if query is correct
if(is_object($getCTA)){
//if a match is found
if($getCTA->num_rows == 1){
	$cta = $getCTA->fetch_array(MYSQLI_ASSOC);
	$id = $cta['ctaid'];
	$name = $cta['name'];
	$requeststatus = $cta['request'];
	$CTAexpires = $cta['expiryTime'];
	$token = $cta['token'];
//this is just to create distraction on the url
	$dummy = uniqid(SHA1($name));
//if cta has expired
	if($CTAexpires <= time()){
		header("location: $root/cta/?checkin=false&acct=xyz&exp=$CTAexpires&dMy=$dummy");
		$general->halt_page();
	}
	else{
		setcookie('user_cta',$token,time()+2592000,"/","",0);
/*if there is request already, redirect to homepage else redirect to the request page
		switch($requeststatus){
			case '1':
			header("location: $root");
		exit();
		break;
		case '0':
		header("location: $root/cta/request.php?p=$requeststatus");
		exit();
		}

i've  used javascript to pop up prompt that the user that he hasn't made any request yet on the homepage,
so just go straight to the home page;
	*/
		header("location: $root/?_rq=$requeststatus");
		exit();

	}
		
}
//if no match is found for the account trying to be logged in
	else{
	$checkinReport = "<h3> Checkin Failed!</h3>
						<p>Incorrect name/phone number and password, check your input or <a href=\"?a=create\">create a new CTA</a></p>";
	}
}
else{
	echo "error";
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
$scanned_ctaname = htmlentities($_POST['newname']);
//check if there is no account with this name
if($db->query_object("SELECT * FROM cta WHERE name='$scanned_ctaname'")->num_rows==0){
$prepared_q = "INSERT INTO cta (ctaid,name,phone,email,request,password,datecreated,timeCreated,expiryTime,token)
				VALUES (?,?,?,?,?,?,?,?,?,?)";
$create_cta = $connection->prepare($prepared_q);
$create_cta->bind_param('isisissiis',$_ctaid,$_ctaname,$_ctaphone,$_ctamail,$_ctarequest,$_ctapassword,$_ctadatecreated,$_ctatimecreated,$_ctaexpirytime,$_ctatoken);

$_ctaid = time() - rand(1000,9999);
$_ctaname = $scanned_ctaname;
$_ctaphone = $_POST['newphone'];
$_ctamail = $_POST['newmail'];
$_ctarequest = 0;
$_ctapassword = $ctapass;
$_ctadatecreated = date('Y-m-l',time());
$_ctatimecreated = time($_POST['newname']);
$_ctaexpirytime = time() + 2592000;
$_ctatoken = SHA1($scanned_ctaname);

$create_cta->execute();
if($create_cta->affected_rows == 1){
	$createCTAReport = "<h3>CTA created successfully</h3>
			<p>You can now request your property with preferences and get notifications when they are available
			<a href=\"../cta/checkin.php?a=checkin\">checkin now</a> to explore!</p>";
		$success = 1;
}


/*
//if query is correct
if($createnewCTA){
	@mysql_query("INSERT INTO notifications (notificationid,subject,subjecttrace,receiver,action,status,time) VALUE ('".uniqid('CTAcreate')."','$ctaname','$ctaid','$ctaname','CTA created','unseen',".time().")");
	$activityID = uniqid(time());
	@mysql_query("INSERT INTO activities (activityID, action, subject, subject_ID, subject_Username, status, timestamp) VALUES('$activityID','CAO','$ctaname','$ctaid','$ctaname','unseen',$timeCreated)");
			}
			*/
			
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
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/ctastyles.css" type="text/css" rel="stylesheet" />
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
						<p>You cannot use Client Temporary Account because you are currently logged in as an agent [$Business_Name] logout first
						<a  href=\"../logout\">Logout</a> </p>";
}
else if($status==9){
$denialMessage = "<h3> Already checked in!</h3>
				<p>A CTA is already checked in as <strong>".$cta_name."</strong> <a href=\"../logout\">checkout</a></p>";
}
?>
</head>
<body class="plain-colored-background">
<?php
$altHeaderContent ="
<div class=\"row\">
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">
Checkin
</div>
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12\">
<p class=\"font-16\">Don't have a CTA yet?  <a  href=\"?a=create\"><button class=\"btn btn-primary\">create CTA</button></a></p>
</div>
</div>";

if(isset($_GET['a']) && $_GET['a']=='create'){
$altHeaderContent ="
<div class=\"row\">
<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">
Create CTA
</div>
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-12\">
<p class=\"font-16\">Already have a CTA?  <a  href=\"?a=checkin\"><button class=\"btn btn-primary\">checkin</button></a></p>
</div>
</div>";
}
require('../resources/global/alt_static_header.php');
?>

<div class="container-fluid body-content">

<?php 
if(isset($denialMessage)){
	echo "<div class=\"operation-report-container success\" id=\"checkin-denial\">$denialMessage</div></body></html>";
	exit();
}?>

<div class="center-content white-background padding-10 border-radius-5">

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

<fieldset class="width-90p margin-auto">

<?php

echo ((!isset($_GET['_rdr']) && !isset($_POST['checkin'])) ? "<div class=\"short-about\"> <p style=\"line-height:150%\" >Client Temporary Account, CTA allows client in need of property to request for their need and get update on availability...<a href=\"#\">learn more about CTA</a></div>": "");
?>
<?php
//if there is error while trying to checkin
if(isset($checkinReport)){
	echo "<div class=\"operation-report-container fail\"  >$checkinReport</div>";
}

?>

<div class="text-center">
	<?php
if(!empty($checkinreminder) || $checkinreminder != ""){
	echo "<div class=\"operation-report-container success\" ><p><span class=\"glyphicon glyphicon-info-sign red icon-size-25\"></span><br/> $checkinreminder</p></div>";
}
?>
<span class="glyphicon glyphicon-user icon-size-40 site-color client-avatar"></span>
</div>


<p style="color:grey">Provide your registered name or phone number and password</p>
<form action="<?php $_PHP_SELF ?>" method="POST">
<div class="form-group">
<input class="form-control more-padding" name="checkinName" type="text" value="<?php if(isset($_POST['checkinName'])){ echo $_POST['checkinName'];}?>" size="30" placeholder="Name or Phone number"/>
</div>

<div class="form-group">
<input class="form-control more-padding"  name="checkinPassword" type="password" size="20" maxlength="11" placeholder="Password"/>
</div>

<input class="btn btn-block btn-lg site-color-background white" name="checkin" type="submit" value="checkin"/>
</form>
</fieldset>
</div>

<div id="createnew">

<fieldset class="width-90p margin-auto">
	<?php
//if cta creating is successful
 if(isset($createCTAReport) && $success == 1){
	echo "<div class=\"operation-report-container success\"  >$createCTAReport</div>";
}?>
<div class="text-center">
<span class="glyphicon glyphicon-folder-open icon-size-40 site-color client-avatar "></span>
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

<input class="btn btn-block btn-lg site-color-background white" name="create"  type="submit"  value="create"/>
</form>
</fieldset>

</div>
<?php 
require('../resources/global/footer.php');
?>
</div>

</div>
</body>

</html>
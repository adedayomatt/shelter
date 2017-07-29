 <?php 
require('../resources/php/master_script.php'); 

if($status==9){
}
//if attempt to checkin
if(isset($_POST['checkin'])){
//if either or both of the name and password field is empty
if(empty($_POST['checkinName']) || empty($_POST['checkinPassword']) ){
	$checkinReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Fields Missing!</h3>
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
//if there is request already, redirect to homepage else redirect to the request page
		switch($requeststatus){
			case '1':
			header("location: $root");
		exit();
		break;
		case '0':
		header("location: $root/cta/request.php?p=$requeststatus");
		exit();
		}
	}
		
}
//if no match is found for the account trying to be logged in
	else{
	$checkinReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Checkin Failed!</h3>
						<p>Incorrect name/phone number and password, check your input or <a href=\"#createnew\">create a new CTA</a></p>";
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
		$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Fields Missing!</h3>
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
			<a href=\"#checkin\">checkin now</a> to explore!</p>";
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
	$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Failed!</h3>
							<p>CTA could not be created, please try again later</p>";
		$success = 0;
		}	
	}
else{
	$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> CTA name already exist!</h3>
							<p>Another user is using this name '$scanned_ctaname', please use another name for your CTA</p>";
		$success = 0;
	}
}
//if password do not match
else{
	$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Password Inconsistency!</h3>
							<p>passwords do not match</p>";
	$success = 0;
		}
	
	}
}
//CTA creation ends here

?>

<!DOCTYPE html>
<html>
<?php require('../resources/html/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/ctastyles.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle = "CTA";
$ref = "ctaPage";
require('../resources/php/header.php');
//if a visitor has attempted an action, and redirect to this page $_GET['_rdr'] would be set
$checkinreminder =((isset($_GET['_rdr'])&&$_GET['_rdr']==1 && !isset($_POST['checkin'])&& !isset($_POST['create'])) ? "You need to checkin first or <a href=\"$root/login\">login</a> as an agent":'');

if($status==1){
	$denialMessage = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Access Denied!</h3>
						<p>You cannot use Client Temporary Account because you are currently logged in as an agent [$Business_Name] logout first
						<a class=\"inline-block-link white-on-red\" href=\"../logout\">Logout</a> </p>";
}
else if($status==9){
$denialMessage = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Already checked in!</h3>
				<p>A CTA is already checked in as <strong>".$cta_name."</strong> <a class=\"inline-block-link white-on-red\" href=\"../logout\">checkout</a></p>";
}
?>
</head>
<body class="no-pic-background">
<?php if(isset($denialMessage)){
	echo "<div class=\"operation-report-container box-shadow-1\" id=\"checkin-denial\">$denialMessage</div></body></html>";
	exit();
}?>

<div class="all-content">
<?php
if(!empty($checkinreminder) || $checkinreminder != ""){
	echo "<div class=\"operation-report-container\" id=\"prompt-container\" ><p><i class=\"black-icon\" id=\"prompt-icon\"></i> $checkinreminder</p></div>";
}
?>
<div id="introduction">
<!--<p>Client Temporary Account (CTA) is account for clients who wish to get notifications on the availability of their requested</p>-->

</div>
<div id="checkin">


<?php

echo ((!isset($_GET['_rdr']) && !isset($_POST['checkin'])) ? "<div class=\"cta\"> <p style=\"line-height:150%\" >Already have a Client Temporary Account?, checkin now to see properties from your agents.</p></div>": "");
//if there is error while trying to checkin
if(isset($checkinReport)){
	echo "<div class=\"operation-report-container\" id=\"error-container\" >$checkinReport</div>";
}
?>
<fieldset>

<legend>Checkin</legend>
<p style="color:grey">Provide your registered name or phone number and password</p>
<form action="<?php $_PHP_SELF ?>" method="POST">
<input class="checkin-input" name="checkinName" type="text" value="<?php if(isset($_POST['checkinName'])){ echo $_POST['checkinName'];}?>" size="30" placeholder="Name or Phone number"/>
<input class="checkin-input" name="checkinPassword" type="password" size="20" maxlength="11" placeholder="Password"/>
<input id="checkin-button" name="checkin" type="submit" value="checkin"/>
</form>
</fieldset>
</div>

<div id="createnew">
<div class="cta">
<span id="question-mark">?</span>
<h3 style="letter-spacing:3px; font-size:200%">Don't Have a CTA? </h3>
<p style="line-height:150%" >You can create a new Client Temporary Account(CTA) Now or you may want to <a href="">learn more</a> about CTA</p>
</div>

<?php
//if there is error while trying to create new CTA
if(isset($createCTAReport) && $success == 0){
	echo "<div class=\"operation-report-container\" id=\"error-container\" >$createCTAReport</div>";
}
else if(isset($createCTAReport) && $success == 1){
	echo "<div class=\"operation-report-container\" id=\"success-container\" >$createCTAReport</div>";
}?>

<fieldset >
<legend>Create new</legend>
<form action="<?php $_PHP_SELF ?>" method="POST" >
<label for="name">Your name</label>
<input class="create-new-input" name="newname" type="text" value="<?php if(isset($_POST['newname'])){ echo $_POST['newname'];}?>" size="30" placeholder="Name"/>
<label for="phone">Active phone number</label>
<input class="create-new-input" name="newphone" type="text" value="<?php if(isset($_POST['newphone'])){ echo $_POST['newphone'];}?>" size="30" maxlength="11" placeholder="Phone No"/>
<label for="email">Active Email <i>(optional)</i></label>
<input class="create-new-input" name="newmail" type="email" value="<?php if(isset($_POST['newmail'])){ echo $_POST['newmail'];}?>" size="30" placeholder="email address"/>
<label for="name">Password</label>
<input class="create-new-input" name="newpass1" type="password" size="30" placeholder="choose password"/>
<input class="create-new-input" name="newpass2" type="password" size="30" placeholder="Repeat password"/>
<p>I want to get notifications via</p>
<input class="checkbox" name="phone" type="checkbox" class="input-label-inline"/><label class="input-label-inline" for="phone">Phone</label><br/>
<input class="checkbox" name="mail" type="checkbox" class="input-label-inline"/><label class="input-label-inline" for="mail">Email</label><br/>
<input id="create-button" name="create"  type="submit"  value="create"/>
</form>
</fieldset>
</div>
<?php 
require('../resources/php/footer.php');
?>
</div>


</body>

</html>
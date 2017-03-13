
<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<style>
.all-content{
	width:70%;
	margin-left:15%;
	margin-right:15%;
}
#prompt-container{
	width:50%;
	border-radius:5px;
	color:white;
	padding:2%;
	margin:auto;
	background-color:#00EEEE;
}
#prompt-icon{
	background-position: 0px -120px;
}

input{
	display:block;
	margin: 5px;
}
.checkin-input{
	display:inline;
}
#checkin-container{
	width:80%;
}

#create-new-container{
	float:left;
}
#error-container, #success-container{
	width:96%;
	border-radius:5px;
	color:white;
	padding:2%;
}

#error-container{
	background-color:red;
}
#error-icon{
	background-position: -312px 0px;
}

#success-container{
	background-color:green;
}
#success-icon{
	background-position:-288px 0px;
}


</style>
<?php
$pagetitle = "CTA-checkin";
$getuserName = true;
$ref = "ctaPage";
$connect = true;
require('../require/header.php');

//if a visitor has attempted an action, and redirect to this page $_GET['_rdr'] would be set
$checkinreminder =((isset($_GET['_rdr'])&&$_GET['_rdr']==0) ? "You need to checkin first or <a href=\"$root/login\">login</a> as an agent":'');

//if attempt to checkin
if(isset($_POST['checkin'])){
//if either or both of the name and password field is empty
if(empty($_POST['checkinName']) || empty($_POST['checkinPassword']) ){
	$checkinReport = "Please input your name/phone number and password";
}
//if either or both of the name and password field is not empty
else{
$user = mysql_real_escape_string($_POST['checkinName']);
$pass = $_POST['checkinPassword'];

//if user want to checkin with number...
if(is_numeric($user)){
	$getCTA = "SELECT ctaid, phone,request,password FROM cta WHERE (phone=$user AND password='$pass')";
}
//...or name
else{
	$getCTA = "SELECT ctaid,name,request,password FROM cta WHERE (name='$user' AND password='$pass')";
}
$getCTAquery = @mysql_query($getCTA);
//if query is correct
if($getCTAquery && mysql_num_rows($getCTAquery)==1){
//if a match is found
	$ctaid = @mysql_fetch_array($getCTAquery,MYSQL_ASSOC);
	$id = $ctaid['ctaid'];
	$requeststatus = $ctaid['request'];
		setcookie('CTA',$id,time()+2592000,"/","",0);
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
//if no match is found for the account trying to be logged in
	else{
	$checkinReport = "Incorrect name/phone number and password, check your input or create a new CTA";
	}
	
		}	
}
//CTA login ends here


//if attempt to create new
if(isset($_POST['create'])){
//if some necessary fields are empty
	if(empty($_POST['newname']) || !is_numeric($_POST['newphone']) || empty($_POST['newmail']) || empty($_POST['newpass1']) || empty($_POST['newpass2'])){
		$createCTAReport = "Some fields are either empty or not filled correctly<br/>please check your input and try again";
		$success = 0;
	}
//if necessary fields are not empty
	else{
$ctaname = $_POST['newname'];
$ctaphone = $_POST['newphone'];
$ctamail = $_POST['newmail'];
//verify if passwords match
$ctapass = (($_POST['newpass1']==$_POST['newpass2']) ? $_POST['newpass2'] : null);
//if verifypassword does not return null, then add info to database
if($ctapass != null){
//assign id
$ctaid = $ctaname.time();
	$createnewCTA = @mysql_query("INSERT INTO cta (ctaid,name,phone,email,request,password,datecreated) VALUES('$ctaid','$ctaname',$ctaphone,'$ctamail',0,'$ctapass',NOW())");
//if query is correct
if($createnewCTA){
	mysql_query("INSERT INTO notifications (notificationid,subject,subjecttrace,receiver,action,status,time) VALUE ('".uniqid('CTAcreate')."','$ctaname','$ctaid','$ctaname','CTA created','unseen',".time().")");
			$createCTAReport = "CTA created successfully<br/>You can now request your property with preferences and get notifications when they are available";
		$success = 1;
}
else{
	$createCTAReport = "CTA could not be created, please try again later";
		$success = 0;
		}	
	}
//if password do not match
else{
	$createCTAReport = "passwords do not match";
	$success = 0;
}
	
	}
}
//CTA creation ends here

if($status==1){
	$denialMessage = "You cannot use Client Temporary Account because you are currently logged in as <a href=\"$root/$profile_name\">$Business_Name</a> <br/><a href=\"../logout\">Logout</a> first";
}
else if($status==9){
$denialMessage = "A CTA is already checked in as <strong>$ctaname</strong><br/><a href=\"../logout\">checkout</a>";
}
?>
</head>
<body class="pic-background">
<?php if(isset($denialMessage)){
	echo "<p style=\"margin-left:20px\">$denialMessage</p></body></html>";
	exit();
}?>

<div class="all-content">
<div id="introduction">
<?php
if(!empty($checkinreminder)){
	echo "<div id=\"prompt-container\" ><p><i class=\"white-icon\" id=\"prompt-icon\"></i> $checkinreminder</p></div>";
}
?>
<p>Client Temporary Account (CTA) is account for clients who wish to get notifications on the availability of their requested</p>
</div>
<div id="checkin-container">
<fieldset>
<legend>Checkin</legend>
<?php
//if there is error while trying to checkin
if(isset($checkinReport)){
	echo "<div id=\"error-container\" ><p><i class=\"white-icon\" id=\"error-icon\"></i> $checkinReport</p></div>";
}
?>
<p>Already have a CTA? </p>
<form action="<?php $_PHP_SELF ?>" method="POST">
<label for="checkinName"></label>Name/Phone<input class="checkin-input" name="checkinName" type="text" value="<?php if(isset($_POST['checkinName'])){ echo $_POST['checkinName'];}?>" size="30" placeholder="Enter your name or phone number"/>
<label for="checkinPassword">password: </label><input class="checkin-input" name="checkinPassword" type="password" size="20" maxlength="11" placeholder="Password"/>
<input class="checkin-input" name="checkin" type="submit" value="checkin"/>
</form>
</fieldset>
</div>
<div id="create-new-container">
<fieldset>
<legend>Create new</legend>
<?php
//if there is error while trying to create new CTA
if(isset($createCTAReport) && $success == 0){
	echo "<div id=\"error-container\" ><p><i class=\"white-icon\" id=\"error-icon\"></i> $createCTAReport</p></div>";
}
else if(isset($createCTAReport) && $success == 1){
	echo "<div id=\"success-container\" ><p><i class=\"white-icon\" id=\"success-icon\"></i> $createCTAReport</p></div>";
}
?>
<p>Create a new Client Temporary Account (CTA)</p>
<form action="<?php $_PHP_SELF ?>" method="POST" >
<label for="name">Your name</label><input name="newname" type="text" value="<?php if(isset($_POST['newname'])){ echo $_POST['newname'];}?>" size="30" placeholder="Name"/>
<label for="phone">Active phone number</label><input name="newphone" type="text" value="<?php if(isset($_POST['newphone'])){ echo $_POST['newphone'];}?>" size="30" maxlength="11" placeholder="Phone No"/>
<label for="email">Active Email <i>(optional)</i></label><input name="newmail" type="email" value="<?php if(isset($_POST['newmail'])){ echo $_POST['newmail'];}?>" size="30" placeholder="email address"/>
<label for="name">Password</label><input name="newpass1" type="password" size="30" placeholder="choose password"/><input name="newpass2" type="password" size="30" placeholder="Repeat password"/>
I want to get notifications via<br/>
<input class="checkin-input" name="phone" type="checkbox"/><label for="phone">Phone</label>
<input class="checkin-input" name="mail" type="checkbox"/><label for="mail">Email</label>
<input  name="create"  type="submit"  value="create"/>
</form>
</fieldset>
</div>
</div>
</body>
<?php mysql_close($db_connection) ?>
</html>
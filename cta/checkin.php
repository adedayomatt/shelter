
<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<style>
.all-content{
	width:50%;
	margin:auto;
}
#denial{
	width:50%;
	text-align:center;
}
#prompt-container{
	background-color:#00EEEE;
}
#prompt-icon{
	background-position: 0px -120px;
}
#checkin,#createnew{
	padding:10%;
	background-color:white;
	margin-top:5px;
	box-shadow: 1px 1px 1px 1px grey;
	border-radius:5px;
}
fieldset{
	width:50%;
	margin:auto;
	padding:5%;
	border-radius:5px;
}
legend{
	font-size:120%;
	color:grey;	
}
.checkin-input,.create-new-input{
	display:block;
	width:94%;
	padding:3%;
}
#checkin-button,#create-button{
	cursor:pointer;
	width:100px;
	padding:10px;
	background-color:#6D0AAA;
	color:white;
	letter-spacing:2px;
	border:none;
	border-radius:5px;
	box-shadow: 2px 2px 2px 2px grey;
	font-size:110%;
	font-weight:bold;
	font-family:san-serif;
}
#checkin-button:hover,#create-button:hover{
	box-shadow: 2px 2px 2px 2px #333;
}
#checkin-button:click{
	background-color:white;
	color:#6D0AAA;
	border:2px solid #6D0AAA;
}
#create-button{
	float:right;
}
.error-flags{
	color:red;
}
#error-container,#success-container{
	width:80%;
	margin-bottom:10px;
}
#error-icon{
	background-position: -312px 0px;
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
$checkinreminder =((isset($_GET['_rdr'])&&$_GET['_rdr']==1) ? "You need to checkin first or <a href=\"$root/login\">login</a> as an agent":'');

//if attempt to checkin
if(isset($_POST['checkin'])){
//if either or both of the name and password field is empty
if(empty($_POST['checkinName']) || empty($_POST['checkinPassword']) ){
	$checkinReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Fields Missing!</h3>
						Please input your name/phone number and password";
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
	$checkinReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Checkin Failed!</h3>
						Incorrect name/phone number and password, check your input or <a href=\"#createnew\">create a new CTA</a>";
	}
	
		}	
}
//CTA login ends here


//if attempt to create new
if(isset($_POST['create'])){
//if some necessary fields are empty
	if(empty($_POST['newname']) || !is_numeric($_POST['newphone']) || empty($_POST['newmail']) || empty($_POST['newpass1']) || empty($_POST['newpass2'])){
		$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Fields Missing!</h3>
						Some fields are either empty or not filled correctly<br/>please check your input and try again";
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
$ctaid = time() - rand(1000,9999);
//check if there is no account with this name
if(mysql_num_rows(mysql_query("SELECT * FROM cta WHERE name='$ctaname'"))==0){
	
	$createnewCTA = @mysql_query("INSERT INTO cta (ctaid,name,phone,email,request,password,datecreated) VALUES('$ctaid','$ctaname',$ctaphone,'$ctamail',0,'$ctapass',NOW())");
//if query is correct
if($createnewCTA){
	mysql_query("INSERT INTO notifications (notificationid,subject,subjecttrace,receiver,action,status,time) VALUE ('".uniqid('CTAcreate')."','$ctaname','$ctaid','$ctaname','CTA created','unseen',".time().")");
			$createCTAReport = "CTA created successfully<br/>You can now request your property with preferences and get notifications when they are available<br/>
			<a href=\"#checkin\">checkin now</a> to explore!";
		$success = 1;
}
else{
	$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Failed!</h3>
							CTA could not be created, please try again later";
		$success = 0;
		}	
	}
else{
	$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> CTA name already exist!</h3>
							Another user is using this name '$ctaname', please use another name for your CTA";
		$success = 0;
	}
}
//if password do not match
else{
	$createCTAReport = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Password Inconsistency!</h3>
							passwords do not match";
	$success = 0;
}
	
	}
}
//CTA creation ends here

if($status==1){
	$denialMessage = "<h3 class=\"error-flags\"><span class=\"black-icon\" id=\"error-icon\"></span> Access Denied!</h3>
						You cannot use Client Temporary Account because you are currently logged in as <a href=\"$root/$profile_name\">$Business_Name</a> <br/>
						<a href=\"../logout\">Logout</a> first";
}
else if($status==9){
$denialMessage = "<h3><span class=\"black-icon\" id=\"error-icon\"></span> Already checked in!</h3>
				A CTA is already checked in as <strong>$ctaname</strong><br/><a href=\"../logout\">checkout</a>";
}
?>
</head>
<body class="no-pic-background">
<?php if(isset($denialMessage)){
	echo "<div class=\"operation-report-container\" id=\"denial\">$denialMessage</div></body></html>";
	exit();
}?>

<div class="all-content">
<div id="introduction">
<!--<p>Client Temporary Account (CTA) is account for clients who wish to get notifications on the availability of their requested</p>-->
<?php
if(!empty($checkinreminder) || $checkinreminder != ""){
	echo "<div class=\"operation-report-container\" id=\"prompt-container\" ><p><i class=\"white-icon\" id=\"prompt-icon\"></i> $checkinreminder</p></div>";
}
?>
</div>
<div id="checkin">
<?php
//if there is error while trying to checkin
if(isset($checkinReport)){
	echo "<div class=\"operation-report-container\" id=\"error-container\" >$checkinReport</div>";
}
?>
<fieldset>
<legend>Checkin</legend>
<form action="<?php $_PHP_SELF ?>" method="POST">
<input class="checkin-input" name="checkinName" type="text" value="<?php if(isset($_POST['checkinName'])){ echo $_POST['checkinName'];}?>" size="30" placeholder="Name or Phone number"/>
<input class="checkin-input" name="checkinPassword" type="password" size="20" maxlength="11" placeholder="Password"/>
<input id="checkin-button" name="checkin" type="submit" value="checkin"/>
</form>
</fieldset>
</div>
<h3 style="letter-spacing:3px; color:#6D0AAA">Don't Have a CTA? </h3>
<span style="letter-spacing:3px; color:grey" >You can create a new Client Temporary Account(CTA) Now or you may want to <a href="">learn more</a> about CTA</span>
<div id="createnew">
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
I want to get notifications via<br/>
<input class="checkbox" name="phone" type="checkbox"/><label for="phone">Phone</label><br/>
<input class="checkbox" name="mail" type="checkbox"/><label for="mail">Email</label><br/>
<input id="create-button" name="create"  type="submit"  value="create"/>
</form>
</fieldset>
</div>
</div>
</body>
<?php mysql_close($db_connection) ?>
</html>
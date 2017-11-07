<?php 
require('../resources/php/master_script.php'); 
if($status != 1){
	$general->redirect('login?return='.$thisPage);
}
if(isset($_POST['changeBusinessInfo'])){
	if(!is_numeric($_POST['OfficeTelNo'])){
		$bussinessInfoUpdateResult = "Invalid office Tel Number";
		$success = false;
	}
	else{
	$db->query_object("UPDATE profiles SET Office_Address = '".$_POST['OfficeAddress']."', Office_Tel_No=".$_POST['OfficeTelNo'].", Business_email='".$_POST['Businessmail']."' WHERE (ID = $agentId AND token = '$agent_token')");
if($connection->affected_rows == 1){
	$bussinessInfoUpdateResult = "Business Info updated successfully";
	$success = true;
}
else{
	$bussinessInfoUpdateResult = "Business Info update failed";
	$success = false;
}
	}
}
if(isset($_POST['changePersonalInfo'])){
	if(!is_numeric($_POST['Phone1']) || !is_numeric($_POST['Phone2'])){
	$personalInfoUpdateResult = "Invalid Phone Number(s)";
	$success = false;
	}
	else{
$updateQuery = $db->query_object("UPDATE profiles SET CEO_Name='".$_POST['CEOName']."', Phone_No=".$_POST['Phone1'].", Alt_Phone_No=".$_POST['Phone2'].", email='".($_POST['email'])."'  WHERE (ID = $agentId AND token = '$agent_token')");
if($connection->affected_rows == 1){
	$personalInfoUpdateResult = "Personal Info updated successfully";
	$success = true;
}
else{
	$personalInfoUpdateResult = "Personal Info update failed";
	$success = false;
}
	}
}
if(isset($_POST['changePassword'])){
	$oldPassword = $_POST['oldPassword'];
//if old password matches
if($db->query_object("SELECT password FROM profiles WHERE ID = $agentId AND token = '$agent_token'")->fetch_array(MYSQLI_ASSOC)['password'] == $oldPassword){
		
		if($_POST['newPassword1'] == $_POST['newPassword2']){
		$finalNewPassword = $_POST['newPassword2'];
			$updateQuery = $db->query_object("UPDATE profiles SET password = '$finalNewPassword' WHERE (password = '$oldPassword' AND ID = $agentId AND token = '$agent_token')");
	if($connection->affected_rows == 1){
	$passwordUpdateResult = "Password successfully changed";
	$success = true;
}
else{
	$passwordUpdateResult = "Password change failed";
	$success = false;
}
	}
	else{
		$passwordUpdateResult = "Passwords do not match. Try again";
		$success = false;
	}	
	}
	else{
$passwordUpdateResult = "Incorrect Old Password";
$success = false;
	}
	
}
?>

<!DOCTYPE html>
<html>
<head>
<?php 
	$pagetitle = "Manage";
	$ref='manage_page';
require('../resources/global/meta-head.php'); 
?>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<style>
.settings-section{
	border:1px solid #e3e3e3;
}
.settings-section>li{
	list-style-type:none;
	padding:15px;
	margin:3px 0px;
	background-color:white;
}
.main-form{
	display:none;
	padding:5px;
}
@media only screen and (min-width:768px){
.body-content{
	padding-left:20px;
	padding-right:20px;
}
}
</style>

</head>
<body class="no-pic-background">
<?php
require('../resources/global/header.php');
?>
<?php
if(isset($_POST['deactivateAccount'])){
	?>
	<script>
	showPopup();
	popUpContent().innerHTML = "<?php echo "Account '$Business_Name' will be deactivated!"  ?>";
	</script>
<?php
}
?>

<div class="container-fluid body-content padding-5">

<div class="row hidden-lg hidden-md hidden-sm visible-xs red-background" style="margin-bottom:5px">
<div class="col-xs-6 padding-5 text-center e3-border"><a href="#properties" class="white font-20">Properties</a></div>
<div class="col-xs-6 padding-5 text-center e3-border"><a href="#account" class="white font-20">Account</a></div>
</div>
<input type="hidden" id="agent-username" value="<?php echo $profile_name ?>" />
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 e3-border" id="properties">
<div class="padding-5 white-background " style="border-right:5px solid red">
<h3>Properties</h3>
</div>
<div class="f7-background padding-10">
<p>Total Uploads: <?php echo $total_uploads ?></p>
<div class="form-group white-background e3-border padding-10">
<label class="grey">Manage your properties</label>
<input class="form-control f7-background" id="pid" placeholder="Enter a Property ID"/>
</div>
<div id="property-list-area">
<?php if($total_uploads == 0){	
?>
<div class="text-center padding-10 white-background e3-border">You have not uploaded any property yet <a class="btn btn-primary" href="../upload">Upload Now</a></div>
<?php
}
else{
?>
<div>
<?php
$fiveDaysAgo = time() - 5 * $oneDay;
$recentUpdate = $db->query_object("SELECT * FROM properties WHERE (uploadby='$profile_name' AND last_reviewed <= $fiveDaysAgo) ORDER BY last_reviewed DESC LIMIT 10");
if(is_object($recentUpdate)){
	if($recentUpdate->num_rows > 0){
	?>
		<h4 class="text-center red"><span class="glyphicon glyphicon-info-sign"></span>You need to update the following properties</h4>
<?php
	while($ru = $recentUpdate->fetch_array(MYSQLI_ASSOC)){
		?>
	<div class="row white-background e3-border" style="margin-bottom:5px">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	<img src="<?php echo $property_obj->get_property_dp('../properties/'.$ru['directory'],$ru['display_photo'])?>" class="mini-property-photo"/>
	</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		<div class="font-20 margin-5"><a href="<?php echo "../properties/".$ru['directory']?>"><?php echo $ru['type'] ?></a></div>
		<div class="margin-5 grey"><span class="glyphicon glyphicon-map-marker red"></span><?php echo $ru['location'] ?></div>
		<div class="margin-5 grey"><span class="glyphicon glyphicon-calendar red"></span>updated <?php echo $general->since($ru['last_reviewed']) ?></div>
		<div class="margin-5 grey"><a class="btn btn-primary" href="<?php echo 'property.php?id='.$ru['property_ID'].'&action=change&agent='.$agent_token ?>"><span class="glyphicon glyphicon-pencil"></span>update</a> <a class="text-right float-right " href=""><span class="glyphicon glyphicon-trash red"></span></a></div>
		</div>
	</div>	
		<?php
	}
}
else{
	
}
}
}
?>
</div>
</div>
</div>
</div>

<div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-6 col-xs-12 e3-border" id="account" >
<div class="padding-5 white-background " style="border-right:5px solid red">

<?php
$getformerdetail = "SELECT * FROM profiles WHERE (User_ID = '".$profile_name."')";
				$getquery = $db->query_object($getformerdetail);
					if($getquery->num_rows ==1){
					$account = $getquery->fetch_array(MYSQLI_ASSOC);
						$editid = $account['ID'];
						$editBN = $account['Business_Name'];
						$editOfficeAddress = $account['Office_Address'];
						$editOfficeTelNo = $account['Office_Tel_No'];
						$editBusinessmail = $account['Business_email'];
						$editCEO = $account['CEO_Name'];
						$editPhoneno = $account['Phone_No'];
						$editAltPhoneno = $account['Alt_Phone_No'];
						$editemail = $account['email'];
						$editUsername = $account['User_ID'];
					}
?>
<h3 >Account</h3>
</div>
<?php if(isset($success)){
	$containerClass = ($success == true ? 'success' : 'fail');
?>
<div class="white-background e3-border">
<div class="operation-report-container <?php echo $containerClass?>">
<?php
if(isset($bussinessInfoUpdateResult)){
	echo $bussinessInfoUpdateResult;
}
else if(isset($personalInfoUpdateResult)){
	echo $personalInfoUpdateResult;
}
else if(isset($passwordUpdateResult)){
	echo $passwordUpdateResult;
}

?>
</div>
</div>
<?php
}
?>
<div class="padding-5 f7-background">
<ul class="no-padding">

<div class="settings-section">
<li><a href="account.php">Edit Business Information</a> <span class="float-right"><span class="glyphicon glyphicon-collapse-down"></span></span></li>
<div class="main-form">
<form action="../manage/#account" method="POST">
<div class="form-group">
<label><span class="glyphicon glyphicon-map-marker red"></span>Office Address</label>
<input class="form-control" placeholder="Office Address" name="OfficeAddress" type="text" required="required" value="<?php echo $editOfficeAddress ?>"/>
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Office Tel Number</label>
<input class="form-control" placeholder="office Telephone Number" name="OfficeTelNo" type="text" maxlength="11"  required="required" value="<?php echo $editOfficeTelNo?>"/>
</div>

<div class="form-group">
<label><span class="glyphicon bold red">@</span>Business email </label>
<input class="form-control" placeholder="Business email address" name="Businessmail" type="email" size="30" value="<?php echo $editBusinessmail ?>"/>
</div>

<input type="submit" name="changeBusinessInfo" class="btn btn-primary" value="save"/>
</form>

</div>
</div>

<div class="settings-section">
<li><a href="account.php">Edit Business Owner Information</a><span class="float-right"><span class="glyphicon glyphicon-collapse-down"></span></span></li>
<div class="main-form">
<form action="../manage/#account" method="POST">
<div class="form-group">
<label>Name</label> 
<input class="form-control" placeholder="CEO's full name" name="CEOName" type="text" required="required" value="<?php echo $editCEO ?>"  />
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Phone No</label>
<input class="form-control" placeholder="CEO's active phone number" name="Phone1" type="text" maxlength="11" required="required" value="<?php echo $editPhoneno ?>" />
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Alternative Phone No</label> 
<input class="form-control" placeholder="CEO's alternative active phone number" name="Phone2" type="text" maxlength="11" value="<?php echo $editAltPhoneno ?>" />
</div>

<div class="form-group">
<label><span class="glyphicon bold red">@</span>email</label> 
<input class="form-control" placeholder="CEO's working email address" name="email" type="email"  value="<?php echo $editemail ?>" />
</div>

<input type="submit" name="changePersonalInfo" class="btn btn-primary" value="save"/>
</form>
</div>
</div>

<div class="settings-section">
<li><a href="account.php">Change Account Password</a> <span class="float-right"><span class="glyphicon glyphicon-collapse-down"></span></span></li>
<div class="main-form">
<form action="../manage/#account" method="POST">

<div class="form-group">
<label><span class="glyphicon bold red"></span>Old password</label> 
<input class="form-control" placeholder="old password" name="oldPassword" type="password"  />
</div>

<div class="form-group">
<label><span class="glyphicon bold red"></span>New Password</label> 
<input class="form-control" placeholder="new password" name="newPassword1" type="password"  />
</div>

<div class="form-group">
<label><span class="glyphicon bold red"></span>Repeat New Password</label> 
<input class="form-control" placeholder="new password" name="newPassword2" type="password"  />
</div>

<input type="submit" name="changePassword" class="btn btn-primary" value="change password"/>
</form>
</div>
</div>
<div class="settings-section">
<li><a href="" class="red">Deactivate Account</a></li>
<div class="main-form" id="deactivate">
<form action="" method="POST">
<p class="text-center font-20 red bold"> Are you sure you want to deactivate this account</p>
<ul>
<li>You will no longer be able to <span class="red">post your properties</span> until you have another account</li>
<li>All your <span class="red"><?php $total_uploads ?> properties</span> will be deleted</li>
<li>All your <span class="red">contacts</span> including <span class="red">phone numbers</span> and <span class="red">emails</span> will be deleted</li>
<li>All <span class="red">messages</span> and <span class="red">notifications</span> will be deleted</li>
</ul>

<div class="text-center">
<input type="button" name="" class="btn btn-primary" value="Cancel" onclick="javascript: document.querySelector('.main-form#deactivate').style.display = 'none'"/>
<input type="submit" name="deactivateAccount" class="btn btn-danger" value="Deactivate"/>
</div>
</form>
</div>

</div>
</ul>
</div>
</div>

</div>
<?php require('../resources/global/footer.php'); ?>

<script>
var pid = document.querySelector('#pid');
var agent = document.querySelector('input#agent-username').value;
var properties = document.querySelector('#property-list-area');
var propertyList = properties.innerHTML;

pid.onkeyup = function(){
	if(pid.value == ''){
properties.innerHTML = 	propertyList;
}
else{
	properties.innerHTML = "<div class=\"text-center font-18 blue\" id=\"searching\"><p>searching for your property with PID <strong>'"+pid.value+"'</strong></p><img src=\"../resrc/gifs/progress-circle.gif\" width=\"50px\" height=\"50px\" style=\"border:none; background-image:none\"/></div>";
	
ajax = ajaxObject();
	ajax.onreadystatechange = function(){
//if the script is OK
	if(ajax.status==200){
//if communication was successfull and response is gotten successfully
if(ajax.readyState == 4){
properties.innerHTML = ajax.responseText;
		}
		else{
properties.innerHTML = "something went wrong while searching for the property with the PID "+ pid.value+"<br/><br/>"+ajax.responseText;
		}
}
	else if(ajax.status==404){
		
	}
}
url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/searchpropertybyid.php?pid="+pid.value+'&agent='+agent;
ajax.open("GET",url,true);
ajax.send();
}
}


var settingHeaders = document.querySelectorAll('.settings-section');
for(i = 0 ;i < settingHeaders.length;i++){
	//settingHeaders[i].querySelector('div.main-form').style.display = 'none';
	toggleSetting(settingHeaders[i]);
}
function toggleSetting(section){
	var trigger = section.querySelector('li');
	var form = section.querySelector('div.main-form');
	toggle(trigger,form);
	}
</script>
</div>
</body>
</html>








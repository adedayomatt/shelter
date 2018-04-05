<?php 
require('../resources/master_script.php'); 
if($status != 1){
	$tool->redirect_to('../login?return='.$current_url);
}

if(isset($_POST['changeBusinessInfo'])){
	$update_business_info = $loggedIn_agent->update_business_info($tool->clean_input($_POST['OfficeAddress']),$tool->clean_input($_POST['OfficeTelNo']),$tool->clean_input($_POST['Businessmail']));
	if($update_business_info == 99){
		$bussinessInfoUpdateResult = "Invalid office Tel Number";
		$success = false;
	}
	else if($update_business_info == 900){
			$bussinessInfoUpdateResult = "Business Info update failed";
			$success = false;
	}
	else if($update_business_info == 100){
		$bussinessInfoUpdateResult = "Business Info updated successfully";
		$success = true;
	}
}

if(isset($_POST['changePersonalInfo'])){
	$update_personal_info = $loggedIn_agent->update_personal_info($tool->clean_input($_POST['CEOName']),$tool->clean_input($_POST['Phone1']),$tool->clean_input($_POST['Phone2']),$tool->clean_input($_POST['email']));
	if($update_personal_info == 99){
		$personalInfoUpdateResult = "Invalid Phone Number(s)";
		$success = false;
	}
	else if($update_personal_info == 900){
		$personalInfoUpdateResult = "Personal Info update failed";
		$success = false;
	}
	else if($update_personal_info == 100){
		$personalInfoUpdateResult = "Personal Info updated successfully";
		$success = true;
	}
}


if(isset($_POST['changePassword'])){
	$change_password = $loggedIn_agent->change_password($_POST['oldPassword'],$_POST['newPassword1'],$_POST['newPassword2']);
	if($change_password == 99){
		$passwordUpdateResult = "Incorrect Old Password";
		$success = false;
	}
	else if($change_password == 69){
		$passwordUpdateResult = "Passwords do not match. Try again";
		$success = false;
	}
	else if($change_password == 900){
		$passwordUpdateResult = "Password change failed";
		$success = false;
	}
	else if($change_password == 100){
		$passwordUpdateResult = "Password successfully changed";
		$success = true;
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
<style>
.settings-section{
	border:1px solid #e3e3e3;
	margin:3px 0px; 
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
.container-fluid{
	padding-left:30px;
	padding-right:30px;
}
}
</style>

</head>
<body>
<?php
require('../resources/global/header.php');
?>
<?php
if(isset($_POST['deactivateAccount'])){
	?>
	
<?php
}
?>

<div class="container-fluid pad-lg pad-md pad-sm no-pad-xs">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-content">
<div class="row hidden-lg hidden-md hidden-sm visible-xs red-background" style="margin-bottom:5px">
<div class="col-xs-6 padding-5 text-center e3-border"><a href="#properties" class="white font-20">Properties</a></div>
<div class="col-xs-6 padding-5 text-center e3-border"><a href="#account" class="white font-20">Account</a></div>
</div>
<input type="hidden" id="agent-username" value="<?php echo $loggedIn_agent->username ?>" />
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 e3-border" id="properties">
<div class="padding-5 white-background " style="border-right:5px solid red">
<h3>Properties</h3>
</div>
<div class="f7-background padding-10">
<?php
$total_uploads = count($loggedIn_agent->uploads());
?>
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
$fiveDaysAgo = time() - (5 * 86400);
$needsUpdate = $db->query_object("SELECT property_ID FROM properties WHERE (uploadby='".$loggedIn_agent->username."' AND last_reviewed <= $fiveDaysAgo) ORDER BY last_reviewed DESC LIMIT 10");
	if($needsUpdate->num_rows > 0){
	?>
		<h4 class="text-center red"><span class="glyphicon glyphicon-info-sign"></span>You need to update the following properties</h4>
<?php
	while($ru = $needsUpdate->fetch_array(MYSQLI_ASSOC)){
		$p = new property($ru['property_ID']);
		?>
	<div class="row white-background e3-border" style="margin-bottom:5px">
		<div class="padding-5">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<img src="<?php echo $p->display_photo_url() ?>" class="mini-property-image size-100"/>
		</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<div class="font-20 margin-5"><a href="<?php echo "../properties/".$p->p_directory?>"><?php echo $p->type ?></a></div>
			<div class="margin-5 grey"><span class="glyphicon glyphicon-map-marker red"></span><?php echo $p->location ?></div>
			<div class="margin-5 grey"><span class="glyphicon glyphicon-calendar red"></span>updated <?php echo $tool->since($p->last_reviewed) ?></div>
			<div class="margin-5 grey"><a class="btn btn-primary" href="<?php echo 'property.php?id='.$p->id.'&action=change&agent='.$p->agent_token ?>"><span class="glyphicon glyphicon-pencil"></span>update</a> <a class="text-right float-right " href=""><span class="glyphicon glyphicon-trash red"></span></a></div>
			</div>
		</div>
	</div>
		<?php
	}
}
else{
	
}
?>
</div>
<?php
}
?>
</div>
</div>
</div>

<div class="col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-6 col-xs-12 e3-border" id="account" >
<div class="padding-5 white-background " style="border-right:5px solid red">
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

<div class="settings-section" data-action="toggle">
<li data-toggle-role="toggle-trigger" data-toggle-off="Edit Business Information" data-toggle-on="Hide Business Information Settings">Edit Business Information<span class="float-right"><span class="glyphicon glyphicon-collapse-down"></span></span></li>
<div class="main-form" data-toggle-role="main-toggle">
<form action="../manage/#account" method="POST">
<div class="form-group">
<label><span class="glyphicon glyphicon-map-marker red"></span>Office Address</label>
<input class="form-control" placeholder="Office Address" name="OfficeAddress" type="text" required="required" value="<?php echo $loggedIn_agent->address ?>"/>
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Office Tel Number</label>
<input class="form-control" placeholder="office Telephone Number" name="OfficeTelNo" type="text" maxlength="11"  required="required" value="<?php echo $loggedIn_agent->office_contact ?>"/>
</div>

<div class="form-group">
<label><span class="glyphicon bold red">@</span>Business email </label>
<input class="form-control" placeholder="Business email address" name="Businessmail" type="email" size="30" value="<?php echo $loggedIn_agent->business_mail ?>"/>
</div>

<input type="submit" name="changeBusinessInfo" class="btn btn-primary" value="save"/>
</form>

</div>
</div>

<div class="settings-section" data-action="toggle">
<li data-toggle-role="toggle-trigger" data-toggle-off="Edit Business Owner Info" data-toggle-on="Hide Business Owner Info">Edit Business Owner Information<span class="float-right"><span class="glyphicon glyphicon-collapse-down"></span></span></li>
<div class="main-form" data-toggle-role="main-toggle">
<form action="../manage/#account" method="POST">
<div class="form-group">
<label>Name</label> 
<input class="form-control" placeholder="CEO's full name" name="CEOName" type="text" required="required" value="<?php echo $loggedIn_agent->CEO ?>"  />
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Phone No</label>
<input class="form-control" placeholder="CEO's active phone number" name="Phone1" type="text" maxlength="11" required="required" value="<?php echo $loggedIn_agent->contact1 ?>" />
</div>

<div class="form-group">
<label><span class="glyphicon glyphicon-phone red"></span>Alternative Phone No</label> 
<input class="form-control" placeholder="CEO's alternative active phone number" name="Phone2" type="text" maxlength="11" value="<?php echo $loggedIn_agent->contact2 ?>" />
</div>

<div class="form-group">
<label><span class="glyphicon bold red">@</span>email</label> 
<input class="form-control" placeholder="CEO's working email address" name="email" type="email"  value="<?php echo $loggedIn_agent->CEO_mail ?>" />
</div>

<input type="submit" name="changePersonalInfo" class="btn btn-primary" value="save"/>
</form>
</div>
</div>

<div class="settings-section" data-action="toggle">
<li data-toggle-role="toggle-trigger" data-toggle-off="Change Account Password" data-toggle-on="Hide Password Settings">Change Account Password</li>
<div class="main-form" data-toggle-role="main-toggle">
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
<div class="settings-section" data-action="toggle">
<li data-toggle-role="toggle-trigger" data-toggle-off="Deactivate Account" data-toggle-on="Deactivate Account">Deactivate Account</li>
<div class="main-form" id="deactivate" data-toggle-role="main-toggle">
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
	properties.innerHTML = "<div class=\"white-background text-center font-18 blue\" id=\"searching\" data-loading-content =\"loading\" style=\"height:200px\"><p>searching for your property with PID <strong>'"+pid.value+"'</strong></p></div>";
	
	var getProperty = new useAjax(doc_root+"/resources/php/api/searchpropertybyid.php?pid="+pid.value+'&agent='+agent);
	getProperty.go(function(code,response){
		if(code == 204){
properties.innerHTML = response;
		}
	});
}
}

</script>
</div>
</div>
</div>
</body>
</html>








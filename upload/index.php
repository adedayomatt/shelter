<?php session_start();
require('../resources/php/master_script.php');

//if agent is not logged in want to access this page
	if($status != 1){
		$general->redirect('login?return='.$thisPage);
	}

//create object for the property class
$property_obj = new property();



/*
if upload is submitted
*/
if(isset($_POST['upload'])){
$missing = array();


//verify necessary fields
if($_POST['type']=="Select type"){
	$missing[] = "Property type need to be specified";
}
if(!is_numeric($_POST['rent']) || empty($_POST['rent'])){
	$missing[] = "Invalid amount of rent";
}
if(!isset($_POST['min_payment'])){
	$missing[] = "Minimum payment required need to specified";
}
if(empty($_POST['location'])){
	$missing[] = "Address of the property is missing";
}
//if all necessary fields are filled correctly
if(empty($missing)){
	//Receiving information from the submitted form
$propertyId = $property_obj->generate_property_id();
$type = $_POST['type'];
$location =$connection->real_escape_string(trim(htmlentities($_POST['location'])));
$rent = $_POST['rent'];
$min_payment = (isset($_POST['min_payment']) ? $_POST['min_payment'] : 'No');
$bath = (isset($_POST['bath']) ? $_POST['bath'] :'No');
$loo = (isset($_POST['loo']) ? $_POST['loo'] : 'No') ;
$pmachine = (isset($_POST['pmachine']) ? $_POST['pmachine'] : 'No' ) ;
$borehole = (isset($_POST['borehole']) ? $_POST['borehole'] : 'No');
$well = (isset($_POST['well']) ? $_POST['well'] : 'No');
$tiles = (isset($_POST['tiles']) ? $_POST['tiles'] : 'No');
$pspace = (isset($_POST['pspace']) ? $_POST['pspace'] : 'No');

$electricity = $_POST['electricity'];
$road = $_POST['road'];
$social = $_POST['social'];
$security = $_POST['security'];
$description = $connection->real_escape_string(trim(htmlentities($_POST['description'])));
$timestamp = time();
$dirName = $propertyId." ".$type." ".$location;
//replace space with -
$dirName = trim(str_replace(array(",","-",".")," ",$dirName));
$dirName = str_replace(" ","-",$dirName);

$uploadQuery = "INSERT INTO properties 
		(property_ID,directory,type,location,rent,min_payment,bath,toilet,pumping_machine,borehole,well,tiles,parking_space,electricity,road,socialization,security,description,uploadby,date_uploaded,timestamp,status,last_reviewed)
		VALUES('$propertyId','$dirName','$type','$location',$rent,'$min_payment',$bath,$loo,'$pmachine','$borehole','$well','$tiles','$pspace',$electricity,$road,$social,$security,'$description','$profile_name',NOW(),$timestamp,'Available',$timestamp)";
//echo $upload;
$upload = $db->query_object($uploadQuery);
//if record added successfully
if(!$connection->error && $connection->affected_rows == 1){
	$activityID = uniqid(time());
//$db->query_object("INSERT INTO activities (activityID, action, subject, subject_ID, subject_Username, status,otherlink,timestamp) VALUES('$activityID','upload','$Business_Name','$profile_name','$myid','unseen','$dirName',$timestamp)");

	//create a directory for new property 
$propertydir = '../properties/'.$dirName;
//this session variables are for a particular upload session, it is used for verification when photos are to be added
$_SESSION['directory'] = $propertydir;
	$_SESSION['id'] = $propertyId;
		if(mkdir($propertydir)){
//This is a prepared statement for a new php file that will be the index of the new directory
$prepared = "
<?php 
require('../../resources/php/master_script.php'); ?>
		<html>
<head>
<?php \$pagetitle=\"$propertyId - $type for rent\"; 
require('../../resources/global/meta-head.php') ?>
<link href=\"../../css/header_styles.css\" type=\"text/css\" rel=\"stylesheet\" />
<link href=\"../../css/details_styles.css\" type=\"text/css\" rel=\"stylesheet\" />
</head>
<body class=\"no-pic-background\">
<?php
\$ID = \"$propertyId\";
require('../detail.php');
?>
</body>
</html>";
					
//create the index.php file
			$open = fopen("$propertydir/index.php",'w');
			$write = fwrite($open,$prepared);
			fclose($open);
			}	
	header("Location: $root/upload/addphoto.php?ptk=".$_COOKIE['PHPSESSID']."&cmpLt=".uniqid()."&sHptk=".SHA1($_COOKIE['PHPSESSID']));
	exit();
}
else{
	echo"<script>alert(\"There was an error\"); \"</script>";
	//window.location=\"http://localhost/shelter/upload
		}
}
else{
$uploadError = "<h3 style=\"color:red; font-weight:normal;font-size:150%\">Cannot continue with upload</h3>
<ul>";
	foreach($missing as $error){
$uploadError .= "<li>$error</li>";
	}
$uploadError .= "</ul>";
}
}
 ?>
 <!DOCTYPE html>
<html>
<head>
<?php
$ref = "upload_page";
$pagetitle = "Upload Property";
 require('../resources/global/meta-head.php'); ?>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="verify.js" ></script>

<style type="text/css" rel="stylesheet">
.upload-section-showing{
		display:block;
	}
.upload-section-hidden{
		display:none;
	}
	
.active-step,.inactive-step{
    cursor:pointer;
}
.active-step{
font-size: 170%;
color:yellow;
}
.inactive-step{
font-size: 100%;
color:#e0f2f1;
}

.active-step-no{
background-color:white;
color:#20435C;
padding:5px 15px 5px 15px;
}
.inactive-step-no{
background-color:grey;
color:white;
padding:5px 10px 5px 10px;
}
 .active-step-no,.inactive-step-no{
        border-radius:50%;
    }
	.step{
	margin-bottom:20px;
	}
</style>

<noscript>you need javascript to use this site!!
	<style type="text/css" rel="stylesheet">
		.upload-section-hidden{
    display:block;
}
	</style>
</noscript>

<script>
function check(){
if(document.details.rent.value<0){
	alert("Rent cannot be negative");
	document.details.rent.focus();
	return false;
}
else if(document.details.type.value=="Select type"){
	alert("Select the type of property");
	document.details.type.focus();
	return false;
}
else{
	return true;
}
	
}
	function nextStep(currentStep,nextStep,progressStatus){
		if(currentStep == 'jumpTo'){
		//hide all section ...
document.querySelector('[class^=upload-section]').className = 'upload-section-hidden';
		}
		else{
document.querySelector('[class^=upload-section]#'+currentStep).className = 'upload-section-hidden';
		}
		//...show only @nextStep
document.querySelector('[class^=upload-section]#'+nextStep).className = 'upload-section-showing';

document.querySelector('#'+progressStatus+'>span[class$=step-no]').className = 'active-step-no';
document.querySelector('.active-step:not(#'+progressStatus+')>span[class$=step-no]').className = 'inactive-step-no';

document.querySelector('#'+progressStatus).className = 'active-step';
document.querySelector('.active-step:not(#'+progressStatus+')').className = 'inactive-step';

var Yoffset = window.pageYOffset;
var goUp = setInterval(steadyScrollUp,1);

function steadyScrollUp(){

if(Yoffset <= 5){
	clearInterval(goUp);
}
else{
window.scrollTo(0,Yoffset);
		Yoffset -= 20;
}
		
}

	}
	</script>
</head>
<body class="plain-colored-background">
<?php
$altHeaderContent ="Upload Property";
require('../resources/global/alt_static_header.php');
?>

<div class="container-fluid body-content" style="padding-top:70px">
<div class="width-80p margin-auto" style="margin-bottom:30px">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center step">
<span  class="active-step " id="upload-progress-basic-info" title="Basic Details">
		<span class="active-step-no" id="basic-info-step-no">1</span>
		« Basics »
		</span>
	</div>
	
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center step">
	<span  class="inactive-step" id="upload-progress-facilities" title="Facilites">
	<span class="inactive-step-no" id="facilities-step-no">2</span>
		« Facilities »
		</span>
</div>

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center step">
	<span  class="inactive-step" id="upload-progress-rating" title="Rating">
		<span class="inactive-step-no" id="rating-step-no">3</span>
		« Rating »
		</span>
</div>

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center step">
	<span class="inactive-step" id="upload-progress-addphoto">
		<span class="inactive-step-no" id="photo-step-no">4</span>
		« Photos »
		</span>
		</div>
</div>
</div>

<div class="center-content white-background padding-20">
<form name="details" action="<?php $_PHP_SELF ?>" method="POST"onsubmit="">

<div class="upload-section-showing" id="basic-info">
	<?php
	if(isset($uploadError)){
		echo "<div class=\"operation-report-container fail\" style=\"text-align:left\">$uploadError</div>";
	}
	?>
<fieldset>
<h2 class="upload-heading">Basic Details</h2>
<hr class="grey">
<p class="help-block">Provide the basic information about the property, all the fields in this section are necessary</p>

<div class="form-group">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<label>Select the property type</label>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<select class="form-control" name="type">
<option value="Select type">Select type</option>
<option value="Boys Quater">Boys Quater</option>
<option value="Bungalow">Bungalow</option>
<option value="Duplex">Duplex</option>
<option value="Flat">Flat</option>
<option value="Hall">Hall</option>
<option value="Land">Land</option>
<option value="Office Space">Office Space</option>
<option value="Self Contain">Self Contain</option>
<option value="Semi detached House">Semi detached House</option>
<option value="Shop">Shop</option>
<option value="Warehouse">Warehouse</option>
</select>
</div>
</div>
</div>

<hr class="grey" />

<div class="form-group">
<div class="row">

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label for="rent"><span class="glyphicon glyphicon-tags"></span>Rent</label>
</div>

<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
<input class="form-control inline" name="rent" type="text" value="<?php echo (isset($_POST['rent']) ? $_POST['rent'] : '') ?>" placeholder="Actual rent per year" maxlength="7"/>
</div>

</div>

</div>

<hr class="grey" />

<label for="duration"><span class="glyphicon glyphicon-equalizer"></span>Minimum payment required </label>
<div class="form-group">
<label class="radio-inline">
<input name="min_payment" type="radio" value="1 year"/>1 year
</label> 

<label class="radio-inline">
<input name="min_payment" type="radio" value="1 year, 6 months"/>1 Year, 6 Months
</label>

<label class="radio-inline">
<input name="min_payment" type="radio" value="2 years"/>2 Years
</label>
</div>

<hr class="grey" />


<div class="form-group">
<label for="location"><span class="glyphicon glyphicon-map-marker"></span>Location </label>
<input class="form-control" name="location" type="text" size="50" value="<?php echo (isset($_POST['location']) ? $_POST['location'] : '') ?>" placeholder="Address of the property"/><br/><br/>
</div>

<hr class="grey" />

</fieldset>

<div class="continue-or-back-button-wrapper">
<a class="continue-or-back-button continue" onclick="javascript: nextStep('basic-info','facilities','upload-progress-facilities')">Continue »</a>
		</div>
</div>


<div class="upload-section-hidden" id="facilities">
<fieldset>
<h2 class="upload-heading">Facilities</h2>
<hr class="grey">

<h3><span class="glyphicon glyphicon-tint"></span>Water supply</h3>
<p class="help-block" >Check for presence of facility</p>

<div class="checkbox">
<label for="pmachine">
 <input name="pmachine" type="checkbox" value="Yes"/>Pumping Machine</label>
</div>

<div class="checkbox">
<label for="borehole">
<input name="borehole" type="checkbox" value="Yes"/>Borehole</label>
</div>

<div class="checkbox">
<label for="well">
<input name="well" type="checkbox" value="Yes"/>Well</label>
</div>

<hr class="grey" />
<div class="row">
<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
<label for="bath">Bathroom</label>
<select class="form-control" name="bath">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">more than 4</option>
</select>
</div>

<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
<label for="loo">Toilet</label>
<select class="form-control" name="loo">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">more than 4</option>
</select>
</div>
</div>
<hr class="grey" />

<div class="checkbox">
<label for="tiles">
<input  name="tiles" type="checkbox" value="Yes"/>Tiles</label>
</div>

<div class="checkbox">
<label for="pspace">
<input  name="pspace" type="checkbox" value="Yes"/>Parking space</label>
</div>

<hr class="grey" />

</fieldset>

<div class="continue-or-back-button-wrapper">

<a class="continue-or-back-button continue" onclick="javascript: nextStep('facilities','rating','upload-progress-rating')">Continue »</a>
<a class="continue-or-back-button go-back" onclick="javascript: nextStep('facilities','basic-info','upload-progress-basic-info')">« Go back</a>
</div>
</div>

<div class="upload-section-hidden" id="rating">
<fieldset>
<h2 class="upload-heading">Rating</h2>
<hr class="grey" />
<p class="help-block">Rate this property and it's amenities on a scale of 0% - 100% <a href="">learn about property rating</a></p>
<div class="row">
<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
<label for="electricity">Electricity</label>
<select class="form-control" name="electricity">
<option value="0">N/A</option>
<option value="0">0%</option>
<option value="10">10%</option>
<option value="15">15%</option>
<option value="20">20%</option>
<option value="30">30%</option>
<option value="40">40%</option>
<option value="50">50%</option>
<option value="60">60%</option>
<option value="70">70%</option>
<option value="80">80%</option>
<option value="90">90%</option>
<option value="100">100%</option>
</select>
</div>

<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
<label for="road">Road</label>
<select class="form-control" name="road">
<option value="0">N/A</option>
<option value="0">0%</option>
<option value="10">10%</option>
<option value="15">15%</option>
<option value="20">20%</option>
<option value="30">30%</option>
<option value="40">40%</option>
<option value="50">50%</option>
<option value="60">60%</option>
<option value="70">70%</option>
<option value="80">80%</option>
<option value="90">90%</option>
<option value="100">100%</option>
</select>
</div>

<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
<label for="social">Socialization</label>
<select class="form-control" name="social">
<option value="0">N/A</option>
<option value="0">0%</option>
<option value="10">10%</option>
<option value="15">15%</option>
<option value="20">20%</option>
<option value="30">30%</option>
<option value="40">40%</option>
<option value="50">50%</option>
<option value="60">60%</option>
<option value="70">70%</option>
<option value="80">80%</option>
<option value="90">90%</option>
<option value="100">100%</option>
</select>
</div>

<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
<label for="security">Security</label>
<select class="form-control" name="security">
<option value="0">N/A</option>
<option value="0">0%</option>
<option value="10">10%</option>
<option value="15">15%</option>
<option value="20">20%</option>
<option value="30">30%</option>
<option value="40">40%</option>
<option value="50">50%</option>
<option value="60">60%</option>
<option value="70">70%</option>
<option value="80">80%</option>
<option value="90">90%</option>
<option value="100">100%</option>
</select>
</div>

<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h3 class="">Description</h3>
<p class="help-block">Brief description of property</p>
<textarea class="form-control" name="description"  placeholder="comment...(150 characters or less)"></textarea>
</div>


</div>
</fieldset>

<hr class="grey" />
<div class="continue-or-back-button-wrapper">
<a class="continue-or-back-button go-back" onclick="javascript: nextStep('rating','facilities','upload-progress-facilities')">« Go back</a>

<input class="continue-or-back-button continue" name="upload" type="submit" value="continue »"/>
</div>
<p class="text-right">Continue to add photos</p>

</div>

</form>
</div>
</div>
</body>
</html>
<?php 
session_start();
require('../resources/master_script.php');

//if agent is not logged in want to access this page
	if($status != 1){
		$tool->redirect_to('../login?return='.$current_url);
	}

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
if(empty($_POST['city'])){
	$missing[] = "Location of the property is not complete, City missing";
}
if(empty($_POST['area'])){
	$missing[] = "Location of the property is not complete, Area missing";
}
//if all necessary fields are filled correctly
if(empty($missing)){
	$identifier = new identifier();
	$propertyId = $identifier->generate_property_id();
	
	$type = $_POST['type'];
	$location = $tool->clean_input($_POST['area'].' '.$_POST['city']);
	
$dirName = $propertyId." ".$type." ".$location;
//replace space with -
$dirName = trim(str_replace(array(",","-",".")," ",$dirName));

$dirName = str_replace(" ","-",$dirName);

$prepare_upload_query = "INSERT INTO properties 
		(property_ID,directory,type,area,city,rent,min_payment,bath,toilet,pumping_machine,borehole,well,tiles,parking_space,electricity,road,socialization,security,description,uploadby,date_uploaded,timestamp,status,last_reviewed)
		VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$upload = $db->prepare_statement($prepare_upload_query);
$upload->bind_param('sssssisiisssssiiiisssisi',$_propertyId,$_dirName,$_type,$_area,$_city,$_rent,$_min_payment,$_bath,$_loo,$_pmachine,$_borehole,$_well,$_tiles,$_pspace,$_electricity,$_road,$_social,$_security,$_description,$_agent_username,$_NOW,$timestamp,$_status,$_last_reviewed);

$_propertyId = $propertyId;
$_dirName = $dirName;
$_type = $type;
$_area = $tool->clean_input($_POST['area']);
$_city = $tool->clean_input($_POST['city']);
$_rent = $_POST['rent'];
$_min_payment = (isset($_POST['min_payment']) ? $_POST['min_payment'] : 'Nil');
$_bath = (isset($_POST['bath']) ? $_POST['bath'] :'No');
$_loo = (isset($_POST['loo']) ? $_POST['loo'] : 'No') ;
$_pmachine = (isset($_POST['pmachine']) ? $_POST['pmachine'] : 'No' ) ;
$_borehole = (isset($_POST['borehole']) ? $_POST['borehole'] : 'No');
$_well = (isset($_POST['well']) ? $_POST['well'] : 'No');
$_tiles = (isset($_POST['tiles']) ? $_POST['tiles'] : 'No');
$_pspace = (isset($_POST['pspace']) ? $_POST['pspace'] : 'No');
$_electricity = $_POST['electricity'];
$_road = $_POST['road'];
$_social = $_POST['social'];
$_security = $_POST['security'];
$_description = $tool->clean_input($_POST['description']);
$_agent_username = $loggedIn_agent->username;
$_NOW = "NOW()";
$timestamp = time();
$_status = 'Available';
$_last_reviewed = time();


$upload->execute();

//if record added successfully
if($upload->affected_rows == 1){
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
			require('../../resources/master_script.php'); ?>
			<html>
				<head>
					<?php \$pagetitle=\"$propertyId - $type for rent\"; 
					require('../../resources/global/meta-head.php') ?>
				</head>
				<body>
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
	$tool->redirect_to("$root/upload/addphoto.php?ptk=".$_COOKIE['PHPSESSID']."&cmpLt=".uniqid()."&sHptk=".SHA1($_COOKIE['PHPSESSID']));
}
else{
	echo"<script>alert(\"There was an error\"); \"</script>";
	//window.location=\"http://localhost/shelter/upload
		}
}
else{
$uploadError = "<h3>Cannot continue with upload</h3>
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
<script type="text/javascript" src="verify.js" ></script>

<style type="text/css" rel="stylesheet">
.upload-heading{
	font-size:25px;
}
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
color:#20435C;
}
.inactive-step{
font-size: 100%;
color:grey;
}

.active-step-no{
background-color:#20435C;
color:white;
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
<body class="white-background">
<?php
$altHeaderContent ="Upload Property";
require('../resources/global/alt_static_header.php');
?>
<style>@media all and (min-width: 768px),(min-device-width: 768px){
	.container-fluid{
	padding-top:50px;
}
.center-content{
	width:80% !important;
	border-radius:5px;
}
.form-control{
	width:50% !important;
}
}
@media all and (max-width: 768px),(max-device-width: 768px){
.container-fluid{
	padding-top:80px;
}
.center-content{
	width:100% !important;
}
}
</style>
<div class="container-fluid">
<div class="hidden-xs" style="margin-bottom:30px">
<div class="row opac-3-site-color-background padding-20">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center step">
<span  class="active-step " id="upload-progress-basic-info" title="Basic Details">
		<span class="active-step-no" id="basic-info-step-no">1</span>
		« Basics »
		</span>
	</div>
	
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center step">
	<span  class="inactive-step" id="upload-progress-facilities" title="Facilites">
	<span class="inactive-step-no" id="facilities-step-no">2</span>
		« Facilities »
		</span>
</div>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center step">
	<span  class="inactive-step" id="upload-progress-rating" title="Rating">
		<span class="inactive-step-no" id="rating-step-no">3</span>
		« Rating »
		</span>
</div>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center step">
	<span class="inactive-step" id="upload-progress-addphoto">
		<span class="inactive-step-no" id="photo-step-no">4</span>
		« Photos »
		</span>
		</div>
</div>
</div>

<div class="center-content">

<div class="padding-10 white-background">
<form name="details" action="<?php $_PHP_SELF ?>" method="POST"onsubmit="">

<div class="upload-section-showing" id="basic-info">
	<?php
	if(isset($uploadError)){
		echo "<div class=\"operation-report-container fail\" style=\"text-align:left\">$uploadError</div>";
	}
	?>
<fieldset>
<h4 class="upload-heading">Basic Details</h4>
<p class="help-block">Provide the basic information about the property, all the fields in this section are necessary</p>

<div class="row site-color-background white padding-10 margin-5-0 border-radius-5">
<p class="">Choose a purpose of the new property</p>
<div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-6">
  <label class="bold">
    <input type="radio" name="purpose" value="tolet" checked>
    To Let
  </label>
</div>
<div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-6">
  <label class="bold" >
    <input type="radio" name="purpose" value="forsale">
    For Sale
  </label>
</div>
</div>

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
<div class="input-group">
      <div class="input-group-addon">N</div>
	  <input class="form-control" name="rent" type="text" value="<?php echo (isset($_POST['rent']) ? $_POST['rent'] : '') ?>" placeholder="Actual rent per year" maxlength="7"/>
 </div>
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
<label for="location"><span class="glyphicon glyphicon-map-marker"></span>  Location </label>
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<div class="padding-5">
<input class="form-control" name="city" type="text" size="50" value="<?php echo (isset($_POST['city']) ? $_POST['city'] : '') ?>" placeholder="City e.g Ibadan, Lagos"/>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<div class="padding-5">
<input class="form-control" name="area" type="text" size="50" value="<?php echo (isset($_POST['area']) ? $_POST['area'] : '') ?>" placeholder="Area"/>
</div>
</div>
</div>
</div>

<script>
var city = document.querySelector("[name='city']");
var area = document.querySelector("[name='area']");
city.addEventListener('keyup',function(event){
	if(city.value == ""){
	area.setAttribute('placeholder', 'Area');
	}
	area.setAttribute('placeholder', 'Which area in '+city.value);
});
if(city.value == ""){
	area.setAttribute('editable', 'true');
}else{
	area.setAttribute('editable', 'false');
}
</script>
</fieldset>

<div class="text-center">
<a class="btn btn-primary" onclick="javascript: nextStep('basic-info','facilities','upload-progress-facilities')">Continue »</a>
</div>
</div>


<div class="upload-section-hidden" id="facilities">
<fieldset>
<h4 class="upload-heading">Facilities</h4>

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

<div class="row">
<p class="help-block" >Check for presence of facility</p>
<div class="checkbox col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label for="pmachine">
 <input name="pmachine" type="checkbox" value="Yes"/>Pumping Machine</label>
</div>

<div class="checkbox col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label for="borehole">
<input name="borehole" type="checkbox" value="Yes"/>Borehole</label>
</div>

<div class="checkbox col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label for="well">
<input name="well" type="checkbox" value="Yes"/>Well</label>
</div>

<div class="checkbox col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label for="tiles">
<input  name="tiles" type="checkbox" value="Yes"/>Tiles</label>
</div>

<div class="checkbox col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label for="pspace">
<input  name="pspace" type="checkbox" value="Yes"/>Parking space</label>
</div>

</div>

<hr class="grey" />

</fieldset>

<div class="text-center">
<a class="btn btn-primary margin-10" onclick="javascript: nextStep('facilities','basic-info','upload-progress-basic-info')">« Go back</a>
<a class="btn btn-primary margin-10" onclick="javascript: nextStep('facilities','rating','upload-progress-rating')">Continue »</a>
</div>
</div>

<div class="upload-section-hidden" id="rating">
<fieldset>
<h4 class="upload-heading">Rating</h4>
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
	<h4 class="">Description</h4>
<p class="help-block">Brief description of property</p>
<textarea class="form-control" name="description"  placeholder="comment...(150 characters or less)"></textarea>
</div>


</div>
</fieldset>

<hr class="grey" />

<div class="text-center">
<a class="btn btn-primary margin-10" onclick="javascript: nextStep('rating','facilities','upload-progress-facilities')">« Go back</a>
<input class="btn btn-primary margin-10" name="upload" type="submit" value="continue »"/>
<p class="text-right grey">Continue to add photos</p>

</div>

</div>

</form>
</div>
</div>
</div>
</body>
</html>
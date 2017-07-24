<?php session_start();
$connect = true;
require('../require/connexion.php');

//if agent is not logged in want to access this page
	if($status != 1){
		redirect();
	}

//create object for the property class
$property_obj = new property();

	function status($form_field){
	if(isset($form_field) AND !empty($form_field)){
	return $form_field;
}
else{
	return 'No';
			}
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
if(empty($_POST['location'])){
	$missing[] = "Address of the property is missing";
}
//if all necessary fields are filled correctly
if(empty($missing)){
	//Receiving information from the submitted form
$propertyId = $property_obj->generate_property_id();
$type = $_POST['type'];
$location =mysql_real_escape_string(trim(htmlentities($_POST['location'])));
$rent = $_POST['rent'];
$min_payment = @$_POST['min_payment'];
$bath = $_POST['bath'];
$loo = $_POST['loo'];
$pmachine = @status($_POST['pmachine']);
$borehole = @status($_POST['borehole']);
$well = @status($_POST['well']);
$tiles = @status($_POST['tiles']);
$pspace = @status($_POST['pspace']);
$electricity = $_POST['electricity'];
$road = $_POST['road'];
$social = $_POST['social'];
$security = $_POST['security'];
$description = mysql_real_escape_string(trim(htmlentities($_POST['description'])));
$timestamp = $now;
$dirName = $propertyId." ".$type." ".$location;
//replace space with -
$dirName = str_replace(" ","-",$dirName);

$upload = "INSERT INTO properties"; 
$upload .= "(property_ID,directory,type,location,rent,min_payment,bath,toilet,pumping_machine,borehole,well,tiles,parking_space,electricity,road,socialization,security,description,uploadby,date_uploaded,timestamp,status)";
$upload .="VALUES('$propertyId',trim('$dirName'),'$type','$location',$rent,'$min_payment',$bath,$loo,'$pmachine','$borehole','$well','$tiles','$pspace',$electricity,$road,$social,$security,'$description','$profile_name',NOW(),$timestamp,'available')";
//echo $upload;
$uploadQuery = mysql_query($upload);
//if record added successfully
if($uploadQuery){
	$activityID = uniqid(time());
@mysql_query("INSERT INTO activities (activityID, action, subject, subject_ID, subject_Username, status,otherlink,timestamp) VALUES('$activityID','upload','$Business_Name','$profile_name','$myid','unseen',trim('$dirName'),$timestamp)");

	//create a directory for new property 
$propertydir = '../properties/'.$dirName;
//this session variables are for a particular upload session, it is used for verification when photos are to be added
$_SESSION['directory'] = $propertydir;
	$_SESSION['id'] = $propertyId;
		if(mkdir($propertydir)){
//This is a prepared statement for a new php file that will be the index of the new directory
			$prepared = "<?php \$connect = true;
			require('../../require/connexion.php'); ?>
			<html>
			<?php require('../../require/meta-head.html'); ?>
<head>
<link href=\"../../css/general.css\" type=\"text/css\" rel=\"stylesheet\" />
<link href=\"../../css/header_styles.css\" type=\"text/css\" rel=\"stylesheet\" />
<link href=\"../../css/details_styles.css\" type=\"text/css\" rel=\"stylesheet\" />
<?php \$pagetitle=\"$propertyId - $type for rent\"; 
require('../../require/header.php') ?>
<script type=\"text/javascript\" language=\"javascript\" src=\"../../js/detailsscript.js\"></script>
</head>
<body class=\"pic-background\">
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
		mysql_close($db_connection);
	

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
<?php require('../require/meta-head.html'); ?>
<head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/upload_styles.css" type="text/css" rel="stylesheet" />
<title>Shelter | Upload property</title>
<?php
//$pagetitle = "upload";
	//$ref = 'upload';
	require('../require/plain-header.html');
	
?>

<script type="text/javascript" src="verify.js" ></script>

<style type="text/css" rel="stylesheet">
	.upload-section-showing{
		display:block;
	}
	.upload-section-hidden{
		display:none;
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
<body class="pic-background">


<div id="upload-progress-wrapper">
	<h3 class="major-headings">Upload property</h3><br/>
	<span  class="active-step" id="upload-progress-basic-info" title="Jump to Basic Details">
		<span class="active-step-no" id="basic-info-step-no">1</span>
		« Basic Details »
		</span>
	
	<span  class="inactive-step" id="upload-progress-facilities" title="Jump to Facilites">
	<span class="inactive-step-no" id="facilities-step-no">2</span>
		« Facilities »
		</span>

	<span  class="inactive-step" id="upload-progress-rating" title="Jump to Rating">
		<span class="inactive-step-no" id="rating-step-no">3</span>
		« Rating »
		</span>

	<span class="inactive-step" id="upload-progress-addphoto">
		<span class="inactive-step-no" id="photo-step-no">4</span>
		« Photos »
		</span>

</div>

<div id="ad-wrapper">
<img src="" id="ad-in-upload" alt="A graphic will appear here"/>
</div>
<div id="upload-form">
<form name="details" action="<?php $_PHP_SELF ?>" method="POST"onsubmit="">

<div class="upload-section-showing" id="basic-info">
	<?php
	if(isset($uploadError)){
		echo "<div class=\"upload-error-wrapper\">$uploadError</div>";
	}
	?>
<fieldset>
<h2 class="upload-heading">Basic Details</h2>

<div class="upload-input-wrapper basic-info">
<label>Select the property type</label>
<select name="type">
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

<div class="upload-input-wrapper basic-info">
<label for="rent">Rent</label><input id="rent-input" name="rent" type="text" placeholder="Actual rent" maxlength="7"/>/annum
</div>

<div class="upload-input-wrapper basic-info">
<label for="duration">Minimum payment required </label><input name="min_payment" type="radio" value="1 year"/>1 year <input name="min_payment" type="radio" value="1 year, 6 months"/>1Year, 6 Months <input name="min_payment" type="radio" value="2 years"/>2 Years<br/><br/>
</div>

<div class="upload-input-wrapper basic-info">
<label for="location">Location </label><input id="location-input" name="location" type="text" size="50" placeholder="Address of the property"/><br/><br/>
</div>

</fieldset>

<div class="continue-or-back-button-wrapper">
<a class="continue-or-back-button continue" onclick="javascript: nextStep('basic-info','facilities','upload-progress-facilities')">Continue »</a>
		</div>
</div>


<div class="upload-section-hidden" id="facilities">
<fieldset>
<h2 class="upload-heading">Facilities</h2>
<h3 class="upload-sub-heading">Water supply</h3>
<p class="instruction" >Check for presence of facility</p>

<div class="upload-input-wrapper facilities">
 <input name="pmachine" type="checkbox" value="Yes"/><label for="pmachine">Pumping Machine</label>
</div>

<div class="upload-input-wrapper facilities">
<input name="borehole" type="checkbox" value="Yes"/><label for="borehole">Borehole</label>
</div>

<div class="upload-input-wrapper facilities">
<input name="well" type="checkbox" value="Yes"/><label for="well">Well</label>
</div>

<div class="upload-input-wrapper facilities">
<label for="bath">Bathroom</label>
<select name="bath">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">more than 4</option>
</select>
</div>

<div class="upload-input-wrapper facilities">
<label for="loo">Toilet</label>
<select name="loo">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">more than 4</option>
</select>
</div>

<h3 class="upload-sub-heading">Other Facilities</h3>
<p class="instruction" >Check for presence of facility</p>
<div class="upload-input-wrapper facilities">
<input  name="tiles" type="checkbox" value="Yes"/><label for="tiles">Tiles</label>
</div>

<div class="upload-input-wrapper facilities">
<input  name="pspace" type="checkbox" value="Yes"/><label for="pspace">Parking space</label>
</div>

</fieldset>

<div class="continue-or-back-button-wrapper">

<a class="continue-or-back-button continue" onclick="javascript: nextStep('facilities','rating','upload-progress-rating')">Continue »</a>
<a class="continue-or-back-button go-back" onclick="javascript: nextStep('facilities','basic-info','upload-progress-basic-info')">« Go back</a>
</div>
</div>

<div class="upload-section-hidden" id="rating">
<fieldset>
<h2 class="upload-heading">Rating</h2>
<p class="instruction">Rate this property and it's amenities on a scale of 0% - 100% <a href="">learn about property rating</a></p>

<div class="upload-input-wrapper rating">
<label for="electricity">Electricity</label>
<select name="electricity">
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

<div class="upload-input-wrapper rating">
<label for="road">Road</label>
<select name="road">
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

<div class="upload-input-wrapper rating">
<label for="social">Socialization</label>
<select name="social">
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

<div class="upload-input-wrapper rating">
<label for="security">Security</label>
<select name="security">
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

<div class="description">
	<h3 class="upload-sub-heading">Description</h3>
<p class="instruction">Brief description of property</p>
<textarea name="description"  placeholder="comment...(150 characters or less)"></textarea>
</div>

</fieldset>
<div class="continue-or-back-button-wrapper">
<a class="continue-or-back-button go-back" onclick="javascript: nextStep('rating','facilities','upload-progress-facilities')">« Go back</a>

<input class="continue-or-back-button continue" name="upload" type="submit" value="continue »"/>
</div>

<div style="height:15px">
	<p class="instruction" style="float:right">Continue to add photos</p>
</div>


</div>

</form>
</div>
</body>
</html>
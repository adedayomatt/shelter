<?php session_start();
$connect = true;
require('../require/connexion.php');
 ?>
<html>
<?php require('../require/meta-head.html'); ?>
<head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<?php
$pagetitle = "upload";
	$ref = 'upload';
	
	$getuserName = true;
	require('../require/plain-header.html');
//if user is not logged in want to access this page
	if(!isset($_COOKIE['name'])){
		header("location: ../login");
		exit();
	}
	else{
		$profile_name = $_COOKIE['name'];
	}
?>

<?php

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

	//Receiving information from the submitted form
$propertyId = generateid();
$type = $_POST['type'];
$location =mysql_real_escape_string($_POST['location']);
$rent = $_POST['rent'];
$min_payment = $_POST['min_payment'];
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
$description = mysql_real_escape_string($_POST['description']);
$timestamp = time();
$dirName = $propertyId." ".$type." ".$location;
//replace ( ,.) with -
$dirName = str_replace(array(" ",",","."),"-",$dirName);
$upload = "INSERT INTO properties"; 
$upload .= "(property_ID,directory,type,location,rent,min_payment,bath,toilet,pumping_machine,borehole,well,tiles,parking_space,electricity,road,socialization,security,description,uploadby,date_uploaded,timestamp)";
$upload .="VALUES('$propertyId',trim('$dirName'),'$type','$location',$rent,'$min_payment',$bath,$loo,'$pmachine','$borehole','$well','$tiles','$pspace',$electricity,$road,$social,$security,'$description','$profile_name',NOW(),$timestamp)";
//echo $upload;
$uploadQuery = mysql_query($upload);
//if record added successfully
if($uploadQuery){
	$activityID = uniqid(time());
@mysql_query("INSERT INTO activities (activityID, action, subject, subject_ID, subject_Username, status,otherlink,timestamp) VALUES('$activityID','upload','$Business_Name','$profile_name','$myid','unseen',trim('$dirName'),$timestamp)");

	//create a directory for new property 
$propertydir = '../properties/'.$dirName;
$_SESSION['directory'] = $propertydir;
	$_SESSION['id'] = $propertyId;
		if(mkdir("$propertydir")){
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
	header("Location: $root/upload/addphoto.php");
	exit();
}
else{
	echo"<script>alert(\"There was an error\"); \"</script>";
	//window.location=\"http://localhost/shelter/upload
		}
		mysql_close($db_connection);
	

}

/*
This function  randomly generate a unique Id.
*/
function generateid(){
	$alphabets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	$firstalphaIndex = rand(0,25);
	$firstalpha  = $alphabets[$firstalphaIndex];
	$secondalphaIndex = rand(0,25);
	$secondalpha  = $alphabets[$secondalphaIndex];
	$thirdalphaIndex = rand(0,25);
	$thirdalpha  = $alphabets[$thirdalphaIndex];
	$figure = rand(1000,9999);
	$final = $firstalpha.$secondalpha.$thirdalpha.$figure;
	//check if the ID already exist
	//$connect =true;
	//require("../require/connexion.php");
	$fetchId = "SELECT property_ID FROM properties";
	$fetchIdQuery = mysql_query($fetchId);
	//if fetching the IDs is successfull...
	if($fetchIdQuery){
		while($id = mysql_fetch_array($fetchIdQuery,MYSQL_ASSOC)){
			if($id['property_ID'] == $final){
				$exist=$id['property_ID'];
			}
		}
		//if there is no any match with the final id, then return the value...
		if(!isset($exist)){
			return $final;
		}
		//if there is any match with the final id, then recurse the function generateid() until no match is found
		else{
			generateid();
		}
	}
	//if query to fetch id is unsucessful
	else{
		echo 'Error occur while verifying ID';
		}
	
}


?>
<script type="text/javascript" src="verify.js" ></script>
<noscript>you need javascript to use this site!!</noscript>
</head>
<body class="pic-background">

<div class="emp"></div>
<div class="upload-form">
<form name="details" action="<?php $_PHP_SELF ?>" method="POST"onsubmit="return(check());">
<fieldset><legend class="headings">Basic Information</legend>
<label>select the property type
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
</select></label><br/><br/>
<?php?>
<label for="rent">Rent N </label><input name="rent" type="text" placeholder="Actual rent"/> per annum<br/><br/>
<label for="duration">Minimum payment required </label><input name="min_payment" type="radio" value="1 year"/>1 year <input name="min_payment" type="radio" value="1 year, 6 months"/>1Year, 6 Months <input name="min_payment" type="radio" value="2 years"/>2 Years<br/><br/>
<label for="location">Location </label><input name="location" type="text" size="50" placeholder="Address of the property"/><br/><br/>
</fieldset>
<br/>
<fieldset><legend class="headings">Facilities</legend>
<p align="left"><b>Water supply</b></p>
<input name="pmachine" type="checkbox" value="Yes"/><label for="pmachine">Pumping Machine</label>
<input name="borehole" type="checkbox" value="Yes"/><label for="borehole">Borehole</label>
<input name="well" type="checkbox" value="Yes"/><label for="well">Well</label><br/><br/>
<label for="bath">Number of Bathroom</label>
<select name="bath">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">more than 4</option>
</select><br/>
<label for="loo">Number of Toilet</label>
<select name="loo">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">more than 4</option>
</select>
<br/><br/>
<p><b>Other Facilities</b></p>
<input  name="tiles" type="checkbox" value="Yes"/><label for="tiles">Tiles</label><br/>
<input  name="pspace" type="checkbox" value="Yes"/><label for="pspace">Parking space</label><br/>
</fieldset>
<br/>
<fieldset><legend class="headings">Rating</legend>
<p>Rate this property and it's amenities on a scale of 0% - 100% <a href="">learn about property rating</a></p>
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
<br/></fieldset><br/>
<label for="comment">Brief description of property</label><br/><textarea name="description"col="10" rows="4" placeholder="comment...(150 characters or less)"></textarea>
<input name="agentincharge" type="hidden" value="<?php  ?>"/>
<input name="upload" type="submit" value="continue" style="cursor: pointer"/>
</form>
</div>
</body>
<style>
.headings{
	color:#6D0AAA;
}

.emp{
	height:50px;
}
label{
	margin-bottom:10px;
}
.upload-form{
	width:70%;
margin-left:100px;
}
</style>
</html>
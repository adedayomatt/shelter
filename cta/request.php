
<?php 
require('../resources/php/master_script.php'); 
if($status != 9){
	$general->redirect('cta/checkin.php?_rdr=1');
}

if(isset($_POST['request'])){

	$query = "INSERT INTO cta_request (ctaid,ctaname,type,maxprice,location,timestamp) VALUES (?,?,?,?,?,?)";
	$p_query = $connection->prepare($query);
	$p_query->bind_param('issisi',$param_ctaid,$param_ctaname,$param_type,$param_maxprice,$param_location,$param_time);

if(!empty($_POST['maxprice']) && is_numeric($_POST['maxprice']) && !empty($_POST['type']) && !empty($_POST['location'])){
		$param_ctaid = $ctaid;
		$param_ctaname = $cta_name;
		$param_type = $_POST['type'];
		$param_maxprice = $_POST['maxprice'];
		$param_location = $connection->real_escape_string(htmlentities(trim($_POST['location'])));
		$param_time = time();
$p_query->execute();
if($p_query->affected_rows ==1){
$updatecta = $db->query_object("UPDATE cta SET request=1 WHERE ctaid=$ctaid");
if(is_string($updatecta)){	error::report_error($updatecta,__FILE__,__CLASS__,__FUNCTION__,__LINE__);}
else{
	//if request placing is successful and updating of cta
if($connection->affected_rows == 1){
	$requestplacementReport = "<b> $cta_name </b>, Your request has been placed, you will be notified as soon as there is any match for your preferences.<br/><br/><strong>Thank You</strong>";
	$sent = true;
		}
	}
}
else{
	$requestplacementReport = "Your placement could not be placed, try again later";
	$sent = false;
}
	
}
//invalid field
else{
$requestplacementReport = "Some fields are empty or filled incorrectly";	
	$sent = false;
		}
	}
	
else if(isset($_POST['change'])){

	if(!empty($_POST['type']) && is_numeric($_POST['maxprice']) && !empty($_POST['type']) && !empty($_POST['location'])){
	
		$param_ctaid = $ctaid;
		$param_type = ($_POST['type'] == 'nil' ? $_POST['former_type'] : $_POST['type']);
		$param_maxprice = $_POST['maxprice'];
		$param_location = $connection->real_escape_string(htmlentities(trim($_POST['location'])));

		
	$change_request = $db->query_object("UPDATE cta_request SET type='$param_type',maxprice=$param_maxprice,location='$param_location' WHERE ctaid=$ctaid");
if(is_string($change_request)){
	error::report_error($change_request,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
}
else{
//if request changing is successful
 if($connection->affected_rows == 1){
	$changeReport = "<strong>$cta_name</strong>, <br/>Your request has been <i>changed</i>, you will be notified as soon as there is any match for your preferences.<br/><br/><strong>Thank You</strong>";
	$change = true;
	}
else{
	$changeReport = "<strong>$cta_name</strong>, <br/>No change was made to your request";
	$change = false;
}
}
	
}
//invalid inputs
else{
$changeReport = "Some fields are empty or filled incorrectly";	
	$change = false;
		}
	}
?>
<!DOCTYPE html>
<html>

<head>
<?php
$pagetitle = "Request";
$ref='ctarequest_page';
require('../resources/global/meta-head.php'); 
?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
</head>

<body class="plain-colored-background">
<?php
$altHeaderContent ="Request";
require('../resources/global/alt_static_header.php');
?>
<div  class="container-fluid body-content" style="padding-top:70px">
<?php 
//if no request has been made
$requests_pref = $client->get_request($ctaid,$cta_name);
if(empty($requests_pref)) {
	if(!isset($_POST['request']) && !isset($_POST['change'])){
	echo "<div class=\"center-content white-background padding-10 e3-border text-center\" style=\"margin-bottom:5%\">
	<span class=\"glyphicon glyphicon-info-sign  icon-size-30 site-color\"></span>
	<p><strong>$cta_name</strong>, you have not specified your preferences of your choice of property.
	Kindly specify now or proceed to <a href=\"$root\">Home page</a></p>
	</div>";
	}
}
?>
<div class="center-content white-background padding-10 box-shadow-1">
<form action="<?php $_PHP_SELF ?>" method="POST">
<?php 
$placeOrChange = ((empty($requests_pref)) ? "request" : "change" )
?>
<fieldset>
<?php if(isset($requestplacementReport) && $sent==false){
	echo "<div class=\"operation-report-container fail\"><p>$requestplacementReport</p></div>";
}
else if(isset($requestplacementReport) && $sent==true){
	echo "<div class=\"operation-report-container success\"><p>$requestplacementReport<br/><a href=\"index.php\">continue</a></p></div>";
	$general->halt_page();
}
else if(isset($changeReport) && $change==true){
	echo "<div class=\"operation-report-container success\"><p>$changeReport<br/><a href=\"index.php\">continue</a></p></div>";
	$general->halt_page();
}
else if(isset($changeReport) && $change==false){
	echo "<div class=\"operation-report-container fail\"><p>$changeReport</p></div>";
}
?>

<h3 class="font-26">
 <?php echo ($placeOrChange == "request" ? "Place Request" : ($placeOrChange == "change" ? "Change Request" : "Unrecognized action"))?>
 </h3>
 <hr class="grey" />
<script type="text/javascript" >
function setType(value){
	var typeInput = document.getElementById('type-input');
	typeInput.value = value;
}
</script>

<div class="row">

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
<p>Property type : <span class="site-color bold"><?php echo (isset($_POST['type'])? $_POST['type'] : isset($request_type)? $request_type:'Not specified')?> </span></p>
<input type="hidden" name="former_type" value="<?php echo $request_type ?>"/>
</div>

<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
<select class="form-control" name="type">
<option value="nil" ><?php echo ($placeOrChange == "request" ? "Select Property type" : ($placeOrChange == "change" ? "Change" : "Invalid action"))?></option>
<option value="Boys Quater" >Boys Quater</option>
<option value="Bungalow" >Bungalow</option>
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
 <hr class="grey" />
<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" style="float:none">
<label for="maxprice">Maximum rent:</label>
<input class="form-control more-padding" name="maxprice" type="text" maxlength="10" value="<?php echo (isset($_POST['maxprice'])? $_POST['maxprice'] : isset($request_maxprice)? $request_maxprice:'')
?>" placeholder="Rent should not be more than..."/>
</div>
 <hr class="grey" />
<div class="form-group">
<label for="location"><span class="glyphicon glyphicon-map-marker"></span>Location:</label>
<input class="form-control more-padding" name="location" type="text" value="<?php echo (isset($_POST['location'])? $_POST['location'] : isset($request_location)? $request_location:'')
 ?>"  placeholder="around where?"/>
 </div>
 
<input class="btn btn-lg btn-block btn-primary site-color-background" name="<?php echo $placeOrChange ?>"  value="<?php echo $placeOrChange ?>" type="submit" />
 
</div>
</fieldset>
</form>
</div>
</div>
</body>
</html>
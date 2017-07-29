
<?php 
require('../resources/php/master_script.php'); 
if($status != 9){
	$general->redirect('cta/checkin.php?_rdr=1');
}

if(isset($_POST['request'])){

	$query = "INSERT INTO cta_request (ctaid,type,maxprice,location) VALUES (?,?,?,?)";
	$p_query = $connection->prepare($query);
	$p_query->bind_param('isis',$param_ctaid,$param_type,$param_maxprice,$param_location);

if(!empty($_POST['maxprice']) && is_numeric($_POST['maxprice']) && !empty($_POST['type']) && !empty($_POST['location'])){
		$param_ctaid = $ctaid;
		$param_type = $_POST['type'];
		$param_maxprice = $_POST['maxprice'];
		$param_location = $connection->real_escape_string(htmlentities(trim($_POST['location'])));
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
<?php require('../resources/html/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle = "Request";
$ref='ctarequest';
require('../resources/php/header.php');
?>



</head>
<style>
#all-header-container{
	display:none;
}
#request-form-container{
	background-color:white;
}
#request-error-container,#request-sent-container{
	width:98%;
	padding:2%;
	font-size:120%;
	border-radius:5px;
	background-color:#F5F5F5;
	border:1px solid #E3E3E3;
	border-radius:2px;
}
#request-error-container{
	color:red;
}
#request-sent-container{
}

input.request-input,.input-labels{
	display:block;
}
#type-input,#type-select{
	display:inline;
}
#request-not-specified-container{

}
#submit-button{
	background-color:#6D0AAA;
	color:white;
	border:none;
}
#submit-button:hover{
	background-color:grey;
	color:white;
}
@media only screen and (min-device-width: 300px) and (max-device-width: 1000px){
	#request-form-container{
		width:80%;
		margin:auto;
		padding:5%;
	margin-top:5%;
	line-height:300%;
	box-shadow:3px 3px 3px 3px #DDD;
}
legend{
	font-weight:normal;
	font-size:250%;
	letter-spacing:2px;
}
select{
	width:96%;
	padding:2%;
	
}
.request-input{
	width:90%;
	padding:3%;
}
#submit-button{
	width:90%;
	margin:auto;
	padding:5%;
	border-radius:10px;
	margin-top:50px;
}
}
@media only screen and (min-device-width: 1000px){
	#request-form-container{
	width:40%;
	margin:auto;
	margin-top:5%;
	padding:5%;
	line-height:200%;
	border-radius:5px;
}
fieldset{
	padding:5%;
}
legend{
	font-weight:normal;
	font-size:250%;
	letter-spacing:2px;
}
.request-input{
	width:94%;
	padding:2%;
}

#submit-button{
	width:30%;
	padding:2%;
	margin-top:20px;
	border-radius:5px;
}
}

</style>
<body class="mixedcolor-background">
<h1 align="center" style="font-size:300%; font-weight:normal; color:white;margin:0px">Shelter</h1>
<div class="box-shadow-1" id="request-form-container">
<?php 
//if no request has been made
if(isset($_GET['p']) && $_GET['p']==0) {
	if(!isset($_POST['request']) && !isset($_POST['change'])){
		if(empty($client->get_request($ctaid,$cta_name))){

		}
	echo "<div id=\"request-not-specified-container\"><p><strong>$cta_name</strong>, you have not specified your preferences of your choice of property.
	Kindly specify now or proceed to <a href=\"$root\">Home page</a></p>
	</div>";
	}
}
?>
<form action="<?php $_PHP_SELF ?>" method="POST">
<?php 
$placeOrChange = ((isset($_GET['p']) && $_GET['p']==0) ? "request":((isset($_GET['p']) && $_GET['p']==1) ? "change" : "invalid"))
?>
<fieldset>
<legend> <?php echo ($placeOrChange == "request" ? "Place Request" : ($placeOrChange == "change" ? "Change Request" : "Invalid action"))?> </legend>
<?php if(isset($requestplacementReport) && $sent==false){
	echo "<div id=\"request-error-container\"><p>$requestplacementReport</p></div>";
}
else if(isset($requestplacementReport) && $sent==true){
	echo "<div id=\"request-sent-container\"><p>$requestplacementReport<br/><a href=\"index.php\">continue</a></p></div>";
	$general->halt_page();
}
else if(isset($changeReport) && $change==true){
	echo "<div id=\"request-sent-container\"><p>$changeReport<br/><a href=\"index.php\">continue</a></p></div>";
	$general->halt_page();
}
else if(isset($changeReport) && $change==false){
	echo "<div id=\"request-error-container\"><p>$changeReport</p></div>";
}
?>
<script type="text/javascript" >
function setType(value){
	var typeInput = document.getElementById('type-input');
	typeInput.value = value;
}
</script>
<label>Property type :<?php echo (isset($_POST['type'])? $_POST['type'] : isset($request_type)? $request_type:'Not specified')?> </label>
<input type="hidden" name="former_type" value="<?php echo $request_type ?>"/>
<select id="type-select" name="type">
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
<label class="input-labels" for="maxprice">Maximum rent:</label>
<input class="request-input" name="maxprice" type="text" maxlength="10" value="<?php echo (isset($_POST['maxprice'])? $_POST['maxprice'] : isset($request_maxprice)? $request_maxprice:'')
?>" placeholder="Rent should not be more than..."/>
<label class="input-labels" for="location">Location:</label>
<input class="request-input" name="location" type="text" value="<?php echo (isset($_POST['location'])? $_POST['location'] : isset($request_location)? $request_location:'')
 ?>"  placeholder="around where?"/>
<input id="submit-button" name="<?php echo (isset($_GET['p'])? ($_GET['p']==1 ? 'change' : ($_GET['p']==0 ? 'request' : '')): '')?>" 
	  value="<?php echo (isset($_GET['p'])? ($_GET['p']==1 ? 'change' : ($_GET['p']==0 ? 'request' : '')): '') ?>"
type="submit" size="30" 
 />

</fieldset>
</form>
</div>
</body>
</html>
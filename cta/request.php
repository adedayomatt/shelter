
<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle = "Request";
$ref='ctarequest';
$connect = true;
$getuserName=true;
require('../require/header.php');
//if not no CTA is checked in
if($status != 9){
	mysql_close($db_connection);
	header('location: checkin.php?_rdr=1');
	exit();
}
?>
<?php
if(isset($_POST['request'])){
	if(!empty($_POST['maxprice']) && is_numeric($_POST['maxprice']) && !empty($_POST['type']) && !empty($_POST['location'])){
		$requestingtype = $_POST['type'];
		$requestingmaxprice = $_POST['maxprice'];
		$requestinglocation = mysql_real_escape_string($_POST['location']);

$placerequest = mysql_query("INSERT INTO cta_request (ctaid,type,maxprice,location) VALUE ('$ctaid','$requestingtype',$requestingmaxprice,'$requestinglocation')");
$updatecta = mysql_query("UPDATE cta SET request=1 WHERE ctaid='$ctaid' ");
//if request placing is successful and updating of cta
			if(($placerequest) && ($updatecta)){
	$requestplacementReport = "Dear $ctaname, Your request has been placed, you will be notified as soon as there is any match for your preferences.<br/><br/><strong>Thank You</strong>";
	$sent = true;
	}
else{
	$requestplacementReport = "Your placement could not be placed, try again later";
	$sent = false;
}
	
}
//if maxprice is not number
else{
$requestplacementReport = "Some fields are empty or filled incorrectly";	
	$sent = false;
		}
	}
	
else if(isset($_POST['change'])){
	if(!empty($_POST['type']) && is_numeric($_POST['maxprice']) && !empty($_POST['type']) && !empty($_POST['location'])){
		
		$changetype = $_POST['type'];
		$changemaxprice = $_POST['maxprice'];
		$changelocation = mysql_real_escape_string($_POST['location']);
		
   $updatecta = mysql_query("UPDATE cta SET request=1 WHERE ctaid='$ctaid'");
	$changerequest = mysql_query("UPDATE cta_request SET type='$changetype',maxprice=$changemaxprice,location='$changelocation' WHERE ctaid='$ctaid'");
//if request changing is successful
			if($changerequest){
	$changeReport = "Dear $ctaname, <br/>Your request has been <i>changed</i>, you will be notified as soon as there is any match for your preferences.<br/><br/><strong>Thank You</strong>";
	$change = true;
	}
else{
	$changeReport = "Dear $ctaname, <br/>Your placement could not be changed, try again later";
	$change = false;
}
	
}
//if maxprice is not number
else{
$changeReport = "Some fields are empty or filled incorrectly";	
	$change = false;
		}
	}
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
	padding:1%;
	font-size:150%;
	border-radius:5px;
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
	if(!isset($_POST['request'])){
	echo "<div id=\"request-not-specified-container\"><p>Hello <strong>$ctaname</strong>, you have not specified your preferences of your choice of property.
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
	exit();
}
else if(isset($changeReport) && $change==true){
	echo "<div id=\"request-sent-container\"><p>$changeReport<br/><a href=\"index.php\">continue</a></p></div>";
	exit();
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
<label>Property type :<?php echo (isset($_POST['type'])? $_POST['type'] : isset($rqtype)? $rqtype:'Not specified')?> </label>
<select id="type-select" name="type">
<option value="All types" ><?php echo ($placeOrChange == "request" ? "Select Property type" : ($placeOrChange == "change" ? "Change" : "Invalid action"))?></option>
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
<input class="request-input" name="maxprice" type="text" maxlength="10" value="<?php echo (isset($_POST['maxprice'])? $_POST['maxprice'] : isset($rqpricemax)? $rqpricemax:'')
?>" placeholder="Rent should not be more than..."/>
<label class="input-labels" for="location">Location:</label>
<input class="request-input" name="location" type="text" value="<?php echo (isset($_POST['location'])? $_POST['location'] : isset($rqlocation)? $rqlocation:'')
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
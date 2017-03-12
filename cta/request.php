
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
	header('location: checkin.php');
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
//if request placing is successful
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
#request-error-container,#request-sent-container{
	width:98%;
	padding:1%;
	color:white;
	border-radius:5px;
}
#request-error-container{
	background-color:red;
}
#request-sent-container{
	background-color:green;
}
legend{
	font-weight:bold;
}
input{
	display:block;
}
#request-form-container{
	margin-top:5%;
	padding-left:20%;
	padding-right:20%;
}
</style>
<body class="pic-background">
<div id="request-form-container">
<form action="<?php $_PHP_SELF ?>" method="POST">
<fieldset>
<legend>Place request</legend>
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
<label for="type">Property type:</label>
<input name="type" type="text" size="30" value="<?php echo (isset($_POST['type'])? $_POST['type'] : isset($rqtype)? $rqtype:'')
?>"/>
<label for="maxprice">Maximum rent:</label>
<input name="maxprice" type="text" size="30" maxlength="10" value="<?php echo (isset($_POST['maxprice'])? $_POST['maxprice'] : isset($rqpricemax)? $rqpricemax:'')
?>" placeholder="Rent should not be more than..."/>
<label for="location">Location:</label>
<input name="location" type="text" size="40" value="<?php echo (isset($_POST['location'])? $_POST['location'] : isset($rqlocation)? $rqlocation:'')
 ?>"  placeholder="around where?"/>
<input name="<?php echo (isset($_GET['placed'])? ($_GET['placed']==1 ? 'change' : $_GET['placed']==0 ? 'request' : ''): '')?>" type="submit" size="30" value="<?php echo (isset($_GET['placed'])?  ($_GET['placed']==1 ? 'change' : $_GET['placed']==0 ? 'request' : ''): '') ?>"/>

</fieldset>
</form>
</div>
</body>
</html>
<?php 
$connect = true;
require('../require/connexion.php'); 
 //confirm if user is still logged in 
if(!isset($_COOKIE['name'])){
	header("Location: ../login");
}
?>

<!DOCTYPE html>
<html>
<?php require('../require/meta-head.html'); ?>
<head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/management_styles.css" type="text/css" rel="stylesheet" />
<?php
	$pagetitle = "Manage";
	$ref='manage';
$getuserName=true;
	require('../require/header.php');
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#show-change').click(function(){
		$('#hidden-form').toggle();
		
	});
});
</script>
<style>

</style>
</head>
<body class="pic-background">
<div id="whole-page">
<div id="manage">
<p>Choose what to do</p>
<div id="manage-acct">
<fieldset><legend>Account</legend>
<ul>
<li class="link"><a href="account.php">Edit profile</a></li>
<li class="link"><a href="account.php">Change Account Password</a></li>
<li class="link"><a href="account.php">Deactivate Account</a></li>
</ul>
</fieldset></div>
<div id="manage-prop">
<fieldset><legend>Properties</legend>
<ul>
<li class="link" id="show-change"><a href="#">Change Property Details</a></li>
<div id="hidden-form">
<form action="property.php" method="GET"> <input name="id" placeholder="Enter the property ID" type="text"/>
<input name="action" type="submit" value="change"/>
</form>
</div>
<li class="link"><a href="property.php">Delete Property</a></li>
<li class="link"><a href="property.php">Report a property</a></li> 
</ul>
</fieldset>
</div>
</div>
</div>
</body>
<?php require('../require/footer.html'); ?>
</html>
<?php 
require('../resources/php/master_script.php');  
?>

<!DOCTYPE html>
<html>
<head>
<?php $pagetitle = "CTA";
$pagetitle .= (($status==9 && (isset($cta_name)) ) ? ' - '.$cta_name:'');
$ref='cta_page';
require('../resources/global/meta-head.php'); ?>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
</head>

<body class="no-pic-background">

<?php
$req = (isset($_GET['src']) ? $_GET['src'] :'matches');

if($status==9){
$showStaticHeader = true;
$staticHead ="<div class=\"col-sm-offset-3\">
<div class=\"row hidden-lg hidden-md static-head-primary\">
<h2 class=\"font-20 site-color\"><span class=\"glyphicon glyphicon-link \"></span>Matches ($matches)</h2>
</div>
</div>";
if($req=='clipped'){
$staticHead ="<div class=\"col-sm-offset-3\">
<div class=\"row hidden-lg hidden-md static-head-primary\">
<h2 class=\"font-20 site-color\"><span class=\"glyphicon glyphicon-paperclip\"></span>Clipped ($clipped)</h2>
</div>
</div>";
}
if($req=='suggestions'){
$staticHead ="<div class=\"col-sm-offset-3\">
<div class=\"row hidden-lg hidden-md static-head-primary\">
<h2 class=\"font-20 site-color\"><span class=\"glyphicon glyphicon-briefcase\"></span>Agent Suggestions ($total_suggestions)</h2>
</div>
</div>";
}
}
require('../resources/global/header.php');
?>

<?php
//if user is logged in as an agent
if($status==1){
echo "<div class=\"body-content\">
<div class=\"box-shadow-1 center-content white-background border-radius-7 padding-10 text-center\" style=\"margin-top:10%\">
		You cannot use Client Temporary Account because you are currently logged in as <br/><a href=\"$root/$profile_name\">$Business_Name</a> <br/>
		<a class=\"btn btn-primary red-background\" href=\"../logout\">Logout</a> first
		</div>
		</div>";
$general->halt_page();
}

//if user is a visitor
else if($status==0){
	?>
	<div class=" container-fluid body-content">
<?php
	if(isset($_GET['checkin']) && isset($_GET['acct']) ){
		?>
		<div class="box-shadow-1 center-content white-background border-radius-7 padding-10 text-center" style="margin-top:10%">
			<p>This CTA you are attempting to checkin has expired since <span class="red"><?php echo $general->since($_GET['exp']) ?></span></p>
			<p>You can create new CTA.</p
			><br/><br/>
			<a class="btn btn-primary site-color-background"  href="checkin.php?a=create">create new CTA</a>
		</div>
		
		<?php
}
else{
	?>
	<div class="box-shadow-1 center-content white-background border-radius-7 padding-10 text-center" style="margin-top:10%">
			<span >You are currently not checked in.</span><br/><br/>
			<a class="btn btn-primary" href="checkin.php?a=checkin">checkin</a>
			<a class="btn btn-primary site-color-background" href="checkin.php?a=create">create new CTA</a>
		</div>
		<?php
		
}
$general->halt_page();
?>
</div>	
<?php		
		}

?>



<div class="container-fluid body-content">
<div class="row">
<?php
	require('../resources/global/sidebar.php');
?>
<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 main-content">

<?php 
if($req=='matches' || $req==""){
	?>
<div class="white-background e3-border padding-5">
<h3 class="major-headings" ><span class="glyphicon glyphicon-link"></span>  Matched properties</h3>
</div>
	<?php
//if there are preferences request
if($request_status==1){
	?>
	<div class="row white-background e3-border padding-5 margin-10 text-center">
<h2 class="font-20">Your Request</h2>
<hr class="grey" />
<div>
<p class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left  padding-3">Type: <strong><?php echo $request_type ?></strong></p> 
<p class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left  padding-3"><span class="glyphicon glyphicon-tags"></span> Max Rent: <strong>N <?php echo number_format($request_maxprice) ?></strong></p>
<p class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-left padding-3"><span class="glyphicon glyphicon-map-marker"></span> Preferred Location: <strong><?php echo $request_location ?></strong></p>
<p class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><a  href="request.php?p=<?php echo $request_status ?>" class="btn btn-primary">change</a></p>
</div>
</div>
<?php
if($matches != 0){
	?>
<?php
$final_property_query = property::$property_query." WHERE (type='$request_type' AND rent <=$request_maxprice AND location LIKE '%$request_location%') ORDER BY since DESC";
require('../resources/global/property_display.php');

}
else{
	?>
<div class="no-property">There are no matches for your request</div>
<?php
}
}
else{
	?>
<div class="no-property">You have not specify your request
<a class="btn btn-primary" href="request.php?p=0">Specify now</a></div>
<?php	
			}
	}

else if($req=='clipped'){
	?>
<div class="white-background e3-border padding-5">
<h3 class="major-headings"><span class="glyphicon glyphicon-paperclip"></span>  Clipped properties</h3>
</div>
<?php
//if there are preferences request
if($clipped != 0){
$final_property_query = "SELECT property.property_ID AS id, property.directory AS dir,
        property.type AS type, property.location AS location, property.rent AS rent,
        property.min_payment AS mp, property.bath AS bath, property.toilet AS toilet,
        property.description AS description, property.timestamp AS since,property.last_reviewed AS lastReviewed,property.display_photo AS dp,        property.views AS views, property.status AS status, agent.Business_Name AS agentBussinessName,
        agent.User_ID AS agentUserName , agent.Office_Address AS agentOfficeAdd, agent.Office_Tel_No AS agentOfficeNo,
        agent.Phone_No AS agentNo,agent.Alt_Phone_No AS agentAltNo,agent.token AS agenttoken,clipped.timestamp AS clippedOn
        FROM clipped INNER JOIN properties AS property ON (clipped.propertyid = property.property_ID) 
		INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby) WHERE (clipped.clippedby = $ctaid)";
require('../resources/global/property_display.php');
}
else{
	?>
<div class="no-property">You have no clipped properties</div>
<?php
}
}
else if ($req == 'suggestions'){
	?>
	<div class="white-background e3-border padding-5">
<h3 class="major-headings"><span class="glyphicon glyphicon-briefcase"></span>  Suggested Properties</h3>
</div>
<?php
	$final_property_query = "SELECT property.property_ID AS id, property.directory AS dir,
        property.type AS type, property.location AS location, property.rent AS rent,
        property.min_payment AS mp, property.bath AS bath, property.toilet AS toilet,
        property.description AS description, property.timestamp AS since,property.last_reviewed AS lastReviewed,property.display_photo AS dp,        property.views AS views, property.status AS status, agent.Business_Name AS agentBussinessName,
        agent.User_ID AS agentUserName , agent.Office_Address AS agentOfficeAdd, agent.Office_Tel_No AS agentOfficeNo,
        agent.Phone_No AS agentNo,agent.Alt_Phone_No AS agentAltNo,agent.token AS agenttoken,property_suggestion.timestamp AS suggestedOn
        FROM property_suggestion INNER JOIN properties AS property ON (property_suggestion.property_id = property.property_ID) 
		INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby) WHERE (property_suggestion.client_id = $ctaid)";
require('../resources/global/property_display.php');
}
?>

<?php require('../resources/global/footer.php') ?>
</div>	<!--main-content ends-->
</div><!--parent row ends-->
</div><!--container-fluid ends-->
</body>
</html>
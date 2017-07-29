<?php 
require('../resources/php/master_script.php');  
?>

<!DOCTYPE html>
<html>
<?php require('../resources/html/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/ctastyles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../js/propertybox.js"></script>

<head>
<?php
$pagetitle = "CTA";
require('../resources/php/header.php');
?>
</head>

<body class="no-pic-background">

<?php
//if user is logged in as an agent
if($status==1){
echo "<br/></br/><div class=\"box-shadow-1 denial\">
		You cannot use Client Temporary Account because you are currently logged in as <br/><a href=\"$root/$profile_name\">$Business_Name</a> <br/><a href=\"../logout\">Logout</a> first
		</div>";
$general->halt_page();
}

//if user is a visitor
else if($status==0){
	if(isset($_GET['checkin']) && isset($_GET['acct']) ){
		?>
		<div class="box-shadow-1 denial">
			<span style=\"\">This CTA you are attempting to checkin has expired since <span style="color:red"><?php echo $general->since($_GET['exp']) ?></span>You can create new CTA.</span><br/><br/>
			<a class="deepblue-inline-block-link"  href="checkin.php">create new CTA</a>
		</div>
		<?php
}
else{
	?>
	<div class="box-shadow-1 denial">
			<span style="font-size:120%">You are currently not checked in.</span><br/><br/>
			<a class="deepblue-inline-block-link" href="checkin.php">checkin</a>
			<a class="deepblue-inline-block-link" href="checkin.php">create new CTA</a>
		</div>
		<?php
		
}
$general->halt_page();			
		}

?>

<?php
	require('../resources/php/sidebar.php');
?>

<div class="main-content cta-content">

<?php 
$req = (isset($_GET['src']) ? $_GET['src'] :'matches');

if($req=='matches' || $req==""){
	?>
<h3 class="major-headings" >Matched properties</h3>
	<?php
//if there are preferences request
if($request_status==1){
	?>
<p>You have requested for <strong><?php echo $request_type ?></strong> with rent not more than <strong>N <?php echo number_format($request_maxprice) ?></strong> preferably around <strong><?php echo $request_location ?></strong>  <a href="request.php?p=<?php echo $request_status ?>">change</a></p>
<?php
if($matches != 0){
	?>
<?php
$final_property_query = property::$property_query." WHERE (type='$request_type' AND rent <=$request_maxprice AND location LIKE '%$request_location%') ORDER BY since DESC LIMIT ".properties_config::$max_display;
require('../resources/php/property_display.php');

}
else{
	?>
<div class="no-property">There are no matches for your request</div>
<?php
}
//mysql_close($db_connection);
}
else{
	?>
<div class="no-property">You have not specify your request
<a class="inline-block-link white-on-purple" href="request.php?p=0">Specify now</a></div>
<?php	
			}
	}

else if($req=='clipped'){
	?>
<h3 class="major-headings">Clipped properties</h3>
<?php
//if there are preferences request
if($clipped != 0){
$max_display = properties_config::$max_display;
$final_property_query = "SELECT property.property_ID AS id, property.directory AS dir,
        property.type AS type, property.location AS location, property.rent AS rent,
        property.min_payment AS mp, property.bath AS bath, property.toilet AS toilet,
        property.description AS description, property.timestamp AS since,property.last_reviewed AS lastReviewed,
        property.views AS views, property.status AS status, agent.Business_Name AS agentBussinessName,
        agent.User_ID AS agentUserName , agent.Office_Address AS agentOfficeAdd, agent.Office_Tel_No AS agentOfficeNo,
        agent.Phone_No AS agentNo,agent.Alt_Phone_No AS agentAltNo,agent.token AS agenttoken
        FROM clipped INNER JOIN properties AS property ON (clipped.propertyid = property.property_ID) 
		INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby) WHERE (clipped.clippedby = $ctaid) LIMIT $max_display";
require('../resources/php/property_display.php');
}
else{
	?>
<div class="no-property">You have no clipped properties</div>
<?php
}
}
?>
</div>

</body>
</html>
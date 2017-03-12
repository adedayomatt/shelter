<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/index_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />

<header>
<?php
$pagetitle = "CTA";
$connect = true;
$getuserName = true;
$ref = "ctaPage";
require('../require/header.php');
//if user is logged in as an agent
if($status==1){
	$denialMessage = "You cannot use Client Temporary Account because you are currently logged in as <a href=\"$root/$profile_name\">$Business_Name</a> <br/><a href=\"../logout\">Logout</a> first";
}
//if user is a visitor
else if($status==0){
//close the opened connection and redirect to the checkin page
	mysql_close($db_connection);
	header('location: checkin.php');
	exit();
}
?>
</header>
<body class="no-pic-background">
<?php
if(isset($denialMessage)){ echo "<p>$denialMessage</p></body></html>";
mysql_close($db_connection);
exit();
}
else{
	require('../require/sidebar.php');
}
?>

<div id="cta-content" style="width:60%;float:left;">

<?php 
$req = (isset($_GET['src']) ? $_GET['src'] : 'matches');
$count = 0;
	switch($req){
case 'matches':
//if there are preferences request
if(isset($rqtype) && isset($rqpricemax) && isset($rqlocation)){
echo "<p>You have requested for $rqtype with rent not more than N".number_format($rqpricemax)." preferably around $rqlocation  <a href=\"request.php?chgt=$rqtype&chMp=$rqpricemax&chLtn=$rqlocation\">change</a></p>";
$query =  "SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded 
            FROM properties WHERE (type='$rqtype' AND rent<=$rqpricemax AND location LIKE '%$rqlocation%') ORDER BY date_uploaded DESC";
$nooutput = "No Match found yet";
}
else{
	$nooutput = "You have not specified your preferences";
}
break;

case 'clipped':
echo "<p>You have clipped the following properties</p>";
$nooutput = "No clipped property";
while($count<$clipcounter){
$getclipped = mysql_query("SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded 
         FROM properties WHERE (property_ID='".$clippedproperty[$count]."') ORDER BY date_uploaded DESC");
if($getclipped){
	$property = mysql_fetch_array($getclipped,MYSQL_ASSOC);
	$propertyId[$count] = $property['property_ID'];
	$propertydir[$count] = $property['directory'];
	$type[$count] = $property['type'];
	$location[$count] = $property['location'];
	$rent[$count] = $property['rent'];
	$min_payment[$count] = $property['min_payment'];
	$bath[$count] = $property['bath'];
	$toilet[$count] = $property['toilet'];
	$description[$count] = $property['description'];
	$date_uploaded[$count] = $property['date_uploaded'];
	$uploadby[$count] = $property['uploadby'];
		 $count++;
}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
	mysql_close($db_connection);
	exit();
			}	
}
break;

default:
echo "<p>You have requested for $rqtype with rent not more than N".number_format($rqpricemax)." preferably around $rqlocation  <a href=\"request.php?chgt=$rqtype&chMp=$rqpricemax&chLtn=$rqlocation\">change</a></p>";
$query =  "SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded 
            FROM properties WHERE (type='$rqtype' AND rent<=$rqpricemax AND location LIKE '%$rqlocation%') ORDER BY date_uploaded DESC";
$nooutput = "No Match found yet";

break;
	}
//This instance would be for case 'matches' and default
	if(isset($query)){
	$executequery = mysql_query($query);
if($executequery){
	while($property = mysql_fetch_array($executequery,MYSQL_ASSOC)){
	$propertyId[$count] = $property['property_ID'];
	$propertydir[$count] = $property['directory'];
	$type[$count] = $property['type'];
	$location[$count] = $property['location'];
	$rent[$count] = $property['rent'];
	$min_payment[$count] = $property['min_payment'];
	$bath[$count] = $property['bath'];
	$toilet[$count] = $property['toilet'];
	$description[$count] = $property['description'];
	$date_uploaded[$count] = $property['date_uploaded'];
	$uploadby[$count] = $property['uploadby'];
	$count++;
//last value of count will eventually equals to the total records fetched.
		}
	}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
	mysql_close($db_connection);
	exit();
			}
	}
//if no match or no clipped
if(empty($propertyId)){
	echo "<p align=\"center\">$nooutput</p>";
	}
	
else{
$ref = "match_page";
require('../require/propertyboxes.php');
mysql_close($db_connection);
}
?>
</div>
</body>
</html>
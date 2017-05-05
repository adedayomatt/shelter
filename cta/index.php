<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../js/propertybox.js"></script>
<header>
<?php
$pagetitle = "CTA";
$connect = true;
$getuserName = true;
require('../require/header.php');
//if user is logged in as an agent
if($status==1){
	$denialMessage = "You cannot use Client Temporary Account because you are currently logged in as <br/><a href=\"$root/$profile_name\">$Business_Name</a> <br/><a href=\"../logout\">Logout</a> first";
}
//if user is a visitor
else if($status==0){
//close the opened connection and redirect to the checkin page
	mysql_close($db_connection);
	header('location: checkin.php?_rdr=1');
	exit();
}
?>
</header>
<style>
@media only screen and (min-device-width: 300px) and (max-device-width: 1000px){
#denial{
	width:100%;
	text-align:center;
}	
.rhs{
	display:none;
}
}
@media only screen and (min-device-width: 1000px){
	#denial{
	width:60%;
	text-align:center;
}
.rhs{
	width:40%;
	float:left;
	background-color:green;
}
.rhs-content{
	position:fixed;
	background-color:red;
	height:80%;
}
#big-side-advert{
	height:100%;
	width:400px;
}
}

</style>
<body class="no-pic-background">
<?php
if(isset($denialMessage)){ echo "<br/></br/><div class=\"operation-report-container\" id=\"denial\" >$denialMessage</div></body></html>";
mysql_close($db_connection);
exit();
}
else{
	require('../require/sidebar.php');
}
?>

<div class="main-content cta-content">

<?php 
$req = (isset($_GET['src']) ? $_GET['src'] : 'matches');
$count = 0;

$max = 4;
if(isset($_GET['next']) && $_GET['next']>0){
	$start = $_GET['next'];
	$end = $_GET['next'] + $max;
}
 else{
	 $start = 0;
	 $end = $max;
 }

if($req=='matches' || $req==""){
//if there are preferences request
if($rqstatus==1 && isset($rqtype) && isset($rqpricemax) && isset($rqlocation)){
	echo "<h1 style=\"font-family:Georgia;font-weight:normal;font-size:200%;letter-spacing:2px;\">Matched properties</h1>";
echo "<p>You have requested for <strong>$rqtype</strong> with rent not more than <strong>N".number_format($rqpricemax)."</strong> preferably around <strong>$rqlocation</strong>  <a href=\"request.php?p=$rqstatus\">change</a></p>";
$query =  "SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded,timestamp 
            FROM properties WHERE (type='$rqtype' AND rent<=$rqpricemax AND location LIKE '%$rqlocation%') ORDER BY date_uploaded DESC LIMIT $start,$end";
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
	$howlong[$count] = $property['timestamp'];
	$count++;
//last value of count will eventually equals to the total records fetched.
		}
$ref = "ctaPage";	
	require('../require/propertyboxes.php');
if(!empty($propertyId)){
	echo "<a class=\"show-more-link\" href =\"?src=matches&next=$end\">show more >></a>";	
}
else{
if($start==0){
	echo "<div class=\"no-property\" align=\"center\">There is no property that match your preference for now</div>";
}
else if($start>0){
	echo "<div class=\"no-property\" align=\"center\">No more matches</div>";
	}
}
		
	}
	
else{
	echo "<div class=\"no-property\"><b>An error occured!!</b></div>";
	mysql_close($db_connection);
	exit();
			}			
}
else{
	echo "<div class=\"no-property\">You have not specified your preferences. <a href=\"request.php?p=0\">specify what you need</a> now</div>";
}
mysql_close($db_connection);
}

else if($req=='clipped'){
echo "<h1 style=\"font-family:Georgia;font-weight:normal;font-size:200%;letter-spacing:2px;\">Clipped properties</h1>";
while($count<$clipcounter){
$getclipped = mysql_query("SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded,timestamp
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
	$howlong[$count] = $property['timestamp'];
		 $count++;
}
else{
	break;
	echo "<div class=\"no-property\"><b>An error occured!!</b></div>";
	mysql_close($db_connection);
	exit();
			}	
}
if(empty($propertyId)){
	echo "<div class=\"no-property\">No clipped property</div>";
}
else{
	$ref = "ctaPage";
require('../require/propertyboxes.php');


	
}
mysql_close($db_connection);
}
?>
</div>

<div class="rhs">
<div class="rhs-content">
<img src="../resrc/image/advert2.jpeg" id="big-side-advert"/>
</div>

</div>
</body>
</html>
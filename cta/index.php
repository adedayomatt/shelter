<?php 
$connect = true;
require('../require/connexion.php'); 
?>

<!DOCTYPE html>
<html>
<?php require('../require/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/ctastyles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../js/propertybox.js"></script>

<header>
<?php
$pagetitle = "CTA";
require('../require/header.php');
?>
</header>

<body class="no-pic-background">

<?php
//if user is logged in as an agent
if($status==1){
	$denialMessage = "You cannot use Client Temporary Account because you are currently logged in as <br/><a href=\"$root/$profile_name\">$Business_Name</a> <br/><a href=\"../logout\">Logout</a> first";
}
//if user is a visitor
else if($status==0){
//close the opened connection and redirect to the checkin page
/*	mysql_close($db_connection);
	header('location: checkin.php?_rdr=1');
	exit();*/
	if(isset($_GET['checkin']) && isset($_GET['acct']) ){
		echo "<div class=\"box-shadow-1 denial\">
			<span style=\"\">This CTA you are attempting to checkin has expired since <span style=\"color:red\">".Timestamp($_GET['exp'])."</span>You can create new CTA.</span><br/><br/>
			<a class=\"deepblue-inline-block-link\"  href=\"checkin.php\">create new CTA</a>
		</div>";
		exit();
}
else{
	echo "<div class=\"box-shadow-1 denial\">
			<span style=\"font-size:120%\">You are currently not checked in.</span><br/><br/>
			<a class=\"deepblue-inline-block-link\" href=\"checkin.php\">checkin</a>
			<a class=\"deepblue-inline-block-link \" href=\"checkin.php\">create new CTA</a>
		</div>";
		exit();
}
}

?>

<?php
if(isset($denialMessage)){ echo "<br/></br/><div class=\"box-shadow-1 denial\">$denialMessage</div></body></html>";
mysql_close($db_connection);
exit();
}
else{
	require('../require/sidebar.php');
}
?>

<div class="main-content cta-content">

<?php 
//if there is notification of remaining days. This variable is set from header.php
if(isset($remainingDaysNotice) && !empty($remainingDaysNotice) ){
	echo "<div class=\"cta-expiry-notice\">$remainingDaysNotice</div>";
}

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
	echo "<h3 class=\"major-headings\" >Matched properties</h3>";
echo "<p>You have requested for <strong>$rqtype</strong> with rent not more than <strong>N".number_format($rqpricemax)."</strong> preferably around <strong>$rqlocation</strong>  <a href=\"request.php?p=$rqstatus\">change</a></p>";
$query =  "SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded,timestamp,views,last_reviewed,status 
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
	$views[$count] = $property['views'];
	$lastReviewed[$count] = $property['last_reviewed'];
	$avail[$count] = $property['status'];
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
	echo "<div class=\"no-property\">You have not specified your preferences.
	<a class=\"inline-block-link white-on-purple\" href=\"request.php?p=0\">Specify now</a></div>";
}
mysql_close($db_connection);
}

else if($req=='clipped'){
echo "<h3 class=\"major-headings\">Clipped properties</h3>";
while($count<$clipcounter){
$getclipped = mysql_query("SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded,timestamp,views,last_reviewed,status 
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
	$views[$count] = $property['views'];
	$lastReviewed[$count] = $property['last_reviewed'];
	$avail[$count] = $property['status'];
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

</body>
</html>
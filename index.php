<?php 
require('resources/php/master_script.php'); 
?>

<!DOCTYPE html>
<html>
<?php
if($status==1){
	?>
<a class="hidden-lg hidden-md  white-background" href="upload" id="quick-upload-ball">
<span class="glyphicon glyphicon-send icon-size-30 red-background white" style="position:fixed;top:80%;left:70%;z-index:99;padding:20px; border-radius:50%; box-shadow: 0px 5px 5px #555"></span>
</a>

<script>
//animateBackgroundColor('#quick-upload-ball');
</script>
	<?php
}
?>

<head>
<?php
$pagetitle = 'Home';
$ref="home_page";
 require('resources/global/meta-head.php'); ?>
<link href="css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="css/index_styles.css" type="text/css" rel="stylesheet" />
<link href="css/propertybox_styles.css" type="text/css" rel="stylesheet" />
</head>

<body class="no-pic-background">


<?php 
$showStaticHeader = true;
require("resources/global/header.php");
?>

<div class="container-fluid body-content">

<div class="row">

	<!--Leftmost side begins-->
<?php require('resources/global/sidebar.php'); ?>
<!--Leftmost side ends-->

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 main-content">
<?php 
if(!isset($_GET['next']) || $_GET['next']==0){
	?>
<div class="row">
<div id="yes-you-can" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<h1><span >YES<span style="color:yellow;font-size:200%"><i>!</i></span> You can live in your dream home</h1> 
<h3 ><i>..all you need is the connection with the right agent, <span style="color:yellow; font-size:110%">we provide that!</span></i></h3>
</div>
</div>
<?php
}
?>
<div class="padded-main-content">
<?php
//one or two notifications will appear here only on the load of the homepage and not when viewing more uploads
if(!isset($_GET['next']) || $_GET['next']==0){
if($status==1 || $status==9){
	?>
<div id="mini-notification">
<?php
//$home_obj->mini_notification();
?>
</div>
<?php
	}
}

?>


<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 search-n-most-viewed">
<div class="row white-background e3-border" style="margin-bottom:10px">
<h3 class="major-headings">Search For Property</h3>
<?php require("search/searchform.php") ?>
</div>


<div id="front-ad-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">
<img src="<?php echo $root.'/'.ads::$ad002 ?>" alt="Advert will be placed here" class="ads"/>
</div>


<div class="row ">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<h3 class="major-headings" >Most Viewed Properties</h3>
<?php
$most_viewed_query = "SELECT property.property_ID AS propertyid, property.directory AS dir,
        property.type AS type, property.location AS location, property.rent AS rent, 
        property.uploadby AS agentUserName, property.timestamp AS since, property.views AS views,property.display_photo AS dp, agent.Business_Name AS agentBussinessName  
        FROM properties AS property INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby) 
         ORDER BY views DESC LIMIT 6";

$most_viewed = $db->query_object($most_viewed_query);
if(is_object($most_viewed)){
	while($mv = $most_viewed->fetch_array(MYSQLI_ASSOC)){
	$mv_id = $mv['propertyid'];
	$mv_dir = $mv['dir'];
	$mv_type = $mv['type'];
	$mv_location = $mv['location'];
	$mv_rent = $mv['rent'];
	$mv_view = $mv['views'];
	$mv_dp = $mv['dp'];
	$mv_timeuploaded = $mv['since'];
    $mv_agent_username = $mv['agentUserName'];
    $mv_agent_bizname = $mv['agentBussinessName'];
?>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
 <div class="margin-2 e3-border">
<div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <div class="mv-wrapper">
 <div class="mv-overlay">
 <div class="font-30"><a class="red" href="properties/<?php echo $mv_dir ?>"><?php echo $general->substring("$mv_type",'abc',25) ?></a></div>
 <div class="site-color"><span class="glyphicon glyphicon-map-marker red"></span><?php echo $general->substring("$mv_location",'abcxyz',25) ?></div>
 <div class=""><span class="mv-rent-figure"> N <?php echo number_format($mv_rent) ?></span></div>
 </div>
 
 <div class="text-center padding-10">
 <img class="mv-photo" src="<?php echo $property_obj->get_property_dp('properties/'.$mv_dir,$mv_dp) ?>" />
 </div>
 </div>
 </div>
 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <div class="padding-5" >
 <div class="row f7-background margin-1 padding-3 e3-border border-radius-3 text-center">
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><p class="font-12 grey"><span class="glyphicon glyphicon-eye-open site-color"></span><?php echo $mv_view ?> views</p></div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><p class="font-12 grey"><span class="glyphicon glyphicon-upload site-color"></span><?php echo $general->since($mv_timeuploaded) ?></p></div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="font-12 grey"> <span class="glyphicon glyphicon-briefcase site-color"></span> <a href="<?php echo $mv_agent_username ?>"><?php echo $mv_agent_bizname ?> </a></p></div>
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 <?php
		}
$most_viewed->free();
	}
 ?>
</div>
</div>

</div>
</div>

<?php if($status == 0){
	?>
<div class="row">
<div id="client-shout-out">
IN NEED OF AN APARTMENT <span style="font-size:300%;color:peru">?</span>
<span style="color:purple">Create a Client Temporary Account (CTA)</span>
</div>
</div>
<?php
}
else if($status == 1){
?>
<div class="row cta-requests-stat-container">
<h3 class="major-headings" style="margin-bottom:0px">Client Requests (<?php echo $all_cta_requests ?>)</h3>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 client-Requests-container scrollable-x white-background e3-border">
<div class="scrollable-x-inner" style="width:1600px">
<?php
//this returns a multidimensional array
$requestee_ = $data->get_all_cta_requests();
//for($k = 0; $k<$all_cta_requests ;$k++){
	for($k = 0; $k<count($requestee_) ;$k++){

	if($k==10){
		break;
	}
?>
<div class="client-request-box float-left">
<div class="request text-center">
<?php 

$request = $client->get_request($requestee_[$k]['id'],$requestee_[$k]['ctaname']);
 ?>
 <span class="glyphicon glyphicon-user icon-size-30 white-background site-color client-avatar"></span>
	<p><?php echo $request['type']?></p>
		<p>N <?php echo number_format($request['maxprice'])?></p>
			<p><?php echo $request['location']?></p>

</div>
<div class="suggest-button-wrapper text-center">
<?php
echo $property_obj->suggestProperty($agentId,$Business_Name,$profile_name,$agent_token,$requestee_[$k]['ctaname'],$requestee_[$k]['id']);
?>
</div>
</div>
<?php	
}
?>
</div>
 <span class="glyphicon glyphicon-hand-right icon-size-20 opac-black-background white" style="position:absolute; left:80%; top: 25%; padding:20px; border-radius:50%" onclick=""></span>
</div>
</div>


<p class="text-right">
<a href="clients" class="btn btn-primary">See all requests</a>
</p>
</div>
<?php
}
?>


<div id="recentuploads"></div>

<div class="row" style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 recent-upload-tab  text-center" id="active-tab" data-tab="to-let-tab">
<h1>To Let</h1>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 recent-upload-tab text-center" id="hidden-tab" data-tab="for-sale-tab">
<h1>For Sale</h1>

</div>

</div>
</div>
</div>

<!--<div class="text-right">
<a  class="btn btn-primary site-color-background white margin-5" href="cta">Go to Categories »</a>
</div>-->

<div id="recent-uploads-container">
<?php
$ref = 'home_page';
$final_property_query = property::$property_query." ORDER BY since DESC";
require('resources/global/property_display.php');
?>	
</div>

<style>
.recent-upload-tab{
border:2px solid #e3e3e3;
cursor:pointer;
}
#active-tab{
	background-color:#20435C;
	color:white;
}
#hidden-tab{
	background-color:white;
	color:#20435C;
}
#recent-uploads-container{
	min-height:300px;
}
</style>
<script>
var tolet = document.querySelector(".recent-upload-tab[data-tab='to-let-tab']");
var forsale = document.querySelector(".recent-upload-tab[data-tab='for-sale-tab']");
var recentUploadContainer = document.querySelector("#recent-uploads-container"); 
var toletContent = recentUploadContainer.innerHTML;
var forsaleContent = "<h1 class=\"text-center\">For Sale Properties will appear here</h1>";
forsale.onclick = function(event){
	tolet.setAttribute('id','hidden-tab');
	forsale.setAttribute('id','active-tab');
	recentUploadContainer.innerHTML = forsaleContent;
}

tolet.onclick = function(event){
	tolet.setAttribute('id','active-tab');
	forsale.setAttribute('id','hidden-tab');
	recentUploadContainer.innerHTML = toletContent;
}
</script>

<div id="advertise-with-us" class="row">
	ADVERTISE WITH US
	</div>
<div class="row">
						
	<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
<h3 class="major-headings">Agents</h3>
<div id="agents-list-container">

<div>
<div id="agents-list-container">
<?php
$getAgents = null;
if($status==1){
$getAgents = $db->query_object("SELECT ID,Business_Name,Office_Address,User_ID FROM profiles WHERE ID != $agentId LIMIT 5");
}
else{
	$getAgents = $db->query_object("SELECT ID,Business_Name,Office_Address,User_ID FROM profiles LIMIT 5");
}
if(is_string($getAgents)){
	error::report_error($getAgents,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
}
else{
	while($ag = $getAgents->fetch_array(MYSQL_ASSOC)){
	//default follow button properties
	$text = 'follow';
	$f = 'follow-button';
	$ficon = 'black-icon follow-icon';
	$followtype = null;
		?>
	<div class="agents-list">
	<div class="row">
	<span class="col-lg-8 col-md-8 col-sm-8 col-xs-6" style="overflow:hidden">
	<a href="<?php echo $ag['User_ID'] ?>" class="black">
	<span class="glyphicon glyphicon-briefcase padding-10 e3-border border-round"></span><?php echo $ag['Business_Name'] ?> </a>
	</span>
	<span class="col-lg-4 col-md-4 col-sm-4 col-xs-6"> 
	<?php
	if($status==1 || $status==9){
if($status==1){
echo "<span class=\"float-right\">".$agent->follow($agentId,$Business_Name,$profile_name,$ag['ID'],$ag['Business_Name'],$ag['User_ID'],'A4A')."</span>";
}
else if($status==9){
	echo "<span class=\"float-right\">".$agent->follow($ctaid,$cta_name,null,$ag['ID'],$ag['Business_Name'],$ag['User_ID'],'C4A')."</span>";	
	}
}
else{
	echo "<span class=\"float-right\"\">".$agent->dummy_follow()."</span>";
}	
	?>
	</span>
</div>
<p class="extra-info"><?php echo $ag['Office_Address'] ?></p>
<p class="extra-info" style="display:inline-block"><?php echo $db->query_object("SELECT property_ID FROM properties WHERE uploadby = '".$ag['User_ID']."'")->num_rows ?> properties</p>
</div>
<?php
	}
}	
?>
</div>
</div>
<a style="float:right;" href="agents">see all agents>></a>
</div>
</div>
	<div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 col-xs-12">
	<div class="update-subscription-wrapper">
			<form action="">
			<p>subscribe to our daily update</p>
			<div class="form-group">
			<input class="form-control" type="email" required placeholder="Enter your email here"/>
			</div>
			<input type="submit" class="btn btn-primary site-color-background" value="submit"/>
				</form>
			</div>

	<div class="feedback-wrapper" style="background-color:white;padding:15px; margin-top:10px">
<h2 class="major-headings">FeedBack</h2>
<p>We would like to hear from you, leave feed back</p>
<form>
<div class="form-group">
<label>Your E-mail</label>
<input class="form-control" type="text" placeholder="Enter your E-mail here"/>
</div>

<div class="form-group">
<textarea class="form-control" placeholder="Write your feedback here"></textarea>
</div>
<input class="btn-block btn-primary btn-lg site-background white-foreground" type="submit" value="Send FeedBack">

</form>
</div>
</div>

</div>

<div>
<?php
 require('resources/global/footer.php');
 ?>
</div>

</div>
</div>

</div>
</div>
</body>
</html>
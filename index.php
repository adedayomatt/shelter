
<?php 
require('resources/php/master_script.php'); 
require('resources/php/home_script.php');

$home_obj = new home();

?>

<!DOCTYPE html>
<html>
<?php require('resources/html/meta-head.html'); ?>
<head>
<link href="css/general.css" type="text/css" rel="stylesheet" />
<link href="css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="css/index_styles.css" type="text/css" rel="stylesheet" />
<link href="css/propertybox_styles.css" type="text/css" rel="stylesheet" />

<?php 
$pagetitle = 'Home';
require("resources/php/header.php");
?>
<script type="text/javascript" src="resources/js/home.js"></script>
</head>

<body class="no-pic-background">
<!--Leftmost side begins-->
<?php require('resources/php/sidebar.php'); ?>
<!--Leftmost side ends-->
<?php
//This is where the main content begin, only this div element would be visible in mobiles
?>
<div class="recent-uploads-container main-content" id="linear-layout-content">

<!--This is only for mobile, the display for the parent element should be none in the media query corresponding to desktop-->
<div id="top-nav-bar-content-on-scroll">
<div id="top-nav-bar-content-on-scroll-content">
<div>
<span class="on-scrolltop-menu" id="toggle-search-agent-container-button" onclick="showSearchAgent()">search agent</span>
<a href="#search"><span class="on-scrolltop-menu">search property</span></a>
<?php
if($status==1){
	$user = substr($Business_Name,0,12).'...';
	$link = $profile_name;
}
else if($status==9){
	$user = $ctaname;
	$link = 'cta';
}
else{
	$user = 'Create CTA';
	$link = 'cta';
}
?>
<a style="color:white" href="<?php echo $link ?>"><span class="on-scrolltop-menu"><?php echo $user ?></span></a>


</div>
<div style="" id="mobile-head-search-container">
<form action="agents" method="GET">
<div style="" class="input-wrapper">
<input name="k" onkeyup="getAgents(this.value,'agents-snipet-search-input-mobile','suggested-agents-search-container-mobile','suggested-agents-search-list-mobile')" class="search-input-field" id="agents-snipet-search-input-mobile" type="text" placeholder="search for agent" maxlength="50"/>
<input style="width:25%" type="submit" class="search-btn" value="Go"/> 
</div>
</form>
</div>
</div>
<div class="suggested-agents-search-container suggestion-box" id="suggested-agents-search-container-mobile">
<div class="suggested-agents-search-list" id="suggested-agents-search-list-mobile" style="padding:0px; ">
</div>
</div>
</div>
<!--Mobile on scroll head ends here-->


<div class="content-before-footer">

<?php 
if(!isset($_GET['next']) || $_GET['next']==0){
	?>
<div class="" id="about-container">
<p style="display:block;text-align:center;margin:0px">A graphic will appear here<br/>loading...</p>
<img src="resrc/gifs/progress-circle.gif" class="front-image"/>
</div>
<?php
}
?>

<?php
//one or two notifications will appear here only on the load of the homepage and not when viewing more uploads
if(!isset($_GET['next']) || $_GET['next']==0){
if($status==1 || $status==9){
	?>
<div id="mini-notification">
<?php
$home_obj->mini_notification();
?>
</div>
<?php
	}
}

?>

<div id="search-mv-agent-container">
<div id="search-box-ad-container">
<div style="border:1px solid #E3E3E3">
<h3 id="search-heading">Search</h3>
<div id="search-box">
<?php require("search/searchform.php") ?>
</div>
</div>
<div id="front-ad-wrapper">
<img src="" alt="Advert will be placed here" id="front-ad"/>
</div>
</div>

<div class="agents-snipet" id="agents-snipet-top">
<div id="most-viewed-wrapper">
<h3 id="most-viewed-heading" >Most viewed</h3>
<div id="most-viewed-container">
<div class="ul-wrapper">
<?php
$most_viewed_obj = null;
$most_viewed_obj = $home_obj->most_viewed();
if(is_object($most_viewed_obj)){
	while($mv = $most_viewed_obj->fetch_array(MYSQLI_ASSOC)){
	$mv_id = $mv['propertyid'];
	$mv_dir = $mv['dir'];
	$mv_type = $mv['type'];
	$mv_location = $mv['location'];
	$mv_rent = $mv['rent'];
	$mv_view = $mv['views'];
	$mv_timeuploaded = $mv['since'];
    $mv_agent_username = $mv['agentUserName'];
    $mv_agent_bizname = $mv['agentBussinessName'];
?>

 <div class="most-viewed-list">
	 <div style="display:inline-block;width:15%">
	<?php $mv_img_src =  (!empty($general->get_images("properties/$mv_dir")) ? $general->get_images("properties/$mv_dir")[0] : '') ?>
 <img src="<?php echo $mv_img_src ?>" width="50px" height="50px"/>
 </div>
 <div style="display:inline-block;width:83%">
 <a style="color:purple" href="properties/<?php echo $mv_dir ?>"><?php echo "$mv_type at $mv_location" ?></a>
 <br/><span class="mv-rent-figure"> N <?php echo number_format($mv_rent) ?></span>
 <p style="margin:0px;color:grey;text-align:right"><?php echo $mv_view ?> views</p>
 <p class="extra-info"> uploaded by <a href="<?php echo $mv_agent_username ?>"><?php echo $mv_agent_bizname ?> </a><br/><?php echo $general->since($mv_timeuploaded) ?></p>
</div>
 </div>
 <?php
		}
	}
 ?>
</div>
</div>
</div>

</div>

</div>

<?php
if(isset($_GET['next']) && $_GET['next']!=0){ 
?>
<style>
a[href="categories"]{
display:inline-block;
padding:2% 5% 2% 5%;
 margin:2% 0px 2% 0px;
  color:white;
  background-color:#74B4E0;
   border-radius:5px
}
</style>
	<a href="categories">Go to categories »</a><br/>
<?php
		}
?>
<?php
$final_property_query = property::$property_query." ORDER BY since DESC LIMIT ".properties_config::$max_display;
require('resources/php/property_display.php');
?>	
	<div id="agents-list-wrapper">
<h3 id="agents-heading" style="margin:0px">Agents</h3>
<div id="agents-list-container">

<div>
<div id="agents-list-container">
<?php
$getAgents = null;
if($status==1){
$getAgents = $db->query_object("SELECT ID,Business_Name,Office_Address,User_ID FROM profiles WHERE ID != $agentId LIMIT 10");
}
else{
	$getAgents = $db->query_object("SELECT ID,Business_Name,Office_Address,User_ID FROM profiles LIMIT 10");
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
	<a href="<?php echo $ag['User_ID'] ?>"><span class="black-icon agent-avatar"></span><?php echo $ag['Business_Name'] ?> </a>
	<?php
	if($status==1 || $status==9){
//check for follow
if($status==1){
echo $agent->follow($agentId,$Business_Name,$profile_name,$ag['ID'],$ag['Business_Name'],$ag['User_ID'],'A4A');
}
else if($status==9){
	echo $agent->follow($ctaid,$cta_name,null,$ag['ID'],$ag['Business_Name'],$ag['User_ID'],'C4A');	
	}
}
else{
	?>
<button style="float:right" class="follow-button" id="" onclick="" ><span class="black-icon follow-icon"></span>follow</button>
<?php
}	
	?>
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
	
	
</div>


<div>
<?php
 require('resources/php/footer.php');
 ?>
</div>
</div>


</body>
</html>
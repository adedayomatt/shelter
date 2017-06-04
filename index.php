<!DOCTYPE html>
<html>
<meta name="viewport" content="width=1000px,maximum-scale=0.35" />
<header>
<link href="css/general.css" type="text/css" rel="stylesheet" />
<link href="css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="css/index_styles.css" type="text/css" rel="stylesheet" />
<link href="css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<script>
</script>
<?php 
$pagetitle = 'Home';
$connect = true;
$getuserName = true;
require("require/header.php");
?>
<script type="text/javascript" src="js/home.js"></script>
<script type="text/javascript" src="js/propertybox.js"></script>
<script type="text/javascript" src="js/profile.js" type="text/javascript"></script>
</header>

<body class="no-pic-background">
<!--Leftmost side begins-->
<?php require('require/sidebar.php'); ?>
<!--Leftmost side ends-->
<?php
//This is where the main content begin, only this div element would be visible in mobiles
?>
<div class="recent-uploads-container main-content" id="linear-layout-content">

<!--This is only for mobile, the display for the parent element should be none in the media query corresponding to desktop-->
<div id="top-nav-bar-content-on-scroll">
<div id="top-nav-bar-content-on-scroll-content">
<div>
<button class="on-scrolltop-button" id="toggle-search-agent-container-button" onclick="showSearchAgent()">search agent</button>
<a href="search"><button class="on-scrolltop-button">search property</button></a>
<?php echo ($status==9 ? "<a href=\"cta\"><button class=\"on-scrolltop-button\">$ctaname</button> </a>" :
			($status==1 ? "<a href=\"$profile_name\"><button class=\"on-scrolltop-button\">".substr($Business_Name,0,12)."...</button> </a>": "<a style=\"color:white\" href=\"cta/checkin.php#create\"><button class=\"on-scrolltop-button\">create CTA</button></a>" ) )?>

</div>
<div id="mobile-head-search-container">
<input onkeyup="getAgents(this.value,'agents-snipet-search-input-mobile','suggested-agents-search-container-mobile','suggested-agents-search-list-mobile')" class="agents-snipet-search-input" id="agents-snipet-search-input-mobile" type="text" placeholder="search for an agent" maxlength="50"/>
<a href="agents" style="padding:1%;background-color:purple;color:white; border-radius:10px; float:left">view all agents</a>
<a href="search" style="padding:1%;padding-left:2%;padding-right:2%;background-color:purple;color:white; border-radius:10px;float:right">search</a> 
<div class="suggested-agents-search-container suggestion-box" id="suggested-agents-search-container-mobile">
<div class="suggested-agents-search-list" id="suggested-agents-search-list-mobile" style="padding:0px; ">
</div>
</div>
</div>

</div>
</div>
<!--Mobile on scroll head ends here-->

<?php
/*if($status != 1){
	$todo = "Have any property to sell, put it on Shelter today and connect with the buyer.<br/>It is easy, just click <a id=\"links\" href=\"signup.php\"><strong>here<strong></a>";
  echo "<p align=\"center\">$todo</p><hr/>";
	}
	*/
?>
<!--
<form style = "font-weight:normal; text-align:center; line-height: 200%;"> <span>Filter recent uploads</span>
<select  id="filter-selection" name="filter">
<option value="all">Everywhere</option>
<option value="Ibadan">Ibadan</option>
<option value="Abeokuta">Abeokuta</option>
</select>
<input type="submit" value="Filter" style="background-color:#6D0AAA; color:white; cursor:pointer; border:none"/>
</form>
-->
<div class="content-before-footer">
<script>
function showdialog(){
	alert('Jao!');
	
}
</script>
<?php 
if(!isset($_GET['next']) || $_GET['next']==0){
	
//show visitors only this message 
if($status ==0){
	echo "<div class=\"\" id=\"about-container\">
	<h1 id=\"about-head\">About</h1>
<p id=\"about\">Shelter.com provide an exclusive realty services all over the country. Getting your choice of property is our concern. We help you to find that your dream home you want to live in. <a href=\"\">Read more</a> on how we operate.</p>
</div>";
}	
if(isset($remainingDaysNotice) && !empty($remainingDaysNotice) ){
	echo "<div class=\"cta-expiry-notice\">$remainingDaysNotice</div>";
}
}
?>

<?php
//one or two notifications will appear here only on the load of the homepage and not when viewing more uploads
if(!isset($_GET['next']) || $_GET['next']==0){
if($status==1 || $status==9){
	echo "<div class=\"operation-report-container\" id=\"mini-notification\">";
	
if($status == 1){
   $totalNotification = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE (receiver='$Business_Name' OR receiver='allAgents')"));
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$Business_Name' OR receiver='allAgents')  ORDER BY time DESC LIMIT 2");
}
else if($status == 9){
	   $totalNotification = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE (receiver='$ctaname' OR receiver='allAgents')"));
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$ctaname' OR receiver='allAgents') ORDER BY time DESC");
}
echo "<h4 style=\"font-weight:bold;margin:0px\">Notifications ($totalNotification)</h4>";
if($getnotifications){
	if(mysql_num_rows($getnotifications) != 0){
//the function notify() is in this required file, it returns list of the notifications. This file is also used on the notifications page itself
	require("notifications/functionNotice.php");	
//start the notification list
	echo "<ul class=\"no-padding-ul\">";
		while($n = mysql_fetch_array($getnotifications,MYSQL_ASSOC)){
			//if notification was received on the same date with the date of checking notifications
if(date('dmy',$n['time'])== date('dmy',time())){
	echo notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'today');
}
//if notification was received a day before date of checking notifications
else if((date('d',time())- date('d',$n['time']))==1){
	echo notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'yesterday');
	}
else{
	echo notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'older');
	}
		}
//notification list ends here
echo "</ul>";
echo "<a href=\"notifications\" style=\"text-align:right\">See all notifications</a>";
	}else{
		echo "<span class=\"notice no-notice\">You do not have any notification for now</span>";
	}
}
echo "</div>";
}
}

?>

<div class="operation-report-container" id="search-box">
<h4 style="margin:0px">Search</h4>
<?php require("search/searchform.php")?>
</div>

<div id="front-ad-wrapper">
<img src="resrc/image/advert2.jpeg" id="front-ad"/>
</div>

<?php echo "".((!isset($_GET['next']) || $_GET['next']==0) ? "<h4 style=\"margin:2% 0px 0px 5%\" id=\"recent-uploads-head\">Recent Uploads</h4>" : 
				"<h4  style=\"margin:2% 0px 0px 5%\" id=\"recent-uploads-head\">More recent uploads</h4><p style=\"margin:2% 0px 0px 0px\">For more filtered properties <a href=\"categories\">Go to categories</a></p>").""?>
<?php
//get some properties from the database
$max = 8;
if(isset($_GET['next']) && $_GET['next']>0){
	$start = $_GET['next'];
}
 else{
	 $start = 0;
 }
 $x = $start+1;
 $y = $start;
 
 $totalproperties = mysql_num_rows(mysql_query("SELECT property_ID FROM properties"));
 $fetchproperties = mysql_query("SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded,timestamp,views FROM properties ORDER BY date_uploaded DESC LIMIT $start,$max");
 if($fetchproperties){
	$count = 0;
	while($property = mysql_fetch_array($fetchproperties,MYSQL_ASSOC)){
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
	$count++;
	$y++;
//last value of count will eventually equals to the total records fetched.
}
//request for script that will display the fetched record orderly
//this $ref is needed to set URL [of the property image] in the included script 		
$ref="home_page";
require("require/propertyboxes.php");	
if(!empty($propertyId)){
	echo "<p>showing $x - $y of $totalproperties <a class=\"show-more-link\" href=\"?next=$y\" >show more >></a></p>";
}
else{
if($start==0){
	echo "<div class=\"no-property\">There are no properties for now</div>";
}
else if($start>0){
	echo "<div class=\"no-property\">There are no more recent properties</div>";
	}
}
	

	}
	
else{
	echo "<div class=\"no-property\">An error occured!!<br/><br/>Recents upload records could not be get fromn the server at this time, we'll resolve this ASAP,
	we regret any inconvience this might bring you </div>";
			}

	?>
</div>
<div>
<?php require('require/footer.html');
 ?>
</div>
</div>
<?php 
//side 3 begins here
 ?>
<div class="agents-snipet" id="agents-snipet-top">
<div id="most-viewed-wrapper">
<h3 id="most-viewed-heading" >Most Viewed</h3>
<div id="most-viewed-container">
<?php
$getMostViewed = mysql_query("SELECT property_ID,directory,type,location,rent,date_uploaded,uploadby,timestamp,views FROM properties ORDER BY views DESC LIMIT 10");
 if($getMostViewed){
	echo "<ul class=\"no-padding-ul\">";
	while($mv = mysql_fetch_array($getMostViewed,MYSQL_ASSOC)){
	$mv_id = $mv['property_ID'];
	$mv_dir = $mv['directory'];
	$mv_type = $mv['type'];
	$mv_location = $mv['location'];
	$mv_rent = $mv['rent'];
	$mv_view = $mv['views'];
	$mv_uploadby = $mv['uploadby'];
	$mv_timeuploaded = $mv['timestamp'];
	$ub = mysql_query("SELECT Business_Name FROM profiles WHERE User_ID = '$mv_uploadby'");
	if($ub){
		$uu = mysql_fetch_array($ub,MYSQL_ASSOC);
		$uploaderBusinessName = $uu['Business_Name'];
	}else{
		$uploaderBusinessName = "Unknown";
	}
 echo "<li class=\"most-viewed-list\"><a style=\"color:purple\" href=\"properties/$mv_dir\">$mv_type at $mv_location</a>
 <br/><span class=\"rent-figure\" style=\"opacity:0.5\"> N ".number_format($mv_rent)."</span>
 <p style=\"margin:0px;color:grey;text-align:right\">$mv_view views</p>
 <p class=\"extra-info\"> uploaded by <a href=\"$mv_uploadby\">$uploaderBusinessName </a><br/> on ".Timestamp($mv_timeuploaded)."</p>
 </li>
 ";
	
}
echo "</ul>";
 }
?>
</div>
</div>
<div id="agents-list-wrapper">
<div style="width:97%;margin:auto; padding:1.5%; background-color:#CECECE">
<h4 style="margin:0px">Agents</h4>
<div id="agents-snipet-search-input-desktop-wrapper">
<input onkeyup="getAgents(this.value,'agents-snipet-search-input-desktop','suggested-agents-search-container-desktop','suggested-agents-search-list-desktop')" class="agents-snipet-search-input" id="agents-snipet-search-input-desktop" type="text" placeholder="search for an agent" maxlength="50"/>
<img src="resrc/loading.gif" id="loading-gif"/>
</div>
</div>
<div id="agents-list-container">
<div class="suggested-agents-search-container suggestion-box" id="suggested-agents-search-container-desktop">
<div class="suggested-agents-search-list" id="suggested-agents-search-list-desktop" style="padding:0px; ">
</div>
</div>

<ul id="agents-list-container">
<?php
$getAgents = mysql_query("SELECT Business_Name,User_ID FROM profiles LIMIT 10");
if($getAgents){
	while($agent = mysql_fetch_array($getAgents,MYSQL_ASSOC)){
	echo "<li class=\"agents-list\"><a class=\"agents-list\" href=\"".$agent['User_ID']."\"><span class=\"black-icon agent-avatar\"></span>".$agent['Business_Name']."</a>
	<p class=\"extra-info\">".mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE uploadby = '".$agent['User_ID']."'"))." properties";
	
if($status==1 || $status==9){
//check for follow
if($status==1){
	$followQuery = "SELECT * FROM follow WHERE follower = '$Business_Name' AND following = '".$agent['Business_Name']."'";
	$user = $Business_Name;
	$userid = $profile_name;
	$followtype = 'A4A';
}
else if($status==9){
	$followQuery = "SELECT * FROM follow WHERE follower = '$ctaname' AND following = '".$agent['Business_Name']."'";
	$user = $ctaname;
	$userid = $ctaid;
	$followtype = 'C4A';
}
$target = $agent['Business_Name'];
$buttonid = $agent['User_ID'];
if(mysql_num_rows(mysql_query($followQuery))==1){
	$text = 'unfollow';
	$f = 'unfollow-button';
	$ficon = 'white-icon unfollow-icon';
}
else{
	$text = 'follow';
	$f = 'follow-button';
	$ficon = 'black-icon follow-icon';
		}
echo "<button style=\"float:right;\" class=\"$f\" id=\"$buttonid\" onclick=\"follow('$buttonid','$user','$userid','$target','$followtype')\" ><i class=\"$ficon\"></i> $text</button>
</p></li>";
	}
//if it was a visitor
else{
	$text = 'follow';
	$f = 'follow-button';
	$ficon = 'black-icon follow-icon';
echo "<a href=\"$root/cta/checkin.php?_rdr=1\"><button style=\"float:right\" class=\"$f\" ><i class=\"$ficon\"></i>  $text</button></li>";
	
}
	}
	
}
else{
	echo "can't get agents from the server";
}

mysql_close($db_connection);
?>
</ul>
<a style="float:right;" href="agents">see all agents>></a>
</div>
</div>

</div>

</body>
</html>
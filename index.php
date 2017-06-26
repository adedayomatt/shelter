
<?php 
$connect = true;
require('require/connexion.php'); 
?>

<!DOCTYPE html>
<html>
<?php require('require/meta-head.html'); ?>
<header>
<link href="css/general.css" type="text/css" rel="stylesheet" />
<link href="css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="css/index_styles.css" type="text/css" rel="stylesheet" />
<link href="css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<script>
</script>
<?php 
$pagetitle = 'Home';
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
<span class="on-scrolltop-menu" id="toggle-search-agent-container-button" onclick="showSearchAgent()">search agent</span>
<a href="#search"><span class="on-scrolltop-menu">search property</span></a>
<?php echo ($status==9 ? "<a href=\"cta\"><span class=\"on-scrolltop-menu\">$ctaname</span> </a>" :
			($status==1 ? "<a href=\"$profile_name\"><span class=\"on-scrolltop-menu\">".substr($Business_Name,0,12)."...</span> </a>": "<a style=\"color:white\" href=\"cta/checkin.php#create\"><span class=\"on-scrolltop-menu\">create CTA</span></a>" ) )?>

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
	
	/*echo "<div id=\"search\">
	<div class=\"\" id=\"about-container\">
	<h1 id=\"about-head\">About Us</h1>
<p id=\"about\">Shelter.com provide an exclusive realty services all over the country. Getting your choice of property is our concern. We help you to find that your dream home you want to live in. <br/><a style=\"float:right\" class=\"yellow-inline-block-link\" href=\"\">Learn more »</a></p>
</div>
</div>";*/

echo "<div class=\"\" id=\"about-container\">
<p style=\"display:block;text-align:center;margin:0px\">A graphic will appear here<br/>loading...</p>
<img src=\"resrc/gifs/progress-circle.gif\" class=\"front-image\"/>

</div>";
}
?>
<?php
//one or two notifications will appear here only on the load of the homepage and not when viewing more uploads
if(!isset($_GET['next']) || $_GET['next']==0){
if($status==1 || $status==9){
	
if($status == 1){
   $totalNotification = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE (receiver='$Business_Name' OR receiver='allAgents')"));
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$Business_Name' OR receiver='allAgents')  ORDER BY time DESC LIMIT 2");
}
else if($status == 9){
	   $totalNotification = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE ((receiver='$ctaname' OR receiver='allAgents')  AND action != 'CTA created')"));
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE ((receiver='$ctaname' OR receiver='allAgents') AND action != 'CTA created') ORDER BY time DESC");
}
if($getnotifications){
	if(mysql_num_rows($getnotifications) != 0){
		echo "<div class=\"operation-report-container\" id=\"mini-notification\">
		<h4  class=\"home-headings\">Notifications ($totalNotification)</h4>";
//the function notify() is in this required file, it returns list of the notifications. This file is also used on the notifications page itself
	require("notifications/functionNotice.php");	
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
echo "<a href=\"notifications\" style=\"text-align:right\">See all notifications</a>
</div>";
			}
		}

	}
}

?>

<div id="search-mv-agent-container">
<div id="search-box-ad-container">
<div style="border:1px solid #E3E3E3">
<h3 id="search-heading">Search</h3>
<div id="search-box">
<?php require("search/searchform.php")?>
</div>
</div>
<div id="front-ad-wrapper">
<img src="resrc/image/advert2.jpeg" alt="Advert will be placed here" id="front-ad"/>
</div>
</div>

<div class="agents-snipet" id="agents-snipet-top">

<h3 id="most-viewed-heading" >Most viewed</h3>
<div id="most-viewed-wrapper">
<div id="most-viewed-container">
<div class="ul-wrapper">
<?php
$getMostViewed = mysql_query("SELECT property_ID,directory,type,location,rent,date_uploaded,uploadby,timestamp,views FROM properties ORDER BY views DESC LIMIT 10");
 if($getMostViewed){
	while($mv = mysql_fetch_array($getMostViewed,MYSQL_ASSOC)){
	$mv_id = $mv['property_ID'];
	$mv_dir = $mv['directory'];
	$mv_type = $mv['type'];
	$mv_location = $mv['location'];
	$mv_rent = $mv['rent'];
	$mv_view = $mv['views'];
	$mv_uploadby = $mv['uploadby'];
	$mv_timeuploaded = $mv['timestamp'];
	$ub = mysql_query("SELECT Business_Name FROM profiles WHERE User_ID = '$mv_uploadby' LIMIT 10");
	if($ub){
		$uu = mysql_fetch_array($ub,MYSQL_ASSOC);
		$uploaderBusinessName = $uu['Business_Name'];
	}else{
		$uploaderBusinessName = "Unknown";
	}
 echo "<div class=\"most-viewed-list\"><a style=\"color:purple\" href=\"properties/$mv_dir\">$mv_type at $mv_location</a>
 <br/><span class=\"mv-rent-figure\"> N ".number_format($mv_rent)."</span>
 <p style=\"margin:0px;color:grey;text-align:right\">$mv_view views</p>
 <p class=\"extra-info\"> uploaded by <a href=\"$mv_uploadby\">$uploaderBusinessName </a><br/>".Timestamp($mv_timeuploaded)."</p>
 </div>
 ";
	
}
 }
?>
</div>
</div>
</div>

</div>

</div>


<?php
//<h3 id=\"recent-uploads-heading\">Recent Uploads</h3>
				echo (!isset($_GET['next']) || $_GET['next']==0) ? "":
			"<a style=\" display:inline-block;padding:2% 5% 2% 5%; margin:2% 0px 2% 0px; color:white;background-color:#74B4E0; border-radius:5px\" href=\"categories\">Go to categories »</a><br/>";
				?>
<?php
//get some properties from the database
$max = 9;
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
	echo "<p style=\"display:block\">showing $x - $y of $totalproperties</p>";
	
	echo "<div class=\"next-prev-container\">";
	if(isset($_GET['next']) && $_GET['next'] > 0 ){
		echo "<a class=\"previous\" href=\"?next=".($y-2*$max)."\" >« prev</a>";
	}
if( !isset($_GET['next']) || (isset($_GET['next']) && ($_GET['next'] < ($totalproperties-$max))) ){
	echo "<a class=\"next\" href=\"?next=$y\" >next »</a>";
}	
echo "</div>";
	
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
	echo "<div class=\"no-property\">An error occured!!<br/><br/>Recents upload records could not be get from the server at this time, we'll resolve this ASAP,
	we regret any inconvience this might bring you </div>";
			}

	?>
	
	
	
	
	
	<div id="agents-list-wrapper">
<h3 id="agents-heading" style="margin:0px">Agents</h3>
<div id="agents-list-container">

<div>
<div id="agents-list-container">
<?php
$getAgents = mysql_query("SELECT Business_Name,Office_Address,User_ID FROM profiles LIMIT 10");
if($getAgents){
	while($agent = mysql_fetch_array($getAgents,MYSQL_ASSOC)){
	echo "<div class=\"agents-list\"><a href=\"".$agent['User_ID']."\"><span class=\"black-icon agent-avatar\"></span>".$agent['Business_Name']."</a>";
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
";
	}
//if it was a visitor
else{
	$text = 'follow';
	$f = 'follow-button';
	$ficon = 'black-icon follow-icon';
echo "<a href=\"$root/cta/checkin.php?_rdr=1\"><button style=\"float:right;\" class=\"$f\" ><i class=\"$ficon\"></i>  $text</button>";
	
}
	
echo "<p class=\"extra-info\">".$agent['Office_Address']."</p>
	<p class=\"extra-info\" style=\"display:inline-block\">".mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE uploadby = '".$agent['User_ID']."'"))." properties</p>";
	

echo "</div>";
	}
	
}
else{
	echo "can't get agents from the server";
}

?>
</div>
</div>
<a style="float:right;" href="agents">see all agents>></a>
</div>
</div>
	
	
</div>


<div>
<?php require('require/footer.html');

mysql_close($db_connection);
 ?>
</div>
</div>


</body>
</html>
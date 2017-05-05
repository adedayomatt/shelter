<!DOCTYPE html>
<html>
<meta name="viewport" content="max-width=1000px,maximum-scale=0.35" />
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
<a href="agents" style="margin-left:60%;">view all agents</a>
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
<div id="search-box">
<h1 id="search-head">Search</h1>
<?php require("search/searchform.php")?>
</div>
<script>
function showdialog(){
	alert('Jao!');
	
}
</script>
<?php 
if(!isset($_GET['next']) || $_GET['next']==0){
	echo "<div id=\"mandate-container\">
<h1 id=\"mandate-head\">Our Mandate</h1>
<p id=\"mandate\">We provide an exclusive realty services all over the country. Getting your choice of property is our concern. We help you to find that your dream home you want to live in. <a href=\"\">Read more</a> on how we operate.</p>
</div>";
}
else{
	if($status==0){
		echo "<div id=\"hold-up-container\"><h1 id=\"hold-up-head\">HOLD UP!</h1><p id=\"hold-up\">You are viewing recent uploads by our agents. We can help you find what you are looking for; you can <a href=\"search\">use the local search engine</a> or make a special by <a href=\"cta/checlin.php\">creating a CTA</a></p></div>";
	}
}
?>
<h1  id="recent-uploads-head"><?php echo ((!isset($_GET['next']) || $_GET['next']==0) ? "Recent Uploads" : "More recent uploads") ?></h1>
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
 $fetchproperties = mysql_query("SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded,timestamp FROM properties ORDER BY date_uploaded DESC LIMIT $start,$max");
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
<div id="front-image">

</div>
<hr/>
<div style="width:90%;margin:auto;">
<input onkeyup="getAgents(this.value,'agents-snipet-search-input-desktop','suggested-agents-search-container-desktop','suggested-agents-search-list-desktop')" class="agents-snipet-search-input" id="agents-snipet-search-input-desktop" type="text" placeholder="search for an agent" maxlength="50"/>
</div>
<hr/>
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
	echo "<li class=\"agents-list\"><a class=\"agents-list\" href=\"".$agent['User_ID']."\"><span class=\"black-icon agent-avatar\"></span>".$agent['Business_Name']."</a>";
	
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
echo "<button style=\"float:right\" class=\"$f\" id=\"$buttonid\" onclick=\"follow('$buttonid','$user','$userid','$target','$followtype')\" ><i class=\"$ficon\"></i> $text</button></li>";
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
</div>

<a style="float:right;" href="agents">see all agents>></a>
</div>

</body>
</html>
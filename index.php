<!DOCTYPE html>
<html>
<header>
<link href="css/general.css" type="text/css" rel="stylesheet" />
<link href="css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="css/index_styles.css" type="text/css" rel="stylesheet" />
<link href="css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<script>
</script>
<?php 
$pagetitle = 'Home';
//this $reference_page is needed in the header to specify if script should get further info
$connect = true;
$getuserName = true;
require("require/header.php");
?>
<script type="text/javascript" src="js/home.js"></script>
<script type="text/javascript" src="js/propertybox.js"></script>
<script type="text/javascript" src="js/profile.js" type="text/javascript"></script>
</header>
<body class="no-pic-background" onload="activateslide()">
<div class="maincontent">
<!--Leftmost side begins-->
<?php require('require/sidebar.php'); ?>
<!--Leftmost side ends-->

<!--<div class= "search_area">
<div class="short-note"><p><b>Shelter.com is a platform that takes advantage of technology to ease your troubles in finding properties to rent or buy anywhere in Nigeria...</b><a href="about">learn more</a></p></div>
<p>You can search for property using the search preference</p>
</div>-->
<div class="recent-uploads-container">
<div id="search-box">
Search for properties...
<?php require("search/searchform.php")?>
</div>
<?php
/*if($status != 1){
	$todo = "Have any property to sell, put it on Shelter today and connect with the buyer.<br/>It is easy, just click <a id=\"links\" href=\"signup.php\"><strong>here<strong></a>";
  echo "<p align=\"center\">$todo</p><hr/>";
	}
	*/
?>
<button type="button" title = "Refresh Page" value="refresh" onclick="javascript:location.reload()" style="border:none; cursor:pointer; background-color:inherit; display:inline; float:right;"><i style="display:inline-block;width:14px;height:14px;background-image:url('resrc/black-icons.png');background-position:-216px -24px;"></i>Refresh</button>
<form style = "margin-left:20px; font-weight:normal"> <label for="filter" >Filter recent uploads by location</label>
<select  name="filter">
<option value="all">Everywhere</option>
<option value="Ibadan">Ibadan</option>
<option value="Abeokuta">Abeokuta</option>
</select>
<input type="submit" value="Filter" style="background-color:#6D0AAA; color:white; cursor:pointer; border:none"/>
</form>
<div style="min-height:400px">
<?php
//get some properties from the database
$max = 4;
if(isset($_GET['next']) && $_GET['next']>0){
	$start = $_GET['next'];
	$end = $_GET['next'] + $max;
}
 else{
	 $start = 0;
	 $end = $max;
 }
 $x = $start+1;
 $y = $start;
 
 $totalproperties = mysql_num_rows(mysql_query("SELECT property_ID FROM properties"));
 $fetchproperties = mysql_query("SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded,timestamp FROM properties ORDER BY date_uploaded DESC LIMIT $start,$end");
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
	echo "<p>showing $x - $y of $totalproperties</p>";
echo "<a style=\"margin-left:80%\" href =\"?next=$end\" >show more<a/>";
}
else{
if($start==0){
	echo "<div class=\"no-property\" align=\"center\">There are no propertties for now</div>";
}
else if($start>0){
	echo "<div class=\"no-property\" align=\"center\">There are no more recent properties</div>";
	}
}
	

	}
	
else{
	echo "<div class=\"no-property\" align=\"center\">An error occured!!<br/>Recents upload records could not be get fromn the server at this time, we'll resolve this ASAP,
	we regret any inconvience this might bring you </div>";
			}



	?>
</div>
<div>
<?php require('require/footer.html');
 ?>
</div>
</div>

<div class="agents-snipet" id="agents-snipet-top">
<div id="front-image">
<h1>ADVERTISEMENT!!!</h1>
<h3>This space would be for advert image, most likely for the site</h3>
</div>
<hr/>
<div style="width:90%;margin:auto;">
<input id="agents-snipet-search" style="width:95%;padding:5px;height:30px;" type="text" placeholder="search for an agent"/>
</div>
<hr/>
<div id="agents-list-container">
<ul id="agents-list-container">
<?php
$getAgents = mysql_query("SELECT Business_Name,User_ID FROM profiles LIMIT 10");
if($getAgents){
	while($agent = mysql_fetch_array($getAgents,MYSQL_ASSOC)){
	echo "<li class=\"agents-list\"><a class=\"agents-list\" href=\"".$agent['User_ID']."\">".$agent['Business_Name']."</a>";
	
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
echo "<button class=\"$f\" id=\"$buttonid\" onclick=\"follow('$buttonid','$user','$userid','$target','$followtype')\" ><i class=\"$ficon\"></i> $text</button></li>";
	}
//if it was a visitor
else{
	$text = 'follow';
	$f = 'follow-button';
	$ficon = 'black-icon follow-icon';
echo "<a href=\"$root/cta/checkin.php?_rdr=1\"><button class=\"$f\" ><i class=\"$ficon\"></i>  $text</button></li>";
	
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

</div>
</body>
</html>
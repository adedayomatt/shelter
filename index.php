<!DOCTYPE html>
<html>
<head>
<link href="css/general.css" type="text/css" rel="stylesheet" />
<link href="css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="css/index_styles.css" type="text/css" rel="stylesheet" />
<link href="css/propertybox_styles.css" type="text/css" rel="stylesheet" />

<?php 
$pagetitle = 'Home';
//this $reference_page is needed in the header to specify if script should get further info
$connect = true;
$getuserName = true;
require("require/header.php");
?>
<script type="text/javascript" src="js/indexscript.js"></script>
<script type="text/javascript" src="js/propertyboxAjax.js"></script>
<script type="text/javascript" language="javascript" src="js/toggle.js"></script>

</head>
<body class="no-pic-background" onload="activatescript()">
<div class="maincontent">
<!--Leftmost side begins-->
<?php require('require/sidebar.php'); ?>
<!--Leftmost side ends-->

<!--centre side begins-->
<div  class="uploads-container">
<div class= "search_area">
<div class="short-note"><p><b>Shelter.com is a platform that takes advantage of technology to ease your troubles in finding properties to rent or buy anywhere in Nigeria...</b><a href="about">learn more</a></p></div>
<div  >
<p>You can search for property using the search preference</p>
<?php require("search/searchform.php")?>
</div></div>
<hr/>
<div class="recent-uploads-container">
<?php
if($status != 1){
	$todo = "Have any property to sell, put it on Shelter today and connect with the buyer.<br/>It is easy, just click <a id=\"links\" href=\"signup.php\"><strong>here<strong></a>";
  echo "<p align=\"center\">$todo</p><hr/>";
	}
?>
<p style="color:#6D0AAA; display:inline; margin-left:25%;"> Recently uploaded properties</p>
<button type="button" autofocus="autofocus" value="refresh" onclick="javascript:location.reload(true)" style="border:none; cursor:pointer; background-color:inherit; display:inline; float:right;"><i style="display:inline-block;width:14px;height:14px;background-image:url('resrc/black-icons.png');background-position:-216px -24px;"></i>Refresh</button>
<hr/>
<form style = "margin-left:20px; font-weight:normal"> <label for="filter" >Filter recent uploads by location</label>
<select  name="filter">
<option value="all">Everywhere</option>
<option value="Ibadan">Ibadan</option>
<option value="Abeokuta">Abeokuta</option>
</select>
<input type="submit" autofocus="autofocus" value="Filter" style="background-color:#6D0AAA; color:white; cursor:pointer; border:none"/>
</form>
<div style="min-height:400px">
<?php
//get some properties from the database
$fetchproperties = mysql_query("SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded FROM properties ORDER BY date_uploaded DESC");
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
	$count++;
//last value of count will eventually equals to the total records fetched.
}
//request for script that will display the fetched record orderly
//this $ref is needed to set URL in the included script 		
$ref="home_page";
require("require/propertyboxes.php");	
	}
	
else{
	echo "<p align=\"center\"><b>An error occured!!<br/>Recents upload records could not be get fromn the server at this time, we'll resolve this ASAP,
	we regret any inconvience this might bring you </b></p>";
			}



	?>
</div>
<div>
<?php require('require/footer.html');
 mysql_close($db_connection);
 ?>
</div>
</div>
<!--Right hand side begins-->
<div class="adverts-container">
<h3>Ads</h3><p size="10px"><a href="advert.html">Place your advert here</a></p>
<a href="adone.html"><img id="pic" src="image/images5.jpeg" height="100px" width="100%" ></img></a>
<a href="adtwo.html"><img id="pic2" src="image/images6.jpeg" height="100px" width="100%"></img></a>
<a href="adthree.html"><img id="pic3" src="image/images7.jpeg" height="100px" width="100%"></img></a>
</div>
</div>
<!--centre side ends-->

<!--Right hand side ends-->

</style>
<!--maincontent ends here-->
</div>
</body>
</html>
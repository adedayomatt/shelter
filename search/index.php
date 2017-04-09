<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/searchresult_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../js/propertybox.js"></script>
<?php 
$pagetitle = 'Search';
?>
<?php
$ref='searchpage';
$connect =true;
$getuserName=true;
require("../require/header.php");
?>
<?php
function ifset($variable){
	$final = (isset($variable)? $variable : null);
	return $final;
}
?>
<body class="no-pic-background">
<?php require('../require/sidebar.php')?>

<div class="main-content results">
<?php
//If nothing has been searched for , display the search form
if(!isset($_GET['type']) || !isset($_GET['max']) || !isset($_GET['location'])){
	echo "<br/><br/>";
	echo "<p align=\"center\"><b>Please select your preference</b></p>";
require("searchform.php");	
	}
//...else use the information in the search field to filter results
else{
	//if all the three param are set
$propertytype = ($_GET['type']);
$maxprice = ($_GET['max']);
$loc = ($_GET['location']);
$maxi = 2;
require("getsearchresults.php");
$ref="search_page";
require("../require/propertyboxes.php");

if(!empty($propertyId)){
echo "<a style=\"margin-left:50%\" href =\"?type=$propertytype&max=$maxprice&location=$loc&next=$end\" >show more results</a>";
}

//if no match is found for the search, get related results
else{
if($start==0){
	echo "<div class=\"no-property\" align=\"center\">There is no result for your search</div>";
}
else if($start>0){
	echo "<div class=\"no-property\" align=\"center\">There are no more result for your search</div>";
	}

	
echo "<h4>Show other results on</h4> <ul>";
	if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] != "All types" && $_GET['type'] != 'all')
	{echo "<li><a href=\"?type=".$_GET['type']."&max=0&location=everywhere\">".$_GET['type']."</a></li>";}

	if(isset($_GET['max'])&& !empty($_GET['max']) && $_GET['max'] != 0)
	{echo "<li><a href=\"?type=all&max=".$_GET['max']."&location=everywhere\">Properties less than ".$_GET['max']."</a></li>";}

	if(isset($_GET['location'])&& !empty($_GET['location']) && $_GET['location'] != "everywhere")
	{echo "<li><a href=\"?type=all&max=0&location=".$_GET['location']."\">Properties around ".$_GET['location']."</a></li>";}

	echo "</ul>";
	}
		
}
?>
</div>




<div class="related-results">

<?php
if(isset($_GET['type']) || isset($_GET['max']) || isset($_GET['location'])){
	echo "<h3 align=\"center\">Related Results</h3>";
	$IDsuggest = array();
	$typesuggest = array();
	$locationsuggest = array();
	$pricesuggest = array();
	$s = 0;
	if($propertytype != "All types"){
	$getsuggestions = "SELECT property_ID,directory,type,location,rent FROM properties WHERE (type = '$propertytype') AND ((location LIKE '%$loc%') OR (rent <= $maxprice)) ORDER BY date_uploaded DESC";	
	}
	else{
	$getsuggestions = "SELECT property_ID,directory,type,location,rent FROM properties WHERE (location LIKE '%$loc%') OR (rent <= $maxprice) ORDER BY date_uploaded DESC";		
	}
	$getsuggestions_query = mysql_query($getsuggestions);
	if($getsuggestions_query){
//if number of fetch is one or more
		if(mysql_num_rows($getsuggestions_query) >= 1){
		echo "<ul id=\"related-results-list\">";
		while($suggest = mysql_fetch_array($getsuggestions_query,MYSQL_ASSOC)){
		$dir[$s] = $suggest['directory'];
		echo "<li class=\"related-results-list\"><a class=\"related-results\" href=\"$root/properties/".$suggest['directory']."\">".$suggest['type']." at ".$suggest['location']." for N ".number_format($suggest['rent'])."</a></li>";
		$s++;
//display max of 12 related results
		if($s==12){
			break;
		}
		}
		echo "</ul>";
	}
//if no related result is selected from db = 0
	else
	{
		echo "<div class=\"no-property\">No related result</div>"; }
}
//if getsuggestions query return false
	else { echo "<p>could not get related results</p>"; }
}
	
if($status == 0 || $status==9)	{
echo "<br/><br/><p align=\"left\" style=\"padding-left:10px;\">Can't find what you are looking for?, Try a new search</p>";
	//require("searchform.php");
	echo "<p align=\"left\" style=\"padding-left:10px;\"><a href=\"../cta/request.php?p=1\">make a special request</a></p>";
echo "<p align=\"right\" style=\"padding-right:10px;\"><b>Have any problem searching?<br/>contact <a href=\"\">our help center</a></b></p>";
}
	
	mysql_close($db_connection);
?>
</div>





</body>
</html>
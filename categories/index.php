<!DOCTYPE>
<html>
<meta name="viewport" content="maximum-scale=0.35" />

<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/categories_styles.css" type="text/css" rel="stylesheet" />
<header>
<?php
$pagetitle = 'Categories';
$connect = true;
$getuserName = true;
require('../require/header.php');
?>
</header>
<body class="no-pic-background" id="body">
<script>
function showcatalog(){
	var fadeout;
	var fadein;
	var catelogheight = 0;
   var catelogfullheight = 600;
	var mobileCatelog = document.getElementById('mobile-category-catalog');
	var desktopCatelog = document.getElementById('category-catalog');
	if(mobileCatelog.style.display != "block"){	
//	fadein = setInterval(fadeincatalog,1);	
	mobileCatelog.style.display = "block";
	document.getElementById('catalog-ball').innerHTML = "&times";
	
	}else{
		//mobileCatelog.innerHTML =" ";	
document.getElementById('catalog-ball').innerHTML = "";		
		mobileCatelog.style.height = "0px";
		mobileCatelog.style.display = "none";
	
		//fadeout = setInterval(fadeoutcatalog,1);
	}
	
function fadeincatalog(){
	if(catelogheight == catelogfullheight){
		clearInerval(fadein);
	}
	else{
		catelogheight += 20;
mobileCatelog.style.height = catelogheight + "px";
	}
}

/*
function fadeoutcatalog(){
	if(catelogfullheight == 0){
	mobileCatelog.innerHTML = "";
	
		clearInerval(fadeout);
	}
	else{
		catelogfullheight--;
mobileCatelog.style.height = catelogfullheight + "px";
	}
}
	*/
}
</script>
<div id="mobile-catalog-container">
<div id="mobile-category-catalog" style="background-color:green">
<ul class="no-padding-ul">
<a href="?c=Flat"><li class="category-list">Flat</li></a>
<a href="?c=Duplex"><li class="category-list">Duplex</li></a>
<a href="?c=Bungalow"><li class="category-list">Bungalow</li></a>
<li class="category-list">Warehouse</li>
<li class="category-list">Shop</li>
</ul>
</div>
</div>
<div id="catalog-ball" onclick="javascript: showcatalog()"></div>
<?php 
//This included purposely for mobile.
require('../require/sidebar.php');
function display($directory,$id,$type,$location,$rent,$manager){
$propertyRoot = "../properties/".$directory;
//get the image...	
if(file_exists($propertyRoot."/$id"."_01")){
	$imagesrc = $propertyRoot."/$id"."_01";
}
else if(file_exists($propertyRoot."/$id"."_02")){
	$imagesrc = $propertyRoot."/$id"."_02";
}
else if(file_exists($propertyRoot."/$id"."_03")){
	$imagesrc = $propertyRoot."/$id"."_03";
}
else if(file_exists($propertyRoot."/$id"."_04")){
	$imagesrc = $propertyRoot."/$id"."_04";
}
//if no image is found, then use the default image
else{
	$imagesrc = "../properties/default.png";
}
$property = "<div class=\"category-property-box\">
<img class=\"category-property-image\" src=\"$imagesrc\" />
<div class=\"category-property-detail-container\" >
<span class=\"category-property-detail\"><a href=\"$propertyRoot\">$type</a></span>
<span class=\"category-property-detail\">$location</span>
<span class=\"category-property-detail\">Rent:<strong>".number_format($rent)."</strong></span>
<span class=\"category-property-detail\">uploaded by: $manager</span>
</div>
</div>";
echo $property;
}
?>
<script>
var mTop = 0;
window.onscroll = function(event){
var contentHeight  = document.getElementsByTagName("body")[0].clientHeight;
if(window.pageYOffset <= (contentHeight*2)){
	mTop = window.pageYOffset;
}
else{
	mTop =0
}
//This is to retain the catalog container in mobile on window scroll
//document.getElementById("mobile-catalog-container").style.marginTop =  mTop + window.screen.height + "px";
	
/*	var h = document.getElementById("top-nav-bar-content").clientHeight;
	if(window.pageYOffset >= h){
		document.getElementById("category-catalog").style.marginTop = (window.pageYOffset - h)+"px";
	}
	else{
		document.getElementById("category-catalog").style.marginTop = "0px";
	}
	*/
}

</script>
<div id="desktop-category-catalog">
<div id="category-catalog">
<h1 id="category-catalog-heading">Categories</h1>
<ul id="categories-ul" class="no-padding-ul">
<a href="?c=Flat"><li class="category-list">Flat</li></a>
<a href="?c=Duplex"><li class="category-list">Duplex</li></a>
<a href="?c=Bungalow"><li class="category-list">Bungalow</li></a>
<li class="category-list">Warehouse</li>
<li class="category-list">Shop</li>
</ul>
</div>
</div>

<div class="specific-category-container">
<?php 
if(isset($_GET['c'])){
	$category = $_GET['c'];
$availableCategory = array("Flat","Duplex","Bungalow");
if(in_array($category,$availableCategory)){
	echo "<h3 style=\"display:block\">$category</h3>";
$totalproperties = mysql_num_rows(mysql_query("SELECT * FROM properties WHERE type='$category'"));
$getCategories = mysql_query("SELECT * FROM properties WHERE (type='$category') LIMIT 10");
if($getCategories){
	while($category = mysql_fetch_array($getCategories,MYSQL_ASSOC)){
	display($category['directory'],$category['property_ID'],$category['type'],$category['location'], $category['rent'], $category['uploadby']);
	}
}
mysql_close($db_connection);
	echo "</body></html>";
	exit();
			}	
		}
?>

</div>



<div class="categories-container">

<img src="../resrc/image/advert2.jpeg" class="advert-img"/>

<div class="property-category-container" id="flats">
<?php
$totalFlats = mysql_num_rows(mysql_query("SELECT * FROM properties WHERE type='Flat'"));
?>
<h1 class="category-headers">Flats (<?php echo $totalFlats ?>)</h1>
<div class="category-sample-container">
<?php
if($totalFlats != 0){
$getFlats = mysql_query("SELECT * FROM properties WHERE type='Flat' ORDER BY date_uploaded DESC LIMIT 4");
if($getFlats){
	while($flat = mysql_fetch_array($getFlats,MYSQL_ASSOC)){
		display($flat['directory'],$flat['property_ID'],$flat['type'],$flat['location'], $flat['rent'], $flat['uploadby']);
	}
}
$showmoreflat = "<br/><a href=\"?c=Flat\">see more Flats</a>";
}
else{
	echo "<p style=\"color:red; font-size: 150%;\"align=\"center\">There is no Flat available for now</p>";
	$showmoreflat = "<a>make a request for Flat</a>";
}
echo $showmoreflat;
?>
</div>
</div>

<div class="property-category-container" id="duplex">
<?php
$totalDuplexs = mysql_num_rows(mysql_query("SELECT * FROM properties WHERE type='Duplex'"));
?>
<h1 class="category-headers">Duplex (<?php echo $totalDuplexs ?>)</h1>
<div class="category-sample-container">
<?php
$getDuplexs = mysql_query("SELECT * FROM properties WHERE type = 'Duplex' ORDER BY date_uploaded DESC");
if($totalDuplexs != 0){
if($getDuplexs){
	while($duplex = mysql_fetch_array($getDuplexs,MYSQL_ASSOC)){
		display($duplex['directory'],$duplex['property_ID'],$duplex['type'],$duplex['location'], $duplex['rent'], $duplex['uploadby']);
	}
}
$showmoreduplex = "<br/><a href=\"?c=Duplex\">see more Duplexs</a>";
}
else{
	echo "<p style=\"color:red; font-size: 150%;\"align=\"center\">There is no Duplex available for now</p>";
	$showmoreduplex = "<a>make a request for Duplex</a>";
}
echo $showmoreduplex;
?>
</div>
</div>

<img src="../resrc/image/advert1.jpeg" class="advert-img"/>

<div class="property-category-container" id="bungalow">
<?php
$totalBungalows = mysql_num_rows(mysql_query("SELECT * FROM properties WHERE type='Bungalow'"));
?>
<h1 class="category-headers">Bungalow (<?php echo $totalBungalows ?>)</h1>
<div class="category-sample-container">
<?php
if($totalBungalows != 0){
$getBungalows = mysql_query("SELECT * FROM properties WHERE type = 'Bungalow' ORDER BY date_uploaded DESC");
if($getBungalows){
	while($bungalow = mysql_fetch_array($getBungalows,MYSQL_ASSOC)){
		display($bungalow['directory'],$bungalow['property_ID'],$bungalow['type'],$bungalow['location'], $bungalow['rent'], $bungalow['uploadby']);
	}
}
$showmorebungalows = "<br/><a href=\"?c=Bungalow\">see more Bungalows</a>";
}
else{
	echo "<p style=\"color:red; font-size: 150%;\"align=\"center\">There is no Bungalow available for now</p>";
	$showmorebungalows = "<a>make a request for Bungalow</a>";
}
echo $showmorebungalows;
?>
</div>
</div>

<h1 align="center">WORK IN PROGRESS...</h1>
</div>
</body>
<?php 	mysql_close($db_connection); ?>
</html>
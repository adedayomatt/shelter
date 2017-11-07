 <?php 
require('../resources/php/master_script.php'); 

function ifset($variable){
	$final = (isset($variable)? $variable : null);
	return $final;
}
?>
<html>
<head>
<?php
$pagetitle = 'Search';
$ref='searchpage';
 require('../resources/global/meta-head.php'); ?>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/searchresult_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
</head>
<body class="no-pic-background">

<?php
if(isset($_GET['type']) || isset($_GET['max']) || isset($_GET['location'])){
?>
<div id="hidden-search-form" style="display:none">	
<?php
	require("searchform.php");
	?>
</div>
<?php

$showStaticHeader = true;
$staticHead ="<div class=\"col-sm-offset-3\">
<div class=\"row hidden-lg hidden-md hidden-sm static-head-primary\">

<span class=\"col-xs-7\">
<h3 class=\"font-80 site-color\">Search Result</h3>
</span>

<span class=\"col-xs-5\">
<button class=\"btn btn-primary new-search\"><span class=\"glyphicon glyphicon-search\"></span>Try new search</button>
</span>

<div class=\"f7-background padding-5 e3-border col-xs-12\" id=\"static-search-form\" style=\"display:none\"></div>

</div>
</div>";
}
require("../resources/global/header.php");
?>
<script>
document.querySelector('.btn.btn-primary.new-search').onclick = function(event){
	document.querySelector('#static-search-form').style.display = 'block';
document.querySelector('#static-search-form').innerHTML = "<div style=\"height:20px\"><span class=\"close\">&times</span></div>"+document.querySelector('#hidden-search-form').innerHTML;
document.querySelector('#static-search-form>div>.close').onclick = function(event){
	document.querySelector('#static-search-form').innerHTML = "";
		document.querySelector('#static-search-form').style.display = 'none';

}
//showPopup();
//popUpContent().innerHTML = document.querySelector('#hidden-search-form').innerHTML;
};
</script>
<div class="container-fluid body-content">

<div class="row">
<?php require('../resources/global/sidebar.php') ?>

<div class=" col-lg-10 col-md-10 col-sm-9 col-xs-12 main-content" >
<div class="padded-main-content">
<h3 class="major-headings"><?php echo ((isset($_GET['type']) || isset($_GET['max']) || isset($_GET['location'])) ? "Search Results":"Search")?></h3>
<?php
//If nothing has been searched for , display the search form
if(!isset($_GET['type']) || !isset($_GET['max']) || !isset($_GET['location'])){
	?>
<div class="row" >
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="background-color:white; border:1px solid #e3e3e3">
<p align="center" class="container-headers" >select your preference</p>
<?php require("searchform.php"); ?>
</div>
</div>
<?php
	}
//...else use the information in the search field to filter results
else{
	//if all the three param are set
$propertytype = ($_GET['type']);
$maxprice = ($_GET['max']);
$loc = ($_GET['location']);
require("../resources/php/get_search_results.php");


//if no match is found for the search, get related resultss
if($totalFound==0){
	?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div align="center" style="padding:5px">There is no result for your search</div>
	</div>
	</div>
	
<div class="row">
<h3 class="container-headers">Show other results on</h3> 
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
<div>
<ul class="no-padding">
<?php
if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] != "All types" && $_GET['type'] != 'all')
	{
echo "<li><a href=\"?type=".$_GET['type']."&max=0&location=everywhere\">".$_GET['type']."</a></li>";
	}
if(isset($_GET['max'])&& !empty($_GET['max']) && $_GET['max'] != 0)
	{echo "<li><a href=\"?type=all&max=".$_GET['max']."&location=everywhere\">Properties less than ".$_GET['max']."</a></li>";}

if(isset($_GET['location'])&& !empty($_GET['location']) && $_GET['location'] != "everywhere")
	{echo "<li ><a href=\"?type=all&max=0&location=".$_GET['location']."\">Properties around ".$_GET['location']."</a></li>";}

?>
</ul>
</div>
</div>
</div>
<?php
}
?>

<div class="row">
<?php
if(isset($_GET['type']) || isset($_GET['max']) || isset($_GET['location'])){
?>	
<h3 class="container-headers" align="left">Related Results</h3>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 related-results-wrapper">
<div id="related-results">
<?php

	if($propertytype != "All types"){
	$getsuggestions = "SELECT property_ID,directory,type,location,rent,display_photo FROM properties WHERE (type = '$propertytype') AND ((location LIKE '%$loc%') OR (rent <= $maxprice)) ORDER BY date_uploaded DESC LIMIT 12";	
	}
	else{
	$getsuggestions = "SELECT property_ID,directory,type,location,rent,display_photo FROM properties WHERE (location LIKE '%$loc%') OR (rent <= $maxprice) ORDER BY date_uploaded DESC LIMIT 12";		
	}
	$getsuggestions_query = $db->query_object($getsuggestions);
	if(!$connection->error){
//if number of fetch is one or more
		if($getsuggestions_query->num_rows >= 1){
			?>
		<ul class="no-padding">
	<?php		
		while($suggest = $getsuggestions_query->fetch_array(MYSQLI_ASSOC)){
		//regulate suggestions so it won't repeat original result as suggestion again
		if(!in_array($suggest['property_ID'],$all_search_result_IDs)){
?>
<li>
<a  href="<?php echo "$root/properties/".$suggest['directory'] ?>" >
<img src="<?php echo $property_obj->get_property_dp('../properties/'.$suggest['directory'], $suggest['display_photo'])?>" width="100px" height="90px" style="vertical-align:baseline"/>
<?php echo $suggest['type'].' at '. $suggest['location'].' for N '.number_format($suggest['rent']) ?></a>
</li>
<?php	
	}
}		
?>
</ul>
<?php
	}
//if no related result is selected from db = 0
	else
	{
?>
<div class="text-center red padding-10">No related result</div>
<?php
 }
}
//if getsuggestions query return false
	else { 
	?>
	<div style="padding:5px;text-align:center; color:red"><span class="black-icon void-icon"></span>could not get related results</div>
<?php
	}
}
	?>
</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 contact-search-help-container">
	<div class="text-center padding-10">
<?php
if($status == 0)	{
	?>
	 <a class="btn btn-primary btn-lg btn-block" href="../cta/request.php?p=1">Make a Special Request</a>
	 <?php
}
else if($status==9){
	?>
	 <a class="btn btn-primary btn-lg btn-block" href="../cta/request.php?p=1">Adjust Your Request</a>
	 <?php
}
?>
     <p><b>Have any problem searching?</b> <a class="btn btn-primary site-color-background" href="">contact our help center</a></p>
</div>
</div>
</div>
<?php
}
 require('../resources/global/footer.php');?>
 </div><!--padded-main-content-->
</div><!--main-content-->
</div><!--parent row-->
</div><!--container-fluid-->
</body>
</html>
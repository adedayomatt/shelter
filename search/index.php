 <?php 
require('../resources/master_script.php'); 

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
 <style>
/******************This is for the fixing of the RHS, the JavaSceipt that controls it is in the header*******************************/						
		
 
 @media all and (min-width:768px){
 [data-fix-rhs='true']{
	top:130px;
	left:58.33333333%;
	}
[data-fix-rhs='true']:hover{
	overflow:auto;
		}
	}
	
/*********************************************/
 
 

 
 </style>
</head>
<body>

<?php
if(isset($_GET['type']) || isset($_GET['max']) || isset($_GET['location'])){
?>
<div id="temp-search">
<div data-action="toggle" class="text-right">
<button data-toggle-role="toggle-trigger" data-toggle-on="&times  Hide new search" data-toggle-off="<span class='glyphicon glyphicon-search'></span>Try new search" class="btn btn-primary"></button>
<br/><div data-toggle-role="main-toggle">	
<?php
	require("searchform.php");
	?>
</div>
</div>
</div>
<?php

$showStaticHeader = true;
$staticHead ="
<div class=\"row hidden-lg hidden-md hidden-sm static-head-primary\">
<div class=\"padding-5 col-xs-12\" id=\"static-search-form\"></div>
</div>";
}
require("../resources/global/header.php");
?>
<script>
document.getElementById('static-search-form').innerHTML = document.getElementById('temp-search').innerHTML;
document.getElementById('temp-search').innerHTML = "";
</script>
<div class="container-fluid">

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="row">
<?php
//If nothing has been searched for , display the search form
if(!isset($_GET['type']) || !isset($_GET['max']) || !isset($_GET['location'])){
	?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="contain" >
<div class="head f7-background">
<h3 class="text-center">select your preference</h3>
</div>
<div class="body white-background">
<?php require("searchform.php"); ?>
</div>
</div>
</div>
<?php
	}
//If nothing has been searched for , display the search form

//...else use the information in the search field to filter results
else{
	?>
<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12" data-relative-lhs >

<h4><?php echo ((isset($_GET['type']) || isset($_GET['max']) || isset($_GET['location'])) ? "Search Results":"Search")?></h4>
	<?php
	//if all the three param are set
$propertytype = ($_GET['type']);
$maxprice = ($_GET['max']);
$loc = ($_GET['location']);
$bath = (isset($_GET['bath']) ? $_GET['bath'] : '');
$loo = (isset($_GET['loo']) ? $_GET['loo'] : '');
$tiles = (isset($_GET['tiles']) ? $_GET['tiles'] : '');
$pm = (isset($_GET['pm']) ? $_GET['pm'] : '');
$bh = (isset($_GET['bh']) ? $_GET['bh'] : '');

$search = new search($propertytype,$maxprice,$loc,$bath,$loo,$tiles,$pm,$bh);
?>

<div class="white-background padding-10 margin-5 e3-border text-center">
		<p><?php echo $search->result_showing ?></p>
<?php  
		if(!empty($search->facilities)){
			?>
			<div style="line-height:40px">
			<span>Facilities searched for: </span>
			<?php
			for($ff = 0;$ff< count($search->facilities); $ff++){
			?>
			<span class="e3-border f7-background border-radius-5 padding-5-10 margin-5"><?php echo $search->facilities[$ff] ?></span>
			<?php
			}
			?>
			</div>
		<?php
		}
	?>
		<p>Total Results Found: <?php echo $search->total_result ?></p>

</div>
	<?php
//if no match is found for the search, get related resultss
if($search->total_result == 0){
	?>
<div class="white-background padding-10 margin-5 text-center">There is no result for your search</div>
<div class="body white-background margin-5 padding-10">
<h4 class="text-left">Show other results on</h4> 
<ul>
<?php
if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] != "ns")
	{
echo "<a href=\"?type=".$_GET['type']."&max=0&location=ns\"><li>".$_GET['type']."</li></a>";
	}
if(isset($_GET['max'])&& !empty($_GET['max']) && $_GET['max'] != 0)
	{
	echo "<a href=\"?type=ns&max=".$_GET['max']."&location=ns\"><li>Properties less than ".number_format($_GET['max'])."</li></a>";
	}

if(isset($_GET['location'])&& !empty($_GET['location']) && $_GET['location'] != "ns")
	{
	echo "<a href=\"?type=ns&max=0&location=".$_GET['location']."\"><li>Properties around ".$_GET['location']."</li></a>";
	}

?>
</ul>
</div>
<?php
}
else{
	?>
	<div class="row">
	<?php
	$from = (isset($_GET['next']) ? ($_GET['next'] < 0 ? 0 : $_GET['next']): 0 );
	$to = $from + 6;
	$limited_result = $search->limited_result($from,$to);
	$search_result_counter = 0;
	$property_display_blocking = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
	while($search_result_counter < count($limited_result)){
		$property = new property($limited_result[$search_result_counter]);
		require('../resources/global/property_display.php');
		unset($property);
		$search_result_counter++;
	}
	?>
	</div>
<?php
}
?>
				<div class="padding-5 margin-5 white-background e3-border hidden-xs" >
					<h4>Try another search</h4>
					<?php require("searchform.php"); ?>
				</div>
</div>

<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" id="related-results" data-fix-rhs >
<div class="row">
	<?php
	if(isset($_GET['type']) || isset($_GET['max']) || isset($_GET['location'])){
		$related_results = $search->related_results(6);
	?>	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="contain remove-side-margin-xs">
			<div class="head f7-background">
				<h4 class="text-left">Related Results</h4>
			</div>
			<div class="body white-background remove-side-padding-xs">
				<?php
				if(count($related_results) == 0){
					?>
				<div class="padding-10 white-background text-center"> No related result </div>	
					<?php
				}
				else{
					$related_results_counter = 0;
					while($related_results_counter < count($related_results)){
						$related_property = new property($related_results[$related_results_counter]);
						$relation = "";
						if($related_property->type == $propertytype){
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\">Same type as your search</span>";
						}
						if($related_property->rent < $maxprice){
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\">Rent less than your search</span>";
						}
						else if($related_property->rent == $maxprice){
							$relation .= " Rent exactly what you searched for. ";
						}
						if($related_property->bath == $bath){
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\">$bath baths</span>";
						}				
						if($related_property->loo == $loo){
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\">$loo Toilets</span>";
						}
						if($related_property->tiles == 'Yes'){
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\"><span class=\"glyphicon glyphicon-ok\"></span>  Tiles</span>";
						}
						if($related_property->pmachine == 'Yes'){
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\"><span class=\"glyphicon glyphicon-ok\"></span>  Pumping Machine</span>";
						}
						if($related_property->borehole == 'Yes'){
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\"><span class=\"glyphicon glyphicon-ok\"></span>  Borehole</span>";
						}
							$relation .= "<span class=\"f7-background e3-border padding-5-10 margin-5 border-radius-5\">$related_property->city</span>";
						?>
				<div class="row e3-border-bottom margin-5-0">
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-4">
						<img src="<?php echo $related_property->display_photo_url() ?>" class="mini-property-image property-images size-100" <?php echo $related_property->image_attributes($popup = true) ?>/>
					</div>
					<div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
						<a  href="<?php echo "$root/properties/".$related_property->p_directory ?>" >
							<?php echo $related_property->type ?>
						</a>
						<p><span class="glyphicon glyphicon-map-marker"></span><?php echo $related_property->location ?> </p>
						 <p class="text-right">
							<span class=" opac-3-site-color-background site-colr padding-5-10 border-radius-5 bold" >N <?php echo number_format($related_property->rent) ?>/year</span>
						</p>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<p style="line-height:40px" class="grey font-12">  <?php echo $relation ?></p>
					</div>
				</div>	<?php
						unset($related_property);
						$related_results_counter++;
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

<?php
	}
}
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contact-search-help-container">
		<div class="text-center padding-10">
	<?php
	if($status == 0)	{
		?>
		 <a class="btn btn-primary btn-lg " href="../cta/request.php?p=1">Make a Request</a>
		 <?php
	}
	else if($status==9){
		?>
		 <a class="btn btn-primary btn-lg " href="../cta/request.php?p=1">Adjust Your Request</a>
		 <?php
	}
	?>
		 <p><b>Have any problem searching?</b> <a class="btn btn-primary site-color-background" href="">contact our help center</a></p>
	</div>
	</div>
</div>

 </div>
 
 </div>
 <?php   require('../resources/global/footer.php');?>
</div><!--body-content-->
</div><!--parent row-->
</div><!--container-fluid-->
</body>
</html>
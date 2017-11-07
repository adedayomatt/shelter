<div class="row">
<?php
$property = null;
$property_in_page_counter = 0;
$max = properties_config::$max_display;
$start = ((isset($_GET['next']) && $_GET['next'] > 0) ? $_GET['next'] : 0);
$x = $start;
$y= $x;
$total_found = $db->query_object($final_property_query)->num_rows;
$property = $db->query_object($final_property_query." LIMIT $start,$max");

if($property->num_rows == 0){
		?>
		<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-property">There are no records to show</div>
</div>
<?php		
	}
	else{
    //echo "Now we're good!";
    while($p = $property->fetch_array(MYSQLI_ASSOC)){
	require('set_property_variables.php');
	?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
<div class="propertybox-wrapper">
	<div id="<?php echo $propertyId ?>" class="row">

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 property-image-container">
	<div>
	<div class="text-center opac-white-background white absolute full-width padding-3 font-20" style="height:40px"> <?php echo $availability ?> </div>
	<img class="property-image" title="<?php echo "$type at $location" ?>" id="<?php echo  $propertyId.'image' ?>" onclick="animatePropertyImages('<?php echo  $propertyId.'image' ?>','<?php echo  $front_image ?>')"  src="<?php echo $front_image ?>"/>
	<div class="row bath-n-loo-container hidden-xs">
	<span class="col-lg-6 col-md-6 col-sm-6 col-xs-12 grey font-12"><?php echo  $bath ?> Bath(s) </span>
	<span class="col-lg-6 col-md-6 col-sm-6 col-xs-12 grey font-12"><?php echo  $toilet ?> Toilets(s) <span>
	</div>
	</div>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 details-container">
	<div>
		<div class="detail-heading">
		<div class="row">
		<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<a href="<?php echo $root.'/properties/'.$propertydir ?>" class="red font-30" ><?php echo $type.'  '.$match?></a>
	</span>
	</div>
	</div>

	<div class="row">
	<div title="<?php echo $location ?>" class="property-info property-address"><span class="glyphicon glyphicon-map-marker red"></span><?php echo $short_address ?></div>
	
	<div class="property-info"><span class="rent-figure">N <?php echo number_format($rent) ?></span></div>
	<div class="property-info"><span class="glyphicon glyphicon-exclamation-sign red"></span><strong><?php echo $min_payment ?></strong> payment required (N <?php echo $firstpayment ?>)</div>
	<div class="property-info"><span class="glyphicon glyphicon-time red"></span><?php echo $upload_since ?></div>
	<div class="property-info"><span class="glyphicon glyphicon-calendar red"></span><?php echo 'updated '.$lastReviewed ?></div>
<div class="property-info"><span class="glyphicon glyphicon-briefcase red"></span> 
	<a tabindex="0" role="link" data-toggle="popover" data-trigger="hover click" data-placement="top" data-html="true"  title="<h3><?php echo $agent_businessname ?></h3>"
	data-content="<div><span class='glyphicon glyphicon-map-marker site-color'></span><?php echo $agent_office_add ?><ul class='agent-contacts-list'><li><span class='glyphicon glyphicon-phone-alt site-color'></span><?php echo $agent_office_no ?></li><li><span class='glyphicon glyphicon-earphone site-color'></span><?php echo $agent_no ?></li><li><span class='glyphicon glyphicon-earphone site-color'></span><?php echo $agent_alt_no ?></li></ul><div><a href='<?php echo "$root/$agent_username" ?>' > Go to profile »</a><p>view profile to see other properties by <?php echo $agent_businessname ?></p></div></div>">
	<?php echo $agent_businessname ?></a>
	</div>	</div>

	
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="row">
	<?php 
	if($totalAvailableImage > 1){
		for($i=0; $i<$totalAvailableImage; ++$i){
			if($all_images[$i] == $front_image){
			continue;
		}
		if($i >=4){
			break;
		}
	?>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
	<img src="<?php echo $all_images[$i] ?>" class="other-property-images" />
	</div>
	<?php
	}
?>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 more-images text-center font-18">
	<span class="glyphicon glyphicon-picture"></span><br/><?php echo $totalAvailableImage ?> total images are available
	</div>
<?php
}
	else{
	?>
	
	<?php
	}
	?>
	</div>
	</div>
	
</div>
<div><?php echo $review ?></div>
<div class="row options-wrapper">
	<span class="col-lg-2 col-md-2 col-sm-2 col-xs-4 property-options" ><?php echo $clipbutton ?></span>
		<span class="col-lg-2 col-md-2 col-sm-2 col-xs-4 property-options" ><a  title="see full information about this <?php echo $type ?>"  href="<?php echo "$root/properties/$propertydir" ?>"><span class="glyphicon glyphicon-link"></span>Details</a></span>
		<span class="col-lg-2 col-md-2 col-sm-2 col-xs-4 property-options"><a title="this property have been viewed <?php echo $views ?> times" href="#"><span class="glyphicon glyphicon-eye-open"></span><?php echo $views ?></a></span>
</div>
</div>
</div>
<?php //close them brackets
$property_in_page_counter++;
	$y++;
if($property_in_page_counter==4){
	?>
<div class="row">
	<img class="ads" src="<?php echo $root.'/'.ads::$ad001 ?>" alt="AD"/>
	</div>
<?php
				}
if($property_in_page_counter==8){
	?>
<div class="row">
	<img class="ads" src="<?php echo $root.'/'.ads::$ad003 ?>" alt="AD"/>
	</div>
<?php
				}				

		}
	}

if($total_found > 0){
?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<p style="display:block">showing <?php echo ($x+1)." - $y of $total_found " ?></p>
<div class="next-prev-container">
<?php
//if there are other $GET[] contents or not
$regulate_url = (strpos($_SERVER['REQUEST_URI'],'&')==0 ? "?" :"&");

if($x > 0 ){
	$jumpTo = $y-2*$max;
	?>
<a class="previous" href ="<?php echo $_SERVER['REQUEST_URI'].$regulate_url.'next='.($jumpTo < 0 ? 0 : $jumpTo).$anchor ?>" >« prev</a>
<?php
	}

if($y < $total_found ){
	?>
	<a class="next" href ="<?php echo $_SERVER['REQUEST_URI'].$regulate_url.'next='.$y.$anchor ?>" >next »</a>
<?php
}	
?>
</div>
</div>
</div>

</div>
<?php
}	
	
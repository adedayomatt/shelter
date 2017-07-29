<?php
$property = null;
$property_in_page_counter = 1;
$property = $db->query_object($final_property_query);
if(is_string($property)){
	//echo $property;
    error::report_error($property,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
}
else{
	if($property->num_rows == 0){
		?>
<div class="no-proerty">There are no property to show</div>
<?php		
	}
	else{
    //echo "Now we're good!";
	$page = 'home_page';
    while($p = $property->fetch_array(MYSQLI_ASSOC)){
	require('set_property_variables.php');
	?>
	
	<div id="<?php echo $propertyId ?>" class="propertybox home-property-box">
	<div class="property-heading-container"><?php echo $review ?>
	<a href="<?php echo $root.'/properties/'.$propertydir ?>" class="property-heading" ><?php echo $type ?>
	<span class="match-indicator"><?php echo $match ?></span></a>
	<span class="status"> <?php echo $availability ?> </span>
	<span style="float:right"> </span>
	</div>
	
<div class="image-info">
	<span class="detail property-address"><span class="black-icon location-icon"></span><?php echo $short_address ?></span>
	<div id = "<?php echo  $propertyId.'container' ?>" class="home-imagebox">
	<img id="<?php echo  $propertyId.'image' ?>" onclick="animatePropertyImages('<?php echo  $propertyId.'image' ?>','<?php echo  $front_image ?>')" height="90%" width="100%" src="<?php echo $front_image ?>"/>
	<div id="bath-loo-wrapper"><span id="bath">(<?php echo  $bath ?>) Baths(s)</span><span id="loo">(<?php echo  $toilet ?>) Toilet(s)</span></div>
	</div>
	
	<div id="<?php echo $propertyId.'agent' ?>" class="agent-contacts-box" style="display:none">
	<span onclick="hideAgentBrief('<?php echo  $propertyId.'agent' ?>')" class="close">&times</span>
	
	<h4><?php echo $agent_businessname ?></h4>
	<span class="black-icon location-icon"></span><?php echo $agent_office_add ?>
	<ul>
	<li><?php echo $agent_office_no ?></li>
	<li><?php echo $agent_no ?></li>
	<li><?php echo $agent_alt_no ?></li>
	</ul>
	<div><a href="<?php echo "$root/$agent_username" ?>" > Go to profile »</a>
	<p>view profile to see other properties by <?php echo $agent_businessname ?></p>
	</div>
	</div>

	<div class="infobox">
	<div><span class="detail"><span class="rent-figure"> N <?php echo number_format($rent) ?>/year</span></span></div>
	<span class="detail home-min-payment-detail"><span class="black-icon min-payment-icon"></span><strong><?php echo $min_payment ?></strong> payment required (N <?php echo $firstpayment ?>)</span>
	
	
	<div class="home-description-container">
	<span class ="description detail"><span class="black-icon comment-icon"></span> Description: </span><div class="comment"><i><?php echo $description ?></i></div>
	</div>
	<span class="detail">Managed by <a onclick="showAgentBrief('<?php echo $propertyId.'agent' ?>')" class="agent-link" href="<?php echo "$root/$agent_username" ?>"><?php echo $agent_businessname ?></a></span>
	</div>
	
	<span class = "detail time" align="left"><span class="black-icon upload-icon"></span><?php echo $upload_since ?></span>
	<span class = "detail time" align="left"><span class="black-icon edit-icon"></span><?php echo $lastReviewed ?></span>
	</div>

	
	<div class="like-pane">
	    <hr/>
		<?php echo $clipbutton ?>
		<a  class="options-on-homepage" href="<?php echo "$root/properties/$propertydir" ?>"><span class="black-icon see-more-icon"></span>Details</a>
		<a  class="options-on-homepage" href="#"><span class="black-icon eye-icon"></span><?php echo $views ?> views</a>
		</div>
		</div>

<?php //close them brackets

			}
	}
	
}
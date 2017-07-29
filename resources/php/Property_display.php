<?php
$property = null;
$property_in_page_counter = 0;
$property = $db->query_object($final_property_query);
if(is_string($property)){
	//echo $property;
    error::report_error($property,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
}
else{
	if($property->num_rows == 0){
		?>
<div class="no-property">There are no property to show</div>
<?php		
	}
	else{
    //echo "Now we're good!";
	$page = 'home_page';
    while($p = $property->fetch_array(MYSQLI_ASSOC)){
	require('set_property_variables.php');
	?>
	
	<div id="<?php echo $propertyId ?>" class="propertybox">

	<div class="display-image-container">
		<div class="review-link-container">	<?php echo $review ?></div>
	<img id="<?php echo  $propertyId.'image' ?>" onclick="animatePropertyImages('<?php echo  $propertyId.'image' ?>','<?php echo  $front_image ?>')"  src="<?php echo $front_image ?>"/>
	<div class="bath-n-loo-container"><span id="bath"><?php echo  $bath ?> Bath(s) </span>
	<span id="loo"><?php echo  $toilet ?> Toilets(s) <span></div>
	</div>

	<div class="details-container">
		<div class="detail-heading">
	<a href="<?php echo $root.'/properties/'.$propertydir ?>" class="heading-link" ><?php echo $type ?></a>
	<span class="status-indicator"> <?php echo $availability ?> </span>
	<span class="match-indicator"><?php echo $match ?></span>
	</div>


	<div class="detail-summary">
	<div class="property-info property-address"><span class="black-icon location-icon"></span><?php echo $short_address ?></div>

<?php /***********This is the hidden agent details************************/?>
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
<?php/******************************************************************************************/?>
	
	<div class="property-info"><span class="rent-figure"> N <?php echo number_format($rent) ?>/year</span></div>
	<div class="property-info"><span class="black-icon min-payment-icon"></span><strong><?php echo $min_payment ?></strong> payment required (N <?php echo $firstpayment ?>)</div>
	<div class="property-info time" align="left"><span class="black-icon upload-icon"></span><?php echo $upload_since ?></div>
	<div class="property-info">Managed by <a onclick="showAgentBrief('<?php echo $propertyId.'agent' ?>')" class="agent-link" href="<?php echo "$root/$agent_username" ?>"><?php echo $agent_businessname ?></a></div>
	</div>


<div class="property-options-container">
	<?php echo $clipbutton ?>
		<a  class="options" href="<?php echo "$root/properties/$propertydir" ?>"><span class="black-icon see-more-icon"></span>More Details</a>
		<a  class="options" href="#"><span class="black-icon eye-icon"></span><?php echo $views ?></a>
</div>



</div>
</div>


<?php //close them brackets
$property_in_page_counter++;
if($property_in_page_counter==4){
	?>
<div class="in-between-advert"><img style="display:block" src"" alt="AD" width="100%" height="100%"/></div>
<?php
				}
			}
		}
	
	}
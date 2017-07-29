<div class="details-wrapper">
<?php
	$getdetails = $db->query_object("SELECT * FROM properties INNER JOIN profiles ON (properties.uploadby = profiles.User_ID) WHERE (property_ID='".$ID."')");
	if(is_string($getdetails)){
error::report_error($getdetails,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
	} 
	else{
	if($getdetails->num_rows==1){
$detail = $getdetails->fetch_array(MYSQLI_ASSOC);
$id =  $detail['property_ID'];
$dir = $detail['directory'];
$type = $detail['type'];
$location =$detail['location'];
$rent = $detail['rent'];
$min_payment = $detail['min_payment'];
$bath = $detail['bath'];
$loo = $detail['toilet'];
$pmachine = $detail['pumping_machine'];
$borehole = $detail['borehole'];
$well = $detail['well'];
$tiles = $detail['tiles'];
$pspace = $detail['parking_space'];
$electricity = $detail['electricity'];
$road = $detail['road'];
$social = $detail['socialization'];
$security = $detail['security'];
$description = $detail['description'];
$date = $detail['date_uploaded'];
$managerId = $detail['uploadby'];
$views = $detail['views'];	
$lastReviewed = $detail['last_reviewed'];	

$BN = $detail['Business_Name'];
$add = $detail['Office_Address'];
$OTel = $detail['Office_Tel_No'];
$Bmail = $detail['Business_email'];
$PTel = $detail['Phone_No'];
$agentId = $detail['User_ID'];
$agent_token = $detail['token'];
		
	}
	else{
		?>
<br/><br/><div class="no-property">No property with the ID <b>".<?php echo $ID ?>."</b>. It may have been deleted or banned.<br/>If you think this is an error, please  <a href="">Report Now</a></div>
		<?php
		$general->halt_page();
	}
}	

function statusIcon($facility){
	switch($facility){
		case "Yes":
		return "background-position:-288px 0px";
		break;
		case "No":
		return "background-position: -312px 0px";
		break;
		default:
		return "background-position: -312px 0px";
		break;
		}
	}
?>

<div>
<?php 
if(($status ==1) && ($BN == $Business_Name)){
$reviewLink = "<a href=\"$root/manage/property.php?id=$ID&action=change&agent=$agent_token\"><span title=\"edit property\" style=\"display:inline-block;padding:5px; border:1px solid #e3e3e3; background-color:#F7F7F7;margin-right:2%\"><span class=\"black-icon edit-icon\"></span></span></a>";
$clip_button = "";
}
else{
	$reviewLink = "";
	$clip_button = "<span style=\"padding:2px 20px 2px 0px; border:1px solid #E3E3E3; border-radius:3px;margin-left:10%\">". ($status==9 ? $property_obj->clip($ID,$ctaid,'detail_page') :'')."</span>";

}
?>
<div id="property-head">
<p style="color:purple;font-size:150%;"> <?php echo $reviewLink.$type.$clip_button ?> </p>
<p style="color:grey;"><?php $ID ?></p>
<p><span class="black-icon location-icon"></span><?php echo $location ?></p>
</div>
</div>

<?php  

$all_images = $general->get_images("../$dir");
$total_images = count($all_images);
?>

<div id="image-tray">
	<h4 class="container-headers">PHOTOS</h4>
<p class="about-section">Photos added by the agent managing this property. It allows client to have an idea of different corners of the property before inspection</p>

<div class="container-inside" id="photos-container">
<?php
if($total_images == 0){
	echo $dir;
	?>
<p style="color:red;text-align:center"><span class="black-icon camera-icon"></span>No photo is available for this property</div>
<?php
}
else{
	foreach($all_images as $photo){
		?>
<div class="photo-container">
<img alt="Not Available" class="property-photo" src="<?php echo $photo ?>"/>
</div>
<?php
	}
}
?>
</div>
</div>

<div>
<p><span class="black-icon eye-icon"></span>Total views: <?php  if($status==1){echo (@$Business_Name == $BN ? $views : $views+1);}else{ echo $views+1;} ?></p>
<p><span class="black-icon edit-icon"></span><?php echo" Last reviewed:  ".($general->since($lastReviewed) == "invalid time" ? "<span style=\"color:red\">Not reviewed yet</span>" : $general->since($lastReviewed)) ?></p>
</div>

<div id="all-details-boxes-container">

<div id="info-container">
<h4 class=" container-headers">INFO</h4>
<p class="about-section">Basic information about this property</p>
<div class="container-inside" id="info">
<ul class="no-padding-ul">
<li class="info-list">Category:N/A</li>
<li class="info-list">Property type: <?php echo $type ?></li>
<div>
<span class="esss" id="rent">Rent: N <?php echo number_format($rent)?></span>
</div>
<li  class="info-list" id="min-pay">Minimum Payment Required: <?php echo $min_payment ?></li>
<li class="info-list">Uploaded on: <?php echo $date ?></li>
</ul>
</div>
</div>

<div id="facilities-container">
<h4 class="container-headers">FACILITIES</h4>
<p class="about-section">Facilities in this property</p>
<div class="container-inside" id="facilities-box">
	
<div>
<span class="esss">(<?php echo $bath ?>)Bathroom(s)</span>
<span class="esss">(<?php echo $loo ?>)Toilet(s)</span>
</div>

<ul class="facilities">
<li class="facilities-list"><span style="<?php echo statusIcon($pmachine)?>" class="black-icon"></span>  Pumping machine</li>
<li class="facilities-list"><span style="<?php echo statusIcon($borehole)?>" class="black-icon"></span>  Borehole</li>
<li class="facilities-list"><span style="<?php echo statusIcon($well)?>" class="black-icon"></span>  Well</li>
<li class="facilities-list"><td><span style="<?php echo statusIcon($tiles)?>" class="black-icon"></span>  Tiles</li>
<li class="facilities-list"><span style="<?php echo statusIcon($pspace)?>" class="black-icon"></span>  Parking space</li>
</ul>
<h4 id="descr">Property description by Agent</h4>
<?php
echo "<div style=\"background-color:white; height:100px; color:blue; padding:2%; width:70%; margin:auto; border:1px solid #e3e3e3;\">".(empty($description) ? "<div style=\"text-align:center; color:red\"><span class=\"black-icon warning-icon\"></span>No Description</div>" :"$description")."</div>";
	?>
</div>
</div>

<div id="rating-container">
<h4 class="container-headers">RATING</h4>
<p class="about-section">According to the agent in charge of this property (<?php echo $BN ?>), this property has been rated on percentage</p>

<!--The bars begin here-->
<div class="container-inside"> 
<div  id="bars-box">

<div class="bar-container">
<div  class="rating-bar" id="electricity-bar">
<div style="<?php echo "width: ".$electricity."%" ?>" class="wiped" id="electricity-wiped">
</div>
</div>
<p class="bar-label">Electricity - <?php echo ($electricity != 0 ? $electricity." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>

<div class="bar-container">
<div class="rating-bar" id="road-bar">
<div style="<?php echo "width: ".$road."%" ?>" class="wiped" id="road-wiped">
</div>
</div>
<p class="bar-label">Road - <?php echo ($road != 0 ? $road." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>

<div class="bar-container">
<div class="rating-bar" id="security-bar">
<div style="<?php echo "width: ".$security."%" ?>" class="wiped" id="security-wiped">
</div>
</div>
<p class="bar-label">Security - <?php echo ($security != 0 ? $security." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>

<div class="bar-container">
<div class="rating-bar" id="social-bar">
<div style="<?php echo "width: ".$social."%" ?>" class="wiped" id="social-wiped">
</div>
</div>
<p class="bar-label">Socialization - <?php echo ($social != 0 ? $social." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>
</div>
</div>
<!--The bars end here-->
<div id="rating-disclaimer-container">
<h2 id="rating-disclaimer-head">DISCLAIMER<span style="font-size:200%; color:yellow">!</span></h2>
<p>This rating is according to the agent that uploaded this property, any alteration in the reality of this property is however not Shelter.com responsibility</p>
</div>
</div>

<div style="" id="agent-info-container">
<h4  class="container-headers">AGENT</h4>
<p class="about-section">Interested in this property and want to inspect it, these are the contacts of the agent in charge</p>

<div class="container-inside" id="agent-contacts">
<ul class="no-padding-ul">
<li class="contact-list"><span id="address-icon"></span>Office Address: <?php echo $add ?> </li>
<li class="contact-list"><span id="phone-icon"></span>Phone No: <?php echo "0".$PTel ?> </li>
<li class="contact-list"><span id="phone-icon"></span>Alt. Phone No: <?php echo "0".$OTel ?> </li>
<li class="contact-list"><span id="mail-icon"></span> E-mail: <?php echo $Bmail ?> </li>
</ul>
<?php echo "<a class=\"skyblue-inline-block-link\" href=\"../../$agentId\">See other properties by $BN</a>" ?>
</div>
</div>

</div>
</div>

<div class="">
<div class="other-properties">
<div id="see-also-container">
<h4 class="container-headers">See Also...</h4>
<p>We thought you might want to see this related properties too</p>
<?php 
$get_related_properties = $db->query_object("SELECT * FROM properties WHERE ((property_ID !='$ID') AND (type = '$type' OR location LIKE '%$location%')) LIMIT 12");
if(is_object($get_related_properties)){
	if($get_related_properties->num_rows > 0){
		while($property = $get_related_properties->fetch_array(MYSQLI_ASSOC)){
		$R_id = $property['property_ID'];
		$R_dir = $property['directory'];
		$R_type = $property['type'];
		$R_rent = number_format($property['rent']);
		$R_MP = $property['min_payment'];
		$R_location = $property['location'];

$related_property_images = $general->get_images($R_dir);
if(count($related_property_images) != 0){
	$R_image = $related_property_images[0];
}
else{
	$R_image = 'default.png';
}
?>
<div class="related-property">
<img src="<?php $R_image ?>" class="related-property-image"/>
<div class="related-property-info">
<a href="<?php echo  "$root/properties/$R_dir" ?>"><?php echo "$R_type at $R_location" ?></a>
 <ul class="no-padding-ul">
 <li>Rent: <?php echo $R_rent ?> /year</li>
 <li>Payment required: <?php echo  $R_MP ?></li>
 </ul>
 </div>
</div>
<?php
			
		}
	}
else{
?>
<div style="text-align:center; padding: 2%; background-color: white; color:red;">There is no related property</div>
<?php
	}
}
?>
<div>
 <a class="skyblue-inline-block-link" href="../../search">search for property</a>
 <a class="next skyblue-block-link" href="../../search">see more »</a>
</div>
<div>
<h4 align="center">DID YOU KNOW?</h4>
<p>You can get alert on your phone and/email on any property that you want? All you need to do is <a href="../../cta/checkin.php">create a Client Temporary Account (CTA)</a></p>
</div>
</div>
<div id="agents-container">
<p>These agents also have this kind of properties</p>
<?php
$other_agent_query = "SELECT profiles.Business_Name AS agent_bn, profiles.User_ID AS agent_un 
						FROM properties INNER JOIN profiles 
						ON (properties.uploadby = profiles.User_ID) 
						WHERE (properties.type='$type' AND profiles.Business_Name != '$BN')";
$get_other_agents = $db->query_object($other_agent_query);
if(is_string($get_other_agents)){
	error::report_error($get_other_agents,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
}else{
	if($get_other_agents->num_rows==0){
		?>
		<p style="color:red">There is no other agent with this kind of properties</p>
		<?php
	}
	else{
	?>
	<ul>
<?php
		while ($a = $get_other_agents->fetch_array(MYSQLI_ASSOC)){
			?>
<li><a href="<?php echo "$root/".$a['agent_un'] ?>"><?php echo $a['agent_bn'] ?></a></li>
	<?php
		}
		?>
</u>
<?php
	}
}
?>
<hr/>
<div style="line-height:200%; text-align:center">
<h1>STILL IN PROGRESS</h1>
<div style="height:50px; width:100%;background: white url('http://192.168.173.1/shelter/resrc/gifs/progress-bar.gif') center no-repeat"></div>
</div>
</div>
</div>
</div>

<div style="margin-top:355px">
<?php  
//
//update number of views

if($status==1 && $Business_Name == $BN){
	$update_view = false;
}
else{
$newviews = $views + 1;
$db->query_object("UPDATE properties SET views=$newviews WHERE (property_ID='$id')");
}

require('../../resources/php/footer.php');
?>
</div>
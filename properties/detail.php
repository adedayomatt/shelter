
<?php
$ref="detail_page";
	$getdetails = $db->query_object("SELECT properties.*,profiles.*,properties.timestamp AS propertyTimestamp FROM properties INNER JOIN profiles ON (properties.uploadby = profiles.User_ID) WHERE (property_ID='".$ID."')");
	if(is_string($getdetails)){
error::report_error($getdetails,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
$property_display = false;
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
$uploadTimestamp = $detail['propertyTimestamp'];
$managerId = $detail['uploadby'];
$views = $detail['views'];	
$lastReviewed = $detail['last_reviewed'];
$avail = $detail['status'];	

$BN = $detail['Business_Name'];
$add = $detail['Office_Address'];
$OTel = $detail['Office_Tel_No'];
$Bmail = $detail['Business_email'];
$PTel = $detail['Phone_No'];
$agentId = $detail['User_ID'];
$agent_token = $detail['token'];
	
	if(($status ==1) && ($BN == $Business_Name)){
$reviewLink = "<a class=\"btn btn-default\" href=\"$root/manage/property.php?id=$ID&action=change&agent=$agent_token\"><span title=\"edit property\"><span class=\"glyphicon glyphicon-edit\"></span> review</span></a>";
$clip_button = "";
}
else{
	$reviewLink = "";
	$clip_button = ($status==9 ? $property_obj->clip($ID,$ctaid,$ref,$client_token): $clipbutton = $property_obj->clip($ID,null,$ref,null));

}
	
	
$property_display = true;
$showStaticHeader = true;
$staticHead = "<div class=\"row static-head-primary\">
<div class=\"col-lg-8 col-md-8 col-sm-8 col-xs-8\" id=\"main-staticHead\">
<div class=\"row\" style=\"padding:0px 10px\">
<span class=\"col-lg-8 col-md-8 col-sm-8 col-xs-7 text-left\">
<span style=\"height:50px\">
<span><img src=\"".$property_obj->get_property_dp('../'.$dir,$detail['display_photo'])."\" style=\"width:60px;height:50px;vertical-align:text-bottom\"/></span>
<span class=\"font-16 bold\">$type</span>
</span>
</span>
<span class=\"col-lg-2 col-md-2 col-sm-2 col-xs-5 text-center\"> $clip_button </span>
<span class=\"col-lg-2 col-md-2 col-sm-2 col-xs-5 text-center\"> $reviewLink </span>
<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left\">
<p class=\"grey\"><span class=\"glyphicon glyphicon-map-marker\" style=\"color:#20435C\"></span>".$general->substring($location,'xyz',20)."</p>
</span>
</div>
</div>

<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-4\">
<div class=\"temporary-popup\" id=\"tap-instruction\">
	<p>Tap on the image to see full size</p>
</div>

</div>
</div>
";	
	}
	else{
$property_display = false;	
$onPageLoadPopup = "No property with the ID <b>$ID</b>. It may have been deleted or banned.<br/>If you think this is an error, please  <a>Report Now</a>";
	//hide the nav bar?>
	<style>nav{display:none}</style>
	<?php
	}
	}
require('../../resources/global/header.php');
	
	if($property_display == false){
		$general->halt_page();
	}
?>
<script>
	function popFullImageSize(imagesrc){
	var	image = "<img src=\""+imagesrc+"\" width=\"100%\" height=\"auto\" />";
showPopup();
popUpContent().innerHTML = image;
	}
	</script>

<style>
div#details-body{
	padding:0px 20px;
}
	div#tap-instruction{
background-color:rgba(0,0,0,0.5);
color:white;
text-align:center;
padding:5px;
border-radius:5px;
	}
.wiped{
	width:100%;
	height:100%;
	background-color:green;
}

</style>

<div class="container-fluid  body-content">

<?php	

function statusIcon($facility){
	switch($facility){
		case "Yes":
		return "glyphicon glyphicon-ok green";
		break;
		case "No":
		return "glyphicon glyphicon-remove red";
		break;
		default:
		return "glyphicon glyphicon-remove red";
		break;
		}
	}
?>

<?php 
$property_status = "<span style=\"color:white; background-color:black;font-weight:bold;letter-spacing:2px;padding:10px 20px 10px 20px;margin-left:10%;border-radius:3px\">$avail</span>"
?>

<div class="row head-tray">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left" style="font-size:200%;"><?php echo $type ?> </span>
</div>

<div class="row">
<span class="col-lg-3 col-md-3 col-sm-6 col-xs-6" style="color:grey;"><?php echo $ID ?> </span>
<span class="col-lg-3 col-md-3 col-sm-6 col-xs-6"><?php echo $property_status ?></span>
</div>

<p><span class="glyphicon glyphicon-map-marker site-color"></span><?php echo $location ?></p>
<div class="row">
<span class="col-lg-1 col-lg-offset-11 col-md-1 col-md-offset-11  col-sm-2 col-sm-offset-10 col-xs-4 col-xs-offset-8" ><?php echo $reviewLink ?> </span>
</div>
</div>

</div>


<?php  

$all_images = $general->get_images("../$dir");
$total_images = count($all_images);
?>
<div id="details-body">

<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 images-container padding-10">
<h4 class="container-headers red"><span class="glyphicon glyphicon-picture"></span>PHOTOS</h4>
<p class="about-section text-center">Photos added by the agent managing this property. It allows client to have an idea of different corners of the property before inspection</p>


<?php
if($total_images == 0){
	?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<p class="text-center red"><span class="glyphicon glyphicon-picture"></span>No photo is available for this property</p>
</div>
<?php
}
else{
	foreach($all_images as $photo){
		?>	
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<img alt="Not Available" class="property-images" src="<?php echo $photo ?>" onclick="javascript: popFullImageSize('<?php echo $photo?>')"/>
</div>
<?php
	}
}
?>

</div>
</div>

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
<div class="row misc-tray">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="container-inside">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
<span class="glyphicon glyphicon-eye-open"></span></span>Total views: <?php  if($status==1){echo (@$Business_Name == $BN ? $views : $views+1);}else{ echo $views+1;} ?>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
<span class="glyphicon glyphicon-pencil"></span></span><?php echo" Last Updated:  ".($general->since($lastReviewed) == "invalid time" ? "<span style=\"color:red\">Not reviewed yet</span>" : $general->since($lastReviewed)) ?>
</div>
</div>
</div>
</div>
</div>

<div class="row all-details-tray">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 basic-info-container">
<h4 class="container-headers red"><span class="glyphicon glyphicon-list-alt"></span>INFO</h4>
<p class="about-section text-center">Basic information about this property</p>

<div class="container-inside" id="info">
<div class="row">
<span class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center detail-list-important" id="rent">Rent: N <?php echo number_format($rent)?></span>
<span class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center detail-list-important">Category:N/A</span>
<span class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center detail-list-important">Property type: <?php echo $type ?></span>
<span class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-center detail-list-important">Minimum Payment Required: <?php echo $min_payment ?></span>
</div>
<p><span class="glyphicon glyphicon-upload"></span>Uploaded: <?php echo $general->since($uploadTimestamp) ?></p>
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 facilities-container">
<h4 class="container-headers red"><span class="glyphicon glyphicon-bed"></span>  FACILITIES</h4>
<p class="about-section">Facilities in this property</p>
<div class="container-inside" id="facilities-box">	
<div class="row">
<div class="row">
<span class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center detail-list">(<?php echo $bath ?>)Bathroom(s)</span>
<span class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center detail-list">(<?php echo $loo ?>)Toilet(s)</span>
</div>

<div class="row e3-border padding-5">
<h4><span class="glyphicon glyphicon-tint site-color"></span>  Water Supply</h4>
<hr class="grey" />
<span class="col-lg-3 col-md-3 col-sm-4 col-xs-6 text-center facilities-list"><span class="<?php echo statusIcon($borehole)?>"></span>  Borehole</span>
<span class="col-lg-3 col-md-3 col-sm-4 col-xs-6 text-center facilities-list"><span class="<?php echo statusIcon($well)?>"></span>  Well</span>
<span class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-center facilities-list"><span class="<?php echo statusIcon($pmachine)?>"></span>  Pumping machine</span>

</div>

<span class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center facilities-list"><td><span class="<?php echo statusIcon($tiles)?>"></span>  Tiles</span>
<span class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center facilities-list"><span class="<?php echo statusIcon($pspace)?>"></span>  Parking space</span>
</div>

<h4 class="text-center site-color">Property description by Agent</h4>
<div id="description-container">
<?php
echo (empty($description) ? "<div style=\"text-align:center; color:red\"><span class=\"glyphicon glyphicon-alert\"></span>No Description</div>" :"$description");
	?>
</div>
	
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rating-container">
<h4 class="container-headers red"><span class="glyphicon glyphicon-stats"></span>RATING</h4>
<p class="about-section text-center">According to the agent in charge of this property (<?php echo $BN ?>), this property has been rated on percentage</p>
<!--The bars begin here-->
<div class="container-inside"> 
<div  id="bars-box">

<div class="bar-container e3-border margin-5 padding-5">
<div  class="rating-bar" id="electricity-bar">
<div style="<?php echo "width: ".$electricity."%" ?>" class="wiped" id="electricity-wiped"></div>
</div>
<p class="bar-label text-left"><span class="glyphicon glyphicon-adjust site-color"></span>Electricity - <?php echo ($electricity != 0 ? $electricity." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>

<div class="bar-container e3-border margin-5 padding-5">
<div class="rating-bar" id="road-bar">
<div style="<?php echo "width: ".$road."%" ?>" class="wiped" id="road-wiped">
</div>
</div>
<p class="bar-label text-left"><span class="glyphicon glyphicon-road site-color"></span>Road - <?php echo ($road != 0 ? $road." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>

<div class="bar-container e3-border margin-5 padding-5">
<div class="rating-bar" id="security-bar">
<div style="<?php echo "width: ".$security."%" ?>" class="wiped" id="security-wiped">
</div>
</div>
<p class="bar-label text-left"><span class="glyphicon glyphicon-lock site-color"></span>Security - <?php echo ($security != 0 ? $security." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>

<div class="bar-container e3-border margin-5 padding-5">
<div class="rating-bar" id="social-bar">
<div style="<?php echo "width: ".$social."%" ?>" class="wiped" id="social-wiped">
</div>
</div>
<p class="bar-label text-left"><span class="glyphicon glyphicon-tent site-color"></span>Socialization - <?php echo ($social != 0 ? $social." %" : "<span class=\"not-rated\">Not rated</span>" ) ?></p>
</div>
</div>
</div>
<!--The bars end here-->
 
<div class="rating-disclaimer-container padding-5 text-center">
<h2 id="rating-disclaimer-head">DISCLAIMER<span style="font-size:200%; color:purple">!</span></h2>
<p>This rating is according to the agent that uploaded this property, any alteration in the reality of this property is however not Shelter.com responsibility</p>
</div>

</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ad-container">
<img src="<?php echo '../../'.ads::$ad004 ?>" class="ads"/>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 agent-info-container">
<h4 class="container-headers red"><span class="glyphicon glyphicon-briefcase"></span>  AGENT</h4>
<p class="about-section text-center">Interested in this property and want to inspect it, these are the contacts of the agent in charge</p>

<div class="container-inside" id="agent-contacts">
<ul class="no-padding-ul">
<li class="contact-list"><span class="glyphicon glyphicon-map-marker site-color"></span> <?php echo $add ?> </li>
<li class="contact-list"><span class="glyphicon glyphicon-earphone site-color"></span> <?php echo "0".$PTel ?> </li>
<li class="contact-list"><span class="glyphicon glyphicon-earphone site-color"></span> <?php echo "0".$OTel ?> </li>
<li class="contact-list"><span class="site-color" style="font-weight:bold">@</span> <?php echo $Bmail ?> </li>
</ul>
<?php echo "<a class=\"\" href=\"../../$agentId\">See other properties by $BN</a>" ?>
</div>
</div>

</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ad-container">
<h4 class="text-center">DID YOU KNOW?</h4>
<p>You can get alert on your phone and/email on any property that you want? All you need to do is <a href="../../cta/checkin.php">create a Client Temporary Account (CTA)</a></p>
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 related-property-container">
<h4 class="container-headers">Related Properties</h4>
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
		$R_dp = $property['display_photo'];

?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 related-property">
<div class="margin-5 e3-border">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0px">
<img src="<?php echo $property_obj->get_property_dp('../'.$R_dir,$R_dp ) ?>" width="100%" height="100px" class="related-property-image"/>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<span class="related-property-detail"><a href="<?php echo  "$root/properties/$R_dir" ?>"><?php echo $general->substring("$R_type at $R_location",'abc',25) ?></a></span>
 <span class="related-property-detail">Rent: <?php echo $R_rent ?> /year</span>
 <span class="related-property-detail">Payment required: <?php echo  $R_MP ?></span>
 </div>
 </div>
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


<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 <a  href="../../search">search for property</a>
 <a href="../../search">see more »</a>
</div>
</div>


</div>

</div>
</div>


<div style="margin-top:35px">
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

require('../../resources/global/footer.php');
?>
<script>
$('.clip-button,.unclip-button').addClass('btn btn-default');
</script>
</div>
</div>



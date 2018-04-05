<style>
.body-content{
	paddding-top:50px;
}
.rating-bar>div{
		height:25px;

}
.this-property-image{
	margin:2px;
}
.this-property-image>img.property-images{
	width:100%;
}

@media all and (min-width:768px),(min-device-width: 768px){
	.this-property-image.biggest,.biggest>.property-images{
	height:500px;
}
.this-property-image.bigger,.bigger>.property-images{
	height:250px;
}
.this-property-image.big,.big>img.property-images{
	height:167px;
}
.this-property-image.small,.small>img.property-images{
	height:125px;
}
}


@media all and (max-width: 768px),(max-device-width:768px){
	.this-property-image.biggest,.biggest>img.property-images{
	height:300px;
}
.this-property-image.bigger,.bigger>img.property-images{
	height:150px;
}
.this-property-image.big,.big>img.property-images{
	height:100px;
}
.this-property-image.small,.small>img.property-images{
	height:75px;
}

}
</style>
<?php

$ref="detail_page";
$property = new property($ID);
if(!$property->property_exist()){
	?>
	<div class="center-content">
	<div class="contain">
	<div class="head f7-background">
	<h1>Invalid Property ID</h1>
	</div>
	<div class="body white-background">
	<p class="text-center">
	No property with the ID <b><?php echo $ID ?> </b>. It may have been deleted or blocked.<br/>If you think this is an error, please  Report Now";
	<br/><a class="btn btn-lg btn-primary">Report</a>
	</p>
	</div>
	</div>
	</div>
<?php
$tool->halt_page();
}
else{
$id =  $property->id;
$dir = $property->p_directory;
$type = $property->type;
$area = $property->area;
$city = $property->city;
$location = $property->location;
$rent = $property->rent;
$min_payment = $property->min_payment;
$bath = $property->bath;
$loo = $property->loo;
$pmachine = $property->pmachine;
$borehole = $property->borehole;
$well = $property->well;
$tiles = $property->tiles;
$pspace = $property->parking_space;
$electricity = $property->electricity;
$road = $property->road;
$social = $property->social;
$security = $property->security;
$description =$property->description;
$uploadTimestamp = $property->upload_timestamp;
$views = $property->views;	
$lastReviewed = $property->last_reviewed;
$avail = $property->status;	
$display_photo = $property->display_photo;
$clips = $property->clips();

$agent_business_name = $property->agent_business_name;
$agent_username = $property->agent_username;
$agent_office_address = $property->agent_address;
$agent_office_contact = $property->agent_office_contact;
$agent_business_mail = $property->agent_business_mail;
$agent_contact1 = $property->agent_contact1;
$agent_contact2 = $property->agent_contact2;
$agent_token = $property->agent_token;
	
	if(($status ==1) && ($agent_business_name == $loggedIn_agent->business_name)){
$updateLink = "<a class=\"btn btn-default\" href=\"$root/manage/property.php?id=$ID&action=change&agent=$agent_token\"><span title=\"edit property\"><span class=\"glyphicon glyphicon-edit\"></span> update</span></a>";
$clip_button = "";
}
else{
	$updateLink = "";
	if($status == 9){
		$clip_button = $property->clip_button($loggedIn_client->id,$loggedIn_client->token,$ref);
	}else{
		$clip_button = $property->clip_button(null,null,$ref);
	}
}
	
$property_status = "<span style=\"color:white; background-color:black;font-weight:bold;letter-spacing:2px;padding:10px 20px 10px 20px;margin-left:10%;border-radius:3px\">$avail</span>";
		
	}
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
require('../../resources/global/header.php');

?>
<div class="container-fluid">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="contain remove-side-margin-xs" >
<div class="head f7-background ">
<div class="text-left">
<img src="<?php echo $property->display_photo_url() ?>" style="vertical-align:text-bottom" class="mini-property-image size-50">
<span class="text-left site-color font-20"><?php echo $type ?></span>
</div>
</div>

<div class="body  white-background text-center" >
<div class="row">

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="contain remove-side-margin-xs">
<div class="head f7-background">
<h4>PID: <?php echo $ID ?> </h4>
</div>
<div class="body text-left">
<div class="padding-5"><span class="glyphicon glyphicon-map-marker site-color"></span><?php echo $location ?></div>
<div class="padding-5">Property type: <?php echo $type ?></div>
<div class="padding-5">Category: N/A</div>
<div class="padding-5">Rent:  N <?php echo number_format($rent)?></div>
<div class="padding-5">Minimum Payment Required: <?php echo $min_payment ?></div>
<div class="padding-10">Property Status: <?php echo $property_status ?></div>
</div>
</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >
<div class="contain remove-side-margin-xs">
<div class="head f7-background">
<h4>Property Stats</h4>
</div>
<div class="body text-left">
<ul class="paddding-0" style="list-style-type:none">
<li class="paddding-5">
<span class="glyphicon glyphicon-eye-open"></span>Total views: <?php  if($status==1){echo ($loggedIn_agent->business_name == $agent_business_name ? $views : $views+1);}else{ echo $views+1;} ?>
</li>
<li class="paddding-5">
<span class="glyphicon glyphicon-upload"></span><?php echo" Uploaded:  ".($tool->since($uploadTimestamp) == "invalid time" ? "<span style=\"color:red\">Not updateed yet</span>" : $tool->since($uploadTimestamp)) ?>
</li>
<li class="paddding-5">
<span class="glyphicon glyphicon-edit"></span><?php echo" Last Updated:  ".($tool->since($lastReviewed) == "invalid time" ? "<span style=\"color:red\">Not updateed yet</span>" : $tool->since($lastReviewed)) ?>
</li>
<li class="paddding-5">
<span class="glyphicon glyphicon-paperclip"></span>clipped by <?php echo $clips ?> client<?php  ?>
</li>
</ul>
</div>
</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="contain">
<div class="head f7-background">
<h4>This Property</h4>
</div>
<div class="body">
<div class="text-center"><?php echo $clip_button ?></div>
<div class="text-center"><?php echo $updateLink ?></div>
</div>
</div>
</div>

</div>
</div>
</div>

</div>

</div>


<?php  

$all_images = $tool->get_images($tool->relative_url()."properties/$dir");
$total_images = count($all_images);
?>

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">

<div class="contain remove-side-margin-xs">
<div class="head f7-background">
<h2 class="text-left" >Photos</h2>
<p class="text-left" >Photos added by the agent managing this property. It allows client to have an idea of different corners of the property before inspection</p>
</div>
<div class="body white-background">
<?php
if($total_images == 0){
	?>
	
<div class="operation-report-container fail" >
<span class="glyphicon glyphicon-picture"></span>No photo is available for this property
</div>

<div class="visible-lg visible-md hidden-sm hidden-xs">
<div data-loading-content="loading" style="height:500px; vertical-align:middle">
<h1 class="text-center"style="vertical-align:middle">No photos to display!</h1>
</div>
	</div>

<?php
}
else{
	$dp = $property->display_photo_url();
?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="this-property-image biggest">
<img class="property-images"  src="<?php echo $property->display_photo_url() ?>" <?php echo $property->image_attributes($popup = true) ?> />
</div>
</div>
<?php

class imageBlock{
	private $total = 0;
	
 function __construct($totalImages){
		$this->total = $totalImages;
		}
		
function imageClass($count){
$total = $this->total;

	if($total == 1){
 return $this->one();
	}
	
else if($total == 2){
 return $this->two();
	}
else if($total == 3){
 return $this->three();
	}
else {
	
//Formation 3,4,2
if($total%9 == 0){
 $c = $count%10;
	if($c <= 3 ){
		return $this->three();
	}
	else if($c > 3 && $c <= 7){
		return $this->four();
	}
	else if($c > 7 && $c <= 8){
		return $this->two();
	}
}

//Formation 4,2,2
else if($total%8 == 0){
 $c = $count%9;
	if($c <= 4){
		return $this->four();
	}
	else if($c > 4 && $c <= 6){
		return $this->two();
	}
	else if($c > 6 && $c <= 8){
		return $this->two();
	}
}

//Formation 2,3,2
else if($total%7 == 0){
 $c = $count%8;
	if($c <= 2){
		return $this->two();
	}
	else if($c > 2 && $c <= 5){
		return $this->three();
	}
	else if($c > 5 && $c <= 7){
		return $this->two();
	}
}

//Formation 3,3
else if($total%6 == 0){
 $c = $count%7;
	if($c <= 3){
		return $this->three();
	}
	else if($c > 3 && $c <= 4){
		return $this->three();
	}
	
}
	
//Formation 3,2
else if($total%5 == 0){
 $c = $count%6;
	if($c <= 3){
		return $this->three();
	}
	else if($c > 3 && $c <= 5){
		return $this->two();
	}
}

//Formation 2,2
else if($total%4 == 0){
 $c = $count%6;
	if($c <= 2){
		return $this->two();
	}
	else if($c > 3 && $c <= 4){
		return $this->two();
	}
}
else if($this->isTotalImageOdd()){//if the total is odd like 11,17,..., first return a 3,4 formation to relese 7 out of the images
	$c = $count%8;
	if($c <= 3){
		return $this->three();
	}
	else if($c > 3 && $c <= 7){
		return $this->four();
	}
else if($c > 7){ //after the 7 has been released, return a new object with a non odd param and get the imageClass()
		$s = new imageBlock($total-7);
		$n = $s->imageClass($count);
		unset($s);
	   return $n;
		}
	}
}
	
}
function isTotalImageOdd(){
	$t = $this->total;
	$odd = true;
for($nums = 1; $nums< $t;$nums++){
	if(($t%$nums) == 0){
		$odd = false;
		break;
	}
}
return $odd;
}

function one(){
return 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
}

function two(){
return 'col-lg-6 col-md-6 col-sm-6 col-xs-6';
}

function three(){
	return 'col-lg-4 col-md-4 col-sm-4 col-xs-4';
}
function four(){
	return 'col-lg-3 col-md-3 col-sm-3 col-xs-3';
}

}


function setImageHeight($container){
if($container == 'col-lg-3 col-md-3 col-sm-3 col-xs-3' ){
		return 'small';
	}
else if($container == 'col-lg-4 col-md-4 col-sm-4 col-xs-4'){
		return 'big';
	}
else if($container == 'col-lg-6 col-md-6 col-sm-6 col-xs-6' ){
		return 'bigger';
	 }
	}
	
	
	
if(($total_images - 1) > 0){//if there are other images asides the dp
	$imageDisplayCount = 1;
	$imageBlock = new imageBlock($total_images);
foreach($all_images as $photo){

$imageClass = $imageBlock->imageClass($imageDisplayCount);
		?>	
<div class="<?php echo $imageClass ?> ">
<div class="this-property-image <?php echo setImageHeight($imageClass) ?> text-center">
<img class="property-images" src="<?php echo $photo ?>" <?php echo $property->image_attributes($popup = true) ?> />
</div>
</div>
<?php
$imageDisplayCount++;
	}
}
?>
</div>
<?php
unset($imageClass);//free the shit!	
}
?>
</div>

</div>

<div class="">
<h4 class="text-center">DID YOU KNOW?</h4>
<p>You can get alert on your phone and/email on any property that you want? All you need to do is <a href="../../cta/checkin.php">create a Client Temporary Account (CTA)</a></p>
</div>

</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
<div>
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<div class="contain border-0">
<div class="head opac-8-site-color-background white">
<h2 class="text-left"><span class="glyphicon glyphicon-bed round site-color-border"></span>  Facilities</h2>
</div>
<div class="body white-background">
<div class = "row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div>
<div class="paddding-5">(<?php echo $bath ?>)Bathroom(s)</div>
<div class="paddding-5">(<?php echo $loo ?>)Toilet(s)</div>

</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="contain">
<div class="head site-color-background white">
<h4 class="text-left"><span class="glyphicon glyphicon-tint white"></span>  Water Supply</h4>
</div>
<div class="body white-background  site-color text-left">
<div class="paddding-5" style="border-bottom:1px solid #e3e3e3"><span class="<?php echo statusIcon($borehole)?>"></span>  Borehole</div>
<div class="paddding-5" style="border-bottom:1px solid #e3e3e3"><span class="<?php echo statusIcon($well)?>"></span>  Well</div>
<div class="paddding-5" style="border-bottom:1px solid #e3e3e3"><span class="<?php echo statusIcon($pmachine)?>"></span>  Pumping machine</div>
</div>

</div>
</div>

</div>
</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
<div class="contain border-0">
<div class="head opac-8-site-color-background white text-left">
<h2 class="text-left"><span class="glyphicon glyphicon-stats round site-color-border"></span>  Rating</h2>
<p class="text-left">According to the agent in charge of this property (<?php echo $agent_business_name ?>), this property has been rated on percentage</p>
</div>
<div class="body white-background">
<!--The bars begin here-->

<div class="e3-border margin-5 padding-5">
<div  class="rating-bar" id="electricity-bar">
<div style="<?php echo "width: ".$electricity."%" ?>" class="site-color-background"></div>
</div>
<p class="text-left"><span class="glyphicon glyphicon-adjust site-color"></span>Electricity - <?php echo ($electricity != 0 ? $electricity." %" : "<span class=\"red\">Not Rated</span>" ) ?></p>
</div>

<div class="e3-border margin-5 padding-5">
<div class="rating-bar" id="road-bar">
<div style="<?php echo "width: ".$road."%" ?>" class="site-color-background">
</div>
</div>
<p class="text-left"><span class="glyphicon glyphicon-road site-color"></span>Road - <?php echo ($road != 0 ? $road." %" : "<span class=\"red\">Not Rated</span>" ) ?></p>
</div>

<div class="e3-border margin-5 padding-5">
<div class="rating-bar" id="security-bar">
<div style="<?php echo "width: ".$security."%" ?>" class="site-color-background">
</div>
</div>
<p class="text-left"><span class="glyphicon glyphicon-lock site-color"></span>Security - <?php echo ($security != 0 ? $security." %" : "<span class=\"red\">Not Rated</span>" ) ?></p>
</div>

<div class="e3-border margin-5 padding-5">
<div class="rating-bar" id="social-bar">
<div style="<?php echo "width: ".$social."%" ?>" class="site-color-background">
</div>
</div>
<p class="text-left"><span class="glyphicon glyphicon-tent site-color"></span>Socialization - <?php echo ($social != 0 ? $social." %" : "<span class=\"red\">Not Rated</span>" ) ?></p>
</div>

<!--The bars end here-->

</div>
</div>

</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class=" red-background margin-10 border-radius-5  animate bounce animate-infinite animate-in-2s" style="box-shadow:0px 5px 5px rgba(0,0,0,0.5)">
<div class="white text-center">
<h2>DISCLAIMER <span style="font-size:50px;"><i class="yellow animate pulse animate-infinite animate-in-2s">!</i></span></h2>
<p>This rating is according to the agent that uploaded this property, any alteration in the reality of this property is however not Shelter.com responsibility</p>
</div>
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="contain border-0">
<div class="head opac-8-site-color-background white">
<h2>Property Description</h2>
<p>What <?php echo $agent_business_name ?> has to say about this property</p>
</div>
<div class="body white-background text-center">
<?php
if(empty($description)){
	?>
	<div class="operation-report-container fail">No description from agent</div>
<?php	
}else{
	?>
	<div class="response"><?php echo $description ?></div>
<?php
}
	?>
</div>
</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="contain border-0">
<div class="head opac-8-site-color-background white">
<h2><span class="glyphicon glyphicon-briefcase round site-color-border"></span>Agent</h2>
</div>
<div class="body white-background text-center">
<h3><?php echo $agent_business_name ?></h3>
<div data-action="toggle" class="text-center">
<button class="btn btn-lg btn-primary" data-toggle-role="toggle-trigger" data-toggle-off ="Show Agent Contact" data-toggle-on="Hide Agent Contacts"></button>
<div data-toggle-role="main-toggle" class="absolute f7-background box-shadow border-radius-5 text-left" style="width:300px; z-index:2">
<div class="margin-10 border-radius-3">
<ul class="">
<li class="no-style-type"><span class="glyphicon glyphicon-map-marker red"></span> <?php echo $agent_office_address ?> (office)</li>
<li class="no-style-type"><span class="glyphicon glyphicon-earphone red"></span> <?php echo "0".$agent_contact1 ?> </li>
<li class="no-style-type"><span class="glyphicon glyphicon-earphone red"></span> <?php echo "0".$agent_contact2 ?> </li>
<li class="no-style-type"><span class="glyphicon glyphicon-earphone red"></span> <?php echo "0".$agent_office_contact ?> </li>
<li class="no-style-type"><span class="red" style="font-weight:bold">@</span> <?php echo $agent_business_mail ?> </li>
</div>
</ul>
</div>
</div>
<div class="padding-10 text-center">
<?php echo "<a class=\"\" href=\"../../agents/$agent_username\">See other properties by $agent_business_name</a>" ?>
</div>
</div>
</div>
</div>

</div>

</div>
</div>

</div>



<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="contain remove-side-margin-xs">
<div class="head f7-background"><h4 class="text-left">Related Properties</h4></div>
<div class="body remove-side-padding-xs">
<?php 
$get_related_properties = $db->query_object("SELECT property_ID FROM properties WHERE ((property_ID !='$ID') AND (type = '$type' OR area LIKE '%$area%' OR city LIKE '%$city%')) LIMIT 12");
	if($get_related_properties->num_rows > 0){
	?>
<div class="row">
<?php
		while($p = $get_related_properties->fetch_array(MYSQLI_ASSOC)){
			$rp = new property($p['property_ID']);
		$R_id = $rp->id;
		$R_dir = $rp->p_directory;
		$R_type = $rp->type;
		$R_rent = number_format($rp->rent);
		$R_MP = $rp->min_payment;
		$R_location = $rp->location;
		$R_dp = $rp->display_photo;

?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
<div class="margin-2 padding-5 e3-border white-background white-background">

<div class="row">

<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding:0px">
<img  class="property-images mini-property-image size-100" src="<?php echo $rp->display_photo_url() ?>" <?php echo $rp->image_attributes($popup = true) ?> />
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<p><a class="site-color" href="<?php echo  "$root/properties/$R_dir" ?>"><?php echo $tool->substring($R_type,'abc',25) ?></a></p>
<p><span class="glyphicon glyphicon-map-marker site-color"></span>  <?php echo $tool->substring($R_location,'abc',25) ?></p>
<p><span class="padding-5-10 border-radius-3 opac-3-site-color-background site-color bold"><?php echo $R_rent ?> /year</span></p>
<p class="">Payment required: <?php echo  $R_MP ?></p>
 </div>
 
 </div>
 
 </div>
</div>
<?php
	unset($rp);		
		}
$get_related_properties->free();
?>
</div>
 <a class="btn btn-bg btn-primary" href="../../search">see more »</a>
<?php
	}
else{
?>
<div class="no-response">There is no related property</div>
<?php
	}

?>
</div>
</div>
 <a class="btn btn-bg btn-primary"  href="../../search">search for property</a>

</div>
</div>


</div><!--container-fluid ends here-->
<div style="margin-top:35px">
<?php  
//
//update number of views

if($status==1 && $loggedIn_agent->business_name == $agent_business_name){
	$update_view = false;
}
else{
$newviews = $views + 1;
$db->query_object("UPDATE properties SET views=$newviews WHERE (property_ID='$id')");
}
?>
<nav class="row fixed f7-background" style="top:88%">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
<div class="row" style="padding:0px 10px">
<span class="col-lg-8 col-md-8 col-sm-8 col-xs-7 text-left">
<span style="height:50px">
<span><img src="<?php echo $property->display_photo_url() ?>" style="vertical-align:text-bottom" class="mini-property-image size-50"></span>
<span class="font-16 bold"><?php echo $type ?></span>
</span>
</span>
<span class="col-lg-2 col-md-2 col-sm-2 col-xs-5 text-center"> <?php echo $clip_button ?> </span>
<span class="col-lg-2 col-md-2 col-sm-2 col-xs-5 text-center"><?php echo $updateLink ?> </span>
<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
<p class="grey"><span class="glyphicon glyphicon-map-marker" style="color:#20435C"></span> <?php echo $tool->substring($location,'xyz',20) ?></p>
</span>
</div>
</div>
<!--
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<div class="temporary-popup" id="tap-instruction">
	<p>Tap on the image to see full size</p>
</div>
</div>
-->
</nav>

<?php
require('../../resources/global/footer.php');
?>
<script>
$('.clip-button,.unclip-button').addClass('btn btn-default');
</script>
</div>
</div>




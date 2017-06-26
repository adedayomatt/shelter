<div class="main-content">
<?php
$totalImages = 0;

	$getdetails = mysql_query("SELECT * FROM properties WHERE (property_ID='".$ID."')");
	if($getdetails and mysql_num_rows($getdetails)==1){
$detail = mysql_fetch_array($getdetails,MYSQL_ASSOC);
$id =  $detail['property_ID'];
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
	}
	else{
		echo "<br/><br/><div class=\"no-property\">No property with the ID <b>".$ID."</b>. It may have been deleted or banned.<br/>If you think this is an error, please  <a href=\"\">Report Now</a></div>";
		mysql_close($db_connection);
		exit();
	}
$getManagerDetail = mysql_query("SELECT Business_Name,Office_Address,Office_Tel_No,Business_email,Phone_No,User_ID FROM profiles WHERE (User_ID='".$managerId."')");
		if($getManagerDetail){
		$ManagerDetail = mysql_fetch_array($getManagerDetail,MYSQL_ASSOC);
			$BN = $ManagerDetail['Business_Name'];
			$add = $ManagerDetail['Office_Address'];
			$OTel = $ManagerDetail['Office_Tel_No'];
			$Bmail = $ManagerDetail['Business_email'];
			$PTel = $ManagerDetail['Phone_No'];
			$agentId = $ManagerDetail['User_ID'];
		
		}else{
			echo "<script>alert(\"Couldnt get manager's detail\");</script>";
		}

function checkForImage($imgName){
	GLOBAL $totalImages;
	if(file_exists($imgName)){
		$image = "<div class=\"photo-container\"><img alt=\"Not Available\" class=\"property-photo\" src=\"".$imgName."\"/></div>";
		$totalImages += 1;
		}else
		{
			$image = "";
		}
		return $image;	
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
<?php echo "<p id=\"property-head\"> $type at $location<br/><span style=\"color:grey;font-size:80%;\">$ID</span></p>"; ?>
</div>


<h4 class="container-headers">PHOTOS</h4>
<p class="about-section">Photos added by the agent managing this property. It allows client to have an idea of different corners of the property before inspection</p>
<div id="image-tray">
<div id="photos-container">
<?php  
//if there is any image available
if(checkForImage($ID.'_01.png') == "" && checkForImage($ID.'_02.png')=="" && checkForImage($ID.'_03.png') =="" && checkForImage($ID.'_02.png') == ""){
	echo "<p style=\"text-align:center; color:red;\">No image is available for this property</p>";
}
else{
	echo "<p style=\"display:block\">".($totalImages > 1 ? "$totalImages photos" : "$totalImages photo"). " available</p>";
echo (checkForImage($ID.'_01.png') != "" ? checkForImage($ID.'_01.png')  : "");
echo (checkForImage($ID.'_02.png') != "" ? checkForImage($ID.'_02.png')  : "");
echo (checkForImage($ID.'_03.png') != "" ? checkForImage($ID.'_03.png')  : "");
echo (checkForImage($ID.'_04.png') != "" ? checkForImage($ID.'_04.png')  : "");
}
?>
</div>
</div>
<span style="display:block;width:40%;padding:2%; border-radius:5px; background-color:#74B4E0"><?php echo" Total views:  $views" ?></span>

<div id="detail-tray">
<h4 class=" container-headers">INFO</h4>
<p class="about-section">Basic information about this property</p>
<div id="info-container">
<div id="info">
<ul class="no-padding-ul">
<li class="info-list">Category:N/A</li>
<li class="info-list">Property type: <?php echo $type?></li>
<li  class="info-list"><button class="info-btn">(<?php echo $bath ?>)Bathroom(s)</button><button class="info-btn">(<?php echo $loo ?>)Toilet(s)</button></li>
<li class="info-list">Address: <?php echo $location?></li>
<li class="info-list">Rent: <?php echo "N".number_format($rent)?></li>
<li  class="info-list">Minimum Payment Required: <?php echo $min_payment ?></li>
<li class="info-list">Agent in charge: <?php echo $BN ?></li>
<li class="info-list">Uploaded on: <?php echo $date ?></li>
</ul>
</div>
</div>
<h4 class="container-headers">FACILITIES</h4>
<p class="about-section">Facilities in this property</p>
<div id="facilities-container">
<div id="facilities-box">
<ul class="no-padding-ul">
<li class="facilities-list"><span style="<?php echo statusIcon($pmachine)?>" class="black-icon"></span>  Pumping machine</li>
<li class="facilities-list"><span style="<?php echo statusIcon($borehole)?>" class="black-icon"></span>  Borehole</li>
<li class="facilities-list"><span style="<?php echo statusIcon($well)?>" class="black-icon"></span>  Well</li>
<li class="facilities-list"><td><span style="<?php echo statusIcon($tiles)?>" class="black-icon"></span>  Tiles</li>
<li class="facilities-list"><span style="<?php echo statusIcon($pspace)?>" class="black-icon"></span>  Parking space</li>
</ul>
<?php echo "<h4>Property description by Agent</h4>";
echo "<p style=\"color:#6D0AAA\"><i>".(empty($description) ? "No Description" : $description)."</i></p>";
	?>
</div>
</div>
<h4 class="container-headers">RATING</h4>
<p class="about-section">According to the agent in charge of this property (<?php echo $BN ?>), this property has been rated on percentage</p>
<div id="rating-container">

<!--The bars begin here-->
<div id="bars-box">

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
<!--The bars end here-->
<div id="rating-disclaimer-container">
<h2 id="rating-disclaimer-head">DISCLAIMER<span style="font-size:200%; color:yellow">!</span></h2>
<p>This rating is according to the agent that uploaded this property, any alteration in the reality of this property is however not Shelter.com responsibility</p>
</div>
</div>

<h4  class="container-headers">AGENT</h4>
<p class="about-section">Interested in this property and want to inspect it, these are the contacts of the agent in charge</p>
<div style="margin-top:5%" id="agent-info-container">
<div id="agent-contacts">
<ul class="no-padding-ul">
<li class="contact-list"><span id="address-icon"></span>Office Address: <?php echo $add ?> </li>
<li class="contact-list"><span id="phone-icon"></span>Phone No: <?php echo "0".$PTel ?> </li>
<li class="contact-list"><span id="phone-icon"></span>Alt. Phone No: <?php echo "0".$OTel ?> </li>
<li class="contact-list"><span id="mail-icon"></span> E-mail: <?php echo $Bmail ?> </li>
</ul>
<?php echo "<a class=\"skyblue-block-link\" href=\"../../$agentId\">See other properties by $BN</a>" ?>
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
$getRelatedProperties = mysql_query("SELECT * FROM properties WHERE ((property_ID !='$ID') AND (type = '$type' OR location LIKE '%location%')) LIMIT 12");
if($getRelatedProperties){
	if(mysql_num_rows($getRelatedProperties) != 0){
		while($property = mysql_fetch_array($getRelatedProperties, MYSQL_ASSOC)){
		$R_id = $property['property_ID'];
		$R_dir = $property['directory'];
		$R_type = $property['type'];
		$R_rent = number_format($property['rent']);
		$R_MP = $property['min_payment'];
		$R_location = $property['location'];
$image1 = $R_dir."/$R_id".">01.png";
$image2 = $R_dir."/$R_id".">02.png";
$image3 = $R_dir."/$R_id".">03.png";
$image4 = $R_dir."/$R_id".">04.png";
$R_image = (file_exists($image1) ? $image1 : (file_exists($image2) ? $image2 : (file_exists($image3) ? $image3 : (file_exists($image4) ? $image4 : "../default.png"))));
echo "<div class=\"related-property\">
<img src=\"$R_image\" class=\"related-property-image\"/>
<div class=\"related-property-info\">
<a href=\"$root/properties/$R_dir\">$R_type at $R_location</a>
 <ul class=\"no-padding-ul\">
 <li>Rent: $R_rent /year</li>
 <li>Payment required: $R_MP</li>
 </ul>
 </div>
</div>";
			
		}
	}
	else{
		echo "<div style=\"text-align:center; padding: 2%; background-color: white; color:red;\">There is no related property</div>";
	}
}
?>
 <a class="skyblue-inline-block-link" href="../../search">search for property</a>
 <a class="next skyblue-block-link" href="../../search">see more »</a>
<br/>
<div>
<h4 align="center">DID YOU KNOW?</h4>
<p>You can get alert on your phone and/email on any property that you want? All you need to do is <a href="../../cta/checkin.php">create a Client Temporary Account (CTA)</a></p>
</div>
</div>
<div id="agents-container">
<p>These agents also have this kind of properties</p>
<?php
$getAgents = mysql_query("SELECT uploadby FROM properties WHERE type=$type");
if($getAgents){
	if(mysql_num_rows($getAgents)==0){
		echo "<p style=\"color:red\">There are no other agents with this kind of properties</p>";
	}
	else{
		while ($a = mysql_fetch_array($getAgents,MYSQL_ASSOC)){
			$x = $a['uploadby'];
$getAgentsProfile = @mysql_query("SELECT Business_Name FROM profiles WHERE User_ID = $x");		
		}
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
//require('../../require/footer.html');
//update number of views
$newviews = $views + 1;
mysql_query("UPDATE properties SET views=$newviews WHERE (property_ID='$ID')");
mysql_close($db_connection);
?></div>
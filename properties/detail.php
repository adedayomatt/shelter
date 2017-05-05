<div class="main-content">
<?php
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
	if(file_exists($imgName)){
		$image = "<div class=\"photo-container\"><img alt=\"Not Available\" class=\"property-photo\" src=\"".$imgName."\"/></div>";
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
<div style="margin-left:20px">
<p><strong><?php echo "$type at $location ($ID )";?></strong></p>
</div>
<div id="image-tray">
<div id="photos-container">
<h4 class="container-headers">PHOTOS</h4>
<?php  
echo (checkForImage($ID.'_01.png') != "" ? checkForImage($ID.'_01.png')  : "<div class=\"photo-container\">No Picture</div>");
echo (checkForImage($ID.'_02.png') != "" ? checkForImage($ID.'_02.png')  : "<div class=\"photo-container\">No Picture</div>");
echo (checkForImage($ID.'_03.png') != "" ? checkForImage($ID.'_03.png')  : "<div class=\"photo-container\">No Picture</div>");
echo (checkForImage($ID.'_04.png') != "" ? checkForImage($ID.'_04.png')  : "<div class=\"photo-container\">No Picture</div>");
?>
</div>
</div>
<div id="detail-tray">

<div id="info-container">
<h4 class=" container-headers">INFO</h4>
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
<div id="facilities-container">
<h4 class="container-headers">FACILITIES</h4>
<div id="facilities-box">
<ul class="no-padding-ul">
<li class="facilities-list"><span style="<?php echo statusIcon($pmachine)?>" class="black-icon"></span>  Pumping machine</li>
<li class="facilities-list"><span style="<?php echo statusIcon($borehole)?>" class="black-icon"></span>  Borehole</li>
<li class="facilities-list"><span style="<?php echo statusIcon($well)?>" class="black-icon"></span>  Well</li>
<li class="facilities-list"><td><span style="<?php echo statusIcon($tiles)?>" class="black-icon"></span>  Tiles</li>
<li class="facilities-list"><span style="<?php echo statusIcon($pspace)?>" class="black-icon"></span>  Parking space</li>
</ul>
<?php echo "<h4>Property description by Agent</h4>";
if(!empty($description)){$d = $description;}
else{$d = "No Description";}
echo "<p style=\"color:#6D0AAA\"><i>$d</i></p>";
	?>
</div>
</div>
<div id="rating-container">
<h4 class="container-headers">RATING</h4>

<!--The bars begin here-->
<div id="bars-box">
<table>
<tr>
<td>
<div  class="rating-bar" id="electricity-bar">
<div style="<?php echo "height: ".(100 - $electricity)."%" ?>" class="wiped" id="electricity-wiped"></div>
</div>
</td>
<td>
<div class="rating-bar" id="road-bar">
<div style="<?php echo "height: ".(100 - $road)."%" ?>" class="wiped" id="road-wiped"></div>
</div>
</td>
<td>
<div class="rating-bar" id="security-bar">
<div style="<?php echo "height: ".(100 - $security)."%" ?>" class="wiped" id="security-wiped"></div>
</div>
</td>
<td>
<div class="rating-bar" id="social-bar">
<div style="<?php echo "height: ".(100 - $social)."%" ?>" class="wiped" id="social-wiped"></div>
</div>
</td>
</tr>
<tr>
<td class="bar-label">E(<?php echo $electricity ?>%)</td><td class="bar-label">R(<?php echo $road ?>%)</td>
<td class="bar-label">S(<?php echo $security ?>%)</td><td class="bar-label">S(<?php echo $social ?>%)</td>
</tr>
</table>
</div>
<!--The bars end here-->
</div>

<div style="margin-top:5%" id="agent-info-container">
<h4  class="container-headers">AGENT</h4>
<div id="agent-contacts">
<ul class="no-padding-ul">
<li class="contact-list"><span id="address-icon"></span>Office Address: <?php echo $add ?> </li>
<li class="contact-list"><span id="phone-icon"></span>Phone No: <?php echo "0".$PTel ?> </li>
<li class="contact-list"><span id="phone-icon"></span>Alt. Phone No: <?php echo "0".$OTel ?> </li>
<li class="contact-list"><span id="mail-icon"></span> E-mail: <?php echo $Bmail ?> </li>
</ul>
<?php echo "<p>See <a href=\"../../$agentId\">other properties by $BN</a></p>" ?>
</div>
</div>

</div>

</div>


<div class="rhs">
<div class="fixed-rhs-content other-properties">
<div id="see-also-container">
<h4>See Also...</h4>
<p>We thought you might want to see this related properties too</p>
<?php 
$getRelatedProperties = mysql_query("SELECT * FROM properties WHERE ((property_ID !='$ID') AND (type = '$type' OR location LIKE '%location%')) LIMIT 3");
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
 <ul>
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
<p><a href="../../search">see more</a> or <a href="../../search">search for property</a></p>


<h4 align="center">DID YOU KNOW?</h4>
<p>You can get alert on your phone and/email on any property that you want? All you need to do is <a href="../../cta/checkin.php">create a Client Temporary Account (CTA)</a></p>
</div>
</div>
</div>

<div style="margin-top:355px">
<?php  
//require('../../require/footer.html');
mysql_close($db_connection);
?></div>

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
		echo "<br/><br/><p align=\"center\">No property with the ID <b>".$ID."</b>. It may have been deleted or banned.<br/>If you think this is an error, please  <a href=\"\">Report Now</a></p>";
		mysql_close($db_connection);
		exit();
	}
$getManagerDetail = mysql_query("SELECT Business_Name,Office_Address,Office_Tel_No,Business_email,Phone_No FROM profiles WHERE (User_ID='".$managerId."')");
		if($getManagerDetail){
		$ManagerDetail = mysql_fetch_array($getManagerDetail,MYSQL_ASSOC);
			$BN = $ManagerDetail['Business_Name'];
			$add = $ManagerDetail['Office_Address'];
			$OTel = $ManagerDetail['Office_Tel_No'];
			$Bmail = $ManagerDetail['Business_email'];
			$PTel = $ManagerDetail['Phone_No'];
		
		}else{
			echo "<script>alert(\"Couldnt get manager's detail\");</script>";
		}

function checkForImage($imgName){
	if(file_exists($imgName)){
		$image = "<div class=\"photo-container\"><img alt=\"Not Available\" class=\"property-photo\" src=\"".$imgName."\"/></div>";
		
		}else
		{
			$image = "<div class=\"photo-container\"><img alt=\"Not Available\" class=\"property-photo\" src=\"".$imgName."\"/></div>";
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
<p><?php echo "shid: ".$ID;?></p>
</div>
<div id="image-tray">
<?php  
echo checkForImage($ID.'_01.png');
echo checkForImage($ID.'_02.png');
echo checkForImage($ID.'_03.png');
echo checkForImage($ID.'_04.png');
?>
</div>
<div id="detail-tray">
<div id="details-tab">
<div style="float:left" class="tab" id="tab1"><p>Info</p></div>
<div style="float:left" class="tab"id="tab2"><p>Facilities</p></div>
<div style="float:left" class="tab" id="tab3"><p>Contact Agent for Inspection</p></div>
</div>

<div class="switch-display" id="info">
<ul id="info-ul">
<li class="info-list">Category:N/A</li>
<li><hr/></li>
<li class="info-list">Property type: <?php echo $type?></li>
<li><hr/></li>
<li  class="info-list"><button class="info-btn">(<?php echo $bath ?>)Bathroom(s)</button>
<button class="info-btn">(<?php echo $loo ?>)Toilet(s)</button></li>
<li><hr/></li>
<li class="info-list">Address: <?php echo $location?></li>
<li><hr/></li>
<li class="info-list">Rent: <?php echo "N".number_format($rent)?></li>
<li><hr/></li>
<li  class="info-list">Minimum Payment Required: <?php echo $min_payment ?></li>
<li><hr/></li>
<li class="info-list">Agent in charge: <?php echo $BN ?></li>
<li><hr/><li>
<li class="info-list">Uploaded on: <?php echo $date ?></li>
</ul>
<br/>
<button class="tab-referer" id="see-more">see more <span class="arrow">»</span></button>
</div>

<div class="switch-display" id="rating">

<div id="facilities-box">
<table>
<tr class="facilities-row"><td><i style="<?php echo statusIcon($pmachine)?>" class="black-icon"></i>  Pumping machine</td></tr>
<tr class="facilities-row"><td><i style="<?php echo statusIcon($borehole)?>" class="black-icon"></i>  Borehole</td></tr>
<tr class="facilities-row"><td><i style="<?php echo statusIcon($well)?>" class="black-icon"></i>  Well</td></tr>
<tr class="facilities-row"><td><i style="<?php echo statusIcon($tiles)?>" class="black-icon"></i>  Tiles</td></tr>
<tr class="facilities-row"><td><i style="<?php echo statusIcon($pspace)?>" class="black-icon"></i>  Parking space</td></tr>
</table>
<?php echo "<h4>Property description by Agent</h4>";
if(!empty($description)){$d = $description;}
else{$d = "No Description";}
echo "<p style=\"color:#6D0AAA\"><i>\"".$d."\"</i></p>";
	?>
</div>
<!--The bars begin here-->
<div id="bars-box">
<table>
<tr>
<td>
<input name="percent" id="electricity-value" type="hidden" value="<?php echo $electricity ?>"/>
<div class="rating-bar" id="electricity-bar">
<div class="wiped" id="electricity-wiped"></div>
</div>
</td>
<td>
<input name="percent" id="road-value" type="hidden" value="<?php echo $road ?>"/>
<div class="rating-bar" id="road-bar">
<div class="wiped" id="road-wiped"></div>
</div>
</td>
<td>
<input name="percent" id="security-value" type="hidden" value="<?php echo $security ?>"/>
<div class="rating-bar" id="security-bar">
<div class="wiped" id="security-wiped"></div>
</div>
</td>
<td>
<input name="percent" id="social-value" type="hidden" value="<?php echo $social ?>"/>
<div class="rating-bar" id="social-bar">
<div class="wiped" id="social-wiped"></div>
</div>
</td>
</tr>
<tr>
<td class="bar-label">Electricity(<?php echo $electricity ?>%)</td><td class="bar-label">Road(<?php echo $road ?>%)</td>
<td class="bar-label">Security(<?php echo $security ?>%)</td><td class="bar-label">Socialization(<?php echo $social ?>%)</td>
</tr>
</table>
</div>
<!--The bars end here-->
<button class="tab-referer" id="contact-agent">Contact Agent <span class="arrow">»</span></button>
</div>


<div id="agent-contacts">
<ul id="contacts-ul">
<li class="contact-list"><i id="address-icon"></i> <?php echo $add ?> </li>
<li class="contact-list"><i id="phone-icon"></i> <?php echo "0".$PTel ?> </li>
<li class="contact-list"><i id="phone-icon"></i> <?php echo "0".$OTel ?> </li>
<li class="contact-list"><i id="mail-icon"></i> <?php echo $Bmail ?> </li>
</ul>
</div></div>
<div style="margin-top:355px">
<?php  
require('../../require/footer.html');
mysql_close($db_connection);
?></div>

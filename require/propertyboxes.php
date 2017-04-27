
<?php
function clip($p,$cta){
	$connect = true;
	require('connexion.php');
	$checkclip = mysql_query("SELECT * FROM clipped WHERE (propertyId='$p' AND clippedby='$cta')");
	if(mysql_num_rows($checkclip)==1){
		return 'unclip';
	}else{
		return 'clip';
	}
	mysql_close($db_connection);
}

function timeuploaded($timestamp){
	$time = time() - $timestamp;
	if($time<60){
		$since = $time.' seconds ago';
	}
	else if($time>=60 && $time<3600){
		$since = (int)($time/60).' minutes ago';
	}
	else if($time>=3600 && $time<86400){
		$since = (int)($time/3600).' hours, '.(($time/60)%60).' minutes ago';
	}
	else if($time>=86400 && $time<604800){
		$since = date('l, M d ',$timestamp).'('.(int)($time/86400).' days ago)';
	}
	else if($time>=604800 && $time<18144000){
		$since = date('M d  ',$timestamp).'('.(int)($time/604800).' weeks ago)';
	}
	else{
		$since = "sometime ago";
	}
return $since;
		}

if(!empty($propertyId)){
/*
before including this script, a script that would fetch the records must have been included. $count would have been initialize as the total
number of records fetched by the query in  the script
*/
$i = 0;
while($i < $count){
	$getbusinessname=mysql_query("SELECT Business_Name,Office_Tel_No,Phone_No,Alt_Phone_No FROM profiles WHERE (User_ID='".$uploadby[$i]."')");
	if($getbusinessname){
		while($B=mysql_fetch_array($getbusinessname,MYSQL_ASSOC)){
			$Bname=$B['Business_Name'];
			$officeNo = $B['Office_Tel_No'];
			$PhoneNo = $B['Phone_No'];
			$altPhoneNo = $B['Alt_Phone_No'];
		}
	}
	else{
		$Bname="property untraceable";
		$officeNo="No contact";
		$PhoneNo ="No contact";
		$altPhoneNo = "No contact";
	}
	
//signifies if matches for CTA
if(isset($rqtype) && isset($rqpricemax) && isset($rqlocation)){
	if(in_array($propertyId[$i],$CTAmatches)){
	$m="<span class=\"black-icon\" style=\"background-position:-72px -144px\"></span>";
	}
	else{
	$m='';	
	}
}
else{
	$m='';
}
	
	
	
	
//this takes the image folder url
	$imageurl = checkurl($propertydir[$i],$ref);
//this takes the complete url of the image. remember, the name of the images are the proprerty id too with either _01,_02...
	$image = showOneImage($imageurl,$propertyId[$i]);
	
	$rentperannum = $rent[$i];
	$OneAndHalf =  $rentperannum + ($rentperannum/2);
	$TwoYears = $rentperannum*2;
	$firstpayment = ($min_payment[$i] == '1 year' ? number_format($rentperannum) : ($min_payment[$i] == '1 year, 6 months' ? number_format($OneAndHalf) : ($min_payment[$i] == '2 years' ? number_format($TwoYears) : '')));
	
	/* I'll need when i want make my image animation in js
	<input id=\"$propertyId[$i]hidden01\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_01.png")."\"  />
	<input id=\"$propertyId[$i]hidden02\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_02.png")."\"  />
	<input id=\"$propertyId[$i]hidden03\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_03.png")."\"    />
	<input id=\"$propertyId[$i]hidden04\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_04.png")."\"    />
	*/
	//main box divided into two >>image:info=50:50
	
	if($status==9){
	$clipbutton = "<a  class=\"options\"  href=\"$root/cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=$ref\" id=\"$propertyId[$i]clipbutton\" onclick=\"makeclip('$propertyId[$i]clipbutton','$ctaid','$ref')\"><span class=\"black-icon clip-icon\"></span>".clip($propertyId[$i],$ctaid)."</a>";
	}
else {
	$clipbutton = "<a class=\"options disabled\"  href=\"$root/cta/checkin.php?_rdr=1\"><span class=\"black-icon clip-icon\"></span>clip</a>";
	
}
	
if($ref=='search_page'){
	$page = "
	<div class=\"mini-propertybox\">
	<div class=\"mini-image\">
	<img id=\"$propertyId[$i]image\" height=\"100%\" width=\"100%\" src=\"$image\"/>
	</div>
	<div class=\"mini-info\">
	<span class=\"mini-detail\"><a href=\"$root/properties/$propertydir[$i]\">$type[$i] at $location[$i]</a>$m</span>
	<span class=\"mini-detail\"><span class=\"black-icon price-icon\"></span> Rent: N ".number_format($rentperannum)."/year</span>
	<span class=\"mini-detail\"><span class=\"black-icon min-payment-icon\"></span><strong>$min_payment[$i]</strong> payment required (N $firstpayment)</span>
	<span class = \"mini-detail time\" align=\"left\"><span class=\"black-icon time-icon\"></span>".timeuploaded($howlong[$i])."</span>
	</div>
	</div>";
		$advertimage1 = "../resrc/image/advert1.jpeg";
		$advertimage2 = "../resrc/image/advert2.jpeg";
}
else if($ref=='profile_page'){
	$page = "
	<div class=\"mini-propertybox\">
	<div class=\"mini-image\">
	<img id=\"$propertyId[$i]image\" height=\"100%\" width=\"100%\" src=\"$image\"/>
	</div>
	<div class=\"mini-info\">
	<span class=\"mini-detail\"><a href=\"$root/properties/$propertydir[$i]\">$type[$i] at $location[$i]</a>$m</span>
	<span class=\"mini-detail\"><span class=\"black-icon price-icon\" ></span> Rent: N ".number_format($rentperannum)."/year</span>
	<span class=\"mini-detail\"><span class=\"black-icon min-payment-icon\"></span> <strong>$min_payment[$i]</strong> payment required (N $firstpayment)</span>
	<span class = \"mini-detail time\" align=\"left\"><span class=\"black-icon time-icon\"></span>".timeuploaded($howlong[$i])."</span>
	$clipbutton
	<a  class=\"options\" href=\"#\"><span class=\"black-icon eye-icon\"></span>(0)views</a>
	</div>
	</div>";	
	$advertimage1 = "../resrc/image/advert1.jpeg";
		$advertimage2 = "../resrc/image/advert2.jpeg";
}
else{
	$page = "<div id=\"$propertyId[$i]\" class=\"propertybox\">
	<div class=\"property-heading\">
	<div class=\"detail\" >
	<a href=\"$root/properties/$propertydir[$i]\">$type[$i] at $location[$i]</a>$m<br/>
	<span class=\"status\"><span class=\"black-icon status-icon\"></span> <span style=\"color:green\">Available</span></span>
	</div>
	</div>
	<div class=\"image-info\">
	<div id = \"$propertyId[$i]container\" class=\"imagebox\">
	<img id=\"$propertyId[$i]image\" onclick=\"animatePropertyImages('$propertyId[$i]image','$image')\" height=\"90%\" width=\"100%\" src=\"$image\"/>
	<div class=\"bath-toilet\"><button class=\"bath-toilet-btn\">($bath[$i]) Baths(s)</button><button class=\"bath-toilet-btn\">($toilet[$i]) Toilet(s)</button></div>
	</div>
	
	<div class=\"infobox\">
	<span class=\"detail\"><span class=\"black-icon price-icon\"></span> Rent: N ".number_format($rentperannum)."/year</span>
	<span class=\"detail\"><span class=\"black-icon min-payment-icon\"></span><strong>$min_payment[$i]</strong> payment required (N $firstpayment)</span>
	<span class =\"description detail\"><span class=\"black-icon comment-icon\"></span> Description: </span><div class=\"comment\"><i>$description[$i]</i></div>
	<span class=\"detail\">Managed by <a class=\"agent-link\" href=\"$root/$uploadby[$i]\">$Bname</a></span>
	</div>
	<span class = \"detail time\" align=\"left\"><span class=\"black-icon time-icon\"></span>".timeuploaded($howlong[$i])."</span>
	</div>";

//the like pane
	$page .= "<div class=\"like-pane\">
	<hr/>
		$clipbutton
		<a  class=\"options report-icon\" href=\"$root/properties/$propertydir[$i]\"><span class=\"black-icon see-more-icon\"></span>see details</a>
		<div class=\"agent-contacts-box\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a  class=\"options agent-contacts\"><span class=\"black-icon contact-icon\"></span>Agent</a>
		<a  class=\"options report-property\" href=\"#\"><span class=\"black-icon eye-icon\"></span>(0)views</a>
		</div>
		</div>";
		$advertimage1 = "resrc/image/advert1.jpeg";
		$advertimage2 = "resrc/image/advert2.jpeg";
}
	print $page;
	
if($i == 1){
	echo "<img class=\"in-between-advert\" src=\"$advertimage1\" />";
}
if($i == 5){
	echo "<img class=\"in-between-advert\" src=\"$advertimage2\" />";
}
	$i++;
}
}

function checkurl($dir,$refpoint){
	/*since this script is required by different pages in different folders, the relative location with the homepage(index) is in the web root, therefore
		url for images is different. $refpoint will only be set in the web index */
	if ($refpoint=="home_page"){
	return "properties/$dir/";
	}
	else{
	return "../properties/$dir/";
	}
}

function showOneImage($url,$imagename){
	if(file_exists($url.$imagename."_01.png")){
		return $url.$imagename."_01.png";
	}
//if the first one is absent...check the second one...
	else if(file_exists($url.$imagename."_02.png")){
			return $url.$imagename."_02.png";
		}
//..else check the third
		else if(file_exists($url.$imagename."_03.png")){
			return $url.$imagename."_03.png";
		}
//...else check the fourth
		else if(file_exists($url.$imagename."_04.png")){
			return $url.$imagename."_04.png";
		}
//if the first, second, third and fourth image is not found, use the default image
		else{
	//i want to access the default image now
	
			if(substr($url,0,3)=="../"){
				return "../properties/default.png";
			}
					else{
				return "properties/default.png";
			}
			
		}
		
	}
function checkimage($url,$imagename){
	if(file_exists($url.$imagename)){
		return $url.$imagename;
	}
	else{
		return "";
	}
}
/*
function pagereferertag($value,$start,$end){
		if($value==$start){
			return 'jump to|> start';
		}
		else if($value==$end){
			return 'end';
		}
		else{
			return $value;
		}
	}
*/

	?>
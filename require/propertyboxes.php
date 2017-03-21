
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
	$m="<i class=\"black-icon\" style=\"background-position:-72px -144px\"></i><i style=\"color:blue\"></i>";
	}
	else{
	$m='';	
	}
}
else{
	$m='';
}
	
	$date = substr($date_uploaded[$i],0,10);
//this takes the image folder url
	$imageurl = checkurl($propertydir[$i],$ref);
//this takes the complete url of the image. remember, the name of the images are the proprerty id too with either _01,_02...
	$image = showOneImage($imageurl,$propertyId[$i]);
	$formatrent = number_format($rent[$i]);
	
	/* I'll need when i want make my image animation in js
	<input id=\"$propertyId[$i]hidden01\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_01.png")."\"  />
	<input id=\"$propertyId[$i]hidden02\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_02.png")."\"  />
	<input id=\"$propertyId[$i]hidden03\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_03.png")."\"    />
	<input id=\"$propertyId[$i]hidden04\" type=\"text\" value=\"".checkimage($imageurl,$propertyId[$i]."_04.png")."\"    />
	*/
	//main box divided into two >>image:info=50:50
	$page = "<div id=\"$propertyId[$i]\"class=\"propertybox\">
	$m<p class=\"property-heading\"><a href=\"$root/properties/$propertydir[$i]\">$type[$i] at $location[$i]</a></p>
	<div class=\"image-info\">
	<div id = \"$propertyId[$i]container\" class=\"imagebox\">
	<img id=\"$propertyId[$i]image\" onclick=\"animatePropertyImages('$propertyId[$i]image','$image')\" height=\"90%\" width=\"100%\" src=\"$image\"/>
	<div class=\"bath-toilet\"><button class=\"bath-toilet-btn\">($bath[$i]) Baths(s)</button><button class=\"bath-toilet-btn\">($toilet[$i]) Toilet(s)</button></div>
	</div>
	
	<div class=\"infobox\">
	<p class=\"property-heading2\"> $type[$i] at $location[$i]</p>
	<p align=\"left\"><i class=\"black-icon\" id=\"price\"></i> price: N $formatrent</p>
	<p align=\"left\"><i class=\"black-icon\" id=\"min\"></i> Minimum payment required: $min_payment[$i]</p>
	<p class =\"description\" align=\"left\"><i class=\"black-icon\" id=\"com\"></i> Description: </p><div class=\"comment\"><i>$description[$i]</i></div>
	<p align=\"left\"><i class=\"black-icon\" id=\"date\"></i> Date uploaded: $date</p>
	<p align=\"left\">Managed by <a class=\"agent-link\" href=\"$root/$uploadby[$i]\">$Bname</a></p>
	<a class=\"view-details\" href=\"$root/properties/$propertydir[$i]\"><i class=\"black-icon\" id=\"see\"></i>See details</a>
	</div>
	</div>";
//the like pane
if($status==9){
	$clipbutton = "<a href=\"$root/cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=$ref\" id=\"$propertyId[$i]clipbutton\" onclick=\"makeclip('$propertyId[$i]clipbutton','$ctaid','$ref')\"><li class=\"options\" id=\"clip-property\"><i class=\"black-icon\" id=\"like\"></i>".clip($propertyId[$i],$ctaid)."</li></a>";
	}
else {
	$clipbutton = "<a href=\"$root/cta/checkin.php?_rdr=1\"><li class=\"options disabled\" id=\"clip-property\"><i class=\"black-icon\" id=\"like\"></i>clip</li></a>";
	
}
	$page .= "<div class=\"like-pane\">
		<span class=\"status\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span></span>
		<ul class=\"option-list\">
		$clipbutton
		<a href=\"#\"><li class=\"options\" id=\"report-property\"><i class=\"black-icon\" id=\"report\"></i>Report this property</li></a>
		<div class=\"agent-contacts-box\" id=\"\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a><li class=\"options\" id=\"agent-contacts\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</li></a>
		</ul>
		</div>
		</div>";
		
	print $page;
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


	?>
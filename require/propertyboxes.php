
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

if(isset($_GET['next'])){
	$i = $_GET['next'];
	
}else{ $i = 0; }
/*pagination logic starts here*/
/* $maxi specify the maximum number of box to be shown at once when page loads */
$maxi = 3;
$track = "<p style=\"display:inline\">showing ".($i+1)." - ".($i+$maxi)." of ".$count."</p>";
if(!empty($propertyId)){
/*
before including this script, a script that would fetch the records must have been included. $count would have been initialize as the total
number of records fetched by the query in  the script
*/
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
	echo "<script>togglecontact('x','y');</script>";
	$imageurl = checkimage($propertydir[$i],$propertyId[$i],$ref);
	$formatrent = number_format($rent[$i]);
	//main box divided into two >>image:info=50:50
	$page = "<div class=\"propertybox\">
	$m<p class=\"property-heading\"><a href=\"$root/properties/$propertydir[$i]\">$type[$i] at $location[$i]</a></p>
	<div class=\"image-info\">
	<div class=\"imagebox\">
	<img height=\"90%\" width=\"100%\" src=\"$imageurl\"/>
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
//$status = 9 is for CTA
	if($status==9){
	if($ref=='home_page' && isset($_GET['next'])){
		$page .= "<div class=\"like-pane\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span>
		<a class=\"love-property\" href=\"cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=home_page&next=".$_GET['next']."\"><i class=\"black-icon\" id=\"like\"></i>".clip($propertyId[$i],$ctaid)."</a>
		<a class=\"report-property\" href=\"#\"><i class=\"black-icon\" id=\"report\"></i>Report this property</a>
		<div class=\"agent-contacts-box\" id=\"y\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a class=\"show-contacts\" id=\"x\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</a>
		</div>
		</div>";
	}
	else if ($ref=='home_page' && !isset($_GET['next'])) {
		$page .= "<div class=\"like-pane\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span>
		<a class=\"love-property\" href=\"cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=home_page\"><i class=\"black-icon\" id=\"like\"></i>".clip($propertyId[$i],$ctaid)."</a>
		<a class=\"report-property\" href=\"#\"><i class=\"black-icon\" id=\"report\"></i>Report this property</a>
		<div class=\"agent-contacts-box\" id=\"y\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a class=\"show-contacts\" id=\"x\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</a>
		</div>
		</div>";
	}
	else if ($ref=='search_page' && isset($_GET['next'])){
		$page .= "<div class=\"like-pane\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span>
		<a class=\"love-property\" href=\"../cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=search_results&next=".$_GET['next']."\"><i class=\"black-icon\" id=\"like\"></i>".clip($propertyId[$i],$ctaid)."</a>
		<a class=\"report-property\" href=\"#\"><i class=\"black-icon\" id=\"report\"></i>Report this property</a>
		<div class=\"agent-contacts-box\" id=\"y\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a class=\"show-contacts\" id=\"x\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</a>
		</div>
		</div>";
	}
	else if ($ref=='search_page' && !isset($_GET['next'])){
		$page .= "<div class=\"like-pane\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span>
		<a class=\"love-property\" href=\"../cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=search_page\"><i class=\"black-icon\" id=\"like\"></i>".clip($propertyId[$i],$ctaid)."</a>
		<a class=\"report-property\" href=\"#\"><i class=\"black-icon\" id=\"report\"></i>Report this property</a>
		<div class=\"agent-contacts-box\" id=\"y\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a class=\"show-contacts\" id=\"x\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</a>
		</div>
		</div>";
	}
	else if ($ref=='match_page' && !isset($_GET['next'])){
		$page .= "<div class=\"like-pane\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span>
		<a class=\"love-property\" href=\"../cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=match_page\"><i class=\"black-icon\" id=\"like\"></i>".clip($propertyId[$i],$ctaid)."</a>
		<a class=\"report-property\" href=\"#\"><i class=\"black-icon\" id=\"report\"></i>Report this property</a>
		<div class=\"agent-contacts-box\" id=\"y\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a class=\"show-contacts\" id=\"x\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</a>
		</div>
		</div>";	
	}
else if ($ref=='profile_page' && !isset($_GET['next'])){
		$page .= "<div class=\"like-pane\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span>
		<a class=\"love-property\" href=\"../cta/c.php?p=$propertyId[$i]&cb=$ctaid&ref=match_page\"><i class=\"black-icon\" id=\"like\"></i>".clip($propertyId[$i],$ctaid)."</a>
		<a class=\"report-property\" href=\"#\"><i class=\"black-icon\" id=\"report\"></i>Report this property</a>
		<div class=\"agent-contacts-box\" id=\"y\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a class=\"show-contacts\" id=\"x\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</a>
		</div>
		</div>";	
	}
}
else{
	$page .= "<div class=\"like-pane\"><strong>status:</strong> <i class=\"black-icon\" id=\"status\"></i> <span style=\"color:green\">Available</span>
		<a class=\"report-property\" href=\"#\"><i class=\"black-icon\" id=\"report\"></i>Report this property</a>
		<div class=\"agent-contacts-box\" id=\"y\">$Bname<ul><li>$officeNo</li><li>$PhoneNo</li><li>$altPhoneNo</li></ul></div>
		<a class=\"show-contacts\" id=\"x\"><i class=\"black-icon\" id=\"contact-agent\"></i>Contact agent</a>
		</div>
		</div>";
}
	print $page;
	$i++;
	if(($i%$maxi)==0){
		break;
	}
}
echo $track;
//[#]this to put all the reference buttons in a box
echo "<div >";
/*calculate number of referer button to be made by dividing the total number of
 records generated by number of 
records to shown on a single page*/

$no_of_button = (int)(($count/$maxi)-1);
//initialize a button counter
$countbutton = 0;
/*create referer  buttons. The referer buttons are created using form with hidden input that takes
 *index to start the page it is refering to as value, when submitted, it loads index.php passing the
 *value along with GET method.*/
 
	while($countbutton<=$no_of_button){
/* $buttonvalue set tag on each refering button, it takes the value returned by pagereferertag()*/
		$buttonvalue = pagereferertag($countbutton,0,($no_of_button));
		
		$goto = $countbutton*$maxi;
		if(isset($_GET['next'])){
			if($countbutton==($_GET['next']/$maxi)){
			$bgcolor = '#6D0AAA';
			$fcolor='white';
		}
		else{
			$bgcolor='#eeeeee';
			$fcolor="#6D0AAA";
		}}else{ $bgcolor = '#eeeeee';$fcolor="#6D0AAA";}
		$action = basename($_SERVER['PHP_SELF']);
		$pagebutton = "<form style=\"display:inline-block\" action=\"$action\" method=\"GET\">
		<input name=\"next\" type=\"hidden\" value=\"$goto\"/>
		<input id=\"page\" style=\"background-color:$bgcolor; color:$fcolor;\"type=\"submit\" value=\"$buttonvalue\"/>
		</form>";
		
		echo $pagebutton;
		$countbutton++;
		}
	echo "<button style=\"display:inline-block;; border:0px\" >page</button>";
	//[#]
	echo "</div>";
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

function checkimage($dir,$imagename,$refpoint){
	/*since this script is required by different pages in different folders, the relative location with the homepage(index) is in the web root, therefore
		url for images is different. $refpoint will only be set in the web index */
	if ($refpoint=="home_page"){
	$imagedirectory = "properties/$dir/";
	}
	else{
	$imagedirectory = "../properties/$dir/";
	}
	
	if(file_exists($imagedirectory.$imagename."_01.png")){
		return $imagedirectory.$imagename."_01.png";
	}
//if the first one is absent...check the second one...
	else if(file_exists($imagedirectory.$imagename."_02.png")){
			return $imagedirectory.$imagename."_02.png";
		}
//..else check the third
		else if(file_exists($imagedirectory.$imagename."_03.png")){
			return $imagedirectory.$imagename."_03.png";
		}
//...else check the fourth
		else if(file_exists($imagedirectory.$imagename."_04.png")){
			return $imagedirectory.$imagename."_04.png";
		}
//if the first, second, third and fourth image is not found, use the default image
		else{
			return $imagedirectory."default.png";;
		}
		
	}
	?>
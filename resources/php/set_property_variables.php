    <?php
    //basic data
    $propertyId = $p['id'];
	$propertydir = $p['dir'];
	$type = $p['type'];
	$location = $p['location'];
	$rent = $p['rent'];
	$min_payment = $p['mp'];
	$bath = $p['bath'];
	$toilet = $p['toilet'];
	$description = $p['description'];
	$views = $p['views'];
	$avail = $p['status'];

    $agent_businessname = $p['agentBussinessName'];
    $agent_username = $p['agentUserName'];
    $agent_office_add = $p['agentOfficeAdd'];
    $agent_office_no = $p['agentOfficeNo'];
    $agent_no = $p['agentNo'];
    $agent_alt_no = $p['agentAltNo'];
    $agent_token = $p['agenttoken'];

    $upload_since = $general->since($p['since']);
    $lastReviewed = $general->since($p['lastReviewed']);
    $lastReviewed = ($lastReviewed=='invalid time' ? "<span style=\"color:red\">Not reviewed yet</span>": 'reviewed '.$lastReviewed);

//computed data
	$OneAndHalf =  $rent + ($rent/2);
	$TwoYears = $rent*2;
	$firstpayment = ($min_payment == '1 year' ? number_format($rent) : ($min_payment == '1 year, 6 months' ? number_format($OneAndHalf) : ($min_payment == '2 years' ? number_format($TwoYears) : '')));
    $short_address = (strlen($location) > 30 ? substr($location,0,29)."...": $location);
    //resources
    //get_images() return an array of available images in a directory, if image(s) are found, get the first one
    $all_images = $general->get_images("properties/$propertydir");
    $front_image = (empty($all_images) ? '' : $all_images[0]);

//set the clipbutton
if($status == 9){
	$clipbutton = $property_obj->clip($propertyId,$ctaid,'home_page');
	$match = (in_array($propertyId,$matches_array) ? "<span class=\"black-icon\" style=\"background-position:-72px -144px\"></span>match":'');
    }
else {
	$clipbutton = "<a class=\"clip-button clip-disabled\"  href=\"$root/cta/checkin.php?_rdr=1\"><span class=\"black-icon not-allowed-icon\"></span>clip</a>";
    $match = '';
}

//set the review link
if($status == 1 && $Business_Name == $agent_businessname){
	$review = "<a class=\"review-link\" href=\"$root/manage/property.php?id=$propertyId&action=change&agent=$agent_token\"><span class=\"black-icon edit-icon\"></span></a>";
}	
else{
	$review ="";
}

//set availability
$availability = ($avail == 'available'? "<span class=\"available-property\">Available</span>":"<span class=\"unavailable-property\">Not Available</span>");

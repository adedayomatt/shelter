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
	$display_photo = $p['dp'];

    $agent_businessname = $p['agentBussinessName'];
    $agent_username = $p['agentUserName'];
    $agent_office_add = $p['agentOfficeAdd'];
    $agent_office_no = $p['agentOfficeNo'];
    $agent_no = $p['agentNo'];
    $agent_alt_no = $p['agentAltNo'];
    $agent_token = $p['agenttoken'];

    $upload_since = $general->since($p['since']);
    $lastReviewed = $general->since($p['lastReviewed']);

//if displaying properties from the home page or any other page
if(isset($ref) && $ref == 'home_page'){
		$property_route ='properties/';
        $anchor = '#recentuploads';
	}
	else{
		$property_route ='../properties/';	
		$anchor = '';
	}
//computed data
	$OneAndHalf =  $rent + ($rent/2);
	$TwoYears = $rent*2;
	$firstpayment = ($min_payment == '1 year' ? number_format($rent) : ($min_payment == '1 year, 6 months' ? number_format($OneAndHalf) : ($min_payment == '2 years' ? number_format($TwoYears) : '')));
    $short_address = (strlen($location) > 30 ? substr($location,0,20)."...".substr($location,strlen($location)-10,strlen($location)): $location);
    
	
	//resources
$all_images = $general->get_images($property_route.$propertydir);
$totalAvailableImage = count($all_images);
$front_image = $property_obj->get_property_dp($property_route.$propertydir,$display_photo);

//set the clipbutton
if($status == 9){
	$clipbutton = $property_obj->clip($propertyId,$ctaid,$ref,$client_token);
	$match = (in_array($propertyId,$matches_array) ? "<span class=\"glyphicon glyphicon-link site-color\"></span>":'');
    }
else {
	$clipbutton = $property_obj->clip($propertyId,null,$ref,null);
	$match = '';
}

//set the review link
if($status == 1 && $Business_Name == $agent_businessname){
	$review = "<a title=\"change this property details\" href=\"$root/manage/property.php?id=$propertyId&action=change&agent=$agent_token\"><span class=\"glyphicon glyphicon-edit site-color\"></span>edit</a>";
}	
else{
	$review ="";
}

//set availability
$availability = ($avail == 'Available'? "<span title=\"This property is available\" class=\"green\"><span class=\"glyphicon glyphicon-check\"></span>Available</span>":"<span title=\"This property has been leased out\" class=\"red\"><span class=\"glyphicon glyphicon-remove\"></span>Not Available</span>");

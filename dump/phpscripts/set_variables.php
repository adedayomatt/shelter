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
    $all_images = $general->get_images('properties/'.$propertydir);
    $front_image = (empty($all_images) ? '' : $all_images[0]);

//set the clipbutton
if($client->check_status()=='active'){
    $clipbutton_id = $id.'clipbtton';
    $ctaid = $client->get_ctaProfile()['ctaid'];
	$clipbutton = "<a  class=\"options\"  href=\"$root/cta/c.php?p=$id&cb=$ctaid&ref=$page\" id=\"$clipbutton_id\" onclick=\"makeclip('$clipbutton_id',$ctaid,'$page')\"><span class=\"black-icon clip-icon\"></span>".clip($propertyId[$i],$ctaid)."</a>";
	$match = (in_array($propertyId,$client->get_matches()) ? "<span class=\"black-icon\" style=\"background-position:-72px -144px\"></span>match":'');
    }
else {
	$clipbutton = "<a class=\"options disabled\"  href=\"$root/cta/checkin.php?_rdr=1\"><span class=\"black-icon clip-icon\"></span>clip</a>";
    $match = '';
}

//set the review link
if($agent->check_status()=='active' && $agent->get_agentProfile()['Business_Name']==$agent_businessname){
	$review = "<a class=\"review-link\" href=\"$root/manage/property.php?id=$id&action=change\"><span class=\"black-icon edit-icon\"></span></a>";
}	
else{
	$review ="";
}

//set availability
$availability = ($avail == 'available'? "<span class=\"available-property\">Available</span>":"<span class=\"unavailable-property\">Not Available</span>");
?>
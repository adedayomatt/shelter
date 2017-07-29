<?php 
/*
**This script is placed seperately and not in the in the header because it get vital information that determine what
**each page renders. User status is checked in this script and therefore must be required before header.php but
**immediately after masterScript.php incase the requiring script need to send header
*/

//get agent details if logged in
if($agent->check_status()=='active'){
	$status = 1;

	$agent_details = $agent->get_agentProfile();

	$profile_name = $agent_details['User_ID'];
	$Business_Name = $agent_details['Business_Name'];
	$agent_token = $agent_details['token'];

	$messages = $agent_details['messages'];
	$notifications = $agent_details['notifications'];
	$followings = $agent_details['followings'];
	$client_followers = $agent_details['c_followers'];
	$agent_followers = $agent_details['a_followers'];
	
	$user = $profile_name;

}


//get Client details
else if($client->check_status()=='active'){
	$status = 9;
	$cta_details = $client->get_ctaProfile();

$cta_name = $cta_details['ctaname'];
$expiry_date = date('D, d M Y ',$cta_details['expiryTime']);
$seconds_before_expiry = $cta_details['seconds_left'];
$hours_before_expiry = round($seconds_before_expiry/3600);
$days_before_expiry = round($seconds_before_expiry/86400);

$request_status = $cta_details['request'];
$messages = $cta_details['messages'];
$notifications = $cta_details['notifications'];
$followings = $cta_details['followings'];
$matches = count($client_obj->get_matches());
$clipped = count($client_obj->get_clipped());

$user = $cta_name;
}
else{
	$status = 0;
	$user = "visitor";
}
echo $user. " is currently active";

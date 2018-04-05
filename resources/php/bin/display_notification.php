<?php
function display_notification($nid,$subject,$subjecttrace,$subjectid,$receiverid,$action,$link,$timestamp,$howold,$status){
	//This objects are in master_script.php
	GLOBAL $db;
	GLOBAL $general;
	GLOBAL $client;
	GLOBAL $root;
	GLOBAL $doc_root;
	GLOBAL $property_obj;

	$time = time() - $timestamp;
if($howold=="yesterday"){
	$since = "Yesterday at ".date('h:i a ',$timestamp);
}
else{
$since = $general->since($timestamp);
}
$seenORunseen = ($status == 'unseen' ? 'f7-background' : 'white-background');
//update the notification as seen
//one of these two queries will update whichever notification it is
$db->query_object("UPDATE client_notifications SET status = 'seen' WHERE notificationid=$nid");
$db->query_object("UPDATE agent_notifications SET status = 'seen' WHERE notificationid=$nid");	
	switch($action){
	//if it is a client following an agent, specify the client need
		case 'C4A':
		$requests = $client->get_request($subjectid,$subject);
		$client_profile = $db->query_object("SELECT ID,Business_Name,User_ID,token FROM profiles where ID=$receiverid");
		$c = $client_profile->fetch_array(MYSQLI_ASSOC);
		$agentId = $c['ID'];
		$agentBN = $c['Business_Name'];
		$agentUN = $c['User_ID'];
		$agentToken = $c['token'];
		if(!empty($requests)){
			$reqtype = $requests['type'] ;
			$reqmaxprice =$requests['maxprice'];
			$reqlocation = $requests['location'];
			$xtra = "<p class=\"grey text-center\">This client requested for <strong>$reqtype</strong> with rent not more than <strong>N".number_format($reqmaxprice)."</strong> around <strong>$reqlocation</strong> <br/>
					".$property_obj->suggestProperty($agentId,$agentBN,$agentUN,$agentToken,$subject,$subjectid)."</p>";
					
		}
		else{
			$xtra="<p class=\"grey text-center\">This client has no specific preference <br/>
					|".$property_obj->suggestProperty($agentId,$agentBN,$agentUN,$agentToken,$subject,$subjectid)."</p>";
		}
		return "<div class=\"$seenORunseen padding-5 e3-border notice\">
					+<span class=\"glyphicon glyphicon-user\"></span>A client <a href=\"$root/cta/ctarequests/?target=$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"grey font-12 text-right\">$since</p>
					 <div class=\"margin-5 padding-5 e3-border f7-background border-radius-3\">$xtra</div>
					 </div>";
		break;
		
		case 'A4A':
		return "<div class=\"$seenORunseen padding-5 e3-border notice\">
					+<span class=\"glyphicon glyphicon-briefcase\" ></span>An agent <a href=\"$root/$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"grey font-12 text-right\">$since</p>
						</div>";
		break;
		
case 'PSG':
$gettheproperty = $db->query_object("SELECT directory,type,rent,location,display_photo FROM properties WHERE directory = '$link'");
if($gettheproperty->num_rows == 0){
	$property_brief = "<div class=\"padding-10 red e3-border border-radius-3\">This property no longer exist</div>";
}
else{
$property = $gettheproperty->fetch_array(MYSQLI_ASSOC);
	$property_dp = $property_obj->get_property_dp('../properties/'.$property['directory'],$property['display_photo']);

	$property_brief = "<div class=\"row\">
						<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6 \">
						<img src=\"$property_dp\" class=\"margin-2 mini-property-photo\"/>
						</div>
						<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6 padding-10 text-left\">
						<div class=\"row\" style=\"line-height:25px\">
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">".$property['type']."</span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">Rent: <strong>N ".number_format($property['rent'])."</strong></span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"><span class=\"glyphicon glyphicon-map-marker\"></span>".$property['location']."</span>
						</div>
						<a href=\"$root/properties/$link\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-eye-open\"></span>see details</a>
						</div>
						</div>";
}
		return "<div class=\"$seenORunseen padding-5 e3-border notice\">
					+<span class=\"glyphicon glyphicon-briefcase\" ></span><a href=\"$root/$subjecttrace\">".$subject."</a> suggested a property
						<div class=\"grey width-90p margin-auto text-center\">$property_brief</div>
					<p class=\"grey font-12 text-right\">$since</p>
						</div>";
		break;
		case 'CTA created':
		return "<div class=\"$seenORunseen padding-5 notice\">
					+<span class=\"glyphicon glyphicon-file-open\"></span>You created your CTA as $subject
					 <p class=\"grey font-12 text-right\">$since</p>
						</div>";
		break;
		case '':
		break;
case 'RVN':
$property_detail = $db->query_object("SELECT properties.property_ID AS property_id,properties.directory AS property_dir,properties.type AS property_type,properties.rent AS property_rent,properties.location AS property_loc,properties.display_photo AS dp, properties.timestamp AS property_timestamp,profiles.token AS agent_token FROM properties LEFT JOIN profiles ON (properties.uploadby = profiles.User_ID) WHERE properties.directory = '$link'");
$p = $property_detail->fetch_array(MYSQLI_ASSOC);
$property_id = $p['property_id'];
$property_dir = $p['property_dir'];
$property_type = $p['property_type'];
$property_rent = $p['property_rent'];
$property_loc = $p['property_loc'];
$property_ts = $p['property_timestamp'];
$agent_token = $p['agent_token'];

	$property_dp = $property_obj->get_property_dp('../properties/'.$property_dir,$p['dp']);
	$property_brief = "<div class=\"row grey\">
						<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">
						<img src=\"$property_dp\" class=\"mini-property-photo margin-2\"/>
						</div>
						<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left padding-10\">
						<div class=\"row\" style=\"line-height:25px\">
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">$property_type</span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">Rent: <strong>N ".number_format($property_rent)."</strong></span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"><span class=\"glyphicon glyphicon-map-marker\"></span>$property_loc</span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"><span class=\"glyphicon glyphicon-upload\"></span>uploaded ".$general->since($property_ts)."</span>
						</div>
						<a href=\"$root/properties/$property_dir\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-eye-open\"></span>see details</a>
						</div>
						</div>";

return "<div class=\"$seenORunseen padding-5 e3-border notice\">
					+<span class=\"glyphicon glyphicon-pencil\" ></span> A property needs to be reviewed
					<p class=\"grey text-left font-12\">Confirm if this property is still available</p>
					$property_brief
					<a class=\"btn red-background white\"href=\"$root/manage/property.php?id=$property_id&action=change&agent=$agent_token\"><span class=\"glyphicon glyphicon-edit\"></span>Review now</a>
					 <p class=\"grey font-12 text-right\">$since</p>
					 <a href=\"\" class=\"font-10\"><span class=\"glyphicon glyphicon-question-sign\"></span>why am i getting this notification?</a>
						</div>";
						break;
	}
	

}
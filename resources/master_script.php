<?php
require('mato/lib/php/global.php');
$db = new database();

class agent{
	public $id = 0;
	public $business_name = "";
	public $username = "";
	public $address = "";
	public $token = "";
	public $last_seen = 0;
	public $office_contact = "";
	public $contact1 = 0;
	public $contact2 = 0;
	public $business_mail = "";
	public $CEO = "";
	public $CEO_mail = "";
	public $registration_timestamp = 0;
	
	function __construct($agentId){
		GLOBAL $db;
		$getAgent = $db->query_object("SELECT * FROM profiles WHERE ID = $agentId");
		if($getAgent->num_rows == 1){
			$agent = $getAgent->fetch_array(MYSQLI_ASSOC);
			$this->id = $agentId;
			$this->business_name = $agent['Business_Name'];
			$this->username = $agent['User_ID'];
			$this->token = $agent['token'];
			$this->last_seen = $agent['last_seen'];
			$this->address = $agent['Office_Address'];
			$this->office_contact = $agent['Office_Tel_No'];
			$this->contact1 = $agent['Phone_No'];
			$this->contact2 = $agent['Alt_Phone_No'];
			$this->business_mail = $agent['Business_email'];
			$this->CEO = $agent['CEO_Name'];
			$this->CEO_mail = $agent['email'];
			$this->registration_timestamp = $agent['timestamp'];
		}
	}
	
	public function all_notifications(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$notifications = array();
		$i = 0;
		$getNotifications = $db->query_object("SELECT notificationid FROM agent_notifications WHERE (receiver_id = $my_id)");
		while($n = $getNotifications->fetch_array(MYSQLI_ASSOC)){
			$notifications[$i]['notification_id'] = $n['notificationid'];
			$i++;
		}
		$getNotifications->free();
		return $notifications;
	}
	
	public function unseen_notifications(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$notifications = array();
		$getNotifications = $db->query_object("SELECT notificationid FROM agent_notifications WHERE (receiver_id = $my_id AND  status='unseen')");
		while($n = $getNotifications->fetch_array(MYSQLI_ASSOC)){
			$notifications[] = $n['notificationid'];
		}
		$getNotifications->free();
		return $notifications;
	}
	
	public function messages(){
		$messages = array();
		return $messages;
	}

	function obsolete_properties(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$properties = array();
		$getObsoleteProperties = $db->query_object("SELECT notificationid,link FROM agent_notifications WHERE (receiver_id = $my_id AND action='RVN' AND timestamp>$last_seen)");
		while($p = $getObsoleteProperties->fetch_array(MYSQLI_ASSOC)){
			$properties[$i] = $p['link'];
		}
		$getObsoleteProperties->free();
		return $properties;
	}
	
	function client_requests_since_last_seen(){
		GLOBAL $db;
		$last_seen = $this->last_seen;
		$requests = array();
		$getRequest = $db->query_object("SELECT ctaid FROM cta_request WHERE (timestamp>$last_seen)");
		while($r = $getRequest->fetch_array(MYSQLI_ASSOC)){
			$requests[] = $r['ctaid'];
		}
		$getRequest->free();
		return $requests;
	}
	
	function client_followers_since_last_seen(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$clients = array();
		$getClient = $db->query_object("SELECT client_id FROM client_agent_follow WHERE (agent_id = $my_id AND timestamp>$last_seen)");
		while($c = $getClient->fetch_array(MYSQLI_ASSOC)){
			$client[] = $c['client_id'];
		}
		$getClient->free();
		return $clients;
	}
	function agent_followers_since_last_seen(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$agents = array();
		$getAgent = $db->query_object("SELECT agent_follower_id FROM agent_agent_follow WHERE (agent_following_id = $my_id AND timestamp>$last_seen)");
		while($a = $getAgent->fetch_array(MYSQLI_ASSOC)){
			$agents[] = $a['agent_follower_id'];
		}
		$getAgent->free();
		return $agents;
	}
	function notifications_since_last_seen(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$notifications = array();
		$getNotifications = $db->query_object("SELECT notificationid FROM agent_notifications WHERE (receiver_id = $my_id AND timestamp>$last_seen AND status='unseen')");
		while($n = $getNotifications->fetch_array(MYSQLI_ASSOC)){
			$notifications[] = $n['notificationid'];
		}
		$getNotifications->free();
		return $notifications;
	}
	
	
	
	public function longTimeWelcome(){
	$msg = "<div class=\"header\">
				<h2 class=\"text-center\">Welcome Back ".$this->business_name."</h2>
			</div>
			<div class=\"body\">
				<p>It's been a while you are here, Check out some updates since you last visited:</p>
				<h4>Clients Requests : <span>".count($this->client_requests_since_last_seen())."</span></h4>
				<h4>New Client Followers : <span>".count($this->client_followers_since_last_seen())."</span></h4>
				<h4>New Agent Followers: <span>".count($this->agent_followers_since_last_seen())."</span></h4>
				<strong><span class=\"glyphicon glyphicon-bell icon-size-40\"></span>  ".count($this->notifications_since_last_seen())."</strong> notifications, ".count($this->unseen_notifications())." total unseen Notifications ".(count($this->obsolete_properties()) >= 1 ? "including <strong>".count($this->obsolete_properties())."</strong> properties waiting for updates" : "")."
				<h4 style=\"color:blue; font-weight:bold\" class=\"text-center\"><span style=\"color:red; font-size:300%;\" class=\"animate bounce\"><i>?</i></span>WHAT WOULD YOU LIKE TO DO NOW?</h4>
				<div class=\"width-70p margin-auto\">
					<a href=\"upload\" class=\"btn btn-block btn-primary\">Upload Property</a>
					<a href=\"manage\" class=\"btn btn-block btn-primary\">Manage properties</a>
					<a href=\"clients\" class=\"btn btn-block btn-primary\">Suggest Property</a>
					<a href=\"search\" class=\"btn btn-block btn-primary\">Search for Property</a>
				</div>
			</div>";

	return $msg;

}		

	public function uploads(){
		GLOBAL $db;
		$my_username = $this->username;
		$uploads = array();
		$getUploads = $db->query_object("SELECT property_ID FROM  properties WHERE (uploadby = '$my_username')");
		while($u = $getUploads->fetch_array(MYSQLI_ASSOC)){
			$uploads[] = $u['property_ID'];
		}
		$getUploads->free();
		return $uploads;
	}
	
public function recent_uploads($from,$how_many){
	GLOBAL $db;
		$recent_upload_ids = array();
		$getRU = $db->query_object("SELECT property_ID FROM properties WHERE uploadby='".$this->username."' ORDER BY timestamp DESC LIMIT $from,$how_many");
		while($property = $getRU->fetch_array(MYSQLI_ASSOC)){
			$recent_upload_ids[] = $property['property_ID'];
		}
		$getRU->free();
		return $recent_upload_ids;
	}
	public function neighborhood_agents($how_many){
	GLOBAL $db;
	$neighborhood_agents = array();
	$getNA = $db->query_object("SELECT ID FROM profiles WHERE(ID !=".$this->id." AND Office_Address LIKE '%".$this->address."%') LIMIT $how_many");
	while($a = $getNA->fetch_array(MYSQLI_ASSOC) ){
		$neighborhood_agents[] = $a['ID'];
			}
			return $neighborhood_agents;
	}

	public function other_agents($how_many){
	GLOBAL $db;
	$other_agents = array();
	$i=0;
	$start = rand(0,10);
	$getOA = $db->query_object("SELECT ID FROM profiles WHERE(ID !=".$this->id.") LIMIT $start,$how_many");
	while($a = $getOA->fetch_array(MYSQLI_ASSOC) ){
		$other_agents[] = $a['ID'];
			}
			return $other_agents;
	}

	public function agent_followers(){
		 GLOBAL $db;
		 $my_id = $this->id;
		 $followers = array();
		$agentfollower = $db->query_object("SELECT agent_follower_id FROM agent_agent_follow WHERE agent_following_id= $my_id");
		while($f = $agentfollower->fetch_array(MYSQLI_ASSOC)){
			$follower_ids[] = $f['agent_follower_id'];
		}	
		$agentfollower->free();
		return $followers;
	}
	
	public function client_followers(){
		 GLOBAL $db;
		 $my_id = $this->id;
		 $followers = array();
		$clientfollower = $db->query_object("SELECT client_id FROM client_agent_follow WHERE agent_id= $my_id ");
		while($f = $clientfollower->fetch_array(MYSQLI_ASSOC)){
			$followers[] = $f['client_id'];
		}	
		$clientfollower->free();
		return $followers;
	}
	

	public function followings(){
		 GLOBAL $db;
		 $my_id = $this->id;
		 $followings = array();
		$getfollowings = $db->query_object("SELECT agent_following_id FROM agent_agent_follow WHERE agent_follower_id= $my_id");
		while($f = $getfollowings->fetch_array(MYSQLI_ASSOC)){
			$followings[] = $f['agent_following_id'];
		}	
		$getfollowings->free();
		return $followings;
	}
	
	public function follow_button($followerId, $follower_name,$follower_username,$type){
		$followingId = $this->id;
		$following_name = $this->business_name;
		$following_username = $this->username;
		
        GLOBAL $db;
		$get_follow = null;
		$get_follow_query = "";
		
		if($follower_username==null && $type=='C4A'){//client
			$get_follow_query = "SELECT * FROM client_agent_follow WHERE (client_id = $followerId AND agent_id = $followingId)";
		}
		else if($type=='A4A'){//agent
			$get_follow_query = "SELECT * FROM agent_agent_follow WHERE (agent_follower_id = $followerId AND agent_following_id = $followingId)";
		}
		else{//visitor
			 $follow_button = "
							<span>
								<button class=\"follow-button\" data-action=\"follow\" data-flwerId=\"nil\" data-flwerName=\"nil\" data-flwerUname=\"nil\" data-flwingId=\"nil\" data-flwingName=\"$following_name\" data-flwingUname=\"nil\" data-ftype=\"nil\"><span class=\"glyphicon glyphicon-plus-sign\"></span>follow</button>
							</span>";
		return $follow_button;
		}
		
    $get_follow = $db->query_object($get_follow_query);
     
	if($get_follow->num_rows == 1){
		$unfollow_button = "
						<span>
							<button class=\"unfollow-button\" data-action=\"follow\" data-flwerId=\"$followerId\" data-flwerName=\"$follower_name\" data-flwerUname=\"$follower_username\" data-flwingId=\"$followingId\" data-flwingName=\"$following_name\" data-flwingUname=\"$following_username\" data-ftype=\"$type\"><span class=\"glyphicon glyphicon-minus-sign\"></span>unfollow</button>
						</span>";
        return $unfollow_button;
     }
     else{
		$follow_button = "
						<span>
							<button class=\"follow-button\" data-action=\"follow\" data-flwerId=\"$followerId\" data-flwerName=\"$follower_name\" data-flwerUname=\"$follower_username\" data-flwingId=\"$followingId\" data-flwingName=\"$following_name\" data-flwingUname=\"$following_username\" data-ftype=\"$type\"><span class=\"glyphicon glyphicon-plus-sign\"></span>follow</button>
						</span>" ;
         return $follow_button;
        }
	}

	public function update_business_info($new_address,$new_office_contact,$new_business_mail){
		GLOBAL $db;
		if(!is_numeric($new_office_contact)){
		return 99;
	}
	else{
	$db->query_object("UPDATE profiles SET Office_Address = '$new_address', Office_Tel_No=$new_office_contact, Business_email='$new_business_mail' WHERE (ID = ".$this->id." AND token = '".$this->token."')");
if($db->connection->affected_rows == 1){
	return 100;
}
else{
	return 900;
}
	}
	}

	public function update_personal_info($new_manager_name,$new_contact1,$new_contact2,$new_mail){
		GLOBAL $db;
		if(!is_numeric($new_contact1) || !is_numeric($new_contact2)){
		return 99;
	}
	else{
	$db->query_object("UPDATE profiles SET CEO_Name='$new_manager_name', Phone_No= $new_contact1, Alt_Phone_No= $new_contact2, email='$new_mail'  WHERE (ID = ".$this->id." AND token = '".$this->token."')");
if($db->connection->affected_rows == 1){
	return 100;
}
else{
	return 900;
		}
	}
}

	public function change_password($old_password,$new_password1,$new_password2){
		GLOBAL $db;
if($db->query_object("SELECT password FROM profiles WHERE ID = ".$this->id." AND token = '".$this->token."'")->fetch_array(MYSQLI_ASSOC)['password'] == $old_password){
		if($new_password1 == $new_password2){
		$db->query_object("UPDATE profiles SET password = '$new_password2' WHERE (ID = ".$this->id." AND token = '".$this->token."')");
			if($db->connection->affected_rows == 1){
				return 100;
			}
			else{
				return 900;
			}
		}
		else{
			return 69;
		}
	}
	else{
return 99;
	}
}

	public function update_last_seen(){
		GLOBAL $db;
		$now = time();
		$update_last_seen = $db->query_object("UPDATE profiles SET last_seen = $now WHERE  token='".$this->token."' ");
		if($db->connection->affected_rows == 1){
			echo "<pre> @".$this->username." last seen updated</pre>";
		}
		else{
			echo "<pre>@".$this->username." last seen update failed</pre>";
		}
	}
	
}

class client{
	public $id = 0;
	public $name = "";
	public $status = "";
	public $token = "";
	public $request_type = "";
	public $request_maxprice = 0;
	public $request_area = "";
	public $request_city = "";
	public $request_time = 0;
	public $last_seen = 0;
	public $expiry_timestamp = 0;
	public $seconds_before_expiry = 0;

	function __construct($clientId){
		GLOBAL $db;
		$getClient = $db->query_object("SELECT * FROM cta WHERE ctaid = $clientId");
		if($getClient->num_rows == 1){
			$client = $getClient->fetch_array(MYSQLI_ASSOC);
			$this->id = $client['ctaid'];
			$this->name = $client['name'];
			$this->last_seen = $client['last_seen'];
			$this->token = $client['token'];
			$this->status = ($client['expiryTimestamp'] > time() ? 'expired' : 'active');
			$this->expiry_date = date('d, m, y',$client['expiryTimestamp']);
			$this->expiry_timestamp = $client['expiryTimestamp'];
			$this->seconds_before_expiry = $client['expiryTimestamp'] - time();

			$getRequest = $db->query_object("SELECT * FROM cta_request WHERE ctaid = $clientId");
			if($getRequest->num_rows == 1){
				$request = $getRequest->fetch_array(MYSQLI_ASSOC);
				$this->request_type = $request['type'];
				$this->request_maxprice = $request['maxprice'];
				$this->request_area = $request['area'];
				$this->request_city = $request['city'];
				$this->request_time = $request['timestamp'];
			}
			$getClient->free();
			$getRequest->free();
		}
				
	}

	
	public function all_notifications(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$notifications = array();
		$i = 0;
		$getNotifications = $db->query_object("SELECT notificationid FROM client_notifications WHERE (receiver_id = $my_id)");
		while($n = $getNotifications->fetch_array(MYSQLI_ASSOC)){
			$notifications[$i]['notification_id'] = $n['notificationid'];
			$i++;
		}
		$getNotifications->free();
		return $notifications;
	}
	
	public function unseen_notifications(){
		GLOBAL $db;
		$my_id = $this->id;
		$last_seen = $this->last_seen;
		$notifications = array();
		$i = 0;
		$getNotifications = $db->query_object("SELECT notificationid FROM client_notifications WHERE (receiver_id = $my_id AND  status='unseen')");
		while($n = $getNotifications->fetch_array(MYSQLI_ASSOC)){
			$notifications[$i]['notification_id'] = $n['notificationid'];
			$i++;
		}
		$getNotifications->free();
		return $notifications;
	}
	
	public function followings(){
		 GLOBAL $db;
		 $id = $this->id;
		 $followings = array();
		 $i = 0;
		$getFollowings = $db->query_object("SELECT agent_id FROM client_agent_follow WHERE client_id= $id");
		while($f = $getFollowings->fetch_array(MYSQLI_ASSOC)){
			$followings[$i]['agent_id'] = $f['agent_id'];
			$i++;
		}	
		$getFollowings->free();
		return $followings;
	}
	
	
	public function matches(){
		GLOBAL $db;
		$matches = array();
		if($this->request_type != "" && $this->request_maxprice != 0 && $this->request_area != "" && $this->request_city != ""){
			//if there is request made yet
			$type = $this->request_type;
			$maxprice = $this->request_maxprice;
			$area = $this->request_area;
			$city = $this->request_city;
			$getCTAmatches = $db->query_object("SELECT property_ID FROM properties WHERE (type='$type' AND rent<=$maxprice AND area LIKE '%$area%' AND city LIKE '%$city%')");
			while($m = $getCTAmatches->fetch_array(MYSQLI_ASSOC)){
				$matches[] = $m['property_ID'];
			}
			$getCTAmatches->free();
		}
		return $matches;
	}
	
	public function clips(){
		GLOBAL $db;
		$my_id = $this->id;
		$clips = array();
		$getClipped = $db->query_object("SELECT propertyid FROM clipped WHERE (clippedby = $my_id)");
		while($c = $getClipped->fetch_array(MYSQLI_ASSOC)){
			$clips[] = $c['propertyid'];
		}
			$getClipped->free();
		return $clips;
	}
	
	public function suggestions(){
		GLOBAL $db;
		$ctaid = $this->id;
		$suggestions = array();
		$getSuggestions = $db->query_object("SELECT property_id FROM property_suggestion WHERE (client_id = $ctaid)");
		while($s  = $getSuggestions->fetch_array(MYSQLI_ASSOC)){
			$suggestions[] = $s['property_id'];
		}
		$getSuggestions->free();
		return $suggestions;
	}

	public function messages(){
		$messages = array();
		return $messages;
	}

	public function suggestions_since_last_since(){
		GLOBAL $db;
		$ctaid = $this->id;
		$suggestions = array();
		$i = 0;
		$getSuggestions = $db->query_object("SELECT property_id FROM property_suggestion WHERE (client_id = $ctaid AND timestamp > $last_seen)");
		while($s  = $getSuggestions->fetch_array(MYSQLI_ASSOC)){
			$suggestions[$i]['property_id'] = $s['property_id'];
			$i++;
		}
		$geSuggestions->free();
		return $suggestions;
	}
	public function new_cta_request($type,$maxprice,$location,$area,$city){
		GLOBAL $db;
		$query = "INSERT INTO cta_request (ctaid,ctaname,type,maxprice,area,city,timestamp) VALUES (?,?,?,?,?,?,?)";
		$p_query = $db->prepare_statement($query);
		$p_query->bind_param('issisi',$param_ctaid,$param_ctaname,$param_type,$param_maxprice,$param_area,$param_city,$param_time);

		if($maxprice != ""  && is_numeric($_POST['maxprice']) && $_POST['type'] != "" && $_POST['area']  != "" && $_POST['city']  != ""){
		$param_ctaid = $this->id;
		$param_ctaname = $this->name;
		$param_type = $type;
		$param_maxprice = $maxprice;
		$param_area = $db->connection->real_escape_string(htmlentities(trim($area)));
		$param_city = $db->connection->real_escape_string(htmlentities(trim($city)));
		$param_time = time();
		$p_query->execute();
		if($p_query->affected_rows ==1){
			$updatecta = $db->query_object("UPDATE cta SET request=1 WHERE ctaid=".$this->id."");
	//if request placing is successful and updating of cta
	return 100;
		}
	else{
			return 900;
			}
		}
		else{
			return 99;
		}
	}
	public function update_cta_request($new_type,$new_maxprice,$new_area,$new_city){
		GLOBAL $db;
	if($new_maxprice != "" && is_numeric($new_maxprice) && $new_type != "" && $new_area != "" && $new_city != ""){
	
		$param_ctaid = $this->id;
		$param_type = ($new_type == 'nil' ? $this->request_type : $new_type);
		$param_maxprice = $new_maxprice;
		$param_area = $db->connection->real_escape_string(htmlentities(trim($new_area)));
		$param_city = $db->connection->real_escape_string(htmlentities(trim($new_city)));

		
	$change_request = $db->query_object("UPDATE cta_request SET type='$param_type',maxprice=$param_maxprice,area='$param_area',city='$new_city' WHERE ctaid=$param_ctaid");

//if request changing is successful
 	if($db->connection->affected_rows == 1){
		return 100;
	}
	else{
		return 800;
	}
}
else{//invalid inputs
return 99;		}
	}
	public function update_last_seen(){
		GLOBAL $db;
		$now = time();
		$update_last_seen = $db->query_object("UPDATE cta SET last_seen = $now WHERE  token='".$this->token."' ");
		if($db->connection->affected_rows == 1){
			echo "<pre> @".$this->name." last seen updated</pre>";
		}
		else{
			echo "<pre>@".$this->name." last seen update failed</pre>";
		}
	}

}

class cta_request{
	public $ctaid = 0;
	public $ctaname = "";
	public $type = "";
	public $maxprice = 0;
	public $location = "";
	public $request_timestamp = 0;

	function __construct($ctaid){
		GLOBAL $db;
		$get_request = $db->query_object("SELECT cta.name AS client_name,cta.ctaid AS client_id, cta_request.*,CONCAT(cta_request.area,', ',cta_request.city) AS location,cta_request.timestamp AS r_timestamp FROM cta LEFT JOIN cta_request USING(ctaid) WHERE ctaid = $ctaid");
		$request = $get_request->fetch_array(MYSQLI_ASSOC);
		$this->ctaid = $request['client_id'];
		$this->ctaname = $request['client_name'];
		$this->type = $request['type'];
		$this->maxprice = $request['maxprice'];
		$this->location = $request['location'];
		$this->request_timestamp = $request['r_timestamp'];
	}

	public function suggest_property_button($agent_id,$agent_business_name,$agent_username,$agent_token){
		GLOBAL $db;
		$suggestion_button = "<button class=\"btn btn-primary\" data-action=\"suggest-property\"data-agent-id=\"$agent_id\" data-agent-business-name=\"$agent_business_name\" data-agent-username=\"$agent_username\" data-agent-token=\"$agent_token\" data-client-name=\"".$this->ctaname."\" data-client-id=\"".$this->ctaid."\">Suggest Property</button>";
		return $suggestion_button;
	}

}


class property extends tools{
	public $id =  "";
	public $p_directory = "";
	public $type = "";
	public $area = "";
	public $city = "";
	public $location = "";
	public $rent = "";
	public $min_payment = "";
	public $bath = 0;
	public $loo = 0;
	public $pmachine = "";
	public $borehole = "";
	public $well = "";
	public $tiles = "";
	public $parking_space = "";
	public $electricity = 0;
	public $road = 0;
	public $social = 0;
	public $security = 0;
	public $description = "";
	public $uploadTimestamp = 0;
	public $views = 0;	
	public $last_reviewed = 0;
	public $status = "";	
	public $display_photo = "";
	public $url = "";
	
	public $agent_business_name = "";
	public $agent_username = "";
	public $agent_address = "";
	public $agent_office_contact = 0;
	public $agent_contact1 = 0;
	public $agent_contact2 = 0;
	public $agent_business_mail = "";
	public $agent_id = 0;
	public $agent_token = "";

	function __construct($pid){
		GLOBAL $db;
		$property_query = 	"SELECT properties.*,profiles.*,
							CONCAT(properties.area,', ',properties.city) AS location,
							properties.timestamp AS property_timestamp 
							FROM properties INNER JOIN profiles ON (properties.uploadby = profiles.User_ID) 
							WHERE (property_ID='".$pid."')";
							
		$getProperty = $db->query_object($property_query);
		if($getProperty->num_rows == 1){
			while($detail = $getProperty->fetch_array(MYSQLI_ASSOC)){
				$this->id =  $detail['property_ID'];
				$this->p_directory = $detail['directory'];
				$this->type = $detail['type'];
				$this->area = $detail['area'];
				$this->city = $detail['city'];
				$this->location =$detail['location'];
				$this->rent = $detail['rent'];
				$this->min_payment = $detail['min_payment'];
				$this->bath = $detail['bath'];
				$this->loo = $detail['toilet'];
				$this->pmachine = $detail['pumping_machine'];
				$this->borehole = $detail['borehole'];
				$this->well = $detail['well'];
				$this->tiles = $detail['tiles'];
				$this->parking_space = $detail['parking_space'];
				$this->electricity = $detail['electricity'];
				$this->road = $detail['road'];
				$this->social = $detail['socialization'];
				$this->security = $detail['security'];
				$this->description = $detail['description'];
				$this->upload_timestamp = $detail['property_timestamp'];
				$this->views = $detail['views'];	
				$this->last_reviewed = $detail['last_reviewed'];
				$this->status = $detail['status'];	
				$this->display_photo = $detail['display_photo'];
				$this->url = "properties/".$detail['directory'];

				$this->agent_business_name = $detail['Business_Name'];
				$this->agent_username = $detail['User_ID'];
				$this->agent_address = $detail['Office_Address'];
				$this->agent_office_contact = $detail['Office_Tel_No'];
				$this->agent_business_mail = $detail['Business_email'];
				$this->agent_contact1 = $detail['Phone_No'];
				$this->agent_contact2 = $detail['Alt_Phone_No'];
				$this->agent_id  = $detail['ID'];
				$this->agent_token  = $detail['token'];
				
			}
		}

	}
	public function property_exist(){
		return ($this->id == "" ? false : true);
	}
	public function update_last_updated(){
		GLOBAL $db;
		$db->query_object("UPDATE properties SET last_reviewed = ".time()." WHERE property_ID= '".$this->id."'");
	}
	public function clip_button($client,$client_token,$ref_page){
		GLOBAL $db;
		
		if($client == null || $client_token==null){//not a client
			$clip_button = "<button  title=\"clip this property to view later\" class=\"clip-button\" data-action=\"clip\"  data-pid=\"".$this->id."\" data-clipper=\"nil\" data-ref=\"$ref_page\" data-token=\"nil\"><span class=\"glyphicon glyphicon-paperclip\"></span>clip</button>";
			return $clip_button;
		}
		else{//if client is checked in and detail is properly set;
			$check_clip = $db->query_object("SELECT * FROM clipped WHERE propertyid='".$this->id."' AND clippedby=$client");
			if($check_clip->num_rows == 1){//if already clipped
				$clips = $check_clip->fetch_array(MYSQLI_ASSOC);
				$clipped_on = 'clipped '.$this->since($clips['timestamp']);
				$unclip_button = "<button  title=\"$clipped_on\" class=\"unclip-button\"  data-action=\"clip\" data-pid=\"".$this->id."\" data-clipper=\"$client\" data-ref=\"$ref_page\" data-token=\"$client_token\"><span class=\"glyphicon glyphicon-paperclip\"></span>unclip</button>";
				return $unclip_button;
			}
			else{//not clipped yet
				$clip_button = "<button  title=\"clip this property to view later\" class=\"clip-button\"  data-action=\"clip\" data-pid=\"".$this->id."\" data-clipper=\"$client\" data-ref=\"$ref_page\" data-token=\"$client_token\"><span class=\"glyphicon glyphicon-paperclip\"></span>clip</button>";
				return $clip_button;
			}
		}
	}
	
	public function photos(){
		$photos = $this->get_images($this->relative_url().'properties/'.$this->p_directory);
		return $photos;
	}

	public function display_photo_url(){
		GLOBAL $tool;
		$all_photos = $this->photos();
		$total_images = count($all_photos);
		if($total_images > 0){//if  there are images in the directory, check if there is any match for the set display photo,
			//if there is any match, set it as the front image.
			if(in_array($this->relative_url().$this->url.'/'.$this->display_photo,$all_photos)){ /*SOMETHING IS NO RIGHT HERE, LATER SHA!*/
				$display_photo = $this->relative_url().$this->url.'/'.$this->display_photo;
			}
			else{//use the first photo found
				$display_photo = $all_photos[0];
			}
		}	
		else{
		$display_photo = $tool->relative_url().'properties/default.png';
		}
		return $display_photo;
	}
	
	public function clips(){
		GLOBAL $db;
		$clips = $db->query_object("SELECT clippedby FROM clipped WHERE propertyid='$this->id'")->num_rows;
		return $clips;
	}
	
	public function make_suggestion($agentId,$agentBusinessName,$agentUserName,$agentToken,$clientName,$clientId){
		if($agentId == null && $agentBusinessName==null && $agentUserName ==null && $agentToken==null){
			$suggestButton = "<button class=\"btn red-background white suggestion-button\" data-action=\"suggest-property\" data-agent-id=\"nil\" data-agent-business-name=\"nil\" data-agent-username=\"nil\" data-agent-token=\"\" data-client-name=\"$clientName\" data-client-id=\"$clientId\"\">Suggest Property</button>";
		}
		else{
			$suggestButton = "<button class=\"btn red-background white suggestion-button\" data-action=\"suggest-property\" data-agent-id=\"$agentId\"  data-agent-business-name=\"$agentBusinessName\" data-agent-username=\"$agentUserName\" data-agent-token=\"$agentToken\" data-client-name=\"$clientName\" data-client-id=\"$clientId\">Suggest Property</button>";
		}
		return 	$suggestButton;
	}
	
	public function image_attributes($popup){
		$alt = $this->type.' at '.$this->location.' ('.$this->rent.' per year)';
		$title = $this->type.' at '.$this->location.' ('.$this->rent.' per year)';
		if($popup == true){
			$data_property_type = $this->type;
			$data_property_location = $this->location;
			$data_property_rent = $this->rent;
			$data_property_dir = $this->url;
		return " alt=\"$alt\"  title=\"$title\"  data-property-type=\"$data_property_type\" data-property-location = \"$data_property_location\" data-property-rent = \"$data_property_rent\" data-property-dir = \"$data_property_dir\" ";
		}
		else{
		return " alt=\"$alt\"  title=\"$title\" ";
		}
	}
	
	
}

class loadData{	
	
	public function load_recently_added_properties_id($from,$how_many){
		GLOBAL $db;
		$recently_added_ids = array();
		$loadRA = $db->query_object("SELECT property_ID FROM properties ORDER BY timestamp DESC LIMIT $from,$how_many");
		while($property = $loadRA->fetch_array(MYSQLI_ASSOC)){
			$recently_added_ids[] = $property['property_ID'];
		}
		$loadRA->free();
		return $recently_added_ids;
	}

	public function load_most_viewed_properties_id($from,$how_many){
		GLOBAL $db;
		$most_viewed_ids = array();
		$loadMV = $db->query_object("SELECT property_ID FROM properties ORDER BY views DESC LIMIT $from,$how_many");
		while($property = $loadMV->fetch_array(MYSQLI_ASSOC)){
			$most_viewed_ids[] = $property['property_ID'];
		}
		$loadMV->free();
		return $most_viewed_ids;
	}


	public function load_cta_requests($from,$how_many){
		GLOBAL $db;
		$cta_requests = array();
		$get_request = $db->query_object("SELECT * FROM cta_request ORDER BY timestamp DESC LIMIT $from,$how_many");
		while($r  = $get_request->fetch_array(MYSQLI_ASSOC)){
			$cta_requests[]  = $r['ctaid'];
		}
		$get_request->free();
		return $cta_requests;
	}
	 
	 public function load_agents_id($from,$how_many,$exception){
		 	GLOBAL $db;
		$agents = array();
		if($exception == null){
		$get_agents = $db->query_object("SELECT ID FROM profiles ORDER BY timestamp DESC LIMIT $from,$how_many");
		}
		else{
		$get_agents = $db->query_object("SELECT ID FROM profiles WHERE (ID != $exception) ORDER BY timestamp DESC LIMIT $from,$how_many");
		}
		while($a  = $get_agents->fetch_array(MYSQLI_ASSOC)){
			$agents[]  = $a['ID'];
		}
		$get_agents->free();
		return $agents;
	 }

	 	 public function load_clients_id($from,$how_many,$exception){
		 	GLOBAL $db;
		$clients = array();
		if($exception == null){
		$get_clients = $db->query_object("SELECT ctaid FROM cta ORDER BY createdTimestamp DESC LIMIT $from,$how_many");
		}
		else{
		$get_clients = $db->query_object("SELECT ctaid FROM cta WHERE (ctaid != $exception) ORDER BY createdTimestamp DESC LIMIT $from,$how_many");
		}
		while($c  = $get_clients->fetch_array(MYSQLI_ASSOC)){
			$clients[]  = $c['ctaid'];
		}
		$get_clients->free();
		return $clients;
	 }
	 public function load_categories(){
		 GLOBAL $db;
		 $categories = array();
		 $categories['Flat'] = $db->query_object("SELECT property_ID FROM properties WHERE type = 'Flat' ")->num_rows;
		 $categories['Bungalow'] = $db->query_object("SELECT property_ID FROM properties WHERE type = 'Bungalow' ")->num_rows;
		 $categories['Self Contain'] = $db->query_object("SELECT property_ID FROM properties WHERE type = 'Self Contain' ")->num_rows;
		 $categories['Office Space'] = $db->query_object("SELECT property_ID FROM properties WHERE type = 'Office Space' ")->num_rows;
		 $categories['Duplex'] = $db->query_object("SELECT property_ID FROM properties WHERE type = 'Duplex' ")->num_rows;
		 $categories['Land'] = $db->query_object("SELECT property_ID FROM properties WHERE type = 'Land' ")->num_rows;
		 $categories['Shop'] = $db->query_object("SELECT property_ID FROM properties WHERE type = 'Shop' ")->num_rows;
	
	return $categories;
	 }
}


class identifier{
	public function generate_property_id(){
		GLOBAL $db; 
		$alphabets = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$firstalphaIndex = rand(0,25);
		$firstalpha  = $alphabets[$firstalphaIndex];
		$secondalphaIndex = rand(0,25);
		$secondalpha  = $alphabets[$secondalphaIndex];
		$thirdalphaIndex = rand(0,25);
		$thirdalpha  = $alphabets[$thirdalphaIndex];
		$figure = rand(1000,9999);
		$final = $firstalpha.$secondalpha.$thirdalpha.$figure;
		//check if the ID already exist
		$existing_ids = null;
		$get_existing_ids = $db->query_object("SELECT property_ID FROM properties WHERE property_ID='$final'");
        if($get_existing_ids->num_rows > 0){//if fetching the IDs is successfull...
			$this->generate_property_id();
        }
        else{
			return $final;
        }
	}
}

class search{
	public $searching_type = "";
	public $searching_maxprice = "";
	public $searching_location = "";
	public $searching_bath = 0;
	public $searching_loo = 0;
	public $searching_tiles = "";
	public $searching_pm = "";
	public $searching_borehole = "";

	public $result_showing = "";
	public $search_query = "";
	public $total_result = 0;
	public $results = array();
	public $facilities = array();

	function __construct($type,$maxprice,$location,$bath,$loo,$tiles,$p_machine,$borehole){
		$this->searching_type = $type;
		$this->searching_maxprice = $maxprice;
		$this->searching_location = $location;
		$this->searching_bath = $bath;
		$this->searching_loo = $loo;
		$this->searching_tiles = $tiles;
		$this->searching_pm = $p_machine;
		$this->searching_borehole = $borehole;

		GLOBAL $db;

	$result_showing = "";

	$filter = $this->filter_search('main_result');

		$this->search_query = "SELECT property_ID FROM properties WHERE (".$filter['query_filter'].")";

		$getResult = $db->query_object($this->search_query);
		$this->total_result = $getResult->num_rows;

		while($r = $getResult->fetch_array(MYSQLI_ASSOC)){
			$this->results[] = $r['property_ID'];
		}
		$this->result_showing = "Showing result for ".$filter['result_showing'];
		$this->facilities = $filter['facilities'];
	}

	public function limited_result($from,$how_many){
		GLOBAL $db;
		$results = array();
		$getResult = $db->query_object($this->search_query."  LIMIT $from,$how_many");
		while($r = $getResult->fetch_array(MYSQLI_ASSOC)){
			$results[] = $r['property_ID'];
		}
		return $results;
	}

	public function related_results($how_many){
		GLOBAL $db;
		$related_results = array();
		
			$filter = $this->filter_search("related_result");
			$related_result_query ="SELECT property_ID FROM properties WHERE (".$filter['query_filter'].") LIMIT $how_many";

				$getRelatedResult = $db->query_object($related_result_query);
			while($r = $getRelatedResult->fetch_array(MYSQLI_ASSOC)){
				if(in_array($r['property_ID'],$this->results)){
					continue;
				}
				$related_results[] = $r['property_ID'];
		}
		return $related_results;
	}

	private function filter_search($result){

		$logic = ($result == "related_result" ? " OR " : " AND ");

		$query_filter = "";
		$result_showing = "";
		$facilities = array();

	if($this->is_prefered($this->searching_type)){
		$query_filter .= ($query_filter != "" ? $logic : "")." type = '".$this->searching_type."' ";
		$result_showing .= "<strong>$this->searching_type</strong>";
	}
	if($this->searching_maxprice != 0){
		$query_filter .= ($query_filter != "" ? $logic : "")." rent <= $this->searching_maxprice";
		$result_showing .= ($result_showing == "" ? " properties" : "")." not more than <strong>".number_format($this->searching_maxprice)."</strong>";
	}
	if($this->is_prefered($this->searching_location)){
		$query_filter .= ($query_filter != "" ? $logic : "")." (area LIKE '%$this->searching_location%' OR city LIKE '%$this->searching_location%' OR CONCAT(area,', ',city) LIKE '%$this->searching_location%') ";
		$result_showing .= ($result_showing == "" ? " properties" : "")." around <strong>$this->searching_location</strong>";
	}

	if($this->is_prefered($this->searching_bath)){
		$query_filter .= ($query_filter != "" ? $logic : "")." bath = $this->searching_bath ";
		$facilities[] = "$this->searching_bath baths ";
	}

	if($this->is_prefered($this->searching_loo)){
		$query_filter .= ($query_filter != "" ? $logic : "")." toilet = $this->searching_loo ";
		$facilities[] = "$this->searching_loo toilets ";
	}

	if($this->is_prefered($this->searching_tiles)){
		$query_filter .= ($query_filter != "" ? $logic : "")." tiles = 'Yes' ";
		$facilities[] = "Tiles";
	}

	if($this->is_prefered($this->searching_pm)){
		$query_filter .= ($query_filter != "" ? $logic : "")." pumping_machine = 'Yes' ";
		$facilities[] = "Pumping Machine";
	}

	if($this->is_prefered($this->searching_borehole)){
		$query_filter .= ($query_filter != "" ? $logic : "")." borehole = 'No' ";
		$facilities[] = "Borehole";
	}	
	return array('query_filter'=>$query_filter,'result_showing'=>$result_showing,'facilities'=>$facilities);
	}

	private function is_prefered($param){
		return ($param != '' && $param != 'ns' ? true : false);
	}

}

class login extends tools{
	public function verify_account($username,$password,$remember){
		GLOBAL $db;
$user = $db->query_object("SELECT User_ID FROM profiles WHERE User_ID = '$username' AND token='".SHA1($username)."'");
if($user->num_rows==1){
	$get_pass = $db->query_object("SELECT password,token FROM profiles WHERE User_ID = '$username'")->fetch_array(MYSQLI_ASSOC);
if($get_pass['password']==$password){
//log CTA out immediadely agent account is logged in
$this->deleteCookie('user_client');
//if user want to remained logged, set the cookie for longer period
if($remember == true){
					setcookie('user_agent',$get_pass['token'],time()+2592000,"/","",0);
					}
					else{
						setcookie('user_agent',$get_pass['token'],0,"/","",0);
					}
return 100;
}
//if password is incorrect
else{
return 'error101';
			}
		}
//if no username matches
else{
return 'error102';
		}
	}
	
} //end of class

class checkin extends tools{
	public function verify_cta($name,$password,$remember){
		if($name == "" || $password == ""){
			return 99;
		}
		else{
		GLOBAL $db;
		if(is_numeric($name)){
$user = $db->query_object("SELECT name FROM cta WHERE phone = $name AND token='".SHA1($name)."'");
	$password_Q = "SELECT password,token,expiryTimestamp FROM cta WHERE phone = $name";
		}
		else if(is_string($name)){
$user = $db->query_object("SELECT name FROM cta WHERE name = '$name' AND token='".SHA1($name)."'");
	$password_Q = "SELECT password,token,expiryTimestamp FROM cta WHERE name = '$name'";
		}
if($user->num_rows==1){
	$get_pass = $db->query_object($password_Q)->fetch_array(MYSQLI_ASSOC);
if($get_pass['password']==$password){
	if($get_pass['expiryTimestamp'] < time()){//check if cta has expired
		return 1000; 
	}
	else{
//log agent out immediadely cta account is checked in
$this->deleteCookie('user_agent');
//if user want to remained checked in, set the cookie for longer period
if($remember == true){
					setcookie('user_client',$get_pass['token'],time()+2592000,"/","",0);
					}
					else{
						setcookie('user_client',$get_pass['token'],0,"/","",0);
					}
return 100;
	}
}
//if password is incorrect
else{
return 101;
			}
		}
//if no name matches
else{
return 102;
			}
		}
	}
}

class verification extends tools{
	public $expiry_timestamp = 0;
	
	function isAgent(){
		if($this->cookieExist('user_agent')){
			return true;
		}
		return false;
	}

function getAgentID(){
			GLOBAL $db;
			$agentID = 0;
			$token = $this->getCookie('user_agent');
	$getAgent = $db->query_object("SELECT ID from profiles WHERE token = '$token'");
			if($getAgent->num_rows == 1){
				$a = $getAgent->fetch_array(MYSQLI_ASSOC);
				$agentID =  $a['ID'];
			}
			return $agentID;
	}

	function isClient(){
		$client = false;
		if($this->cookieExist('user_client')){
			return true;
		}
		return false;
	}	

	function isCTAexpired($expiry_timestamp){
		if($expiry_timestamp < time()){
			return true;
		}
		else{
			return false;
		}
	}

	function getClient(){
			GLOBAL $db;
			$cta = array();
			$token = $this->getCookie('user_client');
			$getClient = $db->query_object("SELECT ctaid,expiryTimestamp from cta WHERE token = '$token'");
			if($getClient->num_rows == 1){
				$c = $getClient->fetch_array(MYSQLI_ASSOC);
				$cta['ctaid'] = $c['ctaid'];
				$cta['expiry'] = $c['expiryTimestamp'];
						}
				return $cta;
			}
	
}//end of verification class



$tool = new tools();
$loadData = new loadData();
$onPageLoadPopup = "";
$status = 0;

//verify user on every page
$verify_user = new verification();
	if($verify_user->isAgent()){
		$agentID = $verify_user->getAgentID();
		if($agentID != 0){
		$loggedIn_agent = new agent($agentID);//this is the object for loggedIn_agent
		$status = 1;
			GLOBAL $onPageLoadPopup;
		if($loggedIn_agent->last_seen == 0){
			$onPageLoadPopup = "<div class=\"header\">
									<h2 class=\"text-center site-color\">Welcome ".$loggedIn_agent->business_name."</h2>
								</div>
								<div class=\"body text-center\">
								<h3>".$loggedIn_agent->business_name.", Thank you for choosing shelter.com, We are glad to have you here</h3>
								</div>";
			}
		else if((time() - $loggedIn_agent->last_seen) >= (7 * $tool->one_day_timestamp)){
			$onPageLoadPopup = $loggedIn_agent->longTimeWelcome();
			} 
		}
	}
	else if($verify_user->isClient()){
		$client = $verify_user->getClient();
		if(!empty($client)){
			if($verify_user->isCTAexpired($client['expiry'])){
			$status = 90; //expired CTA
			GLOBAL $onPageLoadPopup;
			if($loggedIn_client->last_seen == 0){
			$onPageLoadPopup = "<div class=\"header\">
									<h2 class=\"text-center site-color\">Welcome ".$loggedIn_client->name."</h2>
								</div>
								<div class=\"body text-center\">
								<h3>".$loggedIn_client->name.", Thank you for choosing shelter.com, We are glad to have you here</h3>
								<p class=\"font-20\">We are commited to helping find your property of choice either for leasing or for sale.</p>
								<h1>This is How We work</h1>
								<p>blah blah blah</p>
								</div>";
				}
			}
			else{
				$loggedIn_client = new client($client['ctaid']);
				$status = 9; //expired CTA
			}
		}
	}
	else{
		$status = 0; //visitor
	}

/*echo "
	server : $server<br/>
	server doc root: $server_doc_root<br/>
	site doc root : $doc_root<br/>
	error log path : $errorlog_path<br/>
	root: $root<br/>
	current script : $script_running<br/>
	current url : $current_url<br/>
";
echo "User status: $status";
*/
//$onPageLoadPopup = "<div class=\"header\"><h2>Hello, how are you??</h2></div><div class=\"body\">Testing Testing!!!!</div>";
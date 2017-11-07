<?php
/*

This script must first be required in any script because all other information on every other script depends on the variables in this one
*/

require('site_config.php');
$unavailable_page =  "
<html>
<head><title>Page not Available!</title></head>
<body style=\"background-color:#20435C;\">
<div style=\"padding:1%; width:70%;margin:auto; line-height:25px; background-color:white; color:#20435C;border-radius:5px\">
<h2 align=\"center\">Page temporarily not available.</h2>
<p align=\"center\">This page you are trying to view is temporarily not available, it may be under maintainance. We are sorry for any inconviniency this might bring you. You can <a href=\"$root\">visit our homepage</a></p>
</div>
</body>
</html>";

error_reporting( E_ALL | E_ERROR | E_STRICT | E_PARSE);
function handleError($e_no, $e_str,$e_file,$e_line){
$errorLog = "
SCRIPT ERROR: 

Error code: [$e_no] 

Technical Message: <b>$e_str</b> 

File: $e_file 

Line: $e_line 

Page Accessing: ".$_SERVER['PHP_SELF'];

error::logError($errorLog);
    }
set_error_handler("handleError");


/*******MYSQLI CONNECTION****************/
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
if ($connection->connect_error) {
unset($connection);
general::no_connection_page();
die();
	}
	
/*************CLASS OBJECTS***********************/
$db = new database();
$general = new general();
$data = new agent_client_data();
$property_obj = new property();
$client = new cta();
$agent = new agent();

/*************CLASSES***********************/


class database{

/*
This function select records from the database and return a 2-dimensional array data[0..][columns] if columns are specified
in the query and return just the query resul object if all columns (*) are selected 

function select($table,$columns,$condition,$others){
 GLOBAL $connection;
   if(isset($connection)){
     
   if($columns != '*'){
    //split the columns
   $columns_array = spliti(',',$columns);
    $index = 0;
    $data = array();

if($condition == 'all'){
     $q = "SELECT $columns FROM $table $others";  
    }
    else{
        $q  = "SELECT $columns FROM $table WHERE ($condition) $others";
    }


 $query = $connection->query($q);
   if($connection->error){
 return "<b>".__CLASS__."::".__FUNCTION__."</b> in ".__FILE__." line <b>".__LINE__ ."</b> failed.<br/> <b>Reason:</b>\"<i>\"$mysqli->error\"</i>\"";
   }
else{
  while($query_result = $query->fetch_array(MYSQLI_ASSOC)){
    foreach($columns_array as $col){
$data[$index][$col] = $query_result[$col];
    }
$index++;
}
 return $data; //return a 2 X columns array
}
  
    }
//selecting all columns
else{
    if($condition == 'all'){
return $this->query_object("SELECT * FROM $table $others");
    }
    else{
return $this->query_object("SELECT * FROM $table WHERE($condition) $others");
                 }

             }
        }
}
*/
 function query_object($query){
GLOBAL $connection;
$obj = null;

$obj = $connection->query($query);
if($connection->error){
 /*if there was error in the query, return the error string...
	i purposely do not want to log the error directly from here to make backtracing easy and know where the error is comming from.
	Any error that would occur here would be from the query passed into the arguement, so i need to know where the query is coming from. */
	
 return "<b>".__CLASS__."::".__FUNCTION__."</b> in ".__FILE__." line <b>".__LINE__ ."</b> failed.<br/> <b>Reason:</b>\"<i>\"$connection->error\"</i>\"";
   }
   
//else return the query result object;
   else{
return $obj;
         }
    }    

function close_connection(){
    GLOBAL $connection;
     if($connection->close()){
         echo "<div>connection closed</div>";
        }
		else{
			echo "connection could not be close.";
		}
    }

}//end of class


class general{

function redirect($to){
    $goto = ($to==null ? general_config::$root : general_config::$root."/$to");
	header("location: $goto");
	$this->halt_page();
}

static function no_connection_page(){
echo "
<html>
<head><title>Connection failed!</title></head>
<body style=\"background-color:#20435C;\">
<div style=\"padding:10%; line-height:25px;color:white; text-align:center\">
<img src=\"".general_config::$root."/resrc/gifs/icon-wlan.gif\" style=\"width:200px; height:200px\"/>
<h2 align=\"center\">No Connection to Server</h2>
<p align=\"center\">Connection to the server could not be established. We are sorry for any inconviniency this might bring you and please be assured that we are working hard to resolve it soon</p>
</div>
</body>
</html>";
	
    }

function check_cookie($cookie_name){
	if(isset($_COOKIE[$cookie_name])){
		return true;
	}
	else{
		return false;
	}
}

function get_cookie($cookie_name){
	if($this->check_cookie($cookie_name)==true){
		return $_COOKIE[$cookie_name];
	}
	else{
		return null;
	}
}

function unset_cookie($cookie_name){
	setcookie($cookie_name,"",time()-60,"/","",0);
}

function halt_page(){
	GLOBAL $db;
	$db->close_connection();
	exit();
}
//This function takes care of timestamp
function since($timestamp){
	$time = time() - $timestamp;
	if($time<60){
		$since = $time.'sec ago';
	}
	else if($time>=60 && $time<3600){
		$since = round(($time/60)).'min ago';
	}
	else if($time>=3600 && $time<86400){
		$since = round(($time/3600)).'h, '.(($time/60)%60).'min ago';
	}
	else if($time>=86400 && $time<604800){
		$since = round(($time/86400)).'d ago, '.date('l, M d ',$timestamp);
	}
	else if($time>=604800 && $time<18144000){
		$since =round(($time/604800)).'wk ago, '.date('M d  ',$timestamp);
	}
	else{
		$since = "invalid time";
	}
return $since;
		}

function display_notification($nid,$subject,$subjecttrace,$subjectid,$receiverid,$action,$link,$timestamp,$howold,$status){
	GLOBAL $db;
	GLOBAL $client;
	GLOBAL $root;
	GLOBAL $doc_root;
	GLOBAL $property_obj;

	$time = time() - $timestamp;
if($howold=="yesterday"){
	$since = "Yesterday at ".date('h:i a ',$timestamp);
}
else{
$since = $this->since($timestamp);
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
						<span class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\">".$property['type']."</span>
						<span class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\">Rent: <strong>N ".number_format($property['rent'])."</strong></span>
						<span class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\"><span class=\"glyphicon glyphicon-map-marker\"></span>".$property['location']."</span>
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
						<span class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\">$property_type</span>
						<span class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\">Rent: <strong>N ".number_format($property_rent)."</strong></span>
						<span class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\"><span class=\"glyphicon glyphicon-map-marker\"></span>$property_loc</span>
						<span class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\"><span class=\"glyphicon glyphicon-upload\"></span>uploaded ".$this->since($property_ts)."</span>
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

//this function returns a snipped string in case of long string in defined container dimension
function substring($string,$beginningOrEnd,$length){
	if($beginningOrEnd == 'abc'){
		//return the first $length substring
	return (strlen($string) >= $length ? substr($string,0,$length).'...' : $string);
	}
	else if($beginningOrEnd == 'xyz'){
		//return the last $length substring
return (strlen($string)>=$length ? '...'.substr($string,(strlen($string)-$length),strlen($string)) : $string);
	}
	else if($beginningOrEnd == 'abcxyz'){
		//return the part of the beginning substring and part of ending substring
return (strlen($string)>=$length ? substr($string,0,($length/2)).'...'.substr($string,strlen($string)-($length/2),strlen($string)) : $string);
	}
}
	//This function verify if a file is an image
function is_image($filename){
	$allowed = array(".png",".jpg",".jpeg");
	$i = 0;
while($i < count($allowed)){
	if (stripos($filename,$allowed[$i]) == 0){
		$clean = false;
	}
	else{
		$clean = true;
		break;
	}
	$i++;
}
		return $clean;
}

//This function check if an upload is of type image
function is_upload_image($filetype){
	$allowedImageFormats = array ('image/pjpeg','image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
	if (in_array($filetype,$allowedImageFormats)){
		return 'clean';
	}
	else{
		return 'bad';
	}
}

//This function get all the images in a directory with either of the allowed formats
function get_images($dir){
	$clean = array();
$cleanFormats = array('.png','.PNG','.jpg','JPG','.jpeg','.pjpeg','.x-png');

for($i = 0; $i<count($cleanFormats); $i++){

foreach(glob("$dir/*$cleanFormats[$i]") as $c){
	$clean[] = $c;
		}
	}
return $clean;
}

}//end of general class

class agent_client_data{

	function messages($target){
        GLOBAL $db;
$unread_messages = $db->query_object("SELECT * FROM messages WHERE receiver='$target' AND status='unseen'")->num_rows;
return $unread_messages;
	}

	function agent_followings($target){
        GLOBAL $db;
		$following_ids = array();
 $following = $db->query_object("SELECT * FROM agent_agent_follow WHERE agent_follower_id=$target");
 while($f = $following->fetch_array(MYSQLI_ASSOC))	{
	 $following_ids[] = $f['agent_following_id'];
 }
return $following_ids;
	}

	function agent_followers($target){
         GLOBAL $db;
		 $follower_ids = array();
 $agentfollower = $db->query_object("SELECT * FROM agent_agent_follow WHERE agent_following_id=$target");
 while($f = $agentfollower->fetch_array(MYSQLI_ASSOC)){
	 $follower_ids[] = $f['agent_follower_id'];
 }	
return $follower_ids;
	}
function client_followings($target){
        GLOBAL $db;
		 $following_ids = array();
 $following = $db->query_object("SELECT * FROM client_agent_follow WHERE client_id=$target");	
  while($f = $following->fetch_array(MYSQLI_ASSOC)){
	 $following_ids[] = $f['agent_id'];
 }	
return $following_ids;
	}

	function client_followers($target){
         GLOBAL $db;
		 $follower_ids = array();
 $clientfollower = $db->query_object("SELECT * FROM client_agent_follow WHERE agent_id=$target");	
  while($f = $clientfollower->fetch_array(MYSQLI_ASSOC)){
	 $follower_ids[] = $f['client_id'];
 }	
 $clientfollower->free();
return $follower_ids;
	}

function get_uploads($agentId,$agent_username){
	GLOBAL $db;
	$uploads = array();
	$getUploads = $db->query_object("SELECT property_ID FROM  properties WHERE (uploadby='$agent_username')");
	if(is_string($getUploads)){
error::report_error($getUploads,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
	}
	else{
	while($u = $getUploads->fetch_array(MYSQLI_ASSOC)){
		$uploads[] = $u['property_ID'];
	}
	$getUploads->free();
	return $uploads;
	}
}
function agent_notifications($agent_id,$agent_username){
	GLOBAL $db;
	$notificationids = array();
	$getNotifications = $db->query_object("SELECT notificationid FROM  agent_notifications WHERE (receiver_id='$agent_id' AND status='unseen')");
	while($nid = $getNotifications->fetch_array(MYSQLI_ASSOC)){
		$notificationids[] = $nid['notificationid'];
	}
	return $notificationids;
}
function client_notifications($client_id,$client_name){
	GLOBAL $db;
	$notificationids = array();
	$getNotifications = $db->query_object("SELECT notificationid FROM  client_notifications WHERE (receiver_id='$client_id' AND status='unseen')");
	while($nid = $getNotifications->fetch_array(MYSQLI_ASSOC)){
		$notificationids[] = $nid['notificationid'];
	}
	return $notificationids;
}

function get_all_cta_requests(){
	        GLOBAL $db;
			$cta_requests = array();
	$get_request = $db->query_object("SELECT * FROM cta_request");
	$i = 0;
if(is_object($get_request)){
	while($r  = $get_request->fetch_array(MYSQLI_ASSOC)){
		$cta_requests[$i]['id']  = $r['ctaid'];
		$cta_requests[$i]['ctaname']  = $r['ctaname'];
	$i++;}
$get_request->free();
}
return $cta_requests;
	}

}//end of class client_agent_data


class property{
/*This is the default query to fetch property from the database. The aliases must be used if display_property.php is going 
to be used to output the data
*/

  static $property_query = "SELECT property.property_ID AS id, property.directory AS dir,
        property.type AS type, property.location AS location, property.rent AS rent,
        property.min_payment AS mp, property.bath AS bath, property.toilet AS toilet,
        property.description AS description, property.timestamp AS since,property.last_reviewed AS lastReviewed,
        property.views AS views, property.status AS status, property.display_photo AS dp, agent.Business_Name AS agentBussinessName,
        agent.User_ID AS agentUserName , agent.Office_Address AS agentOfficeAdd, agent.Office_Tel_No AS agentOfficeNo,
        agent.Phone_No AS agentNo,agent.Alt_Phone_No AS agentAltNo,agent.token AS agenttoken
        FROM properties AS property INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby)";

/*This function is for clipping*/
function clip($property_id,$clipper,$ref_page,$client_token){
GLOBAL $db;
GLOBAL $general;
GLOBAL $root;
 $clipbutton_id = $property_id.'clipbutton';

 //this is if client is not currently checked in
if($clipper == null || $client_token==null){
$clip_button = "<a  title=\"clip this property to view later\" class=\"clip-button\"   id=\"$clipbutton_id\" onclick=\"makeclip('$clipbutton_id','xxx','$ref_page','xxx')\"><span class=\"glyphicon glyphicon-paperclip\"></span>clip</a>";
return $clip_button;
}
//if client is checked in and detail is properly set;
else{
$check_clip = $db->query_object("SELECT * FROM clipped WHERE propertyid='$property_id' AND clippedby=$clipper");
if($check_clip->num_rows == 1){
	$clips = $check_clip->fetch_array(MYSQLI_ASSOC);
	$clipped_on = 'clipped '.$general->since($clips['timestamp']);
/* used event.preventDefault() the javascript that handle the click event on this elemen but some browser the event.preventDefault
*seems not to work on some browsers, that's why i remove the href attribute for now'
*/
//$unclip_button = "<a  title=\"$clipped_on\" class=\"unclip-button\"  href=\"$root/resources/php/ajax_scripts/clip.php?p=$property_id&cb=$clipper&ref=$ref_page&tkn=$client_token\" id=\"$clipbutton_id\" onclick=\"makeclip('$clipbutton_id',$clipper,'$ref_page','$client_token')\"><span class=\"black-icon minus-icon\"></span>unclip</a>";
$unclip_button = "<a  title=\"$clipped_on\" class=\"unclip-button\"  id=\"$clipbutton_id\" onclick=\"makeclip('$clipbutton_id',$clipper,'$ref_page','$client_token')\"><span class=\"glyphicon glyphicon-paperclip\"></span>unclip</a>";
return $unclip_button;
		}
else{
$clip_button = "<a  title=\"clip this property to view later\" class=\"clip-button\"   id=\"$clipbutton_id\" onclick=\"makeclip('$clipbutton_id',$clipper,'$ref_page','$client_token')\"><span class=\"glyphicon glyphicon-paperclip\"></span>clip</a>";
return $clip_button;
	}
}

}
/*
This function  randomly generate a unique Id for a newly uploaded property.
*/
function generate_property_id(){
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
	//if fetching the IDs is successfull...
    if(is_object($get_existing_ids)){
        if($get_existing_ids->num_rows > 0){
$this->generate_property_id();
        }
        else{
    return $final;
        }
    }
else{
        error::report_error("Unable to generate new property Id $get_existing_ids",__FILE__,__CLASS__,__FUNCTION__,__LINE__);
}
	}
	
function get_property_dp($directory,$dp){
	GLOBAL $general;
	GLOBAL $root;
	 $all_photos = $general->get_images($directory);
	$totalAvailablePhoto = count($all_photos);
	if($totalAvailablePhoto > 0){
//if  there are images in the directory, check if there is any match for the set display photo,
//if there is any match, set it as the front image.
if(in_array($directory.'/'.$dp,$all_photos)){
		$display_photo = $directory.'/'.$dp;
}
else{
    $display_photo = $all_photos[0];
		}
	}
else{
	$display_photo = $root.'/properties/default.png';
}
return $display_photo;
}

function suggestProperty($agentId,$agentBusinessName,$agentUserName,$agentToken,$clientName,$clientId){
	if($agentId == null && $agentBusinessName==null && $agentUserName ==null && $agentToken==null){
$suggestButton = "<button class=\"btn red-background white suggestion-button\" data-agent-id=\"\" data-agent-business-name=\"\" data-agent-username=\"\" data-agent-token=\"\" data-client-name=\"$clientName\" data-client-id=\"$clientId\"\">Suggest Property</button>";
	}
	else{
$suggestButton = "<button class=\"btn red-background white suggestion-button\" id=\"sgg$clientId\" data-agent-id=\"$agentId\" data-agent-business-name=\"$agentBusinessName\" data-agent-username=\"$agentUserName\" data-agent-token=\"$agentToken\" data-client-name=\"$clientName\" data-client-id=\"$clientId\">Suggest Property</button>";
	}
return 	$suggestButton;
}

}//end of property class

class agent{

function check_status(){
	if(!empty($this->get_agentProfile())){
		return 'active';
	}
}
/*This function check for follow and return follow or unfollow button as the case may be
**Notice the javascript function follow() passed in the button, it uses AJAX to follow/unfollow
**asynchronously, check js/profile.js to see the the javascript and profile/follow.php to see the
**php script.
*/
function follow($followerId, $follower_name,$follower_username,$followingId,$following_name,$following_username,$type){
        GLOBAL $db;
    $get_follow = null;
	if($follower_username==null && $type=='C4A'){
$get_follow_query = "SELECT * FROM client_agent_follow WHERE (client_id = $followerId AND agent_id = $followingId)";
	}
else if($type=='A4A'){
$get_follow_query = "SELECT * FROM agent_agent_follow WHERE (agent_follower_id = $followerId AND agent_following_id = $followingId)";

	}
    $get_follow = $db->query_object($get_follow_query);
    if(is_string($get_follow)){
        error::report_error($get_follow,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
    }
    else{
        if($get_follow->num_rows == 1){
	//<p class=\"grey font-12 no-margin follow-status\" id=\"$followingId-follow-status\"><span class=\"glyphicon glyphicon-ok-sign\"></span>Following</p>
    $unfollow_button = "<span>
				<button class=\"unfollow-button\" id=\"$following_username$followingId\" onclick=\"follow('$following_username$followingId',$followerId,'$follower_name','$follower_username',$followingId,'$following_name','$following_username','$type')\" ><span class=\"glyphicon glyphicon-minus-sign\"></span>unfollow</button>
				</span>";
            return $unfollow_button;
        }
        else{
    $follow_button = "<span>
	<p class=\"grey font-12 no-margin\" id=\"$followingId-follow-status\"></p>
	<button  class=\"follow-button\" id=\"$following_username$followingId\" onclick=\"follow('$following_username$followingId',$followerId,'$follower_name','$follower_username',$followingId,'$following_name','$following_username','$type')\" ><span class=\"glyphicon glyphicon-plus-sign\"></span>follow</button>
	</span>";
            return $follow_button;
        }
    }
}
function dummy_follow(){
	GLOBAL $root;
	    $follow_button = "<span>
		<a href=\"$root/cta/checkin.php?_rdr=1\">
	<button  class=\"follow-button\" ><span class=\"glyphicon glyphicon-plus-sign\"></span>follow</button>
	</a>
	</span>";
return $follow_button;
}
	function get_agentProfile(){
		GLOBAL $general;
        GLOBAL $db;
		$agentcookie = $general->get_cookie('user_agent');
		$agentProfile = array();

if($agentcookie != null){

 $getProfile = $db->query_object("SELECT ID,Business_Name,User_ID,token,last_seen,last_upload FROM profiles WHERE (token='$agentcookie')");
		 if(is_object($getProfile)){
             //if profiles still exist
             if($getProfile->num_rows != 0){
			 $records = $getProfile->fetch_array(MYSQLI_ASSOC);
            $agentProfile['ID'] = $records['ID'];
            $agentProfile['Business_Name'] = $records['Business_Name'];
            $agentProfile['User_ID'] = $records['User_ID'];
            $agentProfile['token'] = $records['token'];
		 $agentProfile['last_seen'] = $records['last_seen'];
		 $agentProfile['last_upload'] = $records['last_upload'];
             //Other agent data
			GLOBAL $data;
            $agentProfile['messages'] = $data->messages($records['Business_Name']);
			$agentProfile['a_followers'] = count($data->agent_followers($records['ID']));
			$agentProfile['c_followers'] = count($data->client_followers($records['ID']));
			$agentProfile['followings'] = count($data->agent_followings($records['ID']));
			$agentProfile['uploads'] = count($data->get_uploads($records['ID'],$records['User_ID']));
			$agentProfile['notifications'] = count($data->agent_notifications($records['ID'],$records['User_ID']));

           
            $getProfile->free();
             }
         }else{
			 error::report_error($getProfile,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		 }
	}
	return $agentProfile;
}
function longTimeWelcome($agent,$last_seen){
GLOBAL $db;
$requests_since_last_seen = $db->query_object("SELECT ctaid FROM cta_request WHERE (timestamp>$last_seen)")->num_rows;
$client_followers_since_last_seen = $db->query_object("SELECT client_name FROM client_agent_follow WHERE (agent_business_name = '$agent' AND timestamp>$last_seen)")->num_rows;
$agent_followers_since_last_seen = $db->query_object("SELECT agent_follower_business_name FROM agent_agent_follow WHERE ( agent_following_business_name = '$agent' AND timestamp>$last_seen)")->num_rows;

$msg = "<h1 >Welcome Back <span id=\"subject\">$agent</span></h1>
		<p>It's been a while you are here, Check out some updates since you last visited:</p>
		<h4>Clients Requests : <span style=\"font-family:Georgia; font-size: 120%;\">$requests_since_last_seen</span></h4>
		<h4>New Client Followers : <span style=\"font-family:Georgia; font-size: 120%;\">$client_followers_since_last_seen</span></h4>
		<h4>New Agent Followers: <span style=\"font-family:Georgia; font-size: 120%;\">$agent_followers_since_last_seen</span></h4>
<div style=\"margin-top:5%\">

			<h4 style=\"color:blue; font-weight:bold\" class=\"text-center\"><span style=\"color:red; font-size:300%;\"><i>?</i></span>WHAT WOULD YOU LIKE TO DO NOW?</h4>

		<a href=\"upload\" class=\"link-inside-modal\">Upload Property</a>
		<a href=\"clients\" class=\"link-inside-modal\">Suggest Property</a>
		<a href=\"search\" class=\"link-inside-modal\">Search for Property</a>
		</div>
		";

	return $msg;

}

function get_notification($agent_id,$last_seen){
GLOBAL $db;
$notification = "";
$q = "SELECT an.subject AS subject,an.subject_id AS subject_id,an.action AS action,an.receiver AS receiver, 
	an.receiver_id AS receiver_id,an.timestamp AS notice_time,cta.ctaid AS client_id,cta.name AS client_name 
	FROM agent_notifications AS an LEFT JOIN cta ON (an.subject_id = cta.ctaid) WHERE (an.timestamp > $last_seen)";

 $get_notification = $db->query_object($q);
 if(is_string($get_notification)){
		$notification = $get_notification;
	}
 else if($get_notification->num_rows > 0){

 }
 else{

 }
// return $notification;
}

function send_notification($subject,$subject_username,$subject_id,$receiver,$receiver_id,$action,$link,$timestamp){
	GLOBAL $db;
	$nid = $nid = time() + rand(1000000,9999999);
	$notification_query = $db->query_object("INSERT INTO client_notifications (notificationid,subject,subject_username,subject_id,receiver,receiver_id,action,link,timestamp,status) VALUES ($nid,'$agent_Bname','$agent_username',$agentid,'$clientname',$clientid,'PSG','$root/properties/?pid=$propertyid',$now,'unseen')");

}

//end of agent class
}

class cta{
  
	function get_ctacookie(){
		if(isset($_COOKIE['CTA'])){
return $_COOKIE['CTA'];
		}
		else{
			return null;
		}
	}

	function check_status(){
        GLOBAL $general;
		$cta_details = $this->get_ctaProfile();
			 if(!empty($cta_details)){
				 if($cta_details['seconds_left'] < 0){
					$general->redirect('logout');
				 }
				  else{
 					return 'active';
			 		}
			 } 	
	}

	function get_ctaProfile(){
        GLOBAL $general;
		GLOBAL $db;
		$ctaProfile = array();
		$ctacookie = $general->get_cookie('user_cta');
if($ctacookie != null){
$getCTA = $db->query_object("SELECT ctaid,name,request,timeCreated,expiryTime,token,last_seen FROM cta WHERE (token='$ctacookie')");
if(is_object($getCTA)){
//if CTA is found...
if($getCTA->num_rows == 1){
			$now = time();
			 $records = $getCTA->fetch_array(MYSQL_ASSOC);

            $ctaProfile['ctaid'] = $records['ctaid'];
            $ctaProfile['name'] = $records['name'];
            $ctaProfile['request'] = $records['request'];
            $ctaProfile['timeCreated'] = $records['timeCreated'];
            $ctaProfile['expiryTime'] = $records['expiryTime'];
			$ctaProfile['token'] = $records['token'];
	//Other profile data
GLOBAL $data;
			$ctaProfile['messages'] = $data->messages($records['name']);
			$ctaProfile['followings'] = count($data->client_followings($records['ctaid']));
			$ctaProfile['notifications'] = count($data->client_notifications($records['ctaid'],$records['name']));
			$ctaProfile['seconds_left'] = $records['expiryTime'] - $now;
			$ctaProfile['last_seen'] = $records['last_seen'];	


            $getCTA->free();
	}
}

else{
error::report_error($getCTA,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
            }
		}
return $ctaProfile;
	}

function get_request($ctaid,$ctaname){
	GLOBAL $db;
		$cta_request = array();
//get request 
$rq = $db->query_object("SELECT * FROM cta_request WHERE (ctaid=$ctaid)");
if(is_object($rq)){
$cta_request = $rq->fetch_array(MYSQLI_ASSOC);
		}
else{
//unsuccefull query
}

return $cta_request;
	}

//this function returns an array of all properties that match the argument
function get_matches($type,$maxprice,$location){
	GLOBAL $db;
$cta_matches = array();
//get matches id after the requests data has been retrieved and get the number of rows that mathes the request
$getCTAmatches = $db->query_object("SELECT property_ID FROM properties WHERE (type='$type' AND rent<=$maxprice AND location LIKE '%$location%')");
	if(is_object($getCTAmatches)){
		while($m = $getCTAmatches->fetch_array(MYSQLI_ASSOC)){
	$cta_matches[] = $m['property_ID'] ;
		}
	}else{
	//unsuccessfull query
}
return $cta_matches;
}
 
function get_clipped($ctaid,$ctaname){
		GLOBAL $db;
	$clipped = array();

$getclipped = $db->query_object("SELECT propertyid FROM clipped WHERE (clippedby=$ctaid)");
if(is_object($getclipped)){
	while($c = $getclipped->fetch_array(MYSQLI_ASSOC)){
	$clipped[] = $c['propertyid'] ;
	}
		
}else{
	//unsuccessfull query
}

return $clipped;
}
 
function get_suggestions($target){
	 GLOBAL $db;
	$suggestions= array();
	$get_suggestions = $db->query_object("SELECT * FROM property_suggestion WHERE (client_id = $target)");
if(is_object($get_suggestions)){
	while($s  = $get_suggestions->fetch_array(MYSQLI_ASSOC)){
		$suggestions[] = $s['property_id'];
	}
$get_suggestions->free();
}
return $suggestions;
}


 		}//end of cta class

class error{
 static function report_mysqli_error($bug,$file,$class,$function,$line){
          $errorLog = " 
		  *** mysqli error: 
		  [$bug] in $file, <b>$class::$function</b> in line $line ***";
		  error::logError($errorLog);
    }
static function report_error($msg,$file,$class,$function,$line){
        $errorLog = " *** error: 
		$msg 
		<b>source:</b> [$file >> $class :: $function >> near line $line] ***";
		error::logError($errorLog);
		
   }
static function logError($e){
	GLOBAL $doc_root;
	
	 echo "
	 <div style=\"background-color:white; color:red; width:90%;margin:5% auto;padding:20px;text-align:center; border:1px solid #e3e3e3;border-radius:5px;\">
	<h1> Ooops! Looks like something went wrong!</h1>
	<p>A problem has been encountered while loading this page,
	 this error has been logged and please be assured that we'll get it fixed soon.</p>
	 </div>
	 ";
	
	$file = fopen($doc_root."admin/logs/error_log_".time().".txt","a+");
	$error = '['.date('Y : m : d : H : i : s',time()).'] 
	
	'.$e;
	$log = fwrite($file,$error);
	fclose($file);
	die();
}
    }
/*
*This bottom part set user variables
*/
$oneDay = 86400;
//get agent details if logged in
if($agent->check_status()=='active'){
	$status = 1;

	$agent_details = $agent->get_agentProfile();
	$agentId = $agent_details['ID'];
	$profile_name = $agent_details['User_ID'];
	$Business_Name = $agent_details['Business_Name'];
	$agent_token = $agent_details['token'];
	$agent_last_seen = $agent_details['last_seen'];

	$messages = $agent_details['messages'];
	$followings = $agent_details['followings'];
	$client_followers = $agent_details['c_followers'];
	$agent_followers = $agent_details['a_followers'];
	$total_uploads = $agent_details['uploads'];
	$notifications = $agent_details['notifications'];
	$user = $profile_name;
 
	$all_cta_requests = count($data->get_all_cta_requests());

//pop new notifications
$onPageLoadPopup = $agent->get_notification($agentId,$agent_last_seen);

	//if last seen is more than 5days
$five_days = 5 * $oneDay;
//$five_days = 1;
	if((time()- $agent_last_seen) >= $five_days ){
	$onPageLoadPopup =	$agent->longTimeWelcome($Business_Name,$agent_last_seen);
	}

	}


//get Client details
else if($client->check_status()=='active'){
	$status = 9;
	$cta_details = $client->get_ctaProfile();

$cta_name = $cta_details['name'];
$ctaid = $cta_details['ctaid'];
$client_token = $cta_details['token'];
$expiry_date = date('D, d M Y ',$cta_details['expiryTime']);
$seconds_before_expiry = $cta_details['seconds_left'];
$hours_before_expiry = round($seconds_before_expiry/3600);
$days_before_expiry = round($seconds_before_expiry/86400);

$request_status = $cta_details['request'];
$messages = $cta_details['messages'];
$followings = $cta_details['followings'];
$notifications = $cta_details['notifications'];
$client_last_seen = $cta_details['last_seen'];
$request_type = $client->get_request($ctaid,$cta_name)['type'];
$request_maxprice = $client->get_request($ctaid,$cta_name)['maxprice'];
$request_location = $client->get_request($ctaid,$cta_name)['location'];

$matches_array = $client->get_matches($request_type,$request_maxprice,$request_location);

$clipped_array = $client->get_clipped($ctaid,$cta_name);
$matches = count($matches_array);
$clipped = count($clipped_array);

$suggestions_array = $client->get_suggestions($ctaid);
$total_suggestions = count($suggestions_array);


$user = $cta_name;

$sevenDays = 7 * $oneDay;

//gettin new suggestions since last since
$ns = "SELECT properties.directory AS dir, properties.property_ID AS pid, properties.type AS type, properties.rent AS rent,
		properties.location AS location,profiles.Business_Name AS agent,profiles.User_ID AS agent_username,property_suggestion.timestamp AS time_suggested 
		FROM property_suggestion INNER JOIN properties ON (properties.property_ID = property_suggestion.property_id) 
		INNER JOIN profiles ON (property_suggestion.agent_id = profiles.ID) 
		WHERE (property_suggestion.client_id = $ctaid AND property_suggestion.timestamp > $client_last_seen) ORDER BY time_suggested DESC";
$total_new_suggestions = $db->query_object($ns)->num_rows;
$get_new_suggestion = $db->query_object($ns." LIMIT 2");
if($get_new_suggestion->num_rows > 0){
	$new_suggestion_notice = "<h1><span class=\"subject\">$cta_name</span>, You have $total_new_suggestions new property suggestions</h1><hr class=\"grey\" />";
	$new_suggestion_notice .= "<div style=\"text-align:left\">";
	while($new_sugg = $get_new_suggestion->fetch_array(MYSQLI_ASSOC)){
		$new_suggestion_notice .= "<div style=\"border-bottom:1px solid #e3e3e3;margin-bottom:5px;\">
									<ul style=\"list-style-type:none\">
									<li><b>".$new_sugg['type']."</b></li>
									<li>Rent :<b>".number_format($new_sugg['rent'])."</b></li>
									<li><span class=\"glyphicon glyphicon-map-marker\"></span>".$new_sugg['location']."</li>
									<p style=\"text-align:right\"><a href=\"$root/properties/".$new_sugg['dir']."\">See more details</a></p>
									</ul>";
		$new_suggestion_notice .= "<p style=\"color:grey\">suggested by <a href=\"$root/".$new_sugg['agent_username']."\">".$new_sugg['agent']."</a></p>";
		$new_suggestion_notice .= "<p class=\"text-right font-12 grey\"><span class=\"glyphicon glyphicon-time\"></span>".$general->since($new_sugg['time_suggested'])."</p>";
		$new_suggestion_notice .= "</div>";
	}
$new_suggestion_notice .= "<a href=\"$root/cta/?src=suggestions\">See all suggestions</a>
							</div>";

}

if(isset($new_suggestion_notice) && $new_suggestion_notice != ""){
$onPageLoadPopup = 	$new_suggestion_notice;
}

//if redirected from the checkin page. The $_GET['_rq'] pass the the request status
//or if last seen is more than 3 days and haven't placed request
if((isset($_GET['_rq']) && $_GET['_rq']==0) ||(time() - $client_last_seen >= 3*$oneDay && $request_status==0))
{ 
$onPageLoadPopup = "<h1>Hello <span id=\"subject\">$cta_name</span></h1>
						<p>Please note that you have not made any request yet. Place a request now so we can help you find
						matches for property of apartment of your choice</p><br/>
						<a href=\"$root/cta/request.php?p=".$_GET['_rq']."\" class=\"link-inside-modal\">Place Request Now</a>
";
}

if((time() - $client_last_seen) >= $sevenDays){
$onPageLoadPopup = "<h1>Hello <span id=\"subject\">$cta_name</span></h1>
						<p>It's been a while you checked in here</p>
";
}
if(($days_before_expiry <= 5) && (time()-$client_last_seen >= 2*$oneDay)){
$onPageLoadPopup = "<h1>Hello <span id=\"subject\">$cta_name</span></h1>
						<p>Please note that your CTA will expire in <span style=\"font-size:150%\"> $days_before_expiry days </span>, if you haven't found what you are 
						looking for, renew your  CTA. if you have already found what you need, you can deactivate this CTA
						</p>
						<a class=\"deepblue-inline-block-link\" href=\"\">Renew CTA</a>
						<a class=\"deepblue-inline-block-link\" href=\"\">Deactivate CTA</a>
";	
}
//First checkin
if( $client_last_seen == 0){
$onPageLoadPopup = "<h1>Hello <span id=\"subject\">$cta_name</span></h1>
						<h2>Thank you for creating Client Temporary Account (CTA) !</h2>
						<p>We are here to help you get apartment or property of your choice by linking you to
						numerous agent on our site.</p> 
						<h3>This is how we work:</h3>
						 You make a request on the kind of property you want by specifying the <b>type</b>,<b> maximum 
						rent</b> and the <b>location</b> where you want it; As agents upload their several properties on the site, we
						notify you of any property that matches your request ...<a href=\"\">Learn more</a></p>
						<a class=\"link-inside-modal\" href=\"$root/cta/request.php?p=$request_status\"> Place Request</a>
						<a class=\"link-inside-modal\" href=\"$root/agents\">See Agents</a>";
}


}
else{
	$status = 0;
	$user = "visitor";
}
$now = time();
$thisPage = "http".(isset($_SERVER['HTTPS']) ? 's' : '').'://192.168.173.1'.$_SERVER['REQUEST_URI'];

/*
$onPageLoadPopup = "<h3 style=\"color:white;font-weight:normal\">I just want to start working on the notification, but right now i am so tired, i need some break
But then i just decided to do this animation, it's not part of the Todo for this project though</h3>"; 
$onPageLoadPopup .= "<script>animateBackgroundColor('.modal-inner')</script>";
*/
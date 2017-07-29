<?php
/*
This script must first be required in any script because all other information on every other script depends on the variables in this one
*/

require('site_config.php');
$unavailable_page =  "
<html>
<head><title>Page not Available!</title></head>
<body style=\"background-color:purple;\">
<div style=\"padding:1%; width:70%;margin:auto; line-height:200%; background-color:white; color:purple;border-radius:5px\">
<h2 align=\"center\">Page temporarily not available.</h2>
<p align=\"center\">This page you are trying to view is temporarily not available, it may be under maintainance. We are sorry for any inconviniency this might bring you. You can <a href=\"$root\">visit our homepage</a></p>
</div>
</body>
</html>";

error_reporting( E_ALL | E_ERROR | E_STRICT | E_PARSE);
function handleError($e_no, $e_str,$e_file,$e_line){
        echo "<pre>SCRIPT ERROR: There an error[$e_no] <b>$e_str</b> in $e_file line $e_line </pre>";
    }
set_error_handler("handleError");

/*******MYSQLI CONNECTION****************/
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

 $connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
if ($connection->connect_error) {
 error::report_mysqli_error($mysqli_obj->connect_error,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
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
    //if there was error in the query, return the error string...
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
         echo "connection closed";
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
<body style=\"background-color:purple;\">
<div style=\"padding:10%; line-height:200%;color:white; text-align:center\">
<img src=\"".general_config::$root."/resrc/gifs/icon-wlan.gif\" style=\"width:70px; height:50px\"/>
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
		$since = $time.' seconds ago';
	}
	else if($time>=60 && $time<3600){
		$since = round(($time/60)).' minutes ago';
	}
	else if($time>=3600 && $time<86400){
		$since = round(($time/3600)).' hours, '.(($time/60)%60).' minutes ago';
	}
	else if($time>=86400 && $time<604800){
		$since = round(($time/86400)).' days ago, '.date('l, M d ',$timestamp);
	}
	else if($time>=604800 && $time<18144000){
		$since =round(($time/604800)).' weeks ago, '.date('M d  ',$timestamp);
	}
	else{
		$since = "invalid time";
	}
return $since;
		}

function display_notification($subject,$subjecttrace,$action,$timestamp,$howold){
	$time = time() - $timestamp;
if($howold=="yesterday"){
	$since = "Yesterday at ".date('h:i a ',$timestamp);
}
else{
$since = $this->Timestamp($timestamp);
}
	
	switch($action){
	//if it is a client following an agent, specify the client need
		case 'C4Afollow':
		$requests = mysql_query("SELECT * FROM cta_request WHERE (ctaid='$subjecttrace')");
		if(mysql_num_rows($requests)!=0){
			$get=mysql_fetch_array($requests,MYSQL_ASSOC);
			$reqtype = $get['type'] ;
			$reqmaxprice =$get['maxprice'];
			$reqlocation = $get['location'];
			$xtra = "<p style=\"font-style:normal;\">This client needs $reqtype with rent not more than N".number_format($reqmaxprice)." around $reqlocation <a href=\"\">Suggest a property for this client</a></p>";
					
		}
		else{
			$xtra="<p>This client has no specific preference <a href=\"\">Suggest a property for this client</a></p>";
		}
		return "<div class=\"client-follow-notice\">
					+<span class=\"black-icon user-icon\"></span>A client <a href=\"$root/cta/ctarequests/?target=$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"time\">$since</p>
					 $xtra</div>";
		break;
		
		case 'A4Afollow':
		return "<div class=\"notice\">
					+<span class=\"black-icon user-icon\" ></span>An agent <a href=\"$root/$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"time\">$since</p>
						</div>";
		break;
		

		case 'CTA created':
		return "<div class=\"notice\">
					+<span class=\"black-icon user-icon\"></span>You created your CTA as $subject
					 <p class=\"time\">$since</p>
					 
						</div>";
		break;
		case '':
		break;
	}
}


	//This function verify if a file is an image
function is_image($filename){
	$allowed = array(".png",".jpg",".jpeg");
	if (stripos($filename,".png") ==0){
		return null;
	}
	else{
		return $filename;
	}
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
	return $uploads;
	}
}
	function notifications($target){
        GLOBAL $db;
$notifications = $db->query_object("SELECT * FROM notifications WHERE receiver='$target' AND status='unseen'")->num_rows;	 
return $notifications;
	}
}


class property{

  static $property_query = "SELECT property.property_ID AS id, property.directory AS dir,
        property.type AS type, property.location AS location, property.rent AS rent,
        property.min_payment AS mp, property.bath AS bath, property.toilet AS toilet,
        property.description AS description, property.timestamp AS since,property.last_reviewed AS lastReviewed,
        property.views AS views, property.status AS status, agent.Business_Name AS agentBussinessName,
        agent.User_ID AS agentUserName , agent.Office_Address AS agentOfficeAdd, agent.Office_Tel_No AS agentOfficeNo,
        agent.Phone_No AS agentNo,agent.Alt_Phone_No AS agentAltNo,agent.token AS agenttoken
        FROM properties AS property INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby)";

/*This function is for clipping*/
function clip($property_id,$clipper,$ref_page){
GLOBAL $db;
GLOBAL $root;
 $clipbutton_id = $property_id.'clipbutton';

$check_clip = $db->query_object("SELECT * FROM clipped WHERE propertyid='$property_id' AND clippedby=$clipper");
if($check_clip->num_rows == 1){
$unclip_button = "<a  class=\"unclip-button\"  href=\"$root/resources/php/ajax_scripts/clip.php?p=$property_id&cb=$clipper&ref=$ref_page\" id=\"$clipbutton_id\" onclick=\"makeclip('$clipbutton_id',$clipper,'$ref_page')\"><span class=\"black-icon minus-icon\"></span>unclip</a>";
return $unclip_button;
		}
else{
$clip_button = "<a  class=\"clip-button\"  href=\"$root/resources/php/ajax_scripts/clip.php?p=$property_id&cb=$clipper&ref=$ref_page\" id=\"$clipbutton_id\" onclick=\"makeclip('$clipbutton_id',$clipper,'$ref_page')\"><span class=\"black-icon plus-icon\"></span>clip</a>";
return $clip_button;
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
    $unfollow_button = "<span  style=\"float:right\" >
				<p style=\"color:grey;font-size:12px;text-align:center;margin:0px\" id=\"$followingId-follow-status\">Following</p>
				<button style=\"float:right\" class=\"unfollow-button\" id=\"$following_username$followingId\" onclick=\"follow('$following_username$followingId',$followerId,'$follower_name','$follower_username',$followingId,'$following_name','$following_username','$type')\" ><span class=\"white-icon unfollow-icon\"></span>unfollow</button>
				</span>";
            return $unfollow_button;
        }
        else{
    $follow_button = "<span  style=\"float:right\" >
	<p style=\"color:grey;font-size:14px;text-align:center;margin:0px;padding:0px\" id=\"$followingId-follow-status\"></p>
	<button  class=\"follow-button\" id=\"$following_username$followingId\" onclick=\"follow('$following_username$followingId',$followerId,'$follower_name','$follower_username',$followingId,'$following_name','$following_username','$type')\" ><span class=\"black-icon follow-icon\"></span>follow</button>
	</span>";
            return $follow_button;
        }
    }
}
	function get_agentProfile(){
		GLOBAL $general;
        GLOBAL $db;
		$agentcookie = $general->get_cookie('user_agent');
		$agentProfile = array();

if($agentcookie != null){

 $getProfile = $db->query_object("SELECT ID,Business_Name,User_ID,token FROM profiles WHERE (token='$agentcookie')");
		 if(is_object($getProfile)){
             //if profiles still exist
             if($getProfile->num_rows != 0){
			 $records = $getProfile->fetch_array(MYSQLI_ASSOC);
            $agentProfile['ID'] = $records['ID'];
            $agentProfile['Business_Name'] = $records['Business_Name'];
            $agentProfile['User_ID'] = $records['User_ID'];
            $agentProfile['token'] = $records['token'];
			 
             //Other agent data
			GLOBAL $data;
            $agentProfile['messages'] = $data->messages($records['Business_Name']);
			$agentProfile['notifications'] = $data->notifications($records['Business_Name']);
			$agentProfile['a_followers'] = count($data->agent_followers($records['ID']));
			$agentProfile['c_followers'] = count($data->client_followers($records['ID']));
			$agentProfile['followings'] = count($data->agent_followings($records['ID']));
			$agentProfile['uploads'] = count($data->get_uploads($records['ID'],$records['User_ID']));

           
            $getProfile->free();
             }
         }else{
			 error::report_error($getProfile,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		 }
	}
	return $agentProfile;
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
$getCTA = $db->query_object("SELECT ctaid,name,request,timeCreated,expiryTime,token FROM cta WHERE (token='$ctacookie')");
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
			$ctaProfile['notifications'] = $data->notifications($records['name']);
			$ctaProfile['followings'] = count($data->client_followings($records['ctaid']));
			$ctaProfile['seconds_left'] = $records['expiryTime'] - $now;



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
 
 		}//end of cta class
				
		 

class error{
    static function report_mysqli_error($bug,$file,$class,$function,$line){
          echo "<b>mysqli error:</b> [$bug] in $file, <b>$class::$function</b> in line $line<br/>";
    }
    static function report_error($msg,$file,$class,$function,$line){
        echo "<span style=\"color:red\">error:</span> $msg <br/><b>source:</b> [$file >> $class :: $function >> near line $line]";
    }
    }



/*
*This bottom part set user variables
*/

//get agent details if logged in
if($agent->check_status()=='active'){
	$status = 1;

	$agent_details = $agent->get_agentProfile();
	$agentId = $agent_details['ID'];
	$profile_name = $agent_details['User_ID'];
	$Business_Name = $agent_details['Business_Name'];
	$agent_token = $agent_details['token'];

	$messages = $agent_details['messages'];
	$notifications = $agent_details['notifications'];
	$followings = $agent_details['followings'];
	$client_followers = $agent_details['c_followers'];
	$agent_followers = $agent_details['a_followers'];
	$total_uploads = $agent_details['uploads'];
	$user = $profile_name;

}


//get Client details
else if($client->check_status()=='active'){
	$status = 9;
	$cta_details = $client->get_ctaProfile();

$cta_name = $cta_details['name'];
$ctaid = $cta_details['ctaid'];
$expiry_date = date('D, d M Y ',$cta_details['expiryTime']);
$seconds_before_expiry = $cta_details['seconds_left'];
$hours_before_expiry = round($seconds_before_expiry/3600);
$days_before_expiry = round($seconds_before_expiry/86400);

$request_status = $cta_details['request'];
$messages = $cta_details['messages'];
$notifications = $cta_details['notifications'];
$followings = $cta_details['followings'];
$request_type = $client->get_request($ctaid,$cta_name)['type'];
$request_maxprice = $client->get_request($ctaid,$cta_name)['maxprice'];
$request_location = $client->get_request($ctaid,$cta_name)['location'];
$matches_array = $client->get_matches($request_type,$request_maxprice,$request_location);

$clipped_array = $client->get_clipped($ctaid,$cta_name);
$matches = count($matches_array);
$clipped = count($clipped_array);

$user = $cta_name;
}
else{
	$status = 0;
	$user = "visitor";
}
$now = time();
//echo $user. " is currently active";



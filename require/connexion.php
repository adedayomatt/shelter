<?php
require('../phpscripts/site_config.php');
/*
This script must first be required in any script because all other information on every other script depends on the variables in this one
*/

$root = general_config::$root;

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

/*************CLASSES***********************/



class database{
	function connect(){
DEFINE ('HOST', 'localhost');
DEFINE ('USER', 'adedayo');
DEFINE ('PASSWORD', 'matthew');
DEFINE ('DB', 'shelter');

$connection_error_msg = "
<html>
<head><title>Connection failed!</title></head>
<body style=\"background-color:purple;\">
<div style=\"padding:10%; line-height:200%;color:white; text-align:center\">
<img src=\"".general::$root."/resrc/gifs/icon-wlan.gif\" style=\"width:70px; height:50px\"/>
<h2 align=\"center\">No Connection to Server</h2>
<p align=\"center\">Connection to the server could not be established. We are sorry for any inconviniency this might bring you and please be assured that we are working hard to resolve it soon</p>
</div>
</body>
</html>";

$mysqli = new MySQLi(HOST,USER,PASSWORD,DB);
if ($mysqli->connect_error) {
echo $mysqli->connect_error;
unset($mysqli);

return $connection_error_msg;
	}
	else{
		return 'connection successful';
	}
}
}
class general extends general_config{
	
function redirect($to){
	header("location: $this->root/$to");
	exit();
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

function now(){
	return time();
}
//This function takes care of timestamp
function since($timestamp){
	$time = $this->now() - $timestamp;
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


//end of general class
}


class agent_client_data{
	function messages($target){
$unread_messages = mysql_num_rows(mysql_query("SELECT * FROM messages WHERE receiver='$target' AND status='unseen'"));
return $unread_messages;
	}

	function following($target){
 $following = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE follower='$target'"));	
return $following;
	}

	function client_followers($target){
 $clientfollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$target' AND followtype='C4A'"));	
return $clientfollower;
	}

	function agent_followers($target){
 $agentfollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$target' AND followtype='A4A'"));	
return $agentfollower;
	}

	function notifications($target){
$notifications = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE receiver='$target' AND status='unseen'"));	 
return $notifications;
	}
}

class property{
/*
This function  randomly generate a unique Id for a newly uploaded property.
*/
function generate_property_id(){
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
	$fetchId = mysql_query("SELECT property_ID FROM properties");
	//if fetching the IDs is successfull...
	if($fetchId){
	//if there is any match with the final id, then recurse the function generateid() until no match is found
if(in_array($final,mysql_fetch_array($fetchId))){
$this->generate_property_id();
}
else{
	return $final;	
		}	
	}
	//if query to fetch id is unsucessful
	else{
		return 'error';
		}
	}


//end of general class
}

class agent extends agent_config{

function check_status(){
	if(!empty($this->get_agentProfile())){
		return 'active';
	}
}
	function get_agentProfile(){
		$general_obj = new general();
		$agentcookie = $general_obj->get_cookie('user_agent');
		$agentProfile = array();

if($agentcookie != null){

 $getProfile = mysql_query("SELECT ID,Business_Name,User_ID,token FROM profiles WHERE (token='nil')");
		 if($getProfile ){
			 $agentProfile = mysql_fetch_array($getProfile,MYSQL_ASSOC);

			 //Other agent data
			$agent_data = new agent_client_data();
		 	$agentProfile['messages'] = $agent_data->messages($agentProfile['Business_Name']);
			$agentProfile['notifications'] = $agent_data->notifications($agentProfile['Business_Name']);
			$agentProfile['a_followers'] = $agent_data->agent_followers($agentProfile['Business_Name']);
			$agentProfile['c_followers'] = $agent_data->client_followers($agentProfile['Business_Name']);
			$agentProfile['followings'] = $agent_data->following($agentProfile['Business_Name']);
		 }else{
			 //unsuccessful query
		 }
	}
	return $agentProfile;
}

//end of agent class
}

class cta extends cta_config{
  
	function get_ctacookie(){
		if(isset($_COOKIE['CTA'])){
return $_COOKIE['CTA'];
		}
		else{
			return null;
		}
	}

	function check_status(){
			 if(!empty($this->get_ctaProfile())){
				 if(get_ctaProfile()['seconds_left'] < 0){
					 $general_obj = new general();
					$general_obj->redirect('logout');
				 }
				  else{
 					return 'active';
			 		}
			 } 	
	}

	function get_ctaProfile(){
		$ctaProfile = array();
		$general_obj = new general();
		$ctacookie = $general_obj->get_cookie('CTA');
if($ctacookie != null){
$getCTA = mysql_query("SELECT ctaid,name,request,timeCreated,expiryTime FROM cta WHERE (ctaid='$ctacookie')");	
//if CTA is found...
if($getCTA && mysql_num_rows($getCTA)==1){
			$now = time();
			 $ctaProfile = mysql_fetch_array($getCTA,MYSQL_ASSOC);

	//Other profile data
	$cta_data = new agent_client_data();
			$ctaProfile['messages'] = $cta_data->messages($ctaProfile['name']);
			$ctaProfile['notifications'] = $cta_data->notifications($ctaProfile['name']);
			$ctaProfile['followings'] = $cta_data->following($ctaProfile['name']);
			$ctaProfile['seconds_left'] = $ctaProfile['expiryTime'] - $now;
	}
else{
//unsuccessfull query
}
		}
return $ctaProfile;
	}

function get_request(){
		$cta_request = array();

if($this->check_status() == 1){
//get request 
$rq = mysql_query("SELECT * FROM cta_request WHERE (ctaid='".get_ctaProfile()['ctaid']."')");
if($rq){
$cta_request = mysql_fetch_array($rq,MYSQL_ASSOC);
		}
else{
//unsuccefull query
}

	}
else{
	//no cta available
}	
return $cta_request;
	}

function get_matches(){
$cta_matches = array();
//get matches id after the requests data has been retrieved and get the number of rows that mathes the request
if(!empty($this->get_request())){
$getCTAmatches = mysql_query("SELECT property_ID FROM properties WHERE (type='".$this->get_request()['type']."' AND rent<=".$this->get_request()['maxprice']." AND location LIKE '%".$this->get_request()['location']."%')");
	$cta_matches = mysql_fetch_array($getCTAmatches,MYSQL_ASSOC);
			 }
		else{
			//no request
		}

return $cta_matches;
}
 
function get_clippedProperties(){
	$clipped = array();

	if($this->check_status()==1){
$getclipped = mysql_query("SELECT * FROM clipped WHERE clippedby='".$this->get_ctaProfile()['ctaid']."'");
if($getclipped){
	$clipped = mysql_fetch_array($getclipped,MYSQL_ASSOC);
		
}else{
	//unsuccessfull query
}
	}

return $clipped;
}
 
 		//end of cta class
				}
		 
/*$general_config_obj = new general_config();
$client_obj = new cta();*/



?>




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

/*************CLASS OBJECTS***********************/
$db = new database();
$general = new general();
$data = new agent_client_data();
$property = new property();
$client = new cta();
$agent = new agent();

/*************CLASSES***********************/


class database{

	function connect(){
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

 $mysqli_obj = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
if ($mysqli_obj->connect_error) {
 error::report_mysqli_error($mysqli_obj->connect_error,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
unset($mysqli_obj);
general::no_connection_page();
die();
	}
	else{
		return $mysqli_obj;
	}
}

/*
This function select records from the database and return a 2-dimensional array data[0..][columns] if columns are specified
in the query and return just the query resul object if all columns (*) are selected 
*/
function select($table,$columns,$condition,$others){
   
   $mysqli = $this->connect();

   if(is_object($mysqli)){
     
   if($columns != '*'){
    //split the columns
   $columns_array = split(',',$columns);
    $index = 0;
    $data = array();

if($condition == 'all'){
     $q = "SELECT $columns FROM $table $others";  
    }
    else{
        $q  = "SELECT $columns FROM $table WHERE ($condition) $others";
    }


 $query = $mysqli->query($q);
   if($mysqli->error){
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

 function query_object($query){
$mysqli = $this->connect();
$obj = null;

$obj = $mysqli->query($query);
if($mysqli->error){
    //if there was error in the query, return the error string...
 return "<b>".__CLASS__."::".__FUNCTION__."</b> in ".__FILE__." line <b>".__LINE__ ."</b> failed.<br/> <b>Reason:</b>\"<i>\"$mysqli->error\"</i>\"";
   }
//else return the query result object;
   else{
return $obj;
         }
    }    

function close(){
    $mysqli = $this->connect();
if(is_object($mysqli )){
     if($mysqli->close()){
         echo "connection closed";
              }
        }
    }

}//end of class


class general{

function redirect($to){
    $goto = ($to==null ? general_config::$root : general_config::$root."/$to");
	header("location: $goto");
	exit();
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

}//end of general class

class agent_client_data{

	function messages($target){
        GLOBAL $db;
$unread_messages = $db->query_object("SELECT * FROM messages WHERE receiver='$target' AND status='unseen'")->num_rows;
return $unread_messages;
	}

	function following($target){
        GLOBAL $db;
 $following = $db->query_object("SELECT * FROM follow WHERE follower='$target'")->num_rows;	
return $following;
	}

	function client_followers($target){
         GLOBAL $db;
 $clientfollower = $db->query_object("SELECT * FROM follow WHERE following='$target' AND followtype='C4A'")->num_rows;	
return $clientfollower;
	}

	function agent_followers($target){
         GLOBAL $db;
 $agentfollower = $db->query_object("SELECT * FROM follow WHERE following='$target' AND followtype='A4A'")->num_rows;	
return $agentfollower;
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
        agent.Phone_No AS agentNo,agent.Alt_Phone_No AS agentAltNo
        FROM properties AS property INNER JOIN profiles AS agent ON (agent.User_ID = property.uploadby) 
        ORDER BY since DESC ";
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
    $existing_ids = $db->select('properties','property_ID','all',null);
	//if fetching the IDs is successfull...
    if(is_array($existing_ids)){
        if(in_array($final,$existing_ids)){
$this->generate_property_id();
        }
        else{
    return $final;
        }
    }
else{
        error::report_error('Unable to generate new property Id',__FILE__,__CLASS__,__FUNCTION__,__LINE__);
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
function follow($agentBusinessName,$agentusername, $follower,$followerid,$status){
        GLOBAL $db;
        if($status == 1 || $status==9){
        $followtype = ($status==1 ? 'A4A' : 'C4A');
    $get_follow = null;
    $get_follow = $db->query_object("SELECT * FROM follow WHERE (follower = '$follower' AND following = '$agentBusinessName')");
    if(is_string($get_follow)){
        error::report_error($get_follow,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
    }
    else{
        if($get_follow->num_rows == 1){
    $unfollow_button = "<button style=\"float:right\" class=\"unfollow-button\" id=\"$agentusername\" onclick=\"follow('$agentusername','$follower','$followerid','$agentBusinessName','$followtype')\" ><span class=\"white-icon unfollow-icon\"></span>unfollow</button>";
            return $unfollow_button;
        }
        else{
    $follow_button = "<button style=\"float:right\" class=\"follow-button\" id=\"$agentusername\" onclick=\"follow('$agentusername','$follower','$followerid','$agentBusinessName','$followtype')\" ><span class=\"black-icon follow-icon\"></span>follow</button>";
            return $follow_button;
                   }
             }
        }
        else{
    $dummy_follow_button = "<button style=\"float:right\" class=\"follow-button\" id=\"$agentusername\" onclick=\"follow('$agentusername','$follower','$followerid','$agentBusinessName','$followtype')\" ><span class=\"black-icon follow-icon\"></span>follow</button>";
return $dummy_follow_button;
        }
}
	function get_agentProfile(){
		GLOBAL $general;
        GLOBAL $db;
		$agentcookie = $general->get_cookie('user_agent');
		$agentProfile = array();

if($agentcookie != null){

 $getProfile = $db->query_object("SELECT ID,Business_Name,User_ID,token FROM profiles WHERE (token='nil')");
		 if(is_object($getProfile) ){
			 $agentProfile = $getProfile->fetch_array(MYSQLI_ASSOC);
			 //Other agent data
			GLOBAL $data;
		 	$agentProfile['messages'] = $data->messages($agentProfile['Business_Name']);
			$agentProfile['notifications'] = $data->notifications($agentProfile['Business_Name']);
			$agentProfile['a_followers'] = $data->agent_followers($agentProfile['Business_Name']);
			$agentProfile['c_followers'] = $data->client_followers($agentProfile['Business_Name']);
			$agentProfile['followings'] = $data->following($agentProfile['Business_Name']);
		 }else{
			 //unsuccessful query
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
			 if(!empty($this->get_ctaProfile())){
				 if(get_ctaProfile()['seconds_left'] < 0){
					$general->redirect('logout');
				 }
				  else{
 					return 'active';
			 		}
			 } 	
	}

	function get_ctaProfile(){
        GLOBAL $general;
		$ctaProfile = array();
		$ctacookie = $general->get_cookie('CTA');
if($ctacookie != null){
$getCTA = mysql_query("SELECT ctaid,name,request,timeCreated,expiryTime FROM cta WHERE (ctaid='$ctacookie')");	
//if CTA is found...
if($getCTA && mysql_num_rows($getCTA)==1){
			$now = time();
			 $ctaProfile = mysql_fetch_array($getCTA,MYSQL_ASSOC);

	//Other profile data
GLOBAL $data;
			$ctaProfile['messages'] = $data->messages($ctaProfile['name']);
			$ctaProfile['notifications'] = $data->notifications($ctaProfile['name']);
			$ctaProfile['followings'] = $data->following($ctaProfile['name']);
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
		 

class error{
    static function report_mysqli_error($bug,$file,$class,$function,$line){
          echo "<b>mysqli error:</b> [$bug] in $file, <b>$class::$function</b> in line $line<br/>";
    }
    static function report_error($msg,$file,$class,$function,$line){
        echo "<span style=\"color:red\">error:</span> $msg <br/><b>source:</b> [$file >> $class :: $function >> near line $line]";
    }
    }



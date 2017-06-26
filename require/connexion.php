<?php
/*
This script must first be required in any script because all other information on every other script depends on the variables in this one
*/

//$root = "http://localhost/shelter";
$root = "http://192.168.173.1/shelter";
if(isset($connect) and $connect==true){
$dbhost = '127.0.0.1';
$dbuser = 'adedayo';
$dbpass = 'matthew';
$db_connection = @mysql_connect($dbhost, $dbuser, $dbpass);
if($db_connection) {
mysql_select_db('shelter');
}
else{
	echo "
<html>
<head><title>Connection failed!</title></head>
<body style=\"background-color:purple;\">
<div style=\"padding:10%; line-height:200%;color:white; text-align:center\">
<img src=\"$root/resrc/gifs/icon-wlan.gif\" style=\"width:70px; height:50px\"/>
<h2 align=\"center\">No Connection to Server</h2>
<p align=\"center\">Connection to the server could not be established. We are sorry for any inconviniency this might bring you and please be assured that we are working hard to resolve it soon</p>
</div>
</body>
</html>";
exit(); 
}
}
else{
	echo "
<html>
<head><title>Page not Available!</title></head>
<body style=\"background-color:purple;\">
<div style=\"padding:1%; width:70%;margin:auto; line-height:200%; background-color:white; color:purple;border-radius:5px\">
<h2 align=\"center\">Page temporarily not available.</h2>
<p align=\"center\">This page you are trying to view is temporarily not available, it may be under maintainance. We are sorry for any inconviniency this might bring you. You can <a href=\"$root\">visit our homepage</a></p>
</div>
</body>
</html>";
exit(); 
}


//if user is logged in as an agent
if(isset($_COOKIE['name']) ){
	$status = 1;
	 $profile_name=$_COOKIE['name'];
//Get the business information
		 $getBussinessName = mysql_query("SELECT ID,Business_Name FROM profiles WHERE (User_ID='$profile_name')");
		 if($getBussinessName && mysql_num_rows($getBussinessName)==1){
			 $biz = mysql_fetch_array($getBussinessName,MYSQL_ASSOC);
				 $Business_Name = $biz['Business_Name'];
				 $myid  = $biz['ID'];
		 }else{
			 $Business_Name = "couldn't reach profile";
		 }

//get the number of notifications, followers, following corresponding to the user
$messages = mysql_num_rows(mysql_query("SELECT * FROM messages WHERE receiver='$Business_Name' AND status='unseen'"));
$notifications = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE receiver='$Business_Name' AND status='unseen'"));	 
 $following = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE follower='$Business_Name'"));	
 $clientfollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$Business_Name' AND followtype='C4A'"));	
 $agentfollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$Business_Name' AND followtype='A4A'"));	
		
	}
	
//if a CTA account is logged in
else if(isset($_COOKIE['CTA'])) {
	$ctaid = $_COOKIE['CTA'];
	$status = 9;
//get CTA data
	$CTAmatches = array();
$matchcounter = 0;
	$k=0;
//get CTA 	
$getCTA = mysql_query("SELECT ctaid,name,request,timeCreated,expiryTime FROM cta WHERE (ctaid='$ctaid')");
	 if($getCTA && mysql_num_rows($getCTA)==1){
//if CTA is found...
	 if(mysql_num_rows($getCTA)==1){
			$now = time();
			 $cta = mysql_fetch_array($getCTA,MYSQL_ASSOC);
				 $ctaname = $cta['name'];
				 $myid  = $cta['ctaid'];
				 $rqstatus = $cta['request'];
				 $timeCreated = $cta['timeCreated'];
				 $expiryTime = $cta['expiryTime'];
				 $secondsLeft = $expiryTime - $now;
//if CTA has expired, log it out immediately, so the cookies can be cleared
	if($secondsLeft<0){
	header("location: $root/logout");
exit();	
	}
//Give a major notification as per how many days remaining when the remaining days is <= 6 days
else if($secondsLeft <= (86400 * 7)){
	$remainingDays = (int) (($expiryTime-$now)/86400);
	$remainingDaysNotice = "<h1>NOTICE</h2>
							<p>This CTA will expire ".($remainingDays >=1? "in <strong class=\"cta-time-remaining\">$remainingDays days</strong> time.":($remainingDays <1 ? "in the next <strong class=\"cta-time-remaining\"><span id=\"hours-countdown\" onload=\"timecountdown('hours-countdown',$secondsLeft)\">".(int)(($expiryTime-$now)/3600)." hours.</strong></span>" : "in an unknown time"))."
							<a id=\"\" href=\"#\">Renew CTA</a></p>";
}
//if request has been placed
if($rqstatus==1){
//get request 
$rq = mysql_query("SELECT * FROM cta_request WHERE (ctaid='$ctaid')");
if($rq){
$request = mysql_fetch_array($rq,MYSQL_ASSOC);
 $rqtype = $request['type'];
 $rqpricemax = $request['maxprice'];
 $rqlocation = $request['location'];
 
		}
	}
 //get matches id after the requests data has been retrieved and get the number of rows that mathes the request
if(isset($rqtype) && isset($rqpricemax) && isset($rqlocation)){
$getCTAmatches = mysql_query("SELECT property_ID FROM properties WHERE (type='$rqtype' AND rent<=$rqpricemax AND location LIKE '%$rqlocation%')");
	$matchcounter = mysql_num_rows($getCTAmatches);
	while($match=mysql_fetch_array($getCTAmatches,MYSQL_ASSOC)){
		$CTAmatches[$k]=$match['property_ID'];
		$k++;
	}
			 }
				}
		 
//get clipped
$getclipped = mysql_query("SELECT * FROM clipped WHERE clippedby='$ctaid'");
if($getclipped){
	$c = 0;
	$clipcounter = mysql_num_rows($getclipped);
	while($clipped = mysql_fetch_array($getclipped,MYSQL_ASSOC)){
		$clippedproperty[$c] = $clipped['propertyId'];
		$c++;
	}
}
else{
	$clipcounter = 999;
}
$messages = mysql_num_rows(mysql_query("SELECT * FROM messages WHERE receiver='$ctaname' AND status='unseen'"));
	$notifications = mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE receiver='$ctaname' AND status='unseen'"));
$following = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE follower='$ctaname'"));

}
else{
	//if the cta info cannot be get, clear cookie and redirect to checkin
	setcookie('CTA',"",time()-60,"/","",0);
	mysql_close($db_connection);
		header("location: $root/cta/checkin.php");
	
	exit();
		 }
}
 //if user is not logged in as either agent or client
else{
	$status = 0;
}



/*****************************************************************************************************/
/*functions*/
function redirect(){
	header("location: $root/login");
	exit();
}

//This function takes care of timestamp
function Timestamp($timestamp){
	$time = time() - $timestamp;
	if($time<60){
		$since = $time.' seconds ago';
	}
	else if($time>=60 && $time<3600){
		$since = (int)($time/60).' minutes ago';
	}
	else if($time>=3600 && $time<86400){
		$since = (int)($time/3600).' hours, '.(($time/60)%60).' minutes ago';
	}
	else if($time>=86400 && $time<604800){
		$since = (int)($time/86400).' days ago, '.date('l, M d ',$timestamp);
	}
	else if($time>=604800 && $time<18144000){
		$since =(int)($time/604800).' weeks ago, '.date('M d  ',$timestamp);
	}
	else{
		$since = "sometime ago";
	}
return $since;
		}
?>





<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle = "Notifications";
$ref='notificatons';
$getuserName=true;
$connect =true;
require('../require/header.php');
//if not no CTA is checked in
if($status == 0){
	header('location: ../login');
	exit();
}
?>
</head>
<style>
#notifications-content{
	background-color:white;
	width:70%;
	padding:5px;
	margin:auto;
	min-height:400px;
border-radius:10px;
}
.notice,.client-follow-notice{
	display:block;
	list-style-type:none;
	margin:auto;
	margin-bottom:2px;
	padding-left:5px;
	background-color:#eeeeee;
	height:30px;
	width:90%;
	cursor:default;
}
.client-follow-notice{
	height:50px;
}
.notice:hover,.client-follow-notice:hover{
	opacity:0.8;
}
.period{
	padding-left:50px;
	font-weight:bold;
	margin-bottom:0px;
	
}
.since{
	float:right;
	padding-right:10px;
	font-size:12px;
	color:;
}
</style>
<body class="pic-background">
<div id="notifications-content">

<?php
function notify($subject,$subjecttrace,$action,$timestamp,$howold){
	$time = time() - $timestamp;
//if less than 60 secs
if($howold=="yesterday"){
	$since = "Yesterday at ".date('h:i a ',$timestamp);
}
else{
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
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/86400).' days ago)';
	}
	else if($time>=604800 && $time<18144000){
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/604800).' weeks ago)';
	}
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
			$xtra = "<br/>
					 <i style=\"font-style:normal; font-size:12px;\">This client needs $reqtype with rent not more than N".number_format($reqmaxprice)." around $reqlocation <a href=\"\">Suggest a property for this client</a></i>";
					
		}
		else{
			$xtra='This client has no specific preference <a href=\"\">Suggest a property for this client</a></i>';
		}
		return "<li class=\"client-follow-notice\">
					+<i class=\"black-icon\" id=\"user-icon\"></i>A client <a href=\"../cta/ctarequests/?target=$subjecttrace\">(".$subject.")</a> started following you
					 <i class=\"since\">$since</i>
					 $xtra</li>";
		break;
		
		case 'A4Afollow':
		return "<li class=\"notice\">
					+<i class=\"black-icon\" id=\"user-icon\"></i>An agent <a href=\"../$subjecttrace\">(".$subject.")</a> started following you
					 <i class=\"since\">$since</i>
					 
						</li>";
		break;
		

		case 'CTA created':
		return "<li class=\"notice\">
					+<i class=\"black-icon\" id=\"user-icon\"></i>You created your CTA as $subject
					 <i class=\"since\">".date('l, d M, Y  ',$timestamp)."($since)</i>
					 
						</li>";
		break;
		case '':
		break;
	}
}

if($status==1){
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$Business_Name' OR receiver='allAgents') ORDER BY time DESC");
}
else if($status==9){
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$ctaname' OR receiver='allClients') ORDER BY time DESC");
}
$totalnotifications = mysql_num_rows($getnotifications);
echo "<p>$totalnotifications Total notifications</p>";
if(($totalnotifications)==0){
	echo "<ul><li class=\"notice\">No notifications for now</li></ul>";
}
else{
	$todaysnotifications='';
	$yesterdaysnotifications='';
	$oldernotifications='';
while($n = mysql_fetch_array($getnotifications,MYSQL_ASSOC)){
	
//if notification was received on the same date with the date of checking notifications
if(date('dmy',$n['time'])== date('dmy',time())){
	$todaysnotifications .= notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'today');
}
//if notification was received a day before date of checking notifications

else if((date('d',time())-date('d',$n['time']))==1){
	$yesterdaysnotifications .=notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'yesterday');
	}
else{
	$oldernotifications .=notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'older');
	}

	}

}
mysql_close($db_connection);
?>
<p class="period">Today</p>
<ul>
<?php
if(isset($todaysnotifications) && $todaysnotifications!=''){
echo $todaysnotifications;
}
else{
	echo "<li class=\"notice\">No notifications today</li>";
}
?></ul>
<p class="period">Yesterday</p>
<ul>
<?php
if(isset($yesterdaysnotifications) && $yesterdaysnotifications!=''){
echo $yesterdaysnotifications;
}
else{
	echo "<li class=\"notice\">There was no notifications yesterday</li>";
}
?></ul>
<p class="period">Older</p>
<ul>
<?php
if(isset($oldernotifications) && $oldernotifications!=''){
echo $oldernotifications;
}
else{
	echo "<li class=\"notice\">There are no other notifications</li>";
}
?></ul>
</div>
</body>
</html>
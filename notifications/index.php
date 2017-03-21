
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
#deletionReport-container{
	background-color:#FD577A;
	text-align:center;
	color:white;
	width:40%;
	margin:auto;
	margin-top:20px;
}
#notification-top-bar{
	margin:auto;
	margin-top:20px;
}
#notification-top-bar-links{
	display:inline-block;
	margin-left:20%;
}
#top-bar-table-link-clearall,#top-bar-table-link-clearold{
	display:inline-block;
	width:200px;
	height:30px;
	text-align:center;
	background-color:#6D0AAA;
	color:white;
}
#top-bar-table-link-clearall:hover,#top-bar-table-link-clearold:hover{
	text-decoration:none;
}
#top-bar-table-link-clearall{
	color:red;
}
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
<body class="no-pic-background">
<?php
//Notifications clearing
if(isset($_GET['token']) && isset($_GET['target']) && isset($_GET['action'])){
	if($status==1){
		if($_GET['token']==$myid && $_GET['target']==$Business_Name){
			if($_GET['action']=='clearall'){
			if(mysql_query("DELETE FROM notifications WHERE receiver='$Business_Name'")){
				$deletionReport = "You have successfully cleared your notifications";
			}else{ $deletionReport="Deletion of your notifications failed"; }
			}
else if($_GET['action']=='clearold'){
	//48hours ago
	$old = time() - 172800;
	if(mysql_query("DELETE FROM notifications WHERE receiver='$Business_Name' AND time<=$old")){
				$deletionReport = "You have successfully cleared your old notifications";
			}else{ $deletionReport="Deletion of your old notifications failed"; }
}
		}
	else{
			echo "You are not authorized to clear this notifications";
			mysql_close($db_connection);
			exit();
		}

	}
else if($status==9)	{
	if($_GET['token']==$myid && $_GET['target']==$ctaname){
					if($_GET['action']=='clearall'){
			if(mysql_query("DELETE FROM notifications WHERE receiver='$ctaname'")){
				$deletionReport = "You have successfully cleared your notifications";
			}else{ $deletionReport="Deletion of your notifications failed"; }
			}
else if($_GET['action']=='clearold'){
	//48hours ago
	$old = time() - 172800;
	if(mysql_query("DELETE FROM notifications WHERE receiver='$ctaname' AND time<=$old")){
				$deletionReport = "You have successfully cleared your old notifications";
			}else{ $deletionReport="Deletion of your old notifications failed"; }
}
		}
		else{
			echo "<div id=\"deletionReport-container\">
					<hr/>
				You are not authorized to clear this notifications
					<hr/>
					</div>";
			mysql_close($db_connection);
			exit();
		}
}
else{
	redirect();
}
}
?>
<?php
if(isset($deletionReport) && $deletionReport != ''){
	echo "<div id=\"deletionReport-container\">
	<hr/>
	$deletionReport
	<hr/>
	</div>";
}
?>
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
	$clearAllNotification = "<a href=\"?token=$myid&target=$Business_Name&action=clearall\">clear all notifications</a>";
	$clearOldNotification = "<a href=\"?token=$myid&target=$Business_Name&action=clearold\">clear old notifications</a>";
}
else if($status==9){
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$ctaname' OR receiver='allClients') ORDER BY time DESC");
	$clearAllNotification = "<a id=\"top-bar-table-link-clearall\" href=\"?token=$myid&target=$ctaname&action=clearall\">clear all notifications</a>";
	$clearOldNotification = "<a id=\"top-bar-table-link-clearold\" href=\"?token=$myid&target=$ctaname&action=clearold\">clear old notifications</a>";
}
$totalnotifications = mysql_num_rows($getnotifications);
$topbar = "<div id=\"notification-top-bar\">
	$totalnotifications Total notifications
	<div id=\"notification-top-bar-links\">
	$clearOldNotification
		$clearAllNotification
		</div>
		</div>";
		echo $topbar;
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
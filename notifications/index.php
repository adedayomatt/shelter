<?php 
$connect = true;
require('../require/connexion.php'); 
 //confirm if user is still logged in 
if($status==0){
	redirect();
}
?>
<!DOCTYPE html>
<html>
<?php require('../require/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle = "Notifications";
$ref='notificatons';
$getuserName=true;
require('../require/header.php');
?>
</head>
<style>
#notification-top-bar{
	height:50px;
}
#total-notification{
	font-weight:bold;
	background-color:yellow;
	color:purple;
	padding:5px 10px 5px 10px;
	border-radius:30%;
	box-shadow:0px 3px 3px rgba(0,0,0,0.2) inset;
}
.clear-options{
	float:right;
	display:inline-block;
	padding:1% 2% 1% 2%;
	margin:2px;
	background-color:rgba(200,0,0,0.2);
	color:red;
	box-shadow: 0px 2px 2px rgba(0,0,0,0.05) inset;
	border-radius:2px;
}
.clear-options:hover{
	text-decoration:none;
	opacity:0.8;
	color:red;
}
#notifications-content{
	width:70%;
	background-color:white;
	padding:5px;
	margin:auto;
	min-height:400px;
	border:1px solid #E3E3E3;
}
.notice,.client-follow-notice,.no-nofication{
	display:block;
	list-style-type:none;
	margin:auto;
	margin-bottom:4px;
	padding-left:5px;
	width:98%;
	padding:1%;
	cursor:default;
	background-color:#F7F7F7;
}
.no-nofication{
	width:90%;
	text-align:center;
	background-color:rgba(200,0,0,0.05);
	color:red;
	padding:5%;
	border:1px solid #E3E3E3;
}
.notice:not(.no-nofication):hover,.client-follow-notice:hover{
	opacity:0.8;
}
.period{
	display:block;
	padding:5px;
	color:purple;
	font-weight:normal;
	font-size:150%;
}
.time{
	text-align:right;
}
ul{
	padding:0px;
	margin:0px;
}

@media all and (max-width:800px){
	#notifications-content{
	width:95%;
	}
	#confirm-clearing-box{
	width:90%;
	margin-top:20px;
}
}
@media all and (min-width:800px){
	#notifications-content{
	width:70%;
	}
	#confirm-clearing-box{
	width:30%;
	margin-top:20px;
}
}
</style>
<body class="no-pic-background">
<?php
//Notifications clearing
if(isset($_GET['token']) && isset($_GET['target']) && isset($_GET['action'])){
/*By default, when the user clicks to delete, value of $_GET['confirm'] is SHA1('no'),
	therefore, this confirm dialogue is displayed
*/
$deletewarning = ($_GET['action']=='clearold' ? 'Notifications from 2 days ago and later would be deleted'
				:($_GET['action']=='clearall' ? 'All your notifications since the activation of this account would be deleted':''));
				
	if(isset($_GET['confirm']) && $_GET['confirm']== SHA1('no')){
	echo "<div class=\"operation-report-container\" id=\"confirm-clearing-box\">
	<h2>Confirm</h2>Are you sure you want to clear this notifications?<br/><br/>
	<span class=\"black-icon warning-icon\" ></span><strong style=\"color:red;word-spacing:2px;\">   $deletewarning</strong>
	<br/><br/>
	<a href=\"../notifications\"><button>No, Don't clear</button></a>
	<a  href=\"?token=".$_GET['token']."&target=".$_GET['target']."&action=".$_GET['action']."&confirm=".SHA1('yes')."\"><button>Yes, clear</button>
	</div>";
	mysql_close($db_connection);
	exit();
	}
/*In the confirm dialogue exist the link that now have SHA1('yes') has its value, then the deletion can proceed*/
else if(isset($_GET['confirm']) && $_GET['confirm']== SHA1('yes')){
//For agent
	if($status==1){
		if($_GET['token']==$myid && $_GET['target']==$Business_Name){
			if($_GET['action']=='clearall'){
			if(mysql_query("DELETE FROM notifications WHERE receiver='$Business_Name'")){
				$deletionReport = "<h2>Notifications cleared</h2>You have successfully cleared all your notifications";
			}else{ $deletionReport="<h2>Failed!</h2>Clearing of all your notifications failed"; }
			}
else if($_GET['action']=='clearold'){
	//48hours ago
	$old = time() - 172800;
	if(mysql_query("DELETE FROM notifications WHERE receiver='$Business_Name' AND time<=$old")){
$deletionReport = "<h2>Notifications cleared</h2>You have successfully cleared your older notifications";
			}else{ $deletionReport="<h2>Failed!</h2>Clearing of your old notifications failed"; }
}
		}
	else{
			echo "<br/><div style=\"text-align:center\" class=\"operation-report-container\">
			<h2 color=\"red\">Forbidden!</h2>
				Notifications cannot be cleared
					</div>";
			mysql_close($db_connection);
			exit();
		}

	}
//For CTA
else if($status==9)	{
	if($_GET['token']==$myid && $_GET['target']==$ctaname){
					if($_GET['action']=='clearall'){
			if(mysql_query("DELETE FROM notifications WHERE receiver='$ctaname'")){
				$deletionReport = "<h2>Notifications cleared</h2>You have successfully cleared all your notifications";
			}else{ $deletionReport="<h2>Failed!</h2>Clearing of your notifications failed"; }
			}
else if($_GET['action']=='clearold'){
	//48hours ago
	$old = time() - 172800;
	if(mysql_query("DELETE FROM notifications WHERE receiver='$ctaname' AND time<=$old")){
				$deletionReport = "<h2>Notifications cleared</h2>You have successfully cleared your old notifications";
			}else{ $deletionReport="<h2>Failed!</h2>Clearing of old notifications failed"; }
}
		}
		else{
			echo "<br/><div style=\"text-align:center\" class=\"operation-report-container\">
					<h2>Forbidden!</h2>
				Notifications cannot be cleared
					</div>";
			mysql_close($db_connection);
			exit();
		}
}
//Neither an agent or a logged in client
else{
	redirect();
		}
	}
}
?>

<?php
//include the noticefunction, i put the function in another file because i want to use on the homepage too,to avoid code replication
require('functionNotice.php');
if($status==1){
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$Business_Name' OR receiver='allAgents') ORDER BY time DESC");
	$clearAllNotification = "<a href=\"?token=$myid&target=$Business_Name&action=clearall&confirm=".SHA1('no')."\" class=\"clear-options\"><span class=\"black-icon delete-icon\"></span>clear all notifications</a>";
	$clearOldNotification = "<a href=\"?token=$myid&target=$Business_Name&action=clearold&confirm=".SHA1('no')."\" class=\"clear-options\"><span class=\"black-icon delete-icon\"></span>clear older notifications</a>";
}
else if($status==9){
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$ctaname' OR receiver='allClients') ORDER BY time DESC");
	$clearAllNotification = "<a id=\"top-bar-table-link-clearall\" href=\"?token=$myid&target=$ctaname&action=clearall&confirm=".SHA1('no')."\" class=\"clear-options\"><span class=\"black-icon delete-icon\"></span>clear all notifications</a>";
	$clearOldNotification = "<a id=\"top-bar-table-link-clearold\" href=\"?token=$myid&target=$ctaname&action=clearold&confirm=".SHA1('no')."\" class=\"clear-options\"><span class=\"black-icon delete-icon\"></span>clear older notifications</a>";
}
$totalnotifications = mysql_num_rows($getnotifications);
$topbar = "<div id=\"notification-top-bar\">
			 Total notifications: <span id=\"total-notification\">$totalnotifications</span><br/>
			$clearOldNotification
			$clearAllNotification
			</div>";
?>
<?php	
if(($totalnotifications)==0){
	//echo "<ul><li class=\"notice\">No notifications for now</li></ul>";
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

else if((date('d',time())- date('d',$n['time']))==1){
	$yesterdaysnotifications .=notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'yesterday');
	}
else{
	$oldernotifications .=notify($n['subject'],$n['subjecttrace'],$n['action'],$n['time'],'older');
	}

	}

}
mysql_close($db_connection);
?>

<div id="notifications-content">

<?php
	echo $topbar;
if(isset($deletionReport) && $deletionReport != ''){
	echo "<div class=\"operation-report-container\">
	$deletionReport
	</div>";
}
?>

<ul>
<h3 class="period">Today</h3>
<?php
if(isset($todaysnotifications) && $todaysnotifications!=''){
echo $todaysnotifications;
}
else{
	echo "<li class=\"notice no-nofication\"><span class=\"black-icon warning-icon\"></span>No notifications today</li>";
}
?></ul>

<ul>
<h3 class="period">Yesterday</h3>
<?php
if(isset($yesterdaysnotifications) && $yesterdaysnotifications!=''){
echo $yesterdaysnotifications;
}
else{
	echo "<li class=\"notice no-nofication\"><span class=\"black-icon warning-icon\"></span>There was no notifications yesterday</li>";
}
?></ul>

<ul>
<h3 class="period">Older</h3>
<?php
if(isset($oldernotifications) && $oldernotifications!=''){
echo $oldernotifications;
}
else{
	echo "<li class=\"notice no-nofication\"><span class=\"black-icon warning-icon\"></span>There are no older notifications</li>";
}
?></ul>
</div>
</body>
</html>
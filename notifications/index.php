<?php 
$connect = true;
require('../require/connexion.php'); 
 //confirm if user is still logged in 
if(!isset($_COOKIE['name']) && !isset($_COOKIE['CTA'])){
	header("Location: ../login");
}
?>
<!DOCTYPE html>
<html>
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
.option-button{
	cursor:pointer;
	padding:5px;
	
}
#notifications-content{
	width:70%;
	padding:5px;
	margin:auto;
	min-height:400px;
border-radius:10px;
}
.notice,.client-follow-notice,.no-nofication{
	display:block;
	list-style-type:none;
	margin:auto;
	margin-bottom:4px;
	padding-left:5px;
	background-color:white;
	height:30px;
	width:90%;
	cursor:default;
	border-radius:3px;
}
.no-nofication{
	text-align:center;
	color:grey;
	font-size:110%;
}
.client-follow-notice{
	height:80px;
}
.notice:not(.no-nofication):hover,.client-follow-notice:hover{
	box-shadow:1px 2px 2px 2px grey;
}
.period{
	padding-left:50px;
	font-weight:bold;
	margin-bottom:0px;
	color:grey;
	
}
.since{
	float:right;
	padding-right:10px;
	color:grey;
}
ul{
	padding-left:0px;
}
#confirm-clearing-box{
	width:30%;
	margin-top:20px;
}
#warning-icon{
	background-position: -144px -120px;
}
.user-icon{
		background-position: -168px 0px;
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
	<span class=\"black-icon\" id=\"warning-icon\" ></span><strong style=\"color:red;word-spacing:2px;\">   $deletewarning</strong>
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
	$clearAllNotification = "<a href=\"?token=$myid&target=$Business_Name&action=clearall&confirm=".SHA1('no')."\"><button class=\"option-button\">clear all notifications</button></a>";
	$clearOldNotification = "<a href=\"?token=$myid&target=$Business_Name&action=clearold&confirm=".SHA1('no')."\"><button class=\"option-button\">clear older notifications</button></a>";
}
else if($status==9){
	$getnotifications = mysql_query("SELECT * FROM notifications WHERE (receiver='$ctaname' OR receiver='allClients') ORDER BY time DESC");
	$clearAllNotification = "<a id=\"top-bar-table-link-clearall\" href=\"?token=$myid&target=$ctaname&action=clearall&confirm=".SHA1('no')."\"><button class=\"option-button\">clear all notifications</button></a>";
	$clearOldNotification = "<a id=\"top-bar-table-link-clearold\" href=\"?token=$myid&target=$ctaname&action=clearold&confirm=".SHA1('no')."\"><button class=\"option-button\">clear older notifications</button></a>";
}
$totalnotifications = mysql_num_rows($getnotifications);
$topbar = "<div id=\"notification-top-bar\">
			$totalnotifications Total notifications<br/>
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
<span class="period">Today</span>
<?php
if(isset($todaysnotifications) && $todaysnotifications!=''){
echo $todaysnotifications;
}
else{
	echo "<li class=\"notice no-nofication\">No notifications today</li>";
}
?></ul>

<ul>
<span class="period">Yesterday</span>
<?php
if(isset($yesterdaysnotifications) && $yesterdaysnotifications!=''){
echo $yesterdaysnotifications;
}
else{
	echo "<li class=\"notice no-nofication\">There was no notifications yesterday</li>";
}
?></ul>

<ul>
<span class="period">Older</span>
<?php
if(isset($oldernotifications) && $oldernotifications!=''){
echo $oldernotifications;
}
else{
	echo "<li class=\"notice no-nofication\">There are no older notifications</li>";
}
?></ul>
</div>
</body>
</html>
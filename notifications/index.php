<?php 
require('../resources/php/master_script.php'); 
 //confirm if user is still logged in 
if($status==0){
	$general->redirect('login');
}
?>

<!DOCTYPE html>
<html>
<head>
<?php
$pagetitle = "Notifications";
$ref='notificatons_page';
require('../resources/global/meta-head.php');?>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
</head>
<body class="no-pic-background">
<?php require('../resources/global/header.php'); ?>
<div class="container-fluid body-content">
<div class="main-content00">
<div class="row">

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
		}
}
//Neither an agent or a logged in client
else{
	$general->redirect('login');
		}
	}
}
?>




<?php
if($status==1){
	$getnotifications_q = "SELECT * FROM agent_notifications WHERE (receiver='$Business_Name' OR receiver='allAgents') ORDER BY timestamp DESC";
	$clearAllNotification = "<a href=\"?token=$agent_token&target=$Business_Name&action=clearall&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"glyphicon glyphicon-trash\"></span>clear all notifications</a>";
	$clearOldNotification = "<a href=\"?token=$agent_token&target=$Business_Name&action=clearold&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"glyphicon glyphicon-trash\"></span>clear older notifications</a>";
}
else if($status==9){
	$getnotifications_q = "SELECT * FROM client_notifications WHERE (receiver='$cta_name' OR receiver='allClients') ORDER BY timestamp DESC";
	$clearAllNotification = "<a href=\"?token=$client_token&target=$cta_name&action=clearall&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"black-icon delete-icon\"></span>clear all notifications</a>";
	$clearOldNotification = "<a href=\"?token=$client_token&target=$cta_name&action=clearold&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"black-icon delete-icon\"></span>clear older notifications</a>";
}
$getnotifications = $db->query_object($getnotifications_q);
	
if($getnotifications->num_rows == 0){
	?>
<div class="padding-20 width-80p margin-auto e3-border white-background  text-center" style="margin-top:5%">No notifications for now</div>
	<?php
}
else{
	$todaynotifications='';
	$yesterdaysnotifications='';
	$oldernotifications='';
while($n = $getnotifications->fetch_array(MYSQLI_ASSOC)){
	
//if notification was received on the same date with the date of checking notifications
if(date('dmy',$n['timestamp'])== date('dmy',time())){
	$todaynotifications .= $general->display_notification($n['notificationid'],$n['subject'],$n['subject_username'],$n['subject_id'],$n['receiver_id'],$n['action'],$n['link'],$n['timestamp'],'today',$n['status']);
}
//if notification was received a day before date of checking notifications

else if((date('d',time())- date('d',$n['timestamp']))==1){
	$yesterdaysnotifications .=$general->display_notification($n['notificationid'],$n['subject'],$n['subject_username'],$n['subject_id'],$n['receiver_id'],$n['action'],$n['link'],$n['timestamp'],'yesterday',$n['status']);
	}
else{
	$oldernotifications .=$general->display_notification($n['notificationid'],$n['subject'],$n['subject_username'],$n['subject_id'],$n['receiver_id'],$n['action'],$n['link'],$n['timestamp'],'older',$n['status']);
	}

	}
?>

<div>

<?php

if(isset($deletionReport) && $deletionReport != ''){
	echo "<div class=\"operation-report-container\">
	$deletionReport
	</div>";
}
?>

<div>
<h3 class="container-headers">Today</h3>
<?php
if(isset($todaynotifications) && $todaynotifications!=''){
echo $todaynotifications;
}
else{
	?>
 <div class="padding-10 e3-border white-background text-center">No notifications today</div>
 <?php
}
?>
</div>

<div>
<h3 class="container-headers">Yesterday</h3>
<?php
if(isset($yesterdaysnotifications) && $yesterdaysnotifications!=''){
echo $yesterdaysnotifications;
}
else{
	?>
	<div class="padding-10 e3-border white-background text-center">There was no notifications yesterday</div>
<?php
}
?></div>

<div>
<h3 class="container-headers">Older</h3>
<?php
if(isset($oldernotifications) && $oldernotifications!=''){
echo $oldernotifications;
}
else{
?>
<div class="padding-10 e3-border white-background text-center">There are no older notifications</div>
<?php
}


?></div>

</div>

<?php
}
?>
</div>
</div>
<?php require('../resources/global/footer.php') ?>

</div>

</body>
<style>
.notice{
	margin-bottom:5px;
}
@media all and (min-width:778px){
.main-content00{
	margin:0px 20px;
}
}
</style>

</html>





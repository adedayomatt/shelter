<?php 
if(!isset($status)){
require('../../master_script.php'); 
}
 //confirm if user is still logged in 
 if($status == 0){
	 echo "You are not Logged In";
 }
?>
<style>
.notice{
	padding:1px 4px;
	margin-bottom:10px;
	border-bottom: 1px solid #e3e3e3;
}
.unseen-notification{
	background-color: rgba(0,0,0,0.05);
}
.no-new-notification{
	background-color: rgba(0,0,0,0.3);
}
.new-notification{
	background-color: rgba(200,0,0,0.3);
}
</style>
<div class="row">

<?php
/*
//Notifications clearing
if(isset($_GET['token']) && isset($_GET['target']) && isset($_GET['action'])){
/*By default, when the user clicks to delete, value of $_GET['confirm'] is SHA1('no'),
	therefore, this confirm dialogue is displayed

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

	}
/*In the confirm dialogue exist the link that now have SHA1('yes') has its value, then the deletion can proceed
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
}*/
?>




<?php
if($status==1){
	$getnotifications_q = "SELECT * FROM agent_notifications WHERE (receiver='".$db->connection->real_escape_string($loggedIn_agent->business_name)."' OR receiver='allAgents') ORDER BY timestamp DESC";
	//$clearAllNotification = "<a href=\"?token=$agent_token&target=$Business_Name&action=clearall&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"glyphicon glyphicon-trash\"></span>clear all notifications</a>";
	//$clearOldNotification = "<a href=\"?token=$agent_token&target=$Business_Name&action=clearold&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"glyphicon glyphicon-trash\"></span>clear older notifications</a>";
	$receiver_id = $loggedIn_agent->id;
	$notifications = count($loggedIn_agent->unseen_notifications());
	}
else if($status==9){
	$getnotifications_q = "SELECT * FROM client_notifications WHERE (receiver='".$db->connection->real_escape_string($loggedIn_client->name)."' OR receiver='allClients') ORDER BY timestamp DESC";
	//$clearAllNotification = "<a href=\"?token=$client_token&target=$cta_name&action=clearall&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"black-icon delete-icon\"></span>clear all notifications</a>";
	//$clearOldNotification = "<a href=\"?token=$client_token&target=$cta_name&action=clearold&confirm=".SHA1('no')."\" class=\"btn btn-danger options\"><span class=\"black-icon delete-icon\"></span>clear older notifications</a>";
	$receiver_id =$loggedIn_client->id;
	$notifications = count($loggedIn_client->unseen_notifications());
	}
$getnotifications = $db->query_object($getnotifications_q);
	
if($getnotifications->num_rows == 0){
	?>
<div class=" padding-5 text-center">No notifications for now</div>
	<?php
}
else{
//if no new notification
?>
<div class="padding-5 margin-2 text-center width-80p <?php echo ($notifications == 0? 'no-new-notification' : 'new-notification') ?>" <?php echo ($notifications > 0 ? "data-action='animate-bgcolor'" : '') ?> style="margin:auto; border-radius: 5px;"><?php echo ($notifications == 0 ? "<div>No new notifications</div>" : "<div class=\"animated pulse\"><stong>".$notifications. "</strong> new notifications</div>")?></div>
<?php

	$todaynotifications='';
	$yesterdaysnotifications='';
	$oldernotifications='';
while($n = $getnotifications->fetch_array(MYSQLI_ASSOC)){
	
//if notification was received on the same date with the date of checking notifications
if(date('dmy',$n['timestamp'])== date('dmy',time())){
	$todaynotifications .= display_notification($n['notificationid'],$n['subject'],$n['subject_username'],$n['subject_id'],$n['receiver_id'],$n['action'],$n['link'],$n['timestamp'],'today',$n['status']);
}
//if notification was received a day before date of checking notifications

else if((date('d',time())- date('d',$n['timestamp']))==1){
	$yesterdaysnotifications .=display_notification($n['notificationid'],$n['subject'],$n['subject_username'],$n['subject_id'],$n['receiver_id'],$n['action'],$n['link'],$n['timestamp'],'yesterday',$n['status']);
	}
else{
	$oldernotifications .=display_notification($n['notificationid'],$n['subject'],$n['subject_username'],$n['subject_id'],$n['receiver_id'],$n['action'],$n['link'],$n['timestamp'],'older',$n['status']);
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

<script>
//indicate the remaining unseen notifications
try{
document.querySelector("[data-counter='notifications']").innerHTML = "<?php echo remainingNotification($receiver_id) ?>";
}
catch(err){
	console.log(err);
}
</script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/js/suggest_property.js' ?>"></script>



<?php
function display_notification($nid,$subject,$subjecttrace,$subjectid,$receiverid,$action,$link,$timestamp,$howold,$status){
	//This objects are in master_script.php
	GLOBAL $db;
	GLOBAL $root;
	GLOBAL $doc_root;
	$tool = new tools();
	$time = time() - $timestamp;
if($howold=="yesterday"){
	$since = "Yesterday at ".date('h:i a ',$timestamp);
}
else{
$since = $tool->since($timestamp);
}
$seenORunseen = ($status == 'unseen' ? 'unseen-notification' : 'white-background');
//update the notification as seen
//one of these two queries will update whichever notification it is: either agent's or client's
$db->query_object("UPDATE client_notifications SET status = 'seen' WHERE notificationid=$nid");
$db->query_object("UPDATE agent_notifications SET status = 'seen' WHERE notificationid=$nid");	

	switch($action){
		
	//if it is a client following an agent, specify the client need
		case 'C4A':
		$request = new cta_request($subjectid);
		$agent = new agent($receiverid);
		if($request->type != "" && $request->maxprice != 0 && $request->location != ""){
			$reqtype = $request->type;
			$reqmaxprice = $request->maxprice;
			$reqlocation = $request->location;
			$xtra = "<p class=\"grey text-center\">This client requested for <strong>$reqtype</strong> with rent not more than <strong>N".number_format($reqmaxprice)."</strong> around <strong>$reqlocation</strong> <br/>
					".$request->suggest_property_button($agent->id,$agent->business_name,$agent->username,$agent->token)."</p>";
					
		}
		else{
			$xtra="<p class=\"grey text-center\">This client has no specific preference <br/>
					|".$request->suggest_property_button($agent->id,$agent->business_name,$agent->username,$agent->token)."</p>";
		}
		unset($request);
		unset($agent);
		return "<div class=\"$seenORunseen notice\">
					+<span class=\"glyphicon glyphicon-user\"></span>A client <a href=\"$root/cta/ctarequests/?target=$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"grey font-12 text-right\">$since</p>
					 <div class=\"margin-5 padding-5 e3-border f7-background border-radius-3\">$xtra</div>
					 </div>";
		break;
		
		case 'A4A':
		return "<div class=\"$seenORunseen notice\">
					+<span class=\"glyphicon glyphicon-briefcase\" ></span>An agent <a href=\"$root/agents/$subjecttrace\">(".$subject.")</a> started following you
					 <p class=\"grey font-12 text-right\">$since</p>
						</div>";
		break;
		
case 'PSG':
$gettheproperty = $db->query_object("SELECT property_ID FROM properties WHERE directory = '$link'");
if($gettheproperty->num_rows == 0){
	$property_brief = "<div class=\"padding-10 red\">This property no longer exist</div>";
}
else{
$p = $gettheproperty->fetch_array(MYSQLI_ASSOC);
	$property = new property($p['property_ID']);
	$property_dp = $root.'/'.substr($property->display_photo_url(),strlen('../../../'));

	$property_brief = "<div class=\"row\">
						<div class=\"col-lg-5 col-md-5 col-sm-5 col-xs-5 \">
						<img src=\"$property_dp\" class=\"margin-2 mini-property-image size-100\"/>
						</div>
						<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7 text-left\">
						<div class=\"padding-5\">
						<div class=\"row\" style=\"line-height:25px\">
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">".$property->type."</span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">Rent: <strong>N ".number_format($property->rent)."</strong></span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"><span class=\"glyphicon glyphicon-map-marker\"></span>".$property->location."</span>
						</div>
						</div>
						<div class=\"text-right\">
						<a href=\"$root/properties/$link\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-eye-open\"></span>see details</a>
						</div>
						</div>
						</div>";
}			unset($property);
			$gettheproperty->free();
		return "<div class=\"$seenORunseen notice\">
					+<span class=\"glyphicon glyphicon-briefcase\" ></span><a href=\"$root/agents/$subjecttrace\">".$subject."</a> suggested a property
						<div class=\"grey width-90p margin-auto text-center\">$property_brief</div>
					<p class=\"grey font-12 text-right\">$since</p>
						</div>";
		break;
		case 'CTA created':
		return "<div class=\"$seenORunseen notice\">
					+<span class=\"glyphicon glyphicon-file-open\"></span>You created your CTA as $subject
					 <p class=\"grey font-12 text-right\">$since</p>
						</div>";
		break;
		case '':
		break;
case 'RVN':
$property_detail = $db->query_object("SELECT property_ID FROM properties WHERE properties.directory = '$link'");
$p = $property_detail->fetch_array(MYSQLI_ASSOC);
$property = new property($p['property_ID']);
	$property_dp = $root.'/'.substr($property->display_photo_url(),strlen('../../../'));
	$property_id = $property->id;
	$agent_token = $property->agent_token;
	$property_brief = "<div class=\"row grey\">
						<div class=\"col-lg-5 col-md-5 col-sm-5 col-xs-5\">
						<img src=\"$property_dp\" class=\"mini-property-image size-100\"/>
						</div>
						<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7 text-left\">
						<div class=\"padding-5\">
						<div class=\"row\" style=\"line-height:25px\">
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">".$property->type."</span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">Rent: <strong>N ".number_format($property->rent)."</strong></span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"><span class=\"glyphicon glyphicon-map-marker\"></span>".$property->location."</span>
						<span class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"><span class=\"glyphicon glyphicon-upload\"></span>uploaded ".$tool->since($property->uploadTimestamp)."</span>
						</div>
						</div>
						<div class=\"text-right\">
						<a href=\"$root/properties/$link\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-eye-open\"></span>see details</a>
						</div>
						</div>
						</div>";
unset($property);
$property_detail->free();
return "<div class=\"$seenORunseen notice\">
					+<span class=\"glyphicon glyphicon-pencil\" ></span> A property needs to be reviewed
					<p class=\"grey text-left font-12\">Confirm if this property is still available</p>
					$property_brief
					<a class=\"btn btn-default red-background white\"href=\"$root/manage/property.php?id=$property_id&action=change&agent=$agent_token\"><span class=\"glyphicon glyphicon-edit\"></span>Review now</a>
					 <p class=\"grey font-12 text-right\">$since</p>
					 <a href=\"\" class=\"font-10\"><span class=\"glyphicon glyphicon-question-sign\"></span>why am i getting this notification?</a>
						</div>";
						break;
	}

}
function remainingNotification($receiver_id){
		GLOBAL $db;
		GLOBAL $status;
		if($status == 1){
	return $db->query("SELECT notificationid FROM agent_notifications WHERE (receiver_id=$receiver_id AND status = 'unseen')")->num_rows;
		}
else if($status == 9){
	return $db->query("SELECT notificationid FROM client_notifications WHERE (receiver_id=$receiver_id AND status = 'unseen')")->num_rows;
		}
else{
	return 0;
}
	}


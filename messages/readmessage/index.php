<!DOCTYPE html>
<html>
<link href="../../css/general.css" type="text/css" rel="stylesheet" />
<link href="../../css/header_styles.css" type="text/css" rel="stylesheet" />
<header>
<?php
$pagetitle = "Read Message";
$ref='messagepage';
$getuserName=true;
$connect=true;
require('../../require/header.php');
if($status==0){
	redirect();
}
?>
<style>
div.no-message{
	margin-top:100px;
	width:70%;
	margin:auto;
	padding:10px;
	background-color:white;
	border-radius:5px;
	color:#6D0AAA;
	text-align:center;
}
#messages-parent{
	min-height:400px;
	margin-top:30px;
}
div.messages-side-bar{
	width:20%;
	float:left;
}
div.all-messages-container{
	width:70%;
	float:left;
}
div.message-content{
	width:100%;
	float:left;
	min-height: 100px;
	background-color:white;
	margin-bottom:10px;
	border-radius: 2px;
	box-shadow:1px 5px 5px 0px grey;
}
div.message-heading{
	padding:1%;
	color:grey;
	text-align:left;
	border-top:1px solid grey;
	border-bottom:1px solid grey;
	
}
.out{
	background-position: -288px -144px;
}
.in{
	background-position: -312px -144px;
}
.message-time{
	font-size:12px;
	float:right;
}
div.message-body{
	padding:20px;
}

</style>
</header>
<body class="no-pic-background">
<div id="messages-parent">
<?php
if(isset($_GET['cv'])){
	$cv = $_GET['cv'];
if($status == 1){
	$user = $Business_Name;	
}
else if($status == 9){
		$user = $ctaname;
	}
	$getMessages = mysql_query($messageQuery = "SELECT * FROM messages WHERE (conversationid = '$cv' AND (sender='$user' OR receiver = '$user')) ORDER BY timestamp DESC ");
if(mysql_num_rows($getMessages) >= 1){
	$totalMessages = mysql_num_rows($getMessages);
echo "
<div class=\"messages-side-bar\">
Total Messages : $totalMessages
</div>
";	

echo "<div class=\"all-messages-container\">";
	while($message = mysql_fetch_array($getMessages,MYSQL_ASSOC)){
	$messageid = $message['messageid'];
	$subject = 	$message['subject'];
	$sender = $message['sender'];
	$receiver = $message['receiver'];
	$body = $message['body'];
	if($sender == $user){
		$messagetime = messageTime('sent',$message['timestamp']);
		$sentOrReceived = "Sent to: ".$receiver;
		$inOrOut = 'out';
	}
	else if($receiver == $user){
		$messagetime = messageTime('received',$message['timestamp']);
		$sentOrReceived = "Received from: ".$sender;
		$inOrOut = 'in';
	}
		echo "
		<div class=\"message-content\">
		<div class=\"message-heading\">
		Subject: $subject<br/>
		<i class=\"black-icon $inOrOut\"></i>$sentOrReceived
		<span class=\"message-time\"><i>$messagetime</i></span>
		</div>
		<div class=\"message-body\">
		$body
		</div>
		</div>
		";
		}
//closing tag for all-messages-container
	echo "</div>";
	}
else{
	$MessageQueryReport = "No Message for this conversation";
	}
}
else{
$MessageQueryReport =  "No Valid conversation ID";	
}
if(isset($MessageQueryReport) && $MessageQueryReport != ''){
	echo "<div class=\"no-message\">$MessageQueryReport</div>";
}



function messageTime($sender,$timestamp){
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
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/86400).' days ago)';
	}
	else if($time>=604800 && $time<18144000){
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/604800).' weeks ago)';
	}
	else{
		$since = "sometime ago";
	}
switch($sender){
	case 'received':
	return 'received: '.$since;
	break;
	case 'sent':
	return 'sent: '.$since;
	break;
}

		}
?>
</div>
</body>

<footer></footer>
</html>
<?php 
$connect = true;
require('../../require/connexion.php'); 
 //confirm if user is still logged in 
if($status==0){
	redirect();
}
?>
<!DOCTYPE html>
<html>
<?php require('../../require/meta-head.html'); ?>
<link href="../../css/general.css" type="text/css" rel="stylesheet" />
<link href="../../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../../css/messages_styles.css" type="text/css" rel="stylesheet" />
<header>
<?php
$pagetitle = "Read Message";
$ref='messagepage';
$getuserName=true;
require('../../require/header.php');
?>
<?php
//This place takes care of replying
//COMING BACK TO THAT LATER
if(isset($_POST['reply'])){
	
}
?>

<script>
function toggleReplyContainer(){
var butt = document.getElementById('reply-button');
var replyContainer = document.getElementById('reply-box');
if(replyContainer.style.display != 'block'){
	replyContainer.style.display = 'block';
}
else{
	replyContainer.style.display = 'none';
}
}
</script>
</header>
<body class="no-pic-background">

<div id="reply-box">
<span class="close" title="close" onclick="toggleReplyContainer()"> &times </span>
<form id="reply-form" action="<?php $_PHP_SELF ?>" method="POST">
<?php
	$msg = mysql_fetch_array(mysql_query("SELECT subject,initiator,participant FROM messagelinker WHERE (conversationid=".$_GET['cv'].")"),MYSQL_ASSOC);
	$secondParty = @(($msg['initiator']=="$Business_Name" || $msg['initiator']=="$ctaname") ? $msg['participant'] : $msg['initiator']);
?>
<h2 style="font-weight:normal">Reply <?php echo $secondParty ?></h2>
<input id="reply-subject" name="subject" value="<?php echo ($msg['subject'] == "no subject" ? '' :  $msg['subject'])?>"  placeholder="subject" type="text"/>
<textarea id="reply-body" name="body" placeholder="Reply <?php echo ""?>"></textarea>
<input class="sendmessage-button" name="reply" value="send"  placeholder="subject" type="submit"/>
</form>
</div>

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

//opening tag for all-messages-container
echo "<div class=\"all-messages-container\">
<a class=\"message-menu inline-block\" id=\"reply-button\" onclick=\"toggleReplyContainer()\">Reply</a>
<a class=\"message-menu inline-block\" href=\"../\"> Go to inbox</a>
";

$getMessages = mysql_query("SELECT * FROM messages WHERE (conversationid = '$cv' AND (sender='$user' OR receiver = '$user')) ORDER BY timestamp DESC");
if(mysql_num_rows($getMessages) != 0){
	while($message = mysql_fetch_array($getMessages,MYSQL_ASSOC)){
	$messageid = $message['messageid'];
	$subject = 	$message['subject'];
	$sender = $message['sender'];
	$receiver = $message['receiver'];
	$body = $message['body'];
	$read = ($message['status']== 'unseen' ? 'unread-messages' :'read-messages');
	if($sender == $user){
		$messagetime = messageTime('sent',$message['timestamp']);
		$sentOrReceived = "Sent to: ".$receiver;
		$inOrOut = 'outbox-icon';
	}
	else if($receiver == $user){
		$messagetime = messageTime('received',$message['timestamp']);
		$sentOrReceived = "Received from: ".$sender;
		$inOrOut = 'inbox-icon';
	}
		echo "<div class=\"message-content\" id=\"$messageid\">
		<div class=\"message-heading\">
		Subject: $subject<br/>
		<i class=\"black-icon $inOrOut\"></i>$sentOrReceived
		<span class=\"time\"><i>$messagetime</i></span>
		</div>
		<div class=\"message-body\">
		$body
		</div>
		</div>
		";
		}
		ECHO "<a class=\"message-menu inline-block white-on-red\" style=\"color:white\" href=\"../\">Clear conversation</a>";
}
else{
		echo "<div style=\"text-align:center\" class=\"operation-report-container\">Empty Messages</div>";
}
//closing tag for all-messages-container
	echo "</div>";
	}
/*else{
	$MessageQueryReport = "There is no message in this conversation or you are not involved in the conversation";
	}
*/
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
	//return 'received: '.$since;
	return $since;
	break;
	case 'sent':
	//return 'sent: '.$since;
	return $since;
	break;
}

		}
?>

</div>


<?php
//update the messages as read
@mysql_query("UPDATE messagelinker SET status='seen' WHERE conversationid=$cv");
@mysql_query("UPDATE messages SET status='seen' WHERE conversationid=$cv");
mysql_close($db_connection);
?>
</body>

<footer></footer>
</html>
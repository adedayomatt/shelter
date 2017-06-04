
<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/messages_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle = "Messages";
$ref='messagepage';
$getuserName=true;
$connect=true;
require('../require/header.php');
if($status==0){
	redirect();
}
?>
</head>
<body class="pic-background">

<?php
/*
@id = conversationid
@target = logged in user
*/
function Message($cvid,$msgid,$initiator,$participant,$subject,$lastmessage,$sender,$receiver,$timestamp,$totalmsg,$status){
	$time = time() - $timestamp;
//if less than 60 secs
	if($time<60){
		$since = $time.' seconds ago';
	}
	else if($time>=60 && $time<3600){
		$since = (int)($time/60).' minutes ago';
	}
	else if($time>=3600 && $time<86400){
		$since = (int)($time/3600).' hours ago';
	}
	else if($time>=86400 && $time<604800){
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/86400).' days ago)';
	}
	else if($time>=604800 && $time<18144000){
		$since = date('l, d M, Y  ',$timestamp).'('.(int)($time/604800).' weeks ago)';
	}
	
if($initiator==$receiver){
	$head = $participant;
}	
else if($participant==$receiver){
	$head = $initiator;
}
//if the message was sent by this particular user, then it is an outbox message
if($sender==$receiver){
	$messageclass='outbox';
	$read = "read-messages";
}
else{
	$messageclass='inbox';
	$read = ($status == 'unseen' ? 'unread-messages' : 'read-messages');
}
	return "<li class=\"message $read\">
					<div><i class=\"black-icon\" id=\"$messageclass\"></i>
					 <a href=\"readmessage/?cv=$cvid".($msgid != 'na' ? "#$msgid" : '')."\" class=\"message-heading\" href=\"\">".$head." [$subject]</a></div>
					 <p class=\"lastmessage inline-block-fullwidth\">".(strlen($lastmessage) >= 100 ? substr($lastmessage,0,100)."...<a href=\"readmessage/?cv=$cvid".($msgid != 'na' ? "#$msgid" : '')."\" >continue reading</a>" : $lastmessage)."</p>
					 <i class=\"since inline-block\">$since</i>
					 
						</li>";		
	
}
?>

<div class="messages-side-bar" id="messages-side-bar-fake">
</div>




<?php
//for agent
if($status==1){
	$target = $Business_Name;
}
//for cta
else if($status==9){
		$target = $ctaname;
}
$recentConversation = "SELECT * FROM messagelinker WHERE (initiator='$target' OR participant='$target') ORDER BY lastmsgtime DESC";
$unreadMessages = $inbox = "SELECT * FROM messages WHERE (receiver= '$target' AND status = 'unseen') ORDER BY timestamp DESC";
$readMessages = "SELECT * FROM messages WHERE (receiver= '$target' AND status = 'seen') ORDER BY timestamp DESC";
$sentMessages = "SELECT * FROM messages WHERE (sender= '$target') ORDER BY timestamp DESC";	
$inbox = "SELECT * FROM messages WHERE (receiver= '$target') ORDER BY timestamp DESC";

	if(isset($_GET['folder'])){
	if($_GET['folder']=='recent'){
	$getMessages = mysql_query($recentConversation);
	$folder = "Recent conversations";
	}
else if($_GET['folder']=='read'){
	$getMessages = mysql_query($readMessages);
	$folder = "Read Messages";
}
else if($_GET['folder']=='unread'){
	$getMessages = mysql_query($unreadMessages);
	$folder = "Unread Messages";
}
else if($_GET['folder']=='inbox'){
	$getMessages = mysql_query($inbox);
	$folder = "Inbox";
}
else if($_GET['folder']=='sent'){
	$getMessages = mysql_query($sentMessages);
	$folder = "Sent Messages";
}
else{
	$getMessages = mysql_query($recentConversation );
	$folder = "Recent conversations";
}	
	}
else{
	$getMessages = mysql_query($recentConversation);
	$folder = "Recent conversations";
}

echo "
<div class=\"messages-side-bar\" id=\"messages-side-bar-original\">
<a class=\"messages-sidebar-menu\" href=\"?folder=recent\"> Recent conversations</a>
<a class=\"messages-sidebar-menu\" href=\"?folder=unread\"> Unread Messages only ( ".mysql_num_rows(mysql_query($unreadMessages))." )</a>
<a class=\"messages-sidebar-menu\" href=\"?folder=read\"> Read Messages only ( ".mysql_num_rows(mysql_query($readMessages))." )</a>
<a class=\"messages-sidebar-menu\" href=\"?folder=sent\"> Sent Messages ( ".mysql_num_rows(mysql_query($sentMessages))." )</a>
<a class=\"messages-sidebar-menu\" href=\"?folder=inbox\"> Inbox ( ".mysql_num_rows(mysql_query($inbox))." )</a>

</div>";

?>

<div id="messages-content">

<?php
echo "<span style=\"font-size:150%; line-height:100%; color:purple;\">Messages » $folder</span>";
$allmsg = '';
if($folder == 'Recent conversations'){
while($ms = @mysql_fetch_array($getMessages,MYSQL_ASSOC)){
	$allmsg .= Message($ms['conversationid'],'na',$ms['initiator'],$ms['participant'],$ms['subject'],$ms['lastmsg'],$ms['sender'],$target,$ms['lastmsgtime'],$ms['totalmsg'],$ms['status']);
	}	
}
else if($folder == 'Inbox' || $folder == 'Sent Messages' || $folder == 'Unread Messages' || $folder == 'Read Messages'){
	while($ms = @mysql_fetch_array($getMessages,MYSQL_ASSOC)){
	$allmsg .= Message($ms['conversationid'],$ms['messageid'],$ms['sender'],$ms['receiver'],$ms['subject'],$ms['body'],$ms['sender'],$target,$ms['timestamp'],0,$ms['status']);
	}
} 



	mysql_close($db_connection);
?>

<ul>
<?php
if(isset($allmsg) && $allmsg !=''){
echo $allmsg;
}
else{
	echo "<div style=\"text-align:center\" class=\"operation-report-container\">No message</div>";
}
?></ul>
</div>
</body>
</html>
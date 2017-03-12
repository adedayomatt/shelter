
<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
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
<style>
#messages-content{
	padding-top:20px;
	width:70%;
	margin:auto;
	min-height:400px;
border-radius:10px;
}
.message{
	
	display:block;
	list-style-type:none;
	margin-bottom:2px;
	padding-left:5px;
	background-color:#eeeeee;
	height:50px;
	width:100%;
	cursor:default;
}

.message:hover{
	opacity:0.8;
}
.message-heading{
	display:inline-block;
	font-size:15px;
}
.lastmessage{
	display:inline;
	font-size:12px;
	line-height:0px;
}
.period{
	padding-left:50px;
	font-weight:bold;
	margin-bottom:0px;
	
}
.since{
	display:inline;
	float:right;
	padding-right:10px;
	font-size:12px;
	color:;
}
a:hover{
	text-decoration:none;
}
#outbox{
	background-position: -288px -144px;
}
#inbox{
	background-position: -312px -144px;
}
</style>
<body class="pic-background">
<div id="messages-content">

<?php
/*
@id = conversationid
@target = logged in user
*/
function inbox($id,$initiator,$participant,$subject,$lastmessage,$sender,$receiver,$timestamp,$totalmsg){
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
}
else{
	$messageclass='inbox';
}
	return "<li class=\"message\">
					<div><i class=\"black-icon\" id=\"$messageclass\"></i>
					 <a class=\"message-heading\" href=\"\">".$head." [$subject]</a></div>
					 <p class=\"lastmessage\">".substr($lastmessage,0,100)."</p>
					 <i class=\"since\">$since</i>
					 
						</li>";		
	
}
//for agent
if($status==1){
	$target = $Business_Name;
}
//for cta
else if($status==9){
		$target = $ctaname;
}
$getmsgsummary = mysql_query("SELECT * FROM messagelinker WHERE (initiator='$target' OR participant='$target') ORDER BY lastmsgtime DESC");
$allmsg = '';

while($ms = @mysql_fetch_array($getmsgsummary,MYSQL_ASSOC)){
$allmsg .= inbox($ms['conversationid'],$ms['initiator'],$ms['participant'],$ms['subject'],$ms['lastmsg'],$ms['sender'],$target,$ms['lastmsgtime'],$ms['totalmsg']);
	}

	mysql_close($db_connection);
?>

<ul>
<?php
if(isset($allmsg) && $allmsg !=''){
echo $allmsg;
}
else{
	echo "<li class=\"notice\">No message</li>";
}
?></ul>
</div>
</body>
</html>

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
#notifications-content{
	padding-top:20px;
	width:70%;
	margin:auto;
	min-height:400px;
border-radius:10px;
}
.notice,.client-follow-notice{
	display:block;
	list-style-type:none;
	margin-bottom:2px;
	padding-left:5px;
	background-color:#eeeeee;
	height:30px;
	width:100%;
	cursor:default;
}
.client-follow-notice{
	height:50px;
}
.notice:hover{
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
/*
@id = conversationid
@target = logged in user
*/
function inbox($id,$initiator,$participant,$subject,$receiver,$timestamp,$totalmsg){
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
	return "<li class=\"msg\">
					 <a href=\"\">".$head."[$subject]</a>
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
$allmsg .= inbox($ms['conversationid'],$ms['initiator'],$ms['participant'],$ms['subject'],$target,$ms['lastmsgtime'],$ms['totalmsg']);
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
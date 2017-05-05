
<!DOCTYPE html>
<html>
<meta name="viewport" content="max-width=1000px,maximum-scale=0.35" />
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle = "Send Message";
$ref='messagepage';
$getuserName=true;
$connect = true;
require('../require/header.php');
?>
</head>
<?php 
 //confirm if user is still logged in 
if($status == 0){
	redirect();
}
//when the message is sent
if(isset($_POST['send'])){	
//if all fields are not empty
if($_POST['cvid'] != '' && $_POST['i'] != '' && $_POST['recipient']!= '' && $_POST['msgbody'] != ''){
//pass the data into variables
	$conversationid = $_POST['cvid'];
	$sender = $_POST['i'];
	$receiver = mysql_real_escape_string($_POST['recipient']);
	$subject = mysql_real_escape_string((($_POST['subject'] !='')? $_POST['subject'] : 'no subject' ));
	$body = mysql_real_escape_string($_POST['msgbody']);
	$time = time();
//check if conversation already existentence
if(mysql_num_rows(mysql_query("SELECT conversationid FROM messagelinker WHERE conversationid=$conversationid"))>=1){
	//only update the number of total message and send the message
	$totalmsg = mysql_num_rows(mysql_query("SELECT conversationid FROM messages WHERE conversationid='$conversationid' ")) +1;
	if(mysql_query("UPDATE messagelinker SET subject='$subject',totalmsg=$totalmsg,lastmsg='$body',sender='$sender',lastmsgtime=$time WHERE conversationid='$conversationid' ")){
		//now insert the message
		$messageid = $conversationid + ($time - 10000000);
		$sendmessage = mysql_query("INSERT INTO messages (conversationid,messageid,subject,sender,receiver,body,status,timestamp) 
									VALUE ('$conversationid','$messageid','$subject','$sender','$receiver','$body','unseen',$time)");
	}
}
else{
	//if the conversation did exist before, create a new message linker
if(mysql_query("INSERT INTO messagelinker (conversationid,subject,initiator,participant,totalmsg,lastmsg,sender,lastmsgtime) 
	VALUE($conversationid,'$subject','$sender','$receiver',1,'$body','$sender',$time)")){
//INSERT THE MESSAGE
//generate a message id
$messageid = $conversationid + ($time - 10000000);
$sendmessage = mysql_query("INSERT INTO messages (conversationid,messageid,subject,sender,receiver,body,status,timestamp) 
									VALUE ($conversationid,$messageid,'$subject','$sender','$receiver','$body','unseen',$time)");
		}
	else{
		$sent = "<p style=\"color: red\">Conversation with $receiver could not be initialized</p>";	
		}
		
			}
//if message was sent successfully or not
	if($sendmessage){
	$sent = "<p style=\"color=#6D0AAA\">Your message to $receiver was sent successfully</p>";
	mysql_close($db_connection);
	header("location: http://192.168.173.1/shelter/messages");
	exit();
	}
	else{
		$sent = "<p style=\"color: red\">Your message to $receiver was not sent successfully</p>";
	}
		}
//if some of the fields are empty
else{
	//if message body is empty
	if($_POST['msgbody'] == ''){
		$sent = "<h3 style=\"color: red\">Message not sent!</h3><p>Message body cannot be empty</p>";
	}
}
	}
?>

<style>
@media only screen and (min-device-width: 1000px){
	#compose-area{
		width:50%;
	margin:auto;
	background-color:#eeeeee;
	padding-top:20px;
	padding-left:50px;
	min-height:400px;
border-radius:10px;
line-height:200%;
	}
	#sent-report{
		width:100%;
	}
	input.message-input{
	padding:1%;
	display:block;
	width:80%;
	margin:auto;
}
#sendmessage-button{
	float:right;
	padding:1%;
	padding-left:5%;
	padding-right:5%;
	border:none;
	border-radius:5px;
	background-color:#6D0AAA;
	color:white;
	letter-spacing:2px;
}

}
@media only screen and (min-device-width: 300px) and (max-device-width: 1000px){
	#compose-area{
		width:98%;
	padding:1%;
	background-color:#eeeeee;
  line-height:300%;
}
input.message-input{
	padding:1%;
	display:block;
	width:80%;
	margin:auto;
}
	#message-textarea{
		font-size:100%;
	}
	#sent-report{
		width:100%;
	}
#sendmessage-button{
	width:100%;
	margin:auto;
	margin-top:30px;
	padding:4%;
	border:none;
	border-radius:10px;
	background-color:#6D0AAA;
	color:white;
	letter-spacing:2px;
}
}
#sent-report{
	margin:auto;
	padding:5px;
	background-color:white;
	text-align:center;
	border-radius:5px;
	box-shadow:3px 3px 3px 3px grey;
}

#confirm{
	font-size:120%;
}

#message-textarea{
	padding:1%;
	display:block;
	width:100%;
height:300px;
max-heigh:200px;
font-family:Georgia;
}

</style>
<body class="pic-background">
<div id="compose-area">
<?php
if(isset($_GET['cv']) && isset($_GET['rcpt']) && !empty($_GET['rcpt'])&& !empty($_GET['rcpt'])){
	//first confirm the existentence of the recipient
	$getrecipient = mysql_query("SELECT Business_Name FROM profiles WHERE ID='".$_GET['rcpt']."'");
if(mysql_num_rows($getrecipient)==1){
	$recipient = mysql_fetch_array($getrecipient,MYSQL_ASSOC);
$confirm = "Message <strong>".$recipient['Business_Name']."</strong>";
}
else{
echo "The recipient does not exist";
exit();
}
	}
?>
<form action="<?php $_PHP_SELF;  ?>" method="post">
<?php 
echo (isset($sent)? "<div id=\"sent-report\">$sent</div>" : '');
echo (isset($confirm)? "<div id=\"confirm\">$confirm</div>" : '');
?>
<input name="cvid"  type="hidden" value="<?php echo (isset($_GET['cv']) ? $_GET['cv'] : '') ?>" />
<input name="i"  type="hidden" value="<?php echo (isset($_GET['i']) ? $_GET['i'] : '') ?>" />
<label>Recipient <input class="message-input" name="recipient" maxlength="150" type="text" required="required" value="<?php echo (isset($recipient['Business_Name'])? $recipient['Business_Name']:''); ?>"/></label>
<label>Subject <input class="message-input" name="subject" maxlength="150" type="text" placeholder="no subject"/></label>
<label>Message</label>
<textarea id="message-textarea" name="msgbody" cols="40" rows="5" placeholder="message body"></textarea>
	<input id="sendmessage-button" name="send" type="submit" value="send" />
</form>

</div>
<?php mysql_close($db_connection) ?>
</body>
</html>
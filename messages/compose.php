<?php  
//when the message is sent
if(isset($_POST['send'])){
	$connect = true;
//connect to the database
require('../require/connexion.php');
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
if(mysql_num_rows(mysql_query("SELECT conversationid FROM messagelinker WHERE conversationid='$conversationid' "))>=1){
	//only update the number of total message and send the message
	$totalmsg = mysql_num_rows(mysql_query("SELECT conversationid FROM messages WHERE conversationid='$conversationid' ")) +1;
	if(mysql_query("UPDATE messagelinker SET subject='$subject',totalmsg=$totalmsg,lastmsg='$body',sender='$sender',lastmsgtime=$time WHERE conversationid='$conversationid' ")){
		//now insert the message
		$messageid = $conversationid.$time;
		$sendmessage = mysql_query("INSERT INTO messages (conversationid,messageid,subject,sender,receiver,body,status,timestamp) 
									VALUE ('$conversationid','$messageid','$subject','$sender','$receiver','$body','unseen',$time)");
	}
}
else{
	//if the conversation did exist before, create a new message linker
if(mysql_query("INSERT INTO messagelinker (conversationid,subject,initiator,participant,totalmsg,lastmsg,sender,lastmsgtime) 
				VALUE('$conversationid','$subject','$sender','$receiver',1,'$body','$sender',$time)")){
//insert the message
$messageid = $conversationid.$time;
$sendmessage = mysql_query("INSERT INTO messages (conversationid,messageid,subject,sender,receiver,body,status,timestamp) 
									VALUE ('$conversationid','$messageid','$subject','$sender','$receiver','$body','unseen',$time)");
					}
			}
//if message was sent successfully or not
	if($sendmessage){
	$sent = "Your message to $receiver was sent successfully";
	}
	else{
		$sent = "Your message to $receiver was not sent successfully";
	}
		}
//if some of the fields are empty
else{
	//if message body is empty
	if($_POST['msgbody'] == ''){
		$sent = "Message body cannot be empty";
	}
}
	}
?>
<!DOCTYPE html>
<html>
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
<style>
#compose-area{
	background-color:#eeeeee;
	padding-top:20px;
	padding-left:50px;
	width:70%;
	margin:auto;
	min-height:400px;
border-radius:10px;
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
$confirm = "send message to ".$recipient['Business_Name'];
}
else{
echo "The recipient does not exist";
exit();
}
	}
?>
<form action="<?php $_PHP_SELF;  ?>" method="post">
<?php 
echo (isset($sent)? "<div>$sent</div>" : '');
echo (isset($confirm)? "<div>$confirm</div>" : '');
?>
<input name="cvid"  type="hidden" value="<?php echo (isset($_GET['cv']) ? $_GET['cv'] : '') ?>" />
<input name="i"  type="hidden" value="<?php echo (isset($_GET['i']) ? $_GET['i'] : '') ?>" />
<label>Recipient <input name="recipient" size="50" maxlength="150" type="text" required="required" value="<?php echo (isset($recipient['Business_Name'])? $recipient['Business_Name']:''); ?>"/></label><br><br>
<label>Subject <input name="subject" size="40" maxlength="150" type="text" placeholder="no subject"/></label><br><br>

<textarea name="msgbody" cols="40" rows="5" placeholder="message body"></textarea>
	<input name="send" type="submit" value="send" />
</form>

</div>
<?php mysql_close($db_connection) ?>
</body>
</html>
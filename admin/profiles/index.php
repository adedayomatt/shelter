<?php 
$connect = true;
require('../../require/connexion.php'); 

$affected = array();
$affectedBusiness_names = array();

	if(isset($_POST['execute']) || isset($_POST['smessage'])){
/*Get all the ids in the table*/
	$fetchIds = "SELECT ID,Business_Name FROM profiles";
$fetchIds_Query = mysql_query($fetchIds);
if($fetchIds_Query)
{
	/*if there is any id that matches the ones selected, add it to $affected[]*/
	while($existing = mysql_fetch_array($fetchIds_Query,MYSQL_ASSOC)){
		$x = $existing['ID'];
		if(isset($_POST["$x"])){
			$affected[] = $existing['ID'];
			$affectedBusiness_names[] = $existing['Business_Name'];
				}
			}
		}
		
	}
	
if(isset($_POST['smessage'])){
	if($_POST['smessage'] == 'Send to all'){
		sendMessage('All agents');
	}
else if($_POST['smessage'] == 'Send to marked'){	
if(!empty($affected)){
	foreach($affected as $victims){
		sendMessage($victims);
	}
}
else{
	echo "<script>alert(\"No recipient is selected\")</script>";
}
}
}

function sendMessage($que){
//send message
$adminid = 459032;
$conversationid = $adminid.$que;
$subject = $_POST['msgSubject'];
$body = $_POST['msgBody'];	
$sender = "Admin, Shelter";
$time = time();
$getRecipientName = mysql_query("SELECT Business_Name FROM profiles WHERE ID=$que");
   $n = mysql_fetch_array($getRecipientName,MYSQL_ASSOC);
   $receiver = $n['Business_Name'];
   
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


}
if($sendmessage){
	echo "<script>alert(\"Message Sent\")</script>";
}
else{
	echo "<script>alert(\"Message failed to Send\")</script>";
}
}





if(isset($_POST['execute'])){
	
if(!empty($affected)){
	if(isset($_POST['action'])){
	/*switch the what to do with the records selected, if 0, deleted them using the erase() function..*/
	switch($_POST['action']){
	case 'Delete':
	$no = 0;
	foreach($affected as $victims){
		erase($victims);
		$no++;
	}
echo "<script>alert(\"You have successfully deleted $no records\");window.location=\"$root/admin/profiles\";</script>";
	break;
	case 'Block':
	//block
	echo "<h4 align=\"center\" color=\"red\">Blocking not availble yet!</h4>";
	foreach($affected as $victims){
		block($victims);
	}
	break;
}
	}
	//if no action is selected
else{
	echo "<script>alert(\"No action was selected\");window.location=\"$root/admin/profiles\";</script>";
}
}

else{
	echo "<script>alert(\"You did not select any record\");window.location=\"$root/admin/profiles\";</script>";
}
	}	
function erase($que){
	$no = 1;
	$connect = true;
		$delete_statement = "DELETE FROM profiles WHERE profiles.ID='".$que."'";
		$delete_query = mysql_query($delete_statement,$db_connection);
		if(!$delete_query){
			echo "deleting $que unsuccesful<br/>";
		}
}

function block($que){
	echo "<p align=\"center\">You cannot block ".$que."</p>";
}

?>

<html>
<link href="../styles.css" type="text/css" rel="stylesheet" />
<head><title>Admin|Profiles</title>
</head>
<body>
<p align="center">This page is for administration of <a href="http://localhost/shelter">shelter.com</a> </p>
<p><a href="http://localhost/shelter/admin">Home</a></p>

<form action=" <?php $_PHP_SELF ?>" method="POST">
 <table align="center">
<?php

$propertyId = array();
$type = array();
$location = array();
$rent = array();
$min_duration = array();
$tiles = array();
$pmachine = array();
$comment = array();
$date_uploaded = array();
$uploadedby = array();
$count = 0;
if($db_connection){
	$fetchprofiles = "SELECT * FROM profiles";


$fetchprofiles_Query = mysql_query($fetchprofiles,$db_connection);
if($fetchprofiles_Query)
{
	echo "Total Agents: ".mysql_num_rows($fetchprofiles_Query);
	while($profile = mysql_fetch_array($fetchprofiles_Query,MYSQL_ASSOC)){
		$mod = $count%2;
	switch($mod){
		case 0:
		$color = "#eeeeee";
		break;
		case 1:
		$color = "white";
	break;
	}
		echo "<tr style=\"background-color:$color\">
		<td class=\"noborder\">
		<input name=\"".$profile['ID']."\" type=\"checkbox\" value=\"".$profile['ID']."\"/>
		</td>
		<td>".($count+1)."</td>";
	echo "<td>".$profile['ID']."</td>";
	 echo "<td>".$profile['Business_Name']."</td>";
	echo "<td>".$profile['Office_Address']."</td>";
	echo "<td>". $profile['Office_Tel_No']."</td>";
	echo "<td>".$profile['Business_email']."</td>";
	echo "<td>".$profile['CEO_Name']."</td>";
	echo "<td>".$profile['Phone_No']."</td>";
	echo "<td>".$profile['Alt_Phone_No']."</td>";
	echo "<td>".$profile['User_ID']."</td>";
	echo "<td>".$profile['password']."</td>";
	echo "<td class=\"noborder\"><a href=\"$root/".$profile['User_ID']."\">view</a></td></tr>";

	$count++;
}
}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}

			
			mysql_close($db_connection);
		
}
	
?>
</table>
<style>
.action-category-container{
border:1px solid grey;
padding:10px;
margin:5px;
}
.action-category-header{
	font-weight:normal;
	letter-spacing:3px;
	color:purple;
}
.message-action{
	display:inline-block;
	padding:1%;
	background-color:purple;
	color:white;
	text-decoration:none;
	border-radius:5px;
}
</style>
<script>
function toggleMsgArea(recpt){
	event.preventDefault();
var msgArea = document.getElementById('msg-area');
var sendbutton = document.getElementById('send-button');
if(msgArea.style.display != 'block'){
	msgArea.style.display = 'block';
	
if(recpt == 'marked'){
	sendbutton.value = 'Send to marked';
}
else if(recpt == 'all'){
	sendbutton.value = 'Send to all';
}	
}
else{
	msgArea.style.display = 'none'
}
}
</script>
<div class="action-category-container">
<h2 class="action-category-header">Message</h2>
<div style="width:50%; display:none" id="msg-area">
<input style="display:block;padding:10px; width:100%;" type="text" name="msgSubject" placeholder="Messsage subject"/>
<textarea name="msgBody" id="message" style="width:100%;height:200px" placeholder="Send message to selected agents"></textarea>
<input name="smessage" id="send-button" type="submit" value=""/>
</div>
<a class="message-action" href="#" onclick="javascript: toggleMsgArea('marked')">Send Messsage to marked</a>
<a class="message-action" href="#" onclick="javascript: toggleMsgArea('all')">Send Messsage to all</a>
</div>

<div class="action-category-container">
<h2 class="action-category-header">Delete/Block</h2>
<input type="radio" value="Delete" name="action"/><label>Delete</label>
<input type="radio" value="Block" name="action"/><label >Block</label>
</div>
</form>


</body>
</html>
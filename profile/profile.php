<?php  
function checkfollow($follower,$following){
	$connect=true;
	require('../require/connexion.php');
$getfollows = mysql_query("SELECT * FROM follow WHERE (follower='$follower' AND following='$following')");
	if(mysql_num_rows($getfollows)>=1){
		return 'unfollow';
	}
	else{
	return 'follow';	
	}
mysql_close($db_connection);
}
?>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/profile_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php 
		$pagetitle = $Aid;
		$getuserName = true;
		$connect = true;
		$ref = "profile_page";
		require('../require/header.php');
		//get the agent with $key(from index.php) detail
$getprofile = mysql_query("SELECT * FROM profiles WHERE ID='".$key."'");
if($getprofile and mysql_num_rows($getprofile)==1){
while($user = mysql_fetch_array($getprofile,MYSQL_ASSOC)){
		$ID = $user['ID'];
		$BizName = $user['Business_Name'];
		$OAddress = $user['Office_Address'];
		$OTel = $user['Office_Tel_No'];
		$Omail = $user['Business_email'];
		$CEO = $user['CEO_Name'];
		$Phone = $user['Phone_No'];
		$Phone2 = $user['Alt_Phone_No'];
		$email = $user['email'];
		$Agent_Id = $user['User_ID'];
		}	
	}
	else{
	echo 'Profile was unable to reach';
	exit();
}	
?>
<?php
/*theis javascript source url is like this because this profile.php is dependent on another which
is outside this directory, since it'll be included, the url of followAjax has to be relative to the 
parent file where this would be included
*/
?>
<script src="../profile/followAjax.js" type="text/javascript"></script>

</head>
<body class="no-pic-background">
<div class="left">
<div class="maincontent">
<div id="biz-logo">

<input name="sample" onkeyup="sampling(this.value)"/>
<p id="sampletext"></p>

<img src="logo" alt="Business Logo" style="border:2px solid white; border-radius:30px;" height="100px" width="100px"/></div>
<div id="about-biz"><h4 align="center"><?php echo $BizName?></h4>
<p><?php echo $OAddress?></p>
<p><?php echo $OTel?></p>
<p> <?php echo $email?></p>
<?php
//if current user is logged in as an agen or a client
if($status==1 || $status==9){
	//check if conversation has existed between the users 
$possible1 = $myid.$key;
$possible2 = $key.$myid;
$mutual = mysql_query("SELECT conversationid FROM messagelinker WHERE (conversationid='$possible1' OR conversationid='$possible2')");
//if conversation has exited before, get the conversationid and take as the token
if(mysql_num_rows($mutual) ==1){
	$x = mysql_fetch_array($mutual,MYSQL_ASSOC);
	$token = $x['conversationid'];
}
//if there exist any conversation before, create a conversation id
else{
	$token = $myid.$key;
}
}
//if an agent is logged in
switch($status){
case 1:
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$Business_Name&rcpt=$key\"><button class=\"profile-buttons\"><i class=\"white-icon\" id=\"message-icon\"></i>send message</button></a>";
	if($BizName != $Business_Name)
	{
		$followornot = checkfollow($Business_Name,$BizName);
		$followicon = ($followornot=='follow' ? 'follow-icon' : 'unfollow-icon');
	
	$followup = "<button class=\"profile-buttons\" id=\"followbutton\" onclick=\"follow('$Business_Name','$profile_name','$BizName','A4A')\"><i class=\"white-icon\" id=\"$followicon\"></i> $followornot</button>";
	echo $followup;
	echo $sendmessage;
	}
	else{
	$editprofile = "<a href=\"$root/manage/account.php\"><button class=\"profile-buttons\"><i class=\"white-icon\" id=\"edit-icon\"></i> Edit profile</button></a>";
	echo $editprofile;
	}
break;
//if a client is logged in
	case 9:
	$followornot = checkfollow($ctaname,$BizName);
		$followicon = ($followornot=='follow' ? 'follow-icon' : 'unfollow-icon');
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$ctaname&rcpt=$key\"><button class=\"profile-buttons\"><i class=\"white-icon\" id=\"message-icon\"></i> send message</button></a>";
	$followup = "<button class=\"profile-buttons\" id=\"followbutton\" onclick=\"follow('$ctaname','$ctaid','$BizName','C4A')\"><i class=\"white-icon\" id=\"$followicon\"></i> $followornot</button>";
echo $followup;
	echo $sendmessage;
	break;
//for visitors
default:
$sendmessage = "<a href=\"$root/cta/checkin.php?_rdr=0\"><button class=\"profile-buttons\"><i class=\"white-icon\" id=\"message-icon\"></i> send message</button></a>";
	$followup =  "<a href=\"$root/cta/checkin.php?_rdr=0\"><button class=\"profile-buttons\"><i class=\"white-icon\" id=\"follow-icon\"></i> follow</button></a>";
	echo $followup;
	echo $sendmessage;
	break;
}
?>
</div>
</div><hr style="width:100%; "/>
<div class="recent-uploads">
<h4>Recent uploads by <?php echo $BizName?></h4>
<?php
$fetchproperties = mysql_query("SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM
                               properties WHERE (uploadby='".$Aid."')ORDER BY date_uploaded DESC");
//if there is any record fetched
if($fetchproperties){
	if(mysql_num_rows($fetchproperties)>=1){
	$count=0;
	while($property = mysql_fetch_array($fetchproperties,MYSQL_ASSOC)){
	$propertyId[$count] = $property['property_ID'];
	$propertydir[$count] = $property['directory'];
	$type[$count] = $property['type'];
	$location[$count] = $property['location'];
	$rent[$count] = $property['rent'];
	$min_payment[$count] = $property['min_payment'];
	$bath[$count] = $property['bath'];
	$toilet[$count] = $property['toilet'];
	$description[$count] = $property['description'];
	$date_uploaded[$count] = $property['date_uploaded'];
	$uploadby[$count] = $property['uploadby'];
	$count++;
//last value of count will eventually equals to the total records fetched.
		}
require("../require/propertyboxes.php");
	}
//if zero file was fetched
	else{
	//if it's the owner of the account that is accessing this page
		if($status==1 && $BizName == $Business_Name){
		echo "You have not uploaded any property yet, <a href=\"$root/upload\">upload one now</a>";
		}
		else{
			echo "$BizName have not upload any property yet";
		}
	}
}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}


?>
</div>
<?php
mysql_close($db_connection);
require("../require/footer.html");
?>
</div>
<div class="right">
<h4 align="center">options</h4>
<?php
switch($status){
	case 0:
	echo "Advert could be placed here";
	break;
	case 1:
	echo "<a href=\"editprofile.php\"><button class=\"editbutton\">Edit profile</button></a>";
	break;
	case 9:
	echo "<a href=\"editprofile.php\"><button class=\"editbutton\">Follow</button></a>";
	break;
}
?>
</div>
</body>
<?php //require("../require/footer.html"); ?>
</html>
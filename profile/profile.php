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
</head>
<body class="no-pic-background">
<div class="left">
<div class="maincontent">
<div id="biz-logo">
<img src="logo" alt="Business Logo" style="border:2px solid white; border-radius:30px;" height="100px" width="100px"/></div>
<div id="about-biz"><h4 align="center"><?php echo $BizName?></h4>
<p><?php echo $OAddress?></p>
<p><?php echo $OTel?></p>
<p> <?php echo $email?></p>
<?php
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
switch($status){
	case 1:
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$Business_Name&rcpt=$key\">send message</a>";
	if($BizName != $Business_Name)
	{
	echo "<p align=\"right\"><a href=\"$root/profile/follow.php?flwer=$Business_Name&flwerId=$profile_name&flwing=$BizName&t=A4A&r=$Agent_Id\"><i class=\"black-icon\" id=\"edit-icon\"></i>".checkfollow($Business_Name,$BizName)."</a></p>";
	echo $sendmessage;
	}
	else{
	echo "<p align=\"right\"><a href=\"$root/manage/account.php\"><i class=\"black-icon\" id=\"edit-icon\"></i>Edit profile</a></p>";
	}
break;
	case 9:
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$ctaname&rcpt=$key\">send message</a>";
echo "<p align=\"right\"><a href=\"$root/profile/follow.php?flwer=$ctaname&flwerId=$ctaid&flwing=$BizName&t=C4A&r=$Agent_Id\"><i class=\"black-icon\" id=\"edit-icon\"></i>".checkfollow($ctaname,$BizName)."</a></p>";
echo $sendmessage;
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
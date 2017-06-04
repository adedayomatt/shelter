<?php  
function checkfollow($follower,$following){
	$connect=true;
	require('../require/connexion.php');
$getfollows = mysql_query("SELECT * FROM follow WHERE (follower='$follower' AND following='$following')");
	if(mysql_num_rows($getfollows)>=1){
		return 'positive';
	}
	else{
	return 'negative';	
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
		$regDate = $user['timestamp'];
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
<script src="../js/profile.js" type="text/javascript"></script>
<script src="../js/propertybox.js" type="text/javascript"></script>

<?php
//if current user is logged in as an agen or a client
$followup = '';
$sendmessage ='';
$editprofile='';
$followStatus = '';
if($status==1 || $status==9){
	//check if conversation has existed between the users 
$possible1 = $myid + $key;
$mutual = mysql_query("SELECT conversationid FROM messagelinker WHERE (conversationid='$possible1')");
//if conversation has exited before, get the conversationid and take as the token
if(mysql_num_rows($mutual) ==1){
	$x = mysql_fetch_array($mutual,MYSQL_ASSOC);
	$token = $x['conversationid'];
}
//if there exist any conversation before, create a conversation id
else{
	$token = $myid + $key;
}
}
//if an agent is logged in
switch($status){
case 1:
	if($BizName != $Business_Name)
	{
		if (checkfollow($Business_Name,$BizName)=='positive'){
			$followStatus = 'yes';
			$text = 'unfollow';
			$f = 'unfollow-button';
			$ficon = 'white-icon unfollow-icon';
		}
	else if (checkfollow($Business_Name,$BizName)=='negative'){
		$followStatus = 'no';
		$text = 'follow';
	   $f = 'follow-button';
	   $ficon = 'black-icon follow-icon';	
		}
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$Business_Name&rcpt=$key\"><button class=\"profile-buttons\" id=\"sendmessage-button\"><i class=\"black-icon\" id=\"message-icon\"></i>send message</button></a>";
	$followup = "<button class=\"$f\" id=\"follow-button\" onclick=\"follow('follow-button','$Business_Name','$profile_name','$BizName','A4A')\"><i class=\"$ficon\"></i>  $text</button>";
	}
	else{

	$editprofile = "<a href=\"$root/manage/account.php\"><button class=\"profile-buttons\" id=\"editprofile-button\"><i class=\"black-icon\" id=\"edit-icon\"></i> Edit profile</button></a>";
	}
break;
//if a client is logged in
	case 9:
if (checkfollow($ctaname,$BizName)=='positive'){
			$followStatus = 'yes';
			$text = 'unfollow';
			$f = 'unfollow-button';
			$ficon = 'white-icon unfollow-icon';
		}
	else if (checkfollow($ctaname,$BizName)=='negative'){
		$followStatus = 'no';
		$text = 'follow';
	$f = 'follow-button';
	$ficon = 'black-icon follow-icon';	
		}
		
$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$ctaname&rcpt=$key\"><button class=\"profile-buttons\" id=\"sendmessage-button\"><span class=\"black-icon\" id=\"message-icon\"></span>send message</button></a>";
	$followup = "<button class=\"$f\" id=\"follow-button\" onclick=\"follow('follow-button','$ctaname','$ctaid','$BizName','C4A')\"><span class=\"$ficon\"></span>  $text</button>";
	break;
//for visitors
default:
$sendmessage = "<a href=\"$root/cta/checkin.php?_rdr=1\"><button class=\"profile-buttons\" id=\"sendmessage-button\"><span class=\"black-icon\" id=\"message-icon\"></span>send message</button></a>";
	$followup =  "<a href=\"$root/cta/checkin.php?_rdr=1\"><button class=\"follow-button\" id=\"follow-button\"><i class=\"black-icon follow-icon\"></i> follow</button></a>";
	break;
}
?>

</head>
<body class="no-pic-background">
<?php require('../require/sidebar.php') ?>
<div class="main-content">
<div id="logo-and-name">
<div id="biz-logo-container">
<?php echo "<h1 class=\"avatar\">".substr($BizName,0,1)."</h1> "?>
</div>
<div id="about-biz">
<?php
echo "<h3  id=\"bizname\" >$BizName</h3>";
if($followStatus=='yes'){
	//echo "<div class=\"following-status\" id=\"following-status\" style=\"font-weight:normal; font-size:80%;color:grey;\">you are currently following $BizName</div>
	echo "<div class=\"follow-message-container\">".$followup.$sendmessage."</div>";
}
else if ($followStatus=='no'){
	//echo "<div class=\"following-status\" id=\"following-status\"  style=\"font-weight:normal; font-size:80%;color:grey;\">you are currently <i>NOT</i> following $BizName </div>
	echo "<div class=\"follow-message-container\">".$followup.$sendmessage."</div>";
}
else{
	//echo "<div class=\"following-status\" id=\"following-status\" style=\"font-weight:normal; font-size:80%;color:grey;\"><a href=\"login\">login</a> to follow $BizName </div>
	echo "<div class=\"follow-message-container\">".$followup.$sendmessage."</div>";
}
 ?>
<p><?php echo $OAddress?></p>
<p><?php echo $OTel?></p>
<p> <?php echo $email?></p>
<?php echo $editprofile ?>
</div>

</div>
<br/>

<div class="recent-uploads">
<p style="color:grey;text-align:center;margin-bottom:10px" >Recent uploads</p>
<?php
$max = 7;
if(isset($_GET['next']) && $_GET['next']>0){
	$start = $_GET['next'];
	$end = $_GET['next'] + $max;
}
 else{
	 $start = 0;
	 $end = $max;
 }

$fetchproperties = mysql_query("SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp,views FROM
                               properties WHERE (uploadby='$Aid')ORDER BY date_uploaded DESC LIMIT $start,$end");
//if there is any record fetched
if($fetchproperties){
	$totalUplpoads = mysql_num_rows(mysql_query("SELECT property_ID FROM  properties WHERE (uploadby='$Aid')"));
	$clientFollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$BizName' AND followtype='C4A'"));	
	$agentFollower = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE following='$BizName' AND followtype='A4A'"));
	$Following = mysql_num_rows(mysql_query("SELECT * FROM follow WHERE follower='$BizName'"));	
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
	$howlong[$count] = $property['timestamp'];
	$views[$count] = $property['views'];
	$count++;
//last value of count will eventually equals to the total records fetched.
		}
	$ref ='profile_page';
require("../require/propertyboxes.php");
if(!empty($propertyId)){
echo "<a class=\"show-more-link\" href =\"?next=$end\" >show more>></a>";
}
else{
if($start==0){
	echo "<div class=\"no-property\" align=\"center\">$BizName have not uploaded any property</div>";
}
else if($start>0){
	echo "<div class=\"no-property\" align=\"center\">There are no more properties by $BizName</div>";
	}
}
	}

else{
	echo "<div class=\"no-property\" align=\"center\"><b>An error occured!!</b></div>";
			}


?>
</div>
<?php
//require("../require/footer.html");
?>
</div>
<div class="rhs">
<div class="relative-rhs-content">

<div class="all-corners-border" id="stats-container">
<h4 class="container-headers">STATS</h4>
<?php
function timeReg($timestamp){
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
		$since = date('l, M d ',$timestamp).'('.(int)($time/86400).' days ago)';
	}
	else if($time>=604800 && $time<18144000){
		$since = date('M d  ',$timestamp).'('.(int)($time/604800).' weeks ago)';
	}
	else{
		$since = "sometime ago";
	}
return $since;
		}
?>

<ul class="no-padding-ul">
<li class="agent-stats-list" >Shelter agent since: <?php echo timeReg($regDate)?> </li>
<li class="agent-stats-list" >No of Uploads: <?php echo $totalUplpoads ?> </li>
<li class="agent-stats-list" >Follower [Clients]: <?php echo $clientFollower ?> </li>
<li class="agent-stats-list" >Follower [Agents]: <?php echo $agentFollower ?> </li>
<li class="agent-stats-list" >Following: <?php echo $Following ?> </li>
</ul>
</div>
<img style="width:100%; height:30%; margin-bottom:10px;" src="../resrc/image/advert2.jpeg" />
<div id="other-agents-container">
<h4 class="container-headers">OTHER AGENTS</h4>
<p>Other agents around <?php echo $BizName?></p>
<?php 
/*i want to get other agents that are in the same locality as this one
//$getRelatedAgents = mysql_query("SELECT * FROM profiles WHERE(Office_Address LIKE '%$OAddress%')");*/
$getRelatedAgents = mysql_query("SELECT * FROM profiles LIMIT 10");
if(mysql_num_rows($getRelatedAgents)==0){
	echo "<p style=\"font-size:120%; color:red;\">No agent is found around $BizName</p>
		  <p>You may <a href=\"../agents\">check other agents</as></p>";
	
}
else{
	echo "<ul class=\"no-padding-ul\">";
	while($otherAgent = mysql_fetch_array($getRelatedAgents,MYSQL_ASSOC)){
		echo "<a class=\"list-link\" href=\"../".$otherAgent['User_ID']."\"><li class=\"other-agents-list\">".$otherAgent['Business_Name']."</li></a>";
	}
	
echo "</ul>";
}
?>
<p align="right"><a href="../agents">all agents>></a></p>
</div>
<div>
<?php
if($status != 1){
	echo "
		<li><a href=\"../signup\">Report this agent</a></li>
	<li><a href=\"../signup\">create your own account</a></li>";
}
else{
	echo "<a href=\"../logout\">Logout</a>";
}
?>

</div>
</div>
</div>
</body>
<?php mysql_close($db_connection); ?>
</html>
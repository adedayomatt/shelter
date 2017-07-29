<?php 
require('../resources/php/master_script.php'); ?>
<html>
<?php require('../resources/html/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/profile_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php 
		$pagetitle = $Aid;
		$ref = "profile_page";
		require('../resources/php/header.php');
		//get the agent with $key(from index.php) detail
$getprofile = $db->query_object("SELECT * FROM profiles WHERE ID=$key");
if(is_object($getprofile) and $getprofile->num_rows ==1){
while($user = $getprofile->fetch_array(MYSQLI_ASSOC)){
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
	$general->halt_page();
}	

//if current user is logged in as an agen or a client
$followup = '';
$sendmessage ='';
$editprofile='';
if($status==1 || $status==9){
	//check if conversation has existed between the users 
	$myid = ($status==1 ? $agentId : $ctaid);
$possible1 = $myid + $key;
$mutual = $db->query_object("SELECT conversationid FROM messagelinker WHERE (conversationid=$possible1)");
//if conversation has exited before, get the conversationid and take as the token
if($mutual->num_rows ==1){
	$token = $mutual->fetch_array(MYSQLI_ASSOC)['conversationid'];
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
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$Business_Name&rcpt=$key\"><button class=\"profile-buttons\" id=\"sendmessage-button\"><i class=\"black-icon message-icon\"></i>send message</button></a>";
	$followup = $agent->follow($agentId, $Business_Name,$profile_name,$key,$BN,$Aid,'A4A');
	}
	else{
	$editprofile = "<a href=\"$root/manage/account.php\"><button class=\"profile-buttons\" id=\"editprofile-button\"><i class=\"black-icon edit-icon\"></i> Edit profile</button></a>";
	}
break;
//if a client is logged in
	case 9:	
$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$cta_name&rcpt=$key\"><button class=\"profile-buttons\" id=\"sendmessage-button\"><span class=\"black-icon message-icon\"></span>message</button></a>";
	$followup = $agent->follow($ctaid, $cta_name,null,$key,$BN,$Aid,'C4A');
		break;
//for visitors
default:
$sendmessage = "<a href=\"$root/cta/checkin.php?_rdr=1\"><button class=\"profile-buttons\" id=\"sendmessage-button\"><span class=\"black-icon message-icon\"></span>message</button></a>";
$followup =  "<a href=\"$root/cta/checkin.php?_rdr=1\"><button class=\"follow-button\" id=\"follow-button\"><i class=\"black-icon follow-icon\"></i> follow</button></a>";
	break;
}
?>

</head>
<body class="no-pic-background">
<?php require('../resources/php/sidebar.php') ?>
<div class="profile-main-content">

<div id="profile-wrapper">
<div id="logo-and-name">
<?php echo "<h1 id=\"avatar\">".substr($BizName,0,1)."</h1> "?>
<div id="BizName-and-buttons">
<?php
echo "<h3 id=\"bizname\" >$BizName $followup</h3>";
	//echo "<div class=\"following-status\" id=\"following-status\" style=\"font-weight:normal; font-size:80%;color:grey;\"><a href=\"login\">login</a> to follow $BizName </div>
	echo "<div class=\"follow-message-container\">".$sendmessage."</div>";
echo $editprofile;

?>
 </div>
</div>
 <div id="biz-contacts-wrapper">
<h2 style="color: purple">Contacts</h2>
<p><span class="black-icon location-icon"></span><?php echo $OAddress?></p>
<p><?php echo $OTel?></p>
<p> <?php echo $email?></p>
</div>
</div>
<h4 class="container-headers">STATS</h4>
<div id="stat-wrapper">


<div class="all-corners-border" id="stats-container">
<ul class="no-padding-ul">
<li class="agent-stats-list" style="display:block">Shelter agent since: <?php echo $general->since($regDate)?> </li>
<li class="agent-stats-list" >Total Uploads: <?php  echo count($data->get_uploads($ID,$Agent_Id)) ?> </li>
<li class="agent-stats-list" >Follower [Clients]: <?php echo count($data->client_followers($ID)) ?> </li>
<li class="agent-stats-list" >Follower [Agents]: <?php echo count($data->agent_followers($ID)) ?> </li>
<li class="agent-stats-list" >Following: <?php echo count($data->agent_followings($ID)) ?> </li>
</ul>
</div>
</div>

<h4 class="container-headers">RECENT UPLOADS</h4>
<div id="recent-uploads">
<?php

   $final_property_query = property::$property_query." WHERE agent.User_Id = '$Agent_Id'";
   if($db->query_object($final_property_query)->num_rows ==0){
if($status == 1 && $Business_Name == $BizName){
	?>
	<div class="no-property" align="center"><span class="black-icon warning-icon"></span>You have not uploaded any property 
	<a class="skyblue-inline-block-link" href="<?php echo $root.'/upload' ?>"><span class="white-icon outbox-icon"></span>upload now</a>
		</div>
	<?php
	}
	else{
		?>
	<div class="no-property" align="center"><span class="black-icon warning-icon\"></span><?php echo $BizName ?> have not uploaded any property</div>
	<?php
	}
   }
   else{
   require('../resources/php/property_display.php');
   }

?>
</div>

<div id="bottom-links-container">
<?php
if(($status ==1 && $BizName != $Business_Name) || $status !=1){
	//links for visitors,client and other agents aside this one
	?>
<a class="bottom-links report" href="../signup"><span class="white-icon flag-icon"></span>Report this agent</a>	
<?php
}
if($status!=1){
	//links for non agent  -  either visitor or client
	?>
	<a class="bottom-links create" href="../signup">create your own account</a>
	<?php
}
if($status == 1 && $BizName == $Business_Name){
	//link for the owner
	?>
<a class="bottom-links logout" href="../logout">Logout</a>
	<?php
}
?>
</div>

<h4 class="container-headers">OTHER AGENTS</h4>
<div id="other-agents-wrapper">
<div id="other-agents-container">
<?php 
/*i want to get other agents that are in the same locality as this one
//$getRelatedAgents = mysql_query("SELECT * FROM profiles WHERE(Office_Address LIKE '%$OAddress%')");*/
$get_related_agents = $db->query_object("SELECT * FROM profiles WHERE(ID != $ID) LIMIT 10");
if($get_related_agents->num_rows==0){
	?>
<p style="font-size:120%; color:red;">No agent is found around <?php echo $BizName ?></p>
 <p>You may <a href="../agents">check other agents</a></p>
	
	<?php
}
else{
	?>
	<ul class="no-padding-ul">
<?php
	while($otherAgent = $get_related_agents->fetch_array(MYSQLI_ASSOC)){
		?>
<li class="other-agents-list"><a class="list-link" href="../<?php echo $otherAgent['User_ID'] ?>"><?php echo $otherAgent['Business_Name'] ?></a>
<span style=""><?php echo ($status==1 ? $agent->follow($ID,$BizName,$Agent_Id,$otherAgent['ID'],$otherAgent['Business_Name'],$otherAgent['User_ID'],'A4A') : $agent->follow($ctaid,$cta_name,null,$otherAgent['ID'],$otherAgent['Business_Name'],$otherAgent['User_ID'],'C4A')) ?></span>
<p class="other-agents-address"><?php echo $otherAgent['Office_Address']  ?> </p></li>
<?php 
}
	?>
</ul>
<?php
}
?>
<div>
<a class="skyblue-inline-block-link" style=" display:block;text-align:center" href="../agents">see all agents</a>
</div>
</div>
</div>
<?php require('../resources/php/footer.php'); ?>

</div>
</body>
</html>
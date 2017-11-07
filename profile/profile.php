<?php 
require('../resources/php/master_script.php'); ?>
<html>
<head>

<?php 
	$pagetitle = $Aid;
	$ref = "profile_page";
require('../resources/global/meta-head.php'); ?>
<link href="../css/profile_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<?php 
		
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
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$Business_Name&rcpt=$key\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-envelope\"></span>message</button></a>";
	$followup = $agent->follow($agentId, $Business_Name,$profile_name,$key,$BN,$Aid,'A4A');
	}
	else{
	$editprofile = "<a href=\"$root/manage/account.php\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit profile</button></a>";
	}
break;
//if a client is logged in
	case 9:	
$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=$cta_name&rcpt=$key\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-envelope\"></span>message</button></a>";
	$followup = $agent->follow($ctaid, $cta_name,null,$key,$BN,$Aid,'C4A');
		break;
//for visitors
default:
$sendmessage = "<a href=\"$root/cta/checkin.php?_rdr=1\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-envelope\"></span>message</button></a>";
$followup =  $agent->dummy_follow();
	break;
}
?>

</head>
<body class="no-pic-background">
<?php 
$showStaticHeader = true;
$staticHead = "<div class=\"col-sm-offset-3\">
<div class=\"row hidden-lg hidden-md hidden-sm static-head-primary\">
<h2 class=\"site-color font-20\"><span class=\"glyphicon glyphicon-briefcase padding-10 border-round e3-border\"></span>$BizName</h2>
</div>
</div>";
require('../resources/global/header.php');?>


	<div class="container-fluid body-content">
	<div class="row">
<?php require('../resources/global/sidebar.php') ?>

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 main-content">
<div class="row  white-background pp">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:5px;">
<h3 id="bizname" ><span class="glyphicon glyphicon-briefcase agent-avatar"></span><span class="bn"><?php echo $BizName ?> </span></h3>
</div>
<style>
@media all and (max-width:778px){
	.pp{
		background-color:#20435C;
	}
	.bn{
		color:white;
	}
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="row" style="padding:10px">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
<?php echo $followup ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
<?php echo $sendmessage ?>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<?php echo $editprofile ?>
</div>

</div>
</div>
 
 
</div>

<div class="padded-main-content">
<div class="row">
<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 white-background grey padding-10 address-wrapper" style="">
<span><span class="glyphicon glyphicon-map-marker"></span><span class="text-center"><?php echo $OAddress?></span></span>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-10 contacts-wrapper">
 <div>
<span class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> <span class="glyphicon glyphicon-earphone"></span><?php echo $OTel?></span>
<span class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> <span class="glyphicon bold">@</span><?php echo $email?></span>
</div>
</div>
<p class="grey text-right margin-5"><span class="glyphicon glyphicon-time"></span>User since: <?php echo $general->since($regDate)?></p>
</div>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php 
$agent_followers_id = $data->agent_followers($ID);
$total_agent_followers = count($agent_followers_id);
?>
<div class="grey font-18 bold margin-10">Agent Followers (<?php echo $total_agent_followers ?>)</div>
<div class="scrollable-x">
<div class="<?php echo ($total_agent_followers>=3 ? 'scrollable-x-inner':'') ?>">
<?php
if($total_agent_followers == 0){
	?>
	<div class="white-background padding-10 e3-border text-center">No agent follower</div>
	<?php
}
else{
for($a=0;$a<$total_agent_followers;$a++){
if($a>=10){
	break;
}
$get_agent_follower_detail = $db->query_object("SELECT * FROM profiles WHERE ID = $agent_followers_id[$a]");
$af = $get_agent_follower_detail->fetch_array(MYSQLI_ASSOC);
	?>
	<div class="inline-block white-background padding-5 e3-border text-center agent-followers-box">
	<div class="margin-5"><span class="glyphicon glyphicon-briefcase agent-avatar"></span></div>
	<div class="margin-5"><a href="<?php echo '../'.$af['User_ID'] ?>" > <?php echo $general->substring($af['Business_Name'],'abc',16) ?></a></div>
	<div class="margin-5 text-left grey font-12"><span class="glyphicon glyphicon-map-marker"></span><?php echo $general->substring($af['Office_Address'],'xyz',16) ?> </div>
	<div class="margin-5">
	<?php 
if($status==1){
echo $agent->follow($ID,$BizName,$Agent_Id,$af['ID'],$af['Business_Name'],$af['User_ID'],'A4A');
}
else if($status==9){
 echo $agent->follow($ctaid,$cta_name,null,$af['ID'],$af['Business_Name'],$af['User_ID'],'C4A');
}
else{
	echo $agent->dummy_follow();
}
 ?>
 </div>
	</div>
	<?php
	$get_agent_follower_detail->free();
}
}
?>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php 
$client_followers_id = $data->client_followers($ID);
$total_client_followers = count($client_followers_id);
?>
<div class="grey font-18 bold margin-10">Client Followers (<?php echo $total_client_followers ?>)</div>
<div class="scrollable-x">
<div class="<?php echo ($total_client_followers>=3 ? 'scrollable-x-inner':'') ?>">
<?php
if($total_client_followers == 0){
	?>
	<div class="white-background padding-10 e3-border text-center">No client follower</div>
	<?php
}
else{
for($c=0;$c<$total_client_followers;$c++){
if($c>=10){
	break;
}
$get_client_follower_detail = $db->query_object("SELECT * FROM cta WHERE ctaid = $client_followers_id[$c]");
$cf = $get_client_follower_detail->fetch_array(MYSQLI_ASSOC);
$client_follower_name = $cf['name'];
$get_client_request = $client->get_request($cf['ctaid'],$cf['name']);
	?>
	<div class="inline-block white-background padding-5 e3-border text-center client-followers-box">
	<div class="margin-5"><span class="glyphicon glyphicon-user client-avatar"></span></div>
	<div class="margin-5"><?php echo (strlen($client_follower_name) >= 16 ? substr($client_follower_name,0,15).'...' : $client_follower_name) ?></div>
	<div class="client-follower-request-container grey f7-background border-radius-3 e3-border margin-5">
	<?php
	if(empty($get_client_request)){
		?>
		<p class="grey font-12"><span class="glyphicon glyphicon-question-sign site-color font-20"></span>No Request Yet</p>
		<?php
	}else{
	?>
	<div>
	<div><span class="glyphicon glyphicon-question-sign site-color font-20"></span><?php echo $get_client_request['type'] ?></div>
	<div><?php echo $get_client_request['maxprice'] ?></div>
	<div><?php echo (strlen($get_client_request['location'])>=16 ? '...'.substr($$get_client_request['location'],(strlen($$get_client_request['location'])-16),strlen($get_client_request['location'])) : $get_client_request['location']) ?></div>
	</div>
	<?php
	}
	?>
	</div>
	<div class="margin-5">
	<?php 
	if($status == 1){
		echo $property_obj->suggestProperty($agentId,$Business_Name,$profile_name,$agent_token,$cf['name'],$cf['ctaid']);
	}
	else{
		echo $property_obj->suggestProperty(null,null,null,null,$cf['name'],$cf['ctaid']);
	}
 ?>
 </div>
	</div>
	<?php
$get_client_follower_detail->free();
unset($get_client_request);
}
}
?>
</div>
</div>
</div>
</div>

<style>
.agent-followers-box{
	width:150px;
	height:170px;
	}
.agent-followers-box,.client-followers-box,.followings-box{
	border-radius: 5px;
}
.client-follower-request-container{
	height:80px;
	line-height:25px;
}
</style>
<div class="row e3-border padding-5 stats-wrapper">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="row" style="line-height:30px">
<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left" ><span class="glyphicon glyphicon-briefcase"></span><sup>+</sup>Following: <?php echo count($data->agent_followings($ID)) ?> </span>
<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left" ><span class="glyphicon glyphicon-send"></span>Total Uploads: <?php  echo count($data->get_uploads($ID,$Agent_Id)) ?> </span>
</div>
</div>
</div>

<div class="row uploads-wrapper">
<?php

   $final_property_query = property::$property_query." WHERE agent.User_Id = '$Agent_Id'";
   if($db->query_object($final_property_query)->num_rows ==0){
if($status == 1 && $Business_Name == $BizName){
	?>
	<div class="no-property" align="center"><span class="black-icon warning-icon"></span>You have not uploaded any property 
	<a class="btn btn-primary" href="<?php echo $root.'/upload' ?>">upload now</a>
		</div>
	<?php
	}
	else{
		?>
	<div class="no-property"><?php echo $BizName ?> have not uploaded any property</div>
	<?php
	}
   }
   else{
   require('../resources/global/property_display.php');
   }

?>
</div>

<div class="row white-background e3-border padding-5">
<?php
if(($status ==1 && $BizName != $Business_Name) || $status !=1){
	//links for visitors,client and other agents aside this one
	?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-5">
<a href="../signup"><button class="btn btn-danger" ><span class="white-icon flag-icon"></span>Report this agent</button></a>
</div>	
<?php
}
if($status!=1){
	//links for non agent  -  either visitor or client
	?>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-5">
	<a  href="../signup" class="btn btn-primary">create your own account</a>
	</div>
	<?php
}
if($status == 1 && $BizName == $Business_Name){
	//link for the owner
	?>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-5">
<a href="../logout" class="btn btn-danger">Logout</a></div>
	<?php
}
?>
</div>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<h4 class="container-headers">Other Agents</h4>
<?php 
/*i want to get other agents that are in the same locality as this one
//$getRelatedAgents = mysql_query("SELECT * FROM profiles WHERE(Office_Address LIKE '%$OAddress%')");*/
$get_related_agents = $db->query_object("SELECT * FROM profiles WHERE(ID != $ID) LIMIT 10");
if($get_related_agents->num_rows==0){
	?>
	<div class="white-background text-center padding-10 e3-border">
<p class="" >No agent is found around <?php echo $BizName ?></p>
 <p>You may <a href="../agents">check other agents</a></p>
 </div>
	<?php
}
else{
	?>
<div class="scrollable-x">
<div class="scrollable-x-inner" style="width:1600px">
<?php
	while($otherAgent = $get_related_agents->fetch_array(MYSQLI_ASSOC)){
		?>
<div class="inline-block white-background margin-3 padding-5 border-radius-2 e3-border text-center" style="width:150px; height:160px; margin-top:0px">
<div><span class="glyphicon glyphicon-briefcase agent-avatar"></span></div>
<div><a href="../<?php echo $otherAgent['User_ID'] ?>"><?php echo ((strlen($otherAgent['Business_Name']) > 15) ? substr($otherAgent['Business_Name'],0,14).'...' : $otherAgent['Business_Name'] ) ?></a></div>
<div class="grey font-12"><?php echo ((strlen($otherAgent['Office_Address']) > 20) ? substr($otherAgent['Office_Address'],0,19).'...' : $otherAgent['Office_Address'] )  ?> </div>
<div>
<style>
.follow-status{
	display:none;
}</style>
<?php 
if($status==1){
echo $agent->follow($ID,$BizName,$Agent_Id,$otherAgent['ID'],$otherAgent['Business_Name'],$otherAgent['User_ID'],'A4A');
}
else if($status==9){
 echo $agent->follow($ctaid,$cta_name,null,$otherAgent['ID'],$otherAgent['Business_Name'],$otherAgent['User_ID'],'C4A');
}
else{
	echo $agent->dummy_follow();
}
 ?></div>
 
</div>
<?php 
}
	?>
</div>
</div>
<?php
}
?>
<div class="text-right">
<a href="../agents" class="btn btn-primary"> see more agents </a>
</div>

</div>
</div>

<?php require('../resources/global/footer.php'); ?>

</div>
</div><!--main-content-->

</div><!--parent row-->
</div><!--container-fluid-->
</body>
</html>
<?php 
require('../../resources/master_script.php'); 
	$agent = new agent($key);	
?>
<html>
<head>

<?php 
	$pagetitle = $agent->username;
	$ref = "profile_page";
require('../../resources/global/meta-head.php'); ?>
<?php 
		$ID = $agent->id;
		$business_name = $agent->business_name;
		$office_address = $agent->address;
		$office_contact = $agent->office_contact;
		$business_mail = $agent->business_mail;
		$CEO = $agent->CEO;
		$contact1 = $agent->contact1;
		$contact2 = $agent->contact2;
		$CEO_mail = $agent->CEO_mail;
		$username = $agent->username;
		$registration_timestamp = $agent->registration_timestamp;

//if current user is logged in as an agen or a client
$follow_button = '';
$sendmessage ='';
$editprofile='';
if($status==1 || $status==9){
	//check if conversation has existed between the users 
	$myid = ($status==1 ? $loggedIn_agent->id : $loggedIn_client->id);
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
	if($business_name != $loggedIn_agent->business_name)
	{
	$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=".$loggedIn_agent->business_name."&rcpt=$key\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-envelope\"></span>message</button></a>";
	$follow_button = $agent->follow_button($loggedIn_agent->id,$loggedIn_agent->business_name,$loggedIn_agent->username,'A4A');
	}
	else{
	$editprofile = "<a href=\"$root/manage/account.php\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span> Edit profile</button></a>";
	}
break;
//if a client is logged in
	case 9:	
$sendmessage = "<a href=\"$root/messages/compose.php?cv=".$token."&i=".$loggedIn_client->name."&rcpt=$key\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-envelope\"></span>message</button></a>";
	$follow_button = $agent->follow_button($loggedIn_client->id, $loggedIn_client->name,null,'C4A');
		break;
//for visitors
default:
$sendmessage = "<a href=\"$root/cta/checkin.php?_rdr=1\"><button class=\"btn btn-default\"><span class=\"glyphicon glyphicon-envelope\"></span>message</button></a>";
$follow_button =  $agent->follow_button(null,null,null,null);
	break;
}

function me(){
	GLOBAL $status;
	GLOBAL $agent;
	GLOBAL $loggedIn_agent;
	if($status == 1 && $loggedIn_agent->business_name == $agent->business_name){
		return true;
	}
	else{
		return false;
	}
}
?>

</head>
<body class="no-pic-background">
<?php 
$showStaticHeader = true;
$staticHead = "<div class=\"hidden-lg hidden-md hidden-sm static-head-primary\">
<h5 class=\"site-color\"><span class=\"glyphicon glyphicon-briefcase padding-10 round e3-border\"></span>$business_name (@$username)</h5>
</div>";
require('../../resources/global/header.php');?>


	<div class="container-fluid">
	<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
		<div class="contain remove-side-margin-xs">
			<div class="head f7-background">
			<?php
			if(!me()){
				?>
				<span class="float-right"><?php echo $follow_button ?></span>
				<?php
			}
			?>
			<h4 class="text-left"><span class="glyphicon glyphicon-briefcase agent-avatar"></span><span><?php echo $business_name ?> </span></h4>
			
			</div>
			<div class="body white-background">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:5px">
						<span class="glyphicon glyphicon-map-marker round e3-border"></span>  <?php echo $office_address ?>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
						<div class="dropdown">
							<a href="" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<span class="text-center"><span class="glyphicon glyphicon-earphone"></span>  Contacts</span>  <span class="caret"></span>
							</a>
							<ul class="dropdown-menu"s>
								<li class="padding-0-5"><span class="glyphicon glyphicon-earphone round e3-border"></span>  <?php echo $office_contact?></li>
								<li role="separator" class="divider"></li>
								<li class="padding-0-5"><span class="glyphicon glyphicon-earphone round e3-border"></span><?php echo $contact1 ?></li>
								<li role="separator" class="divider"></li>
								<li class="padding-0-5"><span class="glyphicon glyphicon-earphone round e3-border"></span><?php echo $contact2 ?></li>
								<li role="separator" class="divider"></li>
								<li class="padding-0-5"><span class="glyphicon bold round e3-border">@</span><?php echo $business_mail?></li>
							</ul>
						</div>
					</div>
					<?php if(me()){
						?>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<?php echo $editprofile ?>
					</div>
					<?php	
					}
					else{
						?>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
						<?php echo $sendmessage ?>
					</div>
					<?php
					}
					?>

					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<span class="glyphicon glyphicon-time round e3-border"></span>Shelter Agent since: <?php echo $tool->since($registration_timestamp)?>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<hr/>
						<div class="row">
							<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6" ><span class="glyphicon glyphicon-briefcase"></span><sup>+</sup>Following: <?php echo count($agent->followings()) ?> </span>
							<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6" ><span class="glyphicon glyphicon-send"></span>Total Uploads: <?php  echo count($agent->uploads()) ?> </span>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		<div class="contain remove-side-margin-xs">
			<div class="head red-background white">
				<h4 class="text-left">Reviews</h4>
				<p class="text-left" style="color:#e3e3e3">What people say about <?php echo (me() ? "your business" : $agent->business_name) ?></p>
			</div>
			<div class="body white-background">
				Reviews will appear here
			</div>
		</div>
		<?php
		if(!me()){
		?>
		<div class="white-background padding-5 e3-border border-radius-3">
			<p><?php echo ($status == 1 ? '<strong>'.$loggedIn_agent->business_name.'</strong>, ' : ($status == 9 ? '<strong>'.$loggedIn_client->name.'</strong> ,' : '')) ?> Do you know anything about <?php echo $agent->business_name?> that you'll like to share with others?, feel free to write a review</p>
			<a class="btn btn-default site-color-background white text-right">
				<span class="glyphicon glyphicon-pencil"></span> Write a review
			</a>
		</div>
		<?php
		}
		?>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="contain remove-side-margin-xs">
			<div class="head site-color">
				<h4 class="text-left">Properties By <?php echo $business_name ?></h4>
			</div>
			<div class="body remove-side-padding-xs remove-side-boreder-xs remove-side-boreder-sm remove-side-boreder-md">
				<div class="row e3-background">
					<?php
					$from = (isset($_GET['next']) ? $_GET['next'] : 0);
					$to = $from + 6;
					$uploads = $agent->recent_uploads($from,$to);
					if(count($uploads) == 0){
						?>
						<div class="text-center">
						<?php
						if(me()){
							?>
							<div class="operation-report-container fail">
							<p>You have not uploaded any property yet</p><br/>
							<a href="../upload" class="btn btn-lg opac-3-site-color-background site-color">upload a property now</a>
							</div>
							<?php
						}
						else{
							?>
							<div class="operation-report-container fail">
							<p><?php echo $agent->business_name ?> have not uploaded any property yet</p><br/>
							</div>			
							<?php
						}
						?>
						</div>
						<?php
					}else{
						$upload_count = 0;
						while($upload_count < count($uploads)){
							$property = new property($uploads[$upload_count]);
								require('../../resources/global/property_display.php');
								$upload_count++;
						}
					}
					?>	
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="contain remove-side-margin-xs">
			<?php 
			$client_followers = $agent->client_followers();
			$total_client_followers = count($client_followers);
			?>
				<div class="head f7-background">
					<h4 class="text-left">Client Followers (<?php echo $total_client_followers ?>)</h4>
				</div>
				<div class="body white-background">
				<?php
				if($total_client_followers == 0){
					?>
					<div class="f7-background padding-10 e3-border text-center">No client follower</div>
					<?php
				}
				else{
				for($c=0;$c<$total_client_followers;$c++){
					$client_follower = new client($client_followers[$c]);
					?>
					<div class="margin-5-0 e3-border-bottom">
						<div class="row">
							<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p class="font-16">
									<span class="glyphicon glyphicon-user round site-color-border"></span>
									<?php echo $tool->substring($client_follower->name,'abc',16) ?>
								</p>
							</span>
							<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<?php 
								$client_request = new cta_request($client_followers[$c]);
								if($status == 1){
									echo $client_request->suggest_property_button($loggedIn_agent->id,$loggedIn_agent->business_name,$loggedIn_agent->username,$loggedIn_agent->token);
								}
								else{
									echo $client_request->suggest_property_button(null,null,null,null);
								}
								?>
							</span>
						</div>
						<div class="grey f7-background border-radius-3 e3-border margin-5 padding-5">
							<?php
							if($client_request->type == "" && $client_request->maxprice == 0 && $client_request->location == "" ){
								?>
								<p class="grey font-12 text-center"><span class="glyphicon glyphicon-question-sign site-color font-20 text-center"></span>No Request Yet</p>
								<?php
							}else{
							?>
								<div class="row">
									<span class="col-lg-4 col-md-4 col-sm-4 col-xs-6"><span class="glyphicon glyphicon-question-sign site-color font-20"></span><?php echo $client_request->type ?></span>
									<span class="col-lg-4 col-md-4 col-sm-4 col-xs-6"><?php echo 'N '.number_format($client_request->maxprice) ?></span>
									<span class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><?php echo $tool->substring($client_request->location,'abcxyz',10) ?></span>
								</div>
							<?php
							}
							?>
						</div>
					
					</div>
					<?php
				unset($client_follower);
				unset($client_request);
				}
				}
				?>
				</div>
				</div>
			</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	<div class="contain remove-side-margin-xs">
		<?php 
		$agent_followers = $agent->agent_followers();
		$total_agent_followers = count($agent_followers);
		?>
		<div class="head f7-background">
			<h4 class="text-left">Agent Followers (<?php echo $total_agent_followers ?>) </h4>
		</div>
		<div class="body white-background">
			<?php
			if($total_agent_followers == 0){
				?>
					<div class="f7-background padding-10 e3-border text-center">No agent follower</div>
				<?php
			}
			else{
				for($a=0;$a<$total_agent_followers;$a++){
					$agent_follower = new agent($agent_followers[$a]['agent_follower_id']);
						?>
						<div class="margin-5-0 e3-border-bottom">
							<div class="row">
								<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<p><span class="glyphicon glyphicon-briefcase round red-border"></span> <a href="<?php echo '../'.$agent_follower->username ?>" > <?php echo $tool->substring($agent_follower->business_name,'abc',16) ?></a></p>
								</span>
								<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
									<?php 
									if($status==1){
										echo $agent_follower->follow_button($loggedIn_agent->id,$loggedIn_agent->business_name,$loggedIn_agent->username,'A4A');
									}
									else if($status==9){
										echo $agent_follower->follow_button($loggedIn_client->id,$loggedIn_client->name,null,$af['ID'],'C4A');
									}
									else{
										echo $agent_follower->follow_button(null,null,null,null);
									}
									 ?>
								</span>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<p><span class="glyphicon glyphicon-upload"></span>  <?php echo count($agent_follower->uploads()) ?> properties</p>
								<p><span class="glyphicon glyphicon-map-marker"></span><?php echo $agent_follower->office_address ?> </p>
								</div>
							</div>
						</div>
						<?php
						unset($agent_follower);
				}
			}
			?>
		</div>
	</div>
	</div>
	</div>

<div class="row">
<?php
if($status ==1 && $business_name != $loggedIn_agent->business_name || $status !=1){
	//links for visitors,client and other agents aside this one
	?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
<a href="../signup" class="btn btn-lg btn-danger margin-5"><span class="white-icon flag-icon"></span>Report this agent</a>
</div>	
<?php
}
if($status!=1){
	//links for non agent  -  either visitor or client
	?>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
	<a  href="../signup" class="btn btn-lg btn-primary  margin-5">create your own account</a>
	</div>
	<?php
}
if($status == 1 && $business_name == $loggedIn_agent->business_name){
	//link for the owner
	?>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-5">
<a href="../logout" class="btn btn-danger  margin-5">Logout</a></div>
	<?php
}
?>
</div>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="contain remove-side-margin-xs">
	<div class="head f7-background">
		<p class="text-left">Agents around <?php echo $agent->business_name ?></p>
	</div>
	<div class="body white-background">
	<?php
	$agents_in_the_same_location = $agent->neighborhood_agents(6);
	if(count($agents_in_the_same_location) == 0){
		?>
		<div class="padding-10 text-center">
			<p>No agent is found around <?php echo $agent->business_name ?></p>
		</div>
		<?php
	}
	else{
		for($NA = 0; $NA < count($agents_in_the_same_location); $NA++){
			$n_agent = new agent($agents_in_the_same_location[$NA])
		?>
			<div class="margin-5-0 e3-border-bottom">
							<div class="row">
								<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<p><span class="glyphicon glyphicon-briefcase round red-border"></span> <a href="<?php echo '../'.$n_agent->username ?>" > <?php echo $tool->substring($n_agent->business_name,'abc',16) ?></a></p>
								</span>
								<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
									<?php 
									if($status==1){
										echo $n_agent->follow_button($loggedIn_agent->id,$loggedIn_agent->business_name,$loggedIn_agent->username,'A4A');
									}
									else if($status==9){
										echo $n_agent->follow_button($loggedIn_client->id,$loggedIn_client->name,null,'C4A');
									}
									else{
										echo $n_agent->follow_button(null,null,null,null);
									}
									 ?>
								</span>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<p><span class="glyphicon glyphicon-upload"></span>  <?php echo count($n_agent->uploads()) ?> properies</p>
								<p><span class="glyphicon glyphicon-map-marker"></span><?php echo $n_agent->address ?></p> 
								</div>
							</div>
						</div>
		<?php
		unset($n_agent);
		}
	}
	?>
	</div>
</div>

<div class="contain remove-side-margin-xs">
	<div class="head f7-background">
		<p class="text-left">You might also check properties from...</p>
	</div>
	<div class="body white-background">
	<?php
	$other_agents = $agent->other_agents(6);
	if(count($other_agents) == 0){
		?>
		<div class="padding-10 text-center">
			<p>Could not find other agents</p>
		</div>
		<?php
	}
	else{
			?>
		<div class="scrollable-x">
			<div class="scrollable-x-inner" style="width:<?php echo (270 * count($other_agents)) ?>">
			<?php
		for($OA = 0; $OA < count($other_agents); $OA++){
			$o_agent = new agent($other_agents[$OA])
		?>
			<div class="contain float-left" style="width:250px;">
				<div class="head f7-background">
					<h4><span class="glyphicon glyphicon-briefcase round red-border"></span> <a href="<?php echo '../'.$o_agent->username ?>"  class="site-color"> <?php echo $tool->substring($o_agent->business_name,'abc',16) ?></a></h4>
				</div>
				<div class="body white-background text-center">
					<p><span class="glyphicon glyphicon-upload"></span>  <strong><?php echo count($o_agent->uploads()) ?> properties</strong></p>
					<p><span class="glyphicon glyphicon-map-marker"></span>  <?php echo $tool->substring($o_agent->address,'abcxyz',20) ?></p>
					<?php 
									if($status==1){
										echo $o_agent->follow_button($loggedIn_agent->id,$loggedIn_agent->business_name,$loggedIn_agent->username,'A4A');
									}
									else if($status==9){
										echo $o_agent->follow_button($loggedIn_client->id,$loggedIn_client->name,null,'C4A');
									}
									else{
										echo $o_agent->follow_button(null,null,null,null);
									}
									 ?>
				</div>
			</div>
		<?php
		unset($o_agent);
		}
		?>
			</div>
		</div>
		<?php
	}
	?>
		<div class="text-center">
				<a href="../" class="btn btn-primary btn-lg"> see more agents </a>
		</div>
	</div>
</div>

</div>
</div>

<?php require('../../resources/global/footer.php'); ?>

</div>
</div><!--body-content-->

</div><!--grand-parent row-->
</div><!--container-fluid-->
</body>
</html>
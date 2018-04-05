
<div class="<?php echo $sidebarClass ?> sidebar" >

<div class="sidebar-container">

<?php

//sidebar for agents
if($status == 1){
?>

<div class="sidebar-header">
 	<h4 class="uppercase site-color">
		<span class="glyphicon glyphicon-briefcase round e3-border"></span>  Agent
	</h4>
	<p class="text-center grey">
	<?php echo  $loggedIn_agent->business_name ?><br/>
	(@<?php echo  $loggedIn_agent->username ?>)</p>
</div>
<div class="animate rubberBand padding-10">
	<a href="<?php echo "$root/upload" ?>" id="upload-button" class="btn btn-block btn-primary red-background white bold">
		<span class="glyphicon glyphicon-send"></span>  Upload property
	</a>
</div>

<div class="sidebar-links-container">
	<ul>
		<a href="<?php echo "$root/messages" ?>">
			<li>
				<span class="glyphicon glyphicon-envelope"></span>  Messages 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="messages"><?php echo count($loggedIn_agent->messages()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/agents" ?>">
			<li>
				<span class="glyphicon glyphicon-briefcase"></span>  Following agents 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="followings"><?php echo count($loggedIn_agent->followings()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/clients" ?>">
			<li >
				<span class="glyphicon glyphicon-user"></span>  Follower[client] 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="client-followers"><?php echo count($loggedIn_agent->client_followers()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/agents" ?>">
			<li>
				<span class="glyphicon glyphicon-briefcase"></span>  Follower[agent] 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="agent-followers"><?php echo count($loggedIn_agent->client_followers()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/clients" ?>">
			<li><span class="glyphicon glyphicon-share-alt"></span>  Suggest property</li>
		</a>
		<a href="<?php echo "$root/manage/account.php" ?>">
			<li><span class="glyphicon glyphicon-edit"></span>  Edit profile</li>
		</a>
		<a href="<?php echo "$root/manage" ?>">
			<li><span class="glyphicon glyphicon-cog"></span>  Manage Property</li>
		</a>
		<a href="<?php echo "$root/logout" ?>"  id="logout">
			<li><span class="glyphicon glyphicon-log-out"></span>  Logout</li>
		</a>
	</ul>
</div>
<?php
}

//sidebar for client
else if($status == 9){
?>


<div class="sidebar-header">
 	<h4 class="uppercase">
		<span class="glyphicon glyphicon-user client-avatar round e3-border"></span>  <?php echo $loggedIn_client->name ?>
	</h4>
</div>

<div class=" white-background site-color padding-5 margin-5-0 e3-border border-radius-5 text-center">
	<h4>CTA Expiry Time</h4>
	<p>
		<span class="glyphicon glyphicon-calendar"></span><?php echo $loggedIn_client->expiry_date ?>
	</p>
	
	<noscript>
		<p>Remaining <?php //echo ($days_before_expiry < 1 ? "<span class=\"red;\" >$hours_before_expiry hours</span>" :"<span id=\"side-bar-countdown\"> $days_before_expiry days</span>") ?></p>
	</noscript>

	<div id="side-bar-countdown-container">
		<span class="time-figures-countdown-container" id="day-countdown">--</span>
		<span class="time-figures-countdown-container" id="hr-countdown">--</span>
		<span class="time-figures-countdown-container" id="min-countdown">--</span>
		<span class="time-figures-countdown-container" id="sec-countdown">--</span>
	</div>

	<a href="" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-repeat"></span>  Renew</a>
	<a href="" class="btn btn-block btn-danger"><span class="glyphicon glyphicon-trash"></span>  Deactivate this CTA</a>
</div>
	
	
<script>
 timecountdown('side-bar-countdown-container',<?php echo $loggedIn_client->seconds_before_expiry ?>);
</script>

<div class="sidebar-links-container">
	<ul>
		<a href="<?php echo "$root/messages" ?>">
			<li>
				<span class="glyphicon glyphicon-envelope"></span>  Messages 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="messages"><?php echo count($loggedIn_client->messages()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/cta/?src=matches" ?>" >
			<li>
				<span class="glyphicon glyphicon-link"></span>  Matches 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="matches"><?php echo count($loggedIn_client->matches()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/cta/?src=clipped" ?>" >
			<li>
				<span class="glyphicon glyphicon-paperclip"></span> Clipped 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="clips"><?php echo count($loggedIn_client->clips())?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/agents" ?>" >
			<li>
				<span class="glyphicon glyphicon-briefcase"></span>  Following Agents 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="followings"><?php echo count($loggedIn_client->followings()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/cta/?src=suggestions" ?>" >
			<li>
				<span class="glyphicon glyphicon-briefcase"></span>  Suggestions 
				<div class="float-right">
					<span class="backgrounded-figure red-background">
						<span data-counter="suggestions"><?php echo count($loggedIn_client->suggestions()) ?></span>
					</span>
				</div>
			</li>
		</a>
		<a href="<?php echo "$root/cta/request.php" ?>" >
			<li><span class="glyphicon glyphicon-edit"></span>  Adjust request</li>
		</a>
		<a href="" >
			<li><span class="glyphicon glyphicon-pencil"></span>  Edit CTA details</li>
		</a>
		<a href="<?php echo "$root/logout" ?>"  id="logout">
			<li><span class="glyphicon glyphicon-log-out"></span> Check out</li>
		</a>		
	</ul>
</div>

<div class="sidebar-links-container">
	<ul>
		<a href="<?php echo "$root/login" ?>" >
			<li><span class="glyphicon glyphicon-briefcase"></span>  Login as agent</li>
		</a>
		<a href="<?php echo "$root/signup" ?>" >
			<li><span class="glyphicon glyphicon-folder-open"></span>  Sign up as agent</li>
		</a>
	</ul>
</div>

<?php
}
else{
?>
<div class="sidebar-header">
	<h4 class="site-color">
		<span class="glyphicon glyphicon-briefcase agent-avatar"></span>  AGENT
	</h4>
</div>
<div class="sidebar-links-container">
	<ul>
		<a href="<?php echo "$root/login" ?>" >
			<li><span class="glyphicon glyphicon-log-in"></span> Login</li>
		</a>
		<a href="<?php echo "$root/signup" ?>" >
			<li><span class="glyphicon glyphicon-folder-open"></span> Sign up</li>
		</a>
	</ul>
</div>

<div class="sidebar-header">
	<h4 class="uppercase site-color">
		<span class="glyphicon glyphicon-user client-avatar"></span>  CTA
	</h4>
</div>	

<div class="sidebar-links-container">
	<ul>
		<a href="<?php echo "$root/cta/checkin.php?a=checkin" ?>">
			 <li><span class="glyphicon glyphicon-log-in"></span>  Checkin my CTA</li>
		</a>
		<a href="<?php echo "$root/cta/checkin.php?a=create" ?>" >
			<li><span class="glyphicon glyphicon-folder-open"></span>  Create new CTA</li>
		</a>
		<a href="" >
			<li><span class="glyphicon glyphicon-question-sign"></span>  What is CTA?</li>
		</a>
		<a href="<?php echo "$root/cta" ?>" >
			<li><span class="glyphicon glyphicon-paperclip"></span>  My Clipped properties</li>
		</a>
		<a href="<?php "$root/cta" ?>">
			 <li><span class="glyphicon glyphicon-briefcase"></span>  My agents</li>
		</a>
	</ul>
</div>

<?php
}

?>

</div><!--sidebar-container-->
</div><!--sidebar-->


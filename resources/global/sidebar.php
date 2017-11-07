
<div class="col-lg-2 col-md-2 col-sm-3 sidebar-wrapper" id="sidebar-wrapper">
<div class="sidebar-wrapper-primary">

<?php
//classes general, agent and cta are in connexion.php

$hiddenTopMenu = "<div class=\"account-nav-container\" id=\"hiddenTopMenu\">
					<a href=\"$root\" class=\"account-nav-link text-center\"><span class=\"glyphicon glyphicon-home\"></span><br/>Home</a>
					<a href=\"$root/agents\" class=\"account-nav-link text-center\"><span class=\"glyphicon glyphicon-briefcase\"></span><br/>Agents</a>
					<a href=\"$root/clients\" class=\"account-nav-link text-center\"><span class=\"glyphicon glyphicon-user\"></span><br/>Clients</a>
					<a href=\"$root/search\" class=\"account-nav-link text-center\"><span class=\"glyphicon glyphicon-search\"></span><br/>Search</a>
						</div>";


//sidebar for agents
if($status == 1){
	$avatar = substr($Business_Name,0,1);
echo $hiddenTopMenu;
?>

<div class="account-nav-container text-center f7-background">
 	<h4 class="uppercase site-color">
	<span class="glyphicon glyphicon-briefcase agent-avatar"></span>
	<?php echo  $Business_Name ?>
	</h4>
	
<div class="white-background">
<a href="<?php echo "$root/upload" ?>" class="btn btn-block white deepblue-background font-20">Upload property <span class="glyphicon glyphicon-send"></span></a>
</div>
</div>



<div class="account-nav-container">
	<a href="<?php echo "$root/messages" ?>" class="account-nav-link"><span class="glyphicon glyphicon-envelope"></span> Messages <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $messages ?></span></div></a>
	<a href="<?php echo "$root/agents" ?>" class="account-nav-link"><span class="glyphicon glyphicon-briefcase"></span> Following agents <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $followings ?></span></div></a>
	<a href="<?php echo "$root/clients" ?>" class="account-nav-link"><span class="glyphicon glyphicon-user"></span> Follower[client] <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $client_followers ?></span></div></a>
	<a href="<?php echo "$root/agents" ?>" class="account-nav-link"><span class="glyphicon glyphicon-briefcase"></span> Follower[agent] <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $agent_followers ?></span></div></a>
	<a href="<?php echo "$root/clients" ?>" class="account-nav-link"><span class="glyphicon glyphicon-share-alt"></span> Suggest property</a>
	<a href="<?php echo "$root/manage/account.php" ?>" class="account-nav-link"><span class="glyphicon glyphicon-edit"></span> Edit profile</a>
	<a href="<?php echo "$root/manage" ?>" class="account-nav-link"><span class="glyphicon glyphicon-cog"></span> Manage Property</a>
	<a href="<?php echo "$root/logout" ?>" class="account-nav-link" id="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>

	</div>
<?php
}

//sidebar for client
else if($status == 9){
echo $hiddenTopMenu;

?>



	<div class="account-nav-container ">
	<div class="f7-background text-left padding-2">
 	<h4 class="uppercase">
	<span class="glyphicon glyphicon-user client-avatar"></span>
	<?php echo $cta_name ?>
	</h4>
</div>
<div class="text-center">
	<h4>CTA Expiry Time</h4>
	<p style="font-size:110%"><span class="glyphicon glyphicon-calendar"></span><?php echo $expiry_date ?></p>
	<noscript>
	<p>Remaining <?php echo ($days_before_expiry < 1 ? "<span style=\"color:red;\" >$hours_before_expiry hours</span>" :"<span id=\"side-bar-countdown\"> $days_before_expiry days</span>") ?></p>
	</noscript>

	<div id="side-bar-countdown-container">
	<span class="time-figures-countdown-container" id="day-countdown">--</span>
	<span class="time-figures-countdown-container" id="hr-countdown">--</span>
	<span class="time-figures-countdown-container" id="min-countdown">--</span>
	<span class="time-figures-countdown-container" id="sec-countdown">--</span>
	</div>

	<a href="" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-repeat"></span>Renew</a>
	<a href="" class="btn btn-block btn-danger"><span class="glyphicon glyphicon-trash"></span>Deactivate this CTA</a>
	</div>
	</div>
	<script>
 timecountdown('side-bar-countdown-container',<?php echo $seconds_before_expiry ?>);
</script>

	<div class="account-nav-container">
	<a href="<?php echo "$root/messages" ?>" class="account-nav-link" id="msgs"><span class="glyphicon glyphicon-envelope"></span> Messages <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $messages ?></span></div></a>
	<a href="<?php echo "$root/cta/?src=matches" ?>" class="account-nav-link"><span class="glyphicon glyphicon-link"></span> Matches <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $matches ?></span></div></a>
	<a href="<?php echo "$root/cta/?src=clipped" ?>" class="account-nav-link"><span class="glyphicon glyphicon-paperclip"></span> Clipped <div class="float-right"><span class="backgrounded-figure red-background"><span id="clip-counter"><?php echo $clipped ?></span></span></div></a>
	<a href="<?php echo "$root/agents" ?>" class="account-nav-link"><span class="glyphicon glyphicon-briefcase"></span> Following Agents <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $followings ?></span></div></a>
	<a href="<?php echo "$root/cta/?src=suggestions" ?>" class="account-nav-link"><span class="glyphicon glyphicon-briefcase"></span> Suggestions <div class="float-right"><span class="backgrounded-figure red-background"><?php echo $total_suggestions ?></span></div></a>
	<a href="<?php echo "$root/cta/request.php?p=$request_status" ?>" class="account-nav-link"><span class="glyphicon glyphicon-edit"></span> Adjust request</a>
	<a href="" class="account-nav-link"><span class="glyphicon glyphicon-pencil"></span> Edit CTA details</a>
	<a href="<?php echo "$root/logout" ?>" class="account-nav-link" id="logout"><span class="glyphicon glyphicon-log-out"></span> Check out</a>
	</div>

	<div class="account-nav-container">
	<a href="<?php echo "$root/login" ?>" class="account-nav-link"><span class="glyphicon glyphicon-briefcase"></span>Login as agent</a>
	<a href="<?php echo "$root/signup" ?>" class="account-nav-link"><span class="glyphicon glyphicon-folder-open"></span>Sign up as agent</a>
	</div>

<?php
	}
else{
	echo $hiddenTopMenu;
?>
	<div class="account-nav-container f7-background">
	
	<h4 class="uppercase site-color">
	<span class="glyphicon glyphicon-briefcase agent-avatar"></span> AGENT
	</h4>
	<div class="white-background">
		<a href="<?php echo "$root/login" ?>" class="account-nav-link"><span class="glyphicon glyphicon-log-in"></span> Login</a>
		<a href="<?php echo "$root/signup" ?>" class="account-nav-link"><span class="glyphicon glyphicon-folder-open"></span> Sign up</a>
</div>
	</div>


		<div class="account-nav-container f7-background">
		<h4 class="uppercase site-color">
	<span class="glyphicon glyphicon-user client-avatar"></span>CTA
	</h4>	
	<div class="white-background">
		<a href="<?php echo "$root/cta/checkin.php?a=checkin" ?>" class="account-nav-link"><span class="glyphicon glyphicon-log-in"></span> Checkin my CTA</a>
		<a href="<?php echo "$root/cta/checkin.php?a=create" ?>" class="account-nav-link"><span class="glyphicon glyphicon-folder-open"></span>Create new CTA</a>
		<a href="" class="account-nav-link"><span class="glyphicon glyphicon-question-sign"></span>What is CTA?</a>
		<a href="<?php echo "$root/cta" ?>" class="account-nav-link"><span class="glyphicon glyphicon-paperclip"></span>My Clipped properties</a>
		<a href="<?php "$root/cta" ?>" class="account-nav-link"><span class="glyphicon glyphicon-briefcase"></span>My agents</a>
		</div>
		</div>

<?php
}

?>

<a href="<?php echo $root."/categories" ?>"><span align="center" id="categories"><i class="black-icon" id="category-icon"></i>Categories</span>
<div id="category-container">
<div class = "btn-dropdown" id="all-btn-dropdown" onclick="toggleall()">Expand all <i id="all-arrow" class="arrow-down" title="Expand all"></i></div>
<div id="flats" class = "btn-dropdown" style="font: Arial" onclick="toggleSidebar('flats','flat-dropdown','flat-arrow')">Flats<i title="Expand" id="flat-arrow" class="arrow-down"></i></div>
<div id="flat-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">4 Bedroom</a>
<a href="#" class="dropdown-menu">3 Bedroom</a>
<a href="#" class = "dropdown-menu">2 Bedroom</a>
</div>
</div>


<div id="sc" class = "btn-dropdown" onclick="toggleSidebar('sc','sc-dropdown','sc-arrow')" >Self Contain<i title="Expand" id="sc-arrow" class="arrow-down"></i></div>
<div  id="sc-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">3 Rooms</a>
<a href="#" class="dropdown-menu">2 Rooms</a>
</div>
</div>


<div id="wings" class = "btn-dropdown" onclick="toggleSidebar('wings','wings-dropdown','wings-arrow')" >Wings<i title="Expand" id="wings-arrow" class="arrow-down"></i></div>
<div  id="wings-dropdown"class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">3 Rooms</a>
<a href="#" class="dropdown-menu">2 Rooms</a>
</div></div>


<div id="others" class = "btn-dropdown" onclick="toggleSidebar('others','others-dropdown','others-arrow')" >Others<i  title="Expand"id="others-arrow" class="arrow-down"></i></div>
<div  id="others-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">Single Room</a>
<a href="#" class="dropdown-menu">Room & Parlour</li></a>
</div>
</div>


<div id="sale" class = "btn-dropdown" onclick="toggleSidebar('sale','sale-dropdown','sale-arrow')" >FOR SALE<i title="Expand" id="sale-arrow" class="arrow-down"></i></div>
<div  id="sale-dropdown" class="dropdowns">
<div  class="category-dropdown-content">
<a href="#" class="dropdown-menu">House</a>
<a href="#" class="dropdown-menu">Land</a>
</div>
</div>
</div>

</div>
</div>
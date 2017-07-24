<?php
//classes general, agent and cta are in connexion.php

$hiddenTopMenu = "<div class=\"account-nav-container\" id=\"hiddenTopMenu\">
					<a href=\"$root\" class=\"account-nav-link\">Home</a>
					<a href=\"$root/agents\" class=\"account-nav-link\">Agents</a>
					<a href=\"$root/search\" class=\"account-nav-link\">Search</a>
						</div>";


//sidebar for agents
if($status == 1){
	$avatar = substr($Business_Name,0,1);
$sidebar_content = "$hiddenTopMenu
<div class=\"account-nav-container\">
	<div style=\"padding:5px;\">
<h1 style=\"display:inline-block;border-radius:50%;text-align:center;padding:5% 10% 5% 10%;background-color:yellow;color:purple\">$avatar</h1>
	<h4 style=\"display:inline-block;width:65%; height:\" class=\"username\">$Business_Name</h4>
</div>
	<a href=\"$root/upload\"><div id=\"upload-btn\"><i class=\"white-icon upload-icon\"></i>Upload property</div></a>
	<a href=\"$root/messages\" class=\"account-nav-link\">($messages) Messages</a>
	<a href=\"\" class=\"account-nav-link\">($followings) Following agents</a>
	<a href=\"\" class=\"account-nav-link\">($client_followers) Follower[client]</a>
	<a href=\"\" class=\"account-nav-link\">($agent_followers) Follower[agent]</a>
	<a href=\"$root/manage/account.php\" class=\"account-nav-link\">Edit profile</a>
	<a href=\"$root/manage\" class=\"account-nav-link\">Manage Property</a>
	</div>
";
}

//sidebar for client
else if($status == 9){

$avatar = substr($cta_name,0,1);

$sidebar_content = "$hiddenTopMenu
<div style=\"padding:5px;\">
<h1 style=\"display:inline-block;border-radius:50%;text-align:center;padding:5% 10% 5% 10%;background-color:yellow;color:purple\">$avatar</h1>
	<h4 style=\"display:inline-block;width:65%; height:\" class=\"username\">$cta_name</h4>
</div>
	<div class=\"account-nav-container\">
	<div id=\"cta-status-container\">
	<h4>CTA Expiry Time</h4>
	<p style=\"font-size:120%\">$ExpiryDate</p>
	<noscript>
	<p>Remaining ".($days_before_expiry < 1 ? "<span style=\"color:red;\" >$hours_before_expiry hours</span>" :"<span id=\"side-bar-countdown\"> $days_before_expiry days</span>")."</p>
	</noscript>
	<div id=\"side-bar-countdown-container\">
	<span class=\"time-figures-countdown-container\" id=\"day-countdown\">--</span>
	<span class=\"time-figures-countdown-container\" id=\"hr-countdown\">--</span>
	<span class=\"time-figures-countdown-container\" id=\"min-countdown\">--</span>
	<span class=\"time-figures-countdown-container\" id=\"sec-countdown\">--</span>
	</div>
	<a href=\"\" class=\"cta-status-link\"><span class=\"white-icon recycle-icon\"></span>Renew</a>
	<a href=\"\" class=\"cta-status-link\">Deactivate this CTA</a>
	</div>
	</div>
	<script>
 timecountdown('side-bar-countdown-container',$seconds_before_expiry);
</script>

	<div class=\"account-nav-container\">
	<a href=\"$root/messages\" class=\"account-nav-link\" id=\"msgs\">($messages) Messages</a>
	<a href=\"$root/cta/?src=matches\" class=\"account-nav-link\">($matches) Matches</a>
	<a href=\"$root/cta/?src=clipped\" class=\"account-nav-link\" id=\"clipstring\">($clipped) Clipped properties</a>
	<a href=\"\" class=\"account-nav-link\">($followings) Following Agents</a>
	<a href=\"\" class=\"account-nav-link\">(0) Agents Suggestions</a>
	<a href=\"$root/cta/request.php?p=$request_status\" class=\"account-nav-link\">Adjust request</a>
	<a href=\"\" class=\"account-nav-link\">Change CTA details</a>
	<a href=\"$root/logout\" class=\"account-nav-link\">Check out</a>
	</div>";
	}
else{
	$sidebar_content = "$hiddenTopMenu
	<div class=\"account-nav-container\">
	<h4 align=\"center\" class=\"sidebar-headings\">Agents</h4>
		<a href=\"$root/login\" class=\"account-nav-link\">Login</a>
		<a href=\"$root/signup\" class=\"account-nav-link\">Sign up</a>
		</div>
		<div class=\"account-nav-container\">
	<h4 align=\"center\" class=\"sidebar-headings\">Client Temporary Account (CTA)</h4>
		<a href=\"$root/cta/checkin.php?_rdr=0\" class=\"account-nav-link\">Checkin my CTA</a>
		<a href=\"$root/cta/checkin.php?_rdr=0\" class=\"account-nav-link\">Create new CTA</a>
		<a href=\"\" class=\"account-nav-link\">What is CTA?</a>
		<a href=\"$root/cta/checkin.php?_rdr=1\" class=\"account-nav-link\">My Clipped properties</a>
		<a href=\"$root/cta/checkin.php?_rdr=1\" class=\"account-nav-link\">My agents</a>
		</div>
	";
}

?>


<div id="sidebar-wrapper">
<div id="sidebar-original">
<div id="sidebar-inner">
<!--user navigation sidebar begins here-->
<?php
echo $sidebar_content;
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
<?php
switch($status){
	case 1:
	echo "<div class=\"account-nav-cotainer\">
	<a href=\"$root/logout\" class=\"account-nav-link\">Logout</a>
	<hr/>
	</div>";
	break;
	case 9:
	echo "<hr/>
	<div class=\"account-nav-container\">
	<a href=\"$root/login\" class=\"account-nav-link bottom-nav-cotainer\">Login as agent</a>
	<a href=\"$root/signup\" class=\"account-nav-link\">Sign up as agent</a>
	<hr/>
	</div>";
	break;
}
?>
</div>
</div>
</div>

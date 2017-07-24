

<?php 
//get agent details if logged in
if($agent->check_status()=='active'){
	$status = 1;

	$agent_details = $agent->get_agentProfile();

	$profile_name = $agent_details['User_ID'];
	$Business_Name = $agent_details['Business_Name'];
	$agent_token = $agent_details['token'];

	$messages = $agent_details['messages'];
	$notifications = $agent_details['notifications'];
	$followings = $agent_details['followings'];
	$client_followers = $agent_details['c_followers'];
	$agent_followers = $agent_details['a_followers'];

}

//get Client details
else if($client->check_status()=='active'){
	$status = 9;
	$cta_details = $client->get_ctaProfile();

$cta_name = $cta_details['ctaname'];
$expiry_date = date('D, d M Y ',$cta_details['expiryTime']);
$seconds_before_expiry = $cta_details['seconds_left'];
$hours_before_expiry = round($seconds_before_expiry/3600);
$days_before_expiry = round($seconds_before_expiry/86400);

$request_status = $cta_details['request'];
$messages = $cta_details['messages'];
$notifications = $cta_details['notifications'];
$followings = $cta_details['followings'];
$matches = count($client_obj->get_matches());
$clipped = count($client_obj->get_clipped());
}
else{
	$status = 0;
}
?>

<script type="text/javascript" language="javascript" src="<?php echo $root.'/js/jquery-3.1.1.min.js' ?>"></script>
<script  type="text/javascript" language="javascript" src="<?php echo $root.'/js/masterjs.js' ?>"></script>


<title>Shelter | <?php echo $pagetitle; ?></title>

<div id="all-header-container">
<div id="top-nav-bar-container">
<div class="top-nav-bar" id="top-nav-bar-content">
<span id="top"></span>
<span id="basic-head">
<a href="#" id="menuicon" onclick="javascript:togglemenu()">
<span class="menu-lines"></span>
<span class="menu-lines"></span>
<span class="menu-lines"></span>
</a>
<span id="templogo"><a href="<?php echo $root ?>"><h1 style="display:inline; color:white;">Shelter</h1><h6 style="display:inline; color:white;" >.com</h6></a></span>
</span>
<div id="menus">
<ul id="nav-bar">
<a  href="<?php echo $root ?>" title="Home"><li class="nav-menu">Home</li></a>
	
<?php
//if user is logged, include this menu on the nav-bar
if($status==1){
	echo "<a href=\"$root/$profile_name\" title=\"$profile_name\"> <li class=\"nav-menu\">Account</li></a>";
}
?>

<a href="<?php echo $root."/agents"; ?>" title="Agents"><li class="nav-menu" >Agents</li></a>
<a href="#" title="Contacts"><li class="nav-menu" >Contacts</li></a>
<a href="#" title="About"><li class="nav-menu" >FAQs</li></a>

</ul>
</div>

<div id="agent-search">
<input style="width:100%;height:30px;margin-top:5px;padding-left:5px" type="search" onkeyup="getAgents(this.value,'agents-snipet-search-input-desktop','suggested-agents-search-container-desktop','suggested-agents-search-list-desktop')" class="search-input-field" id="agents-snipet-search-input-desktop" type="text" placeholder="search for agent" maxlength="50"/>
<!--<button class="search-btn">Go</button>-->

<div style="margin-top:5px" class="suggested-agents-search-container suggestion-box" id="suggested-agents-search-container-desktop">
<div class="suggested-agents-search-list" id="suggested-agents-search-list-desktop" style="padding:0px; ">
</div>
</div>

</div>
<span id="header-notice-wrapper">
<?php
if($status==1 || $status==9){
	echo "<span id=\"notification\">$notifications<a  title=\"notifications\" href=\"$root/notifications\"><span class=\"black-icon bell-icon\"></span></a></span>";
}
 ?>
<span title="refresh page" id="refresh" class="white-icon refresh-icon" onclick="javascript:location.reload()" ></span>
</span>

<!--<button id="rhs-top-search-btn" style=""> Search </button>-->
</div>
</div>
<div class="top-nav-bar" id="top-nav-bar-under" ></div>

</div>

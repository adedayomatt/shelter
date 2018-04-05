
<nav class="site-color-background">
<div class="row top-header">

<div class="opac-8-site-color-background">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<a href="<?php echo $root ?>"><h2 style="display:inline; color:white;">Shelter</h2><h6 style="display:inline; color:white;" >.com</h6></a>
</div>
</div>
</div>

</div>


<div id="header-wrapper">
<span id="top"></span><!--Just an anchor-->

<div class="row" id="header-menus-holder">
<a class="hidden-lg hidden-md hidden-sm visible-xs col-xs-1 text-center" id="menuicon" onclick="javascript:togglemenu()">
<span class="menu-lines"></span>
<span class="menu-lines"></span>
<span class="menu-lines"></span>
</a>


<div class="col-lg-6 col-md-6 col-sm-6 hidden-xs text-center menus">
<ul>
<a  href="<?php echo $root ?>" title="Home"><li>Home</li></a>	
<?php
//if user is logged, include this menu on the nav-bar
if($status==1){
	echo "<a href=\"$root/agents/".$loggedIn_agent->username."\" title=\"".$loggedIn_agent->username."\"> <li>Account</li></a>";
}
?>

<a href="<?php echo $root."/agents"; ?>" title="Agents"><li >Agents</li></a>
<a href="<?php echo $root."/clients"; ?>" title="Clients"><li>Clients</li></a>
<a href="#" title="Contacts"><li>Contacts</li></a>
<a href="#" title="About"><li>FAQs</li></a>
</ul>
</div>

<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs agent-search">
<div class="agent-search-container">
<input class="site-color form-control agent-search" style="" type="search" type="text" placeholder="search for agent" maxlength="50"/>
<div style="display:none;" class="white-background result-container"></div>
</div>
</div>

<!--This is the header in mobile-->
<div class="hidden-lg hidden-md hidden-sm visible-xs col-xs-8 mobile-header" style="margin-top:5px;padding:0px">
<div class="row site-color-background" >

<div class="col-sm-3 col-xs-3 text-center" >
<a href="<?php echo $root ?>" class="white" ><span class="glyphicon glyphicon-home round white-background site-color"></span></a>
</div>

<div class="col-sm-3 col-xs-3 text-center">
<a href="<?php echo "$root/agents" ?>" class="white"><span class="glyphicon glyphicon-briefcase round white-background site-color"></span></a>
</div>

<div class="col-sm-3 col-xs-3 text-center">
<a href="<?php echo "$root/clients" ?>" class="white" ><span class="glyphicon glyphicon-user round white-background site-color"></span></a>
</div>

<div class="col-sm-3 col-xs-3 text-center" id="mobile-header-search">
<a  class="white" ><span class="glyphicon glyphicon-search round white-background site-color"></span></a>
</div>

</div>
<div id="extra-container" style="display:none"></div>
</div>
<!--mobile header ends here-->



<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2  header-notice">
<?php
if($status==1 || $status==9){
	if($status==1){
	$notifications = count($loggedIn_agent->unseen_notifications());
	}
	else if($status == 9){
	$notifications = count($loggedIn_client->unseen_notifications());
	}
	?>
	<span style="background-color:rgba(0,0,0,0.5)" class="padding-5 white border-radius-5"><a  title="notifications" href="<?php echo "$root/notifications" ?>" class="white bold"><span class="glyphicon glyphicon-bell icon-size-15 white"></span>
	<span>   <?php echo ($notifications > 0 ? "<span data-counter=\"notifications\" class=\"animate bounce\">$notifications</span>" : $notifications)  ?></span>
	</a>
	</span>
<?php
}
 ?>
<!--<span title="refresh page" class="glyphicon glyphicon-refresh icon-size-15 white" onclick="javascript:location.reload()" style="float:right"></span>-->
</div>
</div>
<?php
if($status==1 || $status==9){
	?>
<div id="notifications-parent" style="display:none;width:100%; height:100vh; position:fixed;z-index:1000">
<div id="notifications-container" class="white-background" style="float:right;width:300px; height:auto; box-shadow:0px 5px 5px rgba(0,0,0,0.5); border-radius:5px; margin-right:5px;">
<div id="notifications-head"class="f7-background text-center padding-10 font-18" style="border-bottom:1px solid #e3e3e3;"><span class="glyphicon glyphicon-bell"></span>Notifications<span class="close font-20" onclick="fader(document.querySelector('#notifications-parent'),'fadeOut','normal')">&times </span></div>
<div id="notifications-body" style="min-height:100px; max-height: 500px; overflow:auto; padding:5px 3px"></div>
</div>
</div>
<?php

	}
?>

</div>



<!--Dashboard start here-->


<div id="dashboard" >

<div class="dashboard-container">
<div class="row">

<?php

//dashboard for agents
if($status == 1){
?>
<div class="row">
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
		<div class="row">
		
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-header">
					<span class="grey">
							<span class="dropdown text-center">
								<a href="" class="site-color dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<span class="text-center"><span class="glyphicon glyphicon-briefcase round e3-border"></span>  <?php echo  $tool->substring($loggedIn_agent->business_name,'abc',10) ?></span>  <span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<a href="<?php echo "$root/manage/#account" ?>">
										<li class="padding-0-5"><span class="glyphicon glyphicon-edit"></span>  Edit profile</li>
									</a>
									<li role="separator" class="divider"></li>
									<a href="<?php echo "$root/logout" ?>"  id="logout">
										<li class="padding-0-5"><span class="glyphicon glyphicon-log-out"></span>  Logout</li>
									</a>
								</ul>
							</span>
						</span>
					
					<p class="text-center">(@<?php echo  $loggedIn_agent->username ?>)</p>
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
				<a href="<?php echo "$root/messages" ?>">
					<span class="glyphicon glyphicon-envelope"></span>  Messages 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="messages"><?php echo count($loggedIn_agent->messages()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>
				
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/agents" ?>">
						<span class="glyphicon glyphicon-briefcase"></span>  Following agents 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="followings"><?php echo count($loggedIn_agent->followings()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>
				
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/clients" ?>">
						<span class="glyphicon glyphicon-user"></span>  Follower[client] 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="client-followers"><?php echo count($loggedIn_agent->client_followers()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/agents" ?>">
						<span class="glyphicon glyphicon-briefcase"></span>  Follower[agent] 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="agent-followers"><?php echo count($loggedIn_agent->client_followers()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/clients" ?>">
						<span class="glyphicon glyphicon-share-alt"></span>  Suggest property
					</a>
				</div>
			</div>


			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/manage" ?>">
						<span class="glyphicon glyphicon-cog"></span>  Manage Property
					</a>
				</div>
			</div>
			
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidden-xs">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="animate rubberBand padding-10">
					<a href="<?php echo "$root/upload" ?>" id="upload-button" class="btn btn-block btn-primary red-background white bold">
						<span class="glyphicon glyphicon-send"></span>  Upload property
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
//dashboard for client
else if($status == 9){
?>

<div class="row">
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
		<div class="row">
		
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-header">
					<span class="grey">
							<span class="dropdown text-center">
								<a href="" class="dropdown-toggle site-color" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<span class="text-center"><span class="glyphicon glyphicon-user round e3-border"></span>  <?php echo  $tool->substring($loggedIn_client->name,'abc',10) ?></span>  <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<a href="<?php echo "$root/cta" ?>"  id="logout">
										<li class="padding-0-5"><span class="glyphicon glyphicon-pencil"></span>  Update CTA details</li>
									</a>
									<li role="separator" class="divider"></li>
									<a href="<?php echo "$root/logout" ?>"  id="logout">
										<li class="padding-0-5"><span class="glyphicon glyphicon-log-out"></span>  checkout</li>
									</a>
								</ul>
							</span>
						</span>
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
				<a href="<?php echo "$root/messages" ?>">
					<span class="glyphicon glyphicon-envelope"></span>  Messages 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="messages"><?php echo count($loggedIn_client->messages()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>
				
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/cta/?src=matches" ?>">
						<span class="glyphicon glyphicon-link"></span>  Matches 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="matches"><?php echo count($loggedIn_client->matches()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>
				
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/cta/?src=clipped" ?>">
						<span class="glyphicon glyphicon-paperclip"></span> Clipped
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="clips"><?php echo count($loggedIn_client->clips())?></span>
							</span>
						</div>
					</a>
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/cta/?src=suggestions" ?>">
						<span class="glyphicon glyphicon-briefcase"></span>  Suggestions 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="suggestions"><?php echo count($loggedIn_client->suggestions()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/agents" ?>">
						<span class="glyphicon glyphicon-briefcase"></span>  Following Agents 
						<div class="float-right">
							<span class="backgrounded-figure red-background white bold">
								<span data-counter="followings"><?php echo count($loggedIn_client->followings()) ?></span>
							</span>
						</div>
					</a>
				</div>
			</div>

			
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="dashboard-link-container">
					<a href="<?php echo "$root/cta/request.php" ?>">
						<span class="glyphicon glyphicon-edit"></span>  Adjust request
					</a>
				</div>
			</div>

			
		</div>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="cta-countdown-container text-center">
					<p><span class="glyphicon glyphicon-calendar"></span>  CTA Expires: <?php echo $loggedIn_client->expiry_date ?></p>
					
					<noscript>
						<p>Remaining <?php //echo ($days_before_expiry < 1 ? "<span class=\"red;\" >$hours_before_expiry hours</span>" :"<span id=\"side-bar-countdown\"> $days_before_expiry days</span>") ?></p>
					</noscript>

					<span class="dropdown">
								<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<span id="side-bar-countdown-container">
										<span class="time-figures-countdown-container" id="day-countdown">--</span>
										<span class="time-figures-countdown-container" id="hr-countdown">--</span>
										<span class="time-figures-countdown-container" id="min-countdown">--</span>
										<span class="time-figures-countdown-container" id="sec-countdown">--</span>
									</span>
									<span class="caret"></span>
								</a>
								<script>
									timecountdown('side-bar-countdown-container',<?php echo $loggedIn_client->seconds_before_expiry ?>);
								</script>

								<ul class="dropdown-menu"s>
									<a href="<?php echo "$root/cta" ?>"  id="logout">
										<li class="padding-0-5"><span class="glyphicon glyphicon-repeat"></span>  Renew</li>
									</a>
									<li role="separator" class="divider"></li>
									<a href="<?php echo "$root/cta" ?>"  id="logout">
										<li class="padding-0-5"><span class="glyphicon glyphicon-trash red"></span>  Deactivate this CTA</li>
									</a>
								</ul>
							</span>
					</div>
			</div>
		</div>
	</div>
</div>


<?php
}
else{
?>
<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<div class="dashboard-link-container">
			<a href="<?php echo "$root/login" ?>" class="site-color">
				<span class="glyphicon glyphicon-log-in"></span>  Agent | Login
			</a>
		</div>
	</div>
	
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<div class="dashboard-link-container">
			<a href="<?php echo "$root/signup" ?>" class="site-color">
				<span class="glyphicon glyphicon-folder-open"></span>  Agent | Sign up
			</a>
		</div>
	</div>
	
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<div class="dashboard-link-container">
			<a href="<?php echo "$root/cta/checkin.php?a=checkin" ?>" class="red">
				<span class="glyphicon glyphicon-log-in"></span>  Client | Checkin
			</a>
		</div>
	</div>

	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
		<div class="dashboard-link-container">
			<a href="<?php echo "$root/cta/checkin.php?a=create" ?>" class="red">
				<span class="glyphicon glyphicon-folder-open"></span>  Client | Create CTA
			</a>
		</div>
	</div>
	
	
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="animate rubberBand padding-10">
					<a href="<?php echo "$root/upload" ?>" id="upload-button" class="btn btn-block btn-primary red-background white bold">
						<span class="glyphicon glyphicon-send"></span>  Upload property
					</a>
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php
}

?>
</div>
</div><!--dashboard-container-->
</div><!--dashboard-->


<?php 

if(isset($showStaticHeader) && $showStaticHeader==true){
	?>
<div class="f7-background static-head-onscroll" style="display:none;">
<?php
if(isset($staticHead) && $staticHead != ""){
	echo $staticHead;
}
?>
</div>
	<?php
}
 ?>


</nav>












		<script>
try{
window.onscroll = function(event){
	var scrollCheck = new windowScroll(window.pageYOffset);
	scrollCheck.onScrollUp(
	function(){
		show('.top-header');
		console.log("scrolling up..");
	}
	);
	scrollCheck.onScrollDown(
	function(){
		hide('.top-header');
		console.log("scrolling down..");
	}
	);
	var static_header = document.querySelector('.static-head-onscroll')
if(static_header != null){	
	var tempPopup = document.querySelector('.temporary-popup');
	if(window.pageYOffset >= 100 ){
		if(static_header.innerHTML != ""){//if the content is not empty
	if(!isDisplaying('.static-head-onscroll')){
	
		fader(document.querySelector('.static-head-onscroll'),'fadeIn','normal');
	}
	
		if(tempPopup != null){
		show('.temporary-popup');
		document.querySelector('#main-staticHead').setAttribute('class','col-lg-8 col-md-8 col-sm-8 col-xs-8');
			}
		}
	}
		
		else{
		if(isDisplaying('.static-head-onscroll')){
		fader(document.querySelector('.static-head-onscroll'),'fadeOut','normal');
		}
	}
	
if(window.pageYOffset >= 280){
		if(tempPopup != null){
		hide('.temporary-popup');
		document.querySelector('#main-staticHead').setAttribute('class','col-lg-12 col-md-12 col-sm-12 col-xs-12');
			}
		}
	}
	
	
	if(document.querySelector("[data-fix-rhs]") != null && document.querySelector("[data-relative-lhs]") != null){
		var rhs = document.querySelector("[data-fix-rhs]");
		var lhs = document.querySelector("[data-relative-lhs]");
		var topHeight = 0;
		if(document.querySelector("#all-top-b4-fixing-rhs") != null){
			topHeight = document.querySelector("#all-top-b4-fixing-rhs").clientHeight - 200;
			
		}
		if((window.pageYOffset >= topHeight) && (window.pageYOffset < (lhs.clientHeight + topHeight-500))){
			rhs.setAttribute("data-fix-rhs","true");
		}
		else{
			rhs.setAttribute("data-fix-rhs","false");
		}
	}
	
	
}//end of try
}catch(err){
	console.log("#100: "+err);
}

dashboardHeight = document.querySelector('nav>#dashboard').clientHeight;
function togglemenu(){
	try{
var sidebar = document.querySelector('nav>#dashboard');
var menu = document.querySelector('#menuicon');
//alert(sidebar.clientHeight);
if(sidebar.style.display != 'block'){
	/*var pull_down = setInterval(function(){
		if(h == 100){
			clearInterval(pull_down);
		}
		else{
			h++;
			sidebar.style.height = h+'px';		
		}
	},0.01);*/
	
	
	fader(sidebar,'fadeIn','fast');
	menu.innerHTML = "<span style=\"foze:150%\">&times</span>";
		}
else{
	fader(sidebar,'fadeOut','fast');
	menu.innerHTML = "<span class=\"menu-lines\"></span><span class=\"menu-lines\"></span><span class=\"menu-lines\"></span>";
		}
}
	catch(err){
		console.log("#101: "+err);
	}
}


try{
document.querySelector('.header-notice').addEventListener('click',function(event){
		event.preventDefault();
		popNotifications();
});
}
	catch(err){
		console.log("#102: "+err);
	}
	
	
function popNotifications(){
	try{
var notificationParent = document.querySelector('#notifications-parent');
var notificationContainer = document.querySelector('#notifications-container');
var notificationsBody = notificationContainer.querySelector("#notifications-body");
if(!isDisplaying('#notifications-parent')){
	
if(isDisplaying('.static-head-onscroll')){
//the static head should excuse
	fader(document.querySelector('.static-head-onscroll'),'fadeOut','normal');
	restoreStaticHead = true;
}

notificationsBody.setAttribute('data-loading-content','loading');
fader(notificationParent,'fadeIn','normal');
	
var getNotifications = new useAjax(doc_root+"/resources/php/api/loadNotifications.php");
getNotifications.go(function(responseCode,responseText){
	if(responseCode == 204){
	notificationsBody.removeAttribute('data-loading-content');
	notificationsBody.innerHTML =  responseText;
	}
	
});
}
else if(isDisplaying('#notifications-parent')){
fader(notificationContainer,'fadeOut','normal');
			}
		}
	catch(err){
		console.log("#103: "+err);
	}
}
	
function search_agent(search_container){
	try{
	var agentSearchField = search_container.querySelector("input.agent-search");
	var suggestionsContainer = search_container.querySelector('div.result-container');
			
			agentSearchField.addEventListener('keyup',function(event){			
			if(agentSearchField.value != ''){
				if(suggestionsContainer.style.display != 'block'){
				fader(suggestionsContainer,'fadeIn','normal');
			}
			suggestionsContainer.setAttribute('data-loading-content','searching');
			suggestionsContainer.innerHTML = "<p class=\"text-center\">searching for <strong>"+agentSearchField.value+"</strong>...</p>";
		var getAgent = new useAjax(doc_root+"/resources/php/api/getagents.php?key="+agentSearchField.value);
		getAgent.go(function(responseCode,responseText){
			if(responseCode == 204){
		   suggestionsContainer.removeAttribute('data-loading-content');
			suggestionsContainer.innerHTML = responseText;
			}
		});
			}
			else{
				fader(suggestionsContainer,'fadeOut','normal');
			}
		});
}catch(err){
	console.log("#104: "+err);
}
}
	search_agent(document.querySelector("div.agent-search-container"));


try{
var mobile_header_holder = document.querySelector(".row#header-menus-holder");
var mobile_search = document.querySelector("#mobile-header-search");
var search_form_holder = document.querySelector("#mobile-header-search-form-holder")

mobile_search.addEventListener('click',function(event){
	if(document.querySelector(".col-xs-12.mobile-searches-row") == null){
	var searches_holder = document.createElement("div");
	searches_holder.setAttribute("class","col-xs-12 mobile-searches-row white");
	
	var search_row = document.createElement("div");
	search_row.setAttribute("class","row");
	
	var agent_search = document.createElement("div");
	agent_search.setAttribute("class","col-xs-6 text-center");
	agent_search.innerHTML = "<span class=\"padding-5-10 opac-5-site-color-background\"><span class=\"glyphicon glyphicon-search\"></span> Search for agent </span>";
	agent_search.addEventListener('click',function(event){
		var agent_search_form = "<div style=\"margin:5px 10px\">"+document.querySelector(".hidden-xs.agent-search").innerHTML+"</div>";
		search_form_holder.innerHTML = agent_search_form;
		search_agent(document.querySelector("#mobile-header-search-form-holder>div>div.agent-search-container"));
	});
	
	var property_search = document.createElement("div");
	property_search.setAttribute("class","col-xs-6 text-center");
	property_search.innerHTML = "<span class=\"padding-5-10 opac-5-site-color-background\"><span class=\"glyphicon glyphicon-search\"></span> Search for property</span>";
	property_search.addEventListener('click',function(event){
		search_form_holder.innerHTML = "just a moment...";
		search_form_holder.setAttribute('loading-content','waiting');
		var get_search_form = new useAjax(doc_root+"/search/searchform.php?ajax=true");
		get_search_form.go(function(responseCode,responseText){
			if(responseCode == 204){
				search_form_holder.removeAttribute('loading-content');
				search_form_holder.innerHTML = "<div style=\"margin:5px 10px\">"+responseText+"</div>";
			}
		});
	});
	
	
	var search_form_holder = document.createElement("div");
	search_form_holder.setAttribute("class","col-xs-12");
	search_form_holder.setAttribute("id","mobile-header-search-form-holder");

	
	search_row.appendChild(property_search);
	search_row.appendChild(agent_search);
	search_row.appendChild(search_form_holder);
	
	searches_holder.appendChild(search_row);
	
	mobile_header_holder.appendChild(searches_holder);
}
else{
	mobile_header_holder.removeChild(mobile_header_holder.querySelector(".col-xs-12.mobile-searches-row"));
}
});
}
catch(err){
	console.log("Error105: "+err);
}
	</script>

	
<?php
if($status==1 ||$status==9){
//if there are new notifications
if($notifications != null && $notifications > 0){
	?>
<script>
popNotifications();
</script>
<?php	
		}
	}
?>

	
	 <?php
//if there is a modal to be display on page load
if(isset($onPageLoadPopup) && $onPageLoadPopup != "" && $onPageLoadPopup != null){
	?>
<div id="onpageLoadModal-holder" style="display:none"><?php echo $onPageLoadPopup ?></div>
<script>
var onpageLoadModal = new Modal();
onpageLoadModal.header = document.querySelector('#onpageLoadModal-holder>.header').innerHTML;
onpageLoadModal.content = document.querySelector('#onpageLoadModal-holder>.body').innerHTML;
onpageLoadModal.createModal();
onpageLoadModal.showModal();
onpageLoadModal.doInBackground(function(){
	 document.querySelector('#onpageLoadModal-holder').innerHTML = "";
});

</script>
<?php
}
?>

<style>
@media all and (min-width: 768px),(min-device-width: 768px){
<?php
if($status == 1 || $status == 9){
	?>
.container-fluid{
	padding-top:150px;/*because of the dashboard attached to the header*/
}
<?php
}
else{
?>
.container-fluid{
	padding-top:140px;
}
<?php
}
?>
}
@media all and (max-width: 768px),(max-device-width: 768px){
	.container-fluid{
	padding-top:90px;
}
}
</style>

<nav>
<span id="top"></span><!--Just an anchor-->

<div class="row">
<a class="hidden-lg hidden-md hidden-sm visible-xs col-xs-1 text-center" id="menuicon" onclick="javascript:togglemenu()">
<span class="menu-lines"></span>
<span class="menu-lines"></span>
<span class="menu-lines"></span>
</a>

<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 logo" style="display:none">
<a href="<?php echo $root ?>"><h1 style="display:inline; color:white;">Shelter</h1><h6 style="display:inline; color:white;" >.com</h6></a>
</div>

<div class="col-lg-6 col-md-6 col-sm-6 hidden-xs text-center menus">
<ul>
<a  href="<?php echo $root ?>" title="Home"><li>Home</li></a>	
<?php
//if user is logged, include this menu on the nav-bar
if($status==1){
	echo "<a href=\"$root/$profile_name\" title=\"$profile_name\"> <li>Account</li></a>";
}
?>

<a href="<?php echo $root."/agents"; ?>" title="Agents"><li >Agents</li></a>
<a href="<?php echo $root."/clients"; ?>" title="Clients"><li>Clients</li></a>
<a href="#" title="Contacts"><li>Contacts</li></a>
<a href="#" title="About"><li>FAQs</li></a>
</ul>
</div>

<div class="col-lg-3 col-md-3 col-sm-3 col-xs-7 agent-search">
<!--<div class="input-group">
<div class="input-group-addon" style="background-color:whites"></div>-->
<input class="site-color-background white form-control" style="" type="search" onkeyup="getAgents(this.value,'agents-snipet-search-input-desktop','suggested-agents-search-container-desktop','suggested-agents-search-list-desktop')" class="search-input-field" id="agents-snipet-search-input-desktop" type="text" placeholder="search for agent" maxlength="50"/>

<div style="margin-top:5px" class="suggested-agents-search-container suggestion-box" id="suggested-agents-search-container-desktop">
<div class="suggested-agents-search-list" id="suggested-agents-search-list-desktop" style="padding:0px; ">
</div>
</div>
</div>

<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 col-xs-offset-1 header-notice">
<?php
if($status==1 || $status==9){
	?>
	<span><a  title="notifications" href="<?php echo "$root/notifications" ?>"><span class="glyphicon glyphicon-bell icon-size-15 white" style="margin-right:0px;"></span>
	<?php 
	if($notifications>0){
	?><span class="red-background white border-radius-5 text-center bold padding-5"><?php echo $notifications ?></span>
	<?php
	}
	?>
	</a>
	</span>
<?php
}
 ?>
<!--<span title="refresh page" class="glyphicon glyphicon-refresh icon-size-15 white" onclick="javascript:location.reload()" style="float:right"></span>-->
</div>
</div>


<div class="row static-head-onscroll" style="display:none;">
<div class="col-xs-12">
<?php
if( isset($showStaticHeader) && $showStaticHeader == true){
if($status==1){
$staticHeadOptions = "<div class=\"col-sm-2 col-xs-2 text-right\">
<span class=\"glyphicon glyphicon-option-vertical icon-size-20 site-color\"></span>
</div>";
}
else if($status==9){
$staticHeadOptions = "<div class=\"col-sm-2 col-xs-2 text-right\">
<span class=\"glyphicon glyphicon-option-vertical icon-size-20 site-color\"></span>
</div>";
}
else{
$staticHeadOptions = "<div class=\"col-sm-2 col-xs-2 text-right\">
<span class=\"glyphicon glyphicon-option-vertical icon-size-20 site-color\"></span>
</div>";
}

if($ref == 'home_page' || $ref=='agents_page' ||  $ref=='clients_page'){
if($ref=='home_page'){
		$homeActiveClass = "icon-size-25 site-color";
		$agentActiveClass = "icon-size-20 grey";
		$clientActiveClass = "icon-size-20 grey";
	}
else if($ref=='agents_page'){
		$homeActiveClass = "icon-size-20 grey";
		$agentActiveClass = "icon-size-25 site-color";
		$clientActiveClass = "icon-size-20 grey";
	}
else if($ref=='clients_page'){
		$homeActiveClass = "icon-size-20 grey";
		$agentActiveClass = "icon-size-20 grey";
		$clientActiveClass = "icon-size-20 site-color";
	}
	
$staticHead = "<div class=\"row hidden-lg hidden-md hidden-sm visible-xs font-10 static-head-primary\" >

<div class=\"col-sm-3 col-xs-3 text-center\" >
<a href=\"$root\" class=\"grey\" ><span class=\"glyphicon glyphicon-home $homeActiveClass\"></span><br/>Home</a>
</div>

<div class=\"col-sm-4 col-xs-4 text-center\">
<a href=\"$root/agents\" class=\"grey\"><span class=\"glyphicon glyphicon-briefcase $agentActiveClass\"></span><br/>Agents</a>
</div>

<div class=\"col-sm-3 col-xs-3 text-center\">
<a href=\"$root/clients\" class=\"grey\" ><span class=\"glyphicon glyphicon-user $clientActiveClass\"></span><br/>Clients</a>
</div>
$staticHeadOptions
</div>
";
}
if(isset($staticHead)){
	echo $staticHead;
}
?>

<style>
.static-head-primary{
background-color:white;
padding:2px 0px;
border-bottom: 4px solid #b2dfdb;	
}
		</style>
		<script>
window.onscroll = function(event){
	staticHead('.static-head-onscroll');
}

function staticHead(theHead){
	var staticHead = document.querySelector(theHead);
	var existingStaticHead = document.querySelector('.alt-static-header');
	var tempPopup = document.querySelector('.temporary-popup');
	if(window.pageYOffset >= 80){
		staticHead.style.display = 'block';
		if(tempPopup != null){
		document.querySelector('.temporary-popup').style.display = 'block';
		document.querySelector('#main-staticHead').setAttribute('class','col-lg-8 col-md-8 col-sm-8 col-xs-8');
		}
		if(existingStaticHead != null){
			existingStaticHead.style.display = 'none';
		}
		}
		else{
		staticHead.style.display = 'none';
		if(existingStaticHead != null){
			existingStaticHead.style.display = 'block';
		}
		}
if(window.pageYOffset >= 280){
		if(tempPopup != null){
		document.querySelector('.temporary-popup').style.display = 'none';
		document.querySelector('#main-staticHead').setAttribute('class','col-lg-12 col-md-12 col-sm-12 col-xs-12');
		}
}
}

	</script>
<?php
}
?>
</div>
</div>

</nav>

 <?php
//this is a prepared popup, it is hidden by default
require('popup.php');
?>




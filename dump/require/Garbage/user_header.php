<script type="text/javascript" language="javascript" src="http://localhost/shelter/js/jquery-3.1.1.min.js"></script>
<script>
$(document).ready(function(){
$('#acct-dropdown').click(function(){
	$('#acct-dropdown-box').toggle();
	
});	
	
});

</script>
<?php
function redirect(){
	header('location: http://localhost/shelter/login');
}
//if user is logged in
if(isset($_COOKIE['name'])){
	$status = 1;
	 $profile_name=$_COOKIE['name']
}
//if user is not logged in
else{
	$status = 0;
}
?>
<title>Shelter | <?php echo $pagetitle; ?></title>
<div id="top-nav-bar">
<a href="http://localhost/shelter"><div id="templogo"><i><h2 style="display: inline" align="center">Shelter</h2><h6 style="display: inline">.com</h6></i></div></a>
<div id="menus">
<ul class="nav-bar">
<a  href="http://localhost/shelter" title="Home"><li class="nav-menu">Home</li></a>
<?php if($status==1){
//if user is logged, include this menu on the nav-bar
	echo "<a href=\"http://localhost/shelter/$profile_name\" title=\"$profile_name\"> <li class=\"nav-menu\">Profile</li></a>";
}?>
<a  href="http://localhost/shelter/agents" title="Agents"><li class="nav-menu">Agent</li></a>
<a href="#" title="Contacts"><li class="nav-menu">Contact</li></a>
<a href="#" title="About"><li class="nav-menu">About</li></a>
</div>

<?php
switch($status){
	case 1:
	$dropdown = "<div id=\"dropdown-container\">";
	$dropdown .= "<button id=\"acct-dropdown\"><i class=\"black-icon\" id=\"user-icon\"></i>$profile_name<i class=\"black-icon\" id=\"arrow\"></i></button>";
	$dropdown .= "<div id=\"acct-dropdown-box\">";
	$dropdown .= "<ul id=\"ul\">";
	$dropdown .= "<a  href=\"http://localhost/shelter/manage\" title=\"Manage\"><li class=\"acct-dropdown-content\">Manage Account</li></a>";
	$dropdown .= "<a  href=\"http://localhost/shelter/manage\" title=\"Manage property\"><li class=\"acct-dropdown-content\">Manage Property</li></a>";
	$dropdown .= "<a  href=\"http://localhost/shelter/logout\" title=\"Logout\"><li class=\"acct-dropdown-content\">Logout</li></a>";
	$dropdown .= "</ul></div>";
	$dropdown .= "</ul></div>";
	break;
	case 0:
	$dropdown = "<div id=\"dropdown-container\">";
	$dropdown .= "<button id=\"acct-dropdown\"><i class=\"black-icon\" id=\"user-icon\"></i>Account<i class=\"black-icon\" id=\"arrow\"></i></button>";
	$dropdown .= "<div id=\"acct-dropdown-box\">";
	$dropdown .= "<ul id=\"ul\">";
	$dropdown .= "<a  href=\"http://localhost/shelter/login\" title=\"Login\"><li class=\"acct-dropdown-content\">Login</li></a>";
	$dropdown .= "<a  href=\"http://localhost/shelter/signup\" title=\"Sign up\"><li class=\"acct-dropdown-content\">Sign up</li></a>";
	$dropdown .= "</ul></div>";
	$dropdown .= "</ul></div>";
	break;
}
echo $dropdown;
?>
</div>
<div style="width:100%; height:50px; background-color:inherit"></div>
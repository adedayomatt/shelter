<script type="text/javascript" language="javascript" src="http://localhost/shelter/js/jquery-3.1.1.min.js"></script>
<script>
$(document).ready(function(){
$('#acct-dropdown').click(function(){
	$('#acct-dropdown-box').toggle();
	
});	
	
});

</script>

<title>Shelter | <?php echo $pagetitle; ?></title>

<div id="top-nav-bar">
<a href="http://localhost/shelter"><div id="templogo"><i><h2 style="display: inline" align="center">Shelter</h2><h6 style="display: inline">.com</h6></i></div></a>
<div id="menus">
<ul class="nav-bar">
<a  href="http://localhost/shelter" title="Home"><li class="nav-menu">Home</li></a>
<a  href="http://localhost/shelter/agents" title="Agents"><li class="nav-menu">Agent</li></a>
<a href="#" title="Contacts"><li class="nav-menu">Contact</li></a>
<a href="#" title="About"><li class="nav-menu">About</li></a>
</div>
<div id="dropdown-container">
<button id="acct-dropdown"><i class="black-icon" id="user-icon"></i>Account<i class="black-icon" id="arrow"></i></button>
<div id="acct-dropdown-box">
<ul id="ul">
<a  href="http://localhost/shelter/login" title="Login"><li class="acct-dropdown-content">Login</li></a>
<li><hr/></li>
<a  href="http://localhost/shelter/signup" title="Sign up"><li  class="acct-dropdown-content">Sign up</li></a>
</ul></div>
</ul></div>
</div>
<div style="width:100%; height:60px; background-color:inherit"></div>
<div style="width:20%;margin:0" >
<marquee style="font-size:12px; color:red"><i><b>*NOTICE: you are currently not logged in as agent</b></i></marquee></div>

<!--@param $pagetitle will be parsed from any script that includes or require this header-->
<title>Shelter | <?php echo $pagetitle; ?></title>
<script>
function time(){
var t = document.getElementById("time");
var datetime = Date().toString();
t.value = datetime.substring(0,datetime.indexOf("GMT-0700 (Pacific Standard Time"));
}
</script>
<div class="top">
<div class="logobox">
<!--<img id = "logo" src="" alt="Shelter logo"  />-->
<div id="templogo"><i><h2 style="display: inline" align="center">Shelter</h2><h6 style="display: inline">.com</h6></i></div>
</div>
<a name="menu">
<nav>
<div class="bar">
		<a class="homelink" href="http://localhost/shelter" title="Home"><button type="button" class="nav_button">Home</button></a>
		<a class="agentslink" href="http://localhost/shelter/agents" title="Agents"><button type="button" class="nav_button">Agents</button></a>
		<a class="contactlink"  href="" title="Contact"><button type="button" class="nav_button">Contact</button></a>
		<a class="aboutlink"  href="" title="About"><button type="button" class="nav_button">About</button></a>
		<button type="button" class="empty_button"></button><button type="button" class="empty_button"></button><button type="button" class="empty_button"></button>
		<button type="button" class="empty_button"></button><button type="button" class="empty_button"></button><button type="button" class="empty_button"></button>
		</div>
</nav>
</a>
<div class="todobox"><a class="todo" href="http://localhost/shelter/signup"><button class="todobutton"><b>sign up</b></button></a> or <a class="todo" href="http://localhost/shelter/login"><button class="todobutton"><b>login</b></button></a></div>
		</div>
		<p><i><b>NOTICE: you are currently not logged in as agent</b></i></p>
		<style>
		
		.todobox{
	padding-left:20px;
	color:white;
	background-color:#6D0AAA;
	float:right;
	width:180px;
	border-radius:0px 0px 0px 15px;
}
.todobutton{
	opacity:0.8;
	border-radius:4px;
	background-color:blue;
	cursor:pointer;
	font-size:15px;
	text-decoration:none;
	color:white;
}

</style>

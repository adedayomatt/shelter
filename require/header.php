
<?php
/*
All the variables in this script are initialized or set in connexion.php; 
connexion.php must have been required before the header is required anywhere
The reason for this is to use header to redirect appropriately from anywhere 
*/
?>

<script type="text/javascript" language="javascript" src="http://localhost/shelter/js/jquery-3.1.1.min.js"></script>
<script  type="text/javascript" language="javascript">

function togglemenu(){
var sidebar = document.getElementById('sidebar-wrapper');
var menu = document.getElementById('menuicon');
var headerunder = document.getElementById('top-nav-bar-under');
var headertop = document.getElementById('top-nav-bar-content');
var body = document.getElementById('linear-layout-content');
var hangingHead = document.getElementById('top-nav-bar-content-on-scroll');

if(sidebar.style.display != 'block'){
	headerunder.style.display = 'block';
	headertop.style.position = 'fixed';
	sidebar.style.display = 'block';
	//sidebar.style.width = '95%';
	sidebar.style.marginTop = '0px';
	sidebar.style.overflow = 'scroll';
	menu.innerHTML = "<span style=\"font-size:150%\">&times</span>";
	sidebar.focus();
	hangingHead.style.display = 'none';
	document.getElementById('suggested-agents-search-list-mobile').style.display ='none';
		}
else{
	sidebar.style.display = 'none';
	menu.innerHTML = "<span class=\"menu-lines\"></span><span class=\"menu-lines\"></span><span class=\"menu-lines\"></span>";
		}
	}
	
function getAgents(key,inputId,container,list){
	var agentSearchField = document.getElementById(inputId);
	var containerBox = document.getElementById(container);
	if(agentSearchField.value != ''){
		containerBox.style.display = 'block';
try{
		//opera 8+, firefox,safari
		xmlhttp = new XMLHttpRequest();
	}
	catch(e){
		//Internet Explorer
		try{
			xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
		}
	catch(e){
		try{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		catch(e){
			alert('This browser is crazy!');
		}
	}	
	}
var thelist = document.getElementById(list);
	xmlhttp.onreadystatechange = function(){
	if(xmlhttp.status == 200){
if(xmlhttp.readyState == 4){
//first clear the list
	thelist.innerHTML = "";
thelist.innerHTML += xmlhttp.responseText;
		}
	}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
}

thelist.innerHTML = "<p class=\"loading-data\"> searching '"+key+"'</p>";

var url = "http://192.168.173.1/shelter/resrc/getagents.php?key="+key;
xmlhttp.open("GET",url, true);
xmlhttp.send();	
	
	}
	else{
		//containerBox.innerHTML = "";
		containerBox.style.display = 'none';
	}
}
function timecountdown(containerId,initial){
var counter = setInterval(countdown,1000);
var container = document.getElementById(containerId);
var day = document.getElementById('day-countdown');
var hour = document.getElementById('hr-countdown');
var min = document.getElementById('min-countdown');
var sec = document.getElementById('sec-countdown');

var d = parseInt(initial/86400);
var h = parseInt((initial%86400)/3600);
var m =  parseInt((initial%3600)/60);
var s = initial%60;
function countdown(){
	if(d==0 && h==0 && m==0 && s==0){
		clearInterval(counter);
		day.innerHTML = '00';
	hour.innerHTML = '00';
	min.innerHTML = '00';
	sec.innerHTML = '00';
	day.style.color='red';
	hour.style.color='red';
	min.style.color='red';
	sec.style.color='red';
	}
	else{
	s--;
	if(s<0){
		m--;
		s=59;
		if(m<0){
			h--;
			m=59;
			if(h<0){
				d--;
				h=23;
			}
		}
	}
	if(d<=5){
		day.style.color='red';
	}
	if(d==0 && h<12){
		hour.style.color='red';
	}
	if(d==0 && h==0 && m<=30){
		min.style.color='red';
		sec.style.color='red';
		
	}
	day.innerHTML = (d<10 ? '0'+d : d)+'d';
	hour.innerHTML = (h<10 ? '0'+h : h)+'h';	
	min.innerHTML = (m<10 ? '0'+m : m)+'m';	
	sec.innerHTML = (s<10 ? '0'+s : s)+'s';	
	
	}
	
}	
}
</script>

<title>Shelter | <?php echo $pagetitle; ?></title>
<style>
.fixed-head-after-scroll{
	height:50px;
}
#desktop-search{
	margin-left:20px;;
}
input.home-search{
	font-family:Georgia;
	border:none;
	border-radius:5px;
	background-color:rgba(236, 87, 236, 0.2);
	padding:5px;
}
input.home-search:focus{
	border:none;
}
input.select-type{
	width: 200px;
}
input.max-price{
	width: 80px;
}
input.location{
	width: 250px;
}
input.search{
	background-color:purple;
	color:white;
}

</style>
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
<?php if($status==1){
//if user is logged, include this menu on the nav-bar
	echo "<a href=\"$root/$profile_name\" title=\"$profile_name\"> <li class=\"nav-menu\">Profile</li></a>";
}?>
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
<script>
window.onscroll = function(event){
	 if(window.pageYOffset >= document.getElementById('top-nav-bar-content').clientHeight){
		 document.getElementById('rhs-top-search-btn').style.display = "inline-block";
}
else{
	document.getElementById('rhs-top-search-btn').style.display = "none";
	}
}
</script>

<!--<button id="rhs-top-search-btn" style=""> Search </button>-->
</div>
</div>
<div class="top-nav-bar" id="top-nav-bar-under" ></div>

</div>

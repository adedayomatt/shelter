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

function showAgentBrief(box){
event.preventDefault();
//alert(event.target);
var agentBox = document.getElementById(box);
agentBox.style.display = 'block';
}
function hideAgentBrief(box){
event.preventDefault();
//alert(event.target);
var agentBox = document.getElementById(box);
agentBox.style.display = 'none';
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


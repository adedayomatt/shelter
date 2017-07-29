
/**
 * This function is to toggle sidebar especially in mobile
 */
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
/*_________________________________________________________________________________________________________________________ */

/**
 * This function is for countdown on the sidebar
 * @param {*} containerId 
 * @param {*} initial 
 */
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
/*_________________________________________________________________________________________________________________________ */

/**
 * This functions is resposible for displaying agent brief info when clicked on in the home page
 * @param {*} box 
 */
function showAgentBrief(box){
event.preventDefault();
//alert(event.target);
var agentBox = document.getElementById(box);
agentBox.style.display = 'block';
}
function hideAgentBrief(box){
event.preventDefault();
var agentBox = document.getElementById(box);
agentBox.style.display = 'none';
}
/*_________________________________________________________________________________________________________________________ */
/**
 * This function uses AJAX to get agents asynchronously
 * @param {*} key 
 * @param {*} inputId 
 * @param {*} container 
 * @param {*} list 
 */
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

var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/getagents.php?key="+key;
xmlhttp.open("GET",url, true);
xmlhttp.send();	
	
	}
	else{
		//containerBox.innerHTML = "";
		containerBox.style.display = 'none';
	}
}

/**
 * This one suggest locations as user type in the search location input
 * 
 */
function getLocations(key){
	var theLocationList = document.getElementById('suggested-location-container');
var locationSearchField = document.getElementById('location-input');
	if(locationSearchField.value != ''){
		theLocationList.style.display = 'block';
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
	xmlhttp.onreadystatechange = function(){
	if(xmlhttp.status==200){
if(xmlhttp.readyState == 4){
//first clear the list
	theLocationList.innerHTML = "";
theLocationList.innerHTML += xmlhttp.responseText;

	}
		else{
			//Nothing here yet
		}
	}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
}
theLocationList.innerHTML = "<div><img class=\"gif stairs-loading\" src=\"resrc/gifs/loading.gif\" /></div>";

var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/getLocations.php?key="+key;
xmlhttp.open("GET",url, true);
xmlhttp.send();	
	
	}
	else{
		theLocationList.style.display = 'none';
	}
}

function setLocation(location){
	var locField = document.getElementById('location-input');
	locField.value = location;
	document.getElementById('suggested-location-container').style.display = 'none';
}


/*_________________________________________________________________________________________________________________________ */

/**
 * This one is for follow
 * @param {*} buttonid 
 * @param {*} follower 
 * @param {*} followerid 
 * @param {*} following 
 * @param {*} type 
 */
function follow(buttonid,followerid,follower_name,follower_username,followingid,following_name,following_username,type){
	var button = document.getElementById(buttonid);
	//	button.innerHTML = '';
		button.className = 'waiting-follow-button';
	setTimeout(f,2000);
function f(){	
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
	
xmlhttp.onreadystatechange = function(){
//if the script is OK
	if(xmlhttp.status==200){
//if communication was successfull and response is gotten successfully
if(xmlhttp.readyState == 4){
	changeStuffs(xmlhttp.responseText);
}
else{
		button.innerHTML = "<span class=\"black-icon warning-icon\"></span>" ;
	}
}
	else if(xmlhttp.status==404){
		button.innerHTML = "<span class=\"black-icon warning-icon\"></span>" ;
	}
};
var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/follow.php?flwerId="+followerid+"&flwer="+follower_name+"&flwerUname="+follower_username+"&flwingId="+followingid+"&flwing="+following_name+"&flwingUname="+following_username+"&t="+type;
xmlhttp.open("GET",url, true);
xmlhttp.send();

function changeStuffs(response){
	if(response == 'positive'){
		button.className = 'unfollow-button';
	button.innerHTML = "<span class=\"white-icon unfollow-icon\"></span> unfollow";
	document.getElementById(followingid+'-follow-status').innerHTML = "Following";
	}
	else if(response == 'negative'){
		button.className = 'follow-button';
	button.innerHTML = "<span class=\"black-icon follow-icon\"></span> follow";
	document.getElementById(followingid+'-follow-status').innerHTML = "";
				}
			}

		}
	}
/*_________________________________________________________________________________________________________________________ */

/**
 * For clipping properties
 * @param {*} propertyclipbutton 
 * @param {*} clipper 
 * @param {*} ref 
 */
function makeclip(propertyclipbutton,clipper,ref){
	event.preventDefault();
	var propertyid = propertyclipbutton.substring(0,propertyclipbutton.indexOf('clipbutton'));

	var clipbutton = document.getElementById(propertyclipbutton);
	clipbutton.className = 'waiting-clip';
//if the page is the homepage where the sidebar is...
	if(ref=='home_page' || ref=='ctaPage'){
	var sidebar = document.getElementById('clipstring');
	var clipcounterstatement = sidebar.innerHTML.substring(3,sidebar.innerHTML.length);
	}
	var response = "";
	setTimeout(clip,2000);
	

function clip(){
	
	//create the XMLHttpRequest object
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
		alert("XMLHttpRequest('Msxml2.XMLHTTP')did not work");
		try{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		catch(e){
			alert('This browser is crazy!');
		}
	}	
	}
	
	xmlhttp.onreadystatechange = function(){
//if the script is OK
	if(xmlhttp.status==200){
//if communication was successfull and response is gotten successfully
if(xmlhttp.readyState == 4){
	sync(xmlhttp.responseText);
		}
		else{
			clipbutton.innerHTML = "<span class=\"black-icon warning-icon\" ></span>";
		}
}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
}
var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/clip.php?p="+propertyid+"&cb="+clipper+"&ref="+ref;
xmlhttp.open("GET",url, true);
xmlhttp.send();
  
  }
  
  function sync(response){
if(response.substring(0,2)=='cl'){
	if(ref=='home_page' || ref=='ctaPage'){
		sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;
	}
	clipbutton.className = 'clip-button';
clipbutton.innerHTML = "<span class=\"black-icon plus-icon\" ></span>"+response.substring(0,response.indexOf('/'));

}
else if(response.substring(0,2)=='un'){
	if(ref=='home_page' || ref=='ctaPage'){
		sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;	
	}
	clipbutton.className = 'unclip-button';
clipbutton.innerHTML = "<span class=\"black-icon minus-icon\"></span>"+response.substring(0,response.indexOf('/'));
	}
	
else if(response.substring(0,2) == 're'){
	if(ref=='home_page' || ref=='ctaPage'){
	sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;
	}
	document.getElementById(propertyid).style.display = "none";
	
}

  }
}


/**
 * This function animate background of element, just pass the element selector (id, class, or other element selector)
 * as the arguement.
 * 
 * CAN'T BELIEVE I MADE THIS MYSELF, 5-Aug-2017, 11:24 PM
 * 
 * @param {*} selector 
 */
function animateBackgroundColor(selector){
	var r = Math.round(Math.random() * 200);
	var g = Math.round(Math.random() * 200);
	var b = Math.round(Math.random() * 200);
	var i = setInterval(animate,500);

function animate(){
if((r >= 180 && g>=180 && b >= 180) || (r <= 180 && g>=180 && b > 180) || (r <= 180 && g<=180 && b >= 10)){
	shrinkRGB();												
	}
else {
exhaustRGB();
	}
									
function exhaustRGB(){
if(r < 200){
r += 5;
	}
else{		
	if(g < 200){
		g += 5;
				}
			   else{
					if(b < 200){
								b += 5;
										}
										
							}
						}
					}

function shrinkRGB(){
if(r>10){
r -= 5;
	}
	else{
		if(g>10){
			g -= 5;
		}
		else{
			if(b>=10){
				b -= 5;
			}
			
		}
	}
}
document.querySelector(selector).style.backgroundColor = "rgb("+r+","+g+","+b+")";
	}

}
	
	

/**
 * This function is to toggle sidebar especially in mobile
 */
function togglemenu(){
var sidebar = document.getElementById('sidebar-wrapper');
var menu = document.getElementById('menuicon');
/*
var headerunder = document.getElementById('top-nav-bar-under');
var headertop = document.getElementById('top-nav-bar-content');
var body = document.getElementById('linear-layout-content');
var hangingHead = document.getElementById('top-nav-bar-content-on-scroll');
*/

if(sidebar.style.display != 'block'){
	sidebar.style.display = 'block';
	sidebar.style.height = '95%';
	sidebar.style.position = 'fixed';
	menu.innerHTML = "<span style=\"font-size:150%\">&times</span>";
	document.querySelector('body').style.overflow = 'hidden';
	sidebar.focus();
		}
else{
	sidebar.style.display = 'none';
	menu.innerHTML = "<span class=\"menu-lines\"></span><span class=\"menu-lines\"></span><span class=\"menu-lines\"></span>";
	document.querySelector('body').style.overflow = 'scroll';
		}
	}

/**
 * __________________________________________________________________________________________________________________________
 */
/**
 * This function toggles
 */
 
 function toggle(trigger,toggleElement){
	 trigger.onclick = function(event){
		 if(toggleElement.style.display == 'block'){
	 toggleElement.style.display = 'none';
	 }else{
toggleElement.style.display = 'block';	
		}
		 
	 }
	 
 }
 
 
/**
 * __________________________________________________________________________________________________________________________
 */

//this function returns the element that contains the popup message
function popUpContent(){
var popupContentElement = document.querySelector('.custom-modal-content');
return popupContentElement;
}

	//opening pop up
function showPopup(){
		var popupParent = document.querySelector('.modal-container');
		popupParent.style.display = 'block';
		popupParent.focus();
		document.querySelector('body').style.overflow = 'hidden';

	}
//closing pop up
function closePopup(){
		var popupParent = document.querySelector('.modal-container');
	//clear its content
	popUpContent().innerHTML= "";
	popupParent.style.display = 'none';
			document.querySelector('body').style.overflow = 'scroll';

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
 * This function create and return object of AJAX with different trials
 */
function ajaxObject(){
	ajax = null;
		try{
		//opera 8+, firefox,safari
		ajax = new XMLHttpRequest();
	}
	catch(e){
		//Internet Explorer
		try{
			ajax = new ActiveXObject('Msxml2.XMLHTTP');
		}
	catch(e){
		try{
		ajax = new ActiveXObject('Microsoft.XMLHTTP');
		}
		catch(e){
			alert('This browser is crazy!');
			}
		}	
	}	
	return ajax;
}

	function check_connection(ajaxObject,reportContainer){
		var url = "http://192.168.173.1/shelter";
		ajaxObject.open("GET",url, true);
	if(!ajaxObject.send()){
		reportContainer.innerHTML = '<h1 class=\"red text-center\">Looks like there is no connection, check your internet</h1>';
		return false;
			}
			else{
				return true;
			}
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

xmlhttp = ajaxObject();

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

thelist.innerHTML = "<p class=\"text-center blue\"> searching '"+key+"'</p>";

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

xmlhttp = ajaxObject();

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
theLocationList.innerHTML = "<p class=\"text-center blue\">looking up '"+key+"'</p>";

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
	//get the Ajax object
xmlhttp = ajaxObject();
xmlhttp.onreadystatechange = function(){
//if the script is OK
	if(xmlhttp.status==200){
//if communication was successfull and response is gotten successfully
if(xmlhttp.readyState == 4){
	changeStuffs(xmlhttp.responseText);
}
else{
		button.innerHTML = "<span class=\"glyphicon glyphicon-warning-sign\"></span>" ;
		button.style.backgroundImage = "" ;
	}
}
	else if(xmlhttp.status==404){
		button.innerHTML = "<span class=\"glyphicon glyphicon-warning-sign\"></span>" ;
		button.style.backgroundImage = "" ;
	}
};
var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/follow.php?flwerId="+followerid+"&flwer="+follower_name+"&flwerUname="+follower_username+"&flwingId="+followingid+"&flwing="+following_name+"&flwingUname="+following_username+"&t="+type;
xmlhttp.open("GET",url, true);
xmlhttp.send();

function changeStuffs(response){
	if(response == 'positive'){
		button.className = 'unfollow-button';
	button.innerHTML = "<span class=\"glyphicon glyphicon-minus-sign\"></span> unfollow";
	//document.getElementById(followingid+'-follow-status').innerHTML = "<span class=\"glyphicon glyphicon-ok-sign\"></span>Following";
	}
	else if(response == 'negative'){
		button.className = 'follow-button';
	button.innerHTML = "<span class=\"glyphicon glyphicon-plus-sign\"></span> follow";
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
function makeclip(propertyclipbutton,clipper,ref,token){
	//event.preventDefault();
	
//strip off the propertyid from the button id
	var propertyid = propertyclipbutton.substring(0,propertyclipbutton.indexOf('clipbutton'));
	var clipCounter = document.getElementById('clip-counter');
	var clipbutton = document.getElementById(propertyclipbutton);
	var response = "";
	clipbutton.className = 'waiting-clip';
	clipbutton.setAttribute('title','just a moment...');
	//2 secs delay
	setTimeout(clip,2000);

function clip(){
	
	xmlhttp = ajaxObject();

	xmlhttp.onreadystatechange = function(){
//if the script is OK
	if(xmlhttp.status==200){
//if communication was successfull and response is gotten successfully
if(xmlhttp.readyState == 4){
	sync(xmlhttp.responseText);
		}
		else{
			clipbutton.innerHTML = "<span class=\"glyphicon glyphicon-alert\"></span>";
			clipbutton.setAttribute('title','An error occured');
		}
}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
}
var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/clip.php?p="+propertyid+"&cb="+clipper+"&ref="+ref+"&tkn="+token;
xmlhttp.open("GET",url, true);
xmlhttp.send();
  
  }
  
  function sync(response){
	  //if the element the number of clipped is accesssible
if(clipCounter != null){
	//set the new number of clipped if clipped or unclip was successful
	if(response.substring(0,2)=='cl' || response.substring(0,2)=='un'){
clipCounter.innerHTML =  response.substring(response.indexOf('/')+1);
	}
	else{
clipCounter.innerHTML = "<span class=\"glyphicon glyphicon-alert\"></span>";
	}
}
//if clipped
if(response.substring(0,2)=='cl'){ 
clipbutton.className = 'unclip-button';
clipbutton.innerHTML = "<span class=\"glyphicon glyphicon-paperclip\"></span>unclip";
clipbutton.setAttribute('title','clipped');
}
//if unclipped
else if(response.substring(0,2)=='un'){
clipbutton.className = 'clip-button';
clipbutton.innerHTML = "<span class=\"glyphicon glyphicon-paperclip\"></span>clip";
clipbutton.setAttribute('title','unclipped');
	}
/*if neither clipped nor unclipped, then it must be that client is not checked in and the checkin form
**is returned, then pop it up!,...
**Debug:see the clip.php script */
else{
	showPopup();
	popUpContent().innerHTML = response;
}
}

/* I want to hide the unclipped if unclipped from the cta page
else if(response.substring(0,2) == 're'){
		clipbutton.setAttribute('title','unclipped');
	if(ref=='home_page' || ref=='ctaPage'){
	sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;
}
	document.getElementById(propertyid).style.display = "none";
	
			}
	*/		

	  }
	  






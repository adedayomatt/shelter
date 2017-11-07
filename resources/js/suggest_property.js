var suggest_buttons = document.querySelectorAll('.suggestion-button');
for(c = 0; c < suggest_buttons.length; c++){
initiate_suggestion(suggest_buttons[c]);
}	
function initiate_suggestion(b){
	b.onclick = function(event){
	//alert(b.getAttribute('data-client-name'));
	var agentid = b.getAttribute('data-agent-id');
	var agent_bname = b.getAttribute('data-agent-business-name');
	var agent_username = b.getAttribute('data-agent-username');
	var token = b.getAttribute('data-agent-token');
	var clientname = b.getAttribute('data-client-name');
	var clientid = b.getAttribute('data-client-id');
loadProperties(agentid,agent_bname,agent_username,token,clientname,clientid);
	}
}
/*
This function load an agent's properties to suggest to a client
*/	 
 function loadProperties(agentid,agent_bname,agent_username,token,clientname,clientid){

showPopup();
popUpContent().innerHTML = "<div class=\"text-center\"><h3 >Suggest property for "+clientname+"</h3><hr class=\"grey\" /><div id=\"loading-gif\">Loading your properties...<br/><img src=\"http://192.168.173.1/shelter/resrc/gifs/progress-bar.gif\"/></div></div>"
setTimeout(goGetProperties,2000);

function goGetProperties(){
xmlhttp = ajaxObject();
xmlhttp.onreadystatechange = function(){
//if the script is OK
	if(xmlhttp.status==200){
//if communication was successfull and response is gotten successfully
if(xmlhttp.readyState == 4){
document.querySelector('#loading-gif').style.display = 'none';
popUpContent().innerHTML += "<div class=\"text-left\">"+ xmlhttp.responseText+"</div>";
initiate_one_click_suggest();
}
else{
		//popUpContent().innerHTML += "<span class=\"glyphicon glyphicon-alert\"></span> Something went wrong" ;
	}
}
	else if(xmlhttp.status==404){
		button.innerHTML = "<span class=\"glyphicon glyphicon-alert\"></span> Couldn't find the script" ;
	}
};
var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/myproperties.php?aid="+agentid+"&aBn="+agent_bname+"&un="+agent_username+"&tkn="+token+"&client="+clientname+"&cid="+clientid;
xmlhttp.open("GET",url, true);
xmlhttp.send();
}
}

function initiate_one_click_suggest(){
var one_click_suggest_btns = document.querySelectorAll('.one-click-suggest-btn');
if(one_click_suggest_btns != null || one_click_suggest_btns.length > 0){
for(s = 0; s < one_click_suggest_btns.length; s++){
suggest(one_click_suggest_btns[s]);
}
}
else{
	alert('no match for .one-click-suggest-btn');
}
function suggest(b){
	b.onclick = function(event){
		var propertyid = b.getAttribute('data-pid');
		var propertydir = b.getAttribute('data-pdir');
		var agent_bname = b.getAttribute('data-agent-name');
		var agent_username = b.getAttribute('data-agent-username');
		var agentid = b.getAttribute('data-agent-id');
		var agenttoken = b.getAttribute('data-agent-token');
		var clientname = b.getAttribute('data-client-name');
		var clientid = b.getAttribute('data-client-id');
	suggest_property(clientname,clientid,propertyid,propertydir,agent_bname,agent_username,agentid,agenttoken);
	}
}
}
/*This one takes care of the adding the suggestion to the database*/
function suggest_property(clientname,clientid,propertyid,propertydir,agent_bname,agent_username,agentid,agenttoken){
var suggestbutton = document.querySelector('.one-click-suggest-btn#'+propertyid);
suggestbutton.innerHTML = "...";
ajax = ajaxObject();
ajax.onreadystatechange = function(){
    //if the script is OK
	if(ajax.status==200){
//if communication was successfull and response is gotten successfully
if(ajax.readyState == 4){
suggestbutton.innerHTML = ajax.responseText;
//suggestbutton.style.backgroundColor = 'green';
}
else{
suggestbutton.innerHTML = "<span class=\"glyphicon glyphicon-alert\"></span> failed" ;
	}
}
else if(ajax.status==404){
		suggestbutton.innerHTML = "<span class=\"glyphicon glyphicon-alert\"></span> Couldn't find the script" ;
	}
};

var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/suggestproperty.php?client="+clientname+"&cid="+clientid+"&pid="+propertyid+"&pdir="+propertydir+"&ag_Bname="+agent_bname+"&ag_name="+agent_username+"&aid="+agentid+"&tkn="+agenttoken;
ajax.open("GET",url, true);
ajax.send();


}
function follow(buttonid,follower,followerid,following,type){
	var button = document.getElementById(buttonid);
	button.innerHTML = "...";
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
		button.innerHTML = "processing..." ;
	}
}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
};
var url = "http://192.168.173.1/shelter/resources/php/ajax_scripts/follow.php?flwer="+follower+"&flwerId="+followerid+"&flwing="+following+"&t="+type;
xmlhttp.open("GET",url, true);
xmlhttp.send();

function changeStuffs(response){
	if(response == 'positive'){
		button.className = 'unfollow-button';
	button.innerHTML = "<span class=\"white-icon unfollow-icon\"></span> unfollow";
	document.getElementById('follow-status').innerHTML = "You are now following "+following;
	}
	else if(response == 'negative'){
		button.className = 'follow-button';
	button.innerHTML = "<span class=\"black-icon follow-icon\"></span> follow";
	document.getElementById('follow-status').innerHTML = "You have stopped following "+following;
	}
}

}
}

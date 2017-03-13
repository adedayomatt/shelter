function follow(follower,followerid,following,type){
	var button = document.getElementById('followbutton');
	
	try{
		//opera 8+, firefox,safari
		xmlhttp = new XMLHttpRequest();
	}
	catch(e){
		//Internet Explorer
		alert("XMLHttpRequest()did not work");
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
button.innerHTML = xmlhttp.responseText ;
}
	else{
		button.innerHTML = "processing..." ;
	}
}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
};
var url = "http://localhost/shelter/profile/follow.php?flwer="+follower+"&flwerId="+followerid+"&flwing="+following+"&t="+type;
xmlhttp.open("GET",url, true);
xmlhttp.send();
}



/*
This was for testing my Ajax, it was awesome!

function sampling(v){
	var msg="default message<br/>";
		xmlhttp = new XMLHttpRequest();
		
xmlhttp.onreadystatechange = function(){
	if(xmlhttp.status==200){
		switch(xmlhttp.readyState)
{
	case 0:
		msg = "Object created...<br/>"	;
	break;
	case 1:
	msg = "open () called..<br/>";
	break;
	case 2:
	msg = "send () called<br/>";
	break;
	case 3:
	msg = "communication established, processing response...<br/>";
	break;
	case 4:
	msg = xmlhttp.responseText + "<br/>" ;
		break;
		default:
		alert("Nothing happened");
		break;
	}
 document.getElementById('sampletext').innerHTML += msg;
	}
	else if(xmlhttp.status==404){
		alert("this did not go well:404!");
	}
};
var url = "http://localhost/shelter/profile/ajax.php?text="+v;
xmlhttp.open("GET",url, true);
xmlhttp.send();

}
*/

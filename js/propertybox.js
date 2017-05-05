
function makeclip(propertyclipbutton,clipper,ref){
	event.preventDefault();
	var propertyid = propertyclipbutton.substring(0,propertyclipbutton.indexOf('clipbutton'));

	var clipbutton = document.getElementById(propertyclipbutton);
	clipbutton.innerHTML = "<span class=\"black-icon clip-icon\"></span>...";
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
}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
}
var url = "http://192.168.173.1/shelter/cta/c.php?p="+propertyid+"&cb="+clipper+"&ref="+ref;
xmlhttp.open("GET",url, true);
xmlhttp.send();
  
  }
  
  function sync(response){
if(response.substring(0,2)=='cl'){
	if(ref=='home_page' || ref=='ctaPage'){
		sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;
	}
clipbutton.innerHTML = "<span class=\"black-icon clip-icon\" ></span>"+response.substring(0,response.indexOf('/'));

}
else if(response.substring(0,2)=='un'){
	if(ref=='home_page' || ref=='ctaPage'){
		sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;	
	}
clipbutton.innerHTML = "<span class=\"black-icon clip-icon\"></span>"+response.substring(0,response.indexOf('/'));
	}
	
else if(response.substring(0,2) == 're'){
	if(ref=='home_page' || ref=='ctaPage'){
	sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;
	}
	document.getElementById(propertyid).style.display = "none";
	
}

  }
}

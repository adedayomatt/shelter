
function makeclip(propertyclipbutton,clipper,ref){
	event.preventDefault();
	var propertyid = propertyclipbutton.substring(0,propertyclipbutton.indexOf('clipbutton'));

	var clipbutton = document.getElementById(propertyclipbutton);
	clipbutton.innerHTML = "<li class=\"options\" ><i class=\"black-icon\" id=\"like\"></i>...</li>";
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

if(xmlhttp.responseText.substring(0,2)=='cl'){
	response = xmlhttp.responseText;
	if(ref=='home_page' || ref=='ctaPage'){
		sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;
	}
clipbutton.innerHTML = "<li class=\"options\" id=\"clip-property\" ><i class=\"black-icon\" id=\"like\"></i>"+response.substring(0,response.indexOf('/'))+"</li>";

}
else if(xmlhttp.responseText.substring(0,2)=='un'){
	response = xmlhttp.responseText;
	if(ref=='home_page' || ref=='ctaPage'){
		sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;	
	}
clipbutton.innerHTML = "<li class=\"options\" id=\"clip-property\"><i class=\"black-icon\" id=\"like\"></i>"+response.substring(0,response.indexOf('/'))+"</li>";
	}
	
else if(xmlhttp.responseText.substring(0,2) == 're'){
	response = xmlhttp.responseText;
	if(ref=='home_page' || ref=='ctaPage'){
	sidebar.innerHTML = "(" + response.substring(response.indexOf('/')+1) + ")" + clipcounterstatement;
	}
	document.getElementById(propertyid).style.display = "none";
	
}

}
	else{
		clipbutton.innerHTML = "<li class=\"options\" id=\"clip-property\"><i class=\"black-icon\" id=\"like\"></i>processing...</li>" ;
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
}

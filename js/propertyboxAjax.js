function makeclip(property,clipper){
	document.getElementById(property).innerHTML ="<li class=\"options\" ><i class=\"black-icon\" id=\"like\"></i>clipping...</li>";
	setTime(clip(property,clipper),5000);
}


function clip(property,clipper){
	//get the particular button
	//alert('p='+property+' cb = '+clipper);
	var clipbutton = document.getElementById(property);
	/*
	var prevclips = document.getElementById('clips').value;
	var newclips = prevclips;
	*/
	//wanted to get the expression before......var clipcounterstatement = clipcounter.innerHTML.substring(3,clipcounter.innerHTML.length);
	
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
	/*
if(xmlhttp.responseText=='clip'){
	newclips = prevclips-1;
}
else if(xmlhttp.responseText=='unclip'){
	newclips = prevclips+1;
}

document.getElementById('clips').value = newclips;
clipcounter.innerHTML= "("+newclips+") Clipped properties";
*/
clipbutton.innerHTML = "<li class=\"options\" ><i class=\"black-icon\" id=\"like\"></i>"+xmlhttp.responseText+"</li>";

}
	else{
		clipbutton.innerHTML = "<li class=\"options\" ><i class=\"black-icon\" id=\"like\"></i>processing...</li>" ;
	}
}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
};
var url = "http://localhost/shelter/cta/c.php?p="+property+"&cb="+clipper;
xmlhttp.open("GET",url, true);
xmlhttp.send();
}
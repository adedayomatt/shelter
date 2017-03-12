function check(){
if(document.details.rent.value<0){
	alert("Rent cannot be negative");
	document.details.rent.focus();
	return false;
}
else if(document.details.type.value=="Select type"){
	alert("Select the type of property");
	document.details.type.focus();
	return false;
}
else{
	return true;
}
	
}
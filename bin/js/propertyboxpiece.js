/*...Then set another interval that will be calling a function that increases the opacity back*/
var appearRate = setInterval(appear,20);

/*This is the function that is being recalled every 50 millisecond to INCREASE the opacity*/
function appear(){
	
/*...until the opacity reaches 1 back before the image change*/
if(x==100){
		clearInterval(appearRate);
/*#2*/
		if(propertyImages[1] != imagesrc && propertyImages[1] !="" && 1>lastImageIndex){
		lastImageIndex = 1;
		changeImage(imageid,propertyImages[1]);
	}
	else if(propertyImages[2] != imagesrc && propertyImages[2] !="" && 2>lastImageIndex){
		lastImageIndex = 2;
		changeImage(imageid,propertyImages[2]);
	}
	else if(propertyImages[3] != imagesrc && propertyImages[3] !="" && 3>lastImageIndex){
		lastImageIndex = 3;
		changeImage(imageid,propertyImages[3]);
	}
	else{
		lastImageIndex = 0;
		changeImage(imageid,propertyImages[0]);
	}
	
}
	else{
		x++;
		imageElement.style.opacity = x/fullOpacity;
			}
		}

//
	
window.onscroll = function(event){
	var ele = document.getElementById('agents-snipet-top');
	var put = document.getElementById('agents-snipet-search');
	var headerHeight = document.getElementById('top-nav-bar-content').style.height;
	var windowOffset = window.pageYOffset;
	var snipetOffset = ele.offsetTop;
		if(snipetOffset-windowOffset <= 50){
			ele.style.position = 'fixed';
		}
		else{
			ele.style.position = 'relative';
			
		}
	}

/*
Slide function begins here

This function is called every 2 seconds by slides() and each call increases the value of i and evaluate its modulo against 3(number)
of the images in the slide so that the values will range between 0,1...(no of images) - 1 and assign it as index for the next image.
*/
var i = 2;var j = 1;var k = 0;
/*
This function calls the function imageslides() every 2 seconds
*/
function activateslide(){	
setInterval(imageslides,5000);
/*when the page loads. focus on the middle. CHALLENGE: it won't work for browsers that tha do not have javascript enabled*/
var bod= document.getElementById("mainproperty");
bod.focus();
}
function imageslides(){
var slides = ["resrc/image/images5.jpeg","resrc/image/images6.jpeg","resrc/image/images7.jpeg"];
var img= document.getElementById("pic");
var img2= document.getElementById("pic2");
var img3= document.getElementById("pic3");
img.src=slides[i];
img2.src=slides[j];
img3.src=slides[k];
i = (i+1)%3;
j = (j+1)%3;
k = (k+1)%3;;
}
/* Everything about slides ends here*/

/*----------------------------------------------------------------------------------------------------------------------------------------------*/

/* This function here is for toggling the side bar*/

function toggleSidebar(activatorId,response,arrow){
	//if the arrrow was down initially, change the class to up
 if($('#'+arrow).attr('class')=='arrow-down'){
		$('#'+arrow).attr({'class':'arrow-up','title':'Collapse'});
		$('#'+response).toggle();
			}
//else, otherwise
else if($('#'+arrow).attr('class')=='arrow-up'){
		$('#'+arrow).attr({'class':'arrow-down','title':'Expand'});
		$('#'+response).toggle();
	}	
}

function toggleall(){
	if($('#all-arrow').attr('class')=='arrow-down'){
		$('#all-arrow').attr({'class':'arrow-up','title':'Collapse all'});
		$('.arrow-down,.arrow-up').attr({'class':'arrow-up','title':'Collapse'});
		$('.dropdowns').show();
}
else if($('#all-arrow').attr('class')=='arrow-up'){
		$('#all-arrow').attr({'class':'arrow-down','title':'Expand all'});
		$('.arrow-up,.arrow-down').attr({'class':'arrow-down','title':'Expand'});
	$('.dropdowns').hide();
}
}
/*
Everything about the side bar toggles ends here
*/

/*----------------------------------------------------------------------------------------------------------------------------------------------*/




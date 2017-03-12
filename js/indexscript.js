
$(document).ready(function(){
	
});

var i = 2;var j = 1;var k = 0;
/*
This function is called every 2 seconds by slides() and each call increases the value of i and evaluate its modulo against 3(number)
of the images in the slide so that the values will range between 0,1...(no of images) - 1 and assign it as index for the next image.
*/
function imageslides(){
var slides = ["image/images5.jpeg","image/images6.jpeg","image/images7.jpeg"];
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
/*
This function calls the function im() every 2 seconds
*/
function activatescript(){
setInterval(imageslides,5000);
/*when the page loads. focus on the middle. CHALLENGE: it won't work for browsers that tha do not have javascript enabled*/
var bod= document.getElementById("mainproperty");
bod.focus();
}

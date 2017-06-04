
var mTop = 0;
window.onscroll = function(event){
var contentHeight  = document.getElementsByTagName("body")[0].clientHeight;
if(window.pageYOffset <= (contentHeight*2)){
	mTop = window.pageYOffset;
}
else{
	mTop =0;
}
document.getElementById("menu-ball").style.marginTop =  mTop + window.screen.height + "px";

}

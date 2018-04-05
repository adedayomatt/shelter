 var clipButtons = document.querySelectorAll("[data-action = 'clip']");
 for(var cb = 0; cb < clipButtons.length; cb++){
	 clip(clipButtons[cb]);
 }
 
function clip(clipbtn){
	clipbtn.addEventListener('click',function(event){
		event.preventDefault();
	var clipper = clipbtn.getAttribute('data-clipper');
	var ref = clipbtn.getAttribute('data-ref');
	var token = clipbtn.getAttribute('data-token');
	var propertyid = clipbtn.getAttribute('data-pid');
	
	var clipCounter = document.querySelector("[data-counter = 'clips']");
	
	clipbtn.setAttribute('title','just a moment...');
	clipbtn.setAttribute('data-loading-content','waiting');

 
 var sync = function(code,response){
	
	if(code == 204){
clipbtn.removeAttribute('data-loading-content');
	  //if the element the number of clipped is accesssible
if(clipCounter != null){
	//set the new number of clipped if clipped or unclip was successful
	if(response.substring(0,2)=='cl' || response.substring(0,2)=='un'){
clipCounter.innerHTML =  response.substring(response.indexOf('/')+1);
	}
	else{
clipCounter.innerHTML = "<span class=\"glyphicon glyphicon-alert\"></span>";
	}
}
//if clipped
if(response.substring(0,2)=='cl'){ 
clipbtn.className = 'unclip-button';
clipbtn.innerHTML = "<span class=\"glyphicon glyphicon-paperclip\"></span>  unclip";
clipbtn.setAttribute('title','clipped');
}
//if unclipped
else if(response.substring(0,2)=='un'){
clipbtn.className = 'clip-button';
clipbtn.innerHTML = "<span class=\"glyphicon glyphicon-paperclip\"></span>  clip";
clipbtn.setAttribute('title','unclipped');
	}
/*if neither clipped nor unclipped, then it must be that client is not checked in and the checkin form
**is returned, then pop it up!,...
**Debug:see the clip.php script */
else{
	modal = new Modal();
	modal.header = "<h4 class=\"text-center site-color\"><span class=\"glyphicon glyphicon-paperclip\"></span>  clip property</h4>";
	modal.content = response;
	modal.createModal();
	modal.showModal();
}
 }
 
}
var c = new useAjax(doc_root+"/resources/php/api/clip.php?p="+propertyid+"&cb="+clipper+"&ref="+ref+"&tkn="+token);
c.go(sync);  
	});
	
	  }
	  


window.onclick = function(event){
/*	for(i=0;i<2;++i){
 document.getElementsByClassName('suggested-agents-search-list')[i].innerHTML ='';
	}
	*/
	}
window.onscroll = function(event){
	//alert(window.pageYOffset);
	var ele = document.getElementById('agents-snipet-top');
	var put = document.getElementById('agents-snipet-search');
	var header = document.getElementById('top-nav-bar-content');
	var headerUnder = document.getElementById('top-nav-bar-under');
	var fixedhead = document.getElementById('fixed-head-after-scroll');
	var headercontainer = document.getElementById('top-nav-bar-container');
	var headerHeight = header.clientHeight;
	 if(window.pageYOffset >= headerHeight ){
//ele.style.marginTop = (window.pageYOffset - headerHeight)+'px';

//In mobile
document.getElementById('top-nav-bar-content-on-scroll').style.display = "block";
document.getElementById('top-nav-bar-content-on-scroll').style.position = "fixed";

}
else{
ele.style.marginTop = '0px';
//headercontainer.style.display = 'block';
document.getElementById('top-nav-bar-content-on-scroll').style.display = "none";
document.getElementsByClassName('agents-snipet-search-input')[0].value="";
 document.getElementById('mobile-head-search-container').style.display ='none';
  //document.getElementById('suggested-agents-search-list-mobile').style.display ='none';

  //document.getElementsByClassName('suggested-agents-search-list')[0].style.display ='none';

	}
		}
		
function showSearchAgent(){
	var agentSearchContainer = document.getElementById('mobile-head-search-container');
	if(agentSearchContainer.style.display != 'block'){
		agentSearchContainer.style.display = 'block';
		document.getElementById('toggle-search-agent-container-button').innerHTML ='&times';
		document.getElementById('toggle-search-agent-container-button').style.fontSize ='200%';
	}
	else{
		agentSearchContainer.style.display = 'none';
		 document.getElementById('suggested-agents-search-container-mobile').style.display ='none';
		 document.getElementById('toggle-search-agent-container-button').innerHTML ='search agent';
		 document.getElementById('toggle-search-agent-container-button').style.fontSize ='100%';

		
	}
}
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





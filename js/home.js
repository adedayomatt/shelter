//
	
window.onscroll = function(event){
	var ele = document.getElementById('agents-snipet-top');
	var put = document.getElementById('agents-snipet-search');
	var headerHeight = document.getElementById('top-nav-bar-content').clientHeight;
	 if(window.pageYOffset >= headerHeight){
ele.style.marginTop = window.pageYOffset+'px';
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




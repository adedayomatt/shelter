
$(document).ready(function(){
	var a = 0;
$('#expand-all').click(function(){
	
	
});

toggleSidebar('flats','flat-dropdown','flat-arrow');
toggleSidebar('sc','sc-dropdown','sc-arrow');
toggleSidebar('wings','wings-dropdown','wings-arrow');
toggleSidebar('others','others-dropdown','others-arrow');
toggleSidebar('sale','sale-dropdown','sale-arrow');
});

function toggleSidebar(activatorId,response,arrow){
	var tracker = 0;
	$('#'+activatorId).click(function(){
			tracker +=1;
	if((tracker%2)==1){
		$('#'+arrow).attr({'class':'arrow-up','title':'Collapse'});
		$('#'+response).toggle();
			}
else{
		$('#'+arrow).attr({'class':'arrow-down','title':'Expand'});
		$('#'+response).toggle();
	}
});
	
}
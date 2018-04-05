
var suggest_buttons = document.querySelectorAll("[data-action='suggest-property']");
for(var sp = 0; sp < suggest_buttons.length; sp++){
initiate_suggestion(suggest_buttons[sp]);
}	
function initiate_suggestion(b){
	
	b.addEventListener('click',function(event){
	var agentid = b.getAttribute('data-agent-id');
	var agent_bname = b.getAttribute('data-agent-business-name');
	var agent_username = b.getAttribute('data-agent-username');
	var token = b.getAttribute('data-agent-token');
	var clientname = b.getAttribute('data-client-name');
	var clientid = b.getAttribute('data-client-id');

popProperties = new Modal();
popProperties.header = "<h3 class=\"text-center\">Suggest property for "+clientname+"</h3>";
popProperties.createModal();
popProperties.showModal();
	
popProperties.contentHolder().setAttribute('data-loading-content','loading');

var getProperties = new useAjax(doc_root+"/resources/php/api/myproperties.php?aid="+agentid+"&aBn="+agent_bname+"&un="+agent_username+"&tkn="+token+"&client="+clientname+"&cid="+clientid);
getProperties.go(function(responseCode,responseText){
popProperties.contentHolder().innerHTML = "<div class=\"text-center\" id=\"loading-properties\">Loading your properties...</div>";

	if(responseCode == 204){
console.log("Response is now ready");
setTimeout(function(){
popProperties.contentHolder().removeAttribute('data-loading-content');
popProperties.contentHolder().innerHTML = responseText;
initiate_one_click_suggest();},2000);

	}
});
	});
}

function initiate_one_click_suggest(){
var one_click_suggest_btns = document.querySelectorAll('.one-click-suggest');
for(var s = 0; s < one_click_suggest_btns.length; s++){
suggest(one_click_suggest_btns[s]);
}
}

function suggest(s){
	var b = s.querySelector('button.suggest-btn');
	var suggestionStatus = s.querySelector('p.suggestion-status');
	b.addEventListener('click',function(event){
		var propertyid = b.getAttribute('data-pid');
		var propertydir = b.getAttribute('data-pdir');
		var agent_bname = b.getAttribute('data-agent-name');
		var agent_username = b.getAttribute('data-agent-username');
		var agentid = b.getAttribute('data-agent-id');
		var agenttoken = b.getAttribute('data-agent-token');
		var clientname = b.getAttribute('data-client-name');
		var clientid = b.getAttribute('data-client-id');
		
var suggestProperty = new useAjax(doc_root+"/resources/php/api/suggestproperty.php?client="+clientname+"&cid="+clientid+"&pid="+propertyid+"&pdir="+propertydir+"&ag_Bname="+agent_bname+"&ag_name="+agent_username+"&aid="+agentid+"&tkn="+agenttoken);
suggestProperty.go(function(responseCode,responseText){
b.setAttribute('data-loading-content','waiting');
	if(responseCode == 204){
		b.removeAttribute('data-loading-content');
		
		if(responseText == 'undo suggestion'){
		b.innerHTML = responseText;
		b.setAttribute('data-suggested','true');
		suggestionStatus.innerHTML = 'Already Suggested!';
		}
		else if(responseText == 'suggest'){
		b.innerHTML = responseText;
		b.setAttribute('data-suggested','false');
		suggestionStatus.innerHTML = 'Suggestion Undone!';
		}
		else{
			b.innerHTML = responseText;
			suggestionStatus.innerHTML = 'Failed!';
		}
	}

		});
	});
}

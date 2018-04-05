var followElements = document.querySelectorAll("[data-action='follow']");
for(var fe = 0; fe<followElements.length; fe++){
	follow(followElements[fe]);
}
function follow(followbtn){
followbtn.addEventListener('click',function(event){
	//event.preventDefault();
	var followerid = followbtn.getAttribute("data-flwerId");
	var follower_name = followbtn.getAttribute("data-flwerName");
	var follower_username = followbtn.getAttribute("data-flwerUname");
	var followingid = followbtn.getAttribute("data-flwingId");
	var following_name = followbtn.getAttribute("data-flwingName");
	var following_username = followbtn.getAttribute("data-flwingUname");
	var type = followbtn.getAttribute("data-ftype");
	var followCounter = document.querySelector("[data-counter='followings']");
		
		followbtn.setAttribute('data-loading-content','waiting');

var f = new useAjax(doc_root+"/resources/php/api/follow.php?flwerId="+followerid+"&flwer="+follower_name+"&flwerUname="+follower_username+"&flwingId="+followingid+"&flwing="+following_name+"&flwingUname="+following_username+"&t="+type);
f.go(function(code,response){
	if(code == 204){
	followbtn.removeAttribute('data-loading-content');

	if(response.substring(0,2)=='po' || response.substring(0,2)=='ne'){	
		if(response.substring(0,2)=='po'){
						followbtn.className = 'unfollow-button';
			followbtn.innerHTML = "<span class=\"glyphicon glyphicon-minus-sign\"></span> unfollow";
		}
		else if(response.substring(0,2)=='ne'){
			followbtn.className = 'follow-button';
			followbtn.innerHTML = "<span class=\"glyphicon glyphicon-plus-sign\"></span> follow";
					}
		followCounter.innerHTML =  response.substring(response.indexOf('/')+1);

				}
				else{
						modal = new Modal();
						modal.header = "<h4 class=\"text-center site-color\"><span class=\"glyphicon glyphicon-plus-sign\"></span>  Follow "+following_name+"</h4>";
						modal.content = response;
						modal.createModal();
						modal.showModal();
				}
			}
	
	});
});
	
}
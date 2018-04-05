

var propertyImages = document.querySelectorAll('img.property-images');
for(var pi = 0; pi< propertyImages.length ;pi++){
	pop_slides(propertyImages[pi]);
}
function pop_slides(img){
	var type = img.getAttribute('data-property-type');
	var location = img.getAttribute('data-property-location');
	var rent = img.getAttribute('data-property-rent');
	var dir = img.getAttribute('data-property-dir');
	img.addEventListener('click',function(event){
		get_images = new useAjax(doc_root+'/resources/php/api/image_slider.php?r='+rent+'&dir='+dir);
		get_images.go(function(responseCode,responseText){
				if(responseCode == 204){
					var modal = new Modal();
					modal.header = "<div class=\"padding-0-10\"><h4 class=\"text-left\">"+type+"</h4><p class=\"text-left\"><span class=\"glyphicon glyphicon-map-marker site-color\"></span>  "+location+"</p></div>";
					modal.content = responseText;
					modal.createModal();
					modal.showModal();
				}
		});

	});
}
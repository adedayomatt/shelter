function togglecontact(activator,contacts){
	$(document).ready(function(){
		$('#'.activator).click(function(){
			$('#'.contacts).toggle();
		});
		
	});
}
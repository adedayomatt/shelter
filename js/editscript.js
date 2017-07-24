$(document).ready(function(){
	    toggleEdit('add-photo-link','add-photo-box');
		toggleEdit('editrent_link','editrent_box');
		toggleEdit('editmp_link','editmp_box');
		toggleEdit('editdescription_link','editdescription_box');
		toggleEdit('editelectricity_link','editelectricity_box');
		toggleEdit('editroad_link','editroad_box');
		toggleEdit('editsocial_link','editsocial_box');
		toggleEdit('editsecurity_link','editsecurity_box');
		
		
	});
	function toggleEdit(link,box){
		$('#'+link).click(function(){
			$('#'+box).toggle();
		});
	}
	function deleteP(){
		alert("you want to delete");
	}
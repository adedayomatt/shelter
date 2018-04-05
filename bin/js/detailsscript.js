$(document).ready(function(){
	showInfo();
	showFacilities();
	showContacts();
	
	var bar_height = 300;
	var E_percent = $('#electricity-value').attr('value');
	var E_display_equivalent =((E_percent/100)*bar_height);
	var E_wiped_area = bar_height - E_display_equivalent;
	$('#electricity-wiped').css({'height':E_wiped_area});
	
	var R_percent = $('#road-value').attr('value');
	var R_display_equivalent =((R_percent/100)*bar_height);
	var R_wiped_area = bar_height - R_display_equivalent;
	$('#road-wiped').css({'height':R_wiped_area});
	
	var SE_percent = $('#security-value').attr('value');
	var SE_display_equivalent =((SE_percent/100)*bar_height);
	var SE_wiped_area = bar_height - SE_display_equivalent;
	$('#security-wiped').css({'height':SE_wiped_area});
	
	var SO_percent = $('#social-value').attr('value');
	var SO_display_equivalent =((SO_percent/100)*bar_height);
	var SO_wiped_area = bar_height - SO_display_equivalent;
	$('#social-wiped').css({'height':SO_wiped_area});
	
	
});	
	
	
function showInfo(){
	
	$('#tab1').click(function(){
		$('#tab1').css("border-bottom","white" );
		$('#tab2,#tab3').css("border-bottom","5px solid #6D0AAA");
		$('#info').show();
		$('#rating,#agent-contacts').hide();
	});
}
function showFacilities(){
$('#tab2,#see-more').click(function(){
		$('#tab1,#tab3').css("border-bottom","5px solid #6D0AAA");
		$('#tab2').css("border-bottom","white");
		$('#rating').show();
		$('#info,#agent-contacts').hide();
});
}
	function showContacts(){
		$('#tab3,#contact-agent').click(function(){
		$('#tab1,#tab2').css("border-bottom","5px solid #6D0AAA");
		$('#tab3').css("border-bottom","white");
		$('#agent-contacts').toggle();
	});
	}

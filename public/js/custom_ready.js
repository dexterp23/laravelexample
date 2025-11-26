
$(document).ready(function() {
	
	//form validate
	$("#form").validate();
	$("#form_2").validate();
	$("#login_form").validate();
	
	$(".dugme_submit").click(function() {
		if ($("#form").valid() == true) {
			mouseLoader_2();
			document.getElementById('form').submit();
		}
		return false;
	});
	
	$(".form_2_submit").click(function() {
		if ($("#form_2").valid() == true) document.getElementById('form_2').submit();
		return false;
	});
	
	$('.bs-tooltip').tooltip({
		container: 'body'
	});
	
});



$(document).keyup(function(e) {
	
	if (e.keyCode == 27) modalClose ('#dModal', '#sys_messages_popup');
	
});
			
			
$(window).resize(function() {


						  
});




























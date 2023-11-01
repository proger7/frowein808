jQuery(document).ready(function($) {
	$("#search-form-header, #search-close").hide();
	jQuery(document).on('click', '#search-menu', function(){
		$('#search-form-header').toggle("slow");
		$('#site-navigation, #search-menu').hide();
		$('#search-close').show();
	});
	jQuery(document).on('click', '#search-close', function() {
		$('#site-navigation, #search-menu').show();
		$('#search-close, #search-form-header').hide();
	});
});
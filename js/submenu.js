jQuery(document).ready(function($) {

	$('.search-button').click(function() {
	  $('.search input').toggle({ direction: "left" }, 1000);
	});
		
	$('.nav-main').hide();


	$('nav .top-menu li').hover(function(){
		if($(this).hasClass('has-submenu')) {
			$('.nav-main').show();
		} else {
			$('.nav-main').slideUp('slow');
		}
	});


	$("nav .top-menu li").click(function() {
		if($(this).hasClass('has-submenu')) {
			$('.nav-main').toggle('slow');
		}
	});
	$('#closeIcon').click(function(){
		$('.openSubmenu').addClass('d-none');
		$('nav .top-menu').removeClass('d-none');
		$('.nav-main').slideUp('slow');
	});

	$('.nav-main').mouseleave(function(){
		$('.nav-main').slideUp('slow');
	});

});
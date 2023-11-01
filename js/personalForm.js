jQuery(document).ready(function($) {
	$(".psid-1").addClass('visually-hidden');
	$(".psid-3").addClass('visually-hidden');
	jQuery(document).on('click', '.pid-1', function(){
		$('.inp-1').addClass('form-control').removeClass('form-control-plaintext').removeAttr('readonly');
		$(".pid-1").addClass('visually-hidden');
		$(".psid-1").removeClass('visually-hidden');
	});
	jQuery(document).on('click', '.psid-1', function() {
		$('.inp-1').addClass('form-control-plaintext').removeClass('form-control').attr('readonly', true);
		$(".pid-1").removeClass('visually-hidden');
		$(".psid-1").addClass('visually-hidden');
	});

	jQuery(document).on('click', '.pid-3', function(){
		$('.inp-3').addClass('form-control').removeClass('form-control-plaintext').removeAttr('readonly');
		$(".pid-3").addClass('visually-hidden');
		$(".psid-3").removeClass('visually-hidden');
	});
	jQuery(document).on('click', '.psid-3', function() {
		$('.inp-3').addClass('form-control-plaintext').removeClass('form-control').attr('readonly', true);
		$(".pid-3").removeClass('visually-hidden');
		$(".psid-3").addClass('visually-hidden');
	});
});
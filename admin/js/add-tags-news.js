jQuery(document).ready(function($) {




	$("input[name='save[news_tags]']").tagsInput({
		'width':'100%',
		'height':'100px',
		'interactive':true,
		'defaultText':'',
		'delimiter': [',',';', ' '],
		'removeWithBackspace' : true,
		'placeholderColor' : '#e3001b'
	});
	// $("input[name='save[product_tags]']").tagsInput({
	// 	'width':'100%',
	// 	'height':'100px',
	// 	'interactive':true,
	// 	'defaultText':'',
	// 	'delimiter': [',',';', ' '],
	// 	'removeWithBackspace' : true,
	// 	'placeholderColor' : '#e3001b'
	// });
	
});
/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */


CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
		config.language = 'de';
		// config.uiColor = '#AADC6E';
		config.extraPlugins = 'imagebrowser';
		config.filebrowserUploadUrl = '../../../upload_sce.php';
		config.filebrowserBrowseUrl = '/admin/js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
		config.filebrowserUploadUrl = '/admin/js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
		config.filebrowserImageBrowseUrl = '/admin/js/filemanager/dialog.php?type=1&editor=ckeditor&fldr=',
		config.filebrowserUploadMethod = 'form';
};

/*
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
		config.language = 'de';
		// config.uiColor = '#AADC6E';
		config.extraPlugins = 'imagebrowser';
		config.filebrowserUploadUrl = '../../../upload_sce.php';
		config.filebrowserBrowseUrl = '/admin/js/ckfinder/ckfinder.html',
		config.filebrowserUploadUrl = '/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
		config.filebrowserUploadMethod = 'form';
};
*/




/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */


/*
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{name: 'clipboard', groups: ['clipboard', 'undo']},
		{name: 'editing', groups: ['find', 'selection', 'spellchecker']},
		{name: 'links'},
		{name: 'insert'},
		{name: 'forms'},
		{name: 'tools'},
		{name: 'document', groups: ['mode', 'document', 'doctools']},
		{name: 'others'},
		'/',
		{name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
		{name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
		{name: 'styles'},
		{name: 'colors'},
		{name: 'about'}
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.filebrowserImageUploadUrl = '/js/ckeditor/php/imageupload.php';
	config.filebrowserImageBrowseUrl = '/js/ckeditor/php/imagebrowse.php';
	config.filebrowserUploadMethod = 'form';


}*/
/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'slideshow,insertpre,codesnippet,widget,lineutils,liststyle,tab';

	//config.extraAllowedContent = 'div(*);data-toggle[*]{*};span;ul;li;table;i;td;style;*[id];*(*);*{*}';	doesn't work
};

CKEDITOR.config.allowedContent = true; 

//CKEDITOR.config.extraAllowedContent = 'div(*);data-toggle[*]{*};span;ul;li;table;i;td;style;*[id];*(*);*{*}';	doesn't work
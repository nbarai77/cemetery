/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl 		= '/js/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl 	= '/js/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserFlashBrowseUrl 	= '/js/ckfinder/ckfinder.html?Type=Flash';
	config.filebrowserUploadUrl 		= '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl 	= '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl 	= '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	
	config.toolbar_MyToolBar =
    [
        [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ],
        [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ],
        [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ],
        '/',
        [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ],
        '/',
        [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ],
[ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ],
        [ 'Link','Unlink','Anchor' ],
        '/',
        [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ],
        '/',
        [ 'Styles','Format','Font','FontSize' ],
        [ 'TextColor','BGColor' ],
        [ 'Maximize', 'ShowBlocks','-','About' ]
    ];
	
};


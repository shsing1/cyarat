/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.height = '400';
	
	config.skin = 'office2003';
	
	config.toolbar = 'MyToolbar';

    config.toolbar_MyToolbar =
    [
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','Find','Replace','-','RemoveFormat'],
		['Link','Unlink','-','Image','Flash','Table'],
		['Maximize','-','Source'],
		'/',
		['Format','FontSize'],
		['Bold','Italic','Underline'],
		['NumberedList','BulletedList','-','Outdent','Indent'],
		['JustifyLeft','JustifyCenter','JustifyRight'],
		['TextColor','BGColor']
    ];
	
 	config.toolbar_MyBasic =
    [
        ['Bold','Italic','Underline','-','Format','FontSize','TextColor','BGColor','-','Smiley','Link','Unlink','Image','Flash','Table'],
		'/',
		['JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList','-','Outdent','Indent']
    ];
};

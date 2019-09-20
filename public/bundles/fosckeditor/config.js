/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Source,Save,Templates,Cut,Undo,Find,SelectAll,Scayt,Form,NumberedList,CopyFormatting,Outdent,Blockquote,JustifyLeft,BidiLtr,Link,Image,FontSize,TextColor,Maximize,About,BGColor,ShowBlocks,RemoveFormat,BulletedList,Indent,CreateDiv,JustifyCenter,BidiRtl,Unlink,Flash,JustifyRight,Language,Anchor,Table,JustifyBlock,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Replace,Redo,Copy,Paste,PasteText,PasteFromWord,NewPage,Preview,Print';
};

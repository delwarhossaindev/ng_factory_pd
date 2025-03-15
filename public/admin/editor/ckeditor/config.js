/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    
    config.extraPlugins = ['youtube','codesnippet','wordcount','cssanim','liststyle','spacingsliders','slideshow','pre'];
   
    config.codeSnippet_theme = 'pojoaque';

	config.filebrowserBrowseUrl = '/admin/editor/kcfinder/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = '/admin/editor/kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = '/admin/editor/kcfinder/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = '/admin/editor/kcfinder/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = '/admin/editor/kcfinder/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = '/admin/editor/kcfinder/upload.php?opener=ckeditor&type=flash';
};

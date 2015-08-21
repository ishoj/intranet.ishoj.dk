/**
 * @file MY_MODULE_ckeditor_config.js
 *
 * Custom configuration for CKEditor.
 */
 
/**
 * Set up custom configurations for the CKEditor editor.
 */
CKEDITOR.editorConfig = function( config )
{
  // config.styleSet is an array of objects that define each style available
  // in the font styles tool in the ckeditor toolbar
  config.stylesSet =
  [
        /* Block Styles */
 
        // Each style is an object whose properties define how it is displayed
        // in the dropdown, as well as what it outputs as html into the editor
        // text area.
        { name : 'Paragraph'   , element : 'p' },
        { name : 'Heading 4'   , element : 'h4' },
        { name : 'Heading 5'   , element : 'h5' },
        { name : 'Heading 6'   , element : 'h6' },
   ];
}

<?php
/**
 * @file
 * os2web_hearings.strongarm.inc
 */

/**
 * Implements hook_strongarm().
 */
function os2web_hearings_strongarm() {
  $export = array();

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'date_format_kun_dato';
  $strongarm->value = 'd';
  $export['date_format_kun_dato'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'language_content_type_os2web_hearings_hearing';
  $strongarm->value = '0';
  $export['language_content_type_os2web_hearings_hearing'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'menu_options_os2web_hearings_hearing';
  $strongarm->value = array(
    0 => 'menu-indholdsmenu',
  );
  $export['menu_options_os2web_hearings_hearing'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'menu_parent_os2web_hearings_hearing';
  $strongarm->value = 'main-menu:0';
  $export['menu_parent_os2web_hearings_hearing'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'node_options_os2web_hearings_hearing';
  $strongarm->value = array(
    0 => 'status',
  );
  $export['node_options_os2web_hearings_hearing'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'node_preview_os2web_hearings_hearing';
  $strongarm->value = '0';
  $export['node_preview_os2web_hearings_hearing'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'node_submitted_os2web_hearings_hearing';
  $strongarm->value = 0;
  $export['node_submitted_os2web_hearings_hearing'] = $strongarm;

  return $export;
}

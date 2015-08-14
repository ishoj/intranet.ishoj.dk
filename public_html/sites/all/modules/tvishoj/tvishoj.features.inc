<?php
/**
 * @file
 * tvishoj.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function tvishoj_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function tvishoj_node_info() {
  $items = array(
    'tvishoj_indslag' => array(
      'name' => t('TV-Ishøj indslag'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}

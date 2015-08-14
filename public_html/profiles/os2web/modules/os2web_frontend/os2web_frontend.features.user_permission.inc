<?php
/**
 * @file
 * os2web_frontend.features.user_permission.inc
 */

/**
 * Implements hook_user_default_permissions().
 */
function os2web_frontend_user_default_permissions() {
  $permissions = array();

  // Exported permission: administer delta.
  $permissions['administer delta'] = array(
    'name' => 'administer delta',
    'roles' => array(),
    'module' => 'delta_ui',
  );

  return $permissions;
}

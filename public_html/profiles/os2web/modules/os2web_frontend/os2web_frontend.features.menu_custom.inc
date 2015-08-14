<?php
/**
 * @file
 * os2web_frontend.features.menu_custom.inc
 */

/**
 * Implements hook_menu_default_menu_custom().
 */
function os2web_frontend_menu_default_menu_custom() {
  $menus = array();

  // Exported menu: os2web-main-menu.
  $menus['os2web-main-menu'] = array(
    'menu_name' => 'os2web-main-menu',
    'title' => 'Main menu',
    'description' => 'The <em>Main</em> menu is used on many sites to show the major sections of the site, often in a top navigation bar.',
  );
  // Exported menu: os2web-menu-business-shortcuts.
  $menus['os2web-menu-business-shortcuts'] = array(
    'menu_name' => 'os2web-menu-business-shortcuts',
    'title' => 'Din kommune',
    'description' => 'Spørgsmål om din kommune',
  );
  // Exported menu: os2web-menu-contentmenu.
  $menus['os2web-menu-contentmenu'] = array(
    'menu_name' => 'os2web-menu-contentmenu',
    'title' => 'Indholdsmenu',
    'description' => '',
  );
  // Exported menu: os2web-menu-other-sites.
  $menus['os2web-menu-other-sites'] = array(
    'menu_name' => 'os2web-menu-other-sites',
    'title' => 'Andre netsteder',
    'description' => '',
  );
  // Exported menu: os2web-menu-user.
  $menus['os2web-menu-user'] = array(
    'menu_name' => 'os2web-menu-user',
    'title' => 'User menu',
    'description' => 'The <em>User</em> menu contains links related to the user\'s account, as well as the \'Log out\' link.',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Andre netsteder');
  t('Din kommune');
  t('Indholdsmenu');
  t('Main menu');
  t('Spørgsmål om din kommune');
  t('The <em>Main</em> menu is used on many sites to show the major sections of the site, often in a top navigation bar.');
  t('The <em>User</em> menu contains links related to the user\'s account, as well as the \'Log out\' link.');
  t('User menu');


  return $menus;
}

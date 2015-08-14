<?php
/**
 * @file
 * os2web_frontend.features.menu_links.inc
 */

/**
 * Implements hook_menu_default_menu_links().
 */
function os2web_frontend_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: os2web-menu-business-shortcuts:contact
  $menu_links['os2web-menu-business-shortcuts:contact'] = array(
    'menu_name' => 'os2web-menu-business-shortcuts',
    'link_path' => 'contact',
    'router_path' => 'contact',
    'link_title' => 'Kontakt',
    'options' => array(),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -50,
  );
  // Exported menu link: os2web-menu-business-shortcuts:nyheder
  $menu_links['os2web-menu-business-shortcuts:nyheder'] = array(
    'menu_name' => 'os2web-menu-business-shortcuts',
    'link_path' => 'nyheder',
    'router_path' => 'nyheder',
    'link_title' => 'Nyheder',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
      'alter' => FALSE,
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -49,
  );
  // Exported menu link: os2web-menu-business-shortcuts:selvbetjening
  $menu_links['os2web-menu-business-shortcuts:selvbetjening'] = array(
    'menu_name' => 'os2web-menu-business-shortcuts',
    'link_path' => 'selvbetjening',
    'router_path' => 'selvbetjening',
    'link_title' => 'Selvbetjening',
    'options' => array(),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -48,
  );
  // Exported menu link: os2web-menu-user:admin/workbench
  $menu_links['os2web-menu-user:admin/workbench'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'admin/workbench',
    'router_path' => 'admin/workbench',
    'link_title' => 'Workbench',
    'options' => array(
      'minipanel' => '',
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -50,
  );
  // Exported menu link: os2web-menu-user:node/add/esdh-dokument
  $menu_links['os2web-menu-user:node/add/esdh-dokument'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/esdh-dokument',
    'router_path' => 'node/add',
    'link_title' => 'Opret ESDH dokument',
    'options' => array(
      'minipanel' => '',
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 1,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -44,
  );
  // Exported menu link: os2web-menu-user:node/add/esdh-sag
  $menu_links['os2web-menu-user:node/add/esdh-sag'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/esdh-sag',
    'router_path' => 'node/add',
    'link_title' => 'Opret ESDH sag',
    'options' => array(
      'minipanel' => '',
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 1,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -45,
  );
  // Exported menu link: os2web-menu-user:node/add/os2web-base-contentpage
  $menu_links['os2web-menu-user:node/add/os2web-base-contentpage'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/os2web-base-contentpage',
    'router_path' => 'node/add/os2web-base-contentpage',
    'link_title' => '+indhold',
    'options' => array(
      'minipanel' => '',
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -47,
  );
  // Exported menu link: os2web-menu-user:node/add/os2web-base-gallery
  $menu_links['os2web-menu-user:node/add/os2web-base-gallery'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/os2web-base-gallery',
    'router_path' => 'node/add/os2web-base-gallery',
    'link_title' => '+galleri',
    'options' => array(
      'minipanel' => '',
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -46,
  );
  // Exported menu link: os2web-menu-user:node/add/os2web-base-iframe
  $menu_links['os2web-menu-user:node/add/os2web-base-iframe'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/os2web-base-iframe',
    'router_path' => 'node/add/os2web-base-iframe',
    'link_title' => '+iframe/selvbetjeningsløsning m.m.',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -45,
  );
  // Exported menu link: os2web-menu-user:node/add/os2web-base-news
  $menu_links['os2web-menu-user:node/add/os2web-base-news'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/os2web-base-news',
    'router_path' => 'node/add/os2web-base-news',
    'link_title' => '+nyhed',
    'options' => array(
      'minipanel' => '',
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -48,
  );
  // Exported menu link: os2web-menu-user:node/add/os2web-base-rotating-image
  $menu_links['os2web-menu-user:node/add/os2web-base-rotating-image'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/os2web-base-rotating-image',
    'router_path' => 'node/add/os2web-base-rotating-image',
    'link_title' => '+billedkarrusel',
    'options' => array(
      'minipanel' => '',
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -49,
  );
  // Exported menu link: os2web-menu-user:node/add/os2web-contact-contact
  $menu_links['os2web-menu-user:node/add/os2web-contact-contact'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/os2web-contact-contact',
    'router_path' => 'node/add',
    'link_title' => '+kontaktblok',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -43,
  );
  // Exported menu link: os2web-menu-user:node/add/os2web-spotbox-box
  $menu_links['os2web-menu-user:node/add/os2web-spotbox-box'] = array(
    'menu_name' => 'os2web-menu-user',
    'link_path' => 'node/add/os2web-spotbox-box',
    'router_path' => 'node/add',
    'link_title' => '+spotboks',
    'options' => array(
      'attributes' => array(
        'title' => '',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -44,
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('+billedkarrusel');
  t('+galleri');
  t('+iframe/selvbetjeningsløsning m.m.');
  t('+indhold');
  t('+kontaktblok');
  t('+nyhed');
  t('+spotboks');
  t('Kontakt');
  t('Nyheder');
  t('Opret ESDH dokument');
  t('Opret ESDH sag');
  t('Selvbetjening');
  t('Workbench');


  return $menu_links;
}

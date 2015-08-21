<?php
/**
 * @file
 * os2intra_user_import.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function os2intra_user_import_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'os2intra_user_import';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'users';
  $view->human_name = 'OS2Intra user import';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'OS2Intra user import';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['use_more_text'] = 'mere';
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['access']['perm'] = 'access user profiles';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['exposed_form']['options']['submit_button'] = 'Udfør';
  $handler->display->display_options['exposed_form']['options']['reset_button_label'] = 'Gendan';
  $handler->display->display_options['exposed_form']['options']['exposed_sorts_label'] = 'Sortér efter';
  $handler->display->display_options['exposed_form']['options']['sort_asc_label'] = 'Stigende';
  $handler->display->display_options['exposed_form']['options']['sort_desc_label'] = 'Faldende';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '50';
  $handler->display->display_options['pager']['options']['expose']['items_per_page_label'] = 'Antal elementer';
  $handler->display->display_options['pager']['options']['expose']['items_per_page_options_all_label'] = '- Alle -';
  $handler->display->display_options['pager']['options']['expose']['offset_label'] = 'Forskydning';
  $handler->display->display_options['pager']['options']['tags']['first'] = '« første';
  $handler->display->display_options['pager']['options']['tags']['previous'] = '‹ forrige';
  $handler->display->display_options['pager']['options']['tags']['next'] = 'næste ›';
  $handler->display->display_options['pager']['options']['tags']['last'] = 'sidste »';
  $handler->display->display_options['style_plugin'] = 'table';
  $handler->display->display_options['style_options']['columns'] = array(
    'views_bulk_operations' => 'views_bulk_operations',
    'field_os2intra_employee_id' => 'field_os2intra_employee_id',
    'field_name_first' => 'field_name_first',
    'field_name_last' => 'field_name_last',
    'name' => 'name',
    'mail' => 'mail',
    'field_os2intra_termination_date' => 'field_os2intra_termination_date',
    'login' => 'login',
    'status' => 'status',
  );
  $handler->display->display_options['style_options']['default'] = '-1';
  $handler->display->display_options['style_options']['info'] = array(
    'views_bulk_operations' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_os2intra_employee_id' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_name_first' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_name_last' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'name' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'mail' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_os2intra_termination_date' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'login' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'status' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
  );
  /* Felt: Masse-handlinger: Bruger */
  $handler->display->display_options['fields']['views_bulk_operations']['id'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['table'] = 'users';
  $handler->display->display_options['fields']['views_bulk_operations']['field'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['display_type'] = '0';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['enable_select_all_pages'] = 1;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['force_single'] = 0;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['entity_load_capacity'] = '10';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_operations'] = array(
    'action::user_block_user_action' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 1,
      'override_label' => 0,
      'label' => '',
    ),
    'action::views_bulk_operations_user_roles_action' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
    'action::views_bulk_operations_modify_action' => array(
      'selected' => 1,
      'postpone_processing' => 0,
      'skip_confirmation' => 1,
      'override_label' => 1,
      'label' => 'Aktiver/Bloker',
      'settings' => array(
        'show_all_tokens' => 1,
        'display_values' => array(
          'status' => 'status',
        ),
      ),
    ),
    'action::pathauto_user_update_action' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
    'action::views_bulk_operations_argument_selector_action' => array(
      'selected' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
      'settings' => array(
        'url' => '',
      ),
    ),
    'action::system_send_email_action' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
    'action::panelizer_set_status_action' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
    'action::views_bulk_operations_delete_item' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
    'action::flag_user_action' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
    'action::views_bulk_operations_script_action' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
    'action::realname_action_realname_update' => array(
      'selected' => 0,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
  );
  /* Felt: Bruger: MedarbejderID */
  $handler->display->display_options['fields']['field_os2intra_employee_id']['id'] = 'field_os2intra_employee_id';
  $handler->display->display_options['fields']['field_os2intra_employee_id']['table'] = 'field_data_field_os2intra_employee_id';
  $handler->display->display_options['fields']['field_os2intra_employee_id']['field'] = 'field_os2intra_employee_id';
  $handler->display->display_options['fields']['field_os2intra_employee_id']['label'] = 'Medarbejder nr.';
  /* Felt: Bruger: First Name */
  $handler->display->display_options['fields']['field_name_first']['id'] = 'field_name_first';
  $handler->display->display_options['fields']['field_name_first']['table'] = 'field_data_field_name_first';
  $handler->display->display_options['fields']['field_name_first']['field'] = 'field_name_first';
  $handler->display->display_options['fields']['field_name_first']['label'] = 'Fornavn';
  /* Felt: Bruger: Last Name */
  $handler->display->display_options['fields']['field_name_last']['id'] = 'field_name_last';
  $handler->display->display_options['fields']['field_name_last']['table'] = 'field_data_field_name_last';
  $handler->display->display_options['fields']['field_name_last']['field'] = 'field_name_last';
  $handler->display->display_options['fields']['field_name_last']['label'] = 'Efternavn';
  /* Felt: Bruger: Navn */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'users';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['label'] = '';
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = FALSE;
  /* Felt: Bruger: E-mail */
  $handler->display->display_options['fields']['mail']['id'] = 'mail';
  $handler->display->display_options['fields']['mail']['table'] = 'users';
  $handler->display->display_options['fields']['mail']['field'] = 'mail';
  /* Felt: Bruger: os2intra_termination_date */
  $handler->display->display_options['fields']['field_os2intra_termination_date']['id'] = 'field_os2intra_termination_date';
  $handler->display->display_options['fields']['field_os2intra_termination_date']['table'] = 'field_data_field_os2intra_termination_date';
  $handler->display->display_options['fields']['field_os2intra_termination_date']['field'] = 'field_os2intra_termination_date';
  $handler->display->display_options['fields']['field_os2intra_termination_date']['label'] = 'Fratrædelsesdato';
  $handler->display->display_options['fields']['field_os2intra_termination_date']['settings'] = array(
    'format_type' => 'short',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
  );
  /* Felt: Bruger: Seneste login */
  $handler->display->display_options['fields']['login']['id'] = 'login';
  $handler->display->display_options['fields']['login']['table'] = 'users';
  $handler->display->display_options['fields']['login']['field'] = 'login';
  $handler->display->display_options['fields']['login']['empty'] = 'aldrig';
  $handler->display->display_options['fields']['login']['date_format'] = 'os2web_base_date_only';
  /* Felt: Bruger: Aktiv */
  $handler->display->display_options['fields']['status']['id'] = 'status';
  $handler->display->display_options['fields']['status']['table'] = 'users';
  $handler->display->display_options['fields']['status']['field'] = 'status';
  $handler->display->display_options['fields']['status']['not'] = 0;
  /* Sorteringskriterie: Bruger: Oprettelsesdato */
  $handler->display->display_options['sorts']['created']['id'] = 'created';
  $handler->display->display_options['sorts']['created']['table'] = 'users';
  $handler->display->display_options['sorts']['created']['field'] = 'created';
  $handler->display->display_options['sorts']['created']['order'] = 'DESC';
  /* Filterkriterie: Bruger: MedarbejderID (field_os2intra_employee_id) */
  $handler->display->display_options['filters']['field_os2intra_employee_id_value']['id'] = 'field_os2intra_employee_id_value';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value']['table'] = 'field_data_field_os2intra_employee_id';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value']['field'] = 'field_os2intra_employee_id_value';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value']['operator'] = 'not empty';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value']['group'] = 1;
  /* Filterkriterie: Realname: Navn */
  $handler->display->display_options['filters']['realname']['id'] = 'realname';
  $handler->display->display_options['filters']['realname']['table'] = 'realname';
  $handler->display->display_options['filters']['realname']['field'] = 'realname';
  $handler->display->display_options['filters']['realname']['operator'] = 'contains';
  $handler->display->display_options['filters']['realname']['group'] = 1;
  $handler->display->display_options['filters']['realname']['exposed'] = TRUE;
  $handler->display->display_options['filters']['realname']['expose']['operator_id'] = 'realname_op';
  $handler->display->display_options['filters']['realname']['expose']['label'] = 'Navn';
  $handler->display->display_options['filters']['realname']['expose']['operator'] = 'realname_op';
  $handler->display->display_options['filters']['realname']['expose']['identifier'] = 'realname';
  $handler->display->display_options['filters']['realname']['expose']['remember_roles'] = array(
    2 => '2',
    1 => 0,
    4 => 0,
    7 => 0,
    5 => 0,
    8 => 0,
    3 => 0,
    6 => 0,
    9 => 0,
    10 => 0,
    11 => 0,
    12 => 0,
  );
  /* Filterkriterie: Bruger: MedarbejderID (field_os2intra_employee_id) */
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['id'] = 'field_os2intra_employee_id_value_1';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['table'] = 'field_data_field_os2intra_employee_id';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['field'] = 'field_os2intra_employee_id_value';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['group'] = 1;
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['exposed'] = TRUE;
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['expose']['operator_id'] = 'field_os2intra_employee_id_value_1_op';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['expose']['label'] = 'Medarbejder nr.';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['expose']['operator'] = 'field_os2intra_employee_id_value_1_op';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['expose']['identifier'] = 'field_os2intra_employee_id_value_1';
  $handler->display->display_options['filters']['field_os2intra_employee_id_value_1']['expose']['remember_roles'] = array(
    2 => '2',
    1 => 0,
    4 => 0,
    7 => 0,
    5 => 0,
    8 => 0,
    3 => 0,
    6 => 0,
    9 => 0,
    10 => 0,
    11 => 0,
    12 => 0,
  );

  /* Display: Over overview */
  $handler = $view->new_display('page', 'Over overview', 'page');
  $handler->display->display_options['path'] = 'admin/config/os2intra/user_import/overview';
  $translatables['os2intra_user_import'] = array(
    t('Master'),
    t('OS2Intra user import'),
    t('mere'),
    t('Udfør'),
    t('Gendan'),
    t('Sortér efter'),
    t('Stigende'),
    t('Faldende'),
    t('Antal elementer'),
    t('- Alle -'),
    t('Forskydning'),
    t('« første'),
    t('‹ forrige'),
    t('næste ›'),
    t('sidste »'),
    t('Bruger'),
    t('Medarbejder nr.'),
    t('Fornavn'),
    t('Efternavn'),
    t('E-mail'),
    t('Fratrædelsesdato'),
    t('Seneste login'),
    t('aldrig'),
    t('Aktiv'),
    t('Navn'),
    t('Over overview'),
  );
  $export['os2intra_user_import'] = $view;

  return $export;
}

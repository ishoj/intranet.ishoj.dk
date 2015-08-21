<?php
$users_query = db_query('SELECT u.entity_id FROM {field_data_field_os2intra_employee_id} u WHERE u.entity_id > :uid', array(':uid' => '3900'));
$result = $users_query->fetchAll();

foreach($result as $uid){
  error_log(print_r($uid->entity_id, 1));
  user_delete($uid->entity_id);
}

$query = db_query("SELECT * FROM `field_data_field_os2intra_department_id` WHERE `entity_type` = 'node'");
$result = $query->fetchAll();

foreach($result as $uid){
  error_log(print_r($uid->entity_id, 1));
  node_delete($uid->entity_id);
}



$query = db_query("SELECT * FROM `field_data_field_os2intra_department_id` WHERE `entity_type` = 'taxonomy_term'");
$result = $query->fetchAll();

foreach($result as $uid){
  error_log(print_r($uid->entity_id, 1));
  taxonomy_term_delete($uid->entity_id);
}


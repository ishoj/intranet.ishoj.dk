<?php

variable_get('os2intra_user_import_dir', 'private://user_import');

$realpath = '';

$dir = reset(file_scan_directory('private://user_import', '/.*\.csv$/'));
if($dir){
  $realpath = drupal_realpath($dir->uri);
}

if(file_exists($realpath)){
  $file = file_get_contents($realpath);

 $data = str_getcsv($file, "\n"); //parse the rows

  // CSV field mapping
  // rewrite for settings page?
  $map = array(
    5 => 'short',
    8 => 'long'
  );
  // Load data from file
  foreach($data as $row_str){
    $row = str_getcsv($row_str, ",");

    // Parse mapping
    foreach($row as $key => $field){
      // If there is a mapping for the key
      if($map[$key]){
        $mapped_row[$map[$key]] = $field;
      }
    }
    $rows[] = $mapped_row;
  }

  // Skip first row, headers
  unset($rows[0]);
}

foreach($rows as $row){
  $titles[$row['short']] = $row['long'];
}

$nodes = node_load_multiple(array(), array('type' => 'group'));

foreach ($nodes as $node){
  if($field = field_get_items('node', $node, 'field_os2intra_department_id')){
    error_log(print_r($node->title, 1));
    error_log(print_r($titles[$field[0]['value']], 1));
    $node->title = $titles[$field[0]['value']];

    node_save($node);
  }
}

$vocab = taxonomy_vocabulary_machine_name_load('os2intra_organizaiton_tax');
$tree = taxonomy_get_tree($vocab->vid);

foreach ($tree as $branch){
  $term = taxonomy_term_load($branch->tid);
  if($field = field_get_items('taxonomy_term', $term, 'field_os2intra_department_id')){
    error_log(print_r($term->name, 1));
    error_log(print_r($titles[$field[0]['value']], 1));
    $term->name = $titles[$field[0]['value']];

    taxonomy_term_save($term);
  }
}

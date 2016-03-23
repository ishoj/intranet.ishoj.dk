<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
$users = entity_load('user');
$user_names = array();
foreach ($users as $user_id => $user) {
$user_names[] = $user->name;
if ($user->field_kaldenavn['und'][0]['value'] == "") {
print "kaldenavn er tom" . "<br />";
print $user->name . "<br />";
if (!empty($user->field_fornavn['und'][0]['value'])) {
$existingUser = user_load($user->uid);  
$existingUser->field_kaldenavn['und'][0]['value'] = $user->field_fornavn['und'][0]['value'] . ' ' . $user->field_efternavn['und'][0]['value'];
//user_save((object) array('uid' => $existingUser->uid), (array) $existingUser);  
echo "HER!: " .  $existingUser->field_kaldenavn['und'][0]['value'] . "<br />";  
}
}    
}


?>
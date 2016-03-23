<?php
header('Content-Type: text/html; charset=utf-8');

define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


$users = entity_load('user');
$user_names = array();
foreach ($users as $user_id => $user) {
$user_names[] = $user->name;
if (strtolower($user->name) != $user->name){  
//if (strpos($user->mail,'2PE@ishoj.dk') !== false) {
echo $user->name . "<br />";
    echo $user->login . "<br />";
    if ($user->login == '0') {
$existingUser = user_load($user->uid);    
$existingUser->name = strtolower($user->name);
// save existing user
//user_save((object) array('uid' => $existingUser->uid), (array) $existingUser);
echo $existingUser->name . "<br />";    
}
//}    
 }   
}


?>
<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// Brugere, der skal springes over
$skip_users = array("admin", "skifter");

// Henter alle brugere med rolen 'Webredaktør'
$role = user_role_load_by_name('Webredaktør');
$uids = db_select('users_roles', 'ur')
  ->fields('ur', array('uid'))
  ->condition('ur.rid', $role->rid, '=')
  ->execute()
  ->fetchCol();
$accounts = user_load_multiple($uids);


//  ************************************************************************************  //
//  ************************************   FASE 1  *************************************  //
//  ************************************************************************************  //
//  For alle brugere, der har rollen 'Webredaktør' (undtagen brugere på udvalgt liste)    //
//  Sæt brugeraktiv = 0                                                                   //
//  Sæt adbruger = 0                                                                      //
//  ************************************************************************************  //
print "<h1>FASE 1 - alle brugere sættes til 'ikke-aktiv'</h1>";


$counter = 0;
foreach ($accounts as $account) {

  if(($counter > 0) and ($counter <= 500)) {
  // if(($counter > 500) and ($counter <= 1000)) {
  // if(($counter > 1000) and ($counter <= 1500)) {
  // if(($counter > 1500) and ($counter <= 2000)) {
  // if(($counter > 2000) and ($counter <= 2500)) {
  // if(($counter > 2500) and ($counter <= 3000)) {
  // if(($counter > 3000) and ($counter <= 3500)) {
  // if(($counter > 3500) and ($counter <= 4000)) {
  if(($counter > 4000)) {

    if (in_array($account->name, $skip_users)) {
      print "<strong>" . $account->name . "</strong> sprunget over<br /><br />";
    }
    else {
      if($account->uid == 0) {
        continue;
      }
      $edit['field_brugeraktiv']['und'][0]['value'] = 0;
      $edit['field_user_in_ad']['und'][0]['value'] = 0;
      // user_save($account, $edit);
      print "<strong>" . $account->name . "</strong> ændret til 'ikke-aktiv'<br /><br />";
    }

  }

  $counter++;
}



?>

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
//  Test om brugeraktiv = 0                                                               //
//  ************************************************************************************  //
print "<h1>Test af brugere</h1>";

$user_counter = 0;
foreach ($accounts as $account) {
  if (in_array($account->name, $skip_users)) {
    print "<strong>" . $account->name . "</strong> sprunget over<br /><br />";
  }
  else {
    if($account->uid == 0) {
      continue;
    }
    // test om aktiv
    if ($account->field_brugeraktiv['und'][0]['value'] == 1) {
      print "<strong>" . $account->name . "</strong> (". $account->field_medarbejderid['und'][0]['value'] . ") er 'aktiv'<br />";
    }
    else {
      print "<strong>" . $account->name . "</strong> (". $account->field_medarbejderid['und'][0]['value'] . ") er 'ikke-aktiv'<br />";
    }
    // test om AD-bruger
    if ($account->field_user_in_ad['und'][0]['value'] == 1) {
      print "<strong>" . $account->name . "</strong> er 'ad-bruger'<br /><br />";
    }
    else {
      print "<strong>" . $account->name . "</strong> er ikke 'ad-bruger'<br /><br />";
    }

  }
  $user_counter++;
}

print "<h2>Antal brugere: " . $user_counter . "</h2>";


?>

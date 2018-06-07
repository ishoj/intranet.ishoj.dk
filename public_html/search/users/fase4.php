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
//  ************************************   FASE 4  *************************************  //
//  ************************************************************************************  //
//  For alle brugere, der har brugeraktiv == 0 (undtagen brugere på udvalgt liste)        //
//  Disable bruger, dvs. $user->status = 0;                                               //
//  ************************************************************************************  //
//  Måske kan dette bruges: https://gist.github.com/hannesl/3864416
print "<h1>FASE 4 - deaktiverer ikke-aktive brugere</h1>";

$user_counter = 0;
foreach ($accounts as $account) {
  if (in_array($account->name, $skip_users)) {
    print "<strong>" . $account->name . "</strong> sprunget over<br /><br />";
  }
  else {
    if($account->uid == 0) {
      continue;
    }
    if(($user_counter > 0) and ($user_counter <= 1000)) {
    // if(($user_counter > 1000) and ($user_counter <= 2000)) {
    // if(($user_counter > 2000) and ($user_counter <= 3000)) {
    // if($user_counter > 3000) {
      // Hvis feltet 'brugeraktiv' = 0 (bruger er ikke aktiv bruger i KMD OPUS og skal disables)
      if ($account->field_brugeraktiv['und'][0]['value'] == 0) {
        $account->status = 0;
        // user_save($account);
        print "<strong>" . $account->name . "</strong> deaktiveret<br /><br />";
      }
    }
  }
  $user_counter++;
}



?>

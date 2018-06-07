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

// if(ini_get('safe_mode')) {
//    print "safe mode is on";
// }
// else {
//   print "safe mode is not on";
// }


$role = user_role_load_by_name("Deaktiveret");

//  ************************************************************************************  //
print "<h1>Deaktiverede brugere får tildelt rollen 'Deaktiveret'</h1>";


$counter = 0;
$deaktiveret = 0;
foreach ($accounts as $account) {

  if($counter > 0) {
  // if(($counter > 0) and ($counter <= 500)) {
  // if(($counter > 500) and ($counter <= 1000)) {
  // if(($counter > 1000) and ($counter <= 1500)) {
  // if(($counter > 1500) and ($counter <= 2000)) {
  // if(($counter > 2000) and ($counter <= 2500)) {
  // if(($counter > 2500) and ($counter <= 3000)) {
  // if(($counter > 3000) and ($counter <= 3500)) {
  // if(($counter > 3500) and ($counter <= 4000)) {
  // if(($counter > 4000)) {

    if (in_array($account->name, $skip_users)) {
      print "<strong>" . $account->name . "</strong> sprunget over<br /><br />";
    }
    else {
      if($account->uid == 0) {
        continue;
      }
      // Hvis bruger er deaktiveret (status == 0)
      if($account->status == 0) {
        user_multiple_role_edit(array($account->uid), 'add_role', $role->rid);
        print "<strong>" . $account->name . "</strong> tildelt rollen 'Deaktiveret'<br /><br />";
        $deaktiveret++;
      }
    }

  }
  $counter++;
}

print "<h2>" . $deaktiveret . " brugere fik tildelt rollen 'Deaktiveret'</h2>";

?>

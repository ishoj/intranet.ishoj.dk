<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// Filer, der skal hentes data fra
// $ad_fil = file_get_contents('ad.csv');
// $opus_fil = file_get_contents('kmdopus.csv'); // echo utf8_encode($opus_fil);

// Brugere, der skal springes over
$skip_users = array("admin", "skifter");
// $skip_ad_users = array("tho", "jvm", "thk");

// Henter alle brugere med rolen 'Webredaktør'
$role = user_role_load_by_name('Webredaktør');
$uids = db_select('users_roles', 'ur')
  ->fields('ur', array('uid'))
  ->condition('ur.rid', $role->rid, '=')
  ->execute()
  ->fetchCol();
$accounts = user_load_multiple($uids);


//  ************************************************************************************  //
//  ************************************************************************************  //
//  For alle brugere, der har rollen 'Webredaktør' (undtagen brugere på udvalgt liste)    //
//  Sæt brugeraktiv = 0                                                                   //
//  ************************************************************************************  //
print "<h1>Alle brugere med manglende medarbederid</h1>";

foreach ($accounts as $account) {
  if (!in_array($account->name, $skip_users)) {
    // if (!$account->field_medarbejderid['und'][0]['value'] == 1) {
    if (!$account->field_medarbejderid) {
      print "<strong>" . $account->name . "</strong> mangler medarbejderid - " . $account->field_brugeraktiv['und'][0]['value'] . "<br /><br />";
    }
  }
}




?>

<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
// set_time_limit(0);


// Filer, der skal hentes data fra
$idm_fil = file_get_contents('idmuser.csv');



//  ************************************************************************************  //
//  ************************************************************************************  //
//  For alle brugere i IDM                                                                //
//  Sæt medarbejderid                                                                     //
//  ************************************************************************************  //
print "<h1>IDM-brugere får sat deres medarbejderid</h1>";

if($idm_fil) {
  utf8_encode($idm_fil);
  $idm_data = str_getcsv($idm_fil, "\n");
  $idm_counter = 0;

  foreach($idm_data as &$idm_row) {
    // spring første linie over, da den indeholder kolonnernes overskrifter (sAMAccountName;cn;Enabled;mail;givenName;sn)
    // if(!$idm_counter == 0) {

      /// række 0 = fulde navn
      /// række 1 = medarbejder id
      /// række 2 = mailadresse
      $idm_row = str_getcsv($idm_row, ";");

      $idm_medarbejderid = $idm_row[1];
      $idm_email = strtolower($idm_row[2]);
      // $idm_username = "";

      print "<br /><br />\$idm_medarbejderid: " . $idm_medarbejderid . "";
      print "<br />\$idm_email: " . $idm_email . "";

      $needle = "@ishoj.dk";
      $haystack = $idm_email;
      // if (strpos($haystack,$needle)) { }
      if (strlen(stristr($haystack, $needle)) > 0) {
        $idm_username = explode('@', $idm_email);
        $idm_account = user_load_by_name($idm_username[0]);
        if (!empty($idm_account->uid)) {
          $idm_edit = array(
            'field_medarbejderid' => array(
              'und' => array(
                0 => array(
                  'value' => $idm_medarbejderid
                )
              )
            )
          );
          user_save($idm_account, $idm_edit);
          print "<br /><strong>" . $idm_username[0] . "</strong> fik angivet medarbejderid";
        }
        else {
          print "<br /><strong>" . $idm_username[0] . "</strong> er ikke bruger på Uglen";
        }
      }
      else {
        print "<br />\$idm_medarbejderid <strong>" . $idm_medarbejderid . "</strong> springes over";
      }
    $idm_counter++;
  }
  print "<h2>IDM-brugere i alt: " . $idm_counter . "</h2>";
}


?>

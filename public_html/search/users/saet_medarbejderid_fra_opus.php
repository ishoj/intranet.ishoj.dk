<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// Filer, der skal hentes data fra
$opus_fil = file_get_contents('kmdopus.csv'); // echo utf8_encode($opus_fil);

// Brugere, der skal springes over
$skip_users = array("admin", "skifter");


//  ************************************************************************************  //
//  ************************************************************************************  //
//  For alle brugere i KMD OPUS (SOM HAR MEDARBEJERID I DERES USERNAME)                   //
//  Tjek om bruger eksisterer                                                             //
//  Sæt medarbejdeid                                                                      //
//  ************************************************************************************  //
print "<h1>Medarbeder-id sættes for alle brugere, der har medarbejderid'et i deres username</h1>";

if($opus_fil) {
  utf8_encode($opus_fil);
  $opus_counter = 0;

  // OPUS START

  $opus_data = str_getcsv($opus_fil, "\n");

  foreach($opus_data as &$opus_row) {
    // spring første linie over, da den indeholder kolonnernes overskrifter ()
    if(!$opus_counter == 0) {

      $opus_row = str_getcsv($opus_row, ";");

      $opus_medarbejder_id = strtolower($opus_row[2]); //medarbederid
      $opus_title = ucfirst(str_replace("NULL","",$row[9]));
      $opus_department = str_replace("NULL","",$row[14]);
      $opus_first_name = $row[4];
      $opus_last_name = $row[5];
      $opus_full_name = $row[6];

      $int = (int)$opus_medarbejder_id;
      $opus_account = user_load_by_name($opus_medarbejder_id);

      // field_medarbejderid['und'][0]['value']
      if (!empty($opus_account->uid)) {
        $edit_opus = array(
          'field_medarbejderid' => array(
            'und' => array(
              0 => array(
                'value' => $opus_medarbejder_id
              )
            )
          )
        );
        // user_save($opus_account, $edit_opus);
        print "<strong>" . $opus_medarbejder_id . "</strong> medarbejderid sat<br /><br />";
      }
      else {
        print "<strong>" . $opus_medarbejder_id . "</strong> eksiterer ikke på Uglen<br /><br />";
      }

    }
    $opus_counter++;
  }

  // OPUS SLUT
  print "<h2>OPUS-brugere i alt: " . $opus_counter . "</h2>";

}





?>

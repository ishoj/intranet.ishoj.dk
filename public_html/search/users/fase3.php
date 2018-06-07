<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// Filer, der skal hentes data fra
$ad_fil = file_get_contents('ad.csv');
// $opus_fil = file_get_contents('kmdopus.csv'); // echo utf8_encode($opus_fil);

// Brugere, der skal springes over
// $skip_users = array("admin", "skifter");
$skip_ad_users = array("tho", "jvm", "thk");


//  ************************************************************************************  //
//  ************************************   FASE 3  *************************************  //
//  ************************************************************************************  //
//  For alle brugere i AD                                                                 //
//  Sæt adbruger = 1                                                                      //
//  Sæt brugeraktiv = 1                                                                   //
//  Sæt e-mail                                                                            //
//  ************************************************************************************  //

print "<h1>FASE 3 - AD-brugere får et flueben, gøres 'aktiv' og e-mail sættes</h1>";

function ad_bruger($a, $b, $skip, $file){
  if($file) { // fil eksisterer
    utf8_encode($file);
    $ad_data = str_getcsv($file, "\n");
    $ad_counter = 0;
    $ad_size = count($ad_data);

    if($a > ($ad_size - 2)) {
      return false;
    }
    if($b > $ad_size){
      $b = $ad_size;
    }

    for ($i = $a; $i < $b; $i++) {
      $ad_row = str_getcsv($ad_data[$i], ";");
      $ad_username = strtolower($ad_row[0]);
      $ad_email = strtolower($ad_row[3]);
      $ad_account = user_load_by_name($ad_username);

      if (empty($ad_account->uid)) {
        print "<strong>" . $ad_username . "</strong> eksisterer ikke<br /><br />";
      }
      else {
        // PÅ SPRING OVER LISTEN
        if($ad_username != "2430") { // 2430 fejler
          if (in_array($ad_username, $skip)) { // Kig på denne - den springer åbenbart skip-listen over, efter at det er blevet et funktionsparameter
            print "<strong>" . $ad_username . "</strong> ikke 'AD-bruger' og 'aktiv'<br /><br />";
            $ad_edit['field_brugeraktiv']['und'][0]['value'] = 1; // brugeraktiv sættes hver gang
            $ad_edit['mail'] = $ad_email; // e-mail sættes hver gang
          }
          else {
            // if($ad_username == 'kah') {
              $ad_edit['field_user_in_ad']['und'][0]['value'] = 1;
              $ad_edit['field_brugeraktiv']['und'][0]['value'] = 1; // brugeraktiv sættes hver gang
              $ad_edit['mail'] = $ad_email; // e-mail sættes hver gang
              print "<strong>" . $ad_username . "</strong> ændret til 'AD-bruger' og 'aktiv'<br /><br />";
            // }
          }
          user_save($ad_account, $ad_edit);
        }
      }

    }
  }
  print "<h2>Brugere kørt for " . $a . " til " . $b . "</h2>";
};


// ad_bruger(1, 500, $skip_ad_users, $ad_fil);
// ad_bruger(501, 1000, $skip_ad_users, $ad_fil);
// ad_bruger(1001, 1500, $skip_ad_users, $ad_fil);

print "<h2>Status:</strong> FASE 3 kørt</h2>";




?>

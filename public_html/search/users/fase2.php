<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// Filer, der skal hentes data fra
// $ad_fil = file_get_contents('ad.csv');
$opus_fil = file_get_contents('kmdopus.csv'); // echo utf8_encode($opus_fil);

// Brugere, der skal springes over
$skip_users = array("admin", "skifter");
// $skip_ad_users = array("tho", "jvm", "thk");


//  ************************************************************************************  //
//  ************************************   FASE 2  *************************************  //
//  ************************************************************************************  //
//  For alle brugere i KMD OPUS (SOM HAR MEDARBEJERID I DERES USERNAME)                   //
//  Tjek om bruger eksisterer                                                             //
//  Ellers opret ny bruger                                                                //
//  Sæt brugeraktiv = 1                                                                   //
//  ************************************************************************************  //
print "<h1>FASE 2 - KMD Opus: nye brugere oprettes, et flueben sættes for alle aktive brugere</h1>";

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
      // $opus_title = ucfirst(str_replace("NULL","",$row[9]));
      // $opus_department = str_replace("NULL","",$row[14]);
      $opus_first_name = $row[4];
      $opus_last_name = $row[5];
      $opus_full_name = $row[6];

      $int = (int)$opus_medarbejder_id;
      $opus_account = user_load_by_name($opus_medarbejder_id);

      // if ($int > 34205) { //medarbejderid over 34205 (nye medarbejdere - Jesper har angivet tallet)
      /////////////////////////////////////////////
      // if (($int > 34205) and ($int <= 35200)) {
      // if (($int > 35200) and ($int <= 36200)) {
      // if (($int > 36200) and ($int <= 37200)) {
      // if (($int > 37200) and ($int <= 38200)) {
      // if (($int > 38200) and ($int <= 39200)) {
      // if (($int > 39200) and ($int <= 40200)) {
      // if (($int > 40200) and ($int <= 41000)) {
      // if ($int > 41000) {
        // brugeren med username = medarbeder-id'et eksisterer ikke og skal derfor oprettes
        // if (empty($opus_account->uid)) {
        //   // Determine the roles of our new user
        //   $editor_role = user_role_load_by_name('Webredaktør');
        //   $editor_rid = $editor_role->rid;
        //   $new_user_roles = array(
        //     DRUPAL_AUTHENTICATED_RID => 'authenticated user',
        //     $editor_rid => TRUE,
        //   );
        //   // Create a new user
        //   $new_user = new stdClass();
        //   $new_user->name = $opus_medarbejder_id;
        //   $new_user->pass = $opus_medarbejder_id . '183'; // plain text, hashed later
        //   //$new_user->mail = '';
        //   $new_user->field_fornavn['und'][0]['value'] = $opus_first_name;
        //   $new_user->field_efternavn['und'][0]['value'] = $opus_last_name;
        //   $new_user->field_kaldenavn['und'][0]['value'] = $opus_full_name;
        //   $new_user->field_medarbejderid['und'][0]['value'] = $opus_medarbejder_id;
        //   $new_user->field_os2intra_employee_id['und'][0]['value'] = $opus_medarbejder_id;
        //   $new_user->field_user_in_ad['und'][0]['value'] = '0';
        //   $new_user->field_createdfromopus['und'][0]['value'] = '1';
        //   $new_user->field_brugeraktiv['und'][0]['value'] = '1';
        //   $new_user->roles = $new_user_roles;
        //   $new_user->status = 1; // omit this line to block this user at creation
        //   $new_user->is_new = TRUE; // not necessary because we already omit $new_user->uid
        //   user_save($new_user);
        //   print "<strong>" . $opus_medarbejder_id . "</strong> oprettet<br /><br />";
        // }
        // else { // Skal ikke oprettes - 'brugeraktiv' sættes til 1
        //   $edit_opus['field_brugeraktiv']['und'][0]['value'] = 1;
        //   user_save($opus_account, $edit_opus);
        //   print "<strong>" . $opus_medarbejder_id . "</strong> findes allerede og ændret til 'aktiv'<br /><br />";
        // }
      // }
      ///////////////////////////////////////////
      // if (($int > 0) and ($int <= 10000)) {
      // if (($int > 10000) and ($int <= 20000)) {
      // if (($int > 20000) and ($int <= 34205)) {
      //   // Hvis brugeren eksisterer
      //   if (!empty($opus_account->uid)) {
      //     $edit_opus['field_brugeraktiv']['und'][0]['value'] = 1;
      //     user_save($opus_account, $edit_opus);
      //     print "<strong>" . $opus_medarbejder_id . "</strong> findes allerede og ændret til 'aktiv'<br /><br />";
      //   }
      //   else {
      //     // SKAL EVT. KOMBINERES MED AD
      //     print "<strong>" . $opus_medarbejder_id . "</strong> skal måske oprettes eller findes allerede med bogstavs-id'<br /><br />";
      //   }
      // }
      ///////////////////////////////////////////


    }
    $opus_counter++;
  }

  // OPUS SLUT
  print "<h2>OPUS-brugere i alt: " . $opus_counter . "</h2>";

}


?>

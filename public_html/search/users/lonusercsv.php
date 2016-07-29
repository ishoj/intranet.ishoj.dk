<?php
header('Content-Type: text/html; charset=utf-8');
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
//Array ( [0] => Tiltrædelsesdato [1] => Fratrædelsesdato [2] => Medarbejdernummer [3] => Fødselsdato [4] => Fornavn [5] => Efternavn [6] => Fulde navn [7] => OrgEnh korttekst [8] => Organisatorisk placering [9] => Stillingsbetegnelse [10] => Stillings kort navn [11] => Medarbejderkreds [12] => Ansættelsesforhold [13] => Omkostningssted [14] => Omkostningsstedtekst [15] => Lønform [16] => Decentral adm. enhed [17] => Betegnelse for organisationsenhed [18] => Org. placering )
//Array ( [0] => Tiltrædelsesdato [1] => Fratrædelsesdato [2] => Medarbejdernummer [3] => Fødselsdato [4] => Fornavn [5] => Efternavn [6] => Fulde navn [7] => OrgEnh korttekst [8] => Organisatorisk placering [9] => Stillingsbetegnelse [10] => Stillings kort navn [11] => Medarbejderkreds [12] => Ansættelsesforhold [13] => Omkostningssted [14] => Omkostningsstedtekst [15] => Lønform [16] => Decentral adm. enhed [17] => Betegnelse for organisationsenhed [18] => Org. placering
$filen = file_get_contents('kmdopuspersonale.csv');
$data = str_getcsv($filen, "\n");
foreach($data as &$row) {
$row = str_getcsv($row, ";");
$username = strtolower($row[2]);
$titelname = ucfirst(str_replace("NULL","",$row[9]));
$afnamename = str_replace("NULL","",$row[14]);
 $firstname = $row[4];
 $lastname = $row[5];
 $fullname = $row[6];
 // $fullname = $firstname . " " . $lastname;
 $ansatdato = $row[1];
//$ledername = str_replace("null","",strtolower($row[18])); // leder username
//$aflosname = str_replace("null","",strtolower($row[15])); // leder username
//$telephone = str_replace(" ","",str_replace("NULL","",$row[8]));
$int = (int)$username;
if ($int > 34205) {
//$fullnameuser = $usertochange->field_fornavn['und'][0]['value'] . " " . $usertochange->field_efternavn['und'][0]['value']
$usertochange = user_load_by_name($username);
if (empty($usertochange->uid)) {
print "TOM <br />";
    $query = new EntityFieldQuery();
$query->entityCondition('entity_type', 'user')
  ->fieldCondition('field_fornavn', 'value', $firstname)
->fieldCondition('field_efternavn', 'value', $lastname);
$result = $query->execute();
$users_ids = array_keys($result['user']);
    print "user: " . $username . "<br/>";
    print "FUNDET NAVN: <br />";
print_r($result);
    if (empty($result)) {
        print "user: " . $username . "<br/>";
        print "navn: " . $firstname . " " . $lastname . "<br/>";
        print "titel: " . $titelname . "<br/>";
         print "afdel: " . $afnamename . "<br/>";
        print "TOM SKAL OPRETTES <br />";
 if (!empty($titelname)) {

$query = new EntityFieldQuery;
$resulttitel = $query
->entityCondition('entity_type', 'taxonomy_term')
->propertyCondition('name', $titelname)
->propertyCondition('vid', 37)
->execute();

print "final titel" . "<br/>";
print_r($resulttitel);
print "sluts" . "<br/>";
$testtest = array_values(array_values($resulttitel)[0]);
     print "herant ";
     print_r($testtest[0]);
}

print "OPRET ny <br />";

// Determine the roles of our new user
$editor_role = user_role_load_by_name('Webredaktør');
$editor_rid = $editor_role->rid;

$new_user_roles = array(
  DRUPAL_AUTHENTICATED_RID => 'authenticated user',
  $editor_rid => TRUE,
);

  print_r($new_user_roles);
    print "<br />";

// Create a new user
$new_user = new stdClass();
$new_user->name = $username;
$new_user->pass = $username . '183'; // plain text, hashed later
//$new_user->mail = '';
$new_user->field_fornavn['und'][0]['value'] = $firstname;
$new_user->field_efternavn['und'][0]['value'] = $lastname;
$new_user->field_kaldenavn['und'][0]['value'] = $fullname;
$new_user->field_medarbejderid['und'][0]['value'] = $username;
$new_user->field_os2intra_employee_id['und'][0]['value'] = $username;
$new_user->field_user_in_ad['und'][0]['value'] = '0';
$new_user->field_createdfromopus['und'][0]['value'] = '1';

$new_user->roles = $new_user_roles;
$new_user->status = 1; // omit this line to block this user at creation
$new_user->is_new = TRUE; // not necessary because we already omit $new_user->uid
//


$os = array("Pensionist administration", "YYYY", "XXXX", "ZZZZZ");
if (in_array($titelname, $os)) {
print "IKKE OPRETTET skal ikke";
} else {
// user_save($new_user);
  print $username ." OPRETTET !!<br />";
}


//field_birthday['und'][0]['value'] = '1446246000';
 // field_birthday['und'][0]['timezone'] = 'Europe/Copenhagen';
            // field_birthday['und'][0]['timezone_db'] = 'Europe/Copenhagen';

    }

// TJEK OM NAVNET ER DER SÅ SKAL DER IKKE OPRETTES

    //field_titel_stilling['und'][0]['tid']
    //field_afdeling

    //field_birthday
    //field_commencement


} else {
print "FINDES ALLEREDE" . "<br/>";
}
}
}
//

?>

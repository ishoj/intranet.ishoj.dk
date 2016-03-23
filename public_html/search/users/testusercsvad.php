<?php
header('Content-Type: text/html; charset=utf-8');

define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


$filen = file_get_contents('ad.csv');
$data = str_getcsv($filen, "\n");
//Array ( [0] => sAMAccountName [1] => mail [2] => cn [3] => physicalDeliveryOfficeName [4] => description [5] => department [6] => company [7] => lastLogon [8] => lastLogonTimestamp [9] => Last Authenticated DC [10] => accountExpires [11] => badPwdCount [12] => PasswordNeverExpires [13] => logonCount [14] => Enabled [15] => Lockout ) user: department
//sAMAccountName;cn;Enabled;mail;givenName;sn
foreach($data as &$row) {
$row = str_getcsv($row, ";");

$username = strtolower($row[0]);
$email = strtolower($row[3]);

$usertochange = user_load_by_name($username);
if (empty($usertochange->uid)) {
print "TOM" . "<br/>";
    print "user: " . $username . "<br/>";


} else { 
// TITEL
   

if ($usertochange->field_user_in_ad['und'][0]['value']  == 0) {
 print "user: " . $username . "<br/>";
 print "bruger no ad: " . $usertochange->name . "<br/>";   
 print "email: " . $email . "<br/>";   
  
  
//   if ($usertochange->name == "jvm") {
$existing = user_load($usertochange->uid);
$edit = (array) $existing;         
$edit['field_user_in_ad']['und'][0]['value'] = '1';
$edit['mail'] = $email;
unset($edit['pass']);
unset($edit['picture']);            
unset($edit['field_faerdigheder']);
unset($edit['field_ansvarsomraader']);
unset($edit['field_os2web_base_field_kle_ref']);
unset($edit['field_userdatatest']);
unset($edit['data']);
unset($edit['field_fotolink']);
unset($edit['signature']);
unset($edit['signature_format']);
unset($edit['name']); 
unset($edit['theme']);                 
unset($edit['roles']); 
unset($edit['language']); 
unset($edit['rdf_mapping']);
unset($edit['field_os2intra_import_groups']);                
print_r($edit);  

$os = array("jvm", "tho", "thk", "Linux");
if (in_array($username, $os)) {
print "IKKE UPDATE";
} else {
//user_save($existing, $edit);
print $username . " UPDATED";
} 
    
 
      }     
// }        
        
   
  

}
//
//print "<br />";
}
?>
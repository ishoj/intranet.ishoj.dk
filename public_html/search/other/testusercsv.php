<?php
header('Content-Type: text/html; charset=utf-8');

define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

//$csv = array_map('str_getcsv', file('ugleusersnysekomautf.txt'));
//print file('ugleusersnysekomautf.txt');
//print_r($csv);
$filen = file_get_contents('ugleusersnysekomautf.txt');
$data = str_getcsv($filen, "\n");
// Array ( [0] => id [1] => fuldnavn [2] => fornavn [3] => efternavn [4] => titel [5] => loginname [6] => Privatephone [7] => Phoneext [8] => DirectPhone [9] => CellularPhone [10] => ImageFileID [11] => File_Name [12] => File_Size [13] => afname [14] => afid [15] => afusername [16] => chefname [17] => chefid [18] => chefusername [19] => chefnavn 
foreach($data as &$row) {
$row = str_getcsv($row, ";");

$username = strtolower($row[5]);
$ledername = str_replace("null","",strtolower($row[18])); // leder username
    $aflosname = str_replace("null","",strtolower($row[15])); // leder username
$telephone = str_replace(" ","",str_replace("NULL","",$row[8]));   
$titelname = str_replace(" ","",str_replace("NULL","",$row[4]));   
print "user: " . $username . "<br/>";
$usertochange = user_load_by_name($username);
if (empty($usertochange->uid)) {
print "TOM";
} else { 
// TITEL
    print "titel valgt: " . $usertochange->field_titel_stilling['und'][0]['tid'] . "<br/>"; 
   
    print "titel ugle valgt: " . $titelname . "<br/>"; 
    
    if (empty($usertochange->field_titel_stilling)) {
      print " tOM  - titel fra ugle: " . $titelname . "<br/>";   
      if (!empty($titelname)) {

$query = new EntityFieldQuery;
$result = $query
->entityCondition('entity_type', 'taxonomy_term')
->propertyCondition('name', 'Webmaster')
->propertyCondition('vid', 37) 
->execute();
print_r($result);   
print "final titel" . "<br/>";      
      }
    }
    
    // AFLØSER
 print "afløser valgt: " . $usertochange->field_afloeser['und'][0]['uid'] . "<br/>";   
 if (empty($usertochange->field_afloeser)) {
    
print "field_afloeser er tom" . "<br/>";
    if (!empty($aflosname)) {
       print "aflos fra ugle: " . $aflosname . "<br/>";   
       $useraflos = user_load_by_name($aflosname); 
        if (!empty($useraflos->uid)) {
            print "aflos fundet: " . $useraflos->name . "<br/>";   
             print "aflos fundet id: " . $useraflos->uid . "<br/>";   
  //  if ($usertochange->name == "jvm") {
 /*
            $existing = user_load($usertochange->uid);
$edit = (array) $existing;         
$edit['field_afloeser']['und'][0]['uid'] = $useraflos->uid;
unset($edit['pass']);
unset($edit['mail']);
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

user_save($existing, $edit); 
            */
  //}        
        
        
        
        }
    
    }
 }
    
    // LEDER 
print "leder valgt: " . $usertochange->field_overordnet['und'][0]['uid'] . "<br/>";
if (empty($usertochange->field_overordnet)) {
    
print "field_overordnet er tom" . "<br/>";
    if (!empty($ledername)) {
        print "leder fra ugle: " . $ledername . "<br/>";   
       $userleder = user_load_by_name($ledername); 
        if (!empty($userleder->uid)) {
            print "leder fundet: " . $userleder->name . "<br/>";   
             print "leder fundet id: " . $userleder->uid . "<br/>";   
     //   if ($usertochange->name == "jvm") {
            $existing = user_load($usertochange->uid);
      
/*
$edit = (array) $existing;         
$edit['field_overordnet']['und'][0]['uid'] = $userleder->uid;
unset($edit['pass']);
unset($edit['mail']);
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
*/
//user_save($existing, $edit); 
  //}
        }
        
    }
   
}
    
print "telefon: " . $usertochange->field_direkte_telefon['und'][0]['value'] . "<br/>";
    if (empty($usertochange->field_direkte_telefon['und'][0]['value'])) {
    print "TOM TELEFON" . "<br/>";
        if (!empty($telephone)) {
    print "IKKE TOM UGLETELEFON" . "<br/>";
            print "ugletelefon: " . $telephone . "<br/>";
          //  $user->field_direkte_telefon['und'][0]['value'] = $telephone;
      //      if ($usertochange->name == "jvm") {
           
  /*                
$existing = user_load($usertochange->uid);
$edit = (array) $existing; 
$edit['field_direkte_telefon']['und'][0]['value'] = $telephone;
unset($edit['pass']);
unset($edit['mail']);
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
            */
//user_save($existing, $edit);            
       
 print "xxid: " . $existing->uid . "<br/>";                 
             //   }
    } 
    }   
print "id: " . $usertochange->uid . "<br/>";  

}

print "<br />";
}
?>
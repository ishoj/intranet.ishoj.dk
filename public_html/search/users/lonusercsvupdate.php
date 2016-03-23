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
$ansatdato = $row[1];
$decentraladmenhed = $row[16];
$betegnelse = $row[17];
//$ledername = str_replace("null","",strtolower($row[18])); // leder username
//$aflosname = str_replace("null","",strtolower($row[15])); // leder username
//$telephone = str_replace(" ","",str_replace("NULL","",$row[8]));   
$int = (int)$username;
    //if ($int > 34205) {
if ($int > 1) {
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
 
//field_birthday['und'][0]['value'] = '1446246000';
 // field_birthday['und'][0]['timezone'] = 'Europe/Copenhagen';
            // field_birthday['und'][0]['timezone_db'] = 'Europe/Copenhagen';
    //field_birthday['und'][0]['value']

 //$node->field_os2web_meetings_date[LANGUAGE_NONE][0]['value'] = $meeting['meeting_date_start'];
//    
  //  $node->field_os2web_meetings_date[LANGUAGE_NONE][0]['timezone'] = 'Europe/Berlin';
//    $node->field_os2web_meetings_date[LANGUAGE_NONE][0]['date_type'] = 'datetime';        
        
    }

// TJEK OM NAVNET ER DER SÅ SKAL DER IKKE OPRETTES

  
    //field_afdeling

    //field_birthday
    //field_commencement
   //  $format = "d-m-Y";
    //  $node->title = $meeting['committee'] . ' - ' . date_format($my_date, $format);
    
} else { 
print "FINDES ALLEREDE" . "<br/>"; 
//her
$editsomething = 0;    
    
$existing = user_load($usertochange->uid);
    $edit = (array) $existing; 
    // STILLING
 if (empty($existing->field_titel_stilling)) {
     
  if (!empty($titelname)) {
    $vocabulary = 'titler';
    $term_name = $titelname;
    print "TITEL: " . $term_name . "<br/>"; 
    
  $arr_terms = taxonomy_get_term_by_name($term_name, $vocabulary);
  if (!empty($arr_terms)) {
    $arr_terms = array_values($arr_terms);
    $tid = $arr_terms[0]->tid;
      print "TID: " . $tid . "<br/>"; 
      $edit['field_titel_stilling']['und'][0]['tid'] = $tid;
      $editsomething = 1;
  } else {
     
 taxonomy_term_save((object) array(
  'name' => $term_name,
  'vid' => '37',
)); 
 // find
      $vocabulary = 'titler';
      print "OPRET TITEL: " . $term_name . "<br/>"; 
  $arr_terms = taxonomy_get_term_by_name($term_name, $vocabulary);
    if (!empty($arr_terms)) {
    $arr_terms = array_values($arr_terms);
    $tid = $arr_terms[0]->tid;
    
     $edit['field_titel_stilling']['und'][0]['tid'] = $tid;
        $editsomething = 1;
    }
      
      
      
  }   
 }   
 }
// field_afdeling['und'][0]['tid']
    // STILLING SLUT
// AFDELING START
 if (empty($existing->field_afdeling)) {
     
  if (!empty($afnamename)) {
    $vocabulary = 'os2web_taxonomies_tax_org';
    $term_name = $afnamename;
    print "afdeling: " . $term_name . "<br/>"; 
    
  $arr_terms = taxonomy_get_term_by_name($term_name, $vocabulary);
  if (!empty($arr_terms)) {
    $arr_terms = array_values($arr_terms);
    $tid = $arr_terms[0]->tid;
      print "TID: " . $tid . "<br/>"; 
      $edit['field_afdeling']['und'][0]['tid'] = $tid;
      $editsomething = 1;
  } else {
     
 taxonomy_term_save((object) array(
  'name' => $term_name,
  'vid' => '5',
)); 
 // find
      $vocabulary = 'os2web_taxonomies_tax_org';
      print "OPRET afdeling: " . $term_name . "<br/>"; 
  $arr_terms = taxonomy_get_term_by_name($term_name, $vocabulary);
    if (!empty($arr_terms)) {
    $arr_terms = array_values($arr_terms);
    $tid = $arr_terms[0]->tid;
    
     $edit['field_afdeling']['und'][0]['tid'] = $tid;
        $editsomething = 1;
    }
      
      
      
  }   
 }   
 }    
// AFDELING SLUT
// $decentraladmenhed START
 if (empty($existing->field_user_decentral_adm_enhed)) {
     
  if (!empty($decentraladmenhed)) {
    $vocabulary = 'decentral_adm_enhed';
    $term_name = $decentraladmenhed;
    print "decentraladmenhed: " . $term_name . "<br/>"; 
    
  $arr_terms = taxonomy_get_term_by_name($term_name, $vocabulary);
  if (!empty($arr_terms)) {
    $arr_terms = array_values($arr_terms);
    $tid = $arr_terms[0]->tid;
      print "TID: " . $tid . "<br/>"; 
      $edit['field_user_decentral_adm_enhed']['und'][0]['tid'] = $tid;
      $editsomething = 1;
  } else {
$termnew = new stdClass();
$termnew->name = $term_name;
$termnew->vid = '43'; 
$termnew->field_decentral_adm_enhed['und'][0]['value'] = $term_name;
$termnew->description = $betegnelse;
taxonomy_term_save($termnew);  
 
      
 // find
      $vocabulary = 'decentral_adm_enhed';
      print "OPRET decentraladmenhed: " . $term_name . "<br/>"; 
  $arr_terms = taxonomy_get_term_by_name($term_name, $vocabulary);
    if (!empty($arr_terms)) {
    $arr_terms = array_values($arr_terms);
    $tid = $arr_terms[0]->tid;
    $edit['field_user_decentral_adm_enhed']['und'][0]['tid'] = $tid;
    $editsomething = 1;
    }
      
      
      
  }   
 }   
 }    
// $decentraladmenhed SLUT    
 if ($editsomething == 1) {
      print "SAVEDUSER: " . $existing->name . "<br/>"; 
    
   $editsomething = 0;
unset($edit['pass']);
unset($edit['$email']);
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
//user_save($existing, $edit); 

         
    } // if ($editsomething == 1) {
    
    
} 
} 
}   
//

?>
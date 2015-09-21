<?php
header('Content-Type: text/html; charset=utf-8');

define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$query = $_GET['query'];
$query = str_replace(array('¿', '¾', 'Œ', ''), array('oe', 'ae', 'aa', '%20'), $query);

$data = array(
    'query' => array(
	'function_score' => array(
	    'functions' => _ishoj_elasticsearch_get_boosting($query),
	    'query' => _ishoj_elasticsearch_get_query($query),
	)
    ),
    'size' => _ishoj_elasticsearch_get_size($query),
);

$data_string = json_encode($data);

$ch = curl_init('localhost:9200/intranet/_search');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

$json = curl_exec($ch);
$json =  str_replace("field_os2web_base_field_summary:value","field_os2web_base_field_summary_value",str_replace("author:url","author_url",$json));

$ch2 = curl_init('localhost:9200/medarbejderishoj/_search');
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch2, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
 
$json2 = curl_exec($ch2);
$json2 = str_replace('"hits":','"hits2":', str_replace("field_titel_stilling:name","field_titel_stilling_name",str_replace("field_afdeling:name","field_afdeling_name",$json2)));
$a1 = json_decode( $json, true );
$a2 = json_decode( $json2, true );

$res = array_merge_recursive( $a1, $a2 );

$resJson = json_encode( $res );
print $resJson;
?>

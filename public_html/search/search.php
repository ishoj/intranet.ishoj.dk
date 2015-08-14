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
print str_replace("field_os2web_base_field_summary:value","field_os2web_base_field_summary_value",str_replace("author:url","author_url",$json));

?>

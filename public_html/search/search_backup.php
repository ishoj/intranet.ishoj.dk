<?php
header('Content-Type: text/html; charset=utf-8');

define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// SEARCHFUNCTION
function searchmedarb($data_stringfunc) {
$ch2 = curl_init('localhost:9200/medarbejderishoj/_search');
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_stringfunc);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_stringfunc)));  
$jsonfunc = curl_exec($ch2);
    return $jsonfunc;
}

$query = $_GET['query'];
$query = str_replace(array('¿', '¾', 'Œ', ''), array('oe', 'ae', 'aa', '%20'), $query);

$data = array(
    'query' => array(
	'function_score' => array(
	    'functions' => _ishoj_elasticsearch_get_boosting($query),
	    'query' => _ishoj_elasticsearch_get_query($query),
	)
    ),
    'size' => '3000',
);
//'size' => _ishoj_elasticsearch_get_size($query),
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
// SEARCH MEDARBEJDERE START ------------------------------------------
if ($_GET["l"] == 1) {



$data_stringmed = '';
// EXPLODE
$query = rtrim($query);
$str = $query;
if(strpos($str,' ') >= 0)
{
$arr =  explode(" ", $str);
$countarr = count($arr);    
  
switch ($countarr) {
    case 1:
    
    // TJEK OM DET AFDELING
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
   
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_afdeling:name": "' . $arr[0] . '" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }},{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}
}';  
    
    

    
    
  $json2 = searchmedarb($data_stringmed);
    } 
     $jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {  
    
/* $data_stringmed = '{
  "query": {
    "bool": {
     
      "should":[{"query_string":{"query":"' . $arr[0] . '","fields":["field_fornavn"]}}]
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }} 
}';  
*/
     
 //  {"bool":{"should":[{"query_string":{"query":"*jesper*","fields":["_all"]}}]}}
    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"' . $query . '","fields":["field_fornavn"], "boost": 2}},{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}]}}}},"size":3000}';  
 //, "sort": { "field_kaldenavn": { "order": "asc" }},
$json2 = searchmedarb($data_stringmed);
    }
 $jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {   
  $data_stringmed = '{
  "query": {
    "bool": {
     
      "should":[{"query_string":{"query":"' . $arr[0] . '","fields":["field_fornavn"]}}],
      "should":[{"query_string":{"query":"' . $arr[0] . '","fields":["field_efternavn"]}}]
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }},{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}
}';   
    
$json2 = searchmedarb($data_stringmed);
    }
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    // PRØV BEGGE I FORNAVN
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_efternavn": "' . $arr[0] . '" }}
    }
  },{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json2 = searchmedarb($data_stringmed);
    }
    
 
        break;
    case 2:
       $data_stringmed = '{
       ,{"query_string":{"query":"*' . $query . '*","fields":["_all"]}},
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_efternavn": "' . $arr[1] . '" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json2 = searchmedarb($data_stringmed);
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    // PRØV BEGGE I FORNAVN
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_fornavn": "' . $arr[1] . '" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }},{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}
}';   
$json2 = searchmedarb($data_stringmed);
    }  
// TJEK OM EFTERNAVN OG FORNAVN
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) { 
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_efternavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_fornavn": "' . $arr[1] . '" }}
    }
  }
}';   
$json2 = searchmedarb($data_stringmed);
    }  
// TJEK OM DET ER FORNAVN OG Ansvar
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_ansvarsomraader:name": "' . $arr[1] . '" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json2 = searchmedarb($data_stringmed);
    }
    
// TJEK OM DET ER FORNAVN OG Ansvar WILDCARD*
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":[{"query_string":{"query":"' . $arr[1] . '*","fields":["field_ansvarsomraader:name"]}}]
    }
  }
}';   
$json2 = searchmedarb($data_stringmed);
    }    
    
// TJEK OM DET ER FORNAVN OG AFDELING
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_afdeling:name": "' . $arr[1] . '" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json = searchmedarb($data_stringmed);
    }
// TJEK OM DET ER FORNAVN OG FÆRDIGHEDER
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_faerdigheder:name": "' . $arr[1] . '" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json2 = searchmedarb($data_stringmed);
    
}
 

    
// TJEK OM DET ER FORNAVN OG EFTERNAVN KORT
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
 //  echo "jes";
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
     "should":[{"query_string":{"query":"' . $arr[1] . '*","fields":["field_efternavn"]}}]
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json2 = searchmedarb($data_stringmed);
    $jsontest = json_decode($json2, true);
if ($jsontest['hits']['total'] == 0) {
 //  echo "NULL";
}
    }          
    
     break;
    case 3:
       $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_fornavn": "' . $arr[1] . '" }},
      "must":     { "match": { "field_efternavn": "' . $arr[2] . '" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';
$json2 = searchmedarb($data_stringmed);
$jsontest = json_decode($json2, true);
// FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    // PRØV BEGGE I EFTERNAVN
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_efternavn": "' . $arr[1] . '" }},
      "must":     { "match": { "field_efternavn": "' . $arr[2] .'" }}
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json2 = searchmedarb($data_stringmed);
    }  
  
$jsontest = json_decode($json2, true);
// FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    // PRØV BEGGE I EFTERNAVN
   $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_efternavn": "' . $arr[2] . '" }},
      "should": [
                  { "match": { "field_efternavn": "' . $arr[1] . '" }}
      ]
    }
  }, "sort": { "field_kaldenavn": { "order": "asc" }}
}';   
$json2 = searchmedarb($data_stringmed);
$jsontest = json_decode($json2, true);
  
    }      
    
        break;
    default:
       //
    
}
} 
   
    
/*
$data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "jesper" }},
      "must":     { "match": { "field_efternavn": "meyer" }},
      "must_not": { "match": { "field_faerdigheder:name": "hedt"  }},
      "should": [
                  { "match": { "field_efternavn": "meyer" }},
                  { "match": { "field_efternavn": "vig"   }}
      ]
    }
  }
}';
*/

// HVEM HAR ANSVAR ET FOR ?
if ($jsontest['hits']['total'] == 0) {
if(strpos($query,'hvem har ansvaret for ') >= 0)
{
$query = str_replace("hvem har ansvaret for ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_ansvarsomraader:name"]}}]}}}},"size":3000}';    
$json2 = searchmedarb($data_stringmed);
}
}

// HVEM HAR ANSVAR ET FOR ?
if ($jsontest['hits']['total'] == 0) {
if(strpos($query,'hvem har ansvar for ') >= 0)
{
$query = str_replace("hvem har ansvar for ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_ansvarsomraader:name"]}}]}}}},"size":3000}';    
$json2 = searchmedarb($data_stringmed);
}
}

// HVEM ER GOD TIL ? - START
if ($jsontest['hits']['total'] == 0) {
if(strpos($query,'hvem er god til at') >= 0)
{
$query = str_replace("hvem er god til at ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_faerdigheder:name"]}}]}}}}, "sort": { "field_kaldenavn": { "order": "asc" }},"size":3000}';    
$json2 = searchmedarb($data_stringmed);
}
}
// HVEM ER GOD TIL ? - SLUT    
    
// HVEM ER GOD TIL ? - START
if ($jsontest['hits']['total'] == 0) {
if(strpos($query,'hvem er god til ') >= 0)
{
$query = str_replace("hvem er god til ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_faerdigheder:name"]}}]}}}}, "sort": { "field_kaldenavn": { "order": "asc" }},"size":3000}';    
$json2 = searchmedarb($data_stringmed);
}
}
// HVEM ER GOD TIL ? - SLUT

// HVEM ER ? - START
if ($jsontest['hits']['total'] == 0) {
if(strpos($query,'hvem er ') >= 0)
{
$query = str_replace("hvem er ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_titel_stilling:name"]}}]}}}}, "sort": { "field_kaldenavn": { "order": "asc" }},"size":3000}';    
$json2 = searchmedarb($data_stringmed);
}
}
// HVEM ER ? - SLUT


// FIRSTNAME WIDTH SEARCH
// SEARCH IN ALL IF EMPTY
$jsontest = json_decode($json2, true);
if ($jsontest['hits']['total'] == 0) {
$json2 = searchmedarb('{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"' . $query . '*","fields":["field_fornavn"]}},{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}]}}}}, "sort": { "field_kaldenavn": { "order": "asc" }},"size":3000}');
} 


    

//{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*jesper*","fields":["_all"]}}]}}}}, "sort": { "field_kaldenavn": { "order": "asc" }},"size":3000}
    
// SEARCH IN ALL IF EMPTY
$jsontest = json_decode($json2, true);
if ($jsontest['hits']['total'] == 0) {
$json2 = searchmedarb('{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}]}}}}, "sort": { "field_kaldenavn": { "order": "asc" }},"size":3000}');
    } 


$json2 = str_replace('"hits":','"hits2":', str_replace("field_titel_stilling:name","field_titel_stilling_name",str_replace("field_afdeling:name","field_afdeling_name",$json2)));


// SEARCH MEDARBEJDERE END
} else {
    $json2 = '{"took":3,"timed_out":false,"_shards":{"total":5,"successful":5,"failed":0},"hits2":{"total":0,"max_score":null,"hits2":[]}}';
}


// LÆG DET SAMMEN
$a1 = json_decode( $json, true );
$a2 = json_decode( $json2, true );

$res = array_merge_recursive( $a1, $a2 );

$resJson = json_encode( $res );
print $resJson;
//print $json2;
?>

<?php
header('Content-Type: text/html; charset=utf-8');

define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
$json2 = '';

function searchmedarb($data_stringfunc) {
$ch2 = curl_init('localhost:9200/medarbejderishoj/_search?pretty=true');
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_stringfunc);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_stringfunc)));  
$jsonfunc = curl_exec($ch2);
    return $jsonfunc;
}

$query = $_GET['query'];
$query = str_replace(array('¿', '¾', 'Œ', ''), array('oe', 'ae', 'aa', '%20'), $query);
$data_stringmed = '';
// EXPLODE

$str = $query;
if(strpos($str,' ') >= 0)
{
$arr =  explode(" ", $str);
$countarr = count($arr);    
  
switch ($countarr) {
    case 1:
  $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }}
    }
  }
}';   
$json2 = searchmedarb($data_stringmed);
$jsontest = json_decode($json2, true);
    // FANDT DEN NOGET?
if ($jsontest['hits']['total'] == 0) {
    // PRØV BEGGE I FORNAVN
    $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_efternavn": "' . $arr[0] . '" }}
    }
  }
}';   
$json2 = searchmedarb($data_stringmed);
    } 
    print " HER";
        break;
    case 2:
       $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "' . $arr[0] . '" }},
      "must":     { "match": { "field_efternavn": "' . $arr[1] . '" }}
    }
  }
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
  }
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
  }
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
  }
}';   
$json2 = searchmedarb($data_stringmed);
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
  }
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
      "must":     { "match": { "field_efternavn": "' . $arr[1] . '" }},
      "must":     { "match": { "field_efternavn": "' . $arr[2] . '" }}
    }
  }
}';   
$json2 = searchmedarb($data_stringmed);
    }  
    
        break;
    default:
       $data_stringmed = '{
  "query": {
    "bool": {
      "must":     { "match": { "field_fornavn": "thomas" }},
      "must":     { "match": { "field_efternavn": "jensen" }}
    }
  }
}';
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
if(strpos($query,'hvem har ansvar for ') >= 0)
{
$query = str_replace("hvem har ansvar for ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_ansvarsomraader:name"]}}]}}}},"size":13}';    
$json2 = searchmedarb($data_stringmed);
}
}

// HVEM ER GOD TIL ? - START
if ($jsontest['hits']['total'] == 0) {
if(strpos($query,'hvem er god til ') >= 0)
{
$query = str_replace("hvem er god til ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_faerdigheder:name"]}}]}}}},"size":13}';    
$json2 = searchmedarb($data_stringmed);
}
}
// HVEM ER GOD TIL ? - SLUT

// HVEM ER ? - START
if ($jsontest['hits']['total'] == 0) {
if(strpos($query,'hvem er ') >= 0)
{
$query = str_replace("hvem er ","",$query);    
$data_stringmed = '{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["field_titel_stilling:name"]}}]}}}},"size":13}';    
$json2 = searchmedarb($data_stringmed);
}
}
// HVEM ER ? - SLUT


$jsontest = json_decode($json2, true);
if ($jsontest['hits']['total'] == 0) {
    print "SOG ALT";
    // SØG ALT
$json2 = searchmedarb('{"query":{"function_score":{"functions":[],"query":{"bool":{"should":[{"query_string":{"query":"*' . $query . '*","fields":["_all"]}}]}}}},"size":13}');
    } 

print str_replace("field_titel_stilling:name","field_titel_stilling_name",str_replace("field_afdeling:name","field_afdeling_name",$json2));
/*
{
  "took" : 1,
  "timed_out" : false,
  "_shards" : {
    "total" : 5,
    "successful" : 5,
    "failed" : 0
  },
  "hits" : {
    "total" : 1,
    "max_score" : 8609137.0,
    "hits" : [ {
      "_index" : "medarbejderishoj",
      "_type" : "medarbejderindex",
      "_id" : "2569",
      "_score" : 8609137.0,
      "_source":{"id":2569,"field_afdeling":"2945","field_afdeling_name":"Kommunikation","field_afdeling:url":"http:\/\/uglen.ishoj.dk\/taxonomy\/term\/2945","field_afloeser":["40","13"],"field_afloeser:name":["tho","thk"],"field_ansvarsomraader:name":["ishoj.dk","Intranet","Digitale medier","Hjemmesiden","Projektleder","TV-Ish\u00f8j Sende udstyr"],"field_arbejdsmobil":"60606060","field_direkte_telefon":"43576203","field_efternavn":"Vig Meyer","field_faerdigheder:name":["Projektledelse","Undervisning","Musikproduktion","Medier","programmering"],"field_fornavn":"Jesper","field_fotolink":"picture-2569-1441967762.jpg","field_kaldenavn":"Jesper V. Meyer","field_medarbejderid":"jvm","field_overordnet":["2575","3716"],"field_overordnet:field_efternavn":["Edlenborg Ahrensberg","Tosten\u00e6s"],"field_overordnet:field_fornavn":["Katharina ","Per"],"field_overordnet:field_kaldenavn":["Katharina Edlenborg Ahrensberg"],"field_privat_mobil":"50505050","field_titel_stilling":"3262","field_titel_stilling_name":"Webmaster","last_access":"1441967741","mail":"jvm@ishoj.dk","name":"jvm","search_api_language":"da","url":"http:\/\/uglen.ishoj.dk\/users\/jesper-v-meyer"}
    } ]
  }
}
*/

?>

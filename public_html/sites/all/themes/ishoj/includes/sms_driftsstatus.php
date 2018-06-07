<?php

// var_dump(extension_loaded('curl'));


$mobilnummer = $_POST["Mobilnummer"];
$fornavn     = $_POST["Fornavn"];
$efternavn   = $_POST["Efternavn"];
$sub         = $_POST["sub"];
$unsub       = $_POST["unsub"];
$required    = $_POST["required"];
$keys        = $_POST["keys"];


$datastring = 'Mobilnummer=' . $mobilnummer . '&Fornavn=' . $fornavn . '&Efternavn=' . $efternavn . '&required=' . $required;

if ($sub) {
  $datastring .= '&sub=' . $sub;
}
else {
  $datastring .= '&unsub=' . $unsub;
}

foreach($keys as $var => $val) {
  if ($val) {
    $datastring .= '&keys%5B%5D=' . $val;
  }
}
//
// echo $datastring;

$url = 'https://gruppe-sms.dk/gate/?handle=subscription&language=da';
// $datastring = 'Mobilnummer=' . $mobilnummer . '&Fornavn=' . $fornavn . '&Efternavn=' . $efternavn . '&sub=' . $sub . '&unsub=' . $unsub . '&required=' . $required . '&keys%5B%5D=' . $key;
// $datastring = 'Mobilnummer=88888888&Fornavn=Admin&Efternavn=Administrator&sub=Tilmeld&required=Mobilnummer%2CEfternavn%2CFornavn&keys%5B%5D=ctI1460622408ct570f544877950';
// echo $datastring;
$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec( $ch );

echo $response;

// if ($_POST) {
//     echo '<pre>';
//     echo htmlspecialchars(print_r($_POST, true));
//     echo '</pre>';
// }


?>

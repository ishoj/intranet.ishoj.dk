<?php

// var_dump(extension_loaded('curl'));

$mobilnummer = htmlspecialchars($_POST["Mobilnummer"]);
$fornavn     = htmlspecialchars($_POST["Fornavn"]);
$efternavn   = htmlspecialchars($_POST["Efternavn"]);
$sub         = htmlspecialchars($_POST["sub"]);
$unsub       = htmlspecialchars($_POST["unsub"]);
$required    = htmlspecialchars($_POST["required"]);
$key         = htmlspecialchars($_POST["keys%5B%5D"]);


$url = 'http://www.ishoj.dk';
$myvars = 'Mobilnummer=' . $mobilnummer . '&Fornavn=' . $fornavn . '&Efternavn=' . $efternavn . '&sub=' . $sub . '&unsub=' . $unsub . '&required=' . $required . '&keys%5B%5D=' . $key;

$response = $myvars;

// $ch = curl_init( $url );
// curl_setopt( $ch, CURLOPT_POST, 1);
// curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
// curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt( $ch, CURLOPT_HEADER, 0);
// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
//
// $response = curl_exec( $ch );



?>

<?php

$url = "http://www.ishoj.dk/jsonaktivitetsdata?hest=" . rand();
$json = file_get_contents($url);
//echo json_encode($json);
echo $json;


?>
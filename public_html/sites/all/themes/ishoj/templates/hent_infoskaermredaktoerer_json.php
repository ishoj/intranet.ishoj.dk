<?php

$url = "http://www.ishoj.dk/json_redaktoerer_infoskaerme?hest=" . rand();
$json = file_get_contents($url);
//echo json_encode($json);
echo $json;


?>
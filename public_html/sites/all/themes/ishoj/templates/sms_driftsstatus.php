<?php

// var_dump(extension_loaded('curl'));


$mobilnummer = $_POST["Mobilnummer"];
$fornavn     = $_POST["Fornavn"];
$efternavn   = $_POST["Efternavn"];
$sub         = $_POST["sub"];
$unsub       = $_POST["unsub"];
$required    = $_POST["required"];
$key         = $_POST["keys"];

// $mobilnummer = htmlspecialchars($_POST["Mobilnummer"]);
// $fornavn     = htmlspecialchars($_POST["Fornavn"]);
// $efternavn   = htmlspecialchars($_POST["Efternavn"]);
// $sub         = htmlspecialchars($_POST["sub"]);
// $unsub       = htmlspecialchars($_POST["unsub"]);
// $required    = htmlspecialchars($_POST["required"]);
// $key         = htmlspecialchars($_POST["keys%5B%5D"]);
// $key         = htmlspecialchars($_POST["keys[]"]);


// $url = 'http://www.ishoj.dk';
// $myvars = 'Mobilnummer=' . $mobilnummer . '&Fornavn=' . $fornavn . '&Efternavn=' . $efternavn . '&sub=' . $sub . '&unsub=' . $unsub . '&required=' . $required . '&keys%5B%5D=' . $key;
// echo $myvars;
echo $mobilnummer;
echo $key[0];

// $ch = curl_init( $url );
// curl_setopt( $ch, CURLOPT_POST, 1);
// curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
// curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_setopt( $ch, CURLOPT_HEADER, 0);
// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
//
// $response = curl_exec( $ch );

if ($_POST) {
    echo '<pre>';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';
}


?>
<form action="" method="post">
    Name:  <input type="text" name="personal[name]" /><br />
    Email: <input type="text" name="personal[email]" /><br />
    Beer: <br />
    <select multiple name="beer[]">
        <option value="warthog">Warthog</option>
        <option value="guinness">Guinness</option>
        <option value="stuttgarter">Stuttgarter Schwabenbräu</option>
    </select><br />
    <input type="submit" value="submit me!" />
</form>

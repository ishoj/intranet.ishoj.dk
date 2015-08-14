<?php	

/*
	File name: test_web_service.php
	Version:   2.1
	
	Description:
	test_wev_service.php tests whether the web service is working.
	
*/

/*
	Copyright 2012-13 by Halibut ApS.
	Visit us at www.halibut.dk / www.taxon.dk.
	
	This file is part of Taxon.

	Taxon is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	Taxon is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Taxon. If not, see <http://www.gnu.org/licenses/>.
	
	For more information read the README.txt file in the root directory.
*/

	$taxon_dir = getcwd();
	
	print "$taxon_dir\n";
	
	$taxon_dir = preg_replace("/\/test\/?$/", "", $taxon_dir);

	print "$taxon_dir\n";

	print "Enter the path and name of your lookup taxonomy and press <ENTER> ($taxon_dir/taxonomies/test_lookup.json): ";
	$taxonomy = trim(fgets(STDIN));

	if($taxonomy == "")
	{
		$taxonomy = "$taxon_dir/taxonomies/test_lookup.json";
	}

	print "Enter a short text to test the system (Denmark): ";
	$text = trim(fgets(STDIN));

	if($text == "")
	{
		$text = "Denmark";
	}

	print "Enter the URL of the Taxon web service (http://localhost/taxon-ws.php): ";
	$url = trim(fgets(STDIN));
	$url = rtrim($url, "/");

	if($url == "")
	{
		$url = "http://localhost/taxon-ws.php";
	}
	
	//set POST variables
	if(! preg_match("/^https?:\/\//", $url))
	{
		$url = "http://$url";
	}
	
	$fields = array(
            'taxonomy' => urlencode($taxonomy),
            'text' => urlencode($text),
            'settings' => urlencode(json_encode(array("numberResultsReturned" => 0)))
        );

	$fields_string = "";

	//url-ify the data for the POST
	foreach($fields as $key => $value)
	{ 
		$fields_string .= $key . '=' . $value . '&'; 
	}

	rtrim($fields_string, '&');

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, count($fields));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	//execute post
	$result = curl_exec($ch);
	
	//close connection
	curl_close($ch);

	$json = json_decode($result);

	if(count($json) == 0)
	{
		print "$result\n";
	}
	else
	{
		print_r($json);
	}
?>

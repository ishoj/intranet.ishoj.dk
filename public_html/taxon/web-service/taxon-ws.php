<?php
/*
	File name: taxon-ws.php
	Version:   2.1
	
	Description:
	taxon-ws.php is a proxy to the actual Taxon system. It exposes an
	interface to the web.
	
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

require_once '../system/taxon/classify.php';

if( ! isset($_POST['taxonomy']))
{
	print "No taxonomy";
	
	exit;
}

if( ! isset($_POST['text']))
{
	print "No text";
	
	exit;
}

$taxonomy = urldecode($_POST['taxonomy']);
$text = urldecode(strip_tags($_POST['text']));
$settings = (array)json_decode(urldecode($_POST['settings']));

if(($taxonomy != "") && ($text != ""))
{
	// Check whether we should alter the text prior to classification
	if(file_exists("includes/preprocessText.php"))
	{
		require "includes/preprocessText.php";

		preprocessText($text);
	}
	
	$taxon_result = classify($taxonomy, $text, $settings);

	if($taxon_result == "")
	{
		print "No result";
	}
	else
	{
		// Check whether we should alter the result
		if(file_exists("includes/postprocessResult.php"))
		{
			require "includes/postprocessResult.php";
			
			postprocessResult($taxon_result);
		}

		print $taxon_result;
	}
}
?>


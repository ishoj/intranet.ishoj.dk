<?php
/*
	File name: test_getallterms.php
	Version:   2.1.2
	
	Description:
	test_getallterms.php tests whether the getallterms function is 
	working correctly.
*/

/*
	Copyright 2012-2013 by Halibut ApS.
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
	require '../taxon/getallterms.php';
	require '../includes/niceJSON.php';

	print "Enter the name of your taxonomy and press <ENTER>: ";
	$taxonomy = trim(fgets(STDIN));

	print "Enter the return type (empty or 'json') and press <ENTER>: ";
	$return_type = trim(fgets(STDIN));

	print "Enter the output type (empty or 'file') and press <ENTER>: ";
	$output_type = trim(fgets(STDIN));

	$settings = array();

	/*
		To make it easier for the user we default to the default taxonomy
		directory.
		For some users and uses it is desirable to enter a full path for
		the taxonomy, and then we don't want the default taxonomy dir
		to get in the way.
	*/
	$taxonomies_dir = "../taxonomies";
	
	if(preg_match("/^\//", $taxonomy))
	{
		$taxonomies_dir = "";
	}
	
	if($return_type != "")
	{
		$settings['return-type'] = $return_type;
	}

	// Call the function
	$result = getallterms("$taxonomies_dir/$taxonomy.json", $settings);

	$filetype = "txt";
	
	if($return_type == "json")
	{
		$result = niceJSON($result);
		$filetype = "json";
	}
	
	if($output_type == "file")
	{
		file_put_contents("./test_getallterms.$filetype", $result);
	}
	else
	{
		print "$result\n";
	}
?>


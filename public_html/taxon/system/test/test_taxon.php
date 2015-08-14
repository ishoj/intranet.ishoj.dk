<?php
/*
	File name: test_taxon.php
	Version:   2.1.2
	
	Description:
	test_taxon.php tests whether Taxon is working correctly.
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

	require '../taxon/classify.php';
	require '../includes/niceJSON.php';
	
	$taxonomies_dir = "../taxonomies";
	
	print "Enter the name of your taxonomy and press (test) <ENTER>: ";

	$taxonomy = trim(fgets(STDIN));

	if($taxonomy == "")
	{
		$taxonomy = "test";
	}

	if(file_exists("$taxonomies_dir/$taxonomy.json"))
	{
		print "Taxonomy file for $taxonomy ($taxonomy.json) is present\n";

		if(file_exists("$taxonomies_dir/$taxonomy" . "_lookup.json"))
		{
			print "Lookup file for $taxonomy ($taxonomy" . "_lookup.json) is present\n";
		}
		else
		{
			print "Lookup file for $taxonomy ($taxonomy" . "_lookup.json) is NOT present\n";
			print "You need to run the make_lookup_taxonomy.php in the tools/ directory, like:\n";
			print "    php ../tools/make_lookup_taxonomy.php ../taxonomies/$taxonomy\n";
			
			exit;
		}
	}
	else
	{
		print "$taxonomy is NOT present\n";
		print "Check that the name of the taxonomy.\n";
		
		exit;
	}
	
	print "\n";
	print "Enter a short text to test the system (Denmark): ";

	$text = trim(fgets(STDIN));

	if($text == "")
	{
		$text = "Denmark";
	}

	$result = classify("$taxonomies_dir/$taxonomy" . "_lookup.json", $text);
	
	$result = niceJSON($result);
	
	print "$result\n";
	 
?>


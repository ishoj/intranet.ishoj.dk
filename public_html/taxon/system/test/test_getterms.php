<?php
/*
	File name: test_getterms.php
	Version:   2.1.2
	
	Description:
	test_getterms.php tests whether the getterms function is 
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
	require '../taxon/getterms.php';
	require '../includes/niceJSON.php';
	
	$taxonomies_dir = "../taxonomies";

	print "Enter the name of your taxonomy and press <ENTER>: ";
	$taxonomy = trim(fgets(STDIN));

	print "Enter class ID and press <ENTER>: ";
	$classid = trim(fgets(STDIN));

	$result = getterms("$taxonomies_dir/$taxonomy.json", $classid);
		
	$result = niceJSON($result);
	
	print "$result\n";

?>


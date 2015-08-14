<?php

/*
	File name: getterms.php
	Version:   2.1.2
	
	Description:
	getterms.php returns the terms from the supplied class.
	
	Functions:
	getterms()
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

function getterms($taxonomy, $classid)
{
	if($taxonomy == "")
	{
		return "No taxonomy";
	}
	
	if($classid == "")
	{
		return "No class ID";
	}
	/************** Start Create the taxonomy structure *************/

	/*
		Get the taxonomy from a JSON file.
	*/
	$file = file_get_contents($taxonomy);

	if($file == "")
	{
		return "Taxonomy file is empty";
	}
	
	/*
		Create the taxonomy structure based on the taxonomy
	*/
	$classes = json_decode($file);

	if($classes == "")
	{
		return "Taxonomy is invalid";
	}
		
	/************** End Create the taxonomy structure *************/

	/*
		Get the term(s) in the class.
	*/

	foreach($classes->classes as $i => $class)
	{
		if($class->id == $classid)
		{
			$terms = $class->terms;
			
			break;
		}
	}

	$json = json_encode($terms);
	
	return $json;
}

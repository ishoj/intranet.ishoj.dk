<?php

/*
	File name: getclasses.php
	Version:   2.1.2
	
	Description:
	getclasses.php returns the class(es) the input term occurs in.
	
	Functions:
	getclasses()
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

function getclasses($taxonomy, $term_title)
{
	if($taxonomy == "")
	{
		return "No taxonomy";
	}
	
	if($term_title == "")
	{
		return "No term title";
	}
	
	$term_title = mb_strtolower($term_title, 'UTF-8');	
	/************** Start Create the lookup structure *************/

	/*
		Get the taxonomy from a JSON file.
	*/
	$file = file_get_contents($taxonomy);

	if($file == "")
	{
		return "Taxonomy file is empty";
	}

	/*
		Create the lookup structure based on the taxonomy
	*/
	$term_lookup = json_decode($file);

	if($term_lookup == "")
	{
		return "Taxonomy is invalid";
	}

	/************** End Create the lookup structure *************/

	/*
		Lookup the class(es) for the term title.
	*/
	
	$classes_lookup = (array)$term_lookup->classes;

	$classes = $classes_lookup[$term_title];

	$json = json_encode($classes);
	
	return $json;
}

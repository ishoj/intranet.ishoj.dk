<?php

/*
	File name: getallclasses.php
	Version:   2.1.2
	
	Description:
	getallclasses.php returns the class(es) in the taxonomy.
	
	Functions:
	getallclasses()
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

function getallclasses($taxonomy, $settings = array())
{
	global $taxon_host;
	
	if($taxonomy == "")
	{
		return "No taxonomy";
	}
	
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
		Create the structure based on the taxonomy
	*/
	$tree = json_decode($file);

	if($tree == "")
	{
		return "Taxonomy is invalid";
	}

	/************** End Create the structure *************/

	/*
		Get the class(es) without the terms.
	*/
	
	$result = array();
	
	foreach($tree->classes as $classid => $class)
	{
		$result[$classid]['title'] = $class->title;
	}

	$result_text = "";
	
	if(isset($settings['return-type']))
	{
		switch($settings['return-type'])
		{
			case 'json' :
				$result_text = json_encode($result);
				break;

			default:
				foreach($result as $classid => $class)
				{
					$result_text .= "$classid " . $class['title'] . "\n";
				}
		}
	}
	else
	{
		foreach($result as $classid => $class)
		{
			$result_text .= "$classid " . $class['title'] . "\n";
		}
	}
	
	return $result_text;
}

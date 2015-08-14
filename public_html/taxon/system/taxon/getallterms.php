<?php

/*
	File name: getallterms.php
	Version:   2.1.2
	
	Description:
	getallterms.php returns all terms from all classes.
	
	Functions:
	getallterms()
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

function getallterms($taxonomy, $settings = array())
{
	if($taxonomy == "")
	{
		return "No taxonomy";
	}

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
		Get the terms in the classes.
	*/

	$result = array();

	foreach($classes->classes as $classid => $class)
	{
		$class_title = $class->title;

		$terms = array();

		if(isset($class->terms))
		{
			foreach($class->terms as $term_title => $term)
			{
				$terms[] = $term_title;
			}

			sort($terms);
		
			$result["$classid $class_title"] = $terms;
		}
		else
		{
			$result["$classid $class_title"] = array("### No terms ###");
		}
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
				foreach($result as $classid => $terms)
				{
					$result_text .= "$classid\n";

					foreach($terms as $i => $term_title)
					{
						$result_text .= "   $term_title\n";;
					}

					$result_text .= "\n";
				}
		}
	}
	else
	{
		foreach($result as $classid => $terms)
		{
			$result_text .= "$classid\n";

			foreach($terms as $i => $term_title)
			{
				$result_text .= "   $term_title\n";;
			}

			$result_text .= "\n";
		}
	}
	
	return $result_text;
}

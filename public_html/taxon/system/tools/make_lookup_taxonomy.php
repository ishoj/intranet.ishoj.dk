<?php
/*
	File name: make_lookup_taxonomy.php
	Version:   2.1.2
	
	Description:
	make_lookup_taxonomy.php converts a taxonomy into a better (faster)
	format for looking up terms.
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

/*
	Some settings
*/

mb_internal_encoding("UTF-8");

if( ! isset($argv[1]))
{
	print "Error: No taxonomy was supplied\n";
	print "USAGE: php make_lookup_taxonomy.php <FULL-PATH-TO-TAXONOMY>\n";
	
	exit;
}

$file_input_json = $argv[1];

$file_output_json = str_replace(".json", "_lookup.json", $file_input_json);

/*
	Get the taxonomy from a JSON file.
*/
$file = file_get_contents($file_input_json);

/*
	Convert to JSON
*/
$taxonomy = json_decode($file);

if($taxonomy == "")
{
	print "Error: '$file_input_json' is not a valid JSON\n";
	
	exit;
}

/*
	Build structure used for actually queries.
*/

$terms_lookup = array();

/*
	Used for error reporting.
*/
$class_number = 0;

/*
	Create the taxonomy based on classes
*/

foreach ($taxonomy->classes as $class)
{
	$class_number++;
	
	// Check whether the title of the class is defined	
	if( ! isset($class->title))
	{
		if(isset($class->id))
		{
			print "Title is not defined in class " . $class->id . "\n";
		}
		else
		{
			print "Title is not defined in class number $class_number\n";
		}		

		continue;
	}

	// Check whether the id of the class is defined	
	if( ! isset($class->id))
	{
		print "ID is not defined in class " . $class->title . "\n";

		continue;
	}

	/*
		Make sure variables for the class are defined
	*/
	if( ! isset($class->thresholdWeight))
	{
		$class->thresholdWeight = 5;
	}
		
	if( ! isset($class->hidden))
	{
		$class->hidden = 0;
	}
		
	if( ! isset($class->exclusive))
	{
		$class->exclusive = 0;
	}
		
	if( ! isset($class->thresholdCount))
	{
		$class->thresholdCount = 1;
	}
		
	if( ! isset($class->thresholdCountUnique))
	{
		$class->thresholdCountUnique = 1;
	}
		
	if(isset($class->terms))
	{
		foreach ($class->terms as $term)
		{
			// Make the title lower case for later comparison in Taxon (classify.php)
			$term->title = mb_strtolower($term->title, 'UTF-8');

			/*
				Make sure variables for the term are defined
			*/
			if( ! isset($term->weight))
			{
				$term->weight = 5;
			}

			if( ! isset($term->required))
			{
				$term->required = 0;
			}

			if( ! isset($term->requireTerm))
			{
				$term->requireTerm = "";
			}

			if( ! isset($term->excludeOnTerm))
			{
				$term->excludeOnTerm = "";
			}

			if( ! isset($term->requireClass))
			{
				$term->requireClass = "";
			}

			if( ! isset($term->excludeOnClass))
			{
				$term->excludeOnClass = "";
			}

			if( ! isset($term->prefix))
			{
				$term->prefix = "";
			}
	
			if( ! isset($term->suffix))
			{
				$term->suffix = "";
			}

			$terms_lookup[$term->title]['classes'][$class->id]->weight = $term->weight;
			$terms_lookup[$term->title]['classes'][$class->id]->required = $term->required;
			$terms_lookup[$term->title]['classes'][$class->id]->requireTerm = $term->requireTerm;
			$terms_lookup[$term->title]['classes'][$class->id]->excludeOnTerm = $term->excludeOnTerm;
			$terms_lookup[$term->title]['classes'][$class->id]->requireClass = $term->requireClass;
			$terms_lookup[$term->title]['classes'][$class->id]->excludeOnClass = $term->excludeOnClass;

			// Merge prefixes
			if( ! isset($terms_lookup[$term->title]['prefix']))
			{
				$terms_lookup[$term->title]['prefix'] = $term->prefix;
			}
			else
			{
				if($terms_lookup[$term->title]['prefix'] == "")
				{
					$terms_lookup[$term->title]['prefix'] = $term->prefix;
				}
				else
				{
					if($term->prefix != "")
					{
						$terms_lookup[$term->title]['prefix'] .= "|" . $term->prefix;
					}
				}
			}
						
			// Merge suffixes
			if( ! isset($terms_lookup[$term->title]['suffix']))
			{
				$terms_lookup[$term->title]['suffix'] = $term->suffix;
			}
			else
			{
				if($terms_lookup[$term->title]['suffix'] == "")
				{
					$terms_lookup[$term->title]['suffix'] = $term->suffix;
				}
				else
				{
					if($term->suffix != "")
					{
						$terms_lookup[$term->title]['suffix'] .= "|" . $term->suffix;
					}
				}
			}
						
			$terms_lookup[$term->title]['classes'][$class->id]->classTitle = $class->title;
			$terms_lookup[$term->title]['classes'][$class->id]->hidden = $class->hidden;
			$terms_lookup[$term->title]['classes'][$class->id]->exclusive = $class->exclusive;
			$terms_lookup[$term->title]['classes'][$class->id]->thresholdWeight = $class->thresholdWeight;
			$terms_lookup[$term->title]['classes'][$class->id]->thresholdCount = $class->thresholdCount;
			$terms_lookup[$term->title]['classes'][$class->id]->thresholdCountUnique = $class->thresholdCountUnique;
		}
	}
}

/*
	Add the system settings to the lookup taxonomy
*/

$taxonomy_lookup->system = $taxonomy->system;

/*
	Add the classes to the lookup taxonomy
*/

$taxonomy_lookup->classes = $terms_lookup;

$taxonomy_lookup_json = json_encode($taxonomy_lookup);

/*
	Cleanup the JSON a little
*/

$taxonomy_lookup_json = str_replace("},", "},\n", $taxonomy_lookup_json);

file_put_contents($file_output_json, $taxonomy_lookup_json);


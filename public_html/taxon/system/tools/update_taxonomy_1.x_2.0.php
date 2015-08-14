<?php
/*
	File name: taxonomy_update.php
	Version:   2.1.2
	
	Description:
	taxonomy_update.php updates a taxonomy written in JSON from 1.x to
	2.x.
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

require '../includes/niceJSON.php';
/*
	Some settings
*/

mb_internal_encoding("UTF-8");

if( ! isset($argv[1]))
{
	print "\nError: No taxonomy was specified.\n";
	print "USAGE: php taxonomy_update.php /FULL/PATH/TO/TAXONOMY\n\n";
	
	exit;
}

$file_input_json = $argv[1];

$file_output_json = str_replace(".json", "_updated.json", $file_input_json);

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

$taxonomy_new;

/*
	Used for error reporting.
*/
$class_number = 0;

$found_errors = FALSE;

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

		$found_errors = TRUE;

		continue;
	}

	// Check whether the id of the class is defined	
	if( ! isset($class->id))
	{
		print "ID is not defined in class " . $class->title . "\n";

		$found_errors = TRUE;

		continue;
	}

	/*
		Get the terms and keep them for later.
		This way the terms is at the end of the class which makes for easier reading
	*/
	
	if(isset($class->terms))
	{
		$terms = $class->terms;
	}
	else
	{
		$terms = array();
	}
	
	/*
		Make sure variables for the class are defined
	*/
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
		
	if( ! isset($class->thresholdWeight))
	{
		$class->thresholdWeight = 5;
	}
		
	if( ! isset($class->thresholdCountUnique))
	{
		$class->thresholdCountUnique = 1;
	}
	
	/*
		Re-order the fields of the class
	*/
	
	$class_new = new StdClass;
	
	$class_new->id = $class->id;
	$class_new->title = $class->title;
	$class_new->hidden = $class->hidden;
	$class_new->exclusive = $class->exclusive;
	$class_new->thresholdCount = $class->thresholdCount;
	$class_new->thresholdWeight = $class->thresholdWeight;
	$class_new->thresholdCountUnique = $class->thresholdCountUnique;

	$taxonomy_new->classes->{$class->id} = $class_new;

	$terms_new = array();
	
	foreach ($terms as $term)
	{
		/*
			Make sure variables for the term are defined
		*/
		if( ! isset($term->title))
		{
			print "Term title is not defined in class " . $class->title . "\n";

			$found_errors = TRUE;

			continue;
		}

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
		
		/*
			Re-order the term fields
		*/
		
		$term_new = new StdClass;

		$term_new->title = $term->title;
		$term_new->weight =	$term->weight;
		$term_new->required =	$term->required;
		$term_new->requireTerm = $term->requireTerm;
		$term_new->excludeOnTerm = $term->excludeOnTerm;
		$term_new->requireClass = $term->requireClass;
		$term_new->excludeOnClass = $term->excludeOnClass;
		$term_new->prefix = $term->prefix;
		$term_new->suffix = $term->suffix;
		
		$taxonomy_new->classes->{$class->id}->terms->{$term_new->title} = $term_new;
	}
}

/*
	We found error(s) in the taxonomy.
*/
if($found_errors)
{
	print "Error: Error(s) were found in the taxonomy.\n";
	print "Make sure the JSON is valid and at least the class id, class title and term title are set.\n";

	exit;
}

/*
	Add the system settings to the new taxonomy
*/

$taxonomy_new->system = $taxonomy->system;

/*
	Add the version settings to the new taxonomy
*/

$versions;

$versions->taxonomy_version = "1.0";
$versions->taxon_version = "2.x";

$taxonomy_new->system->versions = $versions;

/*
	Add the information settings to the new taxonomy
*/

$information;

$information->taxonomy_name = "$file_input_json";

$taxonomy_new->system->information = $information;

/*
	Convert to JSON
*/

$taxonomy_new_json = json_encode($taxonomy_new);

/*
	Cleanup the JSON a little
*/

$taxonomy_new_json = niceJSON($taxonomy_new_json);

$taxonomy_new_json = toHumanUTF8($taxonomy_new_json);

file_put_contents($file_output_json, $taxonomy_new_json);

print "Updated $file_input_json to version 2.x. The new taxonomy is located at $file_output_json\n";



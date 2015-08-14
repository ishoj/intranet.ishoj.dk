<?php

/*
	File name: classify.php
	Version:   2.1.2
	
	Description:
	classify.php is the actual Taxon system. It classifies the 
	input text according to the input taxonomy.
	
	Functions:
	classify()
	actually_classify() (internal)
	classify_full() (internal)
	classify_without_constraints() (internal)
	getTermsAndClasses() (internal)
	cleanupTerms() (internal)
	cleanupClasses() (internal)
	applyClassConstraints() (internal)
	applyTermConstraints() (internal)
	sort_on_weight() (internal)
	
	Note that most parameters are passed by reference.

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
	calculateScores.php holds the functions:
		calculateScores
		calculateConfidenceCoefficient
*/

require dirname(__FILE__) . '/../includes/calculateScores.php';

$version = "2.x";

// Using locales are not really reliable, so we use a character list that 
// should cover most european languages.
// When used in regexps the text is always lowercase, so we do not need uppercase letters.
$special_characters = "ẅëẗÿüïöäḧẍẃéŕýúíóṕǻáśǵḱĺǽǿźćǘńḿẁèỳùìòàùǹåæøẽỹũĩõãṽñŵêŷûîôâŝĝĥĵẑĉ";


function classify($taxonomy, $text, $settings = array())
{
	$result = actually_classify($taxonomy, $text, $settings);
	
	if($result == "onNoResultsUseAlternativeTaxonomy")
	{
		/*
			Use alternative taxonomy
		*/

		$taxonomy = preg_replace("/(\.json)$/", "_alternative$1", $taxonomy);

		$result = actually_classify($taxonomy, $text, $settings);
	}

	return $result;
}

function actually_classify($taxonomy, $text, $settings = array())
{
	if($taxonomy == "")
	{
		return "No taxonomy";
	}
	
	if($text == "")
	{
		return "No text";
	}
	
	if( ! file_exists($taxonomy))
	{
		return "No taxonomy file: $taxonomy";
	}
		
	// Handle UFT8. Convert the text and the taxonomy name to lower for UTF8 characters as well
	mb_internal_encoding("UTF-8");

	$text = " " . mb_strtolower($text, 'UTF-8') . " ";
	
	/************** Start Create the lookup structure *************/
	/*
		Get the taxonomy from a JSON file.
	*/
	$file = file_get_contents($taxonomy);

	/*
		Create the lookup structure based on the taxonomy
	*/
	$taxonomy_lookup = json_decode($file);

	if($taxonomy_lookup == "")
	{		
		return "Taxonomy is invalid $taxonomy:" . $file;
	}

	/************** End Create the lookup structure *************/

	/************** Start Checking correct version of taxonomy *************/

	if(isset($taxonomy_lookup->system->versions->taxon_version))
	{
		global $version;
		
		if($taxonomy_lookup->system->versions->taxon_version != $version)
		{
				return "Taxonomy version expected '$version' but found '" . $taxonomy_lookup->system->versions->taxon_version . "'";
		}
	}
	else
	{
		return "Taxonomy version not set";
	}

	/************** End Checking correct version of taxonomy *************/


	/************** Handle settings, whether they come from the defaults in the taxonomy or as parameters in $settings ******/
	$numberResultsReturned = 5;

	if(isset($taxonomy_lookup->system->defaults->numberResultsReturned))
	{
		$numberResultsReturned = $taxonomy_lookup->system->defaults->numberResultsReturned;
	}

	if(isset($settings['numberResultsReturned']))
	{
		$numberResultsReturned = $settings['numberResultsReturned'];
	}

	$ignoreTermConstraints = 0;

	if(isset($taxonomy_lookup->system->defaults->ignoreTermConstraints))
	{
		$ignoreTermConstraints = $taxonomy_lookup->system->defaults->ignoreTermConstraints;
	}		

	if(isset($settings['ignoreTermConstraints']))
	{
		$ignoreTermConstraints = $settings['ignoreTermConstraints'];
	}
	
	$onNoResultsIgnoreTermConstraints = 0;

	if(isset($taxonomy_lookup->system->defaults->onNoResultsIgnoreTermConstraints))
	{
		$onNoResultsIgnoreTermConstraints = $taxonomy_lookup->system->defaults->onNoResultsIgnoreTermConstraints;
	}		

	if(isset($settings['onNoResultsIgnoreTermConstraints']))
	{
		$onNoResultsIgnoreTermConstraints = $settings['onNoResultsIgnoreTermConstraints'];
	}
	
	$onNoResultsUseAlternativeTaxonomy = 0;

	if(isset($taxonomy_lookup->system->defaults->onNoResultsUseAlternativeTaxonomy))
	{
		$onNoResultsUseAlternativeTaxonomy = $taxonomy_lookup->system->defaults->onNoResultsUseAlternativeTaxonomy;
	}		

	if(isset($settings['onNoResultsUseAlternativeTaxonomy']))
	{
		$onNoResultsUseAlternativeTaxonomy = $settings['onNoResultsUseAlternativeTaxonomy'];
	}
	
	$returnShortResult = 0;

	if(isset($taxonomy_lookup->system->defaults->returnShortResult))
	{
		$returnShortResult = $taxonomy_lookup->system->defaults->returnShortResult;
	}		

	if(isset($settings['returnShortResult']))
	{
		$returnShortResult = $settings['returnShortResult'];
	}
	
	$classification_done = 0;

	$classification_method = "Full classification";
	
	// Are we using an alternative taxonomy?
	if(preg_match("/_lookup_alternative.json$/", $taxonomy))
	{
		$classification_method = "Alternative taxonomy";
	}

	/************** End of Handle settings, whether they come from the defaults in the taxonomy or as parameters in $settings ******/

	/*
		Classify without the require/exclude/threshold constraints 
	*/
	
	if($ignoreTermConstraints)
	{
		if(($classification_done == 0) && ($ignoreTermConstraints == 1))
		{
			$classification_method = "IgnoreTermConstraints";

			$classes = classify_without_constraints($taxonomy_lookup, $text, $settings, $classification_method);

			$classification_done = 1;		
		}
	}
		
	/*
		Classify using the full require/exclude/treshold constraints.
		Also acts as a default. 
		Must be the last classification call because of the $classification_done check.
	*/
	
	if($classification_done == 0)
	{
		$classes = classify_full($taxonomy_lookup, $text, $settings, $classification_method);

		if(count($classes) == 0)
		{
			if(isset($onNoResultsIgnoreTermConstraints))
			{
				if($onNoResultsIgnoreTermConstraints == 1)
				{
					$classification_method = "onNoResultsIgnoreTermConstraints";

					$classes = classify_without_constraints($taxonomy_lookup, $text, $settings, $classification_method);
				}
			}
		}
		
		$classification_done = 1;		
	}
	
	/* 
		Sort the results.
		We sort according to the weight and the firstposition.
	*/

	uasort($classes, "sort_on_weight");

	/*
		Calculate the confidence coefficient
	*/
	
	calculateConfidenceCoefficient($classes);
	
	/*
		Return the max number of result.
	*/

	// 0 means return all
	if($numberResultsReturned > 0)
	{
		/* 
			array_splice does not garantee to preserve the numeric keys like
			our top level class ids, so we have to do the cutting slightly cumbersome. 
		*/

		$count = 1;
		
		foreach($classes as $classid => $class)
		{
			if($count > $numberResultsReturned)
			{
				unset($classes[$classid]);
			}

			$count++;
		}
	}
	
	// Should the result be in the short format
	if($returnShortResult)
	{
		$classes_string = "";
		
		foreach($classes as $classid => $class)
		{
			// The short format only returns ID and Title for each class
			$classes_string .= "$classid " . $class['title'] . "\n";
		}
		
		return $classes_string;
	}

	// What to do when there are no results
	if(empty($classes))
	{
		if($onNoResultsUseAlternativeTaxonomy == 1)
		{
			// Tell function classify to use an alternative taxonomy
			$json = "onNoResultsUseAlternativeTaxonomy";
		}
		else
		{
			$json = "";
		}
	}
	else
	{
		$json = json_encode($classes);
	}

	return $json;
}

/*** Functions ***/

function classify_full(&$taxonomy_lookup, &$text, $settings, $classification_method)
{
	/*
		As we find the terms and classes, keep them.
	*/

	$classes = array();
	$required = array();

	/*
		Step 1: Find the terms in the text. 
		
		Build a list of required terms as we are going along.
	*/

	getTermsAndClasses($text, $taxonomy_lookup, $classes, $required);

	/*
		Step 2: Clean up terms.
	*/

	cleanupTerms($classes);	

	/*
		Step 3: Check the require and exclude conditions.
	*/

	applyTermConstraints($classes, $taxonomy_lookup, $classification_method, $required, $text);		
	
	/*
		Step 4: Clean up classes.
	*/
	
	cleanupClasses($classes);	

	/*
		Step 5: Check the require and exclude conditions.
	*/
	
	applyClassConstraints($classes);		

	/*
		Step 6: Get the score for each class.
	*/

	calculateScores($classes);

	return $classes;
}

function classify_without_constraints(&$taxonomy_lookup, &$text, $settings, $classification_method)
{
	/*
		As we find the terms and classes, keep them.
	*/

	$classes = array();
	$required = array();

	/*
		Step 1: Find the terms in the text and return them and their classes.
	*/

	getTermsAndClasses($text, $taxonomy_lookup, $classes, $required);

	/*
		Step 2: Clean up terms.
	*/

	cleanupTerms($classes);

	/*
		Step 3: Clean up classes.
	*/

	cleanupClasses($classes);

	/*
		Step 4: Get the score for each class.
	*/
	
	calculateScores($classes);

	return $classes;
}

function getTermsAndClasses(&$text, &$taxonomy_lookup, &$classes, &$required)
{
	global $special_characters;
		
	foreach ($taxonomy_lookup->classes as $term_title => $term)
	{
		foreach($term->classes as $classid => $class)
		{		
			if($class->required == 1)
			{
				$required[$classid][$term_title] = 1;
			}
		}
		
		if(stripos($text, $term_title) !== FALSE)
		{			
			$term_prefix = $term->prefix != "" ? "(" . strtolower($term->prefix) . ")?" : "";
			$term_suffix = $term->suffix != "" ? "(" . strtolower($term->suffix) . ")?" : "";

			// Disarm special chars
			$matching_exp = $term_prefix . preg_quote($term_title, "/") . $term_suffix;

			$matching_exp = "/(?<=[^a-z0-9$special_characters\;\_\-])" . $matching_exp . "s?(?=[^a-z0-9$special_characters\&\_\-])/";

			if(preg_match_all($matching_exp, $text, $matches))
			{
				$hits = $matches[0];

				// Get the position for the first match
				preg_match($matching_exp, $text, $matches, PREG_OFFSET_CAPTURE);
			
				$firstpos = $matches[0][1];

				/*
					Calculate the score of the term for each class
				*/
				foreach ($term->classes as $classid => $term_info)
				{
					$score_weight = sizeof($hits) * $term_info->weight;
					$score_count = sizeof($hits);

					// Keep some class information
					$classes[$classid]['title'] = $term_info->classTitle;
					$classes[$classid]['exclusive'] = $term_info->exclusive;
					$classes[$classid]['hidden'] = $term_info->hidden;
					$classes[$classid]['thresholdWeight'] = $term_info->thresholdWeight;
					$classes[$classid]['thresholdCount'] = $term_info->thresholdCount;
					$classes[$classid]['thresholdCountUnique'] = $term_info->thresholdCountUnique;

					if( ! isset($classes[$classid]['terms']))
					{
						$classes[$classid]['terms'] = array();
					}
									
					$classes[$classid]['terms'][$term_title]->weight = $score_weight;
					$classes[$classid]['terms'][$term_title]->count = $score_count;
					$classes[$classid]['terms'][$term_title]->firstpos = $firstpos;

					foreach($hits as $hit)
					{
						if( isset($classes[$classid]['terms'][$term_title]->hits[$hit]))
						{
							$classes[$classid]['terms'][$term_title]->hits[$hit]++;
						}
						else
						{
							$classes[$classid]['terms'][$term_title]->hits[$hit] = 1;
						}
					}
					
					$classes[$classid]['terms'][$term_title]->requireTerm = $term_info->requireTerm;
					$classes[$classid]['terms'][$term_title]->excludeOnTerm = $term_info->excludeOnTerm;
					$classes[$classid]['terms'][$term_title]->requireClass = $term_info->requireClass;
					$classes[$classid]['terms'][$term_title]->excludeOnClass = $term_info->excludeOnClass;
					$classes[$classid]['terms'][$term_title]->required = $term_info->required;
					$classes[$classid]['terms'][$term_title]->hidden = $term_info->hidden;
				}
			}
		}
	}
}

function applyTermConstraints(&$classes, &$taxonomy_lookup, $classification_method, $required, &$text)
{
	/*
		To catch situations where class A requires class B which requires class C
		and class C is missing, we perform the check the number of time that there
		are classes.
	*/

	global $special_characters;

	$class_removed = 0;
	$max_loops = count($classes);
	
	for($loop = 0; $loop < $max_loops;$loop++)
	{
		foreach ($classes as $classid => $class)
		{
			$score_count = 0;
			$score_count_uniques = array();
			$score_weight = 0;

			// We need a place to set the classification method			
			$classes[$classid]['classificationMethod'] = $classification_method;
	
			/*
				We can have a situation where term A is checked against term B
				and then term B is removed, e.g. when requireClass for term A points to
				the same class and term B requires a certain word which is not present.
				
				So we loop if a term is removed to allow the other terms to check constraints
				again.
			*/

			$term_removed = 0;
			$term_max_loops = count($class['terms']);
				
			for($term_loop = 0; $term_loop < $term_max_loops;$term_loop++)
			{
				foreach ($class['terms'] as $term_title => $term)
				{
					$score_count_uniques[$term_title] = 1;
							
					/*
						For this term to be valid the required term(s) must be in the text.
					*/
					if($term->requireTerm != "")
					{
						$requiredtermtitle = $term->requireTerm;

						$matching_exp = "/(?<=[^a-z0-9$special_characters\;\_\-])(" . $requiredtermtitle . ")s?(?=[^a-z0-9$special_characters\&\_\-])/i";

						if( ! preg_match($matching_exp, $text))
						{
							// We did not find the term in the text, so remove the term from the result
							unset($classes[$classid]['terms'][$term_title]);

							$term_removed = 1;

							continue;
						}
					}

					/*
						For this term to be valid the excluding term(s) must not be in the text.
					*/
					if($term->excludeOnTerm != "")
					{
						$excludeontermtitle = $term->excludeOnTerm;
						
						$matching_exp = "/(?<=[^a-z0-9$special_characters\;\_\-])(" . $excludeontermtitle . ")s?(?=[^a-z0-9$special_characters\&\_\-])/i";
		
						if(preg_match($matching_exp, $text))
						{
							unset($classes[$classid]['terms'][$term_title]);
				
							$term_removed = 1;

							continue;
						}
					}

					/*
						For this term to be valid the required class must be in the list.
					*/
					if($term->requireClass != "")
					{

						$requiredclassid = $term->requireClass;
						
						if(isset($classes[$requiredclassid]) === FALSE)
						{
							unset($classes[$classid]['terms'][$term_title]);

							$term_removed = 1;

							continue;
						}
						else
						{
							/*
								It is possible for a term to require the class it lives in, so we need to check that at least one other term within the class was hit
							*/

							if($requiredclassid == $classid)
							{
								$found_another_term = 0;
					
								foreach($classes[$classid]['terms'] as $terms_term_title => $info)
								{
									if($term_title != $terms_term_title)
									{
										$found_another_term = 1;
							
										break;
									}
								}
					
								if($found_another_term == 0)
								{
									/*
										We did not find another term in the class, so remove this term. 
										Because this was the only term in the class the class will be removed.
									*/

									$term_removed = 1;

									unset($classes[$classid]['terms'][$term_title]);
								}
							}
						}
					}

					/*
						For this term to be valid the excluding class must not be in the list.
					*/
					if($term->excludeOnClass != "")
					{
						$excludeonclassid = $term->excludeOnClass;
			
						if(isset($classes[$excludeonclassid]) === TRUE)
						{
							$term_removed = 1;

							unset($classes[$classid]['terms'][$term_title]);

							continue;
						}
					}
		
					$score_weight += $term->weight;
					$score_count += $term->count;
				}
				
				if($term_removed == 0)
				{
					// No terms were removed to stop looping
					break;
				}
			}
			
			/*
				Check whether the required term(s) are present.
			*/

			if(isset($required[$classid]))
			{
				foreach($required[$classid] as $term_title => $info)
				{
					if( ! isset($classes[$classid]['terms'][$term_title]))
					{
						unset($classes[$classid]);
					}
				}
			}
			
			/*
				Check whether the terms in the class score high enough
			*/

			if(($score_count < $class['thresholdCount']) || ($score_weight < $class['thresholdWeight']))
			{
				unset($classes[$classid]);

				// We removed a class so force another check				
				$class_removed = 1;
				
				// Skip to the next class id
				continue;
			}

			/*
				Check whether the unique terms in the class score high enough
			*/

			$score_count_unique = count($score_count_uniques);
		
			if($score_count_unique < $class['thresholdCountUnique'])
			{
				unset($classes[$classid]);

				// We removed a class so force another check				
				$class_removed = 1;
				
				// Skip to the next class id
				continue;
			}

			/*
				Check whether the terms with the required flag set are present
			*/
			
			if(isset($required_terms[$classid]))
			{
				foreach($required_terms[$classid] as $term_title => $term)
				{
					if( ! in_array($term_title, array_keys($classes[$classid]['terms'])))
					{
						unset($classes[$classid]);

						// We removed a class so force another check				
						$class_removed = 1;
					}
				}
			}
		}
	}
}

function cleanupTerms(&$classes)
{
	/*
		Remove terms that are substrings of other terms.
		
		This is the slow but easy way to do it.
	*/
	
	$removeSubTerms = false;
	
	if($removeSubTerms == true)
	{
		foreach ($classes as $classid => $class)
		{
			foreach ($class['terms'] as $termtitle => $term)
			{
				foreach ($classes as $classid2 => $class2)
				{
					foreach ($class2['terms'] as $termtitle2 => $term2)
					{
						// Make a fast and simple check
						if(strlen($termtitle) > strlen($termtitle2))
						{
							// Make the slower and accurate check
							if((preg_match("/^$termtitle2\W/i", $termtitle, $matches)) || (preg_match("/\W$termtitle2\W/i", $termtitle, $matches)) || (preg_match("/\W$termtitle2$/i", $termtitle, $matches)))
							{
								unset($classes[$classid2]['terms'][$termtitle2]);
							}
						}
					}
				}
			}
		}
	}
}

function cleanupClasses(&$classes)
{
	/*
		Remove any empty classes.
	*/

	foreach ($classes as $classid => $class)
	{
		if(sizeof($class['terms']) == 0)
		{
			unset($classes[$classid]);
		}
	}
}

function applyClassConstraints(&$classes)
{
	/*
		Check whether the class is exclusive.
		
		Exclusive means that the class does not have
		any siblings at the same level.
	*/

	foreach ($classes as $classid => $class)
	{
		if($class['exclusive'] == 1)
		{
			$parent_classid = preg_replace("/\.[0-9]+$/", "", $classid);

			foreach($classes as $cid => $c)
			{
				$parent_cid = preg_replace("/\.[0-9]+$/", "", $cid);
				
				if(($cid != $classid) && ($parent_cid == $parent_classid))
				{
					/*
						Another sibling class was found, so remove this class
					*/
					unset($classes[$classid]);
					
					break;					
				}
			}
		}
	}

	/*
		Check whether the class is hidden
	*/

	foreach ($classes as $classid => $class)
	{
		if($class['hidden'] == 1)
		{
			/*
				The class is hidden, so remove it
			*/
			unset($classes[$classid]);
			
			break;					
		}
	}
}

function sort_on_weight($a, $b)
{
	/*
		Calculate the score for the 2 classes.
	*/
	
	$a_score = $a['scoreTotal'];
	$b_score = $b['scoreTotal'];
	
	if($a_score > $b_score)
	{
		return -1;
	}
	
	if($a_score < $b_score)
	{
		return 1;
	}

	// The words have equally score so rank them by the first position in the text
	// NOTE: Lesser is better.
	if($a['scorePosition'] < $b['scorePosition'])
	{
		return -1;
	}

	if($a['scorePosition'] > $b['scorePosition'])
	{
		return 1;
	}

	// Okay they are absolutely the same	
	return 0;
}

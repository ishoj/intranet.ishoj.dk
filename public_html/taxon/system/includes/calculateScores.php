<?php
/*
	File name: calculateScores.php
	Version:   2.1.2
	
	Description:
	calculateScores.php handles the calculation of the various
	scores return by Taxon.
	
	Functions:
	calculateScores()
	calculateConfidenceCoefficient()
	
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

function calculateScores(&$classes)
{
	/*
		Calculate the scores for each class.

		We get:
			a weight score, 
			a count score, 
			a position score and 
			a 'first class' score (is the class the first found in the text or not).
			a total score

	*/
	
	$last_classid = "";
	$first_position_classid = "";
	$last_position = 999999999;
	
	// We reward the first found term with some extra weight.
	$extra_weight_for_first_position = 10;

	foreach ($classes as $classid => $class)
	{
		$score_count = 0;
		$score_weight = 0;
		$score_position = 999999999;
		$score_first = FALSE;

		foreach ($class['terms'] as $termtitle => $term_info)
		{
			$score_count += $term_info->count;
			$score_weight += $term_info->weight;
		
			if($score_position > $term_info->firstpos)
			{
				$score_position = $term_info->firstpos;
			}
		}	

		$classes[$classid]['scoreCount'] = $score_count;
		$classes[$classid]['scoreWeight'] = $score_weight;
		$classes[$classid]['scorePosition'] = $score_position;
		$classes[$classid]['scoreFirstPosition'] = 0;

		// Termine whether the class includes the first found term.
		// If so, reward the class with som extra weight.

		if($last_position > $score_position)
		{
			if($last_classid != "")
			{
				// There might be more classes with the first position score				
				foreach($classes as $cid => $class)
				{
					$classes[$cid]['scoreFirstPosition'] = 0;
				}
			}

			$classes[$classid]['scoreFirstPosition'] = $extra_weight_for_first_position;

			$last_position = $score_position;
			$last_classid = $classid;
			$first_position_classid = $classid;
		}
		else
		{
			if($last_position == $score_position)
			{
				$classes[$classid]['scoreFirstPosition'] = $extra_weight_for_first_position;

				$last_position = $score_position;
				$last_classid = $classid;
				$first_position_classid = $classid;
			}
		}
		
		// Get the total score
		$classes[$classid]['scoreTotal'] = $classes[$classid]['scoreWeight'];
	}

	foreach ($classes as $classid => $class)
	{
		// Update score
		$classes[$classid]['scoreTotal'] += $classes[$classid]['scoreFirstPosition'];
	}
}

function calculateConfidenceCoefficient(&$classes)
{
	/*
		The confidence coefficient is the percentage that the 
		weight difference between the first and second divided
		by the totale weight of all classes.

		Note that $classes is passed by reference, so operations must
		directly on $classes.
	*/
	
	// With 1 class we are 100% certain that this is the class
	if(count($classes) == 1)
	{
		$class = reset($classes);
		$classid = key($classes);

		$classes[$classid]['scoreConfidenceCoefficient'] = 100;	
	}

	if(count($classes) > 1)
	{
		/*
			Find the difference in weight between first and second result.
		*/

		// Get the class IDs of the first and second result
		$results = array_slice($classes, 0, 2, TRUE);

		// Set the array pointer to the beginning
		reset($results);
		$classid_1 = key($results);

		// Point to the next element
		next($results);
		$classid_2 = key($results);

		$weight_difference = $classes[$classid_1]['scoreTotal'] - $classes[$classid_2]['scoreTotal'];
		
		$classes[$classid_1]['scoreConfidenceCoefficient'] = floor(($weight_difference / $classes[$classid_1]['scoreTotal']) * 100);
	}
}

?>

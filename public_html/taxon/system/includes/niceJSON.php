<?php
/*
	File name: niceJSON.php
	Version:   2.1.2
	
	Description:
	niceJSON.php provide some functions to convert a JSON text into
	a more human readable format.
	
	Functions:
	niceJSON()
	toHumanUTF8()
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
	The PHP jason functions return a very compact string. This
	function makes the JSON string easier to read.
*/

function niceJSON($text)
{
	$result = "";
	$inquote = false;

	$indent_str = "   ";
	$indent_count = 0;
	$newline = "\n";
	
	$len = strlen($text);
	
	$last_char = "";
			
	for($i = 0; $i < $len; $i++) 
	{
		$char = $text[$i];

	   if(($char == '"') && ($last_char != '\\'))
	   {
	   	$inquote = !$inquote;
	   }

		if($inquote)
		{
			$result .= $char;
		}
		else
		{
			switch($char) 
			{
				case '{':
				case '[':
					if($last_char == ",")
					{
						$result .= $char . $newline;
					}
					else
					{
						if(($last_char != '{') && ($last_char != '['))
						{
							$result .= $newline . str_repeat($indent_str, $indent_count);
						}
						
						$result .= $char . $newline;
					}
					
					if(($text[$i + 1] != '}') && ($text[$i + 1] != ']'))
					{
						$indent_count++;
						$result .= str_repeat($indent_str, $indent_count);
					}
					else
					{
						$result .= str_repeat($indent_str, $indent_count);
						$indent_count++;
					}
									
				
					break;
				case '}':
				case ']':
					$indent_count--;

					if(($last_char != '{') && ($last_char != '['))
					{
						$result .= $newline . str_repeat($indent_str, $indent_count);
					}
										
					$result .= $char;
				
					break;
				case ',':
					$result .= $char;
				
					$result .= $newline . str_repeat($indent_str, $indent_count);
					
					break;
				default:
					$result .= $char;
			}
		}
		
		$last_char = $char;
	}

	return $result;
}

function toHumanUTF8($text)
{
	$table = array(
		'\u00e6' => 'æ', '\u00f8' => 'ø', '\u00e5' => 'å',
	);

	return strtr($text, $table);
}
?>

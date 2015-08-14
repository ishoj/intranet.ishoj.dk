<?php
/*
	File name: preprocessText.php
	Version:   2.1
	
	Description:
	preprocessText can perform any kind of change to the text
	before it is passed on to the classification.
	
*/

/*
	Copyright 2012-13 by Halibut ApS.
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

function preprocessText(&$text)
{
	/*
		Handle Danish laws.
	*/
		
	$text = preg_replace("/(\wloven)s?\s*\§\s*([1-9][0-9]{0,3})/", "$1 §$2", $text);

	/*
		Handle weird font stuff.
	*/
		
	$text = preg_replace("/ﬂ/", "fl", $text);
}

?>

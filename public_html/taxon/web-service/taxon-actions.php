<?php
/*
	File name: taxon-actions.php
	Version:   2.1
	
	Description:
	taxon-action.php is a proxy to the Taxon actions, e.g. getclasses,
	getallclasses, getterms, getallterms. 
	It exposes an interface to the web.
	
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

if( ! isset($_POST['action']))
{
	print "No action";
	
	exit;
}

if( ! isset($_POST['taxonomy']))
{
	print "No taxonomy";
	
	exit;
}

$action = $_POST['action'];
$taxonomy = $_POST['taxonomy'];

switch($action)
{
	case 'getclasses':
		{
			require_once '../system/taxon/getclasses.php';

			if( ! isset($_POST['term_title']))
			{
				print "No term title";
	
				exit;
			}
			else
			{
				$term_title = $_POST['term_title'];
			}
			
			$result = getclasses($taxonomy, $term_title);
			
			break;
		}

	case 'getallclasses':
		{
			require_once '../system/taxon/getallclasses.php';

			$result = getallclasses($taxonomy);
			
			break;
		}

	case 'getterms':
		{
			require_once '../system/taxon/getterms.php';

			if( ! isset($_POST['classid']))
			{
				print "No classid";
	
				exit;
			}
			else
			{
				$classid = $_POST['classid'];
			}
			
			$result = getterms($taxonomy, $classid);
			
			break;
		}

	case 'getallterms':
		{
			require_once '../system/taxon/getallterms.php';

			$result = getallterms($taxonomy);
			
			break;
		}

	default:
		{
			$result = "No action";
		}
}

print $result;
?>


---------------------------------------------------------------------
About Taxon
---------------------------------------------------------------------

Taxon is an Open Source system for automatic classification of texts.
It relies on one or more taxonomies for the analysis of the texts,
see more in the documentation.

---------------------------------------------------------------------
Upgrading Taxon
---------------------------------------------------------------------
Read the VERSION.txt file for changes.

---------------------------------------------------------------------
Installing Taxon
---------------------------------------------------------------------

Create a directory for Taxon to live in, e.g. taxon/. Enter the directory.

---------------------------------------------------------------------
Installing Taxon core
---------------------------------------------------------------------
Unpack the file taxon-X.y.tar.gz with 

	tar -zxvf  taxon-web-service-X.y.tar.gz

Now there is a directory called taxon/.
 
The directory named system/ contains all the files for Taxon.

---------------------------------------------------------------------
The files
---------------------------------------------------------------------
includes/
	niceJSON.php
taxon/ 
	classify.php
	getclasses.php
	getterms.php
taxonomies/
	test.json
	test_lookup.json
test/
	test_getclasses.php
	test_getterms.php
	test_taxon.php
tools/
	make_lookup_taxonomy.php
	update_taxonomy.php

That's it!
Taxon is now install on your system.

To test Taxon go to the test/ directory and type:

	php test_taxon.php


Enter 'test' as the name of the taxonomy and 'Denmark' as the sample text.
If everything is okay the result is:
stdClass Object
(
    [01] => stdClass Object
        (
            [title] => EU countries
            [exclusive] => 0
            [hidden] => 0
            [thresholdWeight] => 5
            [thresholdCount] => 1
            [thresholdCountUnique] => 1
            [terms] => stdClass Object
                (
                    [denmark] => stdClass Object
                        (
                            [weight] => 5
                            [count] => 1
                            [firstpos] => 1
                            [hits] => stdClass Object
                                (
                                    [denmark] => 1
                                )
                            [requireTerm] => 
                            [excludeOnTerm] => 
                            [requireClass] => 
                            [excludeOnClass] => 
                            [required] => 0
                            [hidden] => 0
                        )
                )

            [scoreCount] => 1
            [scoreWeight] => 5
            [scorePosition] => 1
            [scoreFirstPosition] => 1
            [classificationMethod] => Full classification
        )
)


----------------------------------------------------------------------
More information about Taxon
----------------------------------------------------------------------
Visit the Taxon web site at http://www.taxon.dk/ for more information.

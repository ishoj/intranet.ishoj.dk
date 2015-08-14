-------------------------------------------------------------------------------
About Taxon Web service
-------------------------------------------------------------------------------

Taxon is an Open Source system for automatic classification of texts.
It relies on one or more taxonomies for the analysis of the texts, see more in 
the documentation.

Taxon web service is an interface for the Taxon system.

-------------------------------------------------------------------------------
Installing Taxon web service
-------------------------------------------------------------------------------

Usually you want to use Taxon as a web service.

Copy the file taxon-web-service-X.y.tar.gz (X.y is the version) to the
 same directory as Taxon-X.y.tar.gz, usually taxon/. 

Unpack the file with 

	tar -zxvf  taxon-web-service-X.y.tar.gz


Now there is a directory called web-service/.

Setup your web server to point to the web-service/ directory.

A quick test is to run 

	php test_web_service.php


It will ask for the taxonomy to use. As we have not yet installed a taxonomy, 
type './taxonomies/test_lookup.json'. As for the text, enter 'Denmark'.
For the url of the Taxon web service enter the correct URL.

The result should be:

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

If the result is some HTML with error codes in, check the setup of the web server.

--------------------------------------------------------------------------------
More information about Taxon
--------------------------------------------------------------------------------
Visit the Taxon web site at http://www.taxon.dk/ for more information.

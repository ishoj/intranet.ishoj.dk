
INTRODUCTION
------------
This module provides a means to centrally managed vocabularies and share them to client sites.

FEATURES
--------
 * Share a single vocabulary to multiple client sites.
 * Unique SHA-264 hash keys provide additional security when clients are pulling from the master.
 * Unlimited term depth compatibility.
 * Leverages UUID for consistent IDs across multiple sites.
 * Built to be as lightweight as possible.
 
INSTALLATION
------------
 Enable this module just like any other Drupal module.
 
CONFIGURATION
-------------
Any existing vocabulary can act as a client (sync) or a master (share). Configuration for the given vocabulary is done
by visiting the vocabulary admin form at admin/structure/taxonomy/%vocabulary_machine_name/edit.

To configure a vocabulary as a master:
 * Visit the admin form for the vocabulary.
 * Under the Taxonomy Sync fieldset, choose the Master option.
 * Save the form. Copy the master uri and the master key values for the client setup.
 
To configure a vocabulary as a client:
 * Visit the admin form for the vocabulary.
 * Under the Taxonomy Sync fieldset, choose the Client option.
 * Using the master key and master uri values from your master vocabulary, paste the data into the relevant form values.
 * Save the form. The vocabulary will sync on the next cron run.
 
NOTES
-----
The client will always try to maintain a strict copy of master terms. If terms on the client side are modified, they
will be updated/deleted on the next cron run depending on the state of those terms from the master vocabulary. Because 
of this, it is not possible (yet) to have terms in the client vocabulary that do not exists in the master vocab.

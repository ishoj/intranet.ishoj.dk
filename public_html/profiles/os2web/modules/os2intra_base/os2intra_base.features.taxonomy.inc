<?php
/**
 * @file
 * os2intra_base.features.taxonomy.inc
 */

/**
 * Implements hook_taxonomy_default_vocabularies().
 */
function os2intra_base_taxonomy_default_vocabularies() {
  return array(
    'os2intra_organizaiton_tax' => array(
      'name' => 'Organisation',
      'machine_name' => 'os2intra_organizaiton_tax',
      'description' => 'Indeholder organisationens hieraki',
      'hierarchy' => 0,
      'module' => 'taxonomy',
      'weight' => 0,
      'rdf_mapping' => array(
        'rdftype' => array(
          0 => 'skos:ConceptScheme',
        ),
        'name' => array(
          'predicates' => array(
            0 => 'dc:title',
          ),
        ),
        'description' => array(
          'predicates' => array(
            0 => 'rdfs:comment',
          ),
        ),
      ),
    ),
    'os2intra_tax_group_type' => array(
      'name' => 'Gruppe Type',
      'machine_name' => 'os2intra_tax_group_type',
      'description' => 'Hvilken type gruppe',
      'hierarchy' => 0,
      'module' => 'taxonomy',
      'weight' => 0,
      'rdf_mapping' => array(
        'rdftype' => array(
          0 => 'skos:ConceptScheme',
        ),
        'name' => array(
          'predicates' => array(
            0 => 'dc:title',
          ),
        ),
        'description' => array(
          'predicates' => array(
            0 => 'rdfs:comment',
          ),
        ),
      ),
    ),
  );
}

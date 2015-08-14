<?php
/**
 * @file
 * tvishoj.features.taxonomy.inc
 */

/**
 * Implements hook_taxonomy_default_vocabularies().
 */
function tvishoj_taxonomy_default_vocabularies() {
  return array(
    'tv_ish_j_indslagtaxon' => array(
      'name' => 'TV-Ishøj indslag',
      'machine_name' => 'tv_ish_j_indslagtaxon',
      'description' => '',
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

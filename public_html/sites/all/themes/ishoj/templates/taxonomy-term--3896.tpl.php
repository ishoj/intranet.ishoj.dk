<?php
/**
 * @file
 * Default theme implementation to display a term.
 *
 * Available variables:
 * - $name: (deprecated) The unsanitized name of the term. Use $term_name
 *   instead.
 * - $content: An array of items for the content of the term (fields and
 *   description). Use render($content) to print them all, or print a subset
 *   such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $term_url: Direct URL of the current term.
 * - $term_name: Name of the current term.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - taxonomy-term: The current template type, i.e., "theming hook".
 *   - vocabulary-[vocabulary-name]: The vocabulary to which the term belongs to.
 *     For example, if the term is a "Tag" it would result in "vocabulary-tag".
 *
 * Other variables:
 * - $term: Full term object. Contains data that may not be safe.
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $page: Flag for the full page state.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the term. Increments each time it's output.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_taxonomy_term()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<?php 
//dsm($term);
function sortByTitle($a, $b){
  return strcmp($a->title, $b->title);
}
function sortBysort($a, $b){
  return strcmp($a->field_cheat_sort['und'][0]['value'], $b->field_cheat_sort['und'][0]['value']);
}
  $output = "";

  // ----------------------------  //
  //  K A T E G O R I   S I D E R  //
  // ----------------------------  //
  if($term->vocabulary_machine_name == "kategori") {
  
//    $output = $output . "<!--  KATEGORI OVERSKRIFT START -->";
//    
//    if($term->description) {
//      $output = $output . "<section class=\"kategori-overskrift har-beskrivelse\">";
//    }
//    else {
//      $output = $output . "<section class=\"kategori-overskrift\">";
//    }
//    
//    if($term->field_kategoribillede) {
//      $output = $output . render($content['field_kategoribillede']);
//    }
    // Temp; skal slettes, når alle kategorisider har fået billeder
//    else {
//      $output = $output . "<img src=\"/sites/all/themes/ishoj/dist/img/diverse/kategori_aeldre3.jpg\">";
//    }
//      $output = $output . "<div class=\"kategori-container\">";
//        $output = $output . "<div class=\"container\">";
//          $output = $output . "<div class=\"row\">";
//            $output = $output . "<div class=\"grid-full\">";
//              $output = $output . "<h1>" . $term_name. "</h1>";
    
//              // BRØDKRUMMESTI
//              //this will be your top parent term if any was found
//              $top_parent_term = null;
//              $parent_terms = taxonomy_get_parents_all($term->tid);
//              //top parent term has no parents so find it out by checking if it has parents
//              $output .= "<p class=\"kategori-brodkrummesti\">";
//              $output .= "<a href=\"/\" title=\"Forside\"><span>Forside</span></a>";
//              $parent_i = 0;
//              foreach($parent_terms as $parent) {
//                $parent_parents = taxonomy_get_parents_all($parent->tid);
//                if ($parent_parents != false) {
//                  //this is top parent term
//                  $top_parent_term[$parent_i] = $parent;
//                  $parent_i++;
//                }
//              }
//              for($i = count($top_parent_term); $i > 0; $i--) {
//                if($top_parent_term[$i-1]->tid != $term->tid) {
//                  $output .= "<span> /</span><a href=\"" . url('taxonomy/term/' . $top_parent_term[$i-1]->tid) . "\" title=\"" . $top_parent_term[$i-1]->name . "\"><span> " . $top_parent_term[$i-1]->name . "</span></a>"; 
//                }
//                else {
//                  $output .= "<span> / " . $top_parent_term[$i-1]->name . "</span>"; 
//                }
//              }
//              $output .= "</p>";
//    
//              if($term->description) {
//                $output .= $term->description;
//              }
//            $output = $output . "</div>";
//          $output = $output . "</div>";
//        $output = $output . "</div>";
//      $output = $output . "</div>";
//    $output = $output . "</section>";
//    $output = $output . "<!-- KATEGORI OVERSKRIFT SLUT -->";
    
    // NYHEDER (TOPNYHEDER)
    $output .= "<!-- NYHEDER START -->";
    $output .= "<section class=\"news dark\">";
      $output .= "<div class=\"container\">";
        $output .= "<!-- Nyheder -->";
        $output .= "<div class=\"row\">";
          $output .= "<div class=\"grid-full\">";
            $output .= "<h2>NYHEDER</h2>";
    
    
              // BRØDKRUMMESTI
              //this will be your top parent term if any was found
//              $top_parent_term = null;
//              $parent_terms = taxonomy_get_parents_all($term->tid);
//              //top parent term has no parents so find it out by checking if it has parents
//              $output .= "<p class=\"kategori-brodkrummesti\">";
//              $output .= "<a href=\"/\" title=\"Forside\"><span>Forside</span></a>";
//              $parent_i = 0;
//              foreach($parent_terms as $parent) {
//                $parent_parents = taxonomy_get_parents_all($parent->tid);
//                if ($parent_parents != false) {
//                  //this is top parent term
//                  $top_parent_term[$parent_i] = $parent;
//                  $parent_i++;
//                }
//              }
//              for($i = count($top_parent_term); $i > 0; $i--) {
//                if($top_parent_term[$i-1]->tid != $term->tid) {
//                  $output .= "<span> /</span><a href=\"" . url('taxonomy/term/' . $top_parent_term[$i-1]->tid) . "\" title=\"" . $top_parent_term[$i-1]->name . "\"><span> " . $top_parent_term[$i-1]->name . "</span></a>"; 
//                }
//                else {
//                  $output .= "<span> / " . $top_parent_term[$i-1]->name . "</span>"; 
//                }
//              }
//              $output .= "</p>";
    
    

              $output .= "<div class=\"swiper-container-news\">";
                $output .= "<div class=\"swiper-wrapper\">";
                  $output .= views_embed_view('nyhedsliste','panel_pane_2', $node->nid);
                $output .= "</div>";
              $output .= "</div>";       

              $output .= "<div class=\"news-swiper-button-container\">";
                $output .= "<div class=\"swiper-button white news-swiper-button-prev\"></div>";
                  $output .= "<div class=\"swiper-button white news-swiper-button-next\"></div>";
                $output .= "</div>";
              $output .= "</div>";

            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</div>";
      $output = $output . "</div>";
    $output = $output . "</section>";
    $output .= "<!-- NYHEDER SLUT -->";

    
    // NYHEDSLISTE (ALLE MINUS TOPNYHEDER + EXPOSED FILTER)
//    if($term->vocabulary_machine_name == "kategori") {
//      if($term_name == "Aktiviteter") {
        $output .= "<section class=\"nyhedsside\">";
          $output .= "<div class=\"container\">";
            $output .= "<div class=\"row\">";

//              $output .= "<div class=\"activities node-visning\">";
//                $output .= "<div class=\"swiper-container-activities-aktivitetsside\">";
//                  $output .= "<div class=\"swiper-wrapper\">";
                    $output .= views_embed_view('nyhedsside','alle_nyheder_minus_topnyheder');
//                  $output .= "</div>";
//                $output .= "</div>";
//              $output .= "</div>";

    
    
            $output .= "</div>";
          $output .= "</div>";
        $output .= "</section>";
//      }
//    }


    
    
    
    
  }


?>




<?php 
  
  // BREAKING
  //print views_embed_view('kriseinformation', 'pagevisning');

  // OUTPUT
  print $output;



?>



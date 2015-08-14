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
dsm($term);

$output = "";

//$output .= "<h1>" . $term->tid . "</h1>";
    
    $output .= "<!-- ARTIKEL START -->";
      $output .= "<section id=\"taxonomy-term-" . $term->tid . "\" class=\"" . $classes . " aktivitetsside\">";
        $output .= "<div class=\"container\">";
           
         // Brødkrummesti
          $output .= "<div class=\"row\">";
            $output .= "<div class=\"grid-two-thirds\">";
              $output .= "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $term_name . "</p>";
            $output .= "</div>";
          $output .= "</div>";
           
          $output .= "<div class=\"row second\">";
            $output .= "<div class=\"grid-two-thirds\">";
              $output .= "<h1>Aktiviteter i kategorien \"" . $term_name . "\"</h1>";
//              $output .= "<h1>" . $term_name . "</h1>";
            $output .= "</div>";
            $output .= "<div class=\"grid-third sociale-medier social-desktop\"></div>";
          $output .= "</div>";
  
          $output .= "<div class=\"row\">";
//            $output .= "<div class=\"grid-two-thirds\">";

//              $output .= "<!-- ARTIKEL TOP START -->";
//              $output .= "<div class=\"artikel-top\">";
//              $output .= "</div>";
//              $output .= "<!-- ARTIKEL TOP SLUT -->";

//              $output .= "<h1>Jaaaaaa, det virker!</h1>";

//              $output .= render($content);

              // DEL PÅ SOCIALE MEDIER
//              include_once drupal_get_path('theme', 'ishoj') . '/includes/del-paa-sociale-medier.php';

              // SENEST OPDATERET
//              $output .= "<!-- SENEST OPDATERET START -->";
//              $output .= "<p class=\"last-updated\">Senest opdateret " . format_date($node->changed, 'senest_redigeret') . "</p>";
//              $output .= "<!-- SENEST OPDATERET SLUT -->";

//            $output .= "</div>";
            

            $output .= "<div class=\"activities node-visning\">";
              $output .= "<div class=\"swiper-container-activities-aktivitetsside\">";
                $output .= "<div class=\"swiper-wrapper\">";
                  $output .= views_embed_view('aktiviteter','aktivitet_aktiviteter_med_kategori', $term->tid);
                $output .= "</div>";
              $output .= "</div>";
            $output .= "</div>";

            // Højre kolonne
            // Flyt (prepend) højrekolonne ind i klassen .view-aktiviteter
//            $output .= "<div class=\"grid-third\">";
//              $output .= "<h2>Jaaaa, man!!!</h2>";
//            $output .= "</div>";            

          $output .= "</div>";
      $output .= "</div>";
    $output .= "</section>";
    $output .= "<!-- ARTIKEL SLUT -->";
    
    
    // DIMMER DEL SIDEN
    $options = array('absolute' => TRUE);
    // NODEVISNING
    // $nid = $node->nid; 
    // $abs_url = url('node/' . $nid, $options);
    // -----------
    // TAXONOMIVISNING
    $abs_url = url(substr($term_url, 1), $options);
    include_once drupal_get_path('theme', 'ishoj') . '/includes/dimmer-del-siden.php';
  


?>


<!--<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?>">-->

  <?php// if (!$page): ?>
<!--    <h2><a href="<?php //print $term_url; ?>"><?php //print $term_name; ?></a></h2>-->
  <?php //endif; ?>

<!--  <div class="content">-->
    <?php// print render($content); ?>
<!--  </div>-->

<!--</div>-->


<?php 
  
  // BREAKING
  print views_embed_view('kriseinformation', 'pagevisning');

  // OUTPUT
  print $output;



?>



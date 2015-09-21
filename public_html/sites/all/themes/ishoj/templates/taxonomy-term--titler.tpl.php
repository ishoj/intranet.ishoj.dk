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


dsm($term);
include_once drupal_get_path('theme', 'ishoj') . '/includes/uglen_functions.php';
$output = "";


    
$output .= "<!-- ARTIKEL START -->";
  $output .= "<section id=\"taxonomy-term-" . $term->tid . "\" class=\"" . $classes . " artikel\">";
    $output .= "<div class=\"container\">";
      
      // 1. RÆKKE
      $output .= "<div class=\"row\">";
        $output .= "<div class=\"grid-two-thirds\">";
          // Brødkrummesti
          $output .= "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $term_name . "</p>";
        $output .= "</div>";
      $output .= "</div>";

      // 2. RÆKKE
      $output .= "<div class=\"row second\">";
        $output .= "<div class=\"grid-two-thirds\">";
          $output .= "<h1>Stilling: " . $term_name . "</h1>";
        $output .= "</div>";
        $output .= "<div class=\"grid-third sociale-medier social-desktop\"></div>";
      $output .= "</div>";

      // 3. RÆKKE
      $output .= "<div class=\"row second\">";
        $output .= "<div class=\"grid-two-thirds\">";

          $output .= "<!-- ARTIKEL TOP START -->";
          $output .= "<div class=\"artikel-top\">";
          $output .= "</div>";
          $output .= "<!-- ARTIKEL TOP SLUT -->";

          // INDHOLD 
          $output .= vis_bruger_profiler('stilling', $term->tid); // Parametre, der kan anvendes: 'ansvarsområder', 'afdeling', 'stilling', 'færdigheder'  
          $output .= render($content);

        $output .= "</div>";
        $output .= "<div class=\"grid-third\">";

          // UDSKRIV INDHOLD TIL HØJRE KOLONNE

          // MENU TIL UNDERSIDER START
          // $output .= "<nav class=\"menu-underside\">";                    
          // $block = module_invoke('menu_block', 'block_view', '4');
          // $output .= render($block['content']);
          // $output .= "</nav>";
          // MENU TIL UNDERSIDER SLUT

        $output .= "</div>";              

    $output .= "</div>";
  $output .= "</div>";
$output .= "</section>";
$output .= "<!-- ARTIKEL SLUT -->";


// BREAKING
print views_embed_view('kriseinformation', 'pagevisning');

// OUTPUT
print $output;



?>



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
function sortByTitle($a, $b){
  return strcmp($a->title, $b->title);
}
  $output = "";

  // ----------------------------  //
  //  K A T E G O R I   S I D E R  //
  // ----------------------------  //
  if($term->vocabulary_machine_name == "kategori") {
  
    $output = $output . "<!--  KATEGORI OVERSKRIFT START -->";
    
    if($term->description) {
      $output = $output . "<section class=\"kategori-overskrift har-beskrivelse\">";
    }
    else {
      $output = $output . "<section class=\"kategori-overskrift\">";
    }
    
    if($term->field_kategoribillede) {
      $output = $output . render($content['field_kategoribillede']);
    }
    // Temp; skal slettes, når alle kategorisider har fået billeder
//    else {
//      $output = $output . "<img src=\"/sites/all/themes/ishoj/dist/img/diverse/kategori_aeldre3.jpg\">";
//    }
      $output = $output . "<div class=\"kategori-container\">";
        $output = $output . "<div class=\"container\">";
          $output = $output . "<div class=\"row\">";
            $output = $output . "<div class=\"grid-full\">";
              $output = $output . "<h1>" . $term_name. "</h1>";
    
              // BRØDKRUMMESTI
              //this will be your top parent term if any was found
              $top_parent_term = null;
              $parent_terms = taxonomy_get_parents_all($term->tid);
              //top parent term has no parents so find it out by checking if it has parents
              $output .= "<p class=\"kategori-brodkrummesti\">";
              $output .= "<a href=\"/\" title=\"Forside\"><span>Forside</span></a>";
              $parent_i = 0;
              foreach($parent_terms as $parent) {
                $parent_parents = taxonomy_get_parents_all($parent->tid);
                if ($parent_parents != false) {
                  //this is top parent term
                  $top_parent_term[$parent_i] = $parent;
                  $parent_i++;
                }
              }
              for($i = count($top_parent_term); $i > 0; $i--) {
                if($top_parent_term[$i-1]->tid != $term->tid) {
                  $output .= "<span> /</span><a href=\"" . url('taxonomy/term/' . $top_parent_term[$i-1]->tid) . "\" title=\"" . $top_parent_term[$i-1]->name . "\"><span> " . $top_parent_term[$i-1]->name . "</span></a>"; 
                }
                else {
                  $output .= "<span> / " . $top_parent_term[$i-1]->name . "</span>"; 
                }
              }
              $output .= "</p>";

    
              if($term->description) {
                $output .= $term->description;
              }
    
            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</div>";
      $output = $output . "</div>";
    $output = $output . "</section>";
    $output = $output . "<!-- KATEGORI OVERSKRIFT SLUT -->";

    if($term_name != "Aktiviteter") { // kategorierne vises ikke på aktivitetssiden
      $output = $output . "<!-- CONTENT CATEGORY START -->";
      $output = $output . "<section class=\"content-category\">";
        $output = $output . "<div class=\"container\">";
          $output = $output . "<div class=\"row\">";

            $output = $output . "<ul class=\"list-unstyled\">";
            $a = taxonomy_select_nodes($term->field_os2web_base_field_kle_ref['und'], $pager = FALSE); 
        $nodes = array();
        foreach($a as $nid) {
            $checkifitis = 0;
            // check if node are allready there
           foreach($nodes as $n) {
                if ($n->nid == $nid) {
                  $checkifitis = 1;
                }
            }
             if ($checkifitis == 0) {
            $nodes[] = node_load($nid);
              }
            }

    $taxo_child = taxonomy_get_children($tid, $vid = 0, $key = 'tid');
        dsm($taxo_child);    
        // UNDER KATEGORIER
         foreach($taxo_child as $termchild) {
    $output = $output . "<li class=\"grid-fourth\"><a href=\"" . url('taxonomy/term/' . $termchild->tid) . "\" title=\"" . $termchild->name . "\"><h3><span>" . $termchild->name . "</span></h3></a><li>";    
   }
        

        // NODER 
        
  usort($nodes, 'sortByTitle');
   foreach($nodes as $nid1) {
    $output = $output . "<li class=\"grid-fourth\"><a href=\"" . url('node/' . $nid1->nid) . "\" title=\"" . $nid1->title . "\"><h3><span>" . $nid1->title . "</span></h3></a><li>";    
   }

    
        


          $output = $output . "</div>";
        $output = $output . "</div>";
      $output = $output . "</section>";
      $output = $output . "<!-- CONTENT CATEGORY SLUT -->";
    }
    
  }




  // ----------------------------------- //
  //  S I D E N   A K T I V I T E T E R  //
  // ----------------------------------- //
  if($term->vocabulary_machine_name == "kategori") {
    if($term_name == "Aktiviteter") {
      $output .= "<section class=\"aktivitetsside\">";
        $output .= "<div class=\"container\">";
          $output .= "<div class=\"row\">";

            $output .= "<div class=\"activities node-visning\">";
              $output .= "<div class=\"swiper-container-activities-aktivitetsside\">";
                $output .= "<div class=\"swiper-wrapper\">";
//                  $output .= views_embed_view('aktiviteter','aktivitet_kommende_aktiviteter');
                $output .= "</div>";
              $output .= "</div>";
            $output .= "</div>";

          $output .= "</div>";
        $output .= "</div>";
      $output .= "</section>";
    }
  }





  // ----------------------------- //
  //  A K T I V I T E T S S T E D  //
  // ----------------------------- //
  elseif($term->vocabulary_machine_name == "aktivitetssted") {
     $output .= "<h1>Bingo!!!!</h1>";
  }

// ORGAN //
// ----- //
//------//

 
 if($term->vocabulary_machine_name == "os2web_taxonomies_tax_org") {
 $output .= "<!-- ARTIKEL START -->";
      $output .= "<section id=\"taxonomy-term-" . $term->tid . "\" class=\"" . $classes . " artikel\">";
        $output .= "<div class=\"container\">";
           
         // Brødkrummesti
          $output .= "<div class=\"row\">";
            $output .= "<div class=\"grid-two-thirds\">";
              $output .= "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $term_name . "</p>";
            $output .= "</div>";
          $output .= "</div>";
           
          $output .= "<div class=\"row second\">";
            $output .= "<div class=\"grid-two-thirds\">";
              $output .= "<h1>" . $term_name . "</h1>";
            $output .= "</div>";
            $output .= "<div class=\"grid-third sociale-medier social-desktop\"></div>";
          $output .= "</div>";
  
          $output .= "<div class=\"row second\">";
            $output .= "<div class=\"grid-two-thirds\">";

              $output .= "<!-- ARTIKEL TOP START -->";
              $output .= "<div class=\"artikel-top\">";
              $output .= "</div>";
              $output .= "<!-- ARTIKEL TOP SLUT -->";

 // UNDEROVERSKRIFT
                if($term->field_os2web_base_field_summary) {
                  $output .= "<h2>" . $term->field_os2web_base_field_summary['und'][0]['value'] . "</h2>";
                }
                
                // BODY 
                if($term->description) {
                  $output .= $term->description;
                }
                
                
                // REDIGÉR-KNAP
               /* if($logged_in) {
                  $output .= "<div style=\"position: relative; width: 100%; margin-bottom: 5.5em;\">";
                  $output .= "<div class=\"edit-node\"><a href=\"/taxonomy/term/" . $term->tid . "/edit\" title=\"Ret indhold\"><span>Ret indhold</span></a></div>";
                  $output .= "</div>";
                }
                */

            

// GET USERS FROM TERM REF - START
  $query = new EntityFieldQuery;
  $query->entityCondition('entity_type', 'user')->fieldCondition('field_afdeling', 'tid', $term->tid)->fieldOrderBy('field_kaldenavn', 'value', 'ASC');

 $results = $query->execute();

  if (isset($results['user'])) {
$termusers = user_load_multiple(array_keys($results['user']));    
  }
foreach ($termusers as $a_user) {
// GET USER START  - FROM USERNAME NOT UID
if($a_user){
$outputuser = "";
$outputuser .= "<div class=\"forfatter\">";
$outputuser .= "<ul class=\"search-employees show\">";
$outputuser .= "<li>";
// KALDENNAVN - FOR- OG EFTERNAVN
if ($a_user->field_kaldenavn['und'][0]['safe_value'] != '') {
$name = $a_user->field_kaldenavn['und'][0]['safe_value'];   
} 
else {
$name = $a_user->field_fornavn['und'][0]['safe_value'] . ' ' . $a_user->field_efternavn['und'][0]['safe_value'];  
}
if($a_user->field_fornavn and $a_user->field_efternavn) {
$outputuser .= "<a href=\"/users/" . $a_user->name . "\" titel=\"\"><span class=\"navn\">" . $name . "</span></a>";
}
$outputuser .= "<div class=\"foto\">";
$outputuser .= "<a class=\"foto\" href=\"/users/" . $a_user->name . "\" titel=\"" . $name . "\">";
// FOTO
if($a_user->picture) {
$outputuser .= "<img alt=\"" . $name . "\" src=\"" . image_style_url('profilfoto_lille', $a_user->picture->uri) . "\" />";
}
else {
$outputuser .= "<img alt=\"" . $name . "\" src=\"/sites/all/themes/ishoj/dist/img/sprites-no/nopic.png\" />";
}

// LEDIG/OPTAGET
//$output .= "<span class=\"optaget\"></span>";
$outputuser .= "</a>";
$outputuser .= "</div>";
$outputuser .= "<div class=\"details\">";
// STILLING
// field_titel_stilling['und'][0]['tid']
if($a_user->field_titel_stilling) {
$outputuser .= "<a href=\"" . url('taxonomy/term/' . $a_user->field_titel_stilling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($a_user->field_titel_stilling['und'][0]['tid'])->name . "\"><span class=\"titel\">" . taxonomy_term_load($a_user->field_titel_stilling['und'][0]['tid'])->name . "</span></a><br />";
}
// AFDELING
if($a_user->field_afdeling) {
 $outputuser .= "<a href=\"" . url('taxonomy/term/' . $a_user->field_afdeling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($a_user->field_afdeling['und'][0]['tid'])->name . "\"><span class=\"afdeling\">" . taxonomy_term_load($a_user->field_afdeling['und'][0]['tid'])->name . "</span></a><br />";
}
// TELEFON
if($a_user->field_direkte_telefon) {
$outputuser .= "<span class=\"telefon\">" . $a_user->field_direkte_telefon['und'][0]['safe_value'] . "</span><br />";
}
// E-MAIL
if($a_user->mail) {
 $outputuser .= "<a href=\"mailto:" . $a_user->mail . "\" titel=\"Send en mail til " . $name . "\"><span class=\"email\">" . $a_user->mail . "</span></a>";
}
$outputuser .= "</div>";
$outputuser .= "</li>";
$outputuser .= "</ul>";
$outputuser  .="</div>";
    
// GET USER END
$output .= $outputuser;
}
}
  $output .= render($content);
// GET USERS FROM TERM REF - END
   // SENEST OPDATERET
              $output .= "<!-- SENEST OPDATERET START -->";
//              $output .= "<p class=\"last-updated\">Senest opdateret " . format_date($node->changed, 'senest_redigeret') . "</p>";
              $output .= "<!-- SENEST OPDATERET SLUT -->";

            $output .= "</div>";
    
            $output .= "<div class=\"grid-third\">";
    
            
                // MENU TIL UNDERSIDER START
                //$output .= "<nav class=\"menu-underside\">";                    
                //$block = module_invoke('menu_block', 'block_view', '4');
                //$output .= render($block['content']);
                //$output .= "</nav>";
                // MENU TIL UNDERSIDER SLUT
             
            $output .= "</div>";              

        $output .= "</div>";
      $output .= "</div>";
    $output .= "</section>";
    $output .= "<!-- ARTIKEL SLUT -->";     
     
 }

  // --------------- //
  //  D E F A U L T  //
  // --------------- //
  else {
    
    $output .= "<!-- ARTIKEL START -->";
      $output .= "<section id=\"taxonomy-term-" . $term->tid . "\" class=\"" . $classes . " artikel\">";
        $output .= "<div class=\"container\">";
           
         // Brødkrummesti
          $output .= "<div class=\"row\">";
            $output .= "<div class=\"grid-two-thirds\">";
              $output .= "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $term_name . "</p>";
            $output .= "</div>";
          $output .= "</div>";
           
          $output .= "<div class=\"row second\">";
            $output .= "<div class=\"grid-two-thirds\">";
              $output .= "<h1>" . $term_name . "</h1>";
            $output .= "</div>";
            $output .= "<div class=\"grid-third sociale-medier social-desktop\"></div>";
          $output .= "</div>";
  
          $output .= "<div class=\"row second\">";
            $output .= "<div class=\"grid-two-thirds\">";

              $output .= "<!-- ARTIKEL TOP START -->";
              $output .= "<div class=\"artikel-top\">";
              $output .= "</div>";
              $output .= "<!-- ARTIKEL TOP SLUT -->";

              // ------------------------------  //
              //  P O L I T I S K   U D V A L G  //
              // ------------------------------  //
              if($term->vocabulary_machine_name == "politisk_udvalg") {
                  
                // UNDEROVERSKRIFT
                if($term->field_os2web_base_field_summary) {
                  $output .= "<h2>" . $term->field_os2web_base_field_summary['und'][0]['value'] . "</h2>";
                }
                
                // BODY 
                if($term->description) {
                  $output .= $term->description;
                }
                
                
                // REDIGÉR-KNAP
                if($logged_in) {
                  $output .= "<div style=\"position: relative; width: 100%; margin-bottom: 5.5em;\">";
                  $output .= "<div class=\"edit-node\"><a href=\"/taxonomy/term/" . $term->tid . "/edit\" title=\"Ret indhold\"><span>Ret indhold</span></a></div>";
                  $output .= "</div>";
                }

                
                // Medlemmer af det valgte udvalg
                //print views_embed_view('politisk_udvalg', 'taxonomivisning');
                $output .= "<h2>Medlemmer af " . $term_name . "</h2>";
                $output .= "<div class=\"politiker-liste\">";
                $output .= views_embed_view('politiker','politiker_liste', $term->tid);
                $output .= "</div>";
              }

              $output .= render($content);

              // DEL PÅ SOCIALE MEDIER
              include_once drupal_get_path('theme', 'ishoj') . '/includes/del-paa-sociale-medier.php';

              // SENEST OPDATERET
              $output .= "<!-- SENEST OPDATERET START -->";
//              $output .= "<p class=\"last-updated\">Senest opdateret " . format_date($node->changed, 'senest_redigeret') . "</p>";
              $output .= "<!-- SENEST OPDATERET SLUT -->";

            $output .= "</div>";
    
            $output .= "<div class=\"grid-third\">";
    
              // ------------------------------  //
              //  P O L I T I S K   U D V A L G  //
              // ------------------------------  //
              if($term->vocabulary_machine_name == "politisk_udvalg") {
                $output .= "<nav class=\"menu-underside\">";
                  $output .= "<p class=\"menu-header\">Politiske udvalg</p>";
                  $output .= "<ul class=\"menu\">";
                    $output .= "<li class=\"first expanded active-trail\">";
                      $output .= "<ul class=\"menu\">";
                        $output .= views_embed_view('udvalg','udvalgs_liste');
                      $output .= "</ul>";
                    $output .= "</li>";
                  $output .= "</ul>";
                $output .= "</nav>";
              }
              else {
                // MENU TIL UNDERSIDER START
                $output .= "<nav class=\"menu-underside\">";                    
                $block = module_invoke('menu_block', 'block_view', '4');
                $output .= render($block['content']);
                $output .= "</nav>";
                // MENU TIL UNDERSIDER SLUT
              }

            $output .= "</div>";              

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
  }


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



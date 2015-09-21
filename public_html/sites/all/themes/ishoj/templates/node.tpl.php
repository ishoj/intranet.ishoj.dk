<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */

dsm($node);
global $user;
?>


<?php
function sortByTitle($a, $b){
  return strcmp($a->title, $b->title);
}


function findusersbytags($contentwithtags) {
// FIND USERS IN CONTENT AND LOOP  - START            
$text = render($contentwithtags);
$re = "/\\W+@([\\pL\\d]+)/u"; 
preg_match_all($re, $text, $matches);
foreach ($matches[1] as $foundusers) {
// GET USER START  - FROM USERNAME NOT UID
$a_user = user_load_by_name($foundusers);
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
$text = str_replace("@" . $foundusers,$outputuser,$text);
}
}

// FIND USERS IN CONTENT AND LOOP  - END
    
    
return $text;    
}

$output = "";
?>

                     
        <!-- ARTIKEL START -->
<?php       

        if($node->field_indholdstype) {
          // Hvis kriseinformation 
          if(taxonomy_term_load($node->field_indholdstype['und'][0]['tid'])->name == "Kriseinformation") {
            $output = $output . "<section id=\"node-" . $node->nid . "\" class=\"" . $classes . " artikel breaking-artikel\">";
          }
          else {
            $output = $output . "<section id=\"node-" . $node->nid . "\" class=\"" . $classes . " artikel\">";
          }
        }
        else {
          $output = $output . "<section id=\"node-" . $node->nid . "\" class=\"" . $classes . " artikel\">";
        }

         
          $output = $output . "<div class=\"container\">";

// Get menu from kategori term ref by term KLE                     
    $query = new EntityFieldQuery;
$result2 = $query
  ->entityCondition('entity_type', 'taxonomy_term')
  ->propertyCondition('vid', 16)
  ->fieldCondition('field_os2web_base_field_kle_ref', 'tid', $node->field_os2web_base_field_kle_ref['und'][0]['tid'])
  ->execute();
$bufcount = 0;
$buftid = 0; 
foreach($result2 as $v1) {
foreach($v1 as $v2) {
if ($bufcount == 0) {   
$buftid = $v2->tid;
++$bufcount;
}        
}    
}                       
$bterm = taxonomy_term_load($buftid);  



             // Brødkrummesti
            $output = $output . "<div class=\"row\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
              //  $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $title . "</p>";
 $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " .  "<a href=\"" . url('taxonomy/term/' . $bterm->tid) . "\" title=\"Kategorien " . $bterm->name . "\">" . $bterm->name . "</a>" . " / " . $title . "</p>";
              $output = $output . "</div>";
            $output = $output . "</div>";

           
            $output = $output . "<div class=\"row second\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                  $output = $output . "<h1 id=\"main-content\">" . $title . "</h1>";
              $output = $output . "</div>";
              $output = $output . "<div class=\"grid-third sociale-medier social-desktop\">";
                // TALEBOBLE
                if($node->comment_count > 0) {
//                    $output = $output . "<a class=\"taleboble\">" . $node->comment_count . "</a>";
                    $output = $output . "<a href=\"#kommentarer\" class=\"taleboble\" title=\"Der er " . $node->comment_count . " kommentarer til dette indlæg\"><span>" . $node->comment_count . "</span></a>";
                }
              $output = $output . "</div>";
            $output = $output . "</div>";
  
            $output = $output . "<div class=\"row second\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                $output = $output . "<!-- ARTIKEL TOP START -->";
                $output = $output . "<div class=\"artikel-top\">";
                    // FOTO
                    $output = $output . "<!-- FOTO START -->";
                    
                    if($node->field_os2web_base_field_image) {
                      hide($content['field_image_flexslider']);
                        
                      $output = $output . render($content['field_os2web_base_field_image']);
                      if($node->field_billedtekst) {
                        $output = $output . "<p class=\"foto-tekst\">" . $node->field_billedtekst['und'][0]['value'] . "</p>";
                      }
                    }
                    $output = $output . "<!-- FOTO SLUT -->";

                    // FLEXSLIDER
                    $output = $output . "<!-- FLEXSLIDER START -->";
                    if(($node->field_image_flexslider) and (!$node->field_os2web_base_field_image)) {
                      $output = $output . "<div class=\"flexslider\">";
                        $output = $output . "<ul class=\"slides\">";
                        $length = sizeof($node->field_image_flexslider['und']);
                        for ($i = 0; $i < $length; $i++) {
                          $output = $output . "<li>" . render($content['field_image_flexslider'][$i]) . "</li>"; 
                        }
                        $output = $output . "</ul>";                  
                      $output = $output . "</div>";
                    }
                    $output = $output . "<!-- FLEXSLIDER SLUT -->";

                    // VIDEO
                    $output = $output . "<!-- VIDEO START -->";
                    if(($node->field_video) and (!$node->field_os2web_base_field_image) and (!$node->field_image_flexslider)) {
                      $output = $output . "<div class=\"video-indlejret\">";
                        $output = $output . "<div class=\"embed-container vimeo\">";
                          $output = $output . $node->field_video['und'][0]['value'];
                        $output = $output . "</div>";
                      $output = $output . "</div>";
                      if ($node->field_videotekst) {
                        $output = $output . "<p class=\"video-tekst\">" . $node->field_videotekst['und'][0]['value'] . "</p>";
                      }
                    }
                    $output = $output . "<!-- VIDEO SLUT -->";

                $output = $output . "</div>";
                $output = $output . "<!-- ARTIKEL TOP SLUT -->";
                
                // UNDEROVERSKRIFT
                $output = $output . "<!-- UNDEROVERSKRIFT START -->";
                if($node->field_os2web_base_field_summary) {
                  $output = $output . "<h2>" . $node->field_os2web_base_field_summary['und'][0]['safe_value'] . "</h2>";
                }
                $output = $output . "<!-- UNDEROVERSKRIFT SLUT -->";
               
                // SELVBETJENINGSLØSNING
                if($node->field_field_url_3) {
                  $output = $output . "<!-- SELBETJENINGSLØSNING START -->";
                  
                  foreach ($node->field_field_url_3['und'] as $value) {
                    $output = $output . "<p>";
                      $output = $output . "<a class=\"btn btn-large selvbetjening\" href=\"" . $value['url'] . "\" title=\"" . $value['title'] . "\">";
                        $output = $output . "<span class=\"sprites-sprite sprite-arrow-right\"></span>";
                        $output = $output . $value['title'];
                      $output = $output . "</a>";
                    $output = $output . "</p>";
                  }
                  
                  $output = $output . "<!-- SELBETJENINGSLØSNING SLUT -->";
                }
                
                // TEKSTINDHOLD
                $output = $output . "<!-- TEKSTINDHOLD START -->";
                hide($content['comments']);
                hide($content['links']);

$output = $output . findusersbytags($content);
             $output = $output . "<!-- TEKSTINDHOLD SLUT -->";
                              
                // MIKROARTIKLER
                $output = $output . "<!-- MIKROARTIKLER START -->";
                if($node->field_mikroartikler_titel1 or 
                  $node->field_mikroartikler_titel2 or 
                  $node->field_mikroartikler_titel3 or 
                  $node->field_mikroartikler_titel4 or 
                  $node->field_mikroartikler_titel5 or 
                  $node->field_mikroartikler_titel6 or 
                  $node->field_mikroartikler_titel7 or 
                  $node->field_mikroartikler_titel8 or 
                  $node->field_mikroartikler_titel9 or 
                  $node->field_mikroartikler_titel10) {

                  $mikroartikel = '<div class="microArticleContainer">';

                  if($node->field_mikroartikler_titel1) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle1"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel1['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle1 mArticle">' . $node->field_mikroartikler_tekst1['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel2) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle2"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel2['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle2 mArticle">' . $node->field_mikroartikler_tekst2['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel3) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle3"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel3['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle3 mArticle">' . $node->field_mikroartikler_tekst3['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel4) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle4"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel4['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle4 mArticle">' . $node->field_mikroartikler_tekst4['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel5) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle5"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel5['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle5 mArticle">' . $node->field_mikroartikler_tekst5['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel6) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle6"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel6['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle6 mArticle">' . $node->field_mikroartikler_tekst6['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel7) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle7"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel7['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle7 mArticle">' . $node->field_mikroartikler_tekst7['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel8) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle8"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel8['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle8 mArticle">' . $node->field_mikroartikler_tekst8['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel9) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle9"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel9['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle9 mArticle">' . $node->field_mikroartikler_tekst9['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel10) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle10"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel10['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle10 mArticle">' . $node->field_mikroartikler_tekst10['und'][0]['safe_value'] . '</div></div>';
                  }
                  if($node->field_mikroartikler_titel11) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle11"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel11['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle11 mArticle">' . $node->field_mikroartikler_tekst11['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel12) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle12"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel12['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle12 mArticle">' . $node->field_mikroartikler_tekst12['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel13) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle13"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel13['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle13 mArticle">' . $node->field_mikroartikler_tekst13['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel14) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle14"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel14['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle14 mArticle">' . $node->field_mikroartikler_tekst14['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel15) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle15"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel15['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle15 mArticle">' . $node->field_mikroartikler_tekst15['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel16) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle16"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel16['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle16 mArticle">' . $node->field_mikroartikler_tekst16['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel17) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle17"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel17['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle17 mArticle">' . $node->field_mikroartikler_tekst17['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel18) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle18"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel18['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle18 mArticle">' . $node->field_mikroartikler_tekst18['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel19) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle19"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel19['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle19 mArticle">' . $node->field_mikroartikler_tekst19['und'][0]['safe_value'] . '</div></div>';
                  }

                  if($node->field_mikroartikler_titel20) {
                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h3 class="mArticle" id="mArticle20"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel20['und'][0]['safe_value'] . '</h3>';
                    $mikroartikel = $mikroartikel . '<div class="mArticle20 mArticle">' . $node->field_mikroartikler_tekst20['und'][0]['safe_value'] . '</div></div>';
                  }

                  $mikroartikel = $mikroartikel . "</div>";
                    
                    $output = $output . findusersbytags($mikroartikel);
                    
                 // $output = $output . $mikroartikel;	
                }
                $output = $output . "<!-- MIKROARTIKLER SLUT -->";


                // FILER
                if($node->field_os2web_base_field_media) {
                  $output .= "<h2>Vedhæftede filer</h2>";
                  $output .= "<ul class=\"bilag\">";
                  foreach ($node->field_os2web_base_field_media['und'] as $filevalue) {
                    $output = $output . "<li class=\"pdf\">";
                      $output = $output . "<a href=\"" . file_create_url($filevalue['uri']) . "\" title=\"" . $filevalue['filename'] . "\">";
                        $output = $output . $filevalue['filename'];
                      $output = $output . "</a>";
                    $output = $output . "</li>";
                  }
                  $output = $output . "</ul>";
                }
                

                // --------------------------------- //
                //  S P E C I F I K K E   N O D E R  //
                // --------------------------------- //

                // NODEN "Politiske udvalg" - node-id: 796
//                if($node->nid == 796) {
//                  $output .= "<ul>" . views_embed_view('udvalg','udvalgs_liste') . "</ul>";
//                }


                // ------------------------------------------------- //
                //  S P E C I F I K K E   I N D H O L D S T Y P E R  //
                // ------------------------------------------------- //




                if($node->field_indholdstype) {
                  
                  // Hvis det ikke er af typen kriseinformation 
                  if(taxonomy_term_load($node->field_indholdstype['und'][0]['tid'])->name <> "Kriseinformation") {
                                                    
                    // DIVERSE BOKS
                    $output = $output . "<!-- DIVERSE BOKS START -->";
                    if($node->field_diverse_boks) {
                      $output = $output . "<div class=\"diverse-boks\">";
                      $output = $output . $node->field_diverse_boks['und'][0]['safe_value'];
                      $output = $output . "</div>";
                    }
                    $output = $output . "<!-- DIVERSE BOKS SLUT -->";
                  }
                }
                
                
                // LÆS OGSÅ
                $output = $output . "<!-- LÆS OGSÅ START -->";
                if($node->field_url) {
                  if($node->field_diverse_boks) {
                    $output = $output . "<hr>";
                  }
                  $output = $output . "<h2>Læs også</h2>";
                  $output = $output . "<ul>";
                  foreach ($node->field_url['und'] as $value) {
                    $output = $output . "<li>";
                      $output = $output . "<a href=\"" . $value['url'] . "\" title=\"" . $value['title'] . "\">";
                        $output = $output . $value['title'];
                      $output = $output . "</a>";
                    $output = $output . "</li>";
                  }
                  $output = $output . "</ul>";
                }
                $output = $output . "<!-- LÆS OGSÅ SLUT -->";


               
                


                
                // SENEST OPDATERET
                $output = $output . "<!-- SENEST OPDATERET START -->";
                $output = $output . "<p class=\"last-updated\">Senest opdateret " . format_date($node->changed, 'senest_redigeret') . "</p>";
                $output = $output . "<!-- SENEST OPDATERET SLUT -->";
                

                // REDIGÉR-KNAP
                if($logged_in) {
                  $output .= "<div style=\"float: left; width: 100%; margin-bottom: 1em;\"><div class=\"edit-node\"><a href=\"/node/" . $node->nid . "/edit?destination=admin/content\" title=\"Ret indhold\"><span>Ret indhold</span></a></div></div>";
                }


                // KOMMENTARER
                if($node->comment_count > 0) {
                  $output .= "<h2 id=\"kommentarer\">Kommentarer</h2>";
                  $output .= "<p><a href=\"#kommentar-formular\" title=\"Tilføj ny kommentar\">Tilføj ny kommentar</a></p>";                }
                $output .= "<div class=\"kommentarer\">";

                  $output .= render($content['comments']); 
                $output .= "</div>";



                $output = $output . "</div>";
              
              
              // HVIS NODEN ER AF TYPEN INDHOLD, BORGER.DK-ARTIKEL ELLER AKTIVITET 
              if(($node->type == 'os2web_base_contentpage') or ($node->type == 'nyheder')) {
                
                $output = $output . "<div class=\"grid-third\">";

                  // FORFATTER INFORMATION
                  $output .= "<div class=\"forfatter-container\"><div class=\"forfatter\"><p><em>Skrevet af:</em></p>" . views_embed_view('forfatter','default', $node->nid) . "</div></div>"; 
                
                // HVIS DER ER VALGT EN INDHOLDSTYPE VED "OPRET INDHOLD"
                if($node->field_indholdstype) {

                  
                  // Hvis indholdstypen er en kriseinformation 
                  if(taxonomy_term_load($node->field_indholdstype['und'][0]['tid'])->name == "Kriseinformation") {
                    // DIVERSE BOKS
                    $output = $output . "<!-- DIVERSE BOKS START -->";
                    if($node->field_diverse_boks) {
                      $output = $output . "<div class=\"diverse-boks\">";
                      $output = $output . $node->field_diverse_boks['und'][0]['safe_value'];
                      $output = $output . "</div>";
                    }
                    $output = $output . "<!-- DIVERSE BOKS SLUT -->";
                  }

                // VÆRKTØJER START
                $output = $output . "<!-- VÆRKTØJER START -->";
                if($node->field_url_2) {
                     $output = $output . "<nav class=\"menu-underside\">";
                    $output = $output . "<ul class=\"menu\">";
                      $output = $output . "<li class=\"first expanded active-trail\">";
                        $output = $output . "<a href=\"#\">VÆRKTØJER</a></li>";
                    
                 
                  foreach ($node->field_url_2['und'] as $value) {
                    $output = $output . "<li><a href=\"" . $value['url']  . "\" title=\"" . $value['title'] . "\">" . $value['title'] . "</a></li>"; 
                    
                    
                  }
                   $output = $output . "</ul>";
                    $output = $output . "</nav>";
                }
                $output = $output . "<!-- VÆRKTØJER SLUT -->";
                
                  


                
                  
                  
 
                // ANDEN KLE MENU START
                $output = $output . "<!-- ANDEN KLE START -->";
                if($node->field_anden_kle_menu) {
                     $output = $output . "<nav class=\"menu-underside\">";
                    $output = $output . "<ul class=\"menu\">";
                      $output = $output . "<li class=\"first expanded active-trail\">";
                    $termandelkle = taxonomy_term_load($node->field_anden_kle_menu['und'][0]['tid']);
               
                    $output = $output . "<a href=\"#\">" . $termandelkle->description . "</a></li>";
                  
                   $a = taxonomy_select_nodes($node->field_anden_kle_menu['und'], $pager = FALSE); 
                        $nodes = array();
                        foreach($a as $nid) {
                          $checkifitis = 0;
                          foreach($nodes as $n) {
                            if ($n->nid == $nid) {
                              $checkifitis = 1;
                            }
                          }
                          if ($checkifitis == 0) {
                            $nodes[] = node_load($nid);
                          }
                        }
                        usort($nodes, 'sortByTitle');
                        foreach($nodes as $nid1) {
                          if ($node->nid != $nid1->nid) {
                            $output = $output . "<li><a href=\"" . url('node/' . $nid1->nid) . "\" title=\"" . $nid1->title . "\">" . $nid1->title . "</a></li>"; 
                          }
                        }
                    
                    
                    
                   $output = $output . "</ul>";
                    $output = $output . "</nav>";
                }
                $output = $output . "<!-- ANDEN KLE SLUT -->";                    
                    $a1 = array();
                    // MENU TIL UNDERSIDER START
                    $output = $output . "<nav class=\"menu-underside\">";
                   $output = $output . "<ul class=\"menu\">";
                      $output = $output . "<li class=\"first expanded active-trail\">";
                        $output = $output . "<a href=\"#\">" . $node->title . "</a>";
                        $output = $output . "<ul class=\"menu\">";
                        $a1 = taxonomy_select_nodes($node->field_os2web_base_field_kle_ref['und'], $pager = FALSE); 
                        $nodes = array();
                        foreach($a1 as $nid) {
                          $checkifitis = 0;
                          foreach($nodes as $n) {
                            if ($n->nid == $nid) {
                              $checkifitis = 1;
                            }
                          }
                        
                          if ($checkifitis == 0) {
                            $nodes[] = node_load($nid);
                          }
                        }
                        usort($nodes, 'sortByTitle');
                        foreach($nodes as $nid1) {
                          if ($node->nid != $nid1->nid) {
                            $output = $output . "<li><a href=\"" . url('node/' . $nid1->nid) . "\" title=\"" . $nid1->title . "\">" . $nid1->title . "</a></li>"; 
                          }
                        }

                      //  $output = $output . "<li class=\"active active-trail\"><a href=\"#\">Lorem ipsum dolor</a></li>";
                      $output = $output . "</ul>";
                      $output = $output . "</li>";
                      // GET ALL NOTES FROM KLE REF BY TERM KLE
                      $a = taxonomy_select_nodes($bterm->field_os2web_base_field_kle_ref['und'], $pager = FALSE); 
                      $nodes = array();
                      foreach($a as $nid2) {
                        $checkifitis = 0;
                        // check if node are allready there
                        foreach($nodes as $n) {
                          if ($n->nid == $nid2) {
                            $checkifitis = 1;
                          }
                        }
                         // TJEK AGAIN
                          foreach($a1 as $n1) {
                          if ($n1 == $nid2) {
                              $checkifitis = 1;
                            }
                          }    
                        if ($checkifitis == 0) {
                          $nodes[] = node_load($nid2);
                        }
                      }
                      usort($nodes, 'sortByTitle');
                      foreach($nodes as $nid1) {
                        if ($node->nid != $nid1->nid) {
                         $output = $output . "<li class=\"collapsed\"><a href=\"" . url('node/' . $nid1->nid) . "\" title=\"" . $nid1->title . "\">" . $nid1->title . "</a><li>";
                        }
                      }
                      $output = $output . "</ul>";                  
                      // til BLOCK MENU SITES
                      // $block = module_invoke('menu_block', 'block_view', '4');
                      // $output.= render($block['content']);

                    $output = $output . "</nav>";
                    // MENU TIL UNDERSIDER SLUT                  
                }
                
                
                  // HVIS NODEN ER EN NYHED MED EN REFERENCE TIL ET NYHEDSBREV
                  $output .= "<!-- NYHEDER FRA SAMME NYHEDSBREV START -->";
                  if($node->field_nyhedsbrev) {
                    $output .= "<nav class=\"menu-underside\">";
                      $output .= "<p class=\"menu-header\">". taxonomy_term_load($node->field_nyhedsbrev['und'][0]['tid'])->name . "</p>";
                      $output .= "<ul class=\"menu\">";
                        $output .= "<li class=\"first expanded active-trail\">";
                          $output .= "<ul class=\"menu\">";
                            $output .= views_embed_view('nyhedsliste','boks_nyheder_fra_samme_nyhedsbrev', $node->field_nyhedsbrev['und'][0]['tid']);
                          $output .= "</ul>";
                        $output .= "</li>";
                      $output .= "</ul>";
                    $output .= "</nav>";
                  }
                  $output .= "<!-- NYHEDER FRA SAMME NYHEDSBREV START -->";
                
                

                $output = $output . "</div>";
              }
              
            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</section>";
        $output = $output . "<!-- ARTIKEL SLUT -->";

       


          // BREAKING
          $output .= views_embed_view('kriseinformation','nodevisning', $node->nid); 

        print $output;
        //print render($content['links']);
        

?>

       


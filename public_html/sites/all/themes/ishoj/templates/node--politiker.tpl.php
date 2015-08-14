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
?>




<?php dsm($node); //drupal_set_message('<pre>' . print_r($node, TRUE) . '</pre>'); ?>

<?php
$output = "";
?>

                     
        <!-- ARTIKEL START -->
<?php       
        $output = $output . "<section id=\"node-" . $node->nid . "\" class=\"" . $classes . " artikel\">";
         
          $output = $output . "<div class=\"container\">";
           
           // Brødkrummesti
            $output = $output . "<div class=\"row\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $title . "</p>";
              $output = $output . "</div>";
            $output = $output . "</div>";

           
            $output = $output . "<div class=\"row second\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                $output = $output . "<h1>" . $title . "</h1>";
              $output = $output . "</div>";
              $output = $output . "<div class=\"grid-third sociale-medier social-desktop\"></div>";
            $output = $output . "</div>";
  
            $output = $output . "<div class=\"row second\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                $output = $output . "<!-- ARTIKEL TOP START -->";
                $output = $output . "<div class=\"artikel-top\">";

                  // UNDEROVERSKRIFT / PARTI 
                  if($node->field_er_byraadsmedlem and $node->field_os2web_base_field_summary) { 
                    $output .= "<h2>" . $node->field_os2web_base_field_summary['und'][0]['value'] . "</h2>";
                    
//                    if(taxonomy_term_load($node->field_er_byraadsmedlem['und'][0]['tid'])->name == 'Ja') { 
//                      if($node->field_politisk_parti) {
//                        $output .= "<h2>Byrådsmedlem " . $title . " er medlem af partiet " . taxonomy_term_load($node->field_politisk_parti['und'][0]['tid'])->name . " (" . taxonomy_term_load($node->field_politisk_parti['und'][0]['tid'])->field_bogstav['und'][0]['value'] . ")</h2>";
//                      }                      
//                    }
                  }

                  // FOTO
                  $output = $output . "<!-- FOTO START -->";

                  // Skift denne ud med foto-feltet

                  $output .= "<img src=\"" . image_style_url('portraet_politiker_320x427', $node->field_foto['und'][0]['uri']) . "\" alt=\"" . $title . "\" />";

//                  if($node->field_os2web_base_field_image) {
//                    $output = $output . render($content['field_os2web_base_field_image']);
//                  }
                  $output = $output . "<!-- FOTO SLUT -->";

                $output = $output . "</div>";
                $output = $output . "<!-- ARTIKEL TOP SLUT -->";


                $output .= "<h2>Om " . $title . "</h2>";

                // CIVILT ERHVERV / UNDEROVERSKRIFT
                if($node->field_civilt_erhverv) {
                  $output .= "<p><strong>Civilt erhverv: </strong>" . $node->field_civilt_erhverv['und'][0]['value'] . "</p>";
                }
                              
                // UDDANNELSE
                if($node->field_uddannelse) {
                  $output .= "<p><strong>Uddannelse: </strong>" . $node->field_uddannelse['und'][0]['value'] . "</p>";
                }
                              
                // FØDT
                if($node->field_foedt) {
                  $output .= "<p><strong>Født: </strong>" . $node->field_foedt['und'][0]['value'] . "</p>";
                }

                // TELEFON
                if($node->field_telefon) {
                  $output .= "<p><strong>Telefon: </strong>" . $node->field_telefon['und'][0]['value'] . "</p>";
                }
                              
                // E-MAIL
                if($node->field_email) {
                  $output .= "<p><strong>E-mail: </strong><a href=\"mailto:" . $node->field_email['und'][0]['value'] . "\" title=\"Send en e-mail til " . $title . "\">" . $node->field_email['und'][0]['value'] . "</a></p>";
                }
                              
                // FACEBOOK
                if($node->field_facebook) {
                  $output .= "<p><strong>Facebook: </strong><a href=\"" . $node->field_facebook['und'][0]['value'] . "\" title=\"Besøg " . $title . "s Facebook-profil\">" . $node->field_facebook['und'][0]['value'] . "</a></p>";
                }
                              
                // TWITTER
                if($node->field_twitter) {
                  $output .= "<p><strong>Twitter: </strong><a href=\"" . $node->field_twitter['und'][0]['value'] . "\" title=\"Besøg " . $title . "s Twitter-profil\">" . $node->field_twitter['und'][0]['value'] . "</a></p>";
                }
                              
                // FRITIDSINTERESSER
                if($node->body) {
                  $output .= "<p><strong>Fritidsinteresser: </strong><br />" . $node->body['und'][0]['value'] . "</p>";
                }

                // POLITISKE MÆRKESAGER
                if($node->field_politiske_maerkesager) {
                  $output .= "<p><strong>Politiske mærkesager: </strong><br />" . $node->field_politiske_maerkesager['und'][0]['value'] . "</p>";
                }

                // I BYRÅDET SIDEN
                if($node->field_i_byraadet_siden) {
                  $output .= "<p><strong>I byrådet siden: </strong>" . $node->field_i_byraadet_siden['und'][0]['value'] . "</p>";
                }

//                // POLITISKE UDVALG
//                if($node->field_politisk_udvalg) {
//                  $output .= "<p><strong>Medlem af følgende politiske udvalg:</strong></p>";
//                  $output .= "<ul>";
//                    foreach ($node->field_politisk_udvalg['und'] as $term) {
//                      $output .= "<li><a href=\"" . url('taxonomy/term/' . $term['tid']) . "\" title=\"Se medlemmer af det politiske udvalg " . taxonomy_term_load($term['tid'])->name . "\">" . taxonomy_term_load($term['tid'])->name . "</a></li>";
//                    }
//                  $output .= "</ul>";  
//                }


                // TEKSTINDHOLD
                $output = $output . "<!-- TEKSTINDHOLD START -->";
                hide($content['comments']);
                hide($content['links']);
                $output = $output . render($content);
                $output = $output . "<!-- TEKSTINDHOLD SLUT -->";
                

                
                // KONTAKT
//                $output = $output . "<!-- KONTAKT START -->";
//                if($node->field_os2web_base_field_kle_ref) {
//                  if(($node->field_url) or ($node->field_url_2) or ($node->field_diverse_boks)) {
//                    $output = $output . "<hr>";
//                  }
//                  $output = $output . "<h2>Kontakt</h2>";
//                  $output = $output . views_embed_view('kontakt_kle','default', $node->field_os2web_base_field_kle_ref['und'][0][tid]);
//                  $output = $output . "<!-- GOOGLE MAP START -->";
//                  $output = $output . "<div id=\"map-canvas\"></div>";
//                  $output = $output . "<button class=\"btn map-btn\" onclick=\"loadMapScript();\">Vis kort</button>";
//                  $output = $output . "<!-- GOOGLE MAP SLUT -->";
//                }
//                $output = $output . "<!-- KONTAKT SLUT -->";


                // DEL PÅ SOCIALE MEDIER
                include_once drupal_get_path('theme', 'ishoj') . '/includes/del-paa-sociale-medier.php';

                
                // SENEST OPDATERET
                $output = $output . "<!-- SENEST OPDATERET START -->";
                $output = $output . "<p class=\"last-updated\">Senest opdateret " . format_date($node->changed, 'senest_redigeret') . "</p>";
                $output = $output . "<!-- SENEST OPDATERET SLUT -->";
                

                // REDIGÉR-KNAP
                if($logged_in) {
                  $output .= "<div class=\"edit-node\"><a href=\"/node/" . $node->nid . "/edit?destination=admin/content\" title=\"Ret indhold\"><span>Ret indhold</span></a></div>";
                }


                $output = $output . "</div>";
              
              
                $output = $output . "<div class=\"grid-third\">";

                  // POLITISKE UDVALG
                  if($node->field_politisk_udvalg) {

                    $output .= "<nav class=\"menu-underside\">";
                      $output .= "<p class=\"menu-header\">Medlem af følgende politiske udvalg</p>";
                      $output .= "<ul class=\"menu\">";
                        $output .= "<li class=\"first expanded active-trail\">";
                          $output .= "<ul class=\"menu\">";
                            foreach ($node->field_politisk_udvalg['und'] as $term) {
                              $output .= "<li><a href=\"" . url('taxonomy/term/' . $term['tid']) . "\" title=\"Se medlemmer af det politiske udvalg " . taxonomy_term_load($term['tid'])->name . "\">" . taxonomy_term_load($term['tid'])->name . "</a></li>";
                            }
                          $output .= "</ul>";
                        $output .= "</li>";
                      $output .= "</ul>";
                    $output .= "</nav>";
                  }
                  $output = $output . "</div>";              
              
            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</section>";
        $output = $output . "<!-- ARTIKEL SLUT -->";

       
    // DIMMER DEL SIDEN
    $options = array('absolute' => TRUE);
    // NODEVISNING
     $nid = $node->nid; 
     $abs_url = url('node/' . $nid, $options);
    // -----------
    // TAXONOMIVISNING
//    $abs_url = url(substr($term_url, 1), $options);
    include_once drupal_get_path('theme', 'ishoj') . '/includes/dimmer-del-siden.php';

        

          // BREAKING
          $output .= views_embed_view('kriseinformation','nodevisning', $node->nid);

//        $output = $output . "<!-- BREAKING START -->";
//        $output = $output . "<div class=\"breaking\">";
//          $output = $output . "<div class=\"container\">";
//            $output = $output . "<div class=\"row\">";
//              $output = $output . "<div class=\"grid-full\">";
//                $output = $output . "<div class=\"breaking-inner\">";
//                  $output = $output . "<a class=\"breaking-close\" href=\"#\" title=\"Luk\"></a>";
//                  $output = $output . "<h2><a href=\"#\" title=\"BREAKING: Ishøj Bycenter under vand....stik af!\">BREAKING: Ishøj Bycenter under vand....stik af!</a></h2>";                
//                $output = $output . "</div>";
//              $output = $output . "</div>";
//            $output = $output . "</div>";
//          $output = $output . "</div>";
//        $output = $output . "</div>";
//        $output = $output . "<!-- BREAKING SLUT -->"; 

        print $output;
        print render($content['links']);
        print render($content['comments']); 


?>

       


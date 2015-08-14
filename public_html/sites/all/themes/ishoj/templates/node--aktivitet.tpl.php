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
<?php //drupal_set_message(print_r(taxonomy_get_vocabularies())); ?>

<?php
$output = "";
?>

                     
        <!-- ARTIKEL START -->
<?php       
          $output = $output . "<section class=\"section-breadcrumbs\">";
            $output = $output . "<div class=\"container\">";

// Række 1
             // Brødkrummesti
              $output = $output . "<div class=\"row\">";
                $output = $output . "<div class=\"grid-two-thirds\">";
                  $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $title . "</p>";
                $output = $output . "</div>";
              $output = $output . "</div>";


            $output .= "</div></section>";

          $output = $output . "<section id=\"node-" . $node->nid . "\" class=\"" . $classes . " artikel activities aktivitet-node node-visning\">";
            $output = $output . "<div class=\"container\">";
           
// Række 2
            $output = $output . "<div class=\"row second activity-line\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                $output .= "<div class=\"swiper-container-activities\">";
                  $output .= "<div class=\"swiper-slide fix-width\">";
                    // Dato
                    if($node->field_aktivitetsdato) {
                      if($_GET['d'] == "" or !isset($node->field_aktivitetsdato['und'][$_GET['d']])) {
                        $datoindex = 0;  
                      }
                      else {
                        $datoindex = $_GET['d'];
                      }
                      $output = $output . "<div class=\"date\">" . format_date($node->field_aktivitetsdato['und'][$datoindex]['value'], 'dato_uden_aar') . "</div>";
                    }
                    $output = $output . "<div class=\"circle node-circle\">";
                      $output = $output . "<div></div>";
                    $output = $output . "</div>";
                  $output = $output . "</div>";
                $output = $output . "</div>";
              $output = $output . "</div>";
              $output = $output . "<div class=\"grid-third sociale-medier social-desktop\"></div>";
            $output = $output . "</div>";
  
// Række 3
            $output = $output . "<div class=\"row third\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                $output = $output . "<!-- ARTIKEL TOP START -->";
                $output = $output . "<div class=\"artikel-top\">";
                  $output .= "<div class=\"swiper-container-activities\">";
                    $output .= "<div class=\"swiper-slide fix-width\">";

                      if($node->field_os2web_base_field_image) {
                        $output = $output . "<div class=\"description med-foto\">";
                      }
                      else {
                        $output = $output . "<div class=\"description\">";
                      }
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


                        // Overskrift
                        if($node->field_os2web_base_field_image) {
                          $output = $output . "<h1 class=\"med-foto\">" . $title . "</h1>";
                        }
                        else {
                          $output = $output . "<h1>" . $title . "</h1>";
                        }
                        // Beskrivelse
                        if($node->body) {
                          $output = $output . $node->body['und'][0]['value'];
                        }
                        // Kategori
                        if($node->field_aktivitetstype) {
                          $output = $output . "<p class=\"category\">";
                          $output = $output . "<strong>Kategori:</strong> ";
                          $i = 0;
                            foreach ($node->field_aktivitetstype['und'] as $term) {
                               if($i == 0) {
                                  $output = $output . "<a href=\"" . url('taxonomy/term/' . $term['tid']) . "\" title=\"Aktiviteter under kategorien " . taxonomy_term_load($term['tid'])->name . "\">" . taxonomy_term_load($term['tid'])->name . "</a>";
                               }
                               else {
                                  $output = $output . ", <a href=\"" . url('taxonomy/term/' . $term['tid']) . "\" title=\"Aktiviteter under kategorien " . taxonomy_term_load($term['tid'])->name . "\">" . taxonomy_term_load($term['tid'])->name . "</a>";
                               }
                               $i = $i + 1;
                            }
                          $output = $output . "</p>";
                        }                      
                        // Dato
                        if($node->field_aktivitetsdato) {
                          $output .= "<p><span><strong>Dato:</strong></span> ";

                          // Antallet af datoer
                          $datoer = count($node->field_aktivitetsdato['und']);
                          
                          foreach ($node->field_aktivitetsdato['und'] as $dato) {
                            
                            // Hvis slutdatoen er større/eller lig end aktuelle dato
                            if($dato['value2'] >= strtotime("now")) {
                              
                              // Hvis der er angivet flere datoer, så lav et linieskift
                              if($datoer > 1) {
                                $output .= "<br />";
                              }
                              $output .= format_date($dato['value'], 'senest_redigeret');
                              // Hvis der er en slutdato og den samtidig er forskellig fra startdatoen
                              if(($dato['value2']) and (format_date($dato['value'], 'senest_redigeret') != format_date($dato['value2'], 'senest_redigeret'))) {
                                $output .= " - " . format_date($dato['value2'], 'senest_redigeret');
                              }
                              // Klokkeslæt
                              $output .= " kl. " . format_date($dato['value'], 'klokkeslaet');
                              // Hvis der er et slutklokkeslæt og det samtidig er forskellig fra startklokkeslættet
                              if(($dato['value2']) and (format_date($dato['value'], 'klokkeslaet') != format_date($dato['value2'], 'klokkeslaet'))) {
                                $output .= " - " . format_date($dato['value2'], 'klokkeslaet');
                              }
                            
                            }
                            
                          }

                          
                          
//                          $output .= "<br />" . format_date($node->field_aktivitetsdato['und'][0]['value'], 'senest_redigeret');
//                          // Hvis der er en slutdato og den samtidig er forskellig fra startdatoen
//                          if(($node->field_aktivitetsdato['und'][0]['value2']) and (format_date($node->field_aktivitetsdato['und'][0]['value'], 'senest_redigeret') != format_date($node->field_aktivitetsdato['und'][0]['value2'], 'senest_redigeret'))) {
//                            $output .= " - " . format_date($node->field_aktivitetsdato['und'][0]['value2'], 'senest_redigeret');
//                          }
//                          // Klokkeslæt
//                          $output .= " kl. " . format_date($node->field_aktivitetsdato['und'][0]['value'], 'klokkeslaet');
//                          // Hvis der er et slutklokkeslæt og det samtidig er forskellig fra startklokkeslættet
//                          if(($node->field_aktivitetsdato['und'][0]['value2']) and (format_date($node->field_aktivitetsdato['und'][0]['value'], 'klokkeslaet') != format_date($node->field_aktivitetsdato['und'][0]['value2'], 'klokkeslaet'))) {
//                            $output .= " - " . format_date($node->field_aktivitetsdato['und'][0]['value2'], 'klokkeslaet');
//                          }
                          
                          $output .= "</p>";
                        }
//                        // Dato
//                        if($node->field_aktivitetsdato) {
//                          $output = $output . "<p><span><strong>Dato:</strong></span> " . format_date($node->field_aktivitetsdato['und'][0]['value'], 'senest_redigeret');
//                          if(($node->field_aktivitetsdato['und'][0]['value2']) and (format_date($node->field_aktivitetsdato['und'][0]['value'], 'senest_redigeret') != format_date($node->field_aktivitetsdato['und'][0]['value2'], 'senest_redigeret'))) {
//                            $output = $output . " - " . format_date($node->field_aktivitetsdato['und'][0]['value2'], 'senest_redigeret');
//                          }
//                          $output = $output . "</p>";
//                        }
//                        // Tid
//                        if($node->field_aktivitetsdato) {
//                          $output = $output . "<p><span><strong>Tid:</strong></span> " . format_date($node->field_aktivitetsdato['und'][0]['value'], 'klokkeslaet');
//                          if(($node->field_aktivitetsdato['und'][0]['value2']) and (format_date($node->field_aktivitetsdato['und'][0]['value'], 'klokkeslaet') != format_date($node->field_aktivitetsdato['und'][0]['value2'], 'klokkeslaet'))) {
//                            $output = $output . " - " . format_date($node->field_aktivitetsdato['und'][0]['value2'], 'klokkeslaet');
//                          }
//                          $output = $output . "</p>";
//                        }
                        // Aktivitetssted
                        if($node->field_aktivitetssted) {
                          if(taxonomy_term_load($node->field_aktivitetssted['und'][0]['tid'])->name != "Ikke angivet") {
                            $output = $output . "<p><span><strong>Sted:</strong></span> <a href=\"" . url('taxonomy/term/' . $node->field_aktivitetssted['und'][0]['tid']) . "\" title=\"Aktiviteter i " . taxonomy_term_load($node->field_aktivitetssted['und'][0]['tid'])->name . "\">" . taxonomy_term_load($node->field_aktivitetssted['und'][0]['tid'])->name . "</a></p>";
                          }
                        }
                        // Deltagerbetaling
                        if($node->field_betaling_for_aktivitet){
                          if(taxonomy_term_load($node->field_betaling_for_aktivitet['und'][0]['tid'])->name == "Deltagerbetaling") {
                            if($node->field_pris) {
                              $output .= "<p><span><strong>Pris: </strong></span>" . $node->field_pris['und'][0]['value'] . "</p>";
                            }
                          }
                          else {
                           $output = $output . "<p>" . taxonomy_term_load($node->field_betaling_for_aktivitet['und'][0]['tid'])->name . "</p>";
                          }
                        }

                        // Status på billetsalg (Billetlugen.dk)
                        if($node->field_status_billetsalg) {
                          $billetstatus = taxonomy_term_load($node->field_status_billetsalg['und'][0]['tid'])->name;
                          if($billetstatus != "Normal") {
                            $output .= "<p><span><strong>Status på billetsalg:</strong></span> " . $billetstatus . "</p>";                          
                          }
                        }

                        // Hjemmeside
                        if($node->field_hjemmeside) {
                          $output .= "<p><span><strong>Mere info: </strong></span><a href=\"" . $node->field_hjemmeside['und'][0]['value'] . "\" title=\"Mere info på " . $node->field_hjemmeside['und'][0]['value'] . "\">" . $node->field_hjemmeside['und'][0]['value'] . "</a></p>";
                        }

                        // Arrangør
                        if($node->field_arrangor) {
                          $output .= "<p><span><strong>Arrangør: </strong></span>" . taxonomy_term_load($node->field_arrangor['und'][0]['tid'])->name . "</a></p>";
                        }

                       $output = $output . "</div>";
                    
                    $output = $output . "</div>";
                  $output = $output . "</div>";

                $output = $output . "</div>";
                $output = $output . "<!-- ARTIKEL TOP SLUT -->";
                               
                
                // TEKSTINDHOLD
                $output = $output . "<!-- TEKSTINDHOLD START -->";
                hide($content['comments']);
                hide($content['links']);
                $output = $output . render($content);
                $output = $output . "<!-- TEKSTINDHOLD SLUT -->";
                
                
                
                // SENEST OPDATERET
//                $output = $output . "<!-- SENEST OPDATERET START -->";
//                $output = $output . "<p class=\"last-updated\">Senest opdateret " . format_date($node->changed, 'senest_redigeret') . "</p>";
//                $output = $output . "<!-- SENEST OPDATERET SLUT -->";
                

                // REDIGÉR-KNAP
                if($logged_in) {
                  $output .= "<div class=\"edit-node\"><a href=\"/node/" . $node->nid . "/edit?destination=admin/content\" title=\"Ret indhold\"><span>Ret indhold</span></a></div>";
                }
                $output = $output . "</div>";

                $output = $output . "<div class=\"grid-third\">";
                // INDHOLD TIL HØJRE KOLONNE




                // Andre aktiviteter samme sted
                if($node->field_aktivitetssted['und'][0]['tid']) {
                  $arg1 = $node->field_aktivitetssted['und'][0]['tid'];
                  $arg2 = $node->nid; 
                  $args = array($arg1, $arg2);
                  $view = views_get_view('aktiviteter');
                  $view->set_display('aktivitet_aktiviteter_samme_sted');
                  $view->set_arguments($args);
                  $view->execute();
                  
                  if(count($view->result) > 0) { // Der returneres en eller flere records
                    $output .= "<nav class=\"menu-underside andre-aktiviteter\">";
                      $output .= "<p class=\"menu-header\">Andre aktiviteter samme sted</p>";
                      $output .= "<ul class=\"menu\">";
                        $output .= "<li class=\"first expanded active-trail\">";
                          $output .= "<ul class=\"menu\">";
                              $output .= $view->render();
                          $output .= "</ul>";
                        $output .= "</li>";
                      $output .= "</ul>";
                    $output .= "</nav>";
                  }
                }
                // Andre aktiviteter med samme kategori
                if($node->field_aktivitetstype['und'][0]['tid']) {
                  $arg1_kat = $node->field_aktivitetstype['und'][0]['tid'];
                  $arg2_kat = $node->nid; 
                  $args_kat = array($arg1_kat, $arg2_kat);
                  $view_kat = views_get_view('aktiviteter');
                  $view_kat->set_display('aktivitet_aktiviteter_samme_kategori');
                  $view_kat->set_arguments($args_kat);
                  $view_kat->execute();
                  
                  if(count($view_kat->result) > 0) { // Der returneres en eller flere records
                    $output .= "<nav class=\"menu-underside andre-aktiviteter\">";
                      $output .= "<p class=\"menu-header\">Andre aktiviteter i samme kategori</p>";
                      $output .= "<ul class=\"menu\">";
                        $output .= "<li class=\"first expanded active-trail\">";
                          $output .= "<ul class=\"menu\">";
                            $output .= $view_kat->render();
                          $output .= "</ul>";
                        $output .= "</li>";
                      $output .= "</ul>";
                    $output .= "</nav>";
                  }
                }
                
                $output .= "<div class=\"more-content\"><h3><a href=\"/kategori/aktiviteter\" title=\"Flere aktiviteter\">Flere aktiviteter</a></h3></div>";

                $output = $output . "</div>";
              
              
            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</section>";
        $output = $output . "<!-- ARTIKEL SLUT -->";



          // BREAKING
          $output .= views_embed_view('kriseinformation','nodevisning', $node->nid);


        print $output;
        print render($content['links']);
        print render($content['comments']); 


?>

       


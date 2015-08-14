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




<?php 
  //dsm($node); //drupal_set_message('<pre>' . print_r($node, TRUE) . '</pre>'); 
//  dsm($content); 
?>

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
                // TITEL 
                if($node->field_os2web_meetings_committee and !empty($content['field_os2web_meetings_date']) and $node->field_os2web_meetings_type) {
                  $meetingDate = render($content['field_os2web_meetings_date']);
                  $output .= "<h1>" . $node->field_os2web_meetings_type['und'][0]['value'] . " for " . taxonomy_term_load($node->field_os2web_meetings_committee['und'][0]['tid'])->name . "s møde " . strtolower($meetingDate) . "</h1>"; 
                }

 
              $output = $output . "</div>";
              $output = $output . "<div class=\"grid-third sociale-medier social-desktop\"></div>";
            $output = $output . "</div>";
  
            $output = $output . "<div class=\"row second\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
                $output = $output . "<!-- ARTIKEL TOP START -->";
                $output = $output . "<div class=\"artikel-top\">";



                $output = $output . "</div>";
                $output = $output . "<!-- ARTIKEL TOP SLUT -->";



                // MIKROARTIKLER - DAGSORDENPUNKTER 
                if($node->field_os2web_meetings_bullets and $node->field_os2web_meetings_type) {
                  $output .= "<!-- MIKROARTIKLER START -->";
                  $dagsordenstatus = $node->field_os2web_meetings_type['und'][0]['value'];
                  switch ($dagsordenstatus) {
                    case "Dagsorden":
                      $output .= "<h2>Sagspunkter der skal behandles på mødet</h2>";
                      break;
                    case "Referat":
                      $output .= "<h2>Sagspunkter der blev behandlet på mødet</h2>";
                      break;
                  }
                  $output .= "<div class=\"microArticleContainer\">";

                  foreach ($node->field_os2web_meetings_bullets['und'] as $key =>  $item) {
                    if($node->field_os2web_meetings_bullets['und'][$key]['entity']->field_os2web_meetings_bul_closed['und'][0]['value'] == '1') {
                      $aabenlukket = " (lukket punkt)";
                    }
                    else {
                      $aabenlukket = "";
                    }
                    
                    $output .= "<div class=\"microArticle\"><h2 class=\"mArticle\" id=\"mArticle" . $key . "\"><span class=\"sprites-sprite sprite-plus mikroartikel\"></span>" . $item['entity']->title . $aabenlukket . "</h2>";
                    $output .= "<div class=\"mArticle" . $key . " mArticle\">";
                    
                    if($aabenlukket !== "") {
                       $output .= "<p>Intet indhold til denne sag.</p>";  
                    }
                    else {
//                      $output .= "<p>Sagstekst kommer her...</p>";
                      $output .= views_embed_view('dagsorden','dagsorden_default', $item['entity']->nid);
                      
                      // Bilag
                      if($item['entity']->field_os2web_meetings_enclosures) {
                        $output .= "<h3>Bilag</h3>";
                        $output .= "<ul>";
                        foreach ($item['entity']->field_os2web_meetings_enclosures['und'] as $bilagKey =>  $bilagItem) {
                          $output .= "<li><a href=\"" . file_create_url($bilagItem['uri']) . "\" title=\"Hent bilaget " . $bilagItem['filename'] . "\">" . $bilagItem['filename'] . "</a></li>";
                        }
                        $output .= "</ul>";
                      }
                      
                    }
                    
                    $output .= "</div></div>";
                  }

                  $output .= "</div>";
                  $output .= "<!-- MIKROARTIKLER SLUT -->";
                }

                // SAMLET DOKUMENT
                if(!empty($content['field_os2web_meetings_full_doc'])) {
                  if(strtolower($node->field_os2web_meetings_type['und'][0]['value']) == "dagsorden") {
                    $output .= "<p><br /><a href=\"" . render($content['field_os2web_meetings_full_doc']) . "\" title=\"Hent dagsordenen for mødet som et samlet dokument\">Hent dagsordenen for mødet som et samlet dokument</a></p>";
                  }
                  else {
                    $output .= "<p><br /><a href=\"" . render($content['field_os2web_meetings_full_doc']) . "\" title=\"Hent referatet for mødet som et samlet dokument\">Hent referatet for mødet som et samlet dokument</a></p>";
                  }
                }


                // MIKROARTIKLER - TILLÆGSDAGSORDENPUNKTER
                $view = views_get_view('dagsorden');
                $view->set_display('dagsorden_tillaeg', $node->nid);    
                $tillaegspunkter = $view->render();
                sizeof($view->result);                
                //$tillaeg = views_embed_view('dagsorden','default', $node->nid);
                
                if(sizeof($view->result) > 0) { // Der returneres en eller flere records
                  $output .= "<!-- MIKROARTIKLER TILLÆG START -->";
                  $output .= "<h2>Tillægssager</h2>";
                  $output .= "<div class=\"microArticleContainer\">";
                  $output .= $tillaegspunkter;
                  $output .= "</div>";
                  $output .= "<!-- MIKROARTIKLER TILLÆG SLUT -->";
                }


                // MIDLERTIDIGT OUTPUT
//                $output .= "<p>field_os2web_meetings_id  = " . $node->field_os2web_meetings_id['und'][0]['value'] . "</p>";
//                $output .= "<p>field_os2web_meetings_system_id  = " . $node->field_os2web_meetings_system_id['und'][0]['value'] . "</p>";
 


                // TEKSTINDHOLD
                $output = $output . "<!-- TEKSTINDHOLD START -->";
                hide($content['comments']);
                hide($content['links']);
//                $output = $output . render($content);
                $output = $output . "<!-- TEKSTINDHOLD SLUT -->";


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



                // Hvis noden er en dagsorden/referat (og dermed har et committee-id) 
                if($node->field_os2web_meetings_committee) {
                  $output .= "<nav class=\"menu-underside\">";
                    $output .= "<p class=\"menu-header\"><strong>Møder i " . taxonomy_term_load($node->field_os2web_meetings_committee['und'][0]['tid'])->name . "</strong></p>";
                    $output .= "<ul class=\"menu\">";
                      $output .= "<li class=\"first expanded active-trail\">";
                        $output .= "<ul class=\"menu\">";
                          $output .= views_embed_view('dagsorden','dagsorden_udvalgets_dagsordener', $node->field_os2web_meetings_committee['und'][0]['tid']);
                        $output .= "</ul>";
                      $output .= "</li>";
                    $output .= "</ul>";
                  $output .= "</nav>";
                }







                  // MENU TIL UNDERSIDER START
//                  $output = $output . "<nav class=\"menu-underside\">";                    
//                  $block = module_invoke('menu_block', 'block_view', '4');
//                  $output.= render($block['content']);
//                  $output = $output . "</nav>";
                  // MENU TIL UNDERSIDER SLUT

                $output = $output . "</div>";              
//              }
              
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


        print $output;
        print render($content['links']);
        print render($content['comments']); 


?>

       


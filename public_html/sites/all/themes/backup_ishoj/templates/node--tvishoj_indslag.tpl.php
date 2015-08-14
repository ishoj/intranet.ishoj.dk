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




<?php dsm($node); //drupal_set_message('<pre>' . print_r($node, TRUE) . '</pre>'); 
?>

<?php
function sortByTitle($a, $b){
  return strcmp($a->title, $b->title);
}
$output = "";
$output = "";

?>

                     
        <!-- ARTIKEL START -->
<?php       

          $output = $output . "<section id=\"node-" . $node->nid . "\" class=\"" . $classes . " artikel\">";

         
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
// $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " .  "<a href=\"" . url('taxonomy/term/' . $bterm->tid) . "\" title=\"Kategorien " . $bterm->name . "\">" . $bterm->name . "</a>" . " / " . $title . "</p>";
 $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " .  "<a href=\"" . url('taxonomy/term/' . $bterm->tid) . "\" title=\"Kategorien " . $bterm->name . "\">" . $bterm->name . "</a>" . $title . "</p>";
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

                    // VIDEO
                    $output = $output . "<!-- VIDEO START -->";
                    if($node->field_youwatch_page_url) {
                      $output = $output . "<div class=\"video-indlejret\">";
                        $output = $output . "<div class=\"embed-container vimeo\">";
                      
                          $output .= "<iframe src=\"http://www.youtube.com/embed/" . substr(strrchr($node->field_youwatch_page_url['und'][0]['value'], "="), 1) . "?rel=0\" frameborder=\"0\" allowfullscreen></iframe>";                      
                        
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
                if($node->body) {
                  $output = $output . "<h2>" . $node->body['und'][0]['value'] . "</h2>";
                }
                $output = $output . "<!-- UNDEROVERSKRIFT SLUT -->";
               

                
                
                // TEKSTINDHOLD
                $output = $output . "<!-- TEKSTINDHOLD START -->";
                hide($content['comments']);
                hide($content['links']);
//                $output = $output . render($content);
                $output = $output . "<!-- TEKSTINDHOLD SLUT -->";
                
                




                
                
                // KONTAKT
                $output = $output . "<!-- KONTAKT START -->";
                if($node->field_os2web_base_field_kle_ref) {
                  if(($node->field_url) or ($node->field_url_2) or ($node->field_diverse_boks)) {
                    $output = $output . "<hr>";
                  }
                  $output = $output . "<h2>Kontakt</h2>";
                  $output = $output . views_embed_view('kontakt_kle','default', $node->field_os2web_base_field_kle_ref['und'][0][tid]);
                  $output = $output . "<!-- GOOGLE MAP START -->";
                  $output = $output . "<div id=\"map-canvas\"></div>";
                  $output = $output . "<button class=\"btn map-btn\" onclick=\"loadMapScript();\">Vis kort</button>";
                  $output = $output . "<!-- GOOGLE MAP SLUT -->";
                }
                $output = $output . "<!-- KONTAKT SLUT -->";


                // DEL PÅ SOCIALE MEDIER
                // Hvis noden er en indholdsside, borger.dk-artikel eller en aktivitet 
                if(($node->type == 'os2web_base_contentpage') or ($node->type == 'os2web_borger_dk_article') or ($node->type == 'aktivitet')) {
                  include_once drupal_get_path('theme', 'ishoj') . '/includes/del-paa-sociale-medier.php';
                }

                
                // SENEST OPDATERET
                $output = $output . "<!-- SENEST OPDATERET START -->";
                $output = $output . "<p class=\"last-updated\">Senest opdateret " . format_date($node->changed, 'senest_redigeret') . "</p>";
                $output = $output . "<!-- SENEST OPDATERET SLUT -->";
                

                // REDIGÉR-KNAP
                if($logged_in) {
                  $output .= "<div class=\"edit-node\"><a href=\"/node/" . $node->nid . "/edit?destination=admin/content\" title=\"Ret indhold\"><span>Ret indhold</span></a></div>";
                }


                $output = $output . "</div>";
              
              
              // HVIS NODEN ER AF TYPEN INDHOLD, BORGER.DK-ARTIKEL ELLER AKTIVITET 
              if(($node->type == 'os2web_base_contentpage') or ($node->type == 'os2web_borger_dk_article') or ($node->type == 'aktivitet')) {
                
                $output = $output . "<div class=\"grid-third aside\">";
                
                

                

                $output = $output . "</div>";
              
              }
              
            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</section>";
        $output = $output . "<!-- ARTIKEL SLUT -->";

       
        // DIMMER DEL SIDEN
        $output = $output . "<!-- DIMMER DEL SIDEN START -->";
        // OPRET DEL-PÅ-SOCIALE-MEDIER-KNAPPER, 
        // HVIS NODEN ER AF TYPEN INDHOLD, BORGER.DK-ARTIKEL ELLER AKTIVITET 
        if(($node->type == 'os2web_base_contentpage') or ($node->type == 'os2web_borger_dk_article') or ($node->type == 'aktivitet')) {
          $options = array('absolute' => TRUE);
          $nid = $node->nid; // Node ID
          $abs_url = url('node/' . $nid, $options);

          $output = $output . "<div class=\"dimmer-delsiden hidden\">";
          
          $output .= "<a class=\"breaking-close\" href=\"#\" title=\"Luk\"></a>";
            
            $output = $output . "<ul>";
              $output = $output . "<li class=\"sociale-medier\"><a class=\"sprite sprite-facebook\" href=\"https://www.facebook.com/sharer/sharer.php?u=" . $abs_url . "\" title=\"Del siden på Facebook\"><span><span class=\"screen-reader\">Del siden på Facebook</span></span></a></li>";
              $output = $output . "<li class=\"sociale-medier\"><a class=\"sprite sprite-twitter\" href=\"https://twitter.com/home?status=" . $title . " " . $abs_url . "\" title=\"Del siden på Twitter\"><span><span class=\"screen-reader\">Del siden på Twitter</span></span></a></li>";
              $output = $output . "<li class=\"sociale-medier\"><a class=\"sprite sprite-googleplus\" href=\"https://plus.google.com/share?url=" . $abs_url . "\" title=\"Del siden på Google+\"><span><span class=\"screen-reader\">Del siden på Google+</span></span></a></li>";
              $output = $output . "<li class=\"sociale-medier\"><a class=\"sprite sprite-linkedin\" href=\"https://www.linkedin.com/shareArticle?url=" . $abs_url . "&title=" . $title . "&summary=&source=&mini=true\" title=\"Del siden på LinkedIn\"><span><span class=\"screen-reader\">Del siden på LinkedIn</span></span></a></li>";          
              $output = $output . "<li class=\"sociale-medier\"><a class=\"sprite sprite-mail\" href=\"mailto:?subject=" . $title . " title=\"Send som e-mail\"><span><span class=\"screen-reader\">Send som e-mail</span></span></a></li>";          
              $output = $output . "<li class=\"sociale-medier\"><a class=\"sprite sprite-link\" href=\"#\" title=\"Del link\"><span><span class=\"screen-reader\">Del link</span></span></a></li>";          
            $output = $output . "</ul>";
            $output = $output . "<div class=\"link-url\">";
              $output = $output . "<textarea>" . $abs_url . "</textarea>";
            $output = $output . "</div>";
          $output = $output . "</div>";
        }
        $output = $output . "<!-- DIMMER DEL SIDEN SLUT -->";

          // BREAKING
          $output .= views_embed_view('kriseinformation','nodevisning', $node->nid);


        print $output;
        print render($content['links']);
        print render($content['comments']); 


?>

       


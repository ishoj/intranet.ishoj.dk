<?php

/**
 * @file
 * Bartik's theme implementation to display a node.
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
 */
dsm($node);
include_once drupal_get_path('theme', 'ishoj') . '/includes/uglen_functions.php';
?>
<!--<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>-->
  <?php //print render($title_prefix); ?>

<?php /**  <h2<?php print $title_attributes; ?>>
      <a href="<?php print 'node/' . $node->nid; ?>"><?php print $node->title; ?></a>
    </h2>
*/?>
  <?php //print render($title_suffix); ?>


<!--  <div id='region-content' class="content"<?php print $content_attributes; ?>>-->

  <?php
  if ($node->type == 'os2web_borger_dk_article') {

    $content_field = array();
    $fields = $node->os2web_borger_dk_article['field_settings'];
    // First get admin display settings.
    $admin_display_fields = variable_get('os2web_borger_dk_display');
    $locked_os2web_types = array('field_os2web_borger_dk_borgerurl' => 1);
    // We get admin microarticle display settings.
    $microarticle = variable_get('os2web_borger_dk_microarticle_active', FALSE);
    if ($microarticle) {
      $field_microarticle_settings = $node->os2web_borger_dk_microarticle['field_microarticle_settings'];
    }

    foreach ($admin_display_fields as $type => $value) {

      // If ADMIN set this field to display.
      if ($admin_display_fields[$type]) {
        $arr = $node-> $type;

      if (count($arr) > 0 && $type != 'title' && $type != 'field_os2web_borger_dk_image') {
          $content_field[$type] = $arr['und']['0']['value'];
        }
        elseif (count($arr) > 0 && $type == 'field_os2web_borger_dk_image') {
          $filepath = $arr['und']['0']['uri'];
          $alt = $arr['und']['0']['alt'];
          $content_field[$type] = theme('image', array('path' => $filepath, 'alt' => $alt, 'title' => $alt));
        }
        else {
          $content_field[$type] = '';
       }
        // Microarticles : if microarticle is set up to show by admin.
        if ($microarticle) {
          // Check if content field is body and field_microarticle_settings
          // is NOT empty.
          // The field_microarticle_setting will be empty when a new
          // article is imported and shown in a form, then node_view
          // will display full body text.
          if ($type == 'body' && !empty($field_microarticle_settings)) {
            $body_text = $node->body['und']['0']['value'];
            // Link break in body_text: in windows \r\n, linux \n.
            preg_match("/<\/div>\n/", $body_text, $link_break);
            if (isset($link_break[0])) {
              $div = preg_split("/\n<\/div>\n/", $body_text, -1, PREG_SPLIT_DELIM_CAPTURE);
            }
            else {
              $div = preg_split('/\r\n<[\/]div>\r\n/', $body_text, -1, PREG_SPLIT_DELIM_CAPTURE);
            }
            $show_div = '';
            foreach ($div as $key => $text) {
              $microno = $key + 1;
              $checkboxno = 'os2web_borger_dk_micro_' . $microno;
              // The last div is a link break \n or \r\n.
              if ($div[$key] != $div[(count($div) - 1)]) {
                // If editor set this microarticle to be visible,(TRUE)
                if ($field_microarticle_settings[$microno] != 0) {
                  $show_div .= $div[$key];
                  $show_div .= "\n</div>";
                  $show_div .= "\n";
                }
              }
            }
            // Content body shows only visible microarticles/ part of body_text.
            $content_field[$type] = $show_div;
          }
        }
        elseif ($type == 'body') {
          $content_field['body'] = $node->body['und']['0']['value'];
          $tmpShow = "";
          // Link break in body_text: in windows \r\n, linux \n.
          preg_match("/<\/div>\n/", $content_field['body'], $link_break);
          if (isset($link_break[0])) {
            $divArray = preg_split("/\n<\/div>\n/", $node->body['und']['0']['value'], -1, PREG_SPLIT_DELIM_CAPTURE);
          }
          else {
            $divArray = preg_split('/\r\n<[\/]div>\r\n/', $node->body['und']['0']['value'], -1, PREG_SPLIT_DELIM_CAPTURE);
          }
          
          foreach ($divArray as $key => $text) {
            $tmpShow .= str_replace('<h3>', '<h3 class="mArticle" id="mArticle' . ($key + 1) . '">', $divArray[$key]);
            $tmpShow .= "\n</div>";
            $tmpShow .= "\n"; 
          }
          $content_field['body'] = "<div class=\"microArticleContainer\">" . $tmpShow;
        }

        // End of microarticles.
        // If EDITOR set this field to be hidden.
        if ($fields[$type] == '0') {
            $content_field[$type] = '';
        }
      }

      // If ADMIN set this field to be hidden.
      else {
          $content_field[$type] = '';
      }
    }
//    drupal_add_js(drupal_get_path('module', 'os2web_borger_dk') . '/js/os2web_borger_dk.js', 'file');
//    drupal_add_css(drupal_get_path('module', 'os2web_borger_dk') . '/css/os2web_borger_dk.css', 'file');

    // Set the page-title if field-value is given.
   // if (!empty($node->field_os2web_borger_dk_pagetitle['und'][0]['value'])) {
      //drupal_set_title($node->field_os2web_borger_dk_pagetitle['und'][0]['value']);
    //}
  }


/**
 * Find position of Nth $occurrence of $needle in $haystack
 * Starts from the beginning of the string
**/
function strpos_offset($needle, $haystack, $occurrence) {
  // explode the haystack
  $arr = explode($needle, $haystack);
  // check the needle is not out of bounds
  switch( $occurrence ) {
    case $occurrence == 0:
      return false;
    case $occurrence > max(array_keys($arr)):
      return false;
    default:
      return strlen(implode($needle, array_slice($arr, 0, $occurrence)));
  }
}



  ?>



  <?php
//   print "<div class='borger_dk-region-stack3'>
//            <div class='inside'>";
//    if (!empty($content_field['field_os2web_borger_dk_image'])) {
//      print "<div class='borger_dk_billede'>";
//      print render($content_field['field_os2web_borger_dk_image']);
//      print "</div>";
//    }
//
//    if (!empty($content_field['field_os2web_borger_dk_header'])) {
//      print "<div class='borger_dk_header' id='borger_dk_header'>";
//      print render($content_field['field_os2web_borger_dk_header']);
//      print "</div>";
//    }
//    print "</div></div>";
  ?>
  
<!--  <div class="content clearfix"<?php //print $content_attributes; ?>>-->
  <?php
//    if (!empty($content_field['field_os2web_borger_dk_selfservi'])) {
//      print "<div class='borger_dk-region-stack2'>
//              <div class='inside'>
//                <div class='os2web_borger_dk_selfservi'>";
//      print render($content_field['field_os2web_borger_dk_selfservi']);
//      print   '</div>
//              </div>
//            </div>';
//    }
//
  ?>
<!--  </div>-->
<!--  <div class="content clearfix"<?php //print $content_attributes; ?>>-->
  <?php
//    print "<div class='borger_dk-region-stack3'>
//            <div class='inside'>";
//    if (!empty($content_field['field_os2web_borger_dk_pre_text'])) {
//      print "<div class='borger_dk-field_os2web-borger-dk-pre_text'>";
//      print render($content_field['field_os2web_borger_dk_pre_text']);
//      print '</div>';
//      print "<div class='panel-separator'></div>";
//    }
//
//    if (!empty($content_field['body'])) {
//      print "<div class='borger_dk-body node-body' id='borger_dk-body'>";
//      print "<div class='borger_dk_body_intro_text'>" . "Læs om " . $node->title . "</div>";
//      print render($content_field['body']);
//      print '</div>';
//      print "<div class='panel-separator'></div>";
//    }
//    if (!empty($content_field['field_os2web_borger_dk_post_text'])) {
//      print "<div class='borger_dk-field_os2web-borger-dk-post_text'>";
//      print render($content_field['field_os2web_borger_dk_post_text']);
//      print '</div>';
//      print "<div class='panel-separator'></div>";
//    }

//    if (!empty($content['field_os2web_borger_dk_legislati'])) {
//      print "<div class='borger_dk-field_os2web-borger-dk-legislati'>";
//      print render($content['field_os2web_borger_dk_legislati']);
//      print "</div>";
//    }
//    print "</div></div>";



//    print "</div></div>";

//      print render($content);
    ?>
<!--
    </div>
  </div>
-->
  
  
<!-- START START START START START START START START -->

<?php
function sortByTitle($a, $b){
  return strcmp($a->title, $b->title);
}
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
          //      $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $title . "</p>";
 $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " .  "<a href=\"" . url('taxonomy/term/' . $bterm->tid) . "\" title=\"Kategorien " . $bterm->name . "\">" . $bterm->name . "</a>" . " / " . $title . "</p>";
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

                // UNDEROVERSKRIFT
                $output = $output . "<!-- UNDEROVERSKRIFT START -->";
                if (!empty($content_field['field_os2web_borger_dk_header'])) {
                  $output = $output . "<h2>" . render($content_field['field_os2web_borger_dk_header']) . "</h2>";
                }
                $output = $output . "<!-- UNDEROVERSKRIFT SLUT -->";
               
                // SELVBETJENINGSLØSNING
                $output = $output . "\n\n\n<!-- SELBETJENINGSLØSNING START -->";
//                $output = $output . views_embed_view('selvbetjeningslosning','default', $node->nid);
                if(!empty($content_field['field_os2web_borger_dk_selfservi'])) {
                  $selvbetjening = render($content_field['field_os2web_borger_dk_selfservi']);
                  // Laver borger.dk selvbetjenings-ouput om til vores eget selvbetjenings-output
                  $selvbetjening = str_replace('<h4>Selvbetjening</h4>', '', $selvbetjening);
                  $selvbetjening = str_replace('<ul>', '', $selvbetjening);
                  $selvbetjening = str_replace('</ul>', '', $selvbetjening);
                  $selvbetjening = preg_replace('/\<li id=[^\>]+\>/', '', $selvbetjening);
                  $selvbetjening = str_replace('<li>', '', $selvbetjening);
                  $selvbetjening = str_replace('</li>', '', $selvbetjening);
                  $selvbetjening = str_replace('<a ', '<p><a class="btn btn-large selvbetjening" ', $selvbetjening);
                  $selvbetjening = str_replace('">', '"><span class="sprites-sprite sprite-arrow-right"></span>', $selvbetjening);
                  $selvbetjening = str_replace('</a>', '</a></p>', $selvbetjening);
                  $output = $output . $selvbetjening;
                }
                $output = $output . "<!-- SELBETJENINGSLØSNING SLUT -->";


                // LÆS OM...
                $output = $output . "<h2>Læs om " . lcfirst($node->title) . "</h2>";  


                // TEKSTINDHOLD
                // Borger.dk body-outputtet undeholder også mikroartikler. Det gjorde det ikke i den tidligere version
                $output = $output . "<!-- TEKSTINDHOLD START -->";
                hide($content['comments']);
                hide($content['links']); 
//                $output = $output . "<div>";
                
                if(!empty($content_field['field_os2web_borger_dk_pre_te$node->titlet'])) {
                  $output = $output . render($content_field['field_os2web_borger_dk_pre_text']);
                }
                if(!empty($content_field['body'])) {
//                  $output = $output . "<p>" . "Læs om " . $node->title . "</p";
                  $output = $output . render($content_field['body']);
                }
                if(!empty($content_field['field_os2web_borger_dk_post_text'])) {
                  $output = $output . render($content_field['field_os2web_borger_dk_post_text']);
                }
//                $output = $output . render($content);
//                $output = $output . "</div>";
                $output = $output . "<!-- TEKSTINDHOLD SLUT -->";
                
                
                // MIKROARTIKLER
//                $output = $output . "<!-- MIKROARTIKLER START -->";
//                if($node->field_mikroartikler_titel1 or 
//                  $node->field_mikroartikler_titel2 or 
//                  $node->field_mikroartikler_titel3 or 
//                  $node->field_mikroartikler_titel4 or 
//                  $node->field_mikroartikler_titel5 or 
//                  $node->field_mikroartikler_titel6 or 
//                  $node->field_mikroartikler_titel7 or 
//                  $node->field_mikroartikler_titel8 or 
//                  $node->field_mikroartikler_titel9 or 
//                  $node->field_mikroartikler_titel10) {
//
//                  $mikroartikel = '<div class="microArticleContainer">';
//
//                  if($node->field_mikroartikler_titel1) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle1"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel1['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle1 mArticle">' . $node->field_mikroartikler_tekst1['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel2) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle2"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel2['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle2 mArticle">' . $node->field_mikroartikler_tekst2['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel3) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle3"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel3['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle3 mArticle">' . $node->field_mikroartikler_tekst3['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel4) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle4"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel4['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle4 mArticle">' . $node->field_mikroartikler_tekst4['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel5) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle5"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel5['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle5 mArticle">' . $node->field_mikroartikler_tekst5['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel6) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle6"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel6['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle6 mArticle">' . $node->field_mikroartikler_tekst6['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel7) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle7"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel7['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle7 mArticle">' . $node->field_mikroartikler_tekst7['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel8) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle8"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel8['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle8 mArticle">' . $node->field_mikroartikler_tekst8['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel9) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle9"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel9['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle9 mArticle">' . $node->field_mikroartikler_tekst9['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  if($node->field_mikroartikler_titel10) {
//                    $mikroartikel = $mikroartikel . '<div class="microArticle"><h2 class="mArticle" id="mArticle10"><span class="sprites-sprite sprite-plus mikroartikel"></span>' . $node->field_mikroartikler_titel10['und'][0]['safe_value'] . '</h2>';
//                    $mikroartikel = $mikroartikel . '<div class="mArticle10 mArticle">' . $node->field_mikroartikler_tekst10['und'][0]['safe_value'] . '</div></div>';
//                  }
//
//                  $mikroartikel = $mikroartikel . "</div>";
//                  $output = $output . $mikroartikel;	
//                }
//                $output = $output . "<!-- MIKROARTIKLER SLUT -->";         

                                
                // DIVERSE BOKS
//                $output = $output . "<!-- DIVERSE BOKS START -->";
//                if($node->field_diverse_boks) {
//                  $output = $output . "<div class=\"diverse-boks\">";
//                  $output = $output . $node->field_diverse_boks['und'][0]['safe_value'];
//                  $output = $output . "</div>";
//                }
//                $output = $output . "<!-- DIVERSE BOKS SLUT -->";                    


                // HUSKELISTE
                if (!empty($content_field['field_os2web_borger_dk_shortlist'])) {
                  $huskeliste = render($content_field['field_os2web_borger_dk_shortlist']);
                  $huskeliste = str_replace('<h3>', '<h2>', $huskeliste);
                  $huskeliste = str_replace('</h3>', '</h2>', $huskeliste);
                  $huskeliste = str_replace('<h4>', '<p>', $huskeliste);
                  $huskeliste = str_replace('</h4>', '</p>', $huskeliste);
                  $output = $output . $huskeliste;
                }

                
                // LÆS OGSÅ
                $output = $output . "<!-- LÆS OGSÅ START -->";
//                if($node->field_url) {
//                  if($node->field_diverse_boks) {
//                    $output = $output . "<hr>";
//                  }
//                  $output = $output . "<h2>Læs også</h2>";
//                  $output = $output . "<ul>";
//                  foreach ($node->field_url['und'] as $value) {
//                    $output = $output . "<li>";
//                      $output = $output . "<a href=\"" . $value['url'] . "\" title=\"" . $value['title'] . "\">";
//                        $output = $output . $value['title'];
//                      $output = $output . "</a>";
//                    $output = $output . "</li>";
//                  }
//                  $output = $output . "</ul>";
//                }
                if (!empty($content_field['field_os2web_borger_dk_recommend'])) {
                  if(!empty($content_field['field_os2web_borger_dk_shortlist'])) {
                    $output = $output . "<hr>";
                  }
                  $laesogsaa = render($content_field['field_os2web_borger_dk_recommend']);
                  $laesogsaa = str_replace('<h3>', '<h2>', $laesogsaa);
                  $laesogsaa = str_replace('</h3>', '</h2>', $laesogsaa);
                  $laesogsaa = str_replace('<h4>', '<p>', $laesogsaa);
                  $laesogsaa = str_replace('</h4>', '</p>', $laesogsaa);
                  $output = $output . $laesogsaa;
                }
                $output = $output . "<!-- LÆS OGSÅ SLUT -->";



                // HVAD SIGER LOVEN?
                $output = $output . "<!-- HVAD SIGER LOVEN? START -->";
//                if($node->field_url_2) {
//                  if(($node->field_url) or ($node->field_diverse_boks)) {
//                    $output = $output . "<hr>";
//                  }
//                  $output = $output . "<h2>Hvad siger loven?</h2>";
//                  $output = $output . "<ul>";
//                  foreach ($node->field_url_2['und'] as $value) {
//                    $output = $output . "<li>";
//                      $output = $output . "<a href=\"" . $value['url'] . "\" title=\"" . $value['title'] . "\">";
//                        $output = $output . $value['title'];
//                      $output = $output . "</a>";
//                    $output = $output . "</li>";
//                  }
//                  $output = $output . "</ul>";
//                }
                if(!empty($content['field_os2web_borger_dk_legislati'])) {
                  if(!empty($content_field['field_os2web_borger_dk_recommend']) or !empty($content_field['field_os2web_borger_dk_shortlist'])) {
                    $output = $output . "<hr>";
                  }
                  $hvadsigerloven = render($content['field_os2web_borger_dk_legislati']);
                  $hvadsigerloven = str_replace('<h3>', '<h2>', $hvadsigerloven);
                  $hvadsigerloven = str_replace('</h3>', '</h2>', $hvadsigerloven);
                  $output = $output . $hvadsigerloven;
                }
//                print "</div></div>";
                $output = $output . "<!-- HVAD SIGER LOVEN? SLUT -->";
                
       
  // KONTAKT
                $output = $output . "<!-- KONTAKT START -->";
                  if(($node->field_url) or ($node->field_url_2) or ($node->field_diverse_boks)) {
                    $output = $output . "<hr>";
                  }
                  $output = $output . "<h2>Kontakt</h2>";
                $args = array($node->field_os2web_base_field_kle_ref['und'][0][tid], $node->field_os2web_base_field_kle_ref['und'][0][tid]);

                  $view = views_get_view('kontakt_kle');
                  $view->set_display('default');
                  $view->set_arguments($args);
               $view->execute();
               if(count($view->result) > 0) { 
                    
                   $output .= $view->render();
                  
                  } else  {
                  $output = $output . views_embed_view('kontakt_kle','default', 1968);
                  }
                $output = $output . "<!-- KONTAKT SLUT -->";

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


                // SKREVET AF 
                if (!empty($content_field['field_os2web_borger_dk_byline'])) {
                  $output = $output . "<!-- SKREVET AF START -->";
                  $output = $output . "<p class=\"byline\">" . render($content_field['field_os2web_borger_dk_byline']) . "</p>";
                  $output = $output . "<!-- SKREVET AF SLUT -->";
                }



                $output = $output . "</div>";
              
              
                $output = $output . "<div class=\"grid-third\">";
                  // MENU TIL UNDERSIDER START
                  $output = $output . "<nav class=\"menu-underside\">";
                   // til BLOCK MENU SITES
 // $block = module_invoke('menu_block', 'block_view', '4');
 //   $output.= render($block['content']);
                    $output = $output . "<ul class=\"menu\">";
                      $output = $output . "<li class=\"first expanded active-trail\">";
                        $output = $output . "<a href=\"#\">" . $node->title . "</a>";
                        $output = $output . "<ul class=\"menu\">";
                        $a = taxonomy_select_nodes($node->field_os2web_base_field_kle_ref['und'], $pager = FALSE); 
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
                  $output = $output . "</nav>";
                  // MENU TIL UNDERSIDER SLUT
                $output = $output . "</div>";
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
        // $output .= views_embed_view('kriseinformation','nodevisning', $node->nid);
        //$output .= breaking();


        print $output;
        print render($content['links']);
        print render($content['comments']); 


?>



<!-- SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT -->
<!-- SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT -->
<!-- SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT -->
<!-- SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT -->
<!-- SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT -->
<!-- SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT -->
<!-- SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT SLUT -->
  
  

  <?php
    // Remove the "Add new comment" link on the teaser page or if the comment
    // form is being displayed on the same page.
   // if ($teaser || !empty($content['comments']['comment_form'])) {
      //unset($content['links']['comment']['#links']['comment-add']);
    //}
    // Only display the wrapper div if there are links.
//    $links = render($content['links']);
//    if ($links):
  ?>
<!--    <div class="link-wrapper">-->
      <?php //print $links; ?>
<!--    </div>-->
  <?php //endif; ?>

  <?php //print render($content['comments']); ?>

<!--</div>-->

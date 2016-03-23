<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */

?>
<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
      <?php
                    // TILMELDING TIL NYHEDSBREV              
//                  $output = "<div id=\"mc_embed_signup\">";
//                    $output .= "<form action=\"http://ishoj.us7.list-manage.com/subscribe/post?u=ad8416d0065ab2738f7c91bbf&amp;id=f902f99af4\" class=\"validate\" id=\"mc-embedded-subscribe-form\" method=\"post\" name=\"mc-embedded-subscribe-form\" novalidate=\"\" target=\"_blank\">";
//                      $output .= "<h2>Tilmelding til Ishøj Indefra</h2><p class=\"sub\">Ishøj Kommunes nyhedsbrev</p>";
//                      $output .= "<div class=\"mc-field-group\"><label for=\"mce-EMAIL\">E-mail</label>"; 
//                        $output .= "<input class=\"required email\" id=\"mce-EMAIL\" name=\"EMAIL\" type=\"email\" value=\"\" />";
//                      $output .= "</div>";
//                      $output .= "<div class=\"mc-field-group\"><label for=\"mce-FNAME\">Fornavn</label>"; 
//                        $output .= "<input class=\"required\" id=\"mce-FNAME\" name=\"FNAME\" type=\"text\" value=\"\" />";
//                      $output .= "</div>";
//                      $output .= "<div class=\"mc-field-group\"><label for=\"mce-LNAME\">Efternavn</label>";             
//                        $output .= "<input class=\"required\" id=\"mce-LNAME\" name=\"LNAME\" type=\"text\" value=\"\" />";
//                      $output .= "</div>";
//                      $output .= "<div class=\"clear\" id=\"mce-responses\">";
//                        $output .= "<div class=\"response\" id=\"mce-error-response\" style=\"display:none\"></div>";
//                        $output .= "<div class=\"response\" id=\"mce-success-response\" style=\"display:none\"></div>";
//                      $output .= "</div>";
//                      $output .= "<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->";
//                      $output .= "<div style=\"position: absolute; left: -5000px;\">";
//                        $output .= "<input name=\"b_ad8416d0065ab2738f7c91bbf_f902f99af4\" type=\"text\" value=\"\" />";
//                      $output .= "</div>";
//                      $output .= "<div class=\"clear\"><input class=\"button\" id=\"mc-embedded-subscribe\" name=\"subscribe\" type=\"submit\" value=\"Tilmeld\" /></div>";
//                    $output .= "</form>";
//                  $output .= "</div>";
                  // TILMELDING TIL NYHEDSBREV              
                  $output .= "<div id=\"mc_embed_signup\">";
                    $output .= "<form action=\"http://ishoj.us7.list-manage.com/subscribe/post?u=ad8416d0065ab2738f7c91bbf&amp;id=f902f99af4\" class=\"validate\" id=\"mc-embedded-subscribe-form\" method=\"post\" name=\"mc-embedded-subscribe-form\" novalidate=\"\" target=\"_blank\">";
                      $output .= "<h1 class=\"text-center no-space-top\">1416</h1>
<h2 class=\"_sub no-space-top space-bottom\">af dine kolleger er allerede tilmeldt
vores interne nyhedsbrev</h2>
<p class=\"sub space-top\">Tilmeld dig Ishøj indefra nu</p>";
                      $output .= "<div class=\"mc-field-group\"><label for=\"mce-EMAIL\">E-mail</label>"; 
                        $output .= "<input class=\"required email\" id=\"mce-EMAIL\" name=\"EMAIL\" type=\"email\" value=\"\" />";
                      $output .= "</div>";
                      $output .= "<div class=\"mc-field-group\"><label for=\"mce-FNAME\">Fornavn</label>"; 
                        $output .= "<input class=\"required\" id=\"mce-FNAME\" name=\"FNAME\" type=\"text\" value=\"\" />";
                      $output .= "</div>";
                      $output .= "<div class=\"mc-field-group\"><label for=\"mce-LNAME\">Efternavn</label>";             
                        $output .= "<input class=\"required\" id=\"mce-LNAME\" name=\"LNAME\" type=\"text\" value=\"\" />";
                      $output .= "</div>";
                      $output .= "<div class=\"clear\" id=\"mce-responses\">";
                        $output .= "<div class=\"response\" id=\"mce-error-response\" style=\"display:none\"></div>";
                        $output .= "<div class=\"response\" id=\"mce-success-response\" style=\"display:none\"></div>";
                      $output .= "</div>";
                      $output .= "<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->";
                      $output .= "<div style=\"position: absolute; left: -5000px;\">";
                        $output .= "<input name=\"b_ad8416d0065ab2738f7c91bbf_f902f99af4\" type=\"text\" value=\"\" />";
                      $output .= "</div>";
                      $output .= "<div class=\"clear\"><input class=\"button\" id=\"mc-embedded-subscribe\" name=\"subscribe\" type=\"submit\" value=\"Tilmeld\" /></div>";
                    $output .= "</form>";
                  $output .= "</div>";
      
      print $output;
    ?>  
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>

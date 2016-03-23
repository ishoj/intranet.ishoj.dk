<?php

$output = "";


$output .= "<!-- PAGE START -->";
$output .= "<div data-role=\"page\">"; 

  $output .= "<!-- CONTENT START -->";
  $output .= "<div data-role=\"content\">"; 

    $output .= "<!-- ARTIKEL START -->";
    $output .= "<section class=\"artikel\">";
      $output .= "<div class=\"container\">";
        $output .= "<div class=\"row\">";
          $output .= "<div class=\"grid-two-thirds\">";
          $output .= "</div>";
          $output .= "<div class=\"grid-third\">";
          $output .= "</div>";
        $output .= "</div>";

        $output .= "<div class=\"row second\">";
          $output .= "<div class=\"grid-full\">";
            $output .= render($primary_local_tasks);
            $output .= $messages;


// https://buildingwebs.wordpress.com/2011/05/11/customizing-edit-user-page-in-drupal-7/
// https://www.drupal.org/node/2279959

//            $output .= render($form['form_id']);
//            $output .= render($form['form_build_id']);
//            $output .= render($form['form_token']);
//
//            $output .= render ($form[‘field_user_firstname’]);
//            $output .= render ($form[‘field_user_lastname’]);
//            $output .= render ($form[‘field_user_dob’]);
//
//            $output .= "<input type=\”submit\” name=\”op\” id=\”edit-submit\” value=\”Save\” />";

$output .= drupal_render_children($form);

          $output .= "</div>";
        $output .= "</div>";
      $output .= "</div>";
    $output .= "</section>";
    $output .= "<!-- ARTIKEL SLUT -->";

  $output .= "</div>";
  $output .= "<!-- CONTENT SLUT -->";

$output .= "</div>";
$output .= "<!-- PAGE SLUT -->";

print $output; 
  
?>
 <?php // print render($user_profile); ?>
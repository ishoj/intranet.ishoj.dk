<section class="overlay">
 <div class="spinner"></div>
  <?php print $content['overlay_top']; ?>
  <div class="overlay_bottom">
    <!-- overlay-bottom start -->
    
    
    <?php    
    $output = "";          
    $url_infoskaerme = "http://www.ishoj.dk/json_krisekommunikation?hest=" . rand();
    $request_infoskaerme = drupal_http_request($url_infoskaerme);
    $json_response_infoskaerme = drupal_json_decode($request_infoskaerme->data);
    if($json_response_infoskaerme) { 
      foreach ($json_response_infoskaerme as $response_data_infoskaerme) {
        
//        $output .= $response_data_infoskaerme['name'];

        $output = "<div class=\"kriseinformation\">";
        // OVERSKRIFT
        $output .= "<h1>" . $response_data_infoskaerme['title'] . "</h1>";
        // UNDEROVERSKRIFT
        if($response_data_infoskaerme['field_os2web_base_field_summary']) {
           $output .= "<h2>" . $response_data_infoskaerme['field_os2web_base_field_summary'] . "</h2>";
        }
        // INDHOLD
        if($response_data_infoskaerme['body']) {
        //   $html .= "<h2>" . $data->field_body[0]['raw']['value'] . "</h2>";
           //$output .= $response_data_infoskaerme['body'];
        }
        // SENEST OPDATERET
//        $output .= "<p><span class=\"kriseDato\">Senest opdateret: " . format_date($data->node_changed) . "</span></p>";
        $output .= "<p><span class=\"kriseDato\">Senest opdateret: " . $response_data_infoskaerme['changed'] . "</span></p>";
        $output .= "</div>";

      
      }
      print $output;
    }
    ?>  
    
    
    
    
    
    
    
    <?php print $content['overlay_bottom']; ?>
    <!-- overlay-bottom slut -->
  </div>
</section>
<section class="slider hide"> 
  <div class="flexslider">
    <ul class="slides">
      <?php
        print "<!-- TESTER -->";
        $url_path = drupal_get_path_alias();
        print "<!--" . $url_path . "-->"; 
      ?>
      <!-- info-tv start -->
      <?php print $content['content']; ?>
      <!-- info-tv slut -->
    </ul>
  </div>
</section>

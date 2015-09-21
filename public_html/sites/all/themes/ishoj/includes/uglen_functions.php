<?php

/*************************************/
/***  FUNKTION: VIS BRUGER PROFIL  ***/
/*************************************/
/***  Parametre, der kan anvendes: ***/
/***  - 'ansvarsområder'           ***/
/***  - 'afdeling'                 ***/
/***  - 'stilling'                 ***/
/***  - 'færdigheder'              ***/
/*************************************/
function vis_bruger_profiler($param, $tax_id) {

  $output = "";
  $taxonomy_field = "";

  switch ($param) {
    case "ansvarsområder":
      $taxonomy_field = "field_ansvarsomraader";
      break;
    case "afdeling":
      $taxonomy_field = "field_afdeling";
      break;
    case "stilling":
      $taxonomy_field = "field_titel_stilling";
      break;
    case "færdigheder":
      $taxonomy_field = "field_faerdigheder";
      break;
    default:
      return;
  }

  $query = new EntityFieldQuery;
  $query->entityCondition('entity_type', 'user')->fieldCondition($taxonomy_field, 'tid', $tax_id)->fieldOrderBy('field_kaldenavn', 'value', 'ASC');
  $results = $query->execute();

  if (isset($results['user'])) {
    $termusers = user_load_multiple(array_keys($results['user']));    
  }

  foreach ($termusers as $a_user) {
    // GET USER START  - FROM USERNAME NOT UID
    if($a_user) {

      $output .= "<div class=\"forfatter\">";
        $output .= "<ul class=\"search-employees show\">";
          $output .= "<li>";

            // KALDENNAVN - FOR- OG EFTERNAVN
            if ($a_user->field_kaldenavn['und'][0]['safe_value'] != '') {
              $name = $a_user->field_kaldenavn['und'][0]['safe_value'];   
            } 
            else {
              $name = $a_user->field_fornavn['und'][0]['safe_value'] . ' ' . $a_user->field_efternavn['und'][0]['safe_value'];  
            }
            if($a_user->field_fornavn and $a_user->field_efternavn) {
              $output .= "<a href=\"/users/" . $a_user->name . "\" titel=\"\"><span class=\"navn\">" . $name . "</span></a>";
            }
            // FOTO
            $output .= "<div class=\"foto\">";
              $output .= "<a class=\"foto\" href=\"/users/" . $a_user->name . "\" titel=\"" . $name . "\">";
                if($a_user->picture) {
                  $output .= "<img alt=\"" . $name . "\" src=\"" . image_style_url('profilfoto_lille', $a_user->picture->uri) . "\" />";
                }
                else {
                  $output .= "<img alt=\"" . $name . "\" src=\"/sites/all/themes/ishoj/dist/img/sprites-no/nopic.png\" />";
                }

                // LEDIG/OPTAGET
                //$output .= "<span class=\"optaget\"></span>";
              $output .= "</a>";
            $output .= "</div>";
            $output .= "<div class=\"details\">";

              // STILLING
              // field_titel_stilling['und'][0]['tid']
              if($a_user->field_titel_stilling) {
                $output .= "<a href=\"" . url('taxonomy/term/' . $a_user->field_titel_stilling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($a_user->field_titel_stilling['und'][0]['tid'])->name . "\"><span class=\"titel\">" . taxonomy_term_load($a_user->field_titel_stilling['und'][0]['tid'])->name . "</span></a><br />";
              }

              // AFDELING
              if($a_user->field_afdeling) {
               $output .= "<a href=\"" . url('taxonomy/term/' . $a_user->field_afdeling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($a_user->field_afdeling['und'][0]['tid'])->name . "\"><span class=\"afdeling\">" . taxonomy_term_load($a_user->field_afdeling['und'][0]['tid'])->name . "</span></a><br />";
              }

              // TELEFON
              if($a_user->field_direkte_telefon) {
                $output .= "<span class=\"telefon\">" . $a_user->field_direkte_telefon['und'][0]['safe_value'] . "</span><br />";
              }

              // E-MAIL
              if($a_user->mail) {
                $output .= "<a href=\"mailto:" . $a_user->mail . "\" titel=\"Send en mail til " . $name . "\"><span class=\"email\">" . $a_user->mail . "</span></a>";
              }

            $output .= "</div>";
          $output .= "</li>";
        $output .= "</ul>";
      $output  .="</div>";

    }
  }

  return $output;
  
}











?>

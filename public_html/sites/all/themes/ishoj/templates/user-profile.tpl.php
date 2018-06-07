<?php

global $user;

$name = '';
if (arg(0) == 'user') {
//  print $showuser->mail;
$uid = arg(1);
$showuser = user_load($uid);
//$showuser->field_kaldenavn['und'][0]['safe_value'];

if ($showuser->field_kaldenavn['und'][0]['safe_value'] != '') {
  $name = $showuser->field_kaldenavn['und'][0]['safe_value'];
}
else {
  $name = $showuser->field_fornavn['und'][0]['safe_value'] . ' ' . $showuser->field_efternavn['und'][0]['safe_value'];
}



//dsm($showuser);
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
            // NAVN
            $output .= "<h1>" . $name . "</h1>";
            /////////////////////////////
            // MANGLER AT UDFYLDE DATA //
            /////////////////////////////
                if($logged_in) {
                if(($user->uid == $showuser->uid) or $is_admin) {


            $mangler = 0;

            $mangler_output_top = "<div class=\"user-missing-data\">";
            $mangler_output_top .= "<ul>";
            $mangler_output_bottom = "";
            $mangler_output = "";

            // Billede
            if(!$showuser->picture) {
              $mangler_output .= "<li>Billede</li>";
              $mangler++;
            }
            // Leder
            if(!$showuser->field_overordnet) {
              $mangler_output .= "<li>Leder</li>";
              $mangler++;
            }
            // Afløser
            // if(!$showuser->field_afloeser) {
            //   $mangler_output .= "<li>Afløser</li>";
            //   $mangler++;
            // }
            // Stilling
            if(!$showuser->field_titel_stilling) {
              $mangler_output .= "<li>Stilling</li>";
              $mangler++;
            }
            // Center/afdeling
            if(!$showuser->field_afdeling) {
              $mangler_output .= "<li>Center/afdeling</li>";
              $mangler++;
            }
            // Ansvarsområder
            if(!$showuser->field_ansvarsomraader) {
              $mangler_output .= "<li>Ansvarsområder</li>";
              $mangler++;
            }
            // Direkte telefon
            if(!$showuser->field_direkte_telefon) {
              $mangler_output .= "<li>Direkte telefon</li>";
              $mangler++;
            }
            // Arbejdsmobil
//            if(!$showuser->field_arbejdsmobil) {
//              $mangler_output .= "<li>Arbejdsmobil</li>";
//              $mangler++;
//            }
            // Privat mobil
//            if(!$showuser->field_privat_mobil) {
//              $mangler_output .= "<li>Privat mobil</li>";
//              $mangler++;
//            }

            $mangler_output_bottom .= "</ul>";

            // RET BRUGER KNAP
            if($logged_in) {
              if(($user->uid == $showuser->uid) or $is_admin) {
                $mangler_output_bottom .= "<div style=\"float:left; width:100%; margin-bottom:1em;\"><div class=\"edit-node\"><a href=\"/user/" . $showuser->uid . "/edit\" title=\"Ret bruger\"><span>Ret profil</span></a></div></div>";
              }
            }

            $mangler_output_bottom .= "</div>";

            // Hvis der min. er et felt, der mangler at blive udfyldt
            if($mangler > 0) {

              if($mangler == 1) {
                $output .= $mangler_output_top . "<h3>Hej " . $showuser->field_fornavn['und'][0]['safe_value'] . "</h3><p>Du mangler at udfylde følgende felt for at færdiggøre din profil:</p>" . $mangler_output .  $mangler_output_bottom;
              }
              else {
                $output .= $mangler_output_top . "<h3>Hej " . $showuser->field_fornavn['und'][0]['safe_value'] . "</h3><p>Du mangler at udfylde følgende felter for at færdiggøre din profil:</p>" . $mangler_output .  $mangler_output_bottom;              }
            }
            else {

              // RET BRUGER KNAP
              //global $user;
              if($logged_in) {
                if(($user->uid == $showuser->uid) or $is_admin) {
                  $output .= "<div style=\"float:left; width:100%; margin-bottom:1em;\"><div class=\"edit-node\"><a href=\"/user/" . $showuser->uid . "/edit\" title=\"Ret bruger\"><span>Ret bruger</span></a></div></div>";
                }
              }

            }
                  }
              }



          $output .= "</div>";
          $output .= "<div class=\"grid-third\">";
//            $output .= "<p>TESTER</p>";
          $output .= "</div>";
        $output .= "</div>";

        $output .= "<div class=\"row second\">";
          $output .= "<div class=\"grid-two-thirds\">";

            // BRUGER CONTAINER
            $output .= "<div class=\"user-container\">";
              // FOTO
//                $output .= theme('user_picture', array('account' =>$showuser));
              if($showuser->picture) {
                $output .= "<img alt=\"" . $name . "\" src=\"" . image_style_url('profilfoto_stor', $showuser->picture->uri) . "\" />";

               $output .= "<img class=\"hide-me\" alt=\"" . $name . "\" src=\"" . image_style_url('profilfoto_lille', $showuser->picture->uri) . "\" />";
                }

              else {
                  $output .= "<img alt=\"" . $name . "\" src=\"/sites/all/themes/ishoj/dist/img/sprites-no/nopic_big.png\" />";
              }

              // BRUGER DATA
              $output .= "<div class=\"user-data\">";

                // STILLING
                if($showuser->field_titel_stilling) {
                  $output .= "<p><strong>STILLLING:</strong> <a href=\"" . url('taxonomy/term/' . $showuser->field_titel_stilling['und'][0]['tid']) . "\" title=\"" . $showuser->field_titel_stilling['und'][0]['taxonomy_term']->name . "\">" . $showuser->field_titel_stilling['und'][0]['taxonomy_term']->name . "</a></p>";
                }

                // AFDELING
//                if($showuser->mail) {
                if($showuser->field_afdeling) {
                  $output .= "<p><strong>AFDELING:</strong> <a href=\"" . url('taxonomy/term/' . $showuser->field_afdeling['und'][0]['tid']) . "\" title=\"" . $showuser->field_afdeling['und'][0]['taxonomy_term']->name . "\">" . $showuser->field_afdeling['und'][0]['taxonomy_term']->name . "</a></p>";
                }

                // LOKATION
                if($showuser->field_aktivitetssted) {

                  // STED
                  $output .= "<p><strong>LOKATION:</strong> " . taxonomy_term_load($showuser->field_aktivitetssted['und'][0]['tid'])->name;

                  // ETAGE
                  if($showuser->field_etage) {
                    $output .= ", etage " . $showuser->field_etage['und'][0]['value'];
                  }

                  // LOKALE NR.
                  if($showuser->field_lokale_nr_) {
                    $output .= ", lokale " . $showuser->field_lokale_nr_['und'][0]['value'];
                  }

                  $output .= "</p>";
                }

                // E-MAIL
                if($showuser->mail) {
                  $output .= "<p><strong>E-MAIL:</strong> <a href=\"mailto:" . $showuser->mail . "\" title=\"Send en mail til " . $name  . "\">" . $showuser->mail . "</a></p>";
                }

                // DIREKTE TELEFON
                if($showuser->field_direkte_telefon) {
                  $output .= "<p><strong>DIREKTE TELEFON:</strong> " . preg_replace('/\s+/', '', $showuser->field_direkte_telefon['und'][0]['safe_value']) . "</p>";
                }

                // ARBEJDSMOBIL
                if($showuser->field_arbejdsmobil) {
                  $output .= "<p><strong>ARBEJDSMOBIL:</strong> " . preg_replace('/\s+/', '', $showuser->field_arbejdsmobil['und'][0]['safe_value']) . "</p>";
                }

                // PRIVAT MOBIL
                if($showuser->field_privat_mobil) {
                  $output .= "<p><strong>PRIVAT MOBIL:</strong> " . preg_replace('/\s+/', '', $showuser->field_privat_mobil['und'][0]['safe_value']) . "</p>";
                }

              $output .= "</div>";
            $output .= "</div>";

            // ANSVARSOMRÅDER
            if($showuser->field_ansvarsomraader) {
              $output .= "<p><strong>ANSVARSOMRÅDER:</strong></p>";
              $output .= "<ul class=\"ansvarsomraader\">";
              foreach ($showuser->field_ansvarsomraader['und'] as $ansvarKey => $ansvarItem) {
                $output .= "<li><a href=\"" . url('taxonomy/term/' . $ansvarItem['tid']) . "\" title=\"" . $ansvarItem['taxonomy_term']->name . "\">" . $ansvarItem['taxonomy_term']->name . "</a></li>";
              }
              $output .= "</ul>";
            }

            // FÆRDIGHEDER
            if($showuser->field_faerdigheder) {
              $output .= "<p><strong>KOMPETENCER:</strong></p>";
              $output .= "<ul class=\"ansvarsomraader\">";
              foreach ($showuser->field_faerdigheder['und'] as $faerdighedKey => $faerdighedItem) {
                $output .= "<li><a href=\"" . url('taxonomy/term/' . $faerdighedItem['tid']) . "\" title=\"" . $faerdighedItem['taxonomy_term']->name . "\">" . $faerdighedItem['taxonomy_term']->name . "</a></li>";
              }
              $output .= "</ul>";
            }


    // UDDANNELSE
            if($showuser->field_user_uddannelse) {
              $output .= "<p><strong>UDDANNELSE:</strong></p>";
              $output .= "<ul class=\"ansvarsomraader\">";
              foreach ($showuser->field_user_uddannelse['und'] as $uddannelseKey => $uddannelseItem) {
                $output .= "<li><a href=\"" . url('taxonomy/term/' . $uddannelseItem['tid']) . "\" title=\"" . $uddannelseItem['taxonomy_term']->name . "\">" . $uddannelseItem['taxonomy_term']->name . "</a></li>";
              }
              $output .= "</ul>";
            }

     // SPROGKUNDSKABER
            if($showuser->field_user_sprogkundskaber) {
              $output .= "<p><strong>SPROGKUNDSKABER:</strong></p>";
              $output .= "<ul class=\"ansvarsomraader\">";
              foreach ($showuser->field_user_sprogkundskaber['und'] as $sprogkundskaberKey => $sprogkundskaberItem) {
                $output .= "<li><a href=\"" . url('taxonomy/term/' . $sprogkundskaberItem['tid']) . "\" title=\"" . $sprogkundskaberItem['taxonomy_term']->name . "\">" . $sprogkundskaberItem['taxonomy_term']->name . "</a></li>";
              }
              $output .= "</ul>";
            }

            // INDLÆG OPRETTET AF BRUGER
//              $output .= views_embed_view('noder_fra_user','vis_users_noder', $showuser->uid);
            $view = views_get_view('noder_fra_user');
            $view->set_display('vis_users_noder');
            $view->set_arguments(array($showuser->uid));
            $results = $view->render();
            if(sizeof($view->result) > 0) {
              $output .= "<p><strong>INDLÆG OPRETTET AF BRUGER:</strong></p>";
              $output .= $results;
            }

          $output .= "</div>";
          $output .= "<div class=\"grid-third\">";

            // AFLØSER
            if($showuser->field_afloeser) {


              $output .= "<div class=\"forfatter-container user-side\">";

              if(count($showuser->field_afloeser['und']) > 1) {
                $output .= "<p class=\"hest\"><strong>AFLØSERE:</strong></p>";
              }
              else {
                $output .= "<p class=\"hest\"><strong>AFLØSER:</strong></p>";
              }

              $outputuser = "";

              foreach ($showuser->field_afloeser['und'] as $afloeserKey => $afloeserItem) {

                $outputuser .= "<div class=\"forfatter\">";
                $outputuser .= "<ul class=\"search-employees show\">";
                $outputuser .= "<li>";
                // KALDENNAVN - FOR- OG EFTERNAVN
                if ($afloeserItem['user']->field_kaldenavn['und'][0]['safe_value'] != '') {
                  $name = $afloeserItem['user']->field_kaldenavn['und'][0]['safe_value'];
                }
                else {
                  $name = $afloeserItem['user']->field_fornavn['und'][0]['safe_value'] . ' ' . $afloeserItem['user']->field_efternavn['und'][0]['safe_value'];
                }

                if($afloeserItem['user']->field_fornavn and $afloeserItem['user']->field_efternavn) {
                  $outputuser .= "<a href=\"/users/" . $afloeserItem['user']->name . "\" titel=\"\"><span class=\"navn\">" . $name . "</span></a>";
                }

                $outputuser .= "<div class=\"foto\">";
                $outputuser .= "<a class=\"foto\" href=\"/users/" . $afloeserItem['user']->name . "\" titel=\"" . $name . "\">";
                // FOTO
                if($afloeserItem['user']->picture) {
                  $outputuser .= "<img alt=\"" . $name . "\" src=\"" . image_style_url('profilfoto_lille', $afloeserItem['user']->picture->uri) . "\" />";
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
                if($afloeserItem['user']->field_titel_stilling) {
                  $outputuser .= "<a href=\"" . url('taxonomy/term/' . $afloeserItem['user']->field_titel_stilling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($afloeserItem['user']->field_titel_stilling['und'][0]['tid'])->name . "\"><span class=\"titel\">" . taxonomy_term_load($afloeserItem['user']->field_titel_stilling['und'][0]['tid'])->name . "</span></a><br />";
                }
                // AFDELING
                if($afloeserItem['user']->field_afdeling) {
                  $outputuser .= "<a href=\"" . url('taxonomy/term/' . $afloeserItem['user']->field_afdeling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($afloeserItem['user']->field_afdeling['und'][0]['tid'])->name . "\"><span class=\"afdeling\">" . taxonomy_term_load($afloeserItem['user']->field_afdeling['und'][0]['tid'])->name . "</span></a><br />";
                }
                // TELEFON
                if($afloeserItem['user']->field_direkte_telefon) {
                  $outputuser .= "<span class=\"telefon\">" . preg_replace('/\s+/', '', $afloeserItem['user']->field_direkte_telefon['und'][0]['safe_value']) . "</span><br />";
                }
                // E-MAIL
                if($afloeserItem['user']->mail) {
                  $outputuser .= "<a href=\"mailto:" . $afloeserItem['user']->mail . "\" titel=\"Send en mail til " . $name . "\"><span class=\"email\">" . $afloeserItem['user']->mail . "</span></a>";
                }
                $outputuser .= "</div>";
                $outputuser .= "</li>";
                $outputuser .= "</ul>";
                $outputuser  .="</div>";
              }

              $output .= $outputuser;
              $output .= "</div>";

            }

            // OVERORDNET
            if($showuser->field_overordnet) {

              $output .= "<div class=\"forfatter-container user-side\">";

              if(count($showuser->field_overordnet['und']) > 1) {
                $output .= "<p class=\"hest\"><strong>LEDERE:</strong></p>";
              }
              else {
                $output .= "<p class=\"hest\"><strong>LEDER:</strong></p>";
              }

              $outputuser = "";

              foreach ($showuser->field_overordnet['und'] as $overordnetKey => $overordnetItem) {

                $outputuser .= "<div class=\"forfatter\">";
                $outputuser .= "<ul class=\"search-employees show\">";
                $outputuser .= "<li>";
                // KALDENNAVN - FOR- OG EFTERNAVN
                if ($overordnetItem['user']->field_kaldenavn['und'][0]['safe_value'] != '') {
                  $name = $overordnetItem['user']->field_kaldenavn['und'][0]['safe_value'];
                }
                else {
                  $name = $overordnetItem['user']->field_fornavn['und'][0]['safe_value'] . ' ' . $overordnetItem['user']->field_efternavn['und'][0]['safe_value'];
                }

                if($overordnetItem['user']->field_fornavn and $overordnetItem['user']->field_efternavn) {
                  $outputuser .= "<a href=\"/users/" . $overordnetItem['user']->name . "\" titel=\"\"><span class=\"navn\">" . $name . "</span></a>";
                }

                $outputuser .= "<div class=\"foto\">";
                $outputuser .= "<a class=\"foto\" href=\"/users/" . $overordnetItem['user']->name . "\" titel=\"" . $name . "\">";
                // FOTO
                if($overordnetItem['user']->picture) {
                  $outputuser .= "<img alt=\"" . $name . "\" src=\"" . image_style_url('profilfoto_lille', $overordnetItem['user']->picture->uri) . "\" />";
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
                if($overordnetItem['user']->field_titel_stilling) {
                  $outputuser .= "<a href=\"" . url('taxonomy/term/' . $overordnetItem['user']->field_titel_stilling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($overordnetItem['user']->field_titel_stilling['und'][0]['tid'])->name . "\"><span class=\"titel\">" . taxonomy_term_load($overordnetItem['user']->field_titel_stilling['und'][0]['tid'])->name . "</span></a><br />";
                }
                // AFDELING
                if($overordnetItem['user']->field_afdeling) {
                  $outputuser .= "<a href=\"" . url('taxonomy/term/' . $overordnetItem['user']->field_afdeling['und'][0]['tid']) . "\" titel=\"" . taxonomy_term_load($overordnetItem['user']->field_afdeling['und'][0]['tid'])->name . "\"><span class=\"afdeling\">" . taxonomy_term_load($overordnetItem['user']->field_afdeling['und'][0]['tid'])->name . "</span></a><br />";
                }
                // TELEFON
                if($overordnetItem['user']->field_direkte_telefon) {
                  $outputuser .= "<span class=\"telefon\">" . preg_replace('/\s+/', '', $overordnetItem['user']->field_direkte_telefon['und'][0]['safe_value']) . "</span><br />";
                }
                // E-MAIL
                if($overordnetItem['user']->mail) {
                  $outputuser .= "<a href=\"mailto:" . $overordnetItem['user']->mail . "\" titel=\"Send en mail til " . $name . "\"><span class=\"email\">" . $overordnetItem['user']->mail . "</span></a>";
                }
                $outputuser .= "</div>";
                $outputuser .= "</li>";
                $outputuser .= "</ul>";
                $outputuser  .="</div>";
              }

              $output .= $outputuser;
              $output .= "</div>";


            }



//            $output .=  "<div class=\"artikel-boks\">";
//              $output .=  "<p>&nbsp;</p><p>&nbsp;</p>";

  //                  $output .=  "<h2>Kontakt os, når du har brug for hjælp til hjemmesiden</h2>";
  //                  $output .=  "<h3>Når du har brug for hjælp til indhold, fx tekster, placering af indhold, struktur, menuer mv.</h3>";
  //                  $output .=  "<ul style=\"margin-top:0;\">";
  //                  $output .=  "<li>Thomas Aagaard Kjeldsen<br />Tlf. 43 57 62 29<br /><a href=\"mailto:thk@ishoj.dk\" title=\"Send en e-mail til Thomas Aagaard Kjeldsen\">thk@ishoj.dk</a></li>";
  //                  $output .=  "<li>Henrik Alexandersen<br />Tlf. 43 57 62 34<br /><a href=\"mailto:39456@ishoj.dk\" title=\"Send en e-mail til Henrik Alexandersen\">39456@ishoj.dk</a></li>";
  //                  $output .=  "</ul>";
  //
  //                  $output .=  "<h3>Når du har spørgsmål til teknikken, fx funktionalitet, fejlmeddelelser mv.</h3>";
  //
  //                  $output .=  "<ul>";
  //                    $output .=  "<li>Thomas Mikkel Jensen<br />Tlf. 43 57 62 04<br /><a href=\mailto:tho@ishoj.dk\" title=\"Send en e-mail til Thomas Mikkel Jensen\">tho@ishoj.dk</a></li>";
  //                    $output .=  "<li>Jesper Vig Meyer<br />Tlf. 43 57 62 03<br /><a href=\mailto:jvm@ishoj.dk\" title=\"Send en e-mail til Jesper Vig Meyer\">jvm@ishoj.dk</a></li>";
  //                  $output .=  "</ul>";

//            $output .=  "</div>";
//          $output .= "</div>";



        $output .= "</div>";
      $output .= "</div>";
    $output .= "</section>";
    $output .= "<!-- ARTIKEL SLUT -->";

  $output .= "</div>";
  $output .= "<!-- CONTENT SLUT -->";

$output .= "</div>";
$output .= "<!-- PAGE SLUT -->";

}
print $output;

?>
 <?php // print render($user_profile); ?>

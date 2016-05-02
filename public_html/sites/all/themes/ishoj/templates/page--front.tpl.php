<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>


<?php
include_once drupal_get_path('theme', 'ishoj') . '/includes/uglen_functions.php';
// Sætter metatags på forsiden
print render($page['content']['metatags']);
global $user;
$name = '';
$showuser = user_load($user->uid);
$firstname = $showuser->field_fornavn['und'][0]['safe_value'];
if ($showuser->field_kaldenavn['und'][0]['safe_value'] != '') {
  $name = $showuser->field_kaldenavn['und'][0]['safe_value'];
}
else {
  $name = $showuser->field_fornavn['und'][0]['safe_value'] . ' ' . $showuser->field_efternavn['und'][0]['safe_value'];
}



?>
    <!-- BRUGER BAR START -->
    <section class="bruger-bar">
      <div class="container">
        <div class="row">
          <div class="grid-full">
<?php
            $brugerbar = "";
            if($logged_in) {
              $brugerbar .= "<a href=\"/user\" title=\"Din brugerprofil\">" . $name . "</a>";
              $brugerbar .= " &nbsp;&nbsp;&nbsp; ";
              $brugerbar .= "<a href=\"/user/logout\" title=\"Log ud\">Log ud</a>";
            }
            else {
              $brugerbar .= "<a href=\"/user\" title=\"Log ind\">Log ind</a>";
            }
            print $brugerbar;

?>

          </div>
        </div>
      </div>
    </section>
    <!-- BRUGER BAR SLUT -->


    <!-- HEADER START -->
    <header data-role="header">

      <!-- NAVIGATION START -->
      <div class="container">

            <!-- ARROW START -->
            <div class="arrow action">

              <!-- IKONER START -->
<!--              <i class="icon icon-list btn-mobilmenu" title="Vis menu"></i>-->
              <i class="header-menu" title="Vis menu"></i>
<!--              <i class="icon icon-cross btn-mobilmenu-hide hide-me" title="Skjul menu"></i>-->
              <i class="header-kryds hide-me" title="Skjul menu"></i>
<!--              <i class="icon icon-search btn-search"  title="Søg"></i>-->
              <i class="header-search" title="Søg"></i>
              <?php
                if($logged_in) {
                  print "<i class=\"header-plus\" title=\"Tilføj nyt indhold\"></i>";
                }
              ?>
              <!-- IKONER SLUT -->

              <!-- MENU START -->
              <nav class="mainMenu">
                <?php print render($page['menu']); ?>
              </nav>
              <!-- MENU SLUT -->

              <!-- LOGO START -->
              <?php
              if($logo or $site_name) {
                // site version
                $logoContent = "<div class=\"logo-container\">";
                $logoContent .= "<a class=\"logo-site\" href=\"" . $front_page . "\" title=\"Gå til forsiden\" rel=\"home\">";
                if($logo) {
                  $logoContent .= "<img src=\"" . $logo . "\" alt=\"Gå til forsiden\"/>";
                }
                if($site_name) {
//                  $logoContent .= $site_name;
                  $logoContent .= "<span>" . $site_name . "</span>";
                }
                $logoContent .= "</a></div>";

                // print version
                print $logoContent;
              }
              ?>
              <!-- LOGO SLUT -->

            </div>
            <!-- ARROW SLUT -->

      </div>
      <!-- NAVIGATION SLUT -->

      <!-- MOBILMENU START -->
      <nav data-role="mobilenav">
        <?php print render($page['menu_mobile']); ?>
      </nav>
      <!-- MOBILMENU SLUT -->

      <?php
      if($logged_in) {
        print "<!-- TILFØJ INDHOLD START -->";
        print "<section class=\"tilfoej-indhold\">";
          print "<div class=\"container\">";
            print "<div class=\"row\">";
              print "<div class=\"grid-full\">";
                print "<h2>Opret nyt indhold</h2>";
              print "</div>";
              print "<ul>";
  //<!--
  //              <li>
  //                <a href="/node/add/aktivitet" title="">
  //                  <span class="cat-icon"></span>
  //                  <span class="cat-text">Aktivitet</span>
  //                </a>
  //              </li>
  //-->
                print "<li>";
                  print "<a href=\"/node/add/os2web-base-contentpage\" title=\"\">";
                    print "<span class=\"cat-icon\"></span>";
                    print "<span class=\"cat-text\">Indholdsside</span>";
                  print "</a>";
                print "</li>";
                print "<li>";
                  print "<a href=\"/node/add/nyheder\" title=\"\">";
                    print "<span class=\"cat-icon\"></span>";
                    print "<span class=\"cat-text\">Nyhed</span>";
                  print "</a>";
                print "</li>";
              print "</ul>";
            print "</div>";
          print "</div>";
        print "</section>";
        print "<!-- TILFØJ INDHOLD SLUT -->";
      }
      ?>

      <!-- SØGEBAR START -->
      <section class="soegebar animate bg-<?php echo mt_rand(1,9); ?>">
        <div class="container">
          <div class="row formular">
            <div class="soegeresultat-blinker animated shake"></div>
            <div class="grid-full">




                <?php
                if($logged_in) {
//print "<h1>Hej " . $firstname .  " hvad søger du?</h1>";
print "<h1>Hvad søger du?</h1>";
} else {
print "<h1>Hvad søger du?</h1>";
}
?>
              <form id="sogeformen" action="/" method="post" accept-charset="UTF-8">
                <label class="" for="soegefelt">Søg</label>
                  <?php
if($logged_in) {
print '<input id="soegefelt" placeholder="Indtast dine søgeord"/>';
} else {
print '<input id="soegefelt" placeholder="Indtast dit søgeord"/>';
}



                  ?>
 </form>
<!--
              <div class="search-filter">
                <div class="filter-lines"></div>
                <div class="add-filter-line">

                  <span class="add-search-filter"><i class="search-filter-plus" title="Tilføj søgefilter"></i><span>Tilføj søgefilter</span></span>

                  <form class="addFilterForm hide-me">
                    <select name="addFilter" id="addFilter" class="sprite-menu">
                      <option value="0" selected="">Vælg søgefilter</option>
                      <option value="medarbejder">Medarbejder</option>
                      <option value="indholdssider">Indholdssider</option>
                      <option value="bilag">Bilag / dokumenter</option>
                      <option value="afdeling">Center / afdeling</option>
                      <option value="ansvarsområder">Ansvarsområder</option>
                      <option value="stilling">Titel / stilling</option>
                    </select>
                  </form>

                </div>
              </div>
-->
            </div>
          </div>
        </div>
      </section>
      <!-- SØGEBAR SLUT -->

      <!-- SØGEFANER START -->
      <section class="soegebar-faner medarbejdere">
      </section>
      <!-- SØGEFANER SLUT -->

      <!-- SØGERESULTATER START -->
      <section class="soegebar-resultater">
      </section>
      <!-- SØGERESULTATER SLUT -->


    </header>
    <!-- HEADER SLUT -->

    <!-- PAGE START -->
    <div data-role="page">

      <?php if ($messages): ?>
      <!-- DRUPAL MESSAGES START -->
      <div class="drupal-messages">
        <div class="container">
          <div class="row">
            <div class="grid-full">
              <?php print $messages; ?>
              <?php
              if($is_admin) {
                if ($tabs): ?>
                  <div class="tabs">
                    <?php print render($tabs); ?>
                  </div>
                <?php
                endif;
              }
              ?>
              <?php print render($page['help']); ?>
              <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <!-- DRUPAL MESSAGES SLUT -->
      <?php endif; ?>


      <?php //if($page['editor'] and $logged_in): ?>
      <?php //if($logged_in): ?>
        <!-- REDAKTØRMENU START -->
<!--
        <section class="redaktormenu">
          <div class="container">
            <div class="row">
              <div class="grid-full">
                <div class="editor">
                  <div class="editorInner">
                    <?php //print render($page['editor']); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
-->
        <!-- REDAKTØRMENU SLUT -->
      <?php //endif; ?>



      <!-- CONTENT START -->
      <div data-role="content">

      <?php
//        $output = "";
//
//        $output = $output . "<!-- CONTENT CATEGORY START -->";
//        $output = $output . "<section class=\"content-category-ny\">";
//          $output = $output . "<div class=\"container\">";
//            $output = $output . "<div class=\"row\">";
//
//              $vocabularies = taxonomy_get_vocabularies();
//              if ($vocabularies) {
//                foreach($vocabularies as $vocabulary) {
//                  if($vocabulary->name == "Kategori") {
//                    $terms = taxonomy_get_tree($vocabulary->vid, $parent = 0, $max_depth = 1, $load_entities = FALSE);
//                    if ($terms) {
//                      $output = $output . "<ul class=\"list-unstyled\">";
//                      foreach ($terms as $term) {
//                        switch ($term->tid) {
//    case "2925":
//      //  DONT SHOW
//        break;
//    case "3013":
//     //  DONT SHOW
//        break;
//    case "3896":
//     //  DONT SHOW
//        break;
//    default:
//      $output = $output . "<li><a href=\"" . url('taxonomy/term/' . $term->tid) . "\" title=\"" . $term->name . "\"><span class=\"cat-icon\"></span><span class=\"cat-text\">" . $term->name . "</span></a></li>";
//}
//
//                      }
//                      $output = $output . "</ul>";
//                    }
//                  }
//                }
//              }
//
//            $output = $output . "</div>";
//          $output = $output . "</div>";
//        $output = $output . "</section>";
//        $output = $output . "<!-- CONTENT CATEGORY SLUT -->";
//
//        print $output;
        ?>

        <?php

//        if($is_admin) {
          $output = "";
          $output .= "<!-- NYHEDER START -->";

          $output .= "<section class=\"news-almindelige\">";
            $output .= "<div class=\"container\">";

////////////////////////////////////////////////////////////////////////////////
//            if($is_admin) {
              if($logged_in) {
                if(($user->uid == $showuser->uid) or $is_admin) {

                  $mangler = 0;

                  $mangler_output_top = "<div class=\"user-missing-data\">";
                  $mangler_output_top .= "<ul>";

                  $mangler_output = "";
                  $mangler_output_bottom = "";

                  $mangler_output_top = "<div class=\"row row-topnyhed\"><div class=\"grid-full\">";
                    $mangler_output_top .= "<div class=\"user-missing-data ny\">";

                      $mangler_output_top .= "<div class=\"left\">";

                        $mangler_output_top .= "<ul>";

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
                          if(!$showuser->field_afloeser) {
                            $mangler_output .= "<li>Afløser</li>";
                            $mangler++;
                          }
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

                        $mangler_output_bottom .= "</ul>";

                        // Ret bruger knap
                        if($logged_in) {
                          if(($user->uid == $showuser->uid) or $is_admin) {
                            $mangler_output_bottom .= "<div style=\"float:left; width:100%; margin-bottom:1em;\"><div class=\"edit-node\"><a href=\"/user/" . $showuser->uid . "/edit?pk_campaign=Forside-RetBruger\" title=\"Ret bruger\"><span>Ret profil</span></a></div></div>";
                          }
                        }

                      // Citat
                      $mangler_output_bottom .= "</div>";
                      $mangler_output_bottom .= "<div class=\"right\">";
                        $mangler_output_bottom .= "<div class=\"foto\"><img src=\"/sites/all/themes/ishoj/dist/img/ahj_brugeroplysninger.png\"></div>";
                        $mangler_output_bottom .= "<div class=\"text\"><h2>\"Det er vigtigt, at vi alle sørger for at opdatere vores profiler på Uglen\"</h2><h2>- Anders Hvid Jensen</h2><h3>Kommunaldirektør</h3></div>";
                      $mangler_output_bottom .= "</div>";
                    $mangler_output_bottom .= "</div>";

                  $mangler_output_bottom .= "</div></div>";

                  // Hvis der min. er et felt, der mangler at blive udfyldt
                  if($mangler > 0) {
                    list($first_word) = explode(' ', trim($showuser->field_fornavn['und'][0]['safe_value']));

                    if($mangler == 1) {
                      $output .= $mangler_output_top . "<h3>Hej " . $first_word . "</h3><p>Du mangler at udfylde følgende felt for at færdiggøre din profil:</p>" . $mangler_output .  $mangler_output_bottom;
                    }
                    else {
                      $output .= $mangler_output_top . "<h3>Hej " . $first_word . "</h3><p>Du mangler at udfylde følgende felter for at færdiggøre din profil:</p>" . $mangler_output . $mangler_output_bottom;
                    }
                  }
                }
              }
//            }
////////////////////////////////////////////////////////////////////////////////
              $output .= "<div class=\"row\"><div class=\"grid-full\"></div></div>";
              $output .= "<div class=\"row\">";
                 $output .= "<div class=\"grid-third\">";
                    $output .= views_embed_view('nyhedsliste','topnyheder_lodret_liste');
                 $output .= "</div>";
                 $output .= "<div class=\"grid-two-thirds almindelige\">";

                    // TILMELDING TIL SMS-DRIFTSSTATUS START
                    if($is_admin) {
                      $output .= "<div class=\"sms-driftsstatus\">";

                        $output .= "<div class=\"microArticleContainer\" style=\"margin:0 0 2.5em !important;\">";
                          $output .= "<div class=\"microArticle\">";
                            $output .= "<h3 class=\"mArticle\" id=\"mArticle2\">";
                              $output .= "<span class=\"sprites-sprite sprite-plus mikroartikel\"></span>Tilmelding til SMS-driftsstatus";
                            $output .= "</h3>";
                            $output .= "<div class=\"mArticle2 mArticle\" style=\"overflow: hidden; display: none;\">";
                              $output .= "<p>Tilmeld dig den/de SMS-driftstatuslister, som du har behov for i forhold til dit arbejde.</p>";
                              $output .= "<h3>Care</h3>";
                              $output .= "<h3>Citrix</h3>";
                              $output .= "<h3>Outlook</h3>";
                              $output .= "<h3>SBSYS</h3>";
                            $output .= "</div>";
                          $output .= "</div>";
                        $output .= "</div>";

                      $output .= "</div>";
                    }

                    $output .= views_embed_view('nyhedsliste','almindelige_nyheder_ny2', $node->nid);

                    // MIDLERTIDIG BOKS I.F.M. VINDUESUDSKIFTNINGEN
                    $output .= '<p class="vinduesudskiftning"><a title="Information om vinduesudskiftningen på rådhuset" href="/kategori/vinduesudskiftning-paa-raadhuset">Information om vinduesudskiftningen på rådhuset</a></p>';

                 $output .= "</div>";
                 $output .= "<div class=\"grid-third\">";
                 $output .= "</div>";
              $output .= "</div>";
            $output .= "</div>";
          $output .= "</section>";

          print $output;
//        }

        ?>


        <!-- NYHEDER SLUT -->

        <!-- AKTIVITER START -->
<!--
        <section class="activities" id="thomastester">
          <div class="container">
            <div class="row">
              <div class="grid-full">
                <h2>Aktiviteter</h2>
                <div class="swiper-container-activities">
                  <div class="swiper-wrapper">
                    <?php // print views_embed_view('aktiviteter','aktivitet_forside'); ?>
                  </div>
                </div>
                <div class="activities-swiper-button-container">
                  <div class="swiper-button activities-swiper-button-prev"></div>
                  <div class="swiper-button activities-swiper-button-next"></div>
                </div>
                <div class="more-content">
                  <h3><a href="/kategori/aktiviteter" title="Få en oversigt over aktiviteter og arrangementer i Ishøj Kommune">Flere aktiviteter</a></h3>
                </div>
              </div>
            </div>
          </div>
        </section>
-->
        <!-- AKTIVITER SLUT -->


        <!-- SOCIAL CONTENT START -->
        <section class="social-content">
          <div class="container">
            <div class="row">
              <div class="grid-full">
                <h2>Nyt på vores sociale medier</h2>
                <div class="swiper-container-social-content">
                  <div class="swiper-wrapper">
                    <?php print views_embed_view('social_content','default'); ?>
                  </div>
                </div>
                <div class="swiper-button-container">
                  <div class="swiper-button swiper-button-prev"></div>
                  <div class="swiper-button swiper-button-next"></div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- SOCIAL CONTENT SLUT -->



        <?php //print render($page['content']); ?>
      </div>
      <!-- CONTENT SLUT -->



      <!-- FOOTER START -->
      <footer data-role="footer">
        <div class="container">
          <div class="row">
            <div class="grid-third">
              <?php //print render($page['footer_kontakt']); ?>

              <h3>Vi vil gerne høre, hvad du synes</h3>
              <p class="artikel"><a class="btn btn-large_ sigdinmening" href="/sig-din-mening-om-uglen" title="Sig din mening om Uglen"><span class="sprites-sprite sprite-arrow-right"></span>Sig din mening om Uglen</a>

            </div>
            <div class="grid-third"></div>
            <div class="grid-third sociale-medier">
              <?php print render($page['footer_sociale']); ?>
              <h3>Ishøj Kommune på sociale medier</h3>
              <p>
                <a class="sprite sprite-facebook footer" href="http://www.facebook.com/ishojkommune" title="Følg Ishøj Kommune på Facebook"><span><span class="screen-reader">Følg Ishøj Kommune på Facebook</span></span></a>
                <a class="sprite sprite-linkedin footer" href="https://www.linkedin.com/company/ishoj-kommune" title="Følg Ishøj Kommune på LinkedIn"><span><span class="screen-reader">Følg Ishøj Kommune på LinkedIn</span></span></a>
                <a class="sprite sprite-twitter footer" href="http://www.twitter.com/ishojkommune" title="Følg Ishøj Kommune på Twitter"><span><span class="screen-reader">Følg Ishøj Kommune på Twitter</span></span></a>
                <a class="sprite sprite-youtube footer" href="http://www.youtube.com/tvishoj" title="Følg Ishøj Kommune på Youtube"><span><span class="screen-reader">Følg Ishøj Kommune på Youtube</span></span></a>
              </p>
            </div>
<!--
            <div class="grid-third">
              <h3>Kommunale hjemmesider</h3>
              <form>
                <label for="hjemmesider">Andre hjemmesider</label>
                  <select name="hjemmesider" id="hjemmesider" class="sprite-menu">
                  <optgroup label="Andre hjemmeside">
                   <option value="0" selected="">Vælg en hjemmeside</option>
                  <?php //print views_embed_view('andre_kommunale_hjemmesider','default', $node->nid); ?>
                  </optgroup>
                      <?php //print render($page['footer_hjemmesider']); ?>

                    </select>
              </form>
            </div>
-->

          </div>
        </div>
      </footer>
      <!-- FOOTER SLUT-->

      <?php print breaking(); ?>


    </div>
    <!-- PAGE SLUT -->

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

// Sætter metatags på forsiden
print render($page['content']['metatags']); 

?>
  
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
                 
                  
      <!-- SØGEBAR START -->
      <section class="soegebar animate bg-<?php echo mt_rand(1,9); ?>">
        <div class="container">
          <div class="row formular">
            <div class="grid-full">
              <h1>Hvad søger du?</h1>
              <form action="/" method="post" accept-charset="UTF-8">
                <label class="" for="soegefelt">Søg</label>
                <input id="soegefelt" placeholder="Indtast dit søgeord"/>
              </form>
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
            </div>
          </div>
        </div>
      </section>
      <!-- SØGEBAR SLUT -->      

      <!-- SØGEFANER START -->      

      <section class="soegebar-faner medarbejdere">
<!--        <div class="container">
          <div class="row">
            <div class="grid-half medarbejdere">Medarbejdere <span title="7 søgeresultater">7</span></div>  
            <div class="grid-half indhold">Indhold <span title="1200 søgeresultater">1200</span></div>  
          </div>
        </div>-->
      </section>

      <!-- SØGEFANER SLUT -->      
      
      <!-- SØGERESULTATER START -->

      <section class="soegebar-resultater">
<!--        <div class="container">
          <div class="row search-results show">
-->
 
            <!-- INDHOLD -->
<!--
            <h2 class="indhold">Indhold <span title="1200 søgeresultater">1200</span></h2>
            
            <ul class="search-content">
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">En side om et eller andet</span></a>
                <div class="details">
                  <span class="beskrivelse">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                  <a href="" title=""><span class="kategori"><span>Akutte skader</span></span></a>
-->
<!--
                </div>
              </li>
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Meget spændende indhold</span></a>
                <div class="details">
                  <span class="beskrivelse">Phasellus quis lectus metus, at posuere neque.</span>
                  <a href="" title=""><span class="kategori"><span>Akutte skader</span></span></a>
-->
<!--
                </div>
              </li>
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Gratis kage til alle</span></a>
                <div class="details">
                  <span class="beskrivelse">Sed blandit augue vitae.</span>
                  <a href="" title=""><span class="kategori"><span>Arbejdsskader</span></span></a>
-->
<!--
                </div>
              </li>
            </ul>           
-->

                                         
            <!-- MEDARBEJDERE -->
<!--
            <h2 class="medarbejdere action">Medarbejdere <span title="7 søgeresultater">7</span></h2>
            
            <ul class="search-employees show">
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Thomas Mikkel Jensen</span></a>
                <div class="foto">
                  <a class="foto" href="" titel="Thomas Mikkel Jensen">
                    <img src="http://intranet.ishoj.bellcom.dk/sites/default/files/pictures/picture-40-1433354383.jpg" alt="Thomas Mikkel Jensen">
                    <span class="optaget"></span>
                  </a>
                </div>
                <div class="details">
                  <a href="" titel="Multimediedesigner"><span class="titel">Multimediedesigner</span></a><br />
                  
                  <a href="" titel="Kommunikation"><span class="afdeling">Kommunikation</span></a><br />
                  <span class="telefon">43 57 62 04</span><br />
                  <a href="mailto:tho@ishoj.dk" titel="Send en mail til Thomas"><span class="email">tho@ishoj.dk</span></a>
                </div>
              </li>
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Connie Susanne Skjødt Pedersen</span></a>
                <div class="foto">
                  <a class="foto" href="" titel="Thomas Mikkel Jensen">
                    <img src="http://intranet.ishoj.bellcom.dk/sites/all/themes/ishoj/dist/img/sprites-no/nopic.png" alt="Thomas Mikkel Jensen">
                    <span class="optaget"></span>
                  </a>
                </div>
                <div class="details">
                  <a href="" titel="Multimediedesigner"><span class="titel">Multimediedesigner</span></a><br />
                  <a href="" titel="Kommunikation"><span class="afdeling">Kommunikation</span></a><br />
                  <span class="telefon">43 57 62 04</span><br />
                  <a href="mailto:tho@ishoj.dk" titel="Send en mail til Thomas"><span class="email">tho@ishoj.dk</span></a>
                </div>
              </li>
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Thomas Mikkel Jensen</span></a>
                <div class="foto">
                  <a class="foto" href="" titel="Thomas Mikkel Jensen">
                    <span class="ledig"></span>
                  </a>
                </div>
                <div class="details">
                  <a href="" titel="Multimediedesigner"><span class="titel">Multimediedesigner</span></a><br />
                  <a href="" titel="Kommunikation"><span class="afdeling">Kommunikation</span></a><br />
                  <span class="telefon">43 57 62 04</span><br />
                  <a href="mailto:tho@ishoj.dk" titel="Send en mail til Thomas"><span class="email">tho@ishoj.dk</span></a>
                </div>
              </li>
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Thomas Mikkel Jensen</span></a>
                <div class="foto">
                  <a class="foto" href="" titel="Thomas Mikkel Jensen">
                    <img src="http://intranet.ishoj.bellcom.dk/sites/default/files/pictures/picture-40-1433354383.jpg" alt="Thomas Mikkel Jensen">
                    <span class="optaget"></span>
                  </a>
                </div>
                <div class="details">
                  <a href="" titel="Multimediedesigner"><span class="titel">Multimediedesigner</span></a><br />
                  <a href="" titel="Kommunikation"><span class="afdeling">Kommunikation</span></a><br />
                  <span class="telefon">43 57 62 04</span><br />
                  <a href="mailto:tho@ishoj.dk" titel="Send en mail til Thomas"><span class="email">tho@ishoj.dk</span></a>
                </div>
              </li>
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Connie Susanne Skjødt Pedersen</span></a>
                <div class="foto">
                  <a class="foto" href="" titel="Thomas Mikkel Jensen">
                    <span class="ledig"></span>
                  </a>
                </div>
                <div class="details">
                  <a href="" titel="Multimediedesigner"><span class="titel">Multimediedesigner</span></a><br />
                  <a href="" titel="Kommunikation"><span class="afdeling">Kommunikation</span></a><br />
                  <span class="telefon">43 57 62 04</span><br />
                  <a href="mailto:tho@ishoj.dk" titel="Send en mail til Thomas"><span class="email">tho@ishoj.dk</span></a>
                </div>
              </li>
              <li>
                <a href="" titel="Thomas Mikkel Jensen"><span class="navn">Thomas Mikkel Jensen</span></a>
                <div class="foto">
                  <a class="foto" href="" titel="Thomas Mikkel Jensen">
                    <span class="ledig"></span>
                  </a>
                </div>
                <div class="details">
                  <a href="" titel="Multimediedesigner"><span class="titel">Multimediedesigner</span></a><br />
                  <a href="" titel="Kommunikation"><span class="afdeling">Kommunikation</span></a><br />
                  <span class="telefon">43 57 62 04</span><br />
                  <a href="mailto:tho@ishoj.dk" titel="Send en mail til Thomas"><span class="email">tho@ishoj.dk</span></a>
                </div>
              </li>
            </ul>
          </div>
        </div>-->
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
              <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
              <?php print render($page['help']); ?>
              <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <!-- DRUPAL MESSAGES SLUT -->
      <?php endif; ?>
    
        
      <?php if($page['editor'] and $logged_in): ?>
      <?php //if($logged_in): ?>
        <!-- REDAKTØRMENU START -->        
        <section class="redaktormenu">
          <div class="container">
            <div class="row">
              <div class="grid-full">
                <div class="editor">
                  <div class="editorInner">
                    <?php print render($page['editor']); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- REDAKTØRMENU SLUT -->
      <?php endif; ?>
      
      
      
      <!-- CONTENT START -->
      <div data-role="content"> 
       
      <?php
        $output = "";

        $output = $output . "<!-- CONTENT CATEGORY START -->";
        $output = $output . "<section class=\"content-category-ny\">";
          $output = $output . "<div class=\"container\">";
            $output = $output . "<div class=\"row\">";

              $vocabularies = taxonomy_get_vocabularies();
              if ($vocabularies) {
                foreach($vocabularies as $vocabulary) {
                  if($vocabulary->name == "Kategori") {
                    $terms = taxonomy_get_tree($vocabulary->vid, $parent = 0, $max_depth = 1, $load_entities = FALSE);
                    if ($terms) {
                      $output = $output . "<ul class=\"list-unstyled\">";
                      foreach ($terms as $term) {
                        switch ($term->tid) {
    case "2925":
      //  DONT SHOW
        break;
    case "3013":
     //  DONT SHOW
        break;
    default:
      $output = $output . "<li><a href=\"" . url('taxonomy/term/' . $term->tid) . "\" title=\"" . $term->name . "\"><span class=\"cat-icon\"></span><span class=\"cat-text\">" . $term->name . "</span></a></li>";
}
                       
                      }
                      $output = $output . "</ul>";
                    }
                  }
                }
              }

            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</section>";
        $output = $output . "<!-- CONTENT CATEGORY SLUT -->";     

        print $output;
        ?>

        <!-- NYHEDER START -->
        <section class="news">
          <div class="container">
            <!-- Nyheder -->
            <div class="row">
              <div class="grid-full">
                <h2>Aktuelt</h2>
                <div class="swiper-container-news">
                  <div class="swiper-wrapper">
                    <?php print views_embed_view('nyhedsliste','panel_pane_2', $node->nid); ?>
                  </div>
                </div>       
                
                <div class="news-swiper-button-container">
                  <div class="swiper-button white news-swiper-button-prev "></div>
                  <div class="swiper-button white news-swiper-button-next "></div>
                </div>
              </div>
            </div>
            <!-- TV-Ishøj -->
<!--
            <div class="row">
              <div class="grid-full">
               <h3>Nyt fra TV-Ishøj</h3>
                <div class="swiper-container-news_tvi">
                  <div class="swiper-wrapper">
                    <?php //print views_embed_view('nyhedsliste','youtubeliste_forside', $node->nid); ?>
                  </div>
                </div>       
                
                <div class="news_tvi-swiper-button-container">
                  <div class="swiper-button white news_tvi-swiper-button-prev "></div>
                  <div class="swiper-button white news_tvi-swiper-button-next "></div>
                </div>
              </div>
            </div>
-->
          </div>
        </section>
        
        <section class="news-almindelige">
          <div class="container">
            <div class="row">
<!--              <div class="grid-full">-->
                <ul>
                  <?php print views_embed_view('nyhedsliste','almindelige_nyheder', $node->nid); ?>
                </ul>                
<!--              </div>-->
            </div>
          </div>
        </section>
        
        
        
        <!-- NYHEDER SLUT -->

        <!-- AKTIVITER START -->
        <section class="activities">
          <div class="container">
            <div class="row">
              <div class="grid-full">
                <h2>Aktiviteter</h2>
                <div class="swiper-container-activities">
                  <div class="swiper-wrapper">
                    <?php print views_embed_view('aktiviteter','aktivitet_forside'); ?>
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
              <h3>Andre kommunale hjemmesider</h3>
              <form>
                <label for="hjemmesider">Andre hjemmesider</label>
                  <select name="hjemmesider" id="hjemmesider" class="sprite-menu">
                  <optgroup label="Andre hjemmeside">
                   <option value="0" selected="">Vælg en hjemmeside</option>                  
                  <?php print views_embed_view('andre_kommunale_hjemmesider','default', $node->nid); ?>
                  </optgroup>
                      <?php print render($page['footer_hjemmesider']); ?>
                
                    </select>
              </form>
            </div>
            <div class="grid-third">
              <?php //print render($page['footer_kontakt']); ?>
              
              <h3>Ishøj Kommune</h3>
              <p>Ishøj Store Torv 20<br />
              2635 Ishøj<br />
              Tlf. 43 57 75 75</p>
              <p><a href="mailto:ishojkommune@ishoj.dk" title="Skriv e-mail til Ishøj Kommune">ishojkommune@ishoj.dk</a></p>

            </div>
            <div class="grid-third sociale-medier">
              <?php print render($page['footer_sociale']); ?>           
              <h3>Følg os på sociale medier</h3>
              <p>
                <a class="sprite sprite-facebook footer" href="http://www.facebook.com/ishojkommune" title="Følg Ishøj Kommune på Facebook"><span><span class="screen-reader">Følg Ishøj Kommune på Facebook</span></span></a>
                <a class="sprite sprite-linkedin footer" href="https://www.linkedin.com/company/ishoj-kommune" title="Følg Ishøj Kommune på LinkedIn"><span><span class="screen-reader">Følg Ishøj Kommune på LinkedIn</span></span></a>
                <a class="sprite sprite-twitter footer" href="http://www.twitter.com/ishojkommune" title="Følg Ishøj Kommune på Twitter"><span><span class="screen-reader">Følg Ishøj Kommune på Twitter</span></span></a>
                <a class="sprite sprite-youtube footer" href="http://www.youtube.com/tvishoj" title="Følg Ishøj Kommune på Youtube"><span><span class="screen-reader">Følg Ishøj Kommune på Youtube</span></span></a>
              </p>
            </div>
          </div>             
        </div>   
      </footer>
      <!-- FOOTER SLUT-->
      
      <?php
      // BREAKING
      print views_embed_view('kriseinformation', 'pagevisning');
      ?>


            
    </div>
    <!-- PAGE SLUT -->
    
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
global $user;
$name = '';
$showuser = user_load($user->uid);
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
            <div class="arrow">
            
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
      <section class="soegebar">
        <div class="container">
          <div class="row formular">
            <div class="grid-full">
              <h1>Hvad søger du?</h1>
              <form action="/" method="post" accept-charset="UTF-8">
<!--                <div>-->
                  <label class="" for="soegefelt">Søg</label>
                  <input id="soegefelt" placeholder="Indtast dit søgeord"/>
<!--
                  <div>
                    <input type="submit" value="Søg"/>
                  </div>
-->
<!--                </div>-->
              </form>              
            </div>      
          </div>
        </div>
      </section>
      <!-- SØGEBAR SLUT -->      
      
    </header>
    <!-- HEADER SLUT --> 
    
    <!-- PAGE START -->
    <div data-role="page"> 
    
      <!-- DRUPAL MESSAGES START -->
      <?php if ($messages): ?>
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
      <?php endif; ?>
      <!-- DRUPAL MESSAGES SLUT -->
      
      
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
       
       
<!-- ***************************************************************************************** -->



<?php
        $output = "";

        $output .= "<!-- ARTIKEL START -->";
          $output = $output . "<section class=\"artikel\">";
            $output = $output . "<div class=\"container\">";

        // Række 1
           // Brødkrummesti
            $output = $output . "<div class=\"row\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
        //        $output = $output . "<p class=\"breadcrumbs\">" . theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())) . " / " . $title . "</p>";
              $output = $output . "</div>";
            $output = $output . "</div>";


        // Række 2
            $output = $output . "<div class=\"row second\">";
              $output = $output . "<div class=\"grid-two-thirds\">";
              $output = $output . "</div>";
              $output = $output . "<div class=\"grid-third sociale-medier social-desktop\"></div>";
            $output = $output . "</div>";

        // Række 3
            $output = $output . "<div class=\"row third\">";
              $output = $output . "<div class=\"grid-two-thirds\">";

                $output = $output . "<!-- ARTIKEL TOP START -->";
                $output = $output . "<div class=\"artikel-top\">";

                $output = $output . "</div>";
                $output = $output . "<!-- ARTIKEL TOP SLUT -->";


                // TEKSTINDHOLD
                $output = $output . "<!-- TEKSTINDHOLD START -->";
                $output = $output . render($page['content']);
                $output = $output . "<!-- TEKSTINDHOLD SLUT -->";


                $output = $output . "</div>";

              $output = $output . "<div class=\"grid-third\">";
                // INDHOLD TIL HØJRE KOLONNE
              $output = $output . "</div>";


            $output = $output . "</div>";
          $output = $output . "</div>";
        $output = $output . "</section>";
        $output = $output . "<!-- ARTIKEL SLUT -->";


        // BREAKING
        $output .= views_embed_view('kriseinformation','nodevisning', $node->nid);


        print $output;

?>


<!-- ***************************************************************************************** -->
       
       
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
      
      <!-- BREAKING START -->
      <?php //if ($is_admin and $logged_in): ?> 
        <?php if ($page['krisekommunikation']): ?>
          <div class="breaking"><?php //print render($page['krisekommunikation']); ?></div>
      	<?php endif; ?>
      <? //endif ?>         
      <!-- BREAKING SLUT -->
            
    </div>
    <!-- PAGE SLUT -->
    
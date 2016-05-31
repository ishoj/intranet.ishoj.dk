<!-- PAGE START -->
    <div data-role="page"> 
      
      <!-- CONTENT START -->
      <div data-role="content"> 
                
        <!-- ARTIKEL START -->
        <section class="artikel">
          <div class="container">
            <div class="row">
              <div class="grid-half">
                <h1>Login</h1>
              </div>
            </div>
            <div class="row">
              <div class="grid-half">
                <div class="bruger-login">
<?php

//    print drupal_render_children($form); 

    print drupal_render($form['name']);
    print drupal_render($form['pass']);
    print drupal_render($form['form_build_id']);
    print drupal_render($form['form_id']);

    print(l(t('Er det første gang du logger på? Er du ikke oprettet i citrix'), 'useractivation'));
    print drupal_render($form['actions']);
print '<a href="/user/password">Jeg har glemt mit kodeord!</a>';
?>
                </div>
              </div>
              <div class="grid-half">
              <?php

              if (module_exists('drupal_nemid_login_sg') && $login_methods = drupal_nemid_login_get_login_methods()) {
                $block = block_load('drupal_nemid_login', 'nemid_login');
                $output = _block_get_renderable_array(_block_render_blocks(array($block)));
                print drupal_render($output);
              } ?>
              </div>
            </div>
          </div>
        </section>
        <!-- ARTIKEL SLUT -->

      </div>
      <!-- CONTENT SLUT -->
      
    </div>
    <!-- PAGE SLUT -->


<?php

/* print the variables if needed to allow for 
  individual field theming or breaking them up. */
//  print '<pre>';
//  print_r($variables);
//  print '</pre>';


?>
<?php

// DRUPAL SNIPPETS: http://dropbucket.org/


/************************/
/*** PREPROCESS THEME ***/
/************************/
function ishoj_theme() {
  
  // Theming af user login, se http://dannyenglander.com/blog/customizing-user-login-page-drupal-7
  $items = array();
  // create custom user-login.tpl.php
  $items['user_login'] = array(
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'ishoj') . '/templates',
      'template' => 'user-login',
      'preprocess functions' => array(
      'ishoj_preprocess_user_login'
      ),
    );
  return $items;
}


/***********************/
/*** PREPROCESS HTML ***/
/***********************/
function ishoj_preprocess_html(&$vars) {

}


/***********************/
/*** PREPROCESS PAGE ***/
/***********************/
function ishoj_preprocess_page(&$variables) {
  
  // Fjerner "There is currently no content classified with this term."
  if(isset($variables['page']['content']['system_main']['no_content'])) {
    unset($variables['page']['content']['system_main']['no_content']);
  }
  
  // Fjerner node-indlæsningen fra teaxonomier
  // http://www.wardontheweb.com/remove-node-lists-from-taxonomy-pages-in-drupal-7/ 
  if(arg(0) == "taxonomy" and arg(1) == "term") {
      $variables['page']['content']['system_main']['nodes'] = null;
  }  
  
  // Hvis brugeren er logget på (webredaktør-rolle)
  if($variables['logged_in']) {
    // Indlæs editor.css
    drupal_add_css (path_to_theme() . '/css/editor.css', array('type' => 'file'));
    // Indlæs editor.js
    drupal_add_js(drupal_get_path('theme', 'ishoj') . '/js/editor.js');
  }
  
  ////////////////////
  // I N F O - T V  //
  ////////////////////
  $variables['path_to_theme'] = drupal_get_path('theme', 'ishoj') . '/';
  $path = drupal_get_path_alias(); 
  $urlPath = $path;

  // hvis path'en indeholder strengen 'infotv'
  if(strpos($urlPath, 'infotv') !== false) {
     $urlPath = 'infotv';
  } 
  // hvis path'en indeholder strengen 'udvikling' og ikke indeholder strengen 'udvikling'
//  if((strpos($urlPath, 'udvikling') !== false)) {
//     $urlPath = 'udvikling';
//  } 
  // hvis path'en indeholder strengen 'tvigrafik'
//  if(strpos($urlPath, 'tvigrafik') !== false) {
//     $urlPath = 'tvigrafik';
//  } 
  // hvis path'en indeholder strengen 'uglentopnyheder'
  if(strpos($urlPath, 'uglentopnyheder') !== false) { 
     $urlPath = 'uglentopnyheder';
  } 
  
  switch ($urlPath) {

//      case 'udvikling':
//      drupal_static_reset('drupal_add_css');
//      drupal_static_reset('drupal_add_js');
      
      // Tilføjer styelsheets
//      drupal_add_css($vars['path_to_theme'] . 'css/reset.css', array('group' => CSS_THEME, 'weight' => 100));
//      drupal_add_css($vars['path_to_theme'] . 'css/flexslider.css', array('group' => CSS_THEME, 'weight' => 100));
//      drupal_add_css($vars['path_to_theme'] . 'css/infotv.css', array('group' => CSS_THEME, 'weight' => 100));
      // Tilføjer javascripts
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery-1.10.2.min.js', array('weight' => 1000));
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery.flexslider-udv.js', array('weight' => 1000));
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery.easing.1.3.js', array('weight' => 1000));
//      drupal_add_js($vars['path_to_theme'] . 'js/udv-infotv.js', array('weight' => 1000));
//      break;	

    
    case 'infotv':
      drupal_static_reset('drupal_add_css');
      drupal_static_reset('drupal_add_js');
      
      // Tilføjer styelsheets
      drupal_add_css($variables['path_to_theme'] . 'css/infotv/infotv_reset.css', array('group' => CSS_THEME, 'weight' => 100));
      drupal_add_css($variables['path_to_theme'] . 'css/infotv/infotv_flexslider.css', array('group' => CSS_THEME, 'weight' => 100));
      drupal_add_css($variables['path_to_theme'] . 'css/infotv/infotv.css', array('group' => CSS_THEME, 'weight' => 100));
      // Tilføjer javascripts
      drupal_add_js($variables['path_to_theme'] . 'js/jquery-1.10.2.min.js', array('weight' => 1000));
      drupal_add_js($variables['path_to_theme'] . 'js/jquery.flexslider-udv.js', array('weight' => 1000));
      drupal_add_js($variables['path_to_theme'] . 'js/jquery.easing.1.3.js', array('weight' => 1000));
      drupal_add_js($variables['path_to_theme'] . 'js/infotv.js', array('weight' => 1000));
      break;	

    case 'uglentopnyheder':
      // Tilføjer styelsheets
      drupal_add_css($variables['path_to_theme'] . 'css/infotv/infotv_reset.css', array('group' => CSS_THEME, 'weight' => 100));
      drupal_add_css($variables['path_to_theme'] . 'css/infotv/infotv_flexslider.css', array('group' => CSS_THEME, 'weight' => 100));
      drupal_add_css($variables['path_to_theme'] . 'css/infotv/uglen_forsidenyt.css', array('group' => CSS_THEME, 'weight' => 100));
      // Tilføjer javascripts
      drupal_add_js($variables['path_to_theme'] . 'js/jquery.flexslider-min.js', array('weight' => 1000));
      drupal_add_js($variables['path_to_theme'] . 'js/uglen_forsidenyt.js', array('weight' => 1000));
      break;	
		
//    default:
//      // Tilføjer styelsheets  
//      drupal_add_css($vars['path_to_theme'] . 'css/reset.css', array('group' => CSS_THEME, 'weight' => 100));
//      drupal_add_css($vars['path_to_theme'] . 'css/default.css', array('group' => CSS_THEME, 'weight' => 101));
//      drupal_add_css($vars['path_to_theme'] . 'css/flexslider.css', array('group' => CSS_THEME, 'weight' => 102));
//      drupal_add_css($vars['path_to_theme'] . 'css/responsive.css', array('group' => CSS_THEME, 'weight' => 103));
//      // Tilføjer javascripts
//      drupal_add_js($vars['path_to_theme'] . 'js/modernizr.custom.60073.js', array('weight' => 100));
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery.easing.1.3.js', array('weight' => 101));
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery.hoverIntent.minified.js', array('weight' => 102));
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery.timer.js', array('weight' => 103));
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery.flexslider-min.js', array('weight' => 104));
//      drupal_add_js($vars['path_to_theme'] . 'js/jquery.cookie.js', array('weight' => 105));
//      drupal_add_js($vars['path_to_theme'] . 'js/pages.js', array('weight' => 106));
//      drupal_add_js($vars['path_to_theme'] . 'js/front.js', array('weight' => 107));
//      break;
  }
  
  
  
}



/***********************/
/*** PREPROCESS NODE ***/
/***********************/
function ishoj_preprocess_node(&$variables) {
  
  // Tilføjer scripts for bestemte indholdstyper (https://www.drupal.org/node/2291369)
  $node = &$variables['node'];
  if(($node->type == 'thomas_tester') or 
     ($node->type == 'os2web_base_contentpage') or 
     ($node->type == 'os2web_borger_dk_article')){
    drupal_add_js(path_to_theme() . '/js/google-maps.js', array(
      'group' => JS_THEME,
      'preprocess' => TRUE,
      'scope' => 'footer',
      'weight' => '999',
      )
    );
  }
  $js  = &$variables['js'];
  $css = &$variables['css'];
  if($node->type == 'os2web_borger_dk_article'){
  //    drupal_add_js(drupal_get_path('module', 'os2web_borger_dk') . '/js/os2web_borger_dk.js', 'file');
//    drupal_add_css(drupal_get_path('module', 'os2web_borger_dk') . '/css/os2web_borger_dk.css', 'file');
//    unset($js[drupal_get_path('module', 'os2web_borger_dk') . '/js/os2web_borger_dk.js']);

  }
  
}


/***********************/
/*** PREPROCESS VIEW ***/
/***********************/
function ishoj_preprocess_views_view(&$vars) {
  $view = &$vars['view'];

  // AKTIVITETER 
  if ($view->name == 'aktiviteter' && $view->current_display == 'aktivitet_kommende_aktiviteter') {
    // add needed javascript
//    drupal_add_js(drupal_get_path('theme', 'ishoj') . '/js/jquery.stellar.min.js', array('weight' => 1000));
    // add needed stylesheet
    // drupal_add_css(drupal_get_path('theme', 'your-theme') .'/your-css.css');
  }
}



/*************************/
/*** hook_form_alter() ***/
/*************************/
//https://api.drupal.org/api/drupal/modules%21system%21system.api.php/function/hook_form_alter/7
function ishoj_form_alter(&$form, &$form_state, $form_id) {
  if ($form['#id'] == 'user-login') {
    $form['name']['#description'] = t(''); // Clear the description of name
    $form['pass']['#description'] = t(''); // Clear the description of pass  
  }
  if($form['#id'] == "views-exposed-form-aktiviteter-aktivitet-kommende-aktiviteter"){
    $form['field_aktivitetstype_tid']['#options']['All'] = 'Vis alle';// overrides <All> on the dropdown
    $form['field_aktivitetssted_tid']['#options']['All'] = 'Vis alle';// overrides <All> on the dropdown
//    $form['submit']['#value'] = 'Søg';
//    $form['field_aktivitetsdato_value2[value][date]']['value']['#date_format'] = 'Y-m-d';
    
  }  
}

/************************/
/*** hook_css_alter() ***/
/************************/
function ishoj_css_alter(&$css) {
  unset($css[drupal_get_path('module', 'os2web_borger_dk') . '/css/os2web_borger_dk.css']);
}

/************************/
/*** hook_js_alter() ***/
/************************/
function ishoj_js_alter(&$javascript) {
  unset($javascript[drupal_get_path('module', 'os2web_borger_dk') . '/js/os2web_borger_dk.js']);
}


/*******************/
/*** BREADCRUMBS ***/
/*******************/
function ishoj_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  
  if (!empty($breadcrumb)) {
//	$breadcrumb[0] = '<a href="/" title="Gå til forsiden">' . t("Service") . '</a>';
	$breadcrumb[0] = '<a href="/" title="Gå til forsiden">Forside</a>';
    //array_shift($breadcrumb); // Removes the Home item
    
    $output = implode(' / ', $breadcrumb);
    return $output;
  }
}

/**************/
/*** PANELS ***/
/**************/
function ishoj_panels_default_style_render_region($variables) {
  // Fjerner <div class="panel-separator"></div> i outputtet
    $output = '';
    $output .= implode('', $variables['panes']);
    return $output;
}



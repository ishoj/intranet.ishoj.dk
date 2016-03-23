<?php
//if (empty($_GET['nologin'])) {
$ipadd = '';
if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ipadd=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ipadd=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ipadd=$_SERVER['REMOTE_ADDR'];
    }
$okloginbuf = 'test';
if ($okloginbuf == 'test') {  
if ($ipadd == '212.130.64.114') {
if(user_is_logged_in()){
} else {
if (empty($_GET['internref'])) {
    // no data passed by get
   // print $_SERVER["REQUEST_URI"];
    // /useractivation
    // /user/logout
    if ($_SERVER["REQUEST_URI"] != '/user' ) {
         if ($_SERVER["REQUEST_URI"] != '/user/logout' ) {
             if ($_SERVER["REQUEST_URI"] != '/user/password' ) {
                 if ($_SERVER["REQUEST_URI"] != '/useractivation' ) {
    $desurl = 'http://intranotesrv1/egnemoduler/code/uglenlogin.aspx?destination=' . $_SERVER["REQUEST_URI"];
    header('Location: ' . $desurl, true, 303);
die();
                      }
      }
     } 
    }
} else {
$usernamerem = str_replace('"','',str_replace("'","",$_GET['internref']));
if(!user_is_logged_in()){
if ($_GET['from'] == 'fraserver') {
if (!empty($usernamerem)) {
$query = new EntityFieldQuery();
$query->entityCondition('entity_type', 'user')
  ->fieldCondition('field_userdatatest', 'value', $usernamerem, '=');
$results = $query->execute();
if (!count($results) == 0 ) {
$uidrem = "";
foreach (array_keys($results['user']) as $value) {
$uidrem = $value;
}
$urldone = 'http://uglen.ishoj.dk' . str_replace("testlog=test","",$_GET['destination']);
$user_objrem = user_load($uidrem);
$form_state = array();
$form_state['uid'] = $user_objrem->uid;      
user_login_submit(array(), $form_state);   
header('Location: ' . $urldone, true, 303);
die();
  
}
  
}
    
   
}  
}
    
}

}
    
} 

} // if testlog
//}
/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */

?><!doctype html>
<html lang="da" class="no-js _no-svg"> 
  <head>
    <meta charset="utf-8">
    <?php print $head; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php print $head_title; ?></title>
<!--    <meta name="description" content="">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <?php print $styles; ?>

    <!-- HTML5 Shim for IE 6-8 -->
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->    
    
    <!-- Favicon -->
<!--    <link rel="shortcut icon" type="image/ico" href="">-->
    
    <!-- Apple Touch Icons -->
<!--
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144.png">
-->
    
    <!-- MS Homescreen Icons -->
<!--
    <meta name="msapplication-TileColor" content="#0088cc">
    <meta name="msapplication-TileImage" content="img/ms-touch-icon.png">
-->
    
    <?php print $scripts; ?>
  </head>

  <body class="<?php print $classes; ?>" <?php print $attributes;?>>
  
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>      
<?php 
if($logged_in) { 
print "<script type=\"text/javascript\">userloggedin = true;</script>";    
} else {
 if ($ipadd == '212.130.64.114') {
 print "<script type=\"text/javascript\">userloggedin = true;</script>";
 } else {
 print "<script type=\"text/javascript\">userloggedin = false;</script>";
 }

}
    
?>
    
    </body>
</html>
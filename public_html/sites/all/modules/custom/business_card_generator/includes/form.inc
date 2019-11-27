<?php

use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

/**
 * Form for generating business cards.
 * @param $form
 * @param $form_state
 *
 * @return mixed
 */
function business_card_generator_form($form, &$form_state) {
  $form['heading'] = array(
    '#type' => 'markup',
    '#markup' => t('<h1 style="margin-bottom: 10px;">Opret nyt visitkort</h1>'),
    '#prefix' => '<div class="container">',
  );

  $form['description'] = array(
    '#type' => 'item',
    '#title' => t('Generer dit personlige visitkort i PDF format.'),
  );

  $form['name'] = array(
    '#type' => 'textfield',
    '#title' => t('Fulde navn'),
    '#description' => t('Eks. "Kåre Svarre Jakobsen"'),
    '#required' => TRUE,
  );

  $form['job_position'] = array(
    '#type' => 'textfield',
    '#title' => t('Stilling'),
    '#description' => t('Eks. "Kommunaldirektør/CEO"'),
    '#required' => TRUE,
  );

  $form['department'] = array(
    '#type' => 'textfield',
    '#title' => t('Afdeling'),
    '#description' => t('Eks. "Direktion"'),
    '#required' => TRUE,
  );

  $form['email'] = array(
    '#type' => 'textfield',
    '#title' => t('E-mail adresse'),
    '#description' => t('Eks. "ditnavn@ishoj.dk"'),
    '#required' => TRUE,
  );

  $form['phone'] = array(
    '#type' => 'textfield',
    '#title' => t('Telefon nr.'),
    '#description' => t('Eks. "+45 12 34 56 78" eller "+45 12 34 56 78 / +45 21 43 65 87"'),
    '#required' => TRUE,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Opret visitkort'),
    '#suffix' => '</div>',
  );

  return $form;
}


/**
 * Validation function for business_card_generator_form().
 */
function business_card_generator_form_validate($form, &$form_state) {}

/**
 * Submit function for business_card_generator_form().
 */
function business_card_generator_form_submit($form, &$form_state) {
  $path = DRUPAL_ROOT . '/' . drupal_get_path('module', 'business_card_generator');

  // Fonts.
  $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
  $fontDirs = $defaultConfig['fontDir'];

  $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
  $fontData = $defaultFontConfig['fontdata'];

  $mpdf = new Mpdf([
    'fontDir' => array_merge($fontDirs, [
      $path . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'franklin_gothic_demi' => [
          'R' => 'franklin-gothic-demi.ttf',
        ],
        'franklin_gothic_demi_condensed' => [
          'R' => 'franklin-gothic-demi-condensed.ttf',
        ],
        'franklin_gothic_medium_condensed' => [
          'R' => 'franklin-gothic-medium-condensed.ttf',
        ]
      ],
    'default_font' => 'franklin_gothic_medium_condensed'
  ]);

  // Options.
//  $mpdf->setAutoTopMargin = 1;

  // Add CSS.
  $mpdf->WriteHTML('<style>@page {
    margin: 0;
    margin-top: 1cm;
    }</style>');
  $stylesheet = $path . '/css/mpdf.css';
  if (file_exists($stylesheet)) {
    $mpdf->WriteHTML(file_get_contents($stylesheet), HTMLParserMode::HEADER_CSS);
  }

  // Add content.
  $content = '<div class="wrapper">';

  for ($number = 1; $number <= 10; $number++) {
    $content .= '<div class="column">';
    $content .= '  <div class="business-card" style="background-image: url(' . $path . '/images/background.svg);">';
    $content .= '    <div class="business-card__inner" style="background-image: url(' . $path . '/images/watermark.svg);">';

    // Company information.
    $content .= '      <div class="company-information">';
    $content .= '        <div class="company-information__name">Ishøj Kommune</div>';
    $content .= '      </div>';

    // Personal information.
    $content .= '      <div class="personal-information">';
    $content .= '        <div class="personal-information__name">' . $form_state['values']['name'] . '</div>';
    $content .= '        <div class="personal-information__job-position">' . $form_state['values']['job_position'] . '</div>';
    $content .= '        <div class="personal-information__department">' . $form_state['values']['department'] . '</div>';
    $content .= '      </div>';

    // Contact information.
    $content .= '      <div class="contact-information">';
    $content .= '        <div class="contact-information__email">' . $form_state['values']['email'] . '</div>';
    $content .= '        <div class="contact-information__phone">' . $form_state['values']['phone'] . '</div>';
    $content .= '      </div>';

    $content .= '    </div>';
    $content .= '  </div>';
    $content .= '</div>';
  }

  $content .= '</div>';

  $mpdf->WriteHTML($content);

  // Sent PDF to the browser.
  $mpdf->Output();
  die();
}

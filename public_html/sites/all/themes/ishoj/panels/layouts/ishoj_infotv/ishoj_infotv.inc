<?php

// Plugin definition
$plugin = array(
  'title' => t('Info-tv'),
  'category' => t('Ishøj Kommune'),
  'icon' => 'ishoj_infotv.png',
  'theme' => 'ishoj_infotv',
  'css' => 'ishoj_infotv.css',
  'regions' => array(
	'content' => t('INDHOLD'),
	'overlay_top' => t('OVERLAY (uden tjek af indhold)'),
	'overlay_bottom' => t('OVERLAY (med tjek af indhold)')
  ),
);

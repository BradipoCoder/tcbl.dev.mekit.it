<?php
/**
 * @file
 * smile_settings.features.menu_custom.inc
 */

/**
 * Implements hook_menu_default_menu_custom().
 */
function smile_settings_menu_default_menu_custom() {
  $menus = array();

  // Exported menu: menu-amministrazione.
  $menus['menu-amministrazione'] = array(
    'menu_name' => 'menu-amministrazione',
    'title' => 'Amministrazione',
    'description' => 'Elenco dei link utilizzati nell\'amministrazione',
  );
  // Exported menu: menu-social.
  $menus['menu-social'] = array(
    'menu_name' => 'menu-social',
    'title' => 'Social',
    'description' => 'Elenco dei social linkati nel footer.',
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Amministrazione');
  t('Elenco dei social linkati nel footer.');
  t('Social');


  return $menus;
}

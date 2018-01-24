<?php
/**
 * @file
 * smile_settings.features.menu_links.inc
 */

/**
 * Implements hook_menu_default_menu_links().
 */
function smile_settings_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: menu-amministrazione_aggiungi-contenuto:node/add
  $menu_links['menu-amministrazione_aggiungi-contenuto:node/add'] = array(
    'menu_name' => 'menu-amministrazione',
    'link_path' => 'node/add',
    'router_path' => 'node/add',
    'link_title' => 'Aggiungi contenuto',
    'options' => array(
      'attributes' => array(
        'title' => 'Aggiungi contenuto',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'plus-circle',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'menu-amministrazione_aggiungi-contenuto:node/add',
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => 1,
    'customized' => 1,
  );
  // Exported menu link: menu-amministrazione_amministra-contenuti:admin/content
  $menu_links['menu-amministrazione_amministra-contenuti:admin/content'] = array(
    'menu_name' => 'menu-amministrazione',
    'link_path' => 'admin/content',
    'router_path' => 'admin/content',
    'link_title' => 'Amministra contenuti',
    'options' => array(
      'attributes' => array(
        'title' => 'Amministra contenuti',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'list-ul',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'menu-amministrazione_amministra-contenuti:admin/content',
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => 0,
    'customized' => 1,
  );
  // Exported menu link: menu-social_behance:http://www.behance.net/
  $menu_links['menu-social_behance:http://www.behance.net/'] = array(
    'menu_name' => 'menu-social',
    'link_path' => 'http://www.behance.net/',
    'router_path' => '',
    'link_title' => 'Behance',
    'options' => array(
      'attributes' => array(
        'title' => 'Behance',
      ),
      'identifier' => 'menu-social_behance:http://www.behance.net/',
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'behance-square',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 1,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -45,
    'customized' => 1,
  );
  // Exported menu link: menu-social_facebook:http://www.facebook.com
  $menu_links['menu-social_facebook:http://www.facebook.com'] = array(
    'menu_name' => 'menu-social',
    'link_path' => 'http://www.facebook.com',
    'router_path' => '',
    'link_title' => 'Facebook',
    'options' => array(
      'attributes' => array(
        'title' => 'Facebook',
      ),
      'identifier' => 'menu-social_facebook:http://www.facebook.com',
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'facebook-square',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 1,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -50,
    'customized' => 1,
  );
  // Exported menu link: menu-social_google:https://plus.google.com
  $menu_links['menu-social_google:https://plus.google.com'] = array(
    'menu_name' => 'menu-social',
    'link_path' => 'https://plus.google.com',
    'router_path' => '',
    'link_title' => 'Google+',
    'options' => array(
      'attributes' => array(
        'title' => 'Google+',
      ),
      'identifier' => 'menu-social_google:https://plus.google.com',
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'google-plus-square',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 1,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -47,
    'customized' => 1,
  );
  // Exported menu link: menu-social_twitter:https://twitter.com/
  $menu_links['menu-social_twitter:https://twitter.com/'] = array(
    'menu_name' => 'menu-social',
    'link_path' => 'https://twitter.com/',
    'router_path' => '',
    'link_title' => 'Twitter',
    'options' => array(
      'attributes' => array(
        'title' => 'Twitter',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'twitter',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'menu-social_twitter:https://twitter.com/',
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 1,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -46,
    'customized' => 1,
  );
  // Exported menu link: menu-social_vimeo:http://vimeo.com
  $menu_links['menu-social_vimeo:http://vimeo.com'] = array(
    'menu_name' => 'menu-social',
    'link_path' => 'http://vimeo.com',
    'router_path' => '',
    'link_title' => 'Vimeo',
    'options' => array(
      'attributes' => array(
        'title' => 'Vimeo',
      ),
      'identifier' => 'menu-social_vimeo:http://vimeo.com',
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'vimeo-square',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 1,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -48,
    'customized' => 1,
  );
  // Exported menu link: menu-social_youtube:https://www.youtube.com/
  $menu_links['menu-social_youtube:https://www.youtube.com/'] = array(
    'menu_name' => 'menu-social',
    'link_path' => 'https://www.youtube.com/',
    'router_path' => '',
    'link_title' => 'YouTube',
    'options' => array(
      'attributes' => array(
        'title' => 'YouTube',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'youtube-play',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'menu-social_youtube:https://www.youtube.com/',
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 1,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -49,
    'customized' => 1,
  );
  // Translatables
  // Included for use with string extractors like potx.
  t('Aggiungi contenuto');
  t('Amministra contenuti');
  t('Behance');
  t('Facebook');
  t('Google+');
  t('Twitter');
  t('Vimeo');
  t('YouTube');


  return $menu_links;
}

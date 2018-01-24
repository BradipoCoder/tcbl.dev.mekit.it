<?php

/**
 * @file
 * template.php
 */

define('JS_BOOTSTRAP_MATERIAL', 200);
 
/**
 * Preprocess html.tpl.php.
 *
 * @see bootstrap_material_js_alter()
 */
function bootstrap_material_preprocess_html(&$vars) {
  // Add class to help us style admin pages.
  if (path_is_admin(current_path())) {
    $vars['classes_array'][] = 'admin';
  }
  // Prepare to initialize.
  drupal_add_js('(function ($){ $.material.init(); })(jQuery);', array(
    'type' => 'inline', 
    'group' => JS_BOOTSTRAP_MATERIAL, 
    'scope' => 'footer', 
    'weight' => 2
  ));
  $filepath = path_to_theme() . '/font-awesome/css/font-awesome.min.css';
  drupal_add_css($filepath, array(
    'group' => CSS_THEME,
  ));
}
/*
function bootstrap_material_preprocess_page(&$vars) {
  $service_links = service_links_render($vars['node']);
  foreach( $service_links as $service_link => $url){
      $vars['service_links'] .= '<li>'. $url .'</li>';
  }
}
*/


/**
 * Implements hook_js_alter().
 *
 * Make sure the library files provided by MDB load last, then initialize.
 *
 * @see bootstrap_material_preprocess_html()
 */
function bootstrap_material_js_alter(&$js) { 
  
  $file = path_to_theme() . '/js/bootstrap_material.js';
  
  $js[$file] = drupal_js_defaults($file);
  $js[$file]['group'] = JS_BOOTSTRAP_MATERIAL;
  $js[$file]['scope'] = 'footer';
  $js[$file]['weight'] = $weight = 0;
  
  // Ensure we initialize only after files are loaded.
  foreach ($js as $key => $val) {
    if (is_int($key) && $val['group'] == JS_BOOTSTRAP_MATERIAL) {
      $weight++;
      $js[$key]['weight'] = $weight;
    }
  }
}

/**
 * Overrides theme_menu_local_tasks().
 *
 * Overrides Bootstrap module's override. Let's not turn the secondary menu 
 * into a pagination element.
 *
 * @see bootstrap_menu_local_tasks()
 */
function bootstrap_material_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs--primary nav nav-tabs">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }

  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs--secondary">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

/**
 * Overrides theme_menu_local_action().
 *
 * Overrides Bootstrap module's override. All we're doing is making the action
 * link buttons bigger by removing the 'btn-xs' class.
 *
 * @see bootstrap_menu_local_action()
 */
function bootstrap_material_menu_local_action($variables) {
  $link = $variables['element']['#link'];

  $options = isset($link['localized_options']) ? $link['localized_options'] : array();

  // If the title is not HTML, sanitize it.
  if (empty($options['html'])) {
    $link['title'] = check_plain($link['title']);
  }

  $icon = _bootstrap_iconize_text($link['title']);

  // Format the action link.
  $output = '';
  if (isset($link['href'])) {
    // Turn link into a mini-button and colorize based on title.
    if ($class = _bootstrap_colorize_text($link['title'])) {
      if (!isset($options['attributes']['class'])) {
        $options['attributes']['class'] = array();
      }
      $string = is_string($options['attributes']['class']);
      if ($string) {
        $options['attributes']['class'] = explode(' ', $options['attributes']['class']);
      }
      $options['attributes']['class'][] = 'btn';
      $options['attributes']['class'][] = 'btn-' . $class;
      if ($string) {
        $options['attributes']['class'] = implode(' ', $options['attributes']['class']);
      }
    }
    // Force HTML so we can render any icon that may have been added.
    $options['html'] = !empty($options['html']) || !empty($icon) ? TRUE : FALSE;
    $output .= l($icon . $link['title'], $link['href'], $options);
  }
  else {
    $output .= $icon . $link['title'];
  }

  return $output;
}


/**
 * @file
 * Theme function used by Service Links.
 */

/**
 * Build a single link following the style rules.
 */

function bootstrap_material_service_links_build_link($variables) {
  $text = $variables['text'];
  $url = $variables['url'];
  $image = $variables['image'];
  $nodelink = $variables['nodelink'];
  $style = $variables['style'];
  $attributes = $variables['attributes'];
  $socialService = str_replace('service-links-', '', $attributes['class'][0]);
  $attributes['class'][] = "btn btn-info btn-xs btn-block"; 

  if ($nodelink) {
    $query = isset($url[1]) ? $url[1] : NULL;
    $link = array(
      'title' => theme('html_tag', array(
        'element' => array(
          '#tag' => 'span',
          '#attributes' => array(
            //'class' => 'fa fa-fw fa-2x fa-'.$socialService,
            'class' => 'fa fa-fw fa-'.$socialService,
          ),
          '#value' => '',
        ),
      )) . ' ' . $text,
      'href' => $url[0],
      'query' => $query,
      'attributes' => $attributes,
      'html' => TRUE,
    );
  }
  else {
    $attributes = array('attributes' => $attributes);
    if (isset($url[1])) {
      $attributes['query'] = $url[1];
    }
    $attributes['html'] = TRUE;
    $link = l(
      theme('html_tag', array(
        'element' => array(
          '#tag' => 'span',
          '#attributes' => array(
            //'class' => 'fa fa-fw fa-2x fa-'.$socialService,
            'class' => 'fa fa-fw fa-'.$socialService,
          ),
          '#value' => '',
        ),
      )) . ' ' . $text,
      $url[0],
      $attributes
    );
  }

  return $link;
}

/*added by kpf to expand all menus*/


function bootstrap_material_theme_preprocess_page(&$vars) {
    // To display sublinks.
    $main_menu_tree = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    $vars['main_menu'] =  $main_menu_tree;
  }

function  bootstrap_material_menu_tree__main_menu(&$vars) {
  // To add CSS class to the main menu ul
  return '<ul class="nav navbar-nav">' . $vars['tree'] . '</ul>';
}

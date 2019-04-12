<?php

/**
 * @file
 * company.php
 * test
 */

// ** COMPANY STUFF **
// -------------------

function _tcbl_preprocess_node_company(&$vars){
  if ($vars['view_mode'] == 'full'){
    
    // Add javascript
    $js = drupal_get_path('theme', 'tcbl') . '/js/company.js';
    drupal_add_js( $js , array('group' => JS_LIBRARY, 'weight' => 1));

    // * Company header *
    // ------------------
    _tcbl_company_format_contacts($vars);
    _tcbl_company_format_social($vars);
    _tcbl_company_format_networks($vars);
    _tcbl_company_add_map($vars);

    // * Company content *
    // -------------------
    // About
    _tcbl_company_add_tabs($vars);
    _tcbl_company_add_slider($vars);

    // Details
    _tcbl_company_add_customers($vars);
    _tcbl_company_add_approach_gf($vars);

    // Staff
    _tcbl_company_add_workers_icons($vars);
    _tcbl_company_add_population_gf($vars);
  }
}

function _tcbl_company_format_contacts(&$vars){
  $node = $vars['node'];

  $list = array(
    'plainAddress' => array(
      'value' => false,
      'icon' => 'map-marker',
    ),
    'email' => array(
      'value' => false,
      'icon' => 'envelope',
    ),
    'phone' => array(
      'value' => false,
      'icon' => 'phone',
    ),
    'website' => array(
      'value' => false,
      'icon' => 'desktop',
    ),
  );

  $vars['plain_address'] = false;

  // Field location
  if (isset($node->field_location['und'][0])){
    $field = $node->field_location['und'][0];

    $loop = array(
      'street',
      'city',
      'province_name',
      'postal_code',
      'country_name',
    );

    $plainAddress = false;
    foreach ($loop as $key) {
      if (isset($field[$key]) && $field[$key] !== ''){
        if ($plainAddress){
          $plainAddress .= ', ';
        }
        $plainAddress .= $field[$key];  
      }
    }
    $vars['plain_address'] = $plainAddress;

    if ($plainAddress){
      $list['plainAddress']['value'] = $plainAddress;
    }

    if (isset($field['email']) && $field['email'] !== ''){
      $list['email']['value'] = $field['email'];
    }

    if (isset($field['phone']) && $field['phone'] !== ''){
      $list['phone']['value'] = $field['phone'];
    }
  }

  // Website
  if (isset($node->field_url['und'][0]['url']) && $node->field_url['und'][0]['url'] !== ''){
    $list['website']['value'] = $node->field_url['und'][0]['url'];
  }

  $build = array();
  foreach ($list as $k => $item) {
    if ($item['value']){

      $value = '<i class="fa fa-fw fa-' . $item['icon'] . '"></i>' . $item['value'];

      $build[$k] = array(
        '#prefix' => '<li>',
        '#markup' => $value,
        '#suffix' => '</li>',
      );

      if ($k == 'website'){
        $build[$k]['#markup'] = '<a href="' . $item['value'] . '" target="_blank">' . $value . '</a>';  
      }

    }
  }

  if (count($build)){
    $build['#prefix'] = '<ul class="company-contacts">';
    $build['#suffix'] = '</ul>';
    $vars['content']['contacts'] = $build;
  }
}

function _tcbl_company_format_social(&$vars){
  $node = $vars['node'];

  $list = array(
    'linkedin' => array(
      'icon' => 'linkedin',
    ),
    'fb' => array(
      'icon' => 'facebook',
    ),
    'twitter' => array(
      'icon' => 'twitter',
    ),
    'instagram' => array(
      'icon' => 'instagram',
    ),
    'youtube' => array(
      'icon' => 'youtube-play',
    ),
  );

  $build = array();

  $opt = array(
    'html' => true,
    'attributes' => array(
      'target' => '_blank',
    ),
  );

  foreach ($list as $key => $item) {
    $field_name = 'field_link_' . $key;
    if (isset($node->$field_name['und'][0]['url']) && $node->$field_name['und'][0]['url'] !== ''){
      $icon = '<span class="company-social-icon company-social-icon__' . $key . '"><i class="fa fa-fw fa-' . $list[$key]['icon'] . '"></i></span>';
      $url = $node->$field_name['und'][0]['url'];
      $build[$key] = array(
        '#prefix' => '<li>',
        '#suffix' => '</li>',
        '#markup' => l($icon, $url, $opt),
      );
    }
  }

  if (count($build)){
    $build['#prefix'] = '<ul class="company-social">';
    $build['#suffix'] = '</ul>';
    $vars['content']['social'] = $build;  
  }
}

function _tcbl_company_format_networks(&$vars){
  $node = $vars['node'];

  $list = array(
    'sqetch' => array(
      'name' => 'Sqetch',
    ),
    'sourcebook' => array(
      'name' => 'Sourcebook',
    ),
    'cf' => array(
      'name' => 'Circular Fashion',
    ),
  );

  $opt = array(
    'html' => true,
    'attributes' => array(
      'target' => '_blank',
    ),
  );

  $build = array();
  global $base_url;
  global $theme_path;
  $base_path = $base_url . '/' . $theme_path . '/img/partners/';

  foreach ($list as $key => $item) {
    $field_name = 'field_link_' . $key;
    if (isset($node->$field_name['und'][0]['url']) && $node->$field_name['und'][0]['url'] !== ''){
      $url = $node->$field_name['und'][0]['url'];

      $img = '<img src="' . $base_path . $key . '.jpg"/>';
      $text = 'View on ' . $item['name'];

      // @todo image
      $build[$key] = array(
        '#prefix' => '<li>',
        '#suffix' => '</li>',
        '#markup' => l($img . $text, $url, $opt),
      );
    }
  }

  $vars['has_networks'] = false;
  if (count($build)){
    $vars['has_networks'] = true;
    $build['#prefix'] = '<ul class="company-networks">';
    $build['#suffix'] = '</ul>';
    $vars['content']['networks'] = $build;
  }
}

function _tcbl_company_add_map(&$vars){

  $node = $vars['node'];

  // Coordinate
  $coord = false;
  if (
    isset($node->field_geolocation['und'][0]['first']) && $node->field_geolocation['und'][0]['first'] &&
    isset($node->field_geolocation['und'][0]['second']) && $node->field_geolocation['und'][0]['second']
  ){
    $geo['latitude'] = $node->field_geolocation['und'][0]['first'];
    $geo['longitude'] = $node->field_geolocation['und'][0]['second'];
    $coord = array($geo['latitude'], $geo['longitude']);  
  }

  // Indirizzo
  $address = false;
  if (isset($node->field_location['und'][0])){
    $address = $node->field_location['und'][0];
  }

  $vars['content']['map'] = array(
    '#theme' => 'tcbl_map',
    '#data' => array(
      'mid' => 'company-map',
      'coord' => $coord,
      'address' => $address,
      'plain_address' => $vars['plain_address'],
      'title' => $node->title,
      'nid' => $node->nid,
    ),
  );
}

// ** CONTENTS **
// --------------
// 
// ** About **
// -----------

function _tcbl_company_add_tabs(&$vars){
  
  $list = array(
    'about' => array(
      'title' => 'About',
    ),
    'details' => array(
      'title' => 'Details',
    ),
    'staff' => array(
      'title' => 'Staff',
    ),
  );

  $n = 0;
  foreach ($list as $k => $item) {
    $items[$k]['title'] = $item['title'];
    $items[$k]['class'] = false;
    if ($n == 0){
      $items[$k]['class'] = 'open';
    }
    $items[$k]['n'] = $n;
    $n++;
  }

  $vars['content']['tabs'] = array(
    '#theme' => 'companytabs',
    '#items' => $items,
  );
}

function _tcbl_company_add_slider(&$vars){
  $node = $vars['node'];
  if (isset($node->field_images['und'][0]['uri'])){
    $imgs = $node->field_images['und'];
    
    foreach ($imgs as $key => $item) {

      $opt = array(
        'attributes' => array(
          'class' => array(
            'colorbox',
          ),
          'rel' => 'company',
        ),
        'html' => true,
      );

      $img_url = file_create_url($item['uri']);

      $img = array(
        '#theme' => 'image_style',
        '#style_name' => 'sameh',
        '#path' => $item['uri'],
      );

      $slides[$key]['#markup'] = l(render($img), $img_url, $opt);

      $lsid = 'company-slider';
      $options = _tcbl_company_get_slider_options();
      $vars['content']['field_images'] = _lightslider_create_slider($slides, $lsid, $options);
    }
  }
}

function _tcbl_company_get_slider_options(){
  $options = array(
    'item' =>  2,
    'mode' => 'slide',
    'loop' => false,
    'slideMargin' => 10,
    'slideMove' => 1,
    'slideEndAnimation' => false,
    'auto' => true,
    'autoWidth' => true,
    'speed' => 2000,
    'pause' => 10000,
    'prevHtml' => '<i class="fa fa-lg fa-angle-left"></i>',
    'nextHtml' => '<i class="fa fa-lg fa-angle-right"></i>',
    'controls' => false,
    'pager' => true,
    // 'responsive' => array(
    //   array(
    //     'slideMargin' => 20,
    //     'breakpoint' => 1192,
    //     'settings' => array(
    //       'item' => 6,
    //       'slideMove' => 6,
    //     ),
    //   ),
    //   array(
    //     'breakpoint' => 768,
    //     'settings' => array(
    //       'slideMargin' => 10,
    //       'item' => 3,
    //       'slideMove' => 3,
    //     ),
    //   ),
    // ),
  );
  return $options;
}

// ** Details **
// -------------

function _tcbl_company_add_customers(&$vars){
  $node = $vars['node'];

  $vars['content']['customers'] = false;
  if (isset($node->field_ref_customers['und'][0]['tid'])){
    $build['#prefix'] = '<ul class="company-customers">';
    $build['#suffix'] = '</ul>';
    $list = $node->field_ref_customers['und'];
    foreach ($list as $key => $item) {
      $tid = $item['tid'];
      $term = taxonomy_term_load($tid);
      $build[$key]['#markup'] = '<li>' . $term->name . '</li>';
    }
    $vars['content']['customers'] = $build;
  }
}

function _tcbl_company_add_approach_gf(&$vars){
  $node = $vars['node'];

  $list = array(
    'design' => array(
      'label' => 'Design',
      'color' => 'rgba(179, 214, 236, 0.72)',
    ),
    'make' => array(
      'label' => 'Make',
      'color' => 'rgba(255, 99, 132, 0.52)',
    ),
    'place' => array(
      'label' => 'Place',
      'color' => 'rgba(255, 205, 86, 0.53)',
    ),
  );

  $data = array();
  foreach ($list as $key => $item) {
    $field_name = 'field_app_' . $key;
    if (isset($node->$field_name['und'][0]['value']) && $node->$field_name['und'][0]['value'] !== 0){
      $data['labels'][] = $item['label'];
      $data['data'][] = $node->$field_name['und'][0]['value'];
      $data['colors'][] = $item['color'];
    }
  }

  if (count($data) == 0){
    return false;
  }

  $vars['content']['approach'] = array(
    '#theme' => 'chart',
    '#data' => $data,
    '#cid' => 'approach',
    '#type' => 'polarArea',
  );

}

// ** Staff **
// -----------

function _tcbl_company_add_workers_icons(&$vars){
  $node = $vars['node'];

  if (isset($node->field_n_women['und'][0]['value']) && $node->field_n_women['und'][0]['value']){
    $women_n = $node->field_n_women['und'][0]['value'];
    $icons = array();
    for ($i = 0; $i < $women_n ; $i++) { 
      $icons[$i]['#markup'] = '<span class="worker worker__women"></span>';
    }
    $vars['content']['staff']['women'] = array(
      '#prefix' => '<p class="xs">Women</p><div class="workers">',
      '#suffix' => '</div>',
      'icons' => $icons,
    );
  }

  if (isset($node->field_n_men['und'][0]['value']) && $node->field_n_men['und'][0]['value']){
    $men_n = $node->field_n_men['und'][0]['value'];
    $icons = array();
    for ($i = 0; $i < $men_n ; $i++) { 
      $icons[$i]['#markup'] = '<span class="worker worker__men"></span>';
    }
    $vars['content']['staff']['man'] = array(
      '#prefix' => '<p class="xs">Men</p><div class="workers">',
      '#suffix' => '</div>',
      'icons' => $icons,
    );
  }
}

function _tcbl_company_add_population_gf(&$vars){
  $node = $vars['node'];

  $list = array(
    'students' => array(
      'label' => 'Students',
      'color' => '#ff6384',
    ),
    'researchers' => array(
      'label' => 'Researchers',
      'color' => '#ff9f40',
    ),
    'staff' => array(
      'label' => 'Staff',
      'color' => '#ffcd56',
    ),
    'consultants' => array(
      'label' => 'Consultants',
      'color' => '#4bc0c0',
    ),
    'technicians' => array(
      'label' => 'Technicians',
      'color' => '#36a2eb',
    ),
    'teachers' => array(
      'label' => 'Teachers',
      'color' => '#9966ff',
    ),
    'citizens' => array(
      'label' => 'Citizens',
      'color' => '#c9cbcf',
    ),
  );

  $data = array();
  foreach ($list as $key => $item) {
    $field_name = 'field_pop_' . $key;
    if (isset($node->$field_name['und'][0]['value']) && $node->$field_name['und'][0]['value'] !== 0){
      $data['labels'][] = $item['label'];
      $data['data'][] = $node->$field_name['und'][0]['value'];
      $data['colors'][] = $item['color'];
    }
  }

  if (count($data) == 0){
    return false;
  }

  $vars['content']['population'] = array(
    '#theme' => 'chart',
    '#data' => $data,
    '#cid' => 'population',
    '#type' => 'doughnut',
  );

}





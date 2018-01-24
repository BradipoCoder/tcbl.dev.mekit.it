<?php

/**
 * @file
 * member.php
 */

function _tcbl_preprocess_node_member(&$vars){
  $node = $vars['node'];

  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-sm-3';
    $vars['classes_array'][] = 'col-xs-6';
  }

  if ($vars['view_mode'] == 'full'){
    _tcbl_member_card($vars);
    $title = array(
      '#markup' => '<h2 class="text-center">Contatta ' . $node->title . '</h2>',
    );
    _tcbl_add_bottom_form($vars, $title);
    _tcbl_add_member_slider($vars);
  }
}

function _tcbl_add_member_slider(&$vars){
  $members = get_children_by_pnid(4);
  $members = node_load_multiple($members);

  foreach ($members as $k => $member) {
    $slides[$k] = node_view($member, 'teaser');
  }
  //$vars['content']['members'] = array(
  //  '#prefix' => '<h5 class="text-center margin-t-2">I nostri member convenzionati</h5><hr>',
  //);

  $options = array(
    'item' =>  4,
    'mode' => 'slide',
    //'loop' => true,
    'slideMargin' => 5,
    'slideMove' => 4,
    'slideEndAnimation' => false,
    'auto' => true,
    'speed' => 2000,
    'pause' => 10000,
    'prevHtml' => '<i class="fa fa-lg fa-angle-left"></i>',
    'nextHtml' => '<i class="fa fa-lg fa-angle-right"></i>',
    'responsive' => array(
      array(
        'breakpoint' => 1192,
        'settings' => array(
          'item' => 3,
          'slideMove' => 3,
        ),
      ),
      array(
        'breakpoint' => 768,
        'settings' => array(
          'item' => 1,
          'slideMove' => 1,
          'pager' => false,
        ),
      ),
    ),
  );

  $vars['content']['members']['slider'] = _lightslider_create_slider($slides, 'member', $options);
  $vars['content']['members']['#weight'] = 10;
}

/**
 * Card usata come header nel contenuto completo
 * @param  [type] &$vars [description]
 * @return [type]        [description]
 */
function _tcbl_member_card(&$vars){
  $node = $vars['node'];

  $logo = field_view_field('node', $node, 'field_img', 'default');
  $street = field_view_field('node', $node, 'field_street', 'default');

  $f_cap = field_view_field('node', $node, 'field_cap', 'default');
  $cap = '';
  if (isset($f_cap[0]['#markup'])){
    $cap = $f_cap[0]['#markup'];
  }

  $f_city = field_view_field('node', $node, 'field_address', 'default');
  $city = '';
  if (isset($f_city[0]['#markup'])){
    $city = $f_city[0]['#markup'];
  }

  $f_phone = field_view_field('node', $node, 'field_phone', 'default');
  $phone = '';
  if (isset($f_phone[0]['#markup'])){
    $phone = $f_phone[0]['#markup'];
  }

  $f_email = field_view_field('node', $node, 'field_email', 'default');
  $email = '';
  if (isset($f_email[0]['#markup'])){
    $email = $f_email[0]['#markup'];
  }

  $f_website = field_view_field('node', $node, 'field_website', 'default');
  $website = '';
  if (isset($f_website[0]['#markup'])){
    $website = $f_website[0]['#markup'];
  }

  $address = array(
    'street' => array(
      'data' => $street,
      '#weight' => 1,
    ),
    'city' => array(
      '#prefix' => $cap . ' – ',
      '#markup' => '<span class="text-bold">' . $city . '</span>',
      '#weight' => 2,
    ),
  );

  if (isset($node->field_company['und'][0]['value'])){
    $address['company'] = array(
      '#markup' => '<strong>' . $node->field_company['und'][0]['safe_value'] . '</strong>',
      '#weight' => 0,
    );
  }

  $tel = array(
    '#markup' => 'Tel. ' . $phone . '<br/>' . $email,
  );

  $opt = array(
    'absolute' => TRUE,
    'external' => TRUE,
    'attributes' => array(
      'target' => '_blank',
    ),
    'html' => TRUE,
  );
  $icon = '<i class="fa fa-external-link"></i> ';
  $website = array(
    '#markup' => l($icon . $website, 'http://' . $website, $opt),
  );

  $vars['content']['card'] = array(
    '#prefix' => '<div class="row"><div class="container">',
    '#suffix' => '</div></div>',
    'content' => array(
      '#prefix' => '<hr><div class="row">',
      '#suffix' => '</div><hr class="margin-b-2">',
      'logo' => array(
        '#prefix' => '<div class="col-md-3 col-sm-6">',
        '#suffix' => '</div>',
        'data' => $logo,
      ),
      'description' => array(
        '#prefix' => '<div class="col-md-9 col-sm-6"><div class="row">',
        '#suffix' => '</div></div>',
        'address' => array(
          '#prefix' => '<div class="col-md-4 margin-v-1">',
          '#suffix' => '</div>',
          'data' => $address,
        ),
        'tel' => array(
          '#prefix' => '<div class="col-md-4 margin-v-1">',
          '#suffix' => '</div>',
          'data' => $tel,
        ),
        'website' => array(
          '#prefix' => '<div class="col-md-4 margin-v-1 text-blue">',
          '#suffix' => '</div>',
          'data' => $website,
        ),
      ),

    ),
    '#weight' => -1,
  );

  hide($vars['content']['field_img']);
  hide($vars['content']['field_company']);
  hide($vars['content']['field_street']);
  hide($vars['content']['field_cap']);
  hide($vars['content']['field_address']);
  hide($vars['content']['field_phone']);
  hide($vars['content']['field_website']);
  hide($vars['content']['field_email']);
}
<?php

/**
 * @file
 * content-types.php
 */

// ** PREPROCESS NODE **
// ---------------------

/**
 * Implements hook_preprocess_node()
 */
function tcbl_preprocess_node(&$vars){
  if ($vars['view_mode'] == 'full'){
    _tcbl_alter_pagination($vars);
  }

  $node = $vars['node'];
  switch ($node->type) {
    case 'page':
      _tcbl_preprocess_node_page($vars);
      break;

    case 'event':
      _tcbl_preprocess_node_event($vars);
      break;

    case 'forum':
      _tcbl_preprocess_node_forum($vars);
      break;

    case 'blog':
      _tcbl_preprocess_node_blog($vars);
      break;

    case 'bpilot':
      _tcbl_preprocess_node_bpilot($vars);
      break;

    case 'banner':
      _tcbl_preprocess_node_banner($vars);
      break;

    case 'settings':
      _tcbl_preprocess_node_settings($vars);
      break;

    case 'conference':
      _tcbl_preprocess_node_conference($vars);
      break;

    case 'day':
      _tcbl_preprocess_node_day($vars);
      break;


    default:
      # code...
      break;
  }
}

function _tcbl_preprocess_node_event(&$vars){
  $node = $vars['node'];
  
  if ($vars['view_mode'] == 'full'){
    $address = _tcbl_calculate_address($vars);
    $vars['content']['maps'] = array(
      '#theme' => 'gmaps',
      '#address' => $address,
      '#key' => 'AIzaSyD4-faaQay2GTDdD6RlEqADHdyL4Ouj1rw',
      '#height' => '250',
    );
    _tcbl_add_comments_cta($vars);
  }

  if ($vars['view_mode'] == 'teaser'){

    $vars['classes_array'][] = 'margin-b-1';

    if (isset($node->field_location['und'][0]['city'])){
      $text = $node->field_location['und'][0]['city'];

      if (isset($vars['content']['field_date']['0']['#markup'])){
        $date = $vars['content']['field_date']['0']['#markup'];
        $text .= ' ' . $date;
      }
      hide($vars['content']['field_date']);

      $vars['content']['head'] = array(
        '#prefix' => '<h5 class="margin-v-025">',
        '#suffix' => '</h5>',
        '#markup' => $text,
      );
    }
  }

  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'margin-b-1';

    if (isset($node->field_location['und'][0]['city'])){
      $city = $node->field_location['und'][0]['city'];
      $vars['content']['city']['#markup'] = '<h6 class="margin-b-025">' . $city . '</h6>';
      $vars['content']['city']['#weight'] = 2;

      $vars['content']['more'] = array(
        '#prefix' => '<div class="wrapper-more copy small text-italic">',
        '#suffix' => '</div>',
        '#markup' => l('read more', 'node/' . $node->nid),
        '#weight' => 5,
      );
    }
  }
}

function _tcbl_calculate_address(&$vars){
  $node = $vars['node'];
  $address = _tcbl_calculate_address_array($node);

  if (!empty($address)){
    $address = implode($address, ' ');
  } else {
    $address = false;
  }

  return $address;
}

function _tcbl_calculate_address_array($node){
  $address = array();

  if (isset($node->field_location['und'][0])){
    $location = $node->field_location['und'][0];
    
    if (isset($location['street'])){
      $address['street']= $location['street'];
    }

    if (isset($location['city'])){
      $address['city']= $location['city'];
    }

    if (isset($location['country_name'])){
      $address['country_name']= $location['country_name'];
    }
  }

  return $address;
}

function _tcbl_preprocess_node_forum(&$vars){
  $node = $vars['node'];

  if ($vars['view_mode'] == 'full'){
    $faq = node_load(328);
    $vars['content']['faq'] = _tcbl_faq_link($faq);

    if (isset($node->field_author['und'][0]['uid'])){
      $uid = $node->field_author['und'][0]['uid'];
      $f_user = user_load($uid);
      $avat = _tcbl_get_avatar_path($f_user);
      $vars['avatar'] = $avat;
    }

    _tcbl_add_comments_cta($vars);
  }

  if ($vars['view_mode'] == 'teaser'){
    $vars['content']['more'] = array(
      '#prefix' => '<div class="wrapper-more copy margin-t-05">',
      '#suffix' => '</div>',
      '#markup' => l('Join the discussion', 'node/' . $node->nid),
      '#weight' => 5,
    );
  }

  if ($vars['view_mode'] == 'child'){
    if (isset($node->comment_count)){
      $cc = $node->comment_count;
      $vars['content']['comment_count']['#markup'] = $cc;

      $vars['content']['comment_label']['#markup'] = 'comments';
      if ($cc == 1){
        $vars['content']['comment_label']['#markup'] = 'comment';  
      } 
    }
  }
}

function _tcbl_preprocess_node_blog(&$vars){
  $node = $vars['node'];
  if ($vars['view_mode'] == 'full'){
    if (isset($node->field_by['und'][0]['user'])){
      $writtenBy = $node->field_by['und'][0]['user'];

      $name = $writtenBy->name;

      if (isset($writtenBy->field_firstname['und'][0]['value']) && $writtenBy->field_firstname['und'][0]['value'] !== ''){
        $name = $writtenBy->field_firstname['und'][0]['value'];
      
        if (isset($writtenBy->field_lastname['und'][0]['value']) && $writtenBy->field_lastname['und'][0]['value'] !== ''){
          $name .= ' ' . $writtenBy->field_lastname['und'][0]['value'];
        }
      }

      $vars['content']['field_by'] = array(
        '#prefix' => '<div class="posted-by margin-v-1"><p>',
        '#suffix' => '</p></div>',
        '#markup' => 'Posted By<br/>' . l($name, 'user/' . $writtenBy->uid),
        '#weight' => 8,
      );
    }

    _tcbl_add_comments_cta($vars);
  }

  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'margin-b-1';

    $vars['content']['more'] = array(
      '#prefix' => '<div class="wrapper-more copy small text-italic">',
      '#suffix' => '</div>',
      '#markup' => l('read more', 'node/' . $node->nid),
      '#weight' => 5,
    );
  }
}

function _tcbl_preprocess_node_bpilot(&$vars){
  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-md-4';
    $vars['classes_array'][] = 'col-sm-6';
  }
}

function _tcbl_preprocess_node_banner(&$vars){
  $node = $vars['node'];

  if ($vars['view_mode'] == 'child'){
    if (isset($node->field_url['und'][0]['url'])){
      $link = $node->field_url['und'][0];
      
      $url = $link['url'];
      $title = $link['title'];

      $vars['content']['field_image'][0]['#path']['path'] = $url;
      $vars['content']['field_image'][0]['#path']['options']['attributes']['title'] = htmlspecialchars_decode($title);
    }
  }
}

function _tcbl_preprocess_node_settings(&$vars){
  // We don't want people here
  // Install "content access" for only one page is an overkill
  if (!user_is_logged_in()){
    drupal_goto('<front>');
  }
}

function _tcbl_preprocess_node_conference(&$vars){
  $node = $vars['node'];

  if ($vars['view_mode'] == 'full'){
    _add_conference_where($vars, $node);
    _add_cta_event($vars);
    _add_footer_menu($vars, $node);
  }
}

function _tcbl_preprocess_node_day(&$vars){
  $node = $vars['node'];
  if ($vars['view_mode'] == 'full'){

    $conference = false;
    if (isset($node->nodehierarchy_menu_links[0]['pnid'])){
      $cnid = $node->nodehierarchy_menu_links[0]['pnid'];
      $conference = node_load($cnid);
    }

    _tcbl_node_day_alter_subtitle($vars);

    if ($conference){
      _add_conference_where($vars, $conference);
      _add_footer_menu($vars, $conference);
    }

    _add_cta_event($vars);

  }
}

function _tcbl_node_day_alter_subtitle(&$vars){
  $node = $vars['node'];
  if (isset($node->field_subtitle['und'][0]['value']) && $node->field_subtitle['und'][0]['value'] !== ''){
    $sub = $node->field_subtitle['und'][0]['value'];
    $sub = str_replace("|", '<span class="pipe">|</span>', $sub);
    $vars['content']['field_subtitle'][0]['#prefix'] = '<h4 class="text-center text-italic margin-v-05">';
    $vars['content']['field_subtitle'][0]['#suffix'] = '</h4>';
    $vars['content']['field_subtitle'][0]['#markup'] = $sub;
  }
}

function _add_conference_where(&$vars, $conference){
  $vars['content']['where'] = array(
    '#prefix' => '<i class="fa fa-map-marker"></i>',
  );

  if (isset($conference->field_location['und'][0]['city']) && $conference->field_location['und'][0]['city']){
    $vars['content']['where']['city']['#markup'] = $conference->field_location['und'][0]['city'];
  }

  if (isset($conference->field_location['und'][0]['country_name']) && $conference->field_location['und'][0]['country_name']){
    $vars['content']['where']['country_name']['#prefix'] = ' / ';
    $vars['content']['where']['country_name']['#markup'] = $conference->field_location['und'][0]['country_name'];
  }
}

function _add_cta_event(&$vars){
  $opt = array(
    'attributes' => array(
      'class' => array(
        'btn', 'btn-info', 'btn-lg',
      ),
      'target' => '_blank',
    ),
  );

  $vars['content']['more'] = array(
    '#prefix' => '<div class="wrapper-sign-up text-center margin-v-1">',
    '#suffix' => '</div>',
    '#markup' => l('Sign up for free', 'https://tcbl2018prato.eventbrite.it ', $opt),
    '#weight' => 40,
  );
}

function _add_footer_menu(&$vars, $conference){
  
  if ($conference){
    $cnid = $conference->nid;
    $tab_links[$cnid] = array(
      'path' => 'node/' . $cnid,
      'title' => 'Overview', 
    );
  }

  $links = _nodehierarchy_get_children_menu_links($conference->nid);
  foreach ($links as $key => $link) {
    if (isset($link['nid'])){
      $nid = $link['nid'];
      $day = node_load($nid);
      $tab_links[$nid] = array(
        'path' => 'node/' . $nid,
        'title' => $day->title,
      );
    }
  }
  
  $footer['#prefix'] = '<div class="conference-footer"><ul class="cf-ul">';
  $footer['#suffix'] = '</ul></div>';

  foreach ($tab_links as $key => $l) {

    $opt['fragment'] = 'conference';

    $footer[$key] = array(
      '#prefix' => '<li class="cf-li">',
      '#suffix' => '</li>',
      '#markup' => l($l['title'], $l['path'], $opt),
    );
  }

  //$opt = array(
  //  'attributes' => array(
  //    'target' => '_blank',
  //  ),
  //);
  //$footer['form'] = array(
  //  '#prefix' => '<li class="cf-li">',
  //  '#suffix' => '</li>',
  //  '#markup' => l('How to participate', 'https://tcbl2018prato.eventbrite.it', $opt),
  //);
  
  $vars['content']['footer'] = $footer;

}

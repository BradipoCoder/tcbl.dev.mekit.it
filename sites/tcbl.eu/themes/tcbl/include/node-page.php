<?php

/**
 * @file
 * node-page.php
 */

/**
 * Preprocess node page
 * @param  [type] &$vars [description]
 * @return [type]        [description]
 */
function _tcbl_preprocess_node_page(&$vars){
  $node = $vars['node'];
  if ($vars['view_mode'] == 'teaser'){
    $opt = array(
      'attributes' => array(
        'class' => array(
          'btn', 'btn-ghost',
        ),
      ),
    );
    $vars['content']['more'] = array(
      '#prefix' => '<div class="wrapper-page-more margin-t-1">',
      '#suffix' => '</div>',
      '#markup' => l('Read more', 'node/' . $node->nid, $opt),
    );
  }

  if ($vars['view_mode'] == 'full'){
    $vars['has_image'] = false;
    if (isset($node->field_image['und'][0]['uri'])){
      $vars['has_image'] = true;
    }  
  }

  if ($node->nid == 312){
    _tcbl_preprocess_node_page_news($vars);
  }

  if ($node->nid == 313){
    _tcbl_preprocess_node_page_events($vars);
  }

  if ($node->nid == 327){
    _tcbl_preprocess_node_page_forums($vars);
  }

  if ($node->nid == 310){
    _tcbl_preprocess_node_page_bpilots($vars);
  }
}

/**
 * Hide counter intuitive tabs on node with views
 * Administator can see everything
 */
function _tcbl_is_page_with_view(&$vars){
  $vars['page_with_view'] = false;

  global $user;
  $roles = $user->roles;
  if (isset($roles[3])){
    return;
  }

  $has_view = array(
    '312',
  );
  
  if (isset($vars['node'])){
    $node = $vars['node'];
    $nid = $node->nid;
    if (in_array($nid, $has_view)){
      $vars['page_with_view'] = true;
    }
  }  
}

function _tcbl_preprocess_node_page_events(&$vars){
  
  $faq = node_load(352);
  $vars['content']['faq'] = _tcbl_faq_link($faq);

  $set = _tcbl_get_tcbl_settings();
  if (isset($set->field_ref_banner_events['und'][0]['target_id'])){
    $nid = $set->field_ref_banner_events['und'][0]['target_id'];
    $banner = node_load($nid);
    $vars['content']['banner'] = array(
      '#prefix' => '<div id="event-banner" class="col-xs-12 wrapper-banner margin-b-2 hide">',
      '#suffix' => '</div>',
      'node' => node_view($banner, 'child'),
    );
  }

  $vars['content']['events']['#markup'] = views_embed_view('events', 'first_6');
  add_same_h_by_selector('.events-sameh');

  $js = drupal_get_path('theme', 'tcbl') . '/js/events.js';
  drupal_add_js( $js , array('group' => JS_LIBRARY, 'weight' => 1));
}

function _tcbl_preprocess_node_page_news(&$vars){
  $vars['content']['news']['#markup'] = views_embed_view('news', 'archive');
  add_same_h_by_selector('.news-sameh');
  //$vars['content']['news']['banner']['#markup'] = '<div class="well margin-v-1"><code>banner</code></div>';
  //$vars['content']['news']['up']['#markup'] = views_embed_view('news', 'bottom_3');
}

function _tcbl_preprocess_node_page_forums(&$vars){
  $faq = node_load(328);
  $vars['content']['faq'] = _tcbl_faq_link($faq);
  $vars['content']['forum']['#markup'] = views_embed_view('forum', 'content');
}

function _tcbl_preprocess_node_page_bpilots(&$vars){
  $node = $vars['node'];

  if ($vars['view_mode'] == 'full'){
    $vars['content']['bpilots']['#markup'] = views_embed_view('bpilots', 'block');
    $vars['content']['bpilots']['#weight'] = 40;
    add_same_h_by_selector('.bpilots-sameh');
  }
}
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

  if ($node->nid == 312){
    _tcbl_preprocess_node_page_news($vars);
  }

   if ($node->nid == 326){
    _tcbl_preprocess_node_page_news_archive($vars);
  }

  if ($node->nid == 313){
    _tcbl_preprocess_node_page_events($vars);
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
    '312', '313', '326',
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
  $vars['content']['events']['#markup'] = views_embed_view('events', 'first_6');
  add_same_h_by_selector('.events-sameh');
}

function _tcbl_preprocess_node_page_news(&$vars){
  $vars['content']['news']['top']['#markup'] = views_embed_view('news', 'first_6');
  add_same_h_by_selector('.news-sameh');

  $vars['content']['news']['banner']['#markup'] = '<div class="well margin-v-1"><code>banner</code></div>';
  
  $vars['content']['news']['up']['#markup'] = views_embed_view('news', 'bottom_3');
  
  $opt = array(
    'attributes' => array(
      'class' => array('btn', 'btn-primary', 'btn-ghost', 'btn-lg'),
    ),
  );

  $vars['content']['news']['more'] = array(
    '#prefix' => '<div class="wrapper-more text-center">',
    '#suffix' => '</div>',
    '#markup' => l('More', 'node/326', $opt),
  );
}

function _tcbl_preprocess_node_page_news_archive(&$vars){
  $vars['content']['news']['#markup'] = views_embed_view('news', 'archive');
  add_same_h_by_selector('.news-sameh');  
}
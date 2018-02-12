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

  if ($node->nid == 313){
    _tcbl_preprocess_node_page_events($vars);
  }
}

function _tcbl_preprocess_node_page_events(&$vars){
  $vars['content']['events']['#markup'] = views_embed_view('events', 'first_6');
  add_same_h_by_selector('.events-sameh');
}
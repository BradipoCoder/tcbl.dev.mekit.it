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

    case 'cover':
      _tcbl_preprocess_node_cover($vars);
      break;

    case 'service':
      _tcbl_preprocess_node_service($vars);
      break;

    case 'post':
      _tcbl_preprocess_node_post($vars);
      break;

    case 'member':
      _tcbl_preprocess_node_member($vars);
      break;


    default:
      # code...
      break;
  }
}

function _tcbl_preprocess_node_cover(&$vars){
  if ($vars['view_mode'] == 'teaser'){
    $vars['classes_array'][] = 'margin-v-6';
    $vars['classes_array'][] = 'negative';
    $vars['classes_array'][] = 'text-center';
  }
}

/**
 * Preprecess node service
 * @param  [type] &$vars [description]
 * @return [type]        [description]
 */
function _tcbl_preprocess_node_service(&$vars){
  $node = $vars['node'];
  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-sm-4';
    $vars['classes_array'][] = 'margin-b-1';
    _tcbl_display_as_hover_box($vars);

    if ($node->nid == 8){
      $vars['classes_array'][] = 'col-sm-offset-2';
    }
  }

  if ($vars['view_mode'] == 'full'){
    _tcbl_add_posts_by_category($vars);
  }
}

/**
 * Preprecess node post
 * @param  [type] &$vars [description]
 * @return [type]        [description]
 */
function _tcbl_preprocess_node_post(&$vars){
  $node = $vars['node'];

  if ($vars['view_mode'] == 'full'){
    _tcbl_post_category_and_date($vars);
    _tcbl_post_category_btm($vars);
    _add_custom_btn_social($vars);
    _tcbl_fancy_share($vars);

    $title = field_view_field('node', $node, 'field_form_title' , 'default');
    _tcbl_add_bottom_form($vars, $title);
  }

  if ($vars['view_mode'] == 'child'){
    _tcbl_post_short_title($vars);
    _tcbl_post_category_and_date($vars);
    hide($vars['content']['field_date']);
    hide($vars['content']['field_ref_cat']);
    $vars['classes_array'][] = 'col-md-6';
    $vars['classes_array'][] = 'margin-b-2';
    add_same_h_by_selector('.view-id-posts');
  }
}


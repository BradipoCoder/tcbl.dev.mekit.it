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

    default:
      # code...
      break;
  }
}

function _tcbl_preprocess_node_event(&$vars){
  $node = $vars['node'];
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

function _tcbl_preprocess_node_forum(&$vars){
  $node = $vars['node'];

  if ($vars['view_mode'] == 'full'){
    $vars['content']['faq'] = _tcbl_faq_link();
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

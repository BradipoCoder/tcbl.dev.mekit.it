<?php

/**
 * @file
 * template.php
 */

require('include/content.php');
require('include/content-types.php');
require('include/node-page.php');
require('include/form.php');
require('include/paragraphs.php');
require('include/feed.php');
require('include/comment.php');
require('include/access.php');

/**
 * Implements hook_preprocess_html()
 * Google fonts and Google Analitycs
 */
function tcbl_preprocess_html(&$variables) {
  $fonts = array(
    0 => 'https://fonts.googleapis.com/css?family=Raleway:400,400i,600,600i',
  );

  foreach ($fonts as $key => $css) {
    drupal_add_css($css, array('type' => 'external'));
  }
}

function tcbl_preprocess_page(&$vars){
  // Logo
  $path = drupal_get_path('theme', 'tcbl') . '/img/';
  $vars['logo'] = array(
    '#markup' => '<img src="/' . $path . 'tcbl-logo.svg" class="img-logo"/>',
  );

  // Container class
  $vars['container_class'] = 'container';
  if ($vars['is_front']){
    $vars['container_class'] = 'container-fluid';
  }

  _tcbl_add_social_menu($vars);
  _tcbl_add_user_login($vars);
  _tcbl_add_header($vars);
  _tcbl_alter_breadcrumbs($vars);

  _tcbl_add_light_footer($vars);

  _tcbl_add_conference_cover($vars);
  
  // Add usefull variables to page template (when views is present)
  _tcbl_is_page_with_view($vars);

  $js_scroll_to = libraries_get_path('jquery.scrollto') . '/jquery.scrollto.js';
  drupal_add_js( $js_scroll_to , array('group' => JS_LIBRARY, 'weight' => 1));
}


function tcbl_preprocess_user_profile(&$vars){
  if (arg(1)){
    $uid = arg(1);
    $this_user = user_load($uid);
    $data = _tcbl_get_avatar_path($this_user);

    $vars['user_profile']['avatar'] = array(
      '#prefix' => '<div class="tcbl-avatar">',
      '#suffix' => '</div>',
      '#markup' => '<img src="' . $data['path'] . '" class="img-responsive ' . $data['type'] . '"/>',
      '#weight' => -1,
    );

    if (isset($this_user->mail)){
      $vars['user_profile']['mail'] = array(
        '#prefix' => '<p>',
        '#suffix' => '</p>',
        '#markup' => $this_user->mail,
        '#weight' => 5,
      );
    }
  }
}

// ** ADMIN **
// -----------

/**
 * Implements hook_form_FORM_ID_alter(&$form, &$form_state, $form_id)
 * Node editing and some permission
 */
function tcbl_form_node_form_alter(&$form, $form_state){
  global $user;

  $form['nodehierarchy']['#title'] = 'Parent node';
  if (isset($form['nodehierarchy']['nodehierarchy_menu_links'][0]['#title'])){
    $form['nodehierarchy']['nodehierarchy_menu_links'][0]['#title'] = 'Parent node';
    $form['nodehierarchy']['#weight'] = -1;
  }

  if ($user->uid == 1){
    // Administrator
  } else {
    $form['options']['promote']['#access'] = false;
    $form['options']['sticky']['#access'] = false;
    field_group_hide_field_groups($form, array('group_hide'));
  }
  
  // Can see editor field
  $is_editor = _tcbl_is_editor();

  // Field author | Forum topic
  if (isset($form['field_author']['und'][0]['uid'])){
    $form['field_author']['und'][0]['uid']['#default_value'] = $user->uid;
    if (!$is_editor){
      $form['field_author']['#disabled'] = true;  
    }
  }

  // Field by | News
  if (isset($form['field_by']['und'][0]['uid'])){
    $form['field_by']['und'][0]['uid']['#default_value'] = $user->uid;
    if (!$is_editor){
      $form['field_by']['#disabled'] = true;  
    }
  }
}

// ** THEME **
// -----------

/**
 * Implements hook_theme
 * @return [type] [description]
 */
function tcbl_theme(){
  $path = drupal_get_path('theme', 'tcbl') . '/templates/content';
  return array(
    'gmaps' => array(
      // use a template and give the template's name.
      'template' => 'gmaps',
      'variables' => array(
        'address' => NULL,
        'key' => NULL,
        'width' => '100%',
        'height' => '400',
        'static_width' => '500',
        'static_height' => '300',
        'zoom' => 14,
        'information_bubble' => false,
        'langcode' => 'en',
        'map_type' => 'roadmap', // or satellite
      ),
      'pattern' => 'gmaps__',
      'path' => $path,
    ),
    'tcblfooter' => array(
      'template' => 'tcblfooter',
      'variables' => array(
        'content' => array(),
      ),
      'pattern' => 'tcblfooter__',
      'path' => $path,
    ),
    'confcover' => array(
      'template' => 'confcover',
      'variables' => array(
        'content' => array(),
        'path' => NULL,
      ),
      'pattern' => 'confcover__',
      'path' => $path,
    ),
  );
}

/**
 * Implements hook_form_FORM_ID_alter(&$form, &$form_state, $form_id)
 */
function tcbl_form_webform_client_form_20_alter(&$form, &$form_state, $form_id){
  $node = menu_get_object();
  if ($node){
    $form['submitted']['info']['#default_value'] = $node->title;
  } else {
    $form['submitted']['info']['#default_value'] = 'Home page';
  }
}

function tcbl_preprocess_sadmin(&$vars){
  $is_editor = _tcbl_is_editor();
  //dpm($vars['buttons']);

  if (!$is_editor){
    if (isset($vars['buttons'])){
      foreach ($vars['buttons'] as $key => $l) {
         if ($l['#path'] == 'node/355'){
            unset($vars['buttons'][$key]);
         }
       } 
    }  
  }
}

function _tcbl_add_conference_cover(&$vars){
  if (isset($vars['node'])){
    $node = $vars['node'];  
    if ($node->type == 'conference'){
      
      $tab_links[] = array(
        'path' => '<front>',
        'title' => 'Overview', 
      );

      $tab_links[] = array(
        'path' => '<front>',
        'title' => 'Day one', 
      );

      $tab_links[] = array(
        'path' => '<front>',
        'title' => 'Day two', 
      );

      $tab_links[] = array(
        'path' => '<front>',
        'title' => 'Speaker', 
      );

      $tabs = array(
        '#prefix' => '<ul class="ul-conference-tabs">',
        '#suffix' => '</ul>',
      );

      $n = 0;
      foreach ($tab_links as $key => $link) {
        $n++;

        $markup = '<span>0' . $n  . '.</span> <span class="title">' . $link['title'] . '</span>';

        $opt = array(
          'html' => 'true',
        );

        $tabs[$key] = array(
          '#prefix' => '<li class="conf-tab">',
          '#suffix' => '</li>',
          '#markup' => l($markup, $link['path'], $opt),
        );
      }

      // Cover image and content
      if (isset($node->field_img['und'][0]['uri'])){
        $uri = $node->field_img['und'][0]['uri'];
        $url_img = file_create_url($uri);

        $content['title'] = field_view_field('node', $node, 'field_description', 'default');
        $content['sub'] = field_view_field('node', $node, 'field_subtitle', 'default');
        $content['tabs'] = $tabs;

        $vars['page']['conference_cover'] = array(
          '#theme' => 'confcover',
          '#content' => $content,
          '#path' => $url_img,
        );

        $js_parallax = libraries_get_path('jquery.parallax') . '/jquery.parallax.min.js';
        drupal_add_js( $js_parallax , array('group' => JS_LIBRARY, 'weight' => 1));
      }
    }
  }
}
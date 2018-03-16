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

  /*
  $ga = _tcbl_get_ga_script();
  drupal_add_js($ga, array('type' => 'inline', 'scope' => 'header', 'weight' => 5));
  */
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

  _tcbl_remove_comment_wall($vars);

  _tcbl_add_social_menu($vars);
  _tcbl_add_user_login($vars);
  _tcbl_add_header($vars);
  _tcbl_alter_breadcrumbs($vars);

  _tcbl_add_light_footer($vars);
  
  // Add usefull variables to page template (when views is present)
  _tcbl_is_page_with_view($vars);

  $js_scroll_to = libraries_get_path('jquery.scrollto') . '/jquery.scrollto.js';
  drupal_add_js( $js_scroll_to , array('group' => JS_LIBRARY, 'weight' => 1));
}

function _tcbl_remove_comment_wall(&$vars){
  if (isset($vars['tabs']['#primary'])){
    $primary = $vars['tabs']['#primary'];
    if (!empty($primary)){
      foreach ($primary as $key => $l) {
        if (isset($l['#link']['path']) && ($l['#link']['path'] == 'user/%/comment-wall')){
          unset($vars['tabs']['#primary'][$key]);
        }
      }
    }
  }
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

/**
 * @return string
 */
function _tcbl_get_ga_script(){
  $ga = "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99587862-1', 'auto');
  ga('send', 'pageview');";
  return $ga;
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
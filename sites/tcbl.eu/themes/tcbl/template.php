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
require('include/company.php');
require('include/user.php');
require('include/dev.php');

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
    '#markup' => '<img src="/' . $path . 'tcbl-logo-new.png" class="img-logo"/>',
  );

  // Utility to delete the watchdog
  // db_delete('watchdog')->execute();

  _tcbl_alter_container_class($vars);

  _tcbl_add_social_menu($vars);
  _tcbl_add_user_login($vars);
  _tcbl_add_header($vars);
  _tcbl_alter_breadcrumbs($vars);

  _tcbl_add_light_footer($vars);

  _tcbl_add_conference_cover($vars);
  
  // Add usefull variables to page template (when views is present)
  _tcbl_is_page_with_view($vars);

  $js = libraries_get_path('jquery.scrollto') . '/jquery.scrollto.js';
  drupal_add_js( $js , array('group' => JS_LIBRARY, 'weight' => 1));

  $js = libraries_get_path('jquery.lightslider') . '/js/lightslider.min.js';
  drupal_add_js( $js , array('group' => JS_LIBRARY, 'weight' => 1));
  $css = libraries_get_path('jquery.lightslider') . '/css/lightslider.min.css';
  drupal_add_css($css, array('group' => CSS_SYSTEM));
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
  $is_mentor = _tcbl_is_mentor();

  // Field author | Forum topic
  if (isset($form['field_author']['und'][0]['uid'])){
    if (!$form['field_author']['und'][0]['uid']['#default_value']){
      $form['field_author']['und'][0]['uid']['#default_value'] = $user->uid;
    }
    if (!$is_editor){
      $form['field_author']['#disabled'] = true;  
    }
  }

  // Field by | News
  if (isset($form['field_by']['und'][0]['uid'])){
    if (!$form['field_by']['und'][0]['uid']['#default_value']){
      $form['field_by']['und'][0]['uid']['#default_value'] = $user->uid;
    }

    if (!$is_editor){
      $form['field_by']['#disabled'] = true;  
    }
  }

  // Chi non è editor o mentor non vede il gruppo Admin settings
  if ($is_editor || $is_mentor){
  } else {
    field_group_hide_field_groups($form, array('group_admin', 'group_eval'));  
  }

  _tcbl_alter_comps_form($form, $form_state);
}

function _tcbl_alter_comps_form(&$form, $form_state){
  
  global $user;

  // Check if node exists
  $node = false;
  if (isset($form['#node'])){
    $node = $form['#node'];
    if ($node->type !== 'company'){
      return;
    }
  }

  $is_lab = false;
  $is_startup = false;
  // Se il nodo è già stato creato
  if (isset($node->nid)){
    if ($node->field_ref_memb['und'][0]['tid'] == '28'){
      $is_lab = true;
    }
    if ($node->field_ref_memb['und'][0]['tid'] == '61'){
      $is_startup = true; 
    }
  }

  // If is not a lab – hide a lot of fields
  if (!$is_lab){
    field_group_hide_field_groups($form, array('group_lab', 'group_kas'));
    $form['field_ref_projects']['#access'] = false;
    $form['field_cv_project']['#access'] = false; 
  }

  if ($is_lab){
    // Add some JS
    $js = drupal_get_path('theme', 'tcbl') . '/js/company-backend.js';
    drupal_add_js( $js , array('group' => JS_LIBRARY, 'weight' => 1));
  }

  //$keys = array_keys($form['#groups']);
  //dpm($keys);

  // Key activities logic
  if (isset($node->nid) && ($is_lab)){
    $activeTids = array();

    $map = array(
      '45' => 'group_11', // Business support
      '46' => 'group_c_creative_hub',
      '47' => 'group_s_social',
      '49' => 'group_r_research',
      '48' => 'group_t_teaching_training',
      '50' => 'group_p_production',
    );

    if (isset($node->field_ref_kas['und'][0]['tid'])){
      $items = $node->field_ref_kas['und'];
      foreach ($items as $key => $item) {
        $activeTids[] = $item['tid'];
      }
    }

    foreach ($map as $tid => $field) {
      if (!in_array($tid, $activeTids)){
        field_group_hide_field_groups($form, array($field));  
      }
    }
  }


  // If is not a startup - hide startup fields
  if (!$is_startup){
    field_group_hide_field_groups($form, array('group_startup'));  
  }

  // No one can change this field
  // $form['field_ref_eval_labs']['#disabled'] = true;

  global $user;
  if ($user->uid == 1){
    // Administrator
    // foreach ($form as $key => $value) {
    //   $list[] = $key;
    // }
    // dpm($list);
  } else {
    $form['comment_settings']['#access'] = false;
    $form['metatags']['#access'] = false;
    $form['revision_information']['#access'] = false;
  }
}

function _tcbl_condition_is_lab(){
  # https://api.drupal.org/api/drupal/includes%21common.inc/function/drupal_process_states/7.x
  # https://www.drupal.org/node/767268#comment-2881864
  $condition = array(
    'visible' => array(
      ':input[name="field_ref_memb[und]"]' => array('value' => '28'),
    ),
  );
  return $condition;
}

/**
 * Implements hook_field_group_build_pre_render_alter().
 * not working
 */
// function tcbl_field_group_build_pre_render_alter(&$element){
//   $form_id = $element['#form_id'];
//   if ($form_id == 'company_node_form'){
//     if (isset($element['group_lab'])){
//       foreach ($element['group_lab'] as $key => $value) {
//         //dpm($key);
//       }
// 
//       $element['group_lab']['#states'] = _tcbl_condition_is_lab();
//     } 
//   }
// }

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
        'nid' => NULL,
      ),
      'pattern' => 'confcover__',
      'path' => $path,
    ),
    'companytabs' => array(
      'template' => 'companytabs',
      'variables' => array(
        'items' => NULL,
      ),
      'pattern' => 'companytabs__',
      'path' => $path,
    ),
    'companykas' => array(
      'template' => 'companykas',
      'variables' => array(
        'items' => NULL,
      ),
      'pattern' => 'companykas__',
      'path' => $path,
    ),
    'extcollaboration' => array(
      'template' => 'extcollaboration',
      'variables' => array(
        'url' => NULL,
        'title' => NULL,
      ),
      'pattern' => 'extcollaboration__',
      'path' => $path,
    ),
    'iconlink' => array(
      'template' => 'iconlink',
      'variables' => array(
        'url' => NULL,
        'title' => NULL,
      ),
      'pattern' => 'iconlink__',
      'path' => $path,
    ),
    'icondownload' => array(
      'template' => 'icondownload',
      'variables' => array(
        'url' => NULL,
        'title' => NULL,
      ),
      'pattern' => 'icondownload__',
      'path' => $path,
    ),
    'pricing-table' => array(
      'template' => 'pricing-table',
      'variables' => array(
        'content' => NULL,
      ),
      'pattern' => 'pricing-table__',
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

  if (!$is_editor){
    if (isset($vars['buttons'])){
      foreach ($vars['buttons'] as $key => $l) {
        if ($l['#path'] == 'node/355'){
          unset($vars['buttons'][$key]);
        }
        
      } 
    }  
  }

  // Se non è uno short runs editor (nascondo la preview di shortruns)
  if (!$is_editor){
    $is_sruns_editor = _tcbl_is_sruns_editor();
    if (!$is_sruns_editor){
      if (isset($vars['buttons'])){
        foreach ($vars['buttons'] as $key => $l) {  
          if ($l['#path'] == 'shortruns'){
            unset($vars['buttons'][$key]); 
          }  
        }
      }
    }
  }

}

function _tcbl_add_conference_cover(&$vars){
  if (isset($vars['node'])){
    $node = $vars['node'];  

    $conference = false;
    if ($node->type == 'conference' || $node->type == 'day'){
      if (!arg(2)){    
        if ($node->type == 'conference'){
          $conference = $node;  
        } else {
          if (isset($node->nodehierarchy_menu_links[0]['pnid'])){
            $c_nid = $node->nodehierarchy_menu_links[0]['pnid'];
            $conference = node_load($c_nid);
          }
        }
      }
    }

    if ($conference){
      $cnid = $conference->nid;
      $tab_links[$cnid] = array(
        'path' => 'node/' . $cnid,
        'title' => 'Overview', 
      );

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

      $tabs = array(
        '#prefix' => '<ul class="ul-conference-tabs">',
        '#suffix' => '</ul>',
      );

      $n = 0;
      foreach ($tab_links as $key => $link) {
        $n++;

        //$markup = '<span class="number">0' . $n  . '.</span> <span class="title">' . $link['title'] . '</span>';
        $markup = '<span class="title">' . $link['title'] . '</span>';

        $opt = array(
          'html' => 'true',
        );

        //dpm($key, $cnid);

        if ($key != $cnid){
          $opt['fragment'] = 'conference';  
        }

        if ($node->nid == $key){
          $opt['attributes']['class'][] = 'active';
        }

        $tabs[$key] = array(
          '#prefix' => '<li class="conf-tab">',
          '#suffix' => '</li>',
          '#markup' => l($markup, $link['path'], $opt),
        );
      }

      // Cover image and content
      if (isset($conference->field_img['und'][0]['uri'])){
        $uri = $conference->field_img['und'][0]['uri'];
        $url_img = file_create_url($uri);

        $content['title'] = field_view_field('node', $conference, 'field_description', 'default');
        $content['sub'] = field_view_field('node', $conference, 'field_subtitle', 'default');

        $url = _tcbl_get_eventbride_url_from_node($conference);

        $opt = array(
          'attributes' => array(
            'class' => array(
              'btn', 'btn-info', 'btn-lg',
            ),
            'target' => '_blank',
          ),
        );

        // @todo: link a eventbride.it
        $content['more'] = array(
          '#markup' => l('Sign up for free', $url, $opt),
        );

        $display_tabs = _tcbl_display_tabs($conference);
        if ($display_tabs){
          $content['tabs'] = $tabs;
        }

        $vars['page']['conference_cover'] = array(
          '#theme' => 'confcover',
          '#content' => $content,
          '#path' => $url_img,
          '#nid' => $conference->nid,
        );

        $js_parallax = libraries_get_path('jquery.parallax') . '/jquery.parallax.min.js';
        drupal_add_js( $js_parallax , array('group' => JS_LIBRARY, 'weight' => 1));
      }
    }
  }
}
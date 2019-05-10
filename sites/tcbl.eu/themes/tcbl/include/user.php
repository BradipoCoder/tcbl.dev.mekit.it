<?php

/**
 * @file
 * user.php
 */

function tcbl_preprocess_user_profile(&$vars){
  $vars['theme_hook_suggestions'][] = 'user_profile';
  $vars['theme_hook_suggestions'][] = 'user_profile__' . $vars['elements']['#view_mode'];

  $uid = $vars['elements']['#account']->uid;
  $profile = user_load($uid);
  $avatar = _tcbl_get_avatar_path($profile);

  $vars['url'] = url('user/' . $uid);

  // Standard user profile
  // $vars['user_profile']['avatar'] = array(
  //   '#prefix' => '<span class="tcbl-avatar">',
  //   '#suffix' => '</span>',
  //   '#markup' => '<img src="' . $avatar['path'] . '" class="img-responsive ' . $avatar['type'] . '"/>',
  //   '#weight' => -1,
  // );

  // New avatar
  $vars['user_profile']['avatar']['#prefix'] = '<span class="flat-avatar">';
  $vars['user_profile']['avatar']['#markup'] = '<span class="flat-avatar__icon"><span><i class="fa fa-user"></i></span></span>';
  $vars['user_profile']['avatar']['#suffix'] = '</span>';

  if ($avatar['type'] == 'sso'){
    $vars['user_profile']['avatar']['#markup'] = '<span class="flat-avatar__icon"><img src="' . $avatar['path'] . '" class="img-responsive"/></span>';  
  }

  // Teaser view mode
  if ($vars['elements']['#view_mode'] == 'default'){
    $vars['user_profile']['type']['#markup'] = ', Lab Manager';
  }

  // Full page
  if ($vars['elements']['#view_mode'] == 'full'){
    _tcbl_user_add_company_reference($vars, $profile);
  }

  $vars['show_contact'] = false;
  if (user_is_logged_in()){
    $vars['show_contact'] = true;
  }

  if (isset($profile->mail)){
    $vars['user_profile']['mail'] = array(
      '#prefix' => '<span class="text-primary-light">',
      '#suffix' => '</span>',
      '#markup' => $profile->mail,
    );
  }
}

function _tcbl_user_add_company_reference(&$vars, $profile){
   $vars['company'] = false;

  $uid = $profile->uid;

  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array('company'))
    ->propertyCondition('status', NODE_PUBLISHED)
    ->propertyOrderBy('changed', 'DESC')
    ->fieldCondition('field_ref_user', 'target_id', $uid);

  $query->execute();
  if (isset($query->ordered_results)){
    $results = $query->ordered_results;
  
    $nids = [];
    foreach ( $results as $node ) {
      array_push($nids, $node->entity_id );
    }
   
    if (count($nids)){
      $company = node_load($nids[0]);
      $vars['company'] = true;
      $vars['content']['company'] = node_view($company, 'card');
    }  
  }
  
}




<?php

/**
 * @file
 * comment.php
 */

function tcbl_preprocess_comment_wrapper(&$vars){
  //dpm($vars);
  
  $vars['comments'] = true;
  if (isset($vars['content']['comments'])){
    $comments = $vars['content']['comments'];
    $keys = element_children($comments);
    if (empty($keys)){
      $vars['comments'] = false;
    }
  }

  if (isset($vars['content']['comment_form']['author']['_author'])){
    global $user;
    $this_user = user_load($user->uid);
    $data = _tcbl_get_avatar_path($this_user);

    $name = $this_user->name;

    if (isset($this_user->realname)){
      $name = $this_user->realname;
    }

    $you = array(
      '#prefix' => '<div class="wrapper-you">',
      '#suffix' => '</div>',
    );

    $you['avatar'] = array(
      '#prefix' => '<div class="tcbl-avatar tcbl-avatar-small">',
      '#suffix' => '</div>',
      '#markup' => '<img src="' . $data['path'] . '" class="img-responsive ' . $data['type'] . '"/>',
      '#weight' => -1,
    );

    $you['name'] = array(
      '#prefix' => '<div class="tcbl-you-name">',
      '#suffix' => '</div>',
      '#markup' => '<h5>' . $name . '</h5>',
    );

    $vars['content']['comment_form']['author']['_author']['#title_display'] = 'none';
    $vars['content']['comment_form']['author']['_author']['#markup'] = render($you);
  }
}

function tcbl_preprocess_comment(&$vars){
  $comment = $vars['comment'];
  $uid = $comment->uid;
  $c_user = user_load($uid);
  if ($c_user){
    $data = _tcbl_get_avatar_path($c_user);
    $vars['content']['avatar'] = array(
      '#prefix' => '<div class="tcbl-avatar tcbl-avatar-small">',
      '#suffix' => '</div>',
      '#markup' => '<img src="' . $data['path'] . '" class="img-responsive ' . $data['type'] .'"/>',
    );
  }
  $vars['content']['links']['#attributes']['class'] = array('comment-links');

  // Sostituisco il link all'accesso SSO
  if (isset($vars['content']['links']['comment']['#links']['comment_forbidden'])){
    $vars['content']['links']['comment']['#links']['comment_forbidden']['title'] = '<a href="/user/gluuSSO" title="Log in at TCBL" class="l-forbidden">Login with TCBL</a> <span class="l-forbidden">to comment</span>';  
  }
}
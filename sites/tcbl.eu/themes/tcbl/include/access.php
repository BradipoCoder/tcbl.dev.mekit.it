<?php

/**
 * @file
 * access.php
 * 2 autenticated
 * 3 administrator
 * 4 editor
 * 10 mentor
 * 5 partner?
 * 6 gluu user
 */

function _tcbl_is_editor(){
  global $user;
  $is_editor = false;
  $roles = $user->roles;
  if (isset($roles[3]) || isset($roles[4])){
    $is_editor = true;
  }
  return $is_editor;
}

function _tcbl_is_sruns_editor(){
  global $user;
  $sr_editor = false;
  $roles = $user->roles;
  if (isset($roles[9])){
    $sr_editor = true;
  }
  return $sr_editor;  
}

function _tcbl_is_mentor(){
  global $user;
  $mentor = false;
  $roles = $user->roles;
  if (isset($roles[10])){
    $mentor = true;
  }
  return $mentor;  
}


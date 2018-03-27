<?php

/**
 * @file
 * access.php
 * 2 autenticated
 * 3 administrator
 * 4 editor
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

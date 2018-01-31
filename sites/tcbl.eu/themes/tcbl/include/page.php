<?php

/**
 * @file
 * page.php
 */

/**
 * Preprocess node page
 * @param  [type] &$vars [description]
 * @return [type]        [description]
 */
function _tcbl_preprocess_node_page(&$vars){
  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-sm-6';
    $vars['classes_array'][] = 'col-md-4';
  }
}
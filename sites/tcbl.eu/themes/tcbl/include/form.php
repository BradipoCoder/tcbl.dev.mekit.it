<?php

/**
 * @file
 * form.php
 */

function _tcbl_add_bottom_form(&$vars, $title){
  $n_form = node_load(20);
  $n_form_view = node_view($n_form);

  $vars['content']['webform'] = array(
    '#theme' => 'ser-btm-form',
    '#head' => $title,
    '#form' => $n_form_view,
    '#classes' => '',
  );
}

function _tcbl_add_bottom_form_negative(&$vars, $head){
  $n_form = node_load(20);
  $n_form_view = node_view($n_form);

  $vars['content']['btm_form'] = array(
    '#theme' => 'ser-btm-form',
    '#head' => $head,
    '#form' => $n_form_view,
    '#classes' => 'negative bg-green',
  );
}
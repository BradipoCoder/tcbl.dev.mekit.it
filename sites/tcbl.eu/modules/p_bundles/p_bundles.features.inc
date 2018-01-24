<?php
/**
 * @file
 * p_bundles.features.inc
 */

/**
 * Implements hook_paragraphs_info().
 */
function p_bundles_paragraphs_info() {
  $items = array(
    'copy' => array(
      'name' => 'Testo',
      'bundle' => 'copy',
      'locked' => '1',
    ),
    'img_big' => array(
      'name' => 'Immagine grande',
      'bundle' => 'img_big',
      'locked' => '1',
    ),
    'imgs' => array(
      'name' => 'Immagini affiancate',
      'bundle' => 'imgs',
      'locked' => '1',
    ),
    'video' => array(
      'name' => 'Video',
      'bundle' => 'video',
      'locked' => '1',
    ),
  );
  return $items;
}

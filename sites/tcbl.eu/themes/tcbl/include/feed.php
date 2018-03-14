<?php

/**
 * @file
 * feed.php
 */

function tcbl_preprocess_tcbl_feed_item(&$vars){
  $item = $vars['feed_item'];
  $type = $item->getSource();

  $vars['img_path'] = $item->getPictureUrl();
  $vars['title'] = $item->getTitle();
  $vars['url'] = $item->getUrl();

  $vars['source'] = $item->getSource();
  $vars['is_social'] = $item->isSocial();

  $date = $item->getCreationDate();
  $timestamp = $date->getTimestamp();
  $vars['date'] = format_date($timestamp, 'feed');

  if ($vars['is_social']){
    $vars['date'] = format_date($timestamp, 'feed_social');
  }


  $description = $item->getDescription();
  $vars['description'] = substr($description, 0, 150);

  $vars['message'] = $item->getTrimmedMessage(130);

  if ($item->getPostedByPictureUrl()){
    $src = $item->getPostedByPictureUrl();
    $vars['avatar'] = array(
      '#markup' => '<img src="' . $src . '" class="social-avatar social-avatar-' . $vars['source'] . '"/>',
    );
  }

  $vars['name'] = $item->getPostedByName();

  switch ($type) {
    case 'tcbl_labs':
      //_tcbl_preprocess_labs_feed($vars);
      break;
    
    default:
      # code...
      break;
  }
}
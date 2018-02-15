<?php

/**
 * @file
 * forum.php
 */

function tcbl_preprocess_forum_topic_list(&$vars){
  if (isset($vars['topics'][0])){
    foreach ($vars['topics'] as $key => $topic) {
      $node = node_load($topic->nid);
      
      // Add topic date
      $created = $node->created;
      $vars['topics'][$key]->simple_created = format_date($created, 'short');
    
      // Add topic comment label
      $vars['topics'][$key]->comment_label = 'comments';
      if ($topic->comment_count == 1){
        $vars['topics'][$key]->comment_label = 'comment'; 
      }

      // Add topic text
      $body = field_view_field('node', $node, 'body', 'teaser');
      $vars['topics'][$key]->body = $body;
    }
  }
}
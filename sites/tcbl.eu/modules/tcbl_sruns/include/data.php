<?php

/**
 * Load questions
 */

function _tcbl_sruns_get_questions_nids(){
  $nids = array(
    795, 796, 797, 798, 799, 800
  );
  return $nids;
}

function _tcbl_sruns_get_questions(){
  $nids = _tcbl_sruns_get_questions_nids();
  $nodes = node_load_multiple($nids);
  return $nodes;
}

function _tcbl_sruns_get_progress_data(){
  $nodes = _tcbl_sruns_get_questions();
  $n = 0;
  $build = false;
  foreach ($nodes as $key => $node) {
    $n++;

    // Topics
    if (isset($node->field_ref_topic['und'][0]['tid'])){
      $tid = $node->field_ref_topic['und'][0]['tid'];
    } else {
      continue;
    }
    
    // Topics
    $term = taxonomy_term_load($tid);
    $name = $term->name;
    $build['topics'][$tid] = array(
      'tid' => $tid,
      'name' => $name,
      'on' => false,
    );
    if ($n == 1){
      $build['topics'][$tid]['on'] = true;  
    }
    
    // Questions
    $title = $node->title;
    $build['questions'][$tid] = array(
      'title' => $title,
      'tid' => $tid,
      'build' => node_view($node, 'full'),
      'on' => false,
    );

    if ($n == 1){
      $build['questions'][$tid]['on'] = true;   
    }
    
    // Resources
    $nodes = _tcbl_sruns_get_results_by_tid($tid);
    $build['results'][$tid] = array(
      'tid' => $tid,
      'content' => $nodes,
    );

  }
  return $build;
}

function _tcbl_sruns_get_results_by_tid($tid){
  $nids = _tcbl_sruns_get_nodes_by_tid($tid);
  if ($nids){
    $nodes = node_load_multiple($nids);
    $build = node_view_multiple($nodes, 'teaser');
    return $build;  
  }
  return false;
}

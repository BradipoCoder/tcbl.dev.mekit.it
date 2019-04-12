<?php

/**
 * Query e opzioni
 * passando un array vuoto
 * verranno utilizzati i filtri negli argomenti
 */

function _tcbl_labs_query_nids($form_state, $pager){
  
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array('company'))
    ->propertyCondition('status', NODE_PUBLISHED)
    ->propertyOrderBy('changed', 'DESC');

  if ($pager){
    //$query->addTag('random');
    $query->pager(12);
  }

  $nids = array();
  $query->execute();
  $results = $query->ordered_results;
  foreach ( $results as $node ) {
    array_push ($nids, $node->entity_id );
  }

  return $nids;
}
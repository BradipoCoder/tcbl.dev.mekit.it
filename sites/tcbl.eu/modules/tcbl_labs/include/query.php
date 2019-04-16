<?php

/**
 * Query e opzioni
 * passando un array vuoto
 * verranno utilizzati i filtri negli argomenti
 */

function _tcbl_labs_query_nids($filters){
  $query = db_select('node', 'n');
  $query->fields('n', array('nid','title','created','status', 'type'));
  $query->condition('n.status', true, '=');
  $query->condition('n.type', 'company', '=');

  // Country
  if (isset($filters['country'])){
    $subquery = db_select('location');
    $subquery->addField('location', 'lid');
    $subquery->condition('location.country', $filters['country']);

    // Join Location Table
    $query->join('field_data_field_location', 'loc', 'n.nid = loc.entity_id');
    $query->fields('loc', array('field_location_lid'));
    $query->condition('loc.field_location_lid', $subquery, 'IN');
  }

  // Key activities filter
  if (isset($filters['kas'])){
    $query->join('taxonomy_index', 'ti', 'n.nid = ti.nid');
    $query->condition('ti.tid', $filters['kas'], '=');
  }

  // Key search
  if (isset($filters['key'])){

    $query->join('field_data_body', 'bo', 'n.nid = bo.entity_id');
    $query->fields('bo', array('body_value'));

    $or = db_or();
    $or->condition('n.title', '%' . db_like($filters['key']) . '%', 'LIKE');
    $or->condition('bo.body_value', '%' . db_like($filters['key']) . '%', 'LIKE');
    $query->condition($or); 
  }

  $nids = array();
  $result = $query->execute();
  foreach ($result as $item) {
    $nids[] = $item->nid;
  }
  return $nids;
}

function _tcbl_labs_query_nids_old($filters, $pager){
  
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array('company'))
    ->propertyCondition('status', NODE_PUBLISHED)
    ->propertyOrderBy('changed', 'DESC');

  if (isset($filters['country'])){
    $subquery = db_select('location');
    $subquery->addField('location', 'lid');
    $subquery->condition('location.country', $filters['country']);
    $query->fieldCondition('field_location', 'lid', $subquery, 'IN');
  }

  if (isset($filters['kas'])){
    $query->fieldCondition('field_ref_kas', 'tid', $filters['kas']);  
  }

  if (isset($filters['key'])){
    $query->propertyCondition('title', $filters['key'], 'CONTAINS');
  }

  // if (isset($filters['country'])){
  //   $query->fieldCondition('field_location', 'postal_code', 'ES');
  // }

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


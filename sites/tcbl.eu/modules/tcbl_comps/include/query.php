<?php

/**
 * Query e opzioni
 * passando un array vuoto
 * verranno utilizzati i filtri negli argomenti
 */

function _tcbl_comps_query_nids($filters){
  $query = db_select('node', 'n');
  $query->fields('n', array('nid','title','created','status', 'type'));
  $query->condition('n.status', true, '=');
  $query->condition('n.type', 'company', '=');
  $query->orderBy('title', 'ASC');

  // Country
  if (isset($filters['country']) && $filters['country'] !== 'all'){
    $subquery = db_select('location');
    $subquery->addField('location', 'lid');
    $subquery->condition('location.country', $filters['country']);

    // Join Location Table
    $query->join('field_data_field_location', 'loc', 'n.nid = loc.entity_id');
    $query->fields('loc', array('field_location_lid'));
    $query->condition('loc.field_location_lid', $subquery, 'IN');
  }

  // Taxonomy filters
  $tt = array();
  if (isset($filters['kas']) && $filters['kas'] !== 'all'){
    $tt['kas'] = $filters['kas'];
  }
  if (isset($filters['memb']) && $filters['memb'] !== 'all'){
    $tt['memb'] = $filters['memb'];
    // 28 - labs
    // 60 - associate
  } 

  if (count($tt)){
    foreach ($tt as $key => $value) {
      $field_name = 'field_data_field_ref_' . $key;
      $query->join($field_name, $key, 'n.nid = ' . $key . '.entity_id');
      $col = $key . '.field_ref_' . $key . '_tid'; 
      $query->condition($col, $value, '=');
    }
  }

  // Key search
  if (isset($filters['key']) && $filters['key'] !== 'false'){
    $k = urldecode($filters['key']);
    //dpm($k);
    $query->join('field_data_body', 'bo', 'n.nid = bo.entity_id');
    $query->fields('bo', array('body_value'));

    //$query->join('field_data_title_field', 'tl', 'n.nid = tl.entity_id');
    //$query->fields('tl', array('title_field_value'));

    $or = db_or();
    // Not working in the query.. why?
    $or->condition('n.title', '%' . db_like($k) . '%', 'LIKE');
    //$or->condition('tl.title_field_value', '%' . db_like($k) . '%', 'LIKE');
    $or->condition('bo.body_value', '%' . db_like($k) . '%', 'LIKE');
    $query->condition($or); 
  }

  if (isset($filters['page'])){
    $offset = 8;
    $start = $filters['page'] * $offset - $offset;
    $query->range($start, $offset);
  }

  $nids = array();
  $result = $query->execute()->fetchAll();
  foreach ($result as $item) {
    $nids[] = $item->nid;
  }

  return $nids;
}

/*
function _tcbl_comps_query_nids_old($filters, $pager){
  
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
*/


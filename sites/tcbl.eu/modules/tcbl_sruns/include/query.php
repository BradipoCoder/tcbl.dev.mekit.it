<?php

/**
 * Query
 */

function _tcbl_sruns_get_nodes_by_tid($tid){
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array('resource'))
    ->fieldCondition('field_ref_topics', 'tid', $tid);

  $result = $query->execute();
  if (isset($query->ordered_results)){
    $results = $query->ordered_results;
    $nids = [];
    foreach ( $results as $node ) {
      array_push($nids, $node->entity_id );
    }
    if (count($nids)){
      return $nids;
    }
  }
  return false;
}

/**
function _tcbl_sruns_query_nids($filters){
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

/**
 * Check if the user own some nodes (company | project)
 * @param  $uid of the user
 * @return boolean
 */
/**
function _tcbl_sruns_user_own_nodes($uid){
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array('company', 'project'))
    ->propertyCondition('uid', $uid);

  $query->execute();
  if (isset($query->ordered_results)){
    $results = $query->ordered_results;
    return true;
  } else {
    return false;
  }
}

/**
 * Get nodes owned by the user
 * @param  string $uid  of the user
 * @param  string $type of the node
 * @return array of nids or fale
 */
/**
function _tcbl_sruns_user_get_nodes($uid, $type){
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array($type))
    ->propertyCondition('uid', $uid);

  $query->execute();
  if (isset($query->ordered_results)){
    $results = $query->ordered_results;
    $nids = [];
    foreach ( $results as $node ) {
      array_push($nids, $node->entity_id );
    }
   
    if (count($nids)){
      return $nids;
    }
  }
  return false;
}

/**
 * Return pending labs
 * @param  array $ownNids List of nids owned by a user
 * @return array of nids or false
 */
/**)
function _tcbl_sruns_get_pending_labs($ownNids){
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array('company'))
    ->fieldCondition('field_ref_eval_labs', 'target_id', $ownNids, 'IN')
    ->fieldCondition('field_ref_status', 'tid', '235');

  $query->execute();

  if (isset($query->ordered_results)){
    $results = $query->ordered_results;
    $nids = [];
    foreach ( $results as $node ) {
      array_push($nids, $node->entity_id );
    }
    return $nids;
  }
  return false; 
}*/



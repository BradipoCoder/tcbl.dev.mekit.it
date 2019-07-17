<?php

function _tcbl_comps_get_nodes($nids, $view_mode = 'teaser'){
  $content = array(
    '#prefix' => '<div id="comps-results" class="wrapper-nodes">',
    '#suffix' => '</div>',
    '#weight' => 20,
  );

  if ($nids){
    $nodes = node_load_multiple($nids);
    $content['nodes'] = node_view_multiple($nodes, $view_mode);  
  } else {
    $content['noresults'] = array(
      '#theme' => 'tcbl_comps_noresults',
    );
  }
  
  return $content;
}

function _tcbl_comps_get_maps_data($nids){
  $nodes = node_load_multiple($nids);

  $data = false;
  foreach ($nodes as $key => $node) {
    // Coordinates
    $coord = false;
    if (
      isset($node->field_geolocation['und'][0]['first']) && $node->field_geolocation['und'][0]['first'] &&
      isset($node->field_geolocation['und'][0]['second']) && $node->field_geolocation['und'][0]['second']
    ){
      $geo['latitude'] = $node->field_geolocation['und'][0]['first'];
      $geo['longitude'] = $node->field_geolocation['und'][0]['second'];
      $coord = array($geo['latitude'], $geo['longitude']);
      $data[$key]['coord'] = $coord;
    }

    if ($coord){
      // Title
      $data[$key]['title'] = $node->title; 
      $data[$key]['url'] = url('node/' . $node->nid); 

      // Address
      if (isset($node->field_location['und'][0])){
        $field = $node->field_location['und'][0];
        $plainAddress = _tcbl_company_get_plain_address($field);
        $data[$key]['address'] = $plainAddress;
      }
    }
  }

  return $data;
}

function _tcbl_comps_get_filters($nids){
  $nodes = node_load_multiple($nids);

  $countries = false;
  $kas = false;
  $memb = false;

  foreach ($nodes as $nid => $node) {
    // Contries
    if (isset($node->field_location['und'][0]['country_name'])){
      $country_name = $node->field_location['und'][0]['country_name'];
      $key = $node->field_location['und'][0]['country'];
      $countries[$key] = $country_name;
    }

    // Activities
    if (isset($node->field_ref_kas['und'][0]['tid'])){
      $list = $node->field_ref_kas['und'];
      foreach ($list as $k => $item) {
        $tid = $item['tid'];
        if (!isset($kas[$tid])){
          $term = taxonomy_term_load($tid);
          $kas[$tid] = $term->name;  
        }
      }
    }

    // Member type
    if (isset($node->field_ref_memb['und'][0]['tid'])){
      $list = $node->field_ref_memb['und'];
      foreach ($list as $k => $item) {
        $tid = $item['tid'];
        if (!isset($memb[$tid])){
          $term = taxonomy_term_load($tid);
          $memb[$tid] = $term->name;  
        }
      }
    }
  }

  // Sort countries
  if ($countries){
    ksort($countries);
    foreach ($countries as $mn => $value) {
      $filters['country'][$mn]['title'] = $value;
      $filters['country'][$mn]['selected'] = false;
    }
    // Active item
    if (isset($_GET['country'])){
      $csel = $_GET['country'];
      if (isset($filters['country'][$csel])){
        $filters['country'][$csel]['selected'] = true;  
      }
    }
  } else {
    $filters['country'] = false;
  }
  
  // Sort activities
  if ($kas){
    asort($kas);
    foreach ($kas as $k => $value) {
      $filters['kas'][$k]['title'] = $value;
      $filters['kas'][$k]['selected'] = false;
    }
    // Active item
    if (isset($_GET['kas'])){
      $csel = $_GET['kas'];
      if (isset($filters['kas'][$csel])){
        $filters['kas'][$csel]['selected'] = true;  
      }
    }
  } else {
    $filters['kas'] = false;
  }

  // Sort activities
  if ($memb){
    asort($memb);
    foreach ($memb as $k => $value) {
      $filters['memb'][$k]['title'] = $value;
      $filters['memb'][$k]['selected'] = false;
    }
    // Active item
    if (isset($_GET['memb'])){
      $csel = $_GET['memb'];
      if (isset($filters['memb'][$csel])){
        $filters['memb'][$csel]['selected'] = true;  
      }
    }
  } else {
    $filters['memb'] = false;
  }

  return $filters;
}

// ** UTILITY **
// -------------

function _tcbl_comps_labs_status($node){
  // Only for lab
  if (!_tcbl_comps_is_lab($node)){
    return false;
  }

  // Return the status
  if (isset($node->field_ref_status['und'][0]['tid'])){
    $tid = $node->field_ref_status['und'][0]['tid'];
    $term = taxonomy_term_load($tid);
    $data[$tid] = $term->name;
    return $data;
  }

  return false;
}

function _tcbl_comps_is_lab($node){
  if (isset($node->field_ref_memb['und'][0]['tid']) && $node->field_ref_memb['und'][0]['tid'] == '28'){
    return true;
  }
  return false;
}

/**
 * Check if a lab is waiting for approval by the user
 * @param  [type]  $node [description]
 * @return boolean       [description]
 */
function _is_this_lab_waiting_for_approval_by_user($lab, $uid){
  // Not Jesse
  if ($uid !== '65'){
    // Get his nodes (labs)
    $ownLabs = _tcbl_comps_user_get_nodes($uid, 'company');
    
    if ($ownLabs){
      // Pending nids waiting for him
      $pendingNids = _tcbl_comps_get_pending_labs($ownLabs);
      if ($pendingNids){
        foreach ($pendingNids as $key => $nid) {
          if ($lab->nid == $nid){
            $delta = _tcbl_comps_get_lab_deltas($lab, $ownLabs);
            if ($delta){
              foreach ($delta as $n => $item) {
                $field_name = 'field_eval_' . $item['key'];
                if (isset($node->$field_name['und'][0]['value']) && $node->$field_name['und'][0]['value'] == true){
                  // yet approved
                  return false;
                } else {
                  // to approve
                  return true;  
                }
              }
            } 
          }
        }
      }  
    }
  }

  // Jesse approval
  if ($uid == '65'){
    if (isset($node->field_eval_tcbl['und'][0]['value']) && $node->field_eval_tcbl['und'][0]['value'] == true){
      return false;
    } else {
      return true;  
    }
  }

  return false;
}

/**
 * Approve lab by nid and uid
 * @param  [type] $nid [description]
 * @param  [type] $uid [description]
 * @return [type]      [description]
 */
function _tcbl_lab_approve_lab_by_uid($nid, $uid){
  $lab = node_load($nid);
  $jobDone = false;

  // Not Jesse
  if ($uid !== '65'){
    // Get his nodes (labs)
    $ownLabs = _tcbl_comps_user_get_nodes($uid, 'company');
    if ($ownLabs){
      // Pending nids waiting for him
      $pendingNids = _tcbl_comps_get_pending_labs($ownLabs);
      if ($pendingNids){
        // Approve every possibile
        foreach ($pendingNids as $key => $nid) {
          if ($lab->nid == $nid){
            $delta = _tcbl_comps_get_lab_deltas($lab, $ownLabs);
            if ($delta){
              foreach ($delta as $n => $item) {
                // Set the relative field to true
                $field_name = 'field_eval_' . $item['key'];
                $lab->$field_name['und'][0]['value'] = true;
                node_save($lab);
                $jobDone = true;
              }
            }
          }
        }
      }
    }
  }

  // Jesse
  if ($uid == '66'){
    $lab->field_eval_tcbl['und'][0]['value'] = true;
    node_save($lab);
    $jobDone = true;
  }

  // Check if we need to publish the lab
  // this is done by rules
  // $result = _tcbl_comps_approve_lab($lab);
  // if ($result){
  //   $jobDone = true;
  // }
  
  return $jobDone;
}

/**
 * Programmatically pubblish the lab (deprecated, we are using rules)
 * @param  [type] $lab [description]
 * @return true or false
 */
function _tcbl_comps_approve_lab($lab){
  $n = _tcbl_comps_missing_check_to_complete($lab);
  if ($n == 0){
    $lab->field_ref_status['und'][0]['tid'] = '236';
    $lab->status = 1;
    node_save($lab);
    return true;
  }
  return false;
}

/**
 * Return an integer indicating the missing check to complete the approval process
 * @param  [type] $lab [description]
 * @return integer $n;
 */
function _tcbl_comps_missing_check_to_complete($lab){
  $list = array(
    '1', '2', 'tcbl',
  );

  $n = 3;
  foreach ($list as $key => $name) {
    $fieldName = 'field_eval_' . $name;
    if (isset($lab->$fieldName['und'][0]['value']) && $lab->$fieldName['und'][0]['value']){
      $n--;
    }
  }
  return $n;
}

function _tcbl_comps_get_labs_approval_status_report_table($lab){
  $data = _tcbl_comps_get_labs_approval_status_report($lab);
  if ($data){
    $build = array(
      '#theme' => 'table',
    );
    foreach ($data as $key => $item) {
      $build['#rows'][$key]['title'] = $item['title'];
      if ($item['approved']){
        $build['#rows'][$key]['status'] = '<i class="fa fa-check-circle"></i>';  
      } else {
        $build['#rows'][$key]['status'] = 'Not yet approved';  
      }
    }
    return $build;
  }
  return false;
}

/**
 * Get the status report data for the lab
 * @param  [type] $lab [description]
 * @return [type]      [description]
 */
function _tcbl_comps_get_labs_approval_status_report($lab){
  $result = array();
  if (isset($lab->field_ref_eval_labs['und'][0])){
    foreach ($lab->field_ref_eval_labs['und'] as $key => $item) {
      $k = $key + 1;
      $nid = $item['target_id'];
      $tmpLab = node_load($nid);
      $result[$nid]['title'] = $tmpLab->title;
      $fieldName = 'field_eval_' . $k;

      $result[$nid]['approved'] = false;
      if (isset($lab->$fieldName['und'][0]['value']) && $lab->$fieldName['und'][0]['value']){
        $result[$nid]['approved'] = true;
      }
    }
  } else {
    return false;
  }

  $result['tcbl']['approved'] = false;
  $result['tcbl']['title'] = 'TCBL Foundation committee';
  if (isset($lab->field_eval_tcbl['und'][0]['value']) && $lab->field_eval_tcbl['und'][0]['value']){
    $result['tcbl']['approved'] = true;
  }
  return $result;
}

/**
 * Get delta position of the node
 * @param  [type] $lab      Lab to evaluate
 * @param  [type] $ownLabs  List of nids owned by a user
 * @return return delta (0, 1);
 */
function _tcbl_comps_get_lab_deltas($lab, $ownLabs){
  $ownLabs = array_values($ownLabs);

  $delta = false;
  
  if (isset($lab->field_ref_eval_labs['und'][0])){
    foreach ($lab->field_ref_eval_labs['und'] as $key => $item) {
      $nid = $item['target_id'];

      if (in_array($nid, $ownLabs)){
        // Get the delta for the boolean field
        $tmpDelta = $key + 1;
        
        // Check the value
        $value = _tcbl_labs_get_evaluation_delta_value($lab, $tmpDelta);
        if (!$value){
          $delta[] = array(
            'key' => $tmpDelta,
            'nid' => $nid,
          );
        }
      }
    }
  }
  return $delta;
}

function _tcbl_labs_get_evaluation_delta_value($node, $delta){
  $fieldName = 'field_eval_' . $delta;
  if (isset($node->$fieldName['und'][0]['value']) && $node->$fieldName['und'][0]['value']){
    return true;
  }
  return false;
}

function _is_this_lab_mine($node){
  global $user;
  if ($node->uid == $user->uid){
    return true;
  }
  return false;
}
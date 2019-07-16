<?php

// ** ----- DASHBOARD -----
// ------------------------

function tcbl_comps_dashboard(){

  $content['title']['#markup'] = '<h2>My dashboard</h2>';

  global $user;
  $uid = $user->uid;

  $content['projects'] = false;
  $content['pending'] = false;
  $comp_nids = _tcbl_comps_user_get_nodes($uid, 'company');
  if ($comp_nids) {
    // Labs owned by the user
    $comps = node_load_multiple($comp_nids);
    $content['comps'] = node_view_multiple($comps, 'teaser');

    // Check for labs in pending status
    $pendingNids = _tcbl_comps_get_pending_labs($comp_nids);
    if ($pendingNids){
      $pendingNodes = node_load_multiple($pendingNids);
      $content['pending'] = node_view_multiple($pendingNodes, 'teaser');  
    }
  }

  $project_nids = _tcbl_comps_user_get_nodes($uid, 'project');
  if ($project_nids) {
    $projects = node_load_multiple($project_nids);
    $content['projects'] = node_view_multiple($projects, 'child');
  }

  $build = array(
    '#theme' => 'tcbl_comps_dashboard',
    '#content' => $content,
  );

  return $build;
}

function _tcbl_comps_dashboard_access(){
  global $user;
  $roles = $user->roles;

  if (isset($roles[8])){
    $own_nodes = _tcbl_comps_user_own_nodes($user->uid);
    return $own_nodes;
  }

  return false;
}



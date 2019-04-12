<?php

function _tcbl_labs_get_nodes(){
  $nids = _tcbl_labs_query_nids(array(), true);
  $nodes = node_load_multiple($nids);
  $content = array(
    '#prefix' => '<div class="wrapper-nodes">',
    '#suffix' => '</div>',
    '#weight' => 20,
  );
  $content['nodes'] = node_view_multiple($nodes, 'teaser');
  return $content;
}

function _tcbl_labs_get_maps_data(){
  $nids = _tcbl_labs_query_nids(array(), true);
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
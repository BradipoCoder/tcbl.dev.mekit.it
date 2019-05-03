<?php

function _tcbl_labs_get_nodes($nids, $view_mode = 'teaser'){
  $content = array(
    '#prefix' => '<div id="labs-results" class="wrapper-nodes">',
    '#suffix' => '</div>',
    '#weight' => 20,
  );

  if ($nids){
    $nodes = node_load_multiple($nids);
    $content['nodes'] = node_view_multiple($nodes, $view_mode);  
  } else {
    $content['noresults'] = array(
      '#theme' => 'tcbl_labs_noresults',
    );
  }
  
  return $content;
}

function _tcbl_labs_get_maps_data($nids){
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

function _tcbl_labs_get_filters($nids){
  $nodes = node_load_multiple($nids);

  $countries = false;
  $kas = false;
  foreach ($nodes as $nid => $node) {
    if (isset($node->field_location['und'][0]['country_name'])){
      $country_name = $node->field_location['und'][0]['country_name'];
      $key = $node->field_location['und'][0]['country'];
      $countries[$key] = $country_name;
    }

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
  }

  if ($countries){
    // Sort countries
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
  return $filters;
}
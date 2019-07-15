<?php

// ** ----- EVALUATION PROCESS -----
// ---------------------------------

// ** FIRST STEP **
// ----------------
// path: /labs-eval/%nid

function tcbl_lab_evalution_page($nid){

  $lab = node_load($nid);
  $content['name']['#markup'] = $lab->title;

  $content['labform'] = drupal_get_form('tcbl_lab_evaluation_form', $lab);

  $build = array(
    '#theme' => 'tcbl_lab_evaluation',
    '#content' => $content,
  );
  
  return $build;
}

/**
 * Returns the render array for the form.
 */
function tcbl_lab_evaluation_form($form, &$form_state, $lab) {
  
  $currentLab = $lab;
  $currentLabNid = $lab->nid;

  $filters['memb'] = 28;
  $labNids = _tcbl_comps_query_nids($filters);
  
  if (isset($labNids[$currentLabNid])){
    unset($labNids[$currentLabNid]);
  }

  $labs = node_load_multiple($labNids);
  foreach ($labs as $key => $node) {
    $options[$key] = $node->title;
  }

  $form_state['#lab_nid'] = $currentLabNid;

  $form['lab_1'] = array(
    '#type' => 'select',
    '#title' => t('Lab 1'),
    '#options' => $options,
    '#required' => true,
  );

  $form['lab_2'] = array(
    '#type' => 'select',
    '#title' => t('Lab 2'),
    '#options' => $options,
    '#required' => true,
  ); 

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Next'),
  );

  return $form;
}

/**
 * Validates the form.
 */
function tcbl_lab_evaluation_form_validate($form, &$form_state) {
  if ($form_state['values']['lab_1'] == $form_state['values']['lab_2']){
    form_set_error('lab_2', t('You have to choose two different Labs'));  
  }
}

/**
 * Add a submit handler/function to the form.
 */
function tcbl_lab_evaluation_form_submit($form, &$form_state) {
  $lab_nid = $form_state['#lab_nid'];
  $nid_1 = $form_state['values']['lab_1'];
  $nid_2 = $form_state['values']['lab_2'];
  drupal_goto('labs-eval-end/' . $lab_nid . '/' . $nid_1 . '/' . $nid_2);
}

// ** SECOND STEP **
// -----------------
// path: /labs-eval/%nid/end/%lab1/%lab2

function tcbl_lab_evalution_page_end($labNid, $lab1Nid, $lab2Nid){
  
  $build['#markup'] = '<code>error</code>';

  $lab = node_load($labNid);
  $content['name']['#markup'] = $lab->title;

  $lab1 = node_load($lab1Nid);
  $lab2 = node_load($lab2Nid);

  if ( 
    ($lab1 && ($lab1->type == 'company')) && 
    ($lab2 && ($lab2->type == 'company'))
  ){

    $wnode = node_load(787);
    $form = drupal_get_form('webform_client_form_' . $wnode->nid, $wnode, array());
    $content['webform'] = $form;

    $build = array(
      '#theme' => 'tcbl_lab_evaluation_end',
      '#content' => $content,
    );
  }
  
  return $build;
}

function tcbl_comps_form_webform_client_form_787_alter(&$form, &$form_state, $form_id){
  $lab = arg(1);
  
  $lab1Nid = arg(2);
  $lab1 = node_load($lab1Nid);
  $lab2Nid = arg(3);
  $lab2 = node_load($lab2Nid);

  // Fill lab 1 value
  $form['submitted']['lab_1_nid']['#default_value'] = $lab1->nid;
  $form['submitted']['lab_1_name']['#default_value'] = $lab1->title;
  $form['submitted']['lab_1_mail']['#default_value'] = tcbl_lab_get_lab_manager_mail($lab1);

  // Fill lab 2 value
  $form['submitted']['lab_2_nid']['#default_value'] = $lab2->nid;
  $form['submitted']['lab_2_name']['#default_value'] = $lab2->title;
  $form['submitted']['lab_2_mail']['#default_value'] = tcbl_lab_get_lab_manager_mail($lab2);

}

function tcbl_lab_get_lab_manager_mail($lab){
  if (isset($lab->field_ref_user['und'][0]['target_id'])){
    $uid = $lab->field_ref_user['und'][0]['target_id'];
    $user = user_load($uid);
    return $user->mail;
  }
  return false;
}

/**
 * TCBL Evaualuation page access
 * @return [type] [description]
 */
function tcbl_lab_evalution_page_access(){
  global $user;
  $roles = $user->roles;

  $nid = arg(1);
  $lab = node_load($nid);

  // Company manager
  if (isset($roles[8])){
    if ($lab->uid == $user->uid){
      return true;
    }  
  }

  // Administrators or editor
  if (isset($roles[3]) || isset($roles['4'])){
    return true;
  }

  return false;
}

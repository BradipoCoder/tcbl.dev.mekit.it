<?php

function _tcbl_kas_get_fields_name_from_tid($tid){
  switch ($tid) {
    case '45': // Business support
      $data['prefix'] = 'b';
      $data['fields'] = array(
        'startups',
        'business_planning',
        'funding_support',
        'marketing_support',
        'design_and_man_sup',
      ); 
      break;
    
    default:
      $data = false;
      break;
  }

  return $data;
}
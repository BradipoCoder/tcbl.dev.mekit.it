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

    case '46': // Creative Hub
      $data['prefix'] = 'c';
      $data['fields'] = array(
        'creative_sector',
        'field_l_c_regional_stakeholders',
        'field_longtext_c_setup',
        'regional_stakeholders',
        'setup',
        'services_offered',
        'main_results',
      );
      break;

    case '47': // Social
      $data['prefix'] = 's';
      $data['fields'] = array(
        'materials',
        'nanotechnology',
        'smart_fun_text',
        'circular_eco',
        'processing',
        'ict',
        'ty_of_res_per',
      );
      break;

    case '49': // Research
      $data['prefix'] = 'r';
      $data['fields'] = array(
        'creative',
        'material',
        'technical_scient',
      );
      break;

    case '48': // Teaching / Training
      $data['prefix'] = 't';
      $data['fields'] = array(
        'business',
        'technology',
        'clothing',
        'textiles',
        'training_style',
      );
      break;

    case '50': // Production
      $data['prefix'] = 'p';
      $data['fields'] = array(
        'mat_worked_with',
        'product_creation',
        'production_type',
        'prod_facilities',
        'prod_capability',
        'production_style',
        'technologies',
      );
      break;

    default:
      $data = false;
      break;
  }

  return $data;
}
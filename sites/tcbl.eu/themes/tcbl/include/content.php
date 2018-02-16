<?php

/**
 * @file
 * content.php
 */

function _tcbl_add_header(&$vars){
  // Page title
  $vars['page_title'] = false;
  $node = menu_get_object();
  if ($node){
    $vars['page_title'] = $node->title;
  }

  // Date
  $vars['date'] = false;
  if ($node && $node->type == 'blog'){
    if (isset($node->field_submitted['und'][0])){
      $date = field_view_field('node', $node, 'field_submitted', 'default');
      $vars['date'] = $date;
    }
  }
}

function _tcbl_alter_breadcrumbs(&$vars){
  if (isset($vars['node'])){
    $node = $vars['node'];
    if ($node->type == 'forum'){
      $bcs = [];
      $bcs[] = t('Home');
      $bcs[] = l('Community', 'node/325');
      $bcs[] = l('Forum', 'node/327');
      drupal_set_breadcrumb($bcs);
    }
  }
}

function _tcbl_faq_link(){
  $text = '<i class="fa fa-question-circle-o"></i> FAQ';
  $data = array(
    '#prefix' => '<div class="wrapper-faq-link margin-b-1 text-right"><span class="h4 small">',
    '#suffix' => '</span></div>',
    '#markup' => l($text, 'node/328', array('html' => TRUE)),
  );
  return $data;
}


// ** DROP ? **
// ------------

function _tcbl_add_button(&$vars){
  if (isset($vars['content']['field_button'][0]['#markup']) && $vars['content']['field_button'][0]['#markup'] !== ''){
    $opt = array(
      'attributes' => array(
        'class' => array('btn', 'btn-primary'),
      ),
    );
    $txt = $vars['content']['field_button'][0]['#markup'];
    $vars['content']['field_button'] = array(
      '#prefix' => '<div class="wrapper-button text-center margin-b-1">',
      '#suffix' => '</div>',
      '#markup' => l ($txt, 'node/' . $vars['nid'], $opt),
      '#weight' => 15,
    );
  }
}

function _tcbl_display_as_hover_box(&$vars){
  $node = $vars['node'];
  $style_name = 'square';

  $link  = array(
    'img' => array(
      '#theme' => 'image_style',
      '#style_name' => $style_name,
      '#path' => $node->field_img['und'][0]['uri'],
      //'#attributes' => array(
      //  'class' => array('hidden-xs', 'hidden-sm', 'hidden-md'),
      //),
    ),
    'hover' => array(
      '#prefix' => '<span class="hover-box__hover"><span class="hover-box__wrapper">',
      '#suffix' => '</span></span></span>',
    ),
  );

  if (isset($vars['content']['title_field'][0]['#markup'])){
    $title = $vars['content']['title_field'][0]['#markup'];
    $link['hover']['title'] = array(
      '#prefix' => '<span class="hover-box__title">',
      '#suffix' => '</span>',
      '#markup' => $title,
    );
  }

  $vars['content']['wrapper_img'] = array(
    '#prefix' => '<div class="wrapper-hover-box fx-img-zoom-simple">',
    '#suffix' => '</div>',
    'hover' => array(
      '#markup' => l(render($link), 'node/' . $node->nid, array('html' => TRUE)),
    ),
  );
  unset($vars['content']['field_img']);
  unset($vars['content']['title_field']);
}

function _tcbl_post_category_and_date(&$vars){
  $node = $vars['node'];

  if (isset($vars['content']['field_date'][0]['#markup'])){
    $date = ' ' . $vars['content']['field_date'][0]['#markup'];
  }

  if (isset($node->field_ref_cat['und'][0]['tid'])){
    $tid = $node->field_ref_cat['und'][0]['tid'];
    $term = taxonomy_term_load($tid);
  }

  if (isset($date) && isset($term)){

    $opt = array(
      'attributes' => array(
        'class' => array('cat-link'),
      ),
      'query' => array(
        'cat' => $term->tid,
      ),
    );

    $vars['content']['cat_date'] = array(
      '#prefix' => '<div class="wrapper-cat-date">',
      '#suffix' => '</div>',
      'cat' => array(
        '#markup' =>  l($term->name, 'node/3', $opt),
      ),
      'date' => array(
        '#markup' => $date,
      ),
    );
  }
}

function _tcbl_post_category_btm(&$vars){
  $node = $vars['node'];
  if (isset($node->field_ref_cat['und'][0]['tid'])){
    $tid = $node->field_ref_cat['und'][0]['tid'];
    $term = taxonomy_term_load($tid);

    $opt = array(
      'html' => TRUE,
      'query' => array(
        'cat' => $tid,
      ),
    );

    $text = ' – Archivio attività <i class="fa fa-chevron-circle-right"></i>';

    $vars['content']['cat_link'] = array(
      '#markup' => l($term->name . $text, 'node/3', $opt),
    );

  }
}

function _tcbl_post_short_title(&$vars){
  $node = $vars['node'];
  if (isset($node->title)){
    $title = $node->title;
    if (strlen($title) >= 75){
      $title = trim(substr($title, 0, 75)) . '...';
      $vars['content']['title_field'][0] = array(
        '#prefix' => '<h4>',
        '#suffix' => '</h4>',
        '#markup' => l($title, 'node/' . $node->nid),
      );
    }
  }
}

function _tcbl_add_posts_by_category(&$vars){
  $node = $vars['node'];

  $opt = array(
    'attributes' => array(
      'class' => array('btn', 'btn-primary'),
    ),
  );

  $arg = false;

  if (isset($node->field_ref_cats['und'][0])){
    $cats = $node->field_ref_cats['und'];
    foreach ($cats as $key => $cat) {
      $tids[] = $cat['tid'];
    }
    $arg = implode($tids, '+');
  }

  $view = views_get_view_result('posts', 'default', $arg);
  $result = count($view);

  if ($result){
    $views = views_embed_view('posts', 'default', $arg);

    $vars['content']['related'] = array(
      'title' => array(
        '#prefix' => '<h2 class="text-center margin-v-2">',
        '#suffix' => '</h2>',
        '#markup' => 'Attività in "' . $node->title . '"',
      ),
      'content' => array(
        '#markup' => $views,
      ),
      'more' => array(
        '#prefix' => '<div class="wrapper-button text-center margin-b-1">',
        '#suffix' => '</div>',
        '#markup' => l ('Archivio attività', 'node/3', $opt),
        '#weight' => 15,
      ),
      '#weight' => 14,
    );
  }
}

function _tcbl_fancy_share(&$vars){
  $node = $vars['node'];

  $vars['content']['share'] = array(
    '#prefix' => '<div class="wrapper-share">',
    '#suffix' => '</div>',
    'link' => array(
      '#prefix' => '<p class="text-caps text-share">',
      '#suffix' => '</p>',
      'share' => _tcbl_share($vars),
    ),
    '#weight' => 9,
  );
  $vars['content']['social']['#printed'] = true;
}

function _tcbl_share($vars){
  $opt = array(
    'html' => true,
    'fragment' => ' ',
    'absolute' => true,
    'attributes' => array(
      'class' => array(
        'a-share',
      ),
    ),
  );
  $i = '<i class="fa fa-share-alt fa-fw"></i>';
  $share = array(
    '#prefix' => '<span class="wrapper-social-toggle">',
    '#suffix' => '</span>',
    'link' => array(
      '#markup' => l($i . ' Condividi', '', $opt),
    ),
    'social' => $vars['content']['social'],
  );
  return $share;
}

function _tcbl_alter_pagination(&$vars, $title = TRUE){
  if (isset($vars['pagination']['next'])){
    $prev = node_load($vars['pagination']['prev']);
    $next = node_load($vars['pagination']['next']);

    if ($title){

      $n_text = $next->title;
      if (strlen($n_text) > 35){
        $n_text = substr($n_text,0,35).'...';
      }

      $p_text = $prev->title;
      if (strlen($p_text) > 35){
        $p_text = substr($p_text,0,35).'...';
      }

      $t_prev = '<i class="fa fa-angle-left fa-fw"></i> <span class="text-caps">' . $p_text . '</span>';
      $t_next = '<span class="text-caps">' . $n_text . '</span> <i class="fa fa-angle-right fa-fw"></i>';
    } else {
      $t_prev = '<i class="fa fa-angle-left fa-fw"></i> <span class="text-caps">Precedente</span>';
      $t_next = '<span class="text-caps">Successivo</span> <i class="fa fa-angle-right fa-fw"></i>';
    }

    $vars['content']['pager']['#prefix'] = '<div class="nhc-pager row margin-b-1">';

    $vars['content']['pager']['prev']['#text'] = '<span class="small">' . $t_prev . '</span>';
    $vars['content']['pager']['next']['#text'] = '<span class="small">' . $t_next . '</span>';
  }
}

// ** MACHINE PROCESS **
// ---------------------

/**
 * Gets all section nodes
 */
function _tcbl_get_news(){
  // Get all nodes related by region
  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', array('blog'))
    ->propertyCondition('status', NODE_PUBLISHED);
    
    //->fieldOrderBy('field_photo', 'fid', 'DESC')
  if (isset($options['ref_nid'])){
    $query->fieldCondition('field_ref_brand', 'target_id', $options['ref_nid']);
  }
  $query->addMetaData('account', user_load(1)); // Run the query as user 1.
  $query->execute();

  if (isset($query->ordered_results)){
    $nodes = $query->ordered_results;
    $nodes_id = array();
    foreach ( $nodes as $node ) {
      array_push ($nodes_id, $node->entity_id );
    }
    $nodes = node_load_multiple($nodes_id);
  } else {
    $nodes = false;
  }
  return $nodes;
}
<?php

/**
 * @file
 * page.php
 */

/**
 * Preprocess node page
 * @param  [type] &$vars [description]
 * @return [type]        [description]
 */
function _tcbl_preprocess_node_page(&$vars){
  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-sm-6';
    $vars['classes_array'][] = 'col-md-4';
  }

  _tcbl_add_button($vars);

  if ($vars['nid'] == 5){
    _tcbl_preprocess_node_page_contatti($vars);
  }

  if ($vars['nid'] == 3){
    _tcbl_preprocess_node_page_attivita($vars);
  }

  if ($vars['nid'] == 4){
    _tcbl_preprocess_node_page_gruppo($vars);
  }

  if ($vars['nid'] == 47){
    _tcbl_preprocess_node_page_press($vars);
  }

}

function _tcbl_preprocess_node_page_contatti(&$vars){
  $vars['classes_array'][] = 'negative';

  _tcbl_alter_contatti_layout($vars);

  $n_form = node_load(20);
  $n_form_view = node_view($n_form);
  $vars['content']['webform'] = $n_form_view;
  $vars['content']['webform']['#prefix'] = '<div class="wrapper-form margin-t-2">';
  $vars['content']['webform']['#suffix'] = '</div>';
  $vars['content']['webform']['#weight'] = 8;
}

function _tcbl_alter_contatti_layout(&$vars){
  $node = $vars['node'];

  $vars['content']['title_field'][0]['#markup'] = '<h3 class="margin-t-0">Contatti</h3>';

  $vars['content']['field_short'] = array(
    '#prefix' => '<div class="lead"><p>',
    '#suffix' => '</p></div>',
    '#markup' => $vars['content']['field_short'][0]['#markup'],
  );

  $cts = node_load(20);
  $contatti = field_view_field('node', $cts, 'field_short');
  $contatti['#label_display'] = 'hidden';
  $vars['content']['contacts'] = $contatti;
}

function _tcbl_preprocess_node_page_attivita(&$vars){
  if ($vars['view_mode'] == 'full'){
    _tcbl_create_menu_cat($vars);

    unset($vars['content']['children']);
    unset($vars['content']['title_field']);

    $arg = 'all';
    if (isset($_GET['cat'])){
      $arg = $_GET['cat'];
    }

    $view = views_get_view_result('posts_archive', 'default', $arg);
    $result = count($view);

    if ($result){
      $views = views_embed_view('posts_archive', 'default', $arg);
      $vars['content']['posts']['#markup'] = $views;
      $vars['content']['posts']['#weight'] = 8;

      add_same_h_by_selector('.view-posts-archive');
    }

  }
}

function _tcbl_preprocess_node_page_press(&$vars){
  if ($vars['view_mode'] == 'full'){
    _tcbl_alter_press_layout($vars);

    $n_form = node_load(20);
    $n_form_view = node_view($n_form);
    $vars['content']['webform'] = $n_form_view;
    $vars['content']['webform']['#prefix'] = '<div class="wrapper-form margin-t-2">';
    $vars['content']['webform']['#suffix'] = '</div>';
    $vars['content']['webform']['#weight'] = 8;

    $arg = 'all';
    if (isset($_GET['cat'])){
      $arg = $_GET['cat'];
    }

    $view = views_get_view_result('posts_archive', 'default', $arg);
    $result = count($view);

    if ($result){
      $views = views_embed_view('posts_archive', 'default', $arg);
      $vars['content']['posts']['#markup'] = $views;
      $vars['content']['posts']['#weight'] = 8;

      add_same_h_by_selector('.view-posts-archive');
    }
  }
}

function _tcbl_alter_press_layout(&$vars){
  $node = $vars['node'];

  $vars['content']['title_field'][0]['#markup'] = '<h3 class="margin-t-0">Press</h3>';

  $vars['content']['field_short'] = array(
    '#prefix' => '<div class="lead"><p>',
    '#suffix' => '</p></div>',
    '#markup' => $vars['content']['field_short'][0]['#markup'],
  );

  //$cts = node_load(20);
  //$contatti = field_view_field('node', $cts, 'field_short');
  //$contatti['#label_display'] = 'hidden';
  $vars['content']['contacts'] = $vars['content']['field_content'];
}

function _tcbl_create_menu_cat(&$vars){

  $arg = 'all';
  if (isset($_GET['cat'])){
    $arg = $_GET['cat'];
  }

  $opt = array(
    'attributes' => array(
      'class' => array('a-cat'),
    ),
  );

  if ($arg == 'all'){
    $opt['attributes']['class'][] = 'cat-active';
  }

  $vars['content']['cat_menu'] = array(
    '#prefix' => '<div class="wrapper-menu-cat text-center">',
    '#suffix' => '</div>',
    '#weight' => 4,
    'list' => array(
      '#prefix' => '<ul class="menu-cat">',
      '#suffix' => '</ul>',
      'all' => array(
        '#prefix' => '<li class="li-cat">',
        '#suffix' => '</li>',
        '#markup' => l('Tutti', 'node/3', $opt),
      ),
    ),
  );

  $categories = _tcbl_archive_category_list();

  foreach ($categories as $key => $cat){

    $opt = array(
      'attributes' => array(
        'class' => array(
          'a-cat',
        ),
      ),
      'query' => array(
        'cat' => $key,
      ),
      'html' => TRUE,
    );

    if ($key == $arg){
      $opt['attributes']['class'][] = 'cat-active';
    }

    $vars['content']['cat_menu']['list'][$key] = array(
      '#prefix' => '<li class="li-cat">',
      '#suffix' => '</li>',
      '#markup' => l($cat['name'] . ' <span>(' . $cat['number']  . ')</span>', 'node/3', $opt)
    );
  }
}

/**
 * Categorie Post
 */
function _tcbl_archive_category_list(){

  $query = db_select('taxonomy_term_data', 't');
  $query->fields('t', array('tid','name'));
  $query->condition('t.vid', 1, '=');
  $query->join('taxonomy_index', 'ti', 't.tid = ti.tid');
  $query->join('node', 'n', 'n.nid = ti.nid');
  $query->fields('n', array('type'));
  $query->condition('type', 'post', '=');

  $result = $query->execute();

  foreach ($result as $item) {
    $tid = $item->tid;
    $categories[$tid]['name'] = $item->name;
    if (isset($categories[$tid]['number'])){
      $categories[$tid]['number'] = $categories[$tid]['number'] + 1;
    } else {
      $categories[$tid]['number'] = 1;
    }
  }

  return $categories;
}


function _tcbl_preprocess_node_page_gruppo(&$vars){
  if ($vars['view_mode'] == 'teaser'){
    //_tcbl_add_member_slider($vars);
    $vars['content']['children']['#printed'] = true;
  }

  if ($vars['view_mode'] == 'full'){
    unset($vars['content']['children']);
    //_tcbl_format_children_by_cat($vars);
    $head = array(
      'title' => array(
        '#markup' => '<h3 class="text-center">Contatti</h3>',
      ),
      'desc' => array(
        '#markup' => '<p class="text-center lead">Entra a far parte del nostro gruppo</p>',
      ),
    );
    _tcbl_add_bottom_form_negative($vars, $head);
  }
}

function _tcbl_format_children_by_cat(&$vars){
  $node = $vars['node'];

  $cats = array(
    '12' => 'Produttori',
    '13' => 'Gruppi',
    '14' => 'Rivenditori',
  );

  foreach ($cats as $key => $name) {
    $opt = array(
      'filter_by_term' => $key,
    );
    $data[$key] = get_children_by_pnid($node->nid, $opt);
  }

  foreach ($data as $k => $nids) {
    if (!empty($nids)){

      $list[$k]['title'] = array(
        '#prefix' => '<h4 class="text-center">',
        '#suffix' => '</h4>',
        '#markup' => $cats[$k],
      );


      $list[$k]['nodes'] = array(
        '#prefix' => '<div class="wrapper-children-member wcm-' . $k . ' row margin-b-2">',
        '#suffix' => '</div>',
      );

      $childs = node_load_multiple($nids);
      foreach ($childs as $e => $child) {
        $list[$k]['nodes'][$e] = node_view($child, 'child');
      }
    }
  }

  $vars['content']['list'] = array(
    '#prefix' => '<hr class="margin-v-2">',
    'data' => $list,
    '#weight' => 7,
  );

  unset($vars['content']['children']);
}
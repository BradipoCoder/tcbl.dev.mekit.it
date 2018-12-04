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

    // Date
    $vars['date'] = false;
    if ($node && $node->type == 'blog'){
      if (isset($node->field_submitted['und'][0])){
        $date = field_view_field('node', $node, 'field_submitted', 'default');
        $vars['date'] = $date;
      }
    }

    _tcbl_event_header($vars, $node);

    // Alter title for day content
    if ($node->type == 'day'){
      if (isset($node->nodehierarchy_menu_links[0]['pnid'])){
        $cnid = $node->nodehierarchy_menu_links[0]['pnid'];
        $conference = node_load($cnid);
        $vars['page_title'] = $conference->title;
      }
    }

    if ($node->nid == 312){
      _tcbl_event_news_archive($vars);
    }
  }
}

function _tcbl_event_header(&$vars, $node){
  $vars['header_event'] = array();
  if ($node->type == 'event'){

    if (isset($node->field_date['und'][0])){
      $date = field_view_field('node', $node, 'field_date', 'default');
      $vars['header_event']['date'] = array(
        '#prefix' => '<h5 class="margin-v-0">',
        '#suffix' => '</h5>',
        'item' => $date[0],
      );
    }

    // Address
    if (isset($node->field_location['und'][0])){
      $address = _tcbl_calculate_address_array($node);
      if (!empty($address)){


        $full_address = implode($address, ' ');
        $path = 'https://www.google.it/maps?q=' . $full_address;

        // City
        if (isset($address['city'])){
          $addr['city'] = array(
            '#prefix' => '<h5 class="margin-b-0">',
            '#suffix' => '</h5>',
            '#markup' => '<a href="' . $path . '" class="text-primary" target="_blank">' . $address['city'] . '</a>',
          );  
        }

        if (isset($address['street']) && isset($address['city'])){
          $addr['street'] = array(
            '#prefix' => '<p class="text-primary small margin-b-0">',
            '#suffix' => '</p>',
            '#markup' =>  $address['street'] . ' - ' . $address['city'],
          );  
        }

        if (!empty($address)){
          $addr['#prefix'] = '<div class="wrapper-address">';
          $addr['#suffix'] = '</div>';

          global $base_url;
          $path = $base_url . '/' . drupal_get_path('theme', 'tcbl') . '/img/map-marker.png';
          $addr['icon']['#markup'] = '<img src="' . $path . '"/>';

          $vars['header_event']['address'] = $addr;
        }
      }
    }

    if (user_is_logged_in()){
      // TCBL Contact
      if (isset($node->field_tcbl_contact['und'][0]['uid'])){
        $uid = $node->field_tcbl_contact['und'][0]['uid'];
        $tcbl_contact = user_load($uid);
        $name = $tcbl_contact->name;
        if (isset($tcbl_contact->realname)){
          $name = $tcbl_contact->realname;
        }

        $opt = array(
          'attributes' => array(
            'class' => array(
              'h4', 'text-primary',
            ),
          ),
        );

        $vars['header_event']['contact'] = array(
          '#prefix' => '<div class="tcbl-contact">',
          '#suffix' => '</div>',
          'contact' => array(
            '#prefix' => '<p class="small text-right text-xs-left text-muted">',
            '#suffix' => '</p>',
            '#markup' => 'TCBL Contact: ' . l($name, 'user/' . $tcbl_contact->uid, $opt),
          ),
        );
      } 
    }
    
  }
}

function _tcbl_event_news_archive(&$vars){
  $vars['archive_menu'] = false;

  $active_tid = false;
  if (isset($_GET['cat'])){
    $active_tid = $_GET['cat'];
  }

  $news = _tcbl_get_news();
  $tids = false;
  foreach ($news as $nid => $new) {
    if (isset($new->field_ref_cat['und'][0]['tid'])){
      $tid = $new->field_ref_cat['und'][0]['tid'];
      $tids[$tid] = $tid; 
    }
  }

  if ($tids){
    $terms = taxonomy_term_load_multiple($tids);
    $list = array(
      '#prefix' => '<ul class="category-menu">',
      '#suffix' => '</ul>',
    );
    foreach ($terms as $key => $term) {

      $opt = [
        'query' => [
          'cat' => $term->tid,
        ],
      ];

      if ($active_tid && $active_tid == $term->tid){
        $opt['attributes']['class'][] = 'active-filter';
      }

      $list[$key] = [
        '#prefix' => '<li>',
        '#suffix' => '</li>',
        '#markup' => l($term->name, 'node/312', $opt),
        '#weight' => $term->weight,
      ];
    }

    $vars['archive_menu'] = $list;
  }
}

function _tcbl_add_social_menu(&$vars){
  $menu = menu_tree('menu-social');
  $keys = element_children($menu);
  
  $data = array(
    '#prefix' => '<ul class="ul-social">',
    '#suffix' => '</ul>',
  );

  foreach ($keys as $key) {
    $l = $menu[$key];
    if (isset($l['#localized_options']['icon']['icon'])){
      $icon = '<i class="fa fa-' . $l['#localized_options']['icon']['icon'] . '"></i>'; 
    }
    $data[$key] = array(
      '#prefix' => '<li class="li-social">',
      '#suffix' => '</li>',
      '#markup' => '<a href="' . $l['#href'] . '" title="' . $l['#title'] . '" class="a-social a-social-' . $key . '" target="_blank">' . $icon . '</a>',
    );
  }

  $vars['menu_social'] = $data;
}

function _tcbl_add_user_login(&$vars){
  
  global $base_url;
  $path = $base_url . '/' . drupal_get_path('theme', 'tcbl') . '/img/tcbl-avatar.png';

  if (user_is_logged_in()){
    global $user;
    $full_user = user_load($user->uid);
    $name = $full_user->name;

    if (isset($full_user->realname)){
      $name = $full_user->realname;
    }

    $avat = _tcbl_get_avatar_path($full_user);
    $path = $avat['path'];

    $data['user'] = array(
      '#prefix' => '<div class="user-menu"><a href="https://tcblsso.ilabt.iminds.be/usermanager" title="' . $name . '" target="_blank">',
      '#suffix' => '</a></div>',
      '#markup' => '<img src="' . $path . '"/> <span class="name">' . $name . '</span>',
    );

  } else {
    $data['user'] = array(
      '#prefix' => '<div class="user-menu log-in"><a href="/user/gluuSSO" title="Log in at TCBL">',
      '#suffix' => '</a></div>',
      '#markup' => '<img src="' . $path . '"/> <span class="log-in">Login with TCBL</span>',
    ); 
  }

  $vars['menu_user'] = $data;
}

function _tcbl_add_light_footer(&$vars){
  $content = array();

  if (isset($vars['menu_social'])){
    $content['menu_social'] = $vars['menu_social'];
  }

  if (isset($vars['logo'])){
    $content['logo'] = $vars['logo'];
  }

  // Main menu in footer
  if (isset($vars['primary_nav'])){
    $nav = $vars['primary_nav'];
    $keys = element_children($nav);

    $menu = array(
      '#prefix' => '<ul class="ul-footer-menu">',
      '#suffix' => '</ul>',
    );

    $opt = array(
      'attributes' => array(
        'class' => array(
          'navbar-a-typo',
        ),
      ),
    );

    foreach ($keys as $key){
      // Remove TCBL Conference link
      if ($key !== 3265){
        $item = $nav[$key];
        $l = $item['#original_link'];
      
        $menu[$key] = array(
          '#prefix' => '<li>',
          '#suffix' => '</li>',
          '#markup' => l($l['link_title'], $l['link_path'], $opt),
        );  
      }
    }
    $content['menu'] = $menu;
  }

  // User login in footer
  if (isset($vars['menu_user'])){
    $content['menu_user'] = $vars['menu_user'];
  }

  $vars['page']['footer']['tcbl'] = array(
    '#theme' => 'tcblfooter',
    '#content' => $content,
  );
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

    if ($node->type == 'blog'){
      $bcs = [];
      $bcs[] = t('Home');
      $bcs[] = l('Community', 'node/325');
      $bcs[] = l('News and blog', 'node/312');
      
      if (isset($node->field_ref_cat['und'][0]['tid'])){
        $tid = $node->field_ref_cat['und'][0]['tid'];
        $term = taxonomy_term_load($tid);
        $opt = [
          'query' => [
            'cat' => $tid,
          ],
        ];
        $bcs[] = l($term->name, 'node/312', $opt);
      }

      drupal_set_breadcrumb($bcs);  
    }
  }
}

/**
 * Create content array with tcbl FAQ link
 * @param  class $node Nodo a cui collegare le FAQ
 */
function _tcbl_faq_link($node){
  $text = '<i class="fa fa-question-circle-o"></i> FAQ';

  $nid = $node->nid;

  $opt = array(
    'html' => true,
    'attributes' => array(
      'class' => array(
        'colorbox-inline',
      ),
    ),
    'query' => array(
      'width' => '750',
      'height' => '500',
      'inline' => 'true',
    ),
    'fragment' => 'faq-content-' . $nid,
    'external' => true,
  );

  $data['link'] = array(
    '#prefix' => '<div class="wrapper-faq-link margin-b-05 text-right"><span class="h4 small">',
    '#suffix' => '</span></div>',
    '#markup' => l($text, '', $opt),
  );

  $data['content'] = array(
    '#prefix' => '<div class="wrapper-faw-content hide"><div id="faq-content-' . $nid . '" class="faq-content">',
    '#suffix' => '</div></div>',
    'title' => array(
      '#markup' => '<h2>' . $node->title . '</h2>',
    ),
    'node' => node_view($node, 'default'),
  );

  return $data;
}

function _tcbl_get_avatar_path($profile_user){
  global $base_url;
  $data['path'] = $base_url . '/' . drupal_get_path('theme', 'tcbl') . '/img/tcbl-avatar.png'; 
  $data['type'] = 'default';

  if (isset($profile_user->field_sso_avatar_uri['und'][0]['value'])){
    $value = $profile_user->field_sso_avatar_uri['und'][0]['value'];
    if ($value !== '' && $value !== '_'){
      $data['path'] = $value;
      $data['type'] = 'sso';
    }
  }
  return $data;
}

function _tcbl_get_tcbl_settings(){
  $settings = node_load(355);
  $node = false;
  if ($settings && $settings->type == 'settings'){
    $node = $settings;
  }
  return $node;
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
    $query->fieldCondition('field_ref_cat', 'target_id', $options['ref_nid']);
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
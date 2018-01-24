<?php
/**
 * @file
 * mekit_mgmt_menu.features.menu_links.inc
 */

/**
 * Implements hook_menu_default_menu_links().
 */
function mekit_mgmt_menu_menu_default_menu_links() {
  $menu_links = array();

  // Exported menu link: management_:admin/config/content/formats/%
  // $menu_links['management_:admin/config/content/formats/%'] = array(
  //   'menu_name' => 'management',
  //   'link_path' => 'admin/config/content/formats/%',
  //   'router_path' => 'admin/config/content/formats/%',
  //   'link_title' => '',
  //   'options' => array(
  //     'identifier' => 'management_:admin/config/content/formats/%',
  //   ),
  //   'module' => 'system',
  //   'hidden' => 0,
  //   'external' => 0,
  //   'has_children' => 1,
  //   'expanded' => 0,
  //   'weight' => 0,
  //   'customized' => 0,
  //   'parent_identifier' => 'management_text-formats:admin/config/content/formats',
  // );
  // Exported menu link: management_add-content:node/add
  $menu_links['management_add-content:node/add'] = array(
    'menu_name' => 'management',
    'link_path' => 'node/add',
    'router_path' => 'node/add',
    'link_title' => 'Add content',
    'options' => array(
      'icon' => array(
        'icon' => '',
        'position' => 'title_before',
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
      ),
      'attributes' => array(
        'title' => 'Add content',
      ),
      'identifier' => 'management_add-content:node/add',
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -50,
    'customized' => 1,
    'parent_identifier' => 'management_content:admin/content',
  );
  // Exported menu link: management_appearance:admin/appearance
  $menu_links['management_appearance:admin/appearance'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/appearance',
    'router_path' => 'admin/appearance',
    'link_title' => 'Appearance',
    'options' => array(
      'attributes' => array(
        'title' => 'Select and configure your themes.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'paint-brush',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_appearance:admin/appearance',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -44,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_configuration:admin/config
  $menu_links['management_configuration:admin/config'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/config',
    'router_path' => 'admin/config',
    'link_title' => 'Configuration',
    'options' => array(
      'attributes' => array(
        'title' => 'Administer settings.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'cog',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_configuration:admin/config',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 1,
    'expanded' => 0,
    'weight' => -41,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_content:admin/content
  $menu_links['management_content:admin/content'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/content',
    'router_path' => 'admin/content',
    'link_title' => 'Content',
    'options' => array(
      'attributes' => array(
        'title' => 'Find and manage content.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'list-ul',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_content:admin/content',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 1,
    'expanded' => 0,
    'weight' => -46,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_dashboard:admin/dashboard
  $menu_links['management_dashboard:admin/dashboard'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/dashboard',
    'router_path' => 'admin/dashboard',
    'link_title' => 'Dashboard',
    'options' => array(
      'attributes' => array(
        'title' => 'View and customize your dashboard.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'home',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_dashboard:admin/dashboard',
    ),
    'module' => 'system',
    'hidden' => 1,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -50,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_help:admin/help
  $menu_links['management_help:admin/help'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/help',
    'router_path' => 'admin/help',
    'link_title' => 'Help',
    'options' => array(
      'attributes' => array(
        'title' => 'Reference for usage, configuration, and modules.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'info-circle',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_help:admin/help',
    ),
    'module' => 'system',
    'hidden' => 1,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -37,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_home:<front>
  $menu_links['management_home:<front>'] = array(
    'menu_name' => 'management',
    'link_path' => '<front>',
    'router_path' => '',
    'link_title' => 'Home',
    'options' => array(
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'home',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'attributes' => array(
        'title' => 'Home',
      ),
      'identifier' => 'management_home:<front>',
    ),
    'module' => 'menu',
    'hidden' => 0,
    'external' => 1,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -49,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_modules:admin/modules
  $menu_links['management_modules:admin/modules'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/modules',
    'router_path' => 'admin/modules',
    'link_title' => 'Modules',
    'options' => array(
      'attributes' => array(
        'title' => 'Extend site functionality.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'cubes',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_modules:admin/modules',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -42,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_node-hierarchy:admin/stucture/nodehierarchy
  $menu_links['management_node-hierarchy:admin/stucture/nodehierarchy'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/stucture/nodehierarchy',
    'router_path' => 'admin/stucture/nodehierarchy',
    'link_title' => 'Node Hierarchy',
    'options' => array(
      'attributes' => array(
        'title' => 'Administer default Node Hierarchy settings.',
      ),
      'icon' => array(
        'icon' => '',
        'position' => 'title_before',
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
      ),
      'identifier' => 'management_node-hierarchy:admin/stucture/nodehierarchy',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => 0,
    'customized' => 1,
    'parent_identifier' => 'management_structure:admin/structure',
  );
  // Exported menu link: management_people:admin/people
  $menu_links['management_people:admin/people'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/people',
    'router_path' => 'admin/people',
    'link_title' => 'People',
    'options' => array(
      'attributes' => array(
        'title' => 'Manage user accounts, roles, and permissions.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'user',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_people:admin/people',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 0,
    'expanded' => 0,
    'weight' => -43,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_reports:admin/reports
  $menu_links['management_reports:admin/reports'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/reports',
    'router_path' => 'admin/reports',
    'link_title' => 'Reports',
    'options' => array(
      'attributes' => array(
        'title' => 'View reports, updates, and errors.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'line-chart',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_reports:admin/reports',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 1,
    'expanded' => 0,
    'weight' => -40,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );
  // Exported menu link: management_structure:admin/structure
  $menu_links['management_structure:admin/structure'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/structure',
    'router_path' => 'admin/structure',
    'link_title' => 'Structure',
    'options' => array(
      'attributes' => array(
        'title' => 'Administer blocks, content types, menus, etc.',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'trello',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_structure:admin/structure',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 1,
    'expanded' => 0,
    'weight' => -45,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );

  // ** VOCI AGGIUNTE MANUALMENTE **
  // -------------------------------

  // CONTENT TYPES
  // Exported menu link: management_structure:admin/contenttypes

  // $menu_links['management_structure:admin/contenttypes'] = array(
  //   'menu_name' => 'management',
  //   'link_path' => 'admin/structure/types',
  //   'router_path' => 'admin/structure/types',
  //   'link_title' => 'Content types',
  //   'options' => array(
  //     'attributes' => array(
  //       'title' => 'Content types',
  //     ),
  //     'icon' => array(
  //       'bundle' => 'fontawesome',
  //       'icon' => 'list-ul',
  //       'position' => 'title_before',
  //       'breadcrumb' => 0,
  //       'title_wrapper' => 0,
  //       'title_wrapper_element' => 'span',
  //       'title_wrapper_class' => 'title',
  //     ),
  //     'identifier' => 'management_structure:admin/contenttypes',
  //   ),
  //   'module' => 'system',
  //   'hidden' => 0,
  //   'external' => 0,
  //   'has_children' => 1,
  //   'expanded' => 0,
  //   'weight' => -48,
  //   'customized' => 1,
  //   'parent_identifier' => 'management_administration:admin',
  // );

  // VIEWS
  // Exported menu link: management_structure:admin/views
  // $menu_links['management_structure:admin/views'] = array(
  //   'menu_name' => 'management',
  //   'link_path' => 'admin/structure/views',
  //   'router_path' => 'admin/structure/views',
  //   'link_title' => 'Views',
  //   'options' => array(
  //     'attributes' => array(
  //       'title' => 'Views',
  //     ),
  //     'icon' => array(
  //       'bundle' => 'fontawesome',
  //       'icon' => 'th',
  //       'position' => 'title_before',
  //       'breadcrumb' => 0,
  //       'title_wrapper' => 0,
  //       'title_wrapper_element' => 'span',
  //       'title_wrapper_class' => 'title',
  //     ),
  //     'identifier' => 'management_structure:admin/views',
  //   ),
  //   'module' => 'system',
  //   'hidden' => 0,
  //   'external' => 0,
  //   'has_children' => 1,
  //   'expanded' => 0,
  //   'weight' => -47,
  //   'customized' => 1,
  //   'parent_identifier' => 'management_administration:admin',
  // );

  // LESS
  // Exported menu link: management_structure:admin/less
  $menu_links['management_structure:admin/less'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/config/development/less',
    'router_path' => 'admin/config/development/less',
    'link_title' => 'Less',
    'options' => array(
      'attributes' => array(
        'title' => 'Less',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'code',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_structure:admin/less',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 1,
    'expanded' => 0,
    'weight' => -38,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );

  // PERFORMANCE
  // Exported menu link: management_structure:admin/performance
  $menu_links['management_structure:admin/performance'] = array(
    'menu_name' => 'management',
    'link_path' => 'admin/config/development/performance',
    'router_path' => 'admin/config/development/performance',
    'link_title' => 'Performance',
    'options' => array(
      'attributes' => array(
        'title' => 'Performance',
      ),
      'icon' => array(
        'bundle' => 'fontawesome',
        'icon' => 'rocket',
        'position' => 'title_before',
        'breadcrumb' => 0,
        'title_wrapper' => 0,
        'title_wrapper_element' => 'span',
        'title_wrapper_class' => 'title',
      ),
      'identifier' => 'management_structure:admin/performance',
    ),
    'module' => 'system',
    'hidden' => 0,
    'external' => 0,
    'has_children' => 1,
    'expanded' => 0,
    'weight' => -37,
    'customized' => 1,
    'parent_identifier' => 'management_administration:admin',
  );


  // Translatables
  // Included for use with string extractors like potx.
  t('Add content');
  t('Appearance');
  t('Configuration');
  t('Content');
  t('Dashboard');
  t('Help');
  t('Home');
  t('Modules');
  t('Node Hierarchy');
  t('People');
  t('Reports');
  t('Structure');


  return $menu_links;
}

// ** MANCA VIEWS fa-th ** //

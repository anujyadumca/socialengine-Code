<?php return array (
  'package' =>
  array (
    'type' => 'module',
    'name' => 'company',
    'version' => '4.9.2p1',
    'path' => 'application/modules/Company',
    'title' => 'Company',
    'description' => 'This is used for companies',
    'author' => 'Ipragmatech',
    'callback' =>
    array (
      'class' => 'Engine_Package_Installer_Module',
    ),
    'actions' =>
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' =>
    array (
      0 => 'application/modules/Company',
    ),
    'files' =>
    array (
      0 => 'application/languages/en/company.csv',
    ),
  ),
  // Items ---------------------------------------------------------------------
    'items' => array (
        'company',
        'company_group',
        'company_album',
        'company_category',
        'company_list',
        'company_list_item',
        'company_photo',
        'company_post',
        'company_topic'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array (
        'company_extended' => array (
            'route' => 'companies/:controller/:action/*',
            'defaults' => array (
                'module' => 'company',
                'controller' => 'index',
                'action' => 'index'
            ),
            'reqs' => array (
                'controller' => '\D+',
                'action' => '\D+'
            )
        ),
        'company_general' => array (
            'route' => 'companies/:action/*',
            'defaults' => array (
                'module' => 'company',
                'controller' => 'index',
                'action' => 'browse'
            ),
            'reqs' => array (
                'action' => '(browse|create|list|manage)'
            )
        ),
        'company_specific' => array (
            'route' => 'companies/:action/:group_id/*',
            'defaults' => array (
                'module' => 'company',
                'controller' => 'group',
                'action' => 'index'
            ),
            'reqs' => array (
                'action' => '(edit|delete|join|leave|cancel|accept|invite|style)',
                'group_id' => '\d+'
            )
        ),
        'company_profile' => array (
            'route' => 'company/:id/:slug/*',
            'defaults' => array (
                'module' => 'company',
                'controller' => 'profile',
                'action' => 'index',
                'slug' => ''
            ),
            'reqs' => array (
                'id' => '\d+'
            )
        ),
        'company_topic' => array (
            'route' => 'company/:controller/:action/:group_id/:topic_id/:slug/*',
            'defaults' => array (
                'module' => 'company',
                'controller' => 'index',
                'action' => 'index',
                'slug' => ''
            ),
            'reqs' => array (
                'controller' => '\D+',
                'action' => '\D+'
            )
        ),
        'company_categories_general' => array (
            'route' => 'company/search/:action/*',
            'defaults' => array (
                'module' => 'company',
                'controller' => 'category',
                'action' => 'browse'
            ),
            'reqs' => array (
                'action' => '(browse|browselevelone)'
            )
        ),
        // 				'company_categories_general' => array (
        // 						'route' => 'company/category/:action/*',
        // 						'defaults' => array (
        // 								'module' => 'company',
        // 								'controller' => 'category',
        // 								'action' => 'browse'
        // 						),
        // 						'reqs' => array (
        // 								'action' => '(browse|browselevelone)'
            // 						)
// 				),
// 				'company_browselevelone_categories' => array(
            // 						'route' => 'company/category/1/:category_id/:slug/*',
            // 						'defaults' => array(
            // 								'module' => 'company',
            // 								'controller' => 'category',
            // 								'action' => 'browselevelone',
            // 								'slug' => '',
            // 						),
            // 						'reqs' => array(
        // 								'action' => '(browselevelone)',
        // 								'category_id' => '\d+',
        // 						)
        // 				),
    // 				'company_browseleveltwo_categories' => array(
    // 						'route' => 'company/category/2/:category_id/:slug/*',
        // 						'defaults' => array(
        // 								'module' => 'company',
            // 								'controller' => 'category',
            // 								'action' => 'browseleveltwo',
            // 								'slug' => '',
            // 						),
            // 						'reqs' => array(
            // 								'action' => '(browseleveltwo)',
                // 								'category_id' => '\d+',
                // 						)
// 				)
            )
); ?>
<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Company
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: content.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
return array (
		array (
				'title' => 'Profile Companys',
				'description' => 'Displays a member\'s companys on their profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-groups',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Companys',
						'titleCount' => true
				),
				'requirements' => array (
						'subject' => 'user'
				)
		),

        array(
            'title' => 'PopularCompanyFriends',
            'description' => 'Displays the list of most popular company friends.',
            'category' => 'Company',
            'type' => 'widget',
            'name' => 'company.company-friends',
            'isPaginated' => true,
            'defaultParams' => array(
                'title' => 'PopularCompanyFriends',
            ),
            'requirements' => array(
                'user',
            ),
        ),

        array(
            'title' => 'PopularCompanySectors',
            'description' => 'Displays the list of most popular company sectors.',
            'category' => 'Company',
            'type' => 'widget',
            'name' => 'company.company-sectors',
            'isPaginated' => true,
            'defaultParams' => array(
                'title' => 'PopularCompanySectors',
            ),
            'requirements' => array(
                'user',
            ),
        ),

        array(
            'title' => 'CompanyDetails',
            'description' => 'Displays the totals of Companies',
            'category' => 'Company',
            'type' => 'widget',
            'name' => 'company.company-details',
            'isPaginated' => true,
            'defaultParams' => array(
                'title' => 'CompanyDetails',
            ),
            'requirements' => array(
                'user',
            ),
        ),

		array (
				'title' => 'Company Profile Discussions',
				'description' => 'Displays a Company\'s discussions on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-discussions',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Discussions',
						'titleCount' => true
				),
				'requirements' => array (
						'subject' => 'company'
				)
		),
        array (
				'title' => 'Company Profile Info',
				'description' => 'Displays a Company\'s info (creation date, member count, leader, officers, etc) on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-info',
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Company Profile Members',
				'description' => 'Displays a Company\'s members on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-members',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Members',
						'titleCount' => true
				),
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Company Profile Followers',
				'description' => 'Displays a Company\'s followers on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-followers',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Followers',
						'titleCount' => true
				),
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Company Profile Options',
				'description' => 'Displays a menu of actions (edit, report, join, invite, etc) that can be performed on a Company on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-options',
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Company Profile Photo',
				'description' => 'Displays a Company\'s photo on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-photo',
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Company Profile Photos',
				'description' => 'Displays a Company\'s photos on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-photos',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Photos',
						'titleCount' => true
				),
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Company Profile Status',
				'description' => 'Displays a Company\'s title on its profile.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-status',
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Company Profile Events',
				'description' => 'Displays a Company\'s events on its profile',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.profile-events',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Events',
						'titleCount' => true
				),
				'requirements' => array (
						'subject' => 'company'
				)
		),
		array (
				'title' => 'Popular Companys',
				'description' => 'Displays a list of most viewed companys.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.list-popular-groups',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Popular Companys'
				),
				'requirements' => array (
						'no-subject'
				),
				'adminForm' => array (
						'elements' => array (
								array (
										'Radio',
										'popularType',
										array (
												'label' => 'Popular Type',
												'multiOptions' => array (
														'view' => 'Views',
														'member' => 'Members'
												),
												'value' => 'view'
										)
								)
						)
				)
		),
		array (
				'title' => 'Recent Companys',
				'description' => 'Displays a list of recently created Companys.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.list-recent-groups',
				'isPaginated' => true,
				'defaultParams' => array (
						'title' => 'Recent Companys'
				),
				'requirements' => array (
						'no-subject'
				),
				'adminForm' => array (
						'elements' => array (
								array (
										'Radio',
										'recentType',
										array (
												'label' => 'Recent Type',
												'multiOptions' => array (
														'creation' => 'Creation Date',
														'modified' => 'Modified Date'
												),
												'value' => 'creation'
										)
								)
						)
				)
		),
		array (
				'title' => 'Company Browse Menu',
				'description' => 'Displays a menu in the Company browse page.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.browse-menu',
				'requirements' => array (
						'no-subject'
				)
		),
		array (
				'title' => 'Company Browse Quick Menu',
				'description' => 'Displays a small menu in the Company browse page.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.browse-menu-quick',
				'requirements' => array (
						'no-subject'
				)
		),
		array (
				'title' => 'Browse Company Level One Categories',
				'description' => 'Displays a list of categories.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.browselevelone-categories',
				'defaultParams' => array (
						'title' => 'Browse Company Level One Categories'
				)
		),
		array (
				'title' => 'Browse Company Level Two Categories',
				'description' => 'Displays a list of level two categories.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.browseleveltwo-categories',
				'defaultParams' => array (
						'title' => 'Browse Company Level Two Categories'
				)
		),
		array (
				'title' => 'Browse Company Level Three Categories',
				'description' => 'Displays a list of level three categories.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.browselevelthree-categories',
				'defaultParams' => array (
						'title' => 'Browse Company Level Three Categories'
				)
		),
		array (
				'title' => 'Company Search',
				'description' => 'Displays a search form in the company browse page.',
				'category' => 'Companys',
				'type' => 'widget',
				'name' => 'company.browse-search',
				'defaultParams' => array (
						'title' => 'Company Search'
				)
		),
        array (
            'title' => 'Company BtoB',
            'description' => 'Displays the list of company contact lists.',
            'category' => 'Companys',
            'type' => 'widget',
            'name' => 'company.browse-business',
            'defaultParams' => array (
                'title' => 'Company BtoB'
            )
        ),
        array (
            'title' => 'Company Cutomers',
            'description' => 'Displays the list of company contact lists.',
            'category' => 'Companys',
            'type' => 'widget',
            'name' => 'company.browse-customers',
            'defaultParams' => array (
                'title' => 'Customers'
            )
        ),
        array (
            'title' => 'Company Human Resource',
            'description' => 'Displays the list of company Hr lists.',
            'category' => 'Companys',
            'type' => 'widget',
            'name' => 'company.human-resource',
            'defaultParams' => array (
                'title' => 'Company Human Resource'
            )
        ),
        array (
            'title' => 'Company Investors',
            'description' => 'Displays the list of Company Investors lists.',
            'category' => 'Companys',
            'type' => 'widget',
            'name' => 'company.company-investor',
            'defaultParams' => array (
                'title' => 'Company Investor'
            )
        ),
        array (
            'title' => 'Company News',
            'description' => 'Displays the list of Company Investors lists.',
            'category' => 'Companys',
            'type' => 'widget',
            'name' => 'company.company-news',
            'defaultParams' => array (
                'title' => 'Company News'
            )
        )


	// array
	// 'title' => 'Company Categories',
	// 'description' => 'Display a list of categories for Companys.',
	// 'category' => 'Companys',
	// 'type' => 'widget',
	// 'name' => 'company.list-categories',
	// ),
)?>
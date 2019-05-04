
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Group
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @author		 John
 */


-- --------------------------------------------------------

--
-- Table structure for table `engine4_group_albums`
--

DROP TABLE IF EXISTS `engine4_company_albums` ;
CREATE TABLE `engine4_company_albums` (
  `album_id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(11) unsigned NOT NULL,

  `title` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `search` tinyint(1) NOT NULL default '1',
  `photo_id` int(11) unsigned NOT NULL default '0',
  `view_count` int(11) unsigned NOT NULL default '0',
  `comment_count` int(11) unsigned NOT NULL default '0',
  `like_count` int(11) unsigned NOT NULL default '0',
  `collectible_count` int(11) unsigned NOT NULL default '0',
   PRIMARY KEY (`album_id`),
   KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_categories`
--

DROP TABLE IF EXISTS `engine4_company_categories` ;
CREATE TABLE IF NOT EXISTS `engine4_company_categories` (
  `category_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

--
-- Dumping data for table `engine4_company_categories`
--

INSERT IGNORE INTO `engine4_company_categories` (`title`) VALUES
('Animals'),
('Business & Finance'),
('Computers & Internet'),
('Cultures & Community'),
('Dating & Relationships'),
('Entertainment & Arts'),
('Family & Home'),
('Games'),
('Government & Politics'),
('Health & Wellness'),
('Hobbies & Crafts'),
('Music'),
('Recreation & Sports'),
('Regional'),
('Religion & Beliefs'),
('Companys & Education'),
('Science')
;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_listitems`
--

DROP TABLE IF EXISTS `engine4_company_listitems`;
CREATE TABLE IF NOT EXISTS `engine4_company_listitems` (
  `listitem_id` int(11) unsigned NOT NULL auto_increment,
  `list_id` int(11) unsigned NOT NULL,
  `child_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`listitem_id`),
  KEY `list_id` (`list_id`),
  KEY `child_id` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_lists`
--

DROP TABLE IF EXISTS `engine4_company_lists`;
CREATE TABLE IF NOT EXISTS `engine4_company_lists` (
  `list_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(64) NOT NULL default '',
  `owner_id` int(11) unsigned NOT NULL,
  `child_count` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`list_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_groups`
--

DROP TABLE IF EXISTS `engine4_company_groups`;
CREATE TABLE IF NOT EXISTS `engine4_company_groups` (
  `group_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) unsigned NOT NULL default '0',
  `search` tinyint(1) NOT NULL default '1',
  `invite` tinyint(1) NOT NULL default '1',
  `approval` tinyint(1) NOT NULL default '0',
  `photo_id` int(11) unsigned NOT NULL default '0',
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `member_count` smallint(6) unsigned NOT NULL,
  `view_count` int(11) unsigned NOT NULL default '0',
  `comment_count` int(11) unsigned NOT NULL default '0',
  `like_count` int(11) unsigned NOT NULL default '0',
  `view_privacy` VARCHAR(24) NOT NULL,
  PRIMARY KEY  (`group_id`),
  KEY `user_id` (`user_id`),
  KEY `search` (`search`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_membership`
--

DROP TABLE IF EXISTS `engine4_company_membership`;
CREATE TABLE IF NOT EXISTS `engine4_company_membership` (
  `resource_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  `resource_approved` tinyint(1) NOT NULL default '0',
  `user_approved` tinyint(1) NOT NULL default '0',
  `message` text NULL,
  `title` text NULL,
  PRIMARY KEY  (`resource_id`, `user_id`),
  KEY `REVERSE` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_photos`
--

DROP TABLE IF EXISTS `engine4_company_photos`;
CREATE TABLE `engine4_company_photos` (
  `photo_id` int(11) unsigned NOT NULL auto_increment,
  `album_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,

  `title` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `collection_id` int(11) unsigned NOT NULL,
  `file_id` int(11) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `view_count` int(11) unsigned NOT NULL default '0',
  `comment_count` int(11) unsigned NOT NULL default '0',
  `like_count` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY (`photo_id`),
  KEY `album_id` (`album_id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_posts`
--

DROP TABLE IF EXISTS `engine4_company_posts`;
CREATE TABLE IF NOT EXISTS `engine4_company_posts` (
  `post_id` int(11) unsigned NOT NULL auto_increment,
  `topic_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  
  `body` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY  (`post_id`),
  KEY `topic_id` (`topic_id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_topics`
--

DROP TABLE IF EXISTS `engine4_company_topics`;
CREATE TABLE IF NOT EXISTS `engine4_company_topics` (
  `topic_id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  
  `title` varchar(64) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `sticky` tinyint(1) NOT NULL default '0',
  `closed` tinyint(1) NOT NULL default '0',
  `post_count` int(11) unsigned NOT NULL default '0',
  `view_count` int(11) unsigned NOT NULL default '0',
  `lastpost_id` int(11) unsigned NOT NULL default '0',
  `lastposter_id` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`topic_id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_company_topicwatches`
--

DROP TABLE IF EXISTS `engine4_company_topicwatches`;
CREATE TABLE IF NOT EXISTS `engine4_company_topicwatches` (
  `resource_id` int(10) unsigned NOT NULL,
  `topic_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `watch` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`resource_id`,`topic_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;


-- --------------------------------------------------------

--
-- Dumping data for table `engine4_core_jobtypes`
--

INSERT IGNORE INTO `engine4_core_jobtypes` (`title`, `type`, `module`, `plugin`, `priority`) VALUES
('Rebuild Company Privacy', 'company_maintenance_rebuild_privacy', 'company', 'Company_Plugin_Job_Maintenance_RebuildPrivacy', 50);


-- --------------------------------------------------------

--
-- Dumping data for table `engine4_core_mailtemplates`
--

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
('notify_company_accepted', 'company', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_company_approve', 'company', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_company_discussion_reply', 'company', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_company_discussion_response', 'company', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_company_invite', 'company', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]'),
('notify_company_promote', 'company', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]');


-- --------------------------------------------------------

--
-- Dumping data for table `engine4_core_menus`
--

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
('company_main', 'standard', 'Company Main Navigation Menu'),
('company_profile', 'standard', 'Company Profile Options Menu')
;


-- --------------------------------------------------------

--
-- Dumping data for table `engine4_core_menuitems`
--

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_main_company', 'company', 'Companys', '', '{"route":"company_general","icon":"fa-group"}', 'core_main', '', 6),

('core_sitemap_company', 'company', 'Companys', '', '{"route":"company_general"}', 'core_sitemap', '', 6),

('company_main_browse', 'company', 'Browse Companys', '', '{"route":"company_general","action":"browse"}', 'company_main', '', 1),
('company_main_manage', 'company', 'My Companys', 'Company_Plugin_Menus', '{"route":"company_general","action":"manage"}', 'company_main', '', 2),
('company_main_create', 'company', 'Create New Company', 'Company_Plugin_Menus', '{"route":"company_general","action":"create"}', 'company_main', '', 3),

('company_quick_create', 'company', 'Create New Company', 'Company_Plugin_Menus::canCreateGroup', '{"route":"company_general","action":"create","class":"buttonlink icon_group_new"}', 'company_quick', '', 1),

('company_profile_edit', 'company', 'Edit Profile', 'Company_Plugin_Menus', '', 'company_profile', '', 1),
('company_profile_style', 'company', 'Edit Styles', 'Company_Plugin_Menus', '', 'company_profile', '', 2),

('company_profile_member', 'company', 'Member', 'Company_Plugin_Menus', '', 'company_profile', '', 3),
('company_profile_report', 'company', 'Report Company', 'Company_Plugin_Menus', '', 'company_profile', '', 4),
('company_profile_share', 'company', 'Share', 'Company_Plugin_Menus', '', 'company_profile', '', 5),
('company_profile_invite', 'company', 'Invite', 'Company_Plugin_Menus', '', 'company_profile', '', 6),
('company_profile_message', 'company', 'Message Members', 'Company_Plugin_Menus', '', 'company_profile', '', 7),

('core_admin_main_plugins_company', 'company', 'Companys', '', '{"route":"admin_default","module":"company","controller":"manage"}', 'core_admin_main_plugins', '', 999),

('company_admin_main_manage', 'company', 'Manage Companys', '', '{"route":"admin_default","module":"company","controller":"manage"}', 'company_admin_main', '', 1),
('company_admin_main_settings', 'company', 'Global Settings', '', '{"route":"admin_default","module":"company","controller":"settings"}', 'company_admin_main', '', 2),
('company_admin_main_level', 'company', 'Member Level Settings', '', '{"route":"admin_default","module":"company","controller":"settings","action":"level"}', 'company_admin_main', '', 3),
('company_admin_main_categories', 'company', 'Categories', '', '{"route":"admin_default","module":"company","controller":"settings","action":"categories"}', 'company_admin_main', '', 4),
('authorization_admin_level_company', 'company', 'Companys', '', '{"route":"admin_default","module":"company","controller":"settings","action":"level"}', 'authorization_admin_level', '', 999),
('mobi_browse_company', 'company', 'Companys', '', '{"route":"company_general"}', 'mobi_browse', '', 8);


-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Dumping data for table `engine4_core_settings`
--

INSERT IGNORE INTO `engine4_core_settings` VALUES 
('company.html', 1),
('company.bbcode', 1);


  
 -- Javed
insert IGNORE into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "company_index_manage", "Company Manage Page", NULL, "My Company", "This page lists a user\'s company.", "", 0, 0, "", NULL, NULL, 0, 0);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '36', 'container', 'top', NULL, '1', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '36', 'container', 'main', NULL, '2', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '36', 'container', 'middle', 714, '5', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '36', 'container', 'middle', 715, '5', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '36', 'container', 'right', 715, '4', NULL, NULL);
  

insert into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "company_index_create", "Company Create Page", NULL, "Company Create", "This page allows users to create groups.", "", 0, 0, "", NULL, NULL, 0, 0);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '37', 'container', 'top', NULL, '1', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '37', 'container', 'main', NULL, '2', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '37', 'container', 'middle', 718, '6', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '37', 'container', 'middle', 719, '6', NULL, NULL);


insert into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "company_profile_index", "Company Profile", NULL, "Company Profile", "This is the profile for an company.", "", 0, 0, "", NULL, "subject=group", 0, 0);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '38', 'container', 'main', NULL, '2', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '38', 'container', 'left', 722, '4', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '38', 'container', 'middle', 722, '6', NULL, NULL);


insert into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "mobi_company_profile", "Mobile Company Profile", NULL, "Mobile Company Profile", "This is the mobile verison of a group profile.", "", 0, 0, "", NULL, "subject=group", 0, 0);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '39', 'container', 'main', NULL, '2', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '39', 'container', 'middle', 725, '6', NULL, NULL);


insert IGNORE into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "company_index_browse", "Company Browse Page", NULL, "Company Browse", "This page lists groups.", "", 0, 0, "", NULL, NULL, 0, 0);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '40', 'container', 'top', NULL, '1', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '40', 'container', 'main', NULL, '2', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '40', 'container', 'middle', 727, '5', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '40', 'container', 'middle', 728, '5', NULL, NULL);
INSERT IGNORE INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '40', 'container', 'right', 728, '4', NULL, NULL);



INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `editable`, `is_generated`) VALUES
('company_create', 'company', '{item:$subject} created a new company:', 1, 5, 1, 1, 1, 0, 1),
('company_join', 'company', '{item:$subject} joined the company {item:$object}', 1, 3, 1, 1, 1, 0, 1),
('company_promote', 'company', '{item:$subject} has been made an officer for the company {item:$object}', 1, 3, 1, 1, 1, 0, 1),
('company_topic_create', 'company', '{item:$subject} posted a {itemChild:$object:topic:$child_id} in the company {item:$object}: {body:$body}', 1, 3, 1, 1, 1, 0, 1),
('company_topic_reply', 'company', '{item:$subject} replied to a {itemChild:$object:topic:$child_id} in the company {item:$object}: {body:$body}', 1, 3, 1, 1, 1, 0, 1),
('company_photo_upload', 'company', '{item:$subject} added {var:$count} photo(s).', 1, 3, 2, 1, 1, 0, 1),
('post_company', 'company', '{actors:$subject:$object}: {body:$body}', 1, 7, 1, 4, 1, 1, 0)
;

INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
('company_discussion_response', 'company', '{item:$subject} has {item:$object:posted} on a {itemParent:$object::group topic} you created.', 0, ''),
('company_discussion_reply', 'company', '{item:$subject} has {item:$object:posted} on a {itemParent:$object::group topic} you posted on.', 0, ''),
('company_invite', 'company', '{item:$subject} has invited you to the company {item:$object}.', 1, 'group.widget.request-group'),
('company_approve', 'company', '{item:$subject} has requested to join the company {item:$object}.', 0, ''),
('company_accepted', 'company', 'Your request to join the company {item:$object} has been approved.', 0, ''),
('company_promote', 'company', 'You were promoted to officer in the company {item:$object}.', 0, '')
;

INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'auth_view' as `name`,
    5 as `value`,
    '["everyone", "registered", "member"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
  
  
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'auth_photo' as `name`,
    5 as `value`,
    '["registered", "member", "officer"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
  
  
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'auth_event' as `name`,
    5 as `value`,
    '["registered", "member", "officer"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
  
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'delete' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'view' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'comment' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'photo.edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'topic.edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'photo' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  
  INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'event' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'style' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'invite' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');

-- USER
-- create, delete, edit, invite, view, comment, photo, style, invite, photo.edit, topic.edit
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'delete' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'comment' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'photo' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'event' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'style' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'invite' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'photo.edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'topic.edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');

-- PUBLIC
-- view
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('public');

-- ALL
-- commentHtml
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'company_group' as `type`,
    'commentHtml' as `name`,
    3 as `value`,
    'blockquote, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr, iframe' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');

  
  

-- elevate permissions for existing group officers
INSERT IGNORE INTO `engine4_authorization_allow`
  SELECT
    'company_group' as 'resource_type',
    owner_id as `resource_id`,
    'topic.edit' as `action`,
    'group_list' as `role`,
    list_id as role_id,
    1 as `value`,
    NULL as `params`
  FROM `engine4_group_lists`
;
INSERT IGNORE INTO `engine4_authorization_allow`
  SELECT
    'company_group' as 'resource_type',
    owner_id as `resource_id`,
    'photo.edit' as `action`,
    'group_list' as `role`,
    list_id as role_id,
    1 as `value`,
    NULL as `params`
  FROM `engine4_group_lists`
;


  
INSERT IGNORE INTO `engine4_core_banners`(`name`, `module`, `title`, `body`, `photo_id`, `params`, `custom`) VALUES
('company', 'company', 'Get Together in Company', 'Create and join interest based company. Bring people together.', 0, '{"label":"Create New Company","route":"company_general","routeParams":{"action":"create"}}', 0);
  
update engine4_core_menuitems set enabled = 0 where module = "company" and name="company_main_browse";
INSERT IGNORE INTO `engine4_core_menuitems` ( `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES ('company_main_category_browse','company','Browse Company','','{"route":"company_categories_general","action":"browse"}','company_main','','1','0','1');



insert into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "company_category_browse_page", "Company First Level", NULL, "Company First Level Page", "This page displays an Company's.", "", 0, 0, "", NULL, NULL, 0, 0);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '41', 'container', 'top', NULL, '1', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '41', 'container', 'main', NULL, '2', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '41', 'container', 'middle', 732, '5', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '41', 'container', 'middle', 733, '5', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '41', 'container', 'right', 733, '4', NULL, NULL);


insert into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "company_category_browse_page_level_one", "Company Second Level", NULL, "Company Second Level", "This page displays an second level group's.", "", 0, 0, "", NULL, NULL, 0, 0);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '42', 'container', 'top', NULL, '1', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '42', 'container', 'main', NULL, '2', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '42', 'container', 'middle', 737, '5', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '42', 'container', 'middle', 738, '5', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '42', 'container', 'right', 738, '4', NULL, NULL);


insert into engine4_core_pages (page_id, name, displayname, url, title, description, keywords, custom, fragment, layout, levels, provides, view_count,search) values (null, "company_category_browse_page_level_two", "Company Third Level", NULL, "Company Third Level", "This page displays an Level third group's.", "", 0, 0, "", NULL, NULL, 0, 0);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '43', 'container', 'top', NULL, '1', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '43', 'container', 'main', NULL, '2', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '43', 'container', 'middle', 742, '5', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '43', 'container', 'middle', 743, '5', NULL, NULL);
INSERT INTO `engine4_core_content` (`content_id`, `page_id`, `type`, `name`, `parent_content_id`, `order`, `params`, `attribs`) VALUES (NULL, '43', 'container', 'right', 743, '4', NULL, NULL);

ALTER TABLE `engine4_company_industries` ADD COLUMN `status` int(11) DEFAULT 1;
ALTER TABLE `engine4_company_sectors` ADD COLUMN `status` int(11) DEFAULT 1;

ALTER TABLE `engine4_company_groups` ADD COLUMN `category_id_level_two` int(11) DEFAULT 0 AFTER category_id;
ALTER TABLE `engine4_company_groups` ADD COLUMN `category_id_level_one` int(11) DEFAULT 0 AFTER category_id;
ALTER TABLE `engine4_company_categories` ADD COLUMN `parent_id` int(11) DEFAULT 0;
ALTER TABLE `engine4_company_categories` ADD COLUMN `photo_id` int(11) DEFAULT 0;
ALTER TABLE `engine4_company_categories` ADD UNIQUE `unique_index`(`title`, `parent_id`);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES('company_admin_main_import', 'company', 'Company Import', '', '{"route":"admin_default","module":"company","controller":"settings","action":"import"}', 'company_admin_main', '', 5);


INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('company', 'Company', 'This plugin is a copy of the group module which will be use as separate group known as companies.', '4.0.0', 1, 'extra') ;


ALTER TABLE `engine4_company_groups` ADD COLUMN `zipcode` varchar(256);
ALTER TABLE `engine4_company_groups` ADD COLUMN `companytype` int(11) DEFAULT 1;
ALTER TABLE `engine4_company_membership`  ADD `association` VARCHAR(256) NULL  AFTER `title`;
ALTER TABLE `engine4_company_membership`  ADD `graduation` VARCHAR(256) NULL  AFTER `title`;
ALTER TABLE `engine4_company_categories` ADD COLUMN `status` int(11) DEFAULT 1;

INSERT INTO `engine4_core_menuitems` (`id`, `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES (NULL, 'company_admin_main_relationship', 'company', 'Association', '', '{"route":"admin_default","module":"company","controller":"settings","action”:”association"}', 'company_admin_main', '', '1', '0', '5');


CREATE TABLE `engine4_company_relationships` (
  `relationship_id` int(11) NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `photo_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `engine4_core_menuitems` (`id`, `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES (NULL, 'company_admin_main_industries', 'company', 'Industries', '', '{"route":"admin_default","module":"company","controller":"settings","action":"industries"}', 'company_admin_main', '', '1', '0', '7');

ALTER TABLE `engine4_company_relationships`
  ADD PRIMARY KEY (`relationship_id`);

ALTER TABLE `engine4_company_relationships`
  MODIFY `relationship_id` int(11) NOT NULL AUTO_INCREMENT;
  
  CREATE TABLE `engine4_company_followship` (
  `resource_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `resource_approved` tinyint(1) NOT NULL DEFAULT '0',
  `user_approved` tinyint(1) NOT NULL DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci,
  `title` text COLLATE utf8_unicode_ci,
  `graduation` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `association` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  
ALTER TABLE `engine4_company_followship`
  ADD PRIMARY KEY (`resource_id`,`user_id`),
  ADD KEY `REVERSE` (`user_id`);
  
  INSERT INTO `engine4_core_menuitems` (`id`, `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES (NULL, 'company_profile_followship', 'company', 'Member', 'Company_Plugin_Menus', '', 'company_profile', '', '1', '0', '4');
  INSERT INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `editable`, `is_generated`) VALUES ('company_follow', 'company', '{item:$subject} followed the company {item:$object}', '1', '3', '1', '1', '1', '0', '1');
  INSERT INTO `engine4_core_menuitems` (`id`, `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES (NULL, 'company_profile_claim', 'company', 'Claim Company', 'Company_Plugin_Menus', '', 'company_profile', '', '1', '0', '8');
    
CREATE TABLE `engine4_company_claims` (
  `claim_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `engine4_company_claims`
  ADD PRIMARY KEY (`claim_id`);

ALTER TABLE `engine4_company_claims`
  MODIFY `claim_id` int(11) NOT NULL AUTO_INCREMENT; 
  
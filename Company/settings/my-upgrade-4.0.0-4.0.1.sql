ALTER TABLE `engine4_company_groups` ADD COLUMN `postal_code` varchar(256);
ALTER TABLE `engine4_company_groups` ADD COLUMN `address_one` varchar(256);
ALTER TABLE `engine4_company_groups` ADD COLUMN `address_two` varchar(256);
ALTER TABLE `engine4_company_groups` ADD COLUMN `website` varchar(256);
ALTER TABLE `engine4_company_groups` ADD COLUMN `state_corp` varchar(256);



ALTER TABLE `engine4_company_groups` ADD COLUMN `country_id` int(11) DEFAULT 0;
ALTER TABLE `engine4_company_groups` ADD COLUMN `state_id` int(11) DEFAULT 0;
ALTER TABLE `engine4_company_groups` ADD COLUMN `city_id` int(11) DEFAULT 0;
ALTER TABLE `engine4_company_groups` ADD COLUMN `industry_id` int(11);
ALTER TABLE `engine4_company_groups` ADD COLUMN `sector_id` int(11);


ALTER TABLE `engine4_company_groups` ADD COLUMN `companytype` int(11) DEFAULT 1;

ALTER TABLE `engine4_company_membership`  ADD `association` VARCHAR(256) NULL  AFTER `title`;
ALTER TABLE `engine4_company_membership`  ADD `graduation` VARCHAR(256) NULL  AFTER `title`;

INSERT INTO `engine4_core_menuitems` (`id`, `name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES (NULL, 'company_admin_main_relationship', 'company', 'Association', '', '{"route":"admin_default","module":"company","controller":"settings","action”:"association"}', 'company_admin_main', '', '1', '0', '5');


CREATE TABLE `engine4_company_relationships` (
  `relationship_id` int(11) NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `photo_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `engine4_company_businesscontacts` (
  `contact_id` int(11) unsigned NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(15) DEFAULT '0',
  `link` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `businesstype` int(11) DEFAULT '0',
   PRIMARY KEY  (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `engine4_company_humanresource` (
  `human_resourse_id` int(11) unsigned NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(15) DEFAULT '0',
  `hrtype` int(11) DEFAULT '0',
   PRIMARY KEY  (`human_resourse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `engine4_company_companyinvestors` (
  `investor_id` int(11) unsigned NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(15) DEFAULT '0',
  `investortype` int(11) DEFAULT '0',
   PRIMARY KEY  (`investor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `engine4_company_customers` (
  `customer_id` int(11) unsigned NOT NULL auto_increment,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(15) DEFAULT '0',
  `customertype` int(11) DEFAULT '0',
   PRIMARY KEY  (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `engine4_company_industries` (
	  `industry_id` int(11) NOT NULL,
	  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
 ALTER TABLE `engine4_company_industries`
  ADD PRIMARY KEY (`industry_id`);

ALTER TABLE `engine4_company_industries`
  MODIFY `industry_id` int(11) NOT NULL AUTO_INCREMENT;
 

CREATE TABLE `engine4_company_sectors` (
  `sector_id` int(11) NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `industry_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `engine4_company_sectors`
  ADD PRIMARY KEY (`sector_id`);

ALTER TABLE `engine4_company_sectors`
  MODIFY `sector_id` int(11) NOT NULL AUTO_INCREMENT;
  
INSERT INTO `engine4_company_relationships` (`relationship_id`, `title`, `parent_id`, `photo_id`) VALUES
(NULL, 'Teacher', 0, 0),
(NULL, 'Administrator', 0, 0),
(NULL, 'Student', 0, 0),
(NULL, 'Alumni', 0, 0),
(NULL, 'Other', 0, 0);
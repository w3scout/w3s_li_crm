-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

--
-- Table `tl_member`
--

CREATE TABLE `tl_member` (
  `customerNumber` varchar(255) NOT NULL default '',
  `customerName` varchar(255) NOT NULL default '',
  `isCustomer` char(1) NOT NULL default '',
  `customerColor` varchar(6) NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_project`
--

CREATE TABLE `tl_li_project` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `toCustomer` int(10) unsigned NOT NULL default '0',
  `projectNumber` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_contact`
--

CREATE TABLE `tl_li_contact` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `pid` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `category` varchar(20) NOT NULL default '',
  `startDate` int(10) unsigned NULL default NULL,
  `startTime` int(10) unsigned NULL default NULL,
  `addEnd` char(1) NOT NULL default '',
  `endDate` int(10) unsigned NULL default NULL,
  `endTime` int(10) unsigned NULL default NULL,
  `result` varchar(32) NOT NULL default '',
  `direction` varchar(32) NOT NULL default '',
  `note` text NOT NULL,
  `addAttachment` char(1) NOT NULL default '',
  `attachment` blob NULL,
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_service`
--

CREATE TABLE `tl_li_service` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `toProject` int(10) unsigned NOT NULL default '0',
  `toServiceType` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `price` double NOT NULL default '0',
  `taxRate` double NOT NULL default '0',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_service_type`
--

CREATE TABLE `tl_li_service_type` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `icon` varchar(255) NOT NULL default '',
  `orderNumber` int(10) unsigned NOT NULL default '0',
  `standardPrice` double unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_product`
--

CREATE TABLE `tl_li_product` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `number` varchar(255) NOT NULL default '',
  `toProductType` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `price` double NOT NULL default '0',
  `taxRate` double NOT NULL default '0',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_product_to_project`
--
CREATE TABLE `tl_li_product_to_project` (
   `id` int(10) unsigned NOT NULL auto_increment,
   `tstamp` int(10) unsigned NOT NULL default '0',
   `toProduct` int(10) unsigned NOT NULL default '0',
   `toProject` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_product_type`
--

CREATE TABLE `tl_li_product_type` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `icon` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_task`
--

CREATE TABLE `tl_li_task` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `toProject` int(10) unsigned NOT NULL default '0',
  `toStatus` int(10) unsigned NOT NULL default '0',
  `toUser` int(10) unsigned NOT NULL default '0',
  `priority` int(3) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(64) NOT NULL default '',
  `deadline` varchar(10) NOT NULL default '',
  `description` text NULL,
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table `tl_li_task_status`
--

CREATE TABLE `tl_li_task_status` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `orderNumber` int(10) unsigned NOT NULL default '0',
  `icon` varchar(255) NOT NULL default '',
  `isTaskDisabled` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_task_reminder`
--
CREATE TABLE `tl_li_task_reminder` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `toTask` int(10) unsigned NOT NULL default '0',
  `remindOnce` char(1) NOT NULL default '',
  `remindDate` varchar(10) NOT NULL default '',
  `remindRepeatedly` char(1) NOT NULL default '',
  `remindInterval` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_work_package`
--

CREATE TABLE `tl_li_work_package` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `toHourlyWage` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `hourLimit` int(10) unsigned NOT NULL default '0',
  `isExternal` char(1) NOT NULL default '',
  `toProject` int(10) unsigned NOT NULL default '0',
  `printOnInvoice` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_invoice`
--

CREATE TABLE `tl_li_invoice` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `toCustomer` int(10) unsigned NOT NULL default '0',
  `toCategory` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(64) NOT NULL default '',
  `invoiceDate` varchar(10) NOT NULL default '',
  `performanceDate` varchar(10) NOT NULL default '',
  `price` double unsigned NOT NULL default '0',
  `maturity` int(10) unsigned NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `isSingular` char(1) NOT NULL default '',
  `isOut` char(1) NOT NULL default '',
  `enableGeneration` char(1) NOT NULL default '',
  `headline` varchar(255) NOT NULL default '',
  `toTemplate` int(10) unsigned NOT NULL default '0',
  `toAddress` int(10) unsigned NOT NULL default '0',
  `descriptionBefore` text NOT NULL,
  `positions` text NOT NULL,
  `descriptionAfter` text NOT NULL,
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table `tl_li_invoice_category`
--

CREATE TABLE `tl_li_invoice_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `orderNumber` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_invoice_template`
--

CREATE TABLE `tl_li_invoice_template` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `invoice_template` varchar(64) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  `maturity` int(10) unsigned NOT NULL default '0',
  `descriptionBefore` text NOT NULL,
  `descriptionAfter` text NOT NULL,
  `basePath` varchar(255) NOT NULL default '',
  `periodFolder` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_invoice_reminder`
--
CREATE TABLE `tl_li_invoice_reminder` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `toCustomer` int(10) unsigned NOT NULL default '0',
  `toInvoice` int(10) unsigned NOT NULL default '0',
  `remindOnce` char(1) NOT NULL default '',
  `remindDate` varchar(10) NOT NULL default '',
  `remindRepeatedly` char(1) NOT NULL default '',
  `remindInterval` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_working_hour`
--
CREATE TABLE `tl_li_working_hour` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NULL default '0',
  `entryDate` int(10) unsigned NULL default '0',
  `hours` int(10) unsigned NULL default '0',
  `minutes` int(10) unsigned NULL default '0',
  `toWorkPackage` int(10) unsigned NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_li_hourly_wage`
--
CREATE TABLE `tl_li_hourly_wage` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NULL default '0',
  `title` varchar(20) NOT NULL default '',
  `wage` int(10) unsigned NOT NULL default '0',
  `taxRate` double NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

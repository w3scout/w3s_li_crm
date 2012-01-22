<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Class LiplexCrmRunonce
 */
class LiplexCrmRunonce extends System
{
	/**
	 * @var Database
	 */
	protected $Database;

	/**
	 * Run the update.
	 */
	public function run()
	{
		$this->import('Database');

		if (!$this->Database->tableExists('tl_li_task_comment')) {
			// create table tl_li_task_comment
			// this is a reduces create, with the basic required fields for this update!
			$this->Database->query("CREATE TABLE `tl_li_task_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `user` int(10) unsigned NOT NULL default '0',
  `changeCustomerProject` char(1) NOT NULL default '',
  `toCustomer` int(10) unsigned NOT NULL default '0',
  `toProject` int(10) unsigned NOT NULL default '0',
  `changePriority` char(1) NOT NULL default '',
  `priority` int(3) unsigned NOT NULL default '0',
  `changeTitle` char(1) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `changeDeadline` char(1) NOT NULL default '',
  `deadline` varchar(10) NOT NULL default '',
  `previousStatus` int(10) unsigned NOT NULL default '0',
  `toStatus` int(10) unsigned NOT NULL default '0',
  `previousUser` int(10) unsigned NOT NULL default '0',
  `toUser` int(10) unsigned NOT NULL default '0',
  `comment` text NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

			// insert first comment for each task
			$this->Database->query("INSERT INTO tl_li_task_comment
					(pid,tstamp,user,changeCustomerProject,toCustomer,toProject,changePriority,priority,changeTitle,title,changeDeadline,deadline,toStatus,toUser,comment)
				SELECT id,tstamp,toUser,IF(toCustomer>0, 1, ''),toCustomer,toProject,1,priority,1,title,1,deadline,toStatus,toUser,description
				FROM tl_li_task");
		}
	}
}

$objRunonce = new LiplexCrmRunonce();
$objRunonce->run();

<?php
if (!defined('TL_ROOT'))
	die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

class CRMRunonce extends Controller
{

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();

		// Fix potential Exception on line 0 because of __destruct method (see http://dev.contao.org/issues/2236)
		$this->import((TL_MODE == 'BE' ? 'BackendUser' : 'FrontendUser'), 'User');
		$this->import('Database');
	}

	/**
	 * Run the controller
	 */
	public function run()
	{
		$currentVersion = '0.4.0';

		if (!empty($GLOBALS['TL_CONFIG']['li_crm_version']))
		{
			$this->Config->update("\$GLOBALS['TL_CONFIG']['li_crm_version']", $currentVersion);
		}
		else
		{
			$this->Config->add("\$GLOBALS['TL_CONFIG']['li_crm_version']", $currentVersion);
		}

		// If version is 0.2.0
		if ($this->Database->tableExists('tl_li_performance'))
		{
			$this->Database->execute("RENAME TABLE tl_li_performance TO tl_li_service");
			$this->Database->execute("ALTER TABLE tl_li_service CHANGE toPerformanceType toServiceType INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'");
			$this->Database->execute("RENAME TABLE tl_li_performance_type TO tl_li_service_type;");
		}

		// Updates for version 0.3.1
		if (!$this->Database->fieldExists('currency', 'tl_li_service'))
		{
			$this->Database->execute("ALTER TABLE `tl_li_service` ADD `currency` varchar(3) NOT NULL default ''");
		}
		if (!$this->Database->fieldExists('toCustomer', 'tl_li_service'))
		{
			$this->Database->execute("ALTER TABLE `tl_li_service` ADD `toCustomer` int(10) unsigned NOT NULL default '0'");
		}
		if (!$this->Database->fieldExists('currency', 'tl_li_product'))
		{
			$this->Database->execute("ALTER TABLE `tl_li_product` ADD `currency` varchar(3) NOT NULL default ''");
		}
		if ($this->Database->tableExists('tl_li_product_to_project'))
		{
			if (!$this->Database->fieldExists('toCustomer', 'tl_li_product_to_project'))
			{
				$this->Database->execute("ALTER TABLE `tl_li_product_to_project` ADD `toCustomer` int(10) unsigned NOT NULL default '0'");
			}
		}
		if (!$this->Database->fieldExists('toCustomer', 'tl_li_work_package'))
		{
			$this->Database->execute("ALTER TABLE `tl_li_work_package` ADD `toCustomer` int(10) unsigned NOT NULL default '0'");
		}
		if (!$this->Database->fieldExists('currency', 'tl_li_hourly_wage'))
		{
			$this->Database->execute("ALTER TABLE `tl_li_hourly_wage` ADD `currency` varchar(3) NOT NULL default ''");
		}

		$this->Database->execute("UPDATE tl_li_service SET currency = 'EUR' WHERE currency = ''");
		$this->Database->execute("UPDATE tl_li_product SET currency = 'EUR' WHERE currency = ''");
		$this->Database->execute("UPDATE tl_li_hourly_wage SET currency = 'EUR' WHERE currency = ''");

		$objServices = $this->Database->prepare("SELECT m.id AS customerId, s.id AS serviceId FROM tl_li_service AS s
												 INNER JOIN tl_li_project AS p ON s.toProject = p.id
												 INNER JOIN tl_member AS m ON p.toCustomer = m.id")->execute();
		while ($objServices->next())
		{
			$this->Database->prepare("UPDATE tl_li_service SET toCustomer = ? WHERE id = ?")->execute($objServices->customerId, $objServices->serviceId);
		}

		if ($this->Database->tableExists('tl_li_product_to_project'))
		{
			$objProducts = $this->Database->prepare("SELECT m.id AS customerId, pp.id AS productId FROM tl_li_product_to_project AS pp
												 	 LEFT JOIN tl_li_project AS p ON pp.toProject = p.id
												 	 INNER JOIN tl_member AS m ON p.toCustomer = m.id")->execute();
			while ($objProducts->next())
			{
				$this->Database->prepare("UPDATE tl_li_product_to_project SET toCustomer = ? WHERE id = ?")->execute($objProducts->customerId, $objProducts->productId);
			}
		}

		$objWorkPackages = $this->Database->prepare("SELECT m.id AS customerId, wp.id AS packageId FROM tl_li_work_package AS wp
													 INNER JOIN tl_li_project AS p ON p.id = wp.toProject
													 INNER JOIN tl_member AS m ON m.id = p.toCustomer")->execute();
		while ($objWorkPackages->next())
		{
			$this->Database->prepare("UPDATE tl_li_work_package SET toCustomer = ? WHERE id = ?")->execute($objWorkPackages->customerId, $objWorkPackages->packageId);
		}

		if ($this->Database->tableExists('tl_li_product_to_project'))
		{
			$this->Database->execute("RENAME TABLE tl_li_product_to_project TO tl_li_product_to_customer");
		}

		// Updates for version 0.4.0
		if (!$this->Database->fieldExists('toCustomer', 'tl_li_task'))
		{
			$this->Database->execute("ALTER TABLE `tl_li_task` ADD `toCustomer` int(10) unsigned NOT NULL default '0'");
			$objTasks = $this->Database->prepare("SELECT t.id AS taskId, m.id AS customerId
												  FROM tl_li_task AS t
												  INNER JOIN tl_li_project AS p ON p.id = t.toProject
												  INNER JOIN tl_member AS m ON m.id = p.toCustomer")->execute();
			while ($objTasks->next())
			{
				$this->Database->prepare("UPDATE tl_li_task SET toCustomer = ? WHERE id = ?")->execute($objTasks->customerId, $objTasks->taskId);
			}
		}
		
		// Update for version 0.5.0
		if (!$this->Database->tableExists('tl_li_task_comment')) {
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

			// Insert first comment for each task
			$this->Database->query("INSERT INTO tl_li_task_comment
				(pid,tstamp,user,changeCustomerProject,toCustomer,toProject,changePriority,priority,changeTitle,title,changeDeadline,deadline,toStatus,toUser,comment)
				SELECT id,tstamp,toUser,IF(toCustomer>0, 1, ''),toCustomer,toProject,1,priority,1,title,1,deadline,toStatus,toUser,description
				FROM tl_li_task");
		}
		
		// Update for version 0.5.1
		if(!$this->Database->fieldExists('saleDate', 'tl_li_product_to_customer'))
		{
			$this->Database->query("ALTER TABLE `tl_li_product_to_customer` ADD `saleDate` varchar(10) NOT NULL default ''");
			$this->Database->query("UDATE tl_li_product_to_customer SET saleDate = tstamp");
		}
	}

}

/**
 * Instantiate controller
 */
$crmRunner = new CRMRunonce();
$crmRunner->run();

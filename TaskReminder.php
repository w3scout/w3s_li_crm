<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Class TaskReminder
 */
class TaskReminder extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function getCustomerOptions($dc)
	{
		$customers = array();
		$objCustomers = $this->Database->prepare("SELECT id, customerNumber, customerName FROM tl_member AS m WHERE disable = '' AND (SELECT COUNT(t.id) FROM tl_li_task AS t WHERE t.toCustomer = m.id ) > 0")->execute();
		while ($objCustomers->next())
		{
			$customers[$objCustomers->id] = $objCustomers->customerNumber." ".$objCustomers->customerName;
		}
		if (count($customers) == 0)
		{
			$customers[0] = "kein kunde";
		}
		return $customers;
	}

	public function getTaskOptions($dc)
	{
		$tasks = array();
		$objTasks = $this->Database->prepare("SELECT id, title FROM tl_li_task WHERE toCustomer = ? AND deadline >= ?")->execute($dc->activeRecord->toCustomer, strtotime(date('d.m.Y')));
		while ($objTasks->next())
		{
			$tasks[$objTasks->id] = $objTasks->title;
		}
		return $tasks;
	}

	public function getRemindDate($value, $dc)
	{
		if (true)
		{
			$objInvoice = $this->Database->prepare("SELECT deadline FROM tl_li_task WHERE id = ?")->limit(1)->execute($dc->activeRecord->toTask);
			return $this->parseDate('d.m.Y', $objInvoice->taskDate);
		}
		else
		{
			return '';
		}
	}

	public function renderLabel($row, $label)
	{
		$objTask = $this->Database->prepare("SELECT title, deadline FROM tl_li_task WHERE id = ?")->limit(1)->execute($row['toTask']);
		if ($row['toCustomer'] == '0')
		{
			$label = $GLOBALS['TL_LANG']['tl_li_task_reminder']['noCustomer']." - ".$objTask->title;
		}
		else
		{
			$objCustomer = $this->Database->prepare("SELECT customerNumber, customerName FROM tl_member WHERE id = ?")->limit(1)->execute($row['toCustomer']);
			$label = $objCustomer->customerNumber." ".$objCustomer->customerName." - ".$objTask->title;
		}
		if ($objTask->deadline < strtotime(date('d.m.Y')))
		{
			$label = '<span class="disabled">'.$label.'</span>';
		}
		return $label;
	}

}
?>
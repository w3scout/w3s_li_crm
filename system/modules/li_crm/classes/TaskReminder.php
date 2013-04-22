<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace W3S\LiCRM;

/**
 * Class TaskReminder
 */
class TaskReminder extends \Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function getTaskOptions()
	{
        // Get all tasks whose deadline hasn't passed yet
		$objTasks = $this->Database->prepare("
			SELECT t.id, t.title, p.title AS project, c.customerNumber, c.customerName
		    FROM tl_li_task as t
            LEFT JOIN tl_li_project AS p
            	ON t.toProject = p.id
            LEFT JOIN tl_member AS c
            	ON t.toCustomer = c.id
		    WHERE deadline >= ?
		    ORDER BY c.customerNumber, p.title, t.title
		")->execute(strtotime(date('d.m.Y')));

		$tasks = array();
		while ($objTasks->next())
		{
            $customer   = $objTasks->customerNumber != '' ? $objTasks->customerNumber." ".$objTasks->customerName : $GLOBALS['TL_LANG']['tl_li_task_reminder']['noCustomer'];
            $project    = $objTasks->project != '' ? $objTasks->project : $GLOBALS['TL_LANG']['tl_li_task_reminder']['noProject'];

			$tasks[$customer.' - '.$project][$objTasks->id] = $objTasks->title;
		}
        
		return $tasks;
	}

	public function getRemindDate($value, $dc)
	{
        $objInvoice = $this->Database->prepare("SELECT deadline
                                                FROM tl_li_task
                                                WHERE id = ?")
                                     ->limit(1)
                                     ->execute($dc->activeRecord->toTask);

        return $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->taskDate);
	}

	public function renderLabel($row)
	{
        // Get the data of the linked task and its project and customer data (if any)
		$objTask = $this->Database->prepare("
			SELECT t.title, t.deadline, p.title AS project, m.customerName
            FROM tl_li_task AS t
            LEFT JOIN tl_li_project AS p
            	ON t.toProject = p.id
            LEFT JOIN tl_member AS m
            	ON p.toCustomer = m.id
		    WHERE t.id = ?")->limit(1)->execute($row['toTask']);
        
        $label = $objTask->customerName != '' ? $objTask->customerName : $GLOBALS['TL_LANG']['tl_li_task_reminder']['noCustomer'];
        $label .= ' - ';
        $label .= $objTask->project != '' ? $objTask->project : $GLOBALS['TL_LANG']['tl_li_task_reminder']['noProject'];
        $label .= ' - ';
        $label .= $objTask->title;

        // Check if the deadline already passed the current date and adjust the formatting
		if ($objTask->deadline < strtotime(date('d.m.Y')))
		{
			$label = '<span class="disabled">'.$label.'</span>';
		}

		return $label;
	}
}

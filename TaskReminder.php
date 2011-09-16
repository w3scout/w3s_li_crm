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

    /**
     * Gets all tasks and order them in an array that can be used to create a select-list of all tasks. Groups
     * by customers and projects
     *
     * @return array The tasks as a nested array
     */
	public function getTaskOptions()
	{
        // Get all tasks whose deadline hasn't passed yet
		$objTasks = $this->Database->prepare("SELECT t.id, t.title, p.title AS project, c.customerName
		    FROM tl_li_task as t
                LEFT JOIN tl_li_project AS p ON t.toProject = p.id
                LEFT JOIN tl_member AS c ON p.toCustomer = c.id
		    WHERE deadline >= ?
		    ORDER BY c.customerName, p.title, t.title")->execute(strtotime(date('d.m.Y')));

		$tasks = array();
		while ($objTasks->next())
		{
            $customer = $objTasks->customerName != '' ? $objTasks->customerName : $GLOBALS['TL_LANG']['tl_li_task_reminder']['noCustomer'];
            $project = $objTasks->project != '' ? $objTasks->project : $GLOBALS['TL_LANG']['tl_li_task_reminder']['noProject'];

			$tasks[$customer.' - '.$project][$objTasks->id] = $objTasks->title;
		}
        
		return $tasks;
	}

	public function getRemindDate($value, $dc)
	{
        $objInvoice = $this->Database->prepare("SELECT deadline
            FROM tl_li_task
            WHERE id = ?")->limit(1)->execute($dc->activeRecord->toTask);

        return $this->parseDate('d.m.Y', $objInvoice->taskDate);
	}

    /**
     * Renders the label of a task to be displayed in a list
     *
     * @param $row The current row to be rendered
     * @return string The rendered label
     */
	public function renderLabel($row)
	{
        // Get the data of the linked task and its project and customer data (if any)
		$objTask = $this->Database->prepare("SELECT t.title, t.deadline, p.title AS project, m.customerName
            FROM tl_li_task AS t
                LEFT JOIN tl_li_project AS p ON t.toProject = p.id
                LEFT JOIN tl_member AS m ON p.toCustomer = m.id
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
    
    public function getGroupLabel()
    {
        return 'test';
    }
}
?>

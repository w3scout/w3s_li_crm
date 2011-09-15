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
 * Class Task
 */
class Task extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->title);
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_li_task WHERE alias=?")->execute($varValue);

		// Check whether the news alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-'.$dc->id;
		}

		return $varValue;
	}

	public function renderLabel($row, $label)
	{
		$statusIcon = '<img src="system/modules/li_crm/icons/status_default.png" alt="'
                      .$GLOBALS['TL_LANG']['tl_li_task']['defaultIcon'].'" style="vertical-align:-3px;" />';

		if ($row['toStatus'] != 0)
		{
			$objStatus = $this->Database->prepare("SELECT title, icon, isTaskDisabled
			    FROM tl_li_task_status
			    WHERE id = ?")
                    ->limit(1)
                    ->execute($row['toStatus']);

			if ($objStatus->icon != '')
			{
				$statusIcon = '<img src="'.$objStatus->icon.'" alt="'.$objStatus->title.'" style="vertical-align: -3px;" />';
			}
			if ($objStatus->isTaskDisabled)
			{
				$taskDisabled = true;
			}
		}

		if ($row['toProject'] != 0)
		{
			$objCustomer = $this->Database->prepare("SELECT c.customerNumber, c.customerName
			    FROM tl_li_project AS p
			        INNER JOIN tl_member AS c ON p.toCustomer = c.id
			    WHERE p.id = ?")
                    ->limit(1)
                    ->execute($row['toProject']);

			$customer = $objCustomer->customerNumber." ".$objCustomer->customerName;
		}
		else
		{
			$customer = $GLOBALS['TL_LANG']['tl_li_task']['noCustomer'];
		}

		if (!$taskDisabled)
		{
			$priorityIcon = '<img src="system/modules/li_crm/icons/priority_'.$row['priority'].'.png" alt="'
                            .$GLOBALS['TL_LANG']['tl_li_task']['priority'][0].' '.$row['priority'].'" style="vertical-align:-3px;" />';

			return $priorityIcon." ".$statusIcon." ".$customer." - ".$row['title'];
		}
		else
		{
			$priorityIcon = '<img src="system/modules/li_crm/icons/priority_'.$row['priority'].'_disabled.png" alt="'
                            .$GLOBALS['TL_LANG']['tl_li_task']['priority'][0].' '.$row['priority'].'" style="vertical-align:-3px;" />';
            
			return $priorityIcon." ".$statusIcon." <span class=\"disabled\">".$customer." - ".$row['title']."</span>";
		}
	}

	public function getPriorityOptions($dc)
	{
		$options = array();
		for ($i = 1; $i <= 5; $i++)
		{
			$options[$i] = $GLOBALS['TL_LANG']['tl_li_task']['priority'][0]." ".$i;
		}
		return $options;
	}

}
?>
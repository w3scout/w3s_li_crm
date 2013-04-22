<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>, Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace W3S\LiCRM;

/**
 * Class TaskStatus
 */
class TaskStatus extends \Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function renderLabel($row, $label)
	{
		if ($row['icon'] != '')
		{
			return '<img src="'.$row['icon'].'" alt="'.$row['title'].'" /> '.$row['title'];
		}
		else
		{
			return '<img src="system/modules/li_crm/assets/status_default.png" alt="'.$GLOBALS['TL_LANG']['tl_li_task_status']['defaultIcon'].'" /> '.$row['title'];
		}
	}

	public function renderGroup($row)
	{
        return $GLOBALS['TL_LANG']['tl_li_task_status']['orderNumber'][0]." ".$row;
	}
}

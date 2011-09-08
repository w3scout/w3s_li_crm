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
 * Class TaskStatus
 */
class TaskStatus extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function renderLabel($row, $label)
	{
		if ($row['icon'] != '')
		{
			return "<img src=\"".$row['icon']."\" alt=\"".$row['title']."\" /> ".$row['title'];
		}
		else
		{
			return "<img src=\"system/modules/li_crm/icons/status_default.png\" alt=\"".$GLOBALS['TL_LANG']['tl_li_task_status']['defaultIcon']."\" /> ".$row['title'];
		}
	}

	public function renderGroup($row)
	{
		return $GLOBALS['TL_LANG']['tl_li_task_status']['orderNumber'][0]." ".$row['orderNumber'];
	}

}
?>
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
 * Class ServiceType
 */
class ServiceType extends Controller
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
			return "<img src=\"system/modules/li_crm/icons/service_default.png\" alt=\"".$GLOBALS['TL_LANG']['tl_li_service_type']['defaultIcon']."\" /> ".$row['title'];
		}
	}

}
?>
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
 * Class Contact
 */
class Contact extends \Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function renderLabel($arrContact)
	{
		$categoryIcon = '<img src="system/modules/li_crm/icons/'.$arrContact['category'].'_'.$arrContact['direction'].'.png" style="vertical-align:-3px;" alt="" />';
		$reachedIcon = '<img src="system/modules/li_crm/icons/'.$arrContact['result'].'.png" style="vertical-align:-3px;" alt="" />';
		$date = date('d.m.Y', $arrContact['startDate'])." ".date('H:i', $arrContact['startTime']);
		$title = $arrContact['title'];

		return $categoryIcon." ".$reachedIcon." ".$date." - ".$title;
	}
}

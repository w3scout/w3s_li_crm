<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

class Contact extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	public function renderLabel($arrContact)
	{
		$categoryIcon = '<img src="/system/modules/li_crm/icons/'.$arrContact['category'].'_'.$arrContact['direction'].'.png" style="vertical-align:-3px;" alt="" />';
		$reachedIcon = '<img src="/system/modules/li_crm/icons/'.$arrContact['result'].'.png" style="vertical-align:-3px;" alt="" />';
		$date = date('d.m.Y', $arrContact['startDate'])." ".date('H:i', $arrContact['startTime']);
		$title = $arrContact['title'];

		return $categoryIcon." ".$reachedIcon." ".$date." - ".$title;
	}

}
?>
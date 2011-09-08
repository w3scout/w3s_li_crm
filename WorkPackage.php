<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

class WorkPackage extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
	
	public function getWorkPackages()
	{
		$workPackages = array();
		$getWorkPackages = $this->Database->prepare("SELECT *
			FROM tl_li_work_package")->execute();
		
		while ($getWorkPackages->next())
		{
			$workPackages[$getWorkPackages->id] = $getWorkPackages->title.' ('.$getWorkPackages->hourLimit.')';
		}
		
		return $workPackages;
	}
}
?>
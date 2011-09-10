<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright	Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author		Christian Kolb <info@liplex.de>
 * @author		apoy2k
 * @license		MIT (see /LICENSE.txt for further information)
 */
class WorkPackage extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
	
	/**
	 * Gets all work packages and returns them as an array of strings. The amount of already written hours
	 * and the hour limit is displayed, too.
	 * 
	 * @return array All work packages
	 */
	public function getWorkPackages()
	{
		$workPackages = array();
		$getWorkPackages = $this->Database->prepare("SELECT wp.id, wp.title, wp.hourLimit,
				(SUM(wh.hours) * 60 + SUM(wh.minutes)) AS sumMinutes
			FROM tl_li_work_package wp
				LEFT JOIN tl_li_working_hours wh ON wh.toWorkPackage = wp.id
			GROUP BY wp.id
			ORDER BY id")->execute();
		
		while ($getWorkPackages->next())
		{
			// Calculate the amount of full hours and minutes worked on a package
			$minutes = $getWorkPackages->sumMinutes % 60;
			$hours = ($getWorkPackages->sumMinutes - $minutes) / 60;
			
			$workPackages[$getWorkPackages->id] = $getWorkPackages->title.
				' ('.$hours.'h'.(!empty($minutes) ? ' '.$minutes.'m ' : ' ').'/ ' .$getWorkPackages->hourLimit.'h)';
		}
		
		return $workPackages;
	}
}

<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
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
				LEFT JOIN tl_li_working_hour wh ON wh.toWorkPackage = wp.id
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
    
    /**
     * Generates a label from a given work package entry
     * 
     * @param array $row The database row of the work package
     * @return string The generated label
     */
    public function getLabel($row)
    {
        // Get all necessary information
        $getRow = $this->Database->prepare("SELECT hw.title
            FROM tl_li_hourly_wage hw
            WHERE hw.id = ?")->execute($row['toHourlyWage']);
        
        return $row['title'].' ('.$row['hourLimit'].'h - '.$getRow->title.')';
    }
    
    /**
     * Gets a label of a group or returns a default label for groups without one
     * 
     * @param string $currentLabel The current label of a group
     * @return string The group label
     */
    public function getGroupLabel($currentLabel)
    {
        // Only modify the label if it's a numeric id - meaning that the foreignKey wasn't matchen
        if (!empty($currentLabel))
            return $currentLabel;
        
		// Load language file for workpackages
		$this->loadLanguageFile('tl_li_work_package');
        
        return $GLOBALS['TL_LANG']['tl_li_work_package']['internal'];
    }
}

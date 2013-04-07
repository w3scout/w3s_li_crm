<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class WorkPackage
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
		$getWorkPackages = $this->Database->prepare("
			SELECT wp.id, wp.title, wp.hourLimit, (SUM(wh.hours) * 60 + SUM(wh.minutes)) AS sumMinutes
			FROM tl_li_work_package wp
			LEFT JOIN tl_li_working_hour wh
				ON wh.toWorkPackage = wp.id
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
    
    public function getLabel($row)
    {
        // Get all necessary information
        $getRow = $this->Database->prepare("
        	SELECT hw.title
            FROM tl_li_hourly_wage hw
            WHERE hw.id = ?
        ")->execute($row['toHourlyWage']);
        
        return $row['title'].' ('.$row['hourLimit'].'h - '.$getRow->title.')';
    }
    
    public function getGroupLabel($group, $sortingMode, $firstOrderBy, $row, $dc)
    {
        $customerId = $row['toCustomer'];
        if($customerId != 0) {
            $objCustomer = $this->Database->prepare("
            	SELECT customerNumber, customerName
                FROM tl_member
                WHERE id = ?
            ")->execute($customerId);
            $customer = $objCustomer->customerNumber.' '.$objCustomer->customerName;
            return $customer;
        } else {
            $this->loadLanguageFile('tl_li_work_package');
            return $GLOBALS['TL_LANG']['tl_li_work_package']['internal'];
        }
    }
}

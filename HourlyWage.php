<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
class HourlyWage extends Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }
    
    /**
     * Gets all hourly wages as an array that can be used to generate a select list
     * 
     * @return array The list of hourly wages
     */
    public function getHourlyWagesList()
    {
        $getHourlyWages = $this->Database->prepare("SELECT id, title, wage
            FROM tl_li_hourly_wage
            ORDER BY title")->execute();
        
        $hourlyWages = array();
        while($getHourlyWages->next())
        {
            $hourlyWages[$getHourlyWages->id] = $getHourlyWages->title.' ('.$getHourlyWages->wage.')';
        }
        
        return $hourlyWages;
    }
}

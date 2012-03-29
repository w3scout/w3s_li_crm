<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class HourlyWage
 */
class HourlyWage extends Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }
    
    public function getHourlyWagesList()
    {
        $getHourlyWages = $this->Database->prepare("
        	SELECT id, title, wage, currency
            FROM tl_li_hourly_wage
            ORDER BY title
        ")->execute();
        
        $hourlyWages = array();
        while($getHourlyWages->next())
        {
            $hourlyWages[$getHourlyWages->id] = $getHourlyWages->title.' ('.$getHourlyWages->wage.' '.$getHourlyWages->currency.')';
        }
        
        return $hourlyWages;
    }
    
    public function renderLabel($row, $label)
    {
    	return '('.$this->getFormattedNumber($row['wage']).') '.$row['title'];
    }
}

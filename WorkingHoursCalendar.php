<?php

/**
 * @copyright	
 * @author		apoy2k
 * @license		
 */
class WorkingHoursCalendar extends BackendModule
{
	protected $strTemplate = 'be_working_hours_calendar';
	
	public function generate()
	{
		parent::generate();
		
		// Get the desired week range or set default values
		$week = empty($_POST['tl_li_week']) ? date('W') : $_POST['tl_li_week'];
		
		// Save the desired week range for display
		$this->Template->week = $week;
		
		// Only get the working hours in the desired week range
		$getWorkingHours = $this->Database->prepare("SELECT wh.id,
				WEEKDAY(FROM_UNIXTIME(wh.li_crm_date)) as weekday, wh.hours, wp.hourLimit, c.customerColor,
				c.id as customerId, wp.id as workPackageId
			FROM tl_li_working_hours wh
			INNER JOIN tl_li_work_package wp
				ON wh.toWorkPackage = wp.id
			LEFT JOIN tl_member c
				ON wp.toCustomer = c.id
			WHERE hours IS NOT NULL
				AND WEEK(FROM_UNIXTIME(li_crm_date)) = ".$week."
			ORDER BY li_crm_date")->execute();
		
		// Build an array of the working hours per day. The first index is the week of the year,
		// the second is the day within that week. This array is iterated on the calendar,
		// building the complete calendar
		$hours = array();
		while ($getWorkingHours->next())
		{
			$entry = array(
				'id' => $getWorkingHours->id,
				'hours' => $getWorkingHours->hours,
				'hourLimit' => $getWorkingHours->hourLimit,
				'customerColor' => $getWorkingHours->customerColor,
				'customerId' => $getWorkingHours->customerId,
				'workPackageId' => $getWorkingHours->workPackageId,
			);
			
			$hours[$getWorkingHours->weekday][] = $entry;
		}
		
		$this->loadLanguageFile('tl_li_working_hours');
		$lang = $GLOBALS['TL_LANG']['tl_li_working_hours'];
		
		$this->Template->hours = $hours;
		$this->Template->lang = $lang;
		
		return $this->Template->parse();
	}
	
	protected function compile()
	{
	}
}

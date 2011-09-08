<?php

/**
 * @copyright	
 * @author		apoy2k
 * @license		
 */
class WorkingHoursCalendar extends BackendModule
{
	protected $strTemplate = 'be_time_keeping_calendar';
	
	public function generate()
	{
		parent::generate();
		
		// Get the desired week range or set default values
		$startWeek = empty($_POST['startWeek']) ? date('W') : $_POST['startWeek'];
		$endWeek = empty($_POST['endWeek']) ? date('W') + 4 : $_POST['endWeek'];
		
		// Save the desired week range for display
		$this->Template->startWeek = $startWeek;
		$this->Template->endWeek = $endWeek;
		
		// Only get the working hours in the desired week range
		$getWorkingHours = $this->Database->prepare("SELECT id, WEEK(FROM_UNIXTIME(tstamp)) as week,
				WEEKDAY(FROM_UNIXTIME(tstamp)) as weekday, hours, toWorkPackage
			FROM tl_li_working_hours
			WHERE hours IS NOT NULL
				AND WEEK(FROM_UNIXTIME(tstamp)) BETWEEN ".$startWeek." AND ".$endWeek."
			ORDER BY tstamp")->execute();
		
		// Build an array of the working hours per day. The first index is the week of the year,
		// the second is the day within that week. This array is iterated on the calendar,
		// building the complete calendar
		$hours = array();
		while ($getWorkingHours->next())
		{
			$entry = array();
			
			$entry['id'] = $getWorkingHours->id;
			$entry['toWorkPackage'] = $getWorkingHours->toWorkPackage;
			$entry['hours'] = $getWorkingHours->hours;
			
			$hours[$getWorkingHours->week][$getWorkingHours->weekday][] = $entry;
		}
		
		$this->loadLanguageFile('tl_li_working_hours');
		$lang = array(
			'addHoursLabel' => $GLOBALS['TL_LANG']['tl_li_working_hours']['addHours'],
			'manageWorkPackages' => $GLOBALS['TL_LANG']['tl_li_working_hours']['manageWorkPackages']
		);
		
		$this->Template->hours = $hours;
		$this->Template->lang = $lang;
		
		return $this->Template->parse();
	}
	
	protected function compile()
	{
	}
}

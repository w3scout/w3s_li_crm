<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     apoy2k
 * @license    MIT (see /LICENSE.txt for further information)
 */
class WorkingHourCalendar extends BackendModule
{
	protected $strTemplate = 'be_working_hour_calendar';

	public function generate()
	{
		parent::generate();
		
		// Get the desired week range or set default values
		if (!empty($_REQUEST['tl_li_week']))
		{
			$week = $_REQUEST['tl_li_week'];
		}
		elseif (!empty($_SESSION['tl_li_week']))
		{
			$week = $_SESSION['tl_li_week'];
		}
		else
		{
			$week = date('W');
		}
		
		// Save the displayed week in the session so it will be restored if the user leaves the page
		$_SESSION['tl_li_week'] = $week;
		
		// Save template variables for previous, current and next week numbers
		$this->Template->week = $week;
		$this->Template->prevWeek = ($week - 1 <= 0) ? 53 : $week - 1;
		$this->Template->nextWeek = ($week + 1 > 53) ? 1 : $week + 1;

		// Get the configured week mode from the configuration
		$weekMode = !empty($GLOBALS['TL_CONFIG']['li_crm_timekeeping_week_mode']) ?
			$GLOBALS['TL_CONFIG']['li_crm_timekeeping_week_mode'] : '7';

		// Only get the working hours in the desired week range
		$getWorkingHours = $this->Database->prepare("SELECT wh.id, WEEKDAY(FROM_UNIXTIME(wh.entryDate)) as weekday,
				(wh.hours * 60 + wh.minutes) AS minutes, wp.id as workPackageId, c.customerColor
			FROM tl_li_working_hour wh
				INNER JOIN tl_li_work_package wp ON wh.toWorkPackage = wp.id
				INNER JOIN tl_li_project p ON wp.toProject = p.id
				LEFT JOIN tl_member c ON p.toCustomer = c.id
			WHERE hours IS NOT NULL
				AND WEEK(FROM_UNIXTIME(wh.entryDate), ?) = ?
			ORDER BY wh.entryDate")->execute($weekMode, $week);

		// Build an array of the working hours per day. The first index is the week of the year,
		// the second is the day within that week
		$hours = array();
		while ($getWorkingHours->next())
		{
			// Calculate the amount of full hours and minutes worked on an entry
			$minutes = $getWorkingHours->minutes % 60;
			$hoursWorked = ($getWorkingHours->minutes - $minutes) / 60;

            $entry = array(
					'id' => $getWorkingHours->id,
					'hours' => $hoursWorked,
					'minutes' => $minutes,
					'hourLimit' => $getWorkingHours->hourLimit,
					'customerColor' => $getWorkingHours->customerColor != '' ? $getWorkingHours->customerColor : 'eee',
					'customerId' => $getWorkingHours->customerId,
					'workPackageId' => $getWorkingHours->workPackageId,
			);
			
			$hours[$getWorkingHours->weekday][] = $entry;
		}

		$this->loadLanguageFile('tl_li_working_hour');
		$lang = $GLOBALS['TL_LANG']['tl_li_working_hour'];

		$this->Template->hours = $hours;
		$this->Template->lang = $lang;

		return $this->Template->parse();
	}

	protected function compile()
	{
	}

}

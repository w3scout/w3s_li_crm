<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @author     ApoY2k
 * @license    MIT (see /LICENSE.txt for further information)
 */
class Appointment extends BackendModule
{
	protected $strTemplate = 'be_dates_month';

	public function generate()
	{
		parent::generate();
		
		// Get the desired week range or set default values
		if (!empty($_REQUEST['dates_year']))
		{
			$year = $_REQUEST['dates_year'];
		}
		elseif (!empty($_SESSION['dates_year']))
		{
			$year = $_SESSION['dates_year'];
		}
		else
		{
			$year = date('Y');
		}
		
		if (!empty($_REQUEST['dates_month']))
		{
			$month = $_REQUEST['dates_month'];
		}
		elseif (!empty($_SESSION['dates_month']))
		{
			$month = $_SESSION['dates_month'];
		}
		else
		{
			$month = date('m');
		}
		
		// Save the displayed week in the session so it will be restored if the user leaves the page
		$_SESSION['dates_year'] = $year;
		$_SESSION['dates_month'] = $month;
		
		// Save template variables for previous, current and next week numbers
		$this->Template->week = $week;
		$this->Template->prevWeek = ($week - 1 <= 0) ? 53 : $week - 1;
		$this->Template->nextWeek = ($week + 1 > 53) ? 1 : $week + 1;

		// Get the configured week mode from the configuration
		$weekMode = !empty($GLOBALS['TL_CONFIG']['li_crm_timekeeping_week_mode']) ?
			$GLOBALS['TL_CONFIG']['li_crm_timekeeping_week_mode'] : '7';

		// Only get the working hours in the desired week range
		$getWorkingHours = $this->Database->prepare("SELECT wh.id, WEEKDAY(FROM_UNIXTIME(wh.entryDate)) AS weekday,
				(wh.hours * 60 + wh.minutes) AS minutes, wp.id AS workPackageId, c.customerColor
			FROM tl_li_working_hour wh
				INNER JOIN tl_li_work_package wp ON wh.toWorkPackage = wp.id
				LEFT JOIN tl_li_project p ON wp.toProject = p.id
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

		$this->loadLanguageFile('tl_li_date');

		$this->Template->hours = $hours;
		
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$days = array();
		for($i = 1; $i <= $daysInMonth; $i++) {
			$day = array();
			$day['date'] = date('d.m.Y', strtotime($year.'-'.$month.'-'.$i));
			$objDates = $this->Database->prepare("SELECT id, subject, color
												  FROM tl_li_date
												  WHERE YEAR(FROM_UNIXTIME(startDate)) = ?
												  	AND MONTH(FROM_UNIXTIME(startDate)) = ?
												  	AND DAY(FROM_UNIXTIME(startDate)) = ?")->execute($year, $month, $i);
			$dates = array();
			$counter = 1;
			$countDates = $objDates->numRows;
			while($objDates->next()) {
				$color = $objDates->color != '' ? $objDates->color : 'ddd';
				$css = 'date';
				if($counter == 1) {
					$css .= ' first';
				}
				if($counter == $countDates) {
					$css .= ' last';
				}
				$dates[] = array(
					'id' => $objDates->id,
					'subject' => $objDates->subject,
					'color' => $color,
					'css' => $css
				);
				$counter++;
			}
			$day['dates'] = $dates;
			$days[] = $day;
		}
		$this->Template->days = $days;
		
		$this->Template->year = $year;
		$this->Template->month = $month;
		
		$this->Template->prevYear = $month > 1 ? $year : $year - 1;
		$this->Template->prevMonth = $month > 1 ? $month - 1 : 12;
		
		$this->Template->nextYear = $month < 12 ? $year : $year + 1;
		$this->Template->nextMonth = $month < 12 ? $month + 1 : 1;

		return $this->Template->parse();
	}

	protected function compile()
	{
	}
}

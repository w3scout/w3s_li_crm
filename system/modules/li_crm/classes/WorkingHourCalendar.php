<?php

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>, Darko Selesi <hallo@w3scouts.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace W3S\LiCRM;

/**
 * Class WorkingHourCalendar
 */
class WorkingHourCalendar extends \BackendModule
{
	protected $strTemplate = 'be_working_hour_calendar';

	public function generate()
	{
		parent::generate();

		// Get the desired year or set default values
		if (isset($_REQUEST['tl_li_year']))
		{
			$year = $_REQUEST['tl_li_year'];
		}
		elseif (isset($_SESSION['tl_li_year']))
		{
			$year = $_SESSION['tl_li_year'];
		}
		else
		{
			$year = date('Y');
		}
		
		// Get the desired week range or set default values
		if (isset($_REQUEST['tl_li_week']))
		{
			$week = $_REQUEST['tl_li_week'];
		}
		elseif (isset($_SESSION['tl_li_week']))
		{
			$week = $_SESSION['tl_li_week'];
		}
		else
		{
			$week = date('W');
		}

		// catch 0 week and greater than 53 week
		if( $week <= 0 )
		{
			$year--;
			$week = $week + 53;
		}
		if( $week > 53 )
		{
			$year++;
			$week = $week - 53;
		} 

		// clamp the week
		$week = min( 53, max( 1, $week ) );

		// Save the displayed week and year in the session so it will be restored if the user leaves the page
		$_SESSION['tl_li_week'] = $week;
		$_SESSION['tl_li_year'] = $year;
		
		// Save template variables for previous, current and next week numbers
		$this->Template->week = $week;
		$this->Template->prevWeek = $week - 1;
		$this->Template->nextWeek = $week + 1;
		$this->Template->year = $year;

		// Get the configured week mode from the configuration
		$weekMode = 3;//!empty($GLOBALS['TL_CONFIG']['li_crm_timekeeping_week_mode']) ?	$GLOBALS['TL_CONFIG']['li_crm_timekeeping_week_mode'] : '3';

		// Only get the working hours in the desired week range
		$getWorkingHours = $this->Database->prepare("SELECT wh.id, WEEKDAY(FROM_UNIXTIME(wh.entryDate)) AS weekday,
				(wh.hours * 60 + wh.minutes) AS minutes, wp.id AS workPackageId, c.customerColor,
				u.username AS username, u.name as `user`, wh.description as description
			FROM tl_li_working_hour wh
				INNER JOIN tl_li_work_package wp ON wh.toWorkPackage = wp.id
				LEFT JOIN tl_li_project p ON wp.toProject = p.id
				LEFT JOIN tl_member c ON p.toCustomer = c.id
				LEFT JOIN tl_user u ON wh.user = u.id
			WHERE hours IS NOT NULL
				AND WEEK(FROM_UNIXTIME(wh.entryDate), ?) = ?
				AND YEAR(FROM_UNIXTIME(wh.entryDate)) = ?
			ORDER BY wh.entryDate")->execute($weekMode, $week, $year);

		// Build an array of the working hours per day. The first index is the week of the year,
		// the second is the day within that week
		$hours = array();
		while ($getWorkingHours->next())
		{
			// Calculate the amount of full hours and minutes worked on an entry
			$minutes = $getWorkingHours->minutes % 60;
			$hoursWorked = ($getWorkingHours->minutes - $minutes) / 60;

			$entry = array(
				'id'            => $getWorkingHours->id,
				'hours'         => $hoursWorked,
				'minutes'       => $minutes,
				'hourLimit'     => $getWorkingHours->hourLimit,
				'customerColor' => $getWorkingHours->customerColor != '' ? $getWorkingHours->customerColor : 'eee',
				'customerId'    => $getWorkingHours->customerId,
				'workPackageId' => $getWorkingHours->workPackageId,
				'user'          => $getWorkingHours->user ? $getWorkingHours->user : $getWorkingHours->username,
				'description'   => $getWorkingHours->description,
				'foo'           => $getWorkingHours->row()
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

	/**
	 * DataContainer submit callback
	 *
	 * @param DataContainer $dc
	 */
	public function onSubmit(DataContainer $dc)
	{
		// if there is a task comment associated to this working hour ...
		$objComment = $this->Database
			->prepare("SELECT * FROM tl_li_task_comment WHERE working_hour_dataset=?")
			->execute($dc->id);

		if ($objComment->next()) {
			// ... update the hours and minutes of the task comment
			$this->Database
				->prepare("UPDATE tl_li_task_comment SET hours=?, minutes=?, toWorkPackage=? WHERE id=?")
				->execute($dc->activeRecord->hours, $dc->activeRecord->minutes, $dc->activeRecord->toWorkPackage, $objComment->id);
		}
	}

	/**
	 * DataContainer delete callback
	 *
	 * @param DataContainer $dc
	 */
	public function onDelete(DataContainer $dc)
	{
		// if there is a task comment associated to this working hour ...
		$objComment = $this->Database
			->prepare("SELECT * FROM tl_li_task_comment WHERE working_hour_dataset=?")
			->execute($dc->id);

		if ($objComment->next()) {
			// ... remove the time tracking
			$this->Database
				->prepare("UPDATE tl_li_task_comment SET keeptime=? WHERE id=?")
				->execute('', $objComment->id);
		}
	}
}

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
	public function generate()
	{
		$this->import('BackendUser', 'User');

		$view = $this->Input->get('view');

		if($view == '' or ($view != 'week' && $view != 'day'))
		{
			$this->Template = new BackendTemplate('be_appointments_month');
			$this->showAppointmentsOfThisMonth();
		}
		elseif($view == 'week')
		{
			$this->Template = new BackendTemplate('be_appointments_week');
			$this->showAppointmentsOfThisWeek();
		}
		elseif($view == 'day')
		{
			$this->Template = new BackendTemplate('be_appointments_day');
			$this->showAppointmentsOfThisDay();
		}
		
		return $this->Template->parse();
	}
	
	private function showAppointmentsOfThisMonth() {
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

		$this->loadLanguageFile('tl_li_appointment');
		
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$days = array();
		for($i = 1; $i <= $daysInMonth; $i++) {
			$day = array();
			$currentDate = strtotime($year.'-'.$month.'-'.$i);
			$day['date'] = date('d.m.Y', $currentDate);
			$dayOfWeek = date('w', $currentDate) + 1;
			$week = date('W', $currentDate);
			$objDates = $this->Database->prepare("SELECT id, creator, subject, participants, startDate, color
												  FROM tl_li_appointment
												  WHERE
												  (
												  	YEAR(FROM_UNIXTIME(startDate)) = ?
												  	AND MONTH(FROM_UNIXTIME(startDate)) = ?
												  	AND DAY(FROM_UNIXTIME(startDate)) = ?
												  )
												  OR
												  (
												  	repetition = 1
												  	AND period = 'weekly'
												  	AND DAYOFWEEK(FROM_UNIXTIME(startdate)) = ?
												  	AND
												  	(
												  		(
												  			WEEK(FROM_UNIXTIME(startdate)) < ?
												  			AND YEAR(FROM_UNIXTIME(startDate)) = ?
												  		)
												  		OR
												  		(
												  			YEAR(FROM_UNIXTIME(startDate)) < ?
												  		)
												  	)
												  )")->execute($year, $month, $i, $dayOfWeek, $week, $year, $year);
			$dates = array();
			$countDates = $objDates->numRows;
			while($objDates->next()) {
				// User has to be creator, a participant or an admin
				// Skip check if user is admin
				if(!$this->User->isAdmin) {
					$userId = $this->User->id;
					// Skip appointment if appointment is private and user is not creator
					if($userId != $objDates->creator && $objDates->private) {
						continue;
					}
					$found = $userId == $objDates->creator;
					$participants = unserialize($objDates->participants);
					if(!$found && $participants) {
						foreach($participants as $participant) {
							if($participant == $userId) {
								$found = true;
								break;
							}
						}
					}
					if(!$found) {
						continue;
					}
				}
				
			
				$color = $objDates->color != '' ? $objDates->color : 'ddd';
				$dates[] = array(
					'id' => $objDates->id,
					'subject' => $objDates->subject,
					'color' => $color
				);
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
	}

	private function showAppointmentsOfThisWeek() {
		
	}
	
	private function showAppointmentsOfThisDay() {
		
	}

	protected function compile() {}
}

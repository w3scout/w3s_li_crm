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
		$this->loadLanguageFile('tl_li_appointment');
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
		if (!empty($_REQUEST['appointments_year']))
		{
			$year = $_REQUEST['appointments_year'];
		}
		elseif (!empty($_SESSION['appointments_year']))
		{
			$year = $_SESSION['appointments_year'];
		}
		else
		{
			$year = date('Y');
		}
		
		if (!empty($_REQUEST['appointments_month']))
		{
			$month = $_REQUEST['appointments_month'];
		}
		elseif (!empty($_SESSION['appointments_month']))
		{
			$month = $_SESSION['appointments_month'];
		}
		else
		{
			$month = date('m');
		}
		
		// Save the displayed month and year in the session so they will be restored if the user leaves the page
		$_SESSION['appointments_year'] = $year;
		$_SESSION['appointments_month'] = $month;
		
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$days = array();
		for($i = 1; $i <= $daysInMonth; $i++) {
			$day = array();
			$currentDate = strtotime($year.'-'.$month.'-'.$i);
			$day['date'] = date('d.m.Y', $currentDate);
			$dayOfWeek = date('w', $currentDate) + 1;
			$week = date('W', $currentDate);
			$evenWeek = $week % 2 == 0 ? '0' : '1';
			$objAppointments = $this->Database->prepare("
				SELECT id, creator, subject, participants, startDate, color
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
						OR(YEAR(FROM_UNIXTIME(startDate)) < ?)
					)
				)
				OR
				(
					repetition = 1
					AND period = 'biweekly'
					AND DAYOFWEEK(FROM_UNIXTIME(startdate)) = ?
					AND WEEK(FROM_UNIXTIME(startdate)) % 2 = ?
					AND
						(
							(
								WEEK(FROM_UNIXTIME(startdate)) < ?
								AND YEAR(FROM_UNIXTIME(startDate)) = ?
							)
							OR(YEAR(FROM_UNIXTIME(startDate)) < ?)
						)
					)
				OR
				(
					repetition = 1
					AND period = 'monthly'
					AND DAYOFMONTH(FROM_UNIXTIME(startdate)) = ?
					AND
					(
						(
							MONTH(FROM_UNIXTIME(startdate)) < ?
							AND YEAR(FROM_UNIXTIME(startDate)) = ?
						)
						OR(YEAR(FROM_UNIXTIME(startDate)) < ?)
					)
				)")->execute($year, $month, $i, $dayOfWeek, $week, $year, $year, $dayOfWeek, $evenWeek, $week, $year, $year, $i, $month, $year, $year);
			$appointments = array();
			while($objAppointments->next()) {
				// User has to be creator, a participant or an admin
				// Skip check if user is admin
				if(!$this->User->isAdmin) {
					$userId = $this->User->id;
					// Skip appointment if appointment is private and user is not creator
					if($userId != $objAppointments->creator && $objAppointments->private) {
						continue;
					}
					$found = $userId == $objAppointments->creator;
					$participants = unserialize($objAppointments->participants);
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
				
			
				$color = $objAppointments->color != '' ? $objAppointments->color : 'ddd';
				$appointments[] = array(
					'id' => $objAppointments->id,
					'subject' => $objAppointments->subject,
					'color' => $color
				);
			}
			$day['appointments'] = $appointments;
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
		// Get the desired week range or set default values
		if (!empty($_REQUEST['appointments_day']))
		{
			$currentDay = $_REQUEST['appointments_day'];
		}
		elseif (!empty($_SESSION['appointments_day']))
		{
			$currentDay = $_SESSION['appointments_day'];
		}
		else
		{
			$currentDay = date($GLOBALS['TL_CONFIG']['dateFormat']);
		}
		
		// Save the displayed day in the session so it will be restored if the user leaves the page
		$_SESSION['appointments_day'] = $currentDay;
		
			$currentDate = strtotime($currentDay);
			$day = date('d', $currentDate);
			$week = date('W', $currentDate);
			$month = date('m', $currentDate);
			$year = date('Y', $currentDate);
			$dayOfWeek = date('w', $currentDate) + 1;
			$evenWeek = $week % 2 == 0 ? '0' : '1';
			$objAppointments = $this->Database->prepare("
				SELECT id, creator, subject, participants, startDate, color
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
						OR(YEAR(FROM_UNIXTIME(startDate)) < ?)
					)
				)
				OR
				(
					repetition = 1
					AND period = 'biweekly'
					AND DAYOFWEEK(FROM_UNIXTIME(startdate)) = ?
					AND WEEK(FROM_UNIXTIME(startdate)) % 2 = ?
					AND
						(
							(
								WEEK(FROM_UNIXTIME(startdate)) < ?
								AND YEAR(FROM_UNIXTIME(startDate)) = ?
							)
							OR(YEAR(FROM_UNIXTIME(startDate)) < ?)
						)
					)
				OR
				(
					repetition = 1
					AND period = 'monthly'
					AND DAYOFMONTH(FROM_UNIXTIME(startdate)) = ?
					AND
					(
						(
							MONTH(FROM_UNIXTIME(startdate)) < ?
							AND YEAR(FROM_UNIXTIME(startDate)) = ?
						)
						OR(YEAR(FROM_UNIXTIME(startDate)) < ?)
					)
				)")->execute($year, $month, $day, $dayOfWeek, $week, $year, $year, $dayOfWeek, $evenWeek, $week, $year, $year, $day, $month, $year, $year);
			$appointments = array();
			while($objAppointments->next()) {
				// User has to be creator, a participant or an admin
				// Skip check if user is admin
				if(!$this->User->isAdmin) {
					$userId = $this->User->id;
					// Skip appointment if appointment is private and user is not creator
					if($userId != $objAppointments->creator && $objAppointments->private) {
						continue;
					}
					$found = $userId == $objAppointments->creator;
					$participants = unserialize($objAppointments->participants);
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
				
				$color = $objAppointments->color != '' ? $objAppointments->color : 'f6f6f6';
				$appointments[] = array(
					'id' => $objAppointments->id,
					'subject' => $objAppointments->subject,
					'color' => $color
				);
			}
		
		$this->Template->appointments = $appointments;
			
		$this->Template->day = $currentDay;
		$this->Template->prevDay = date($GLOBALS['TL_CONFIG']['dateFormat'], strtotime($currentDay.' -1 day'));
		$this->Template->nextDay = date($GLOBALS['TL_CONFIG']['dateFormat'], strtotime($currentDay.' +1 day'));
	}

	protected function compile() {}
}

<?php if (!defined('TL_ROOT')) die("You cannot access this file directly!");

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require_once('../../initialize.php');

/**
 * Class DetailsBox
 */
class DetailsBox extends Backend
{
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct();

		$this->User->authenticate();

		$this->loadLanguageFile('default');
	}


	/**
	 * Run controller and parse the template
	 */
	public function run()
	{
		$this->loadLanguageFile($this->Input->get('table'));
		$this->loadDataContainer($this->Input->get('table'));
		
		$id = $this->Input->get('id');

		$this->Template = new BackendTemplate('be_appointment_details');

		$objAppointment = $this->Database->prepare("
			SELECT m.customerNumber,
				   m.customerName,
				   u.name AS creator,
				   a.subject,
				   t.title AS task,
				   a.participants,
				   a.place,
				   a.note,
				   a.startDate,
				   a.endDate,
				   a.startTime,
				   a.endTime,
				   a.repetition,
				   a.period
			FROM tl_li_appointment AS a
			LEFT JOIN tl_member AS m
				ON m.id = a.toCustomer
			INNER JOIN tl_user AS u
				ON u.id = a.creator
			LEFT JOIN tl_li_task AS t
				ON t.id = a.toTask
			WHERE a.id = ?
		")->limit(1)->execute($id);
		if($objAppointment->numRows == 1)
		{
			$appointment = array();
			$appointment['customer'] = $objAppointment->customerNumber != '' ? $objAppointment->customerNumber." ".$objAppointment->customerName : '';
			$appointment['creator'] = $objAppointment->creator;
			$appointment['subject'] = $objAppointment->subject;
			$appointment['task'] = $objAppointment->task;
			$appointment['participants'] = $objAppointment->participants;
			$appointment['place'] = $objAppointment->place;
			$appointment['note'] = $objAppointment->note;
			$appointment['startDate'] = date($GLOBALS['TL_CONFIG']['dateFormat'], $objAppointment->startDate);
			$appointment['endDate'] = $objAppointment->endDate != 0 ? date($GLOBALS['TL_CONFIG']['dateFormat'], $objAppointment->endDate) : $appointment['startDate'];
			$appointment['startTime'] = date('H:i', $objAppointment->startTime);
			$appointment['endTime'] = date('H:i', $objAppointment->endTime);
			$appointment['repetition'] = $objAppointment->repetition == 1 ? $GLOBALS['TL_LANG']['tl_li_appointment']['periods'][$objAppointment->period] : '';
			
			$participants = unserialize($appointment['participants']);
			if($participants)
			{
				$participantsAsText = "";
				foreach($participants as $participant)
				{
					$objParticipant = $this->Database->prepare("
						SELECT name
						FROM tl_user
						WHERE id = ?
					")->limit(1)->execute($participant);
					$participantsAsText .= $objParticipant->name."<br />";
				}
				$appointment['participants'] = $participantsAsText;
			}
			
			$this->Template->appointment = $appointment;
		}

		$this->output();
	}

	/**
	 * Output the template file
	 */
	protected function output()
	{
		$this->Template->theme = $this->getTheme();
		$this->Template->base = $this->Environment->base;
		$this->Template->language = $GLOBALS['TL_LANGUAGE'];
		$this->Template->title = $GLOBALS['TL_CONFIG']['websiteTitle'];
		$this->Template->charset = $GLOBALS['TL_CONFIG']['characterSet'];

		$this->Template->output();
	}
}

/**
 * Instantiate controller
 */
$objDetailsBox = new DetailsBox();
$objDetailsBox->run();

<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class Reminder
 */
class Reminder extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
		$this->loadLanguageFile('tl_li_invoice_reminder');
		$this->loadLanguageFile('tl_li_task_reminder');
	}

	public function checkForReminder()
	{
		// Invoice reminder
		$objReminder = $this->Database->prepare("
			SELECT *
			FROM tl_li_invoice_reminder
		")->execute();
		
		while ($objReminder->next())
		{
			if ($objReminder->remindOnce)
			{
				if (date('d.m.Y', $objReminder->remindDate) == date('d.m.Y'))
				{
					$this->prepareInvoiceReminder($objReminder);
				}
			}
			if ($objReminder->remindRepeatedly)
			{
				$objInvoice = $this->Database->prepare("SELECT invoiceDate FROM tl_li_invoice WHERE id = ?")->limit(1)->execute($objReminder->toInvoice);
				if ($objReminder->remindInterval == 'daily')
				{
					$this->prepareInvoiceReminder($objReminder);
				}
				elseif ($objReminder->remindInterval == 'weekly' && date('w', $objInvoice->invoiceDate) == date('w'))
				{
					$this->prepareInvoiceReminder($objReminder);
				}
				elseif ($objReminder->remindInterval == 'monthly' && date('j', $objInvoice->invoiceDate) == date('j'))
				{
					$this->prepareInvoiceReminder($objReminder);
				}
				elseif ($objReminder->remindInterval == 'yearly' && date('z', $objInvoice->invoiceDate) == date('z'))
				{
					$this->prepareInvoiceReminder($objReminder);
				}
			}
		}
		// Task reminder
		$objReminder = $this->Database->prepare("SELECT r.toTask, t.toCustomer, r.remindOnce, r.remindDate, r.remindRepeatedly, r.remindInterval FROM tl_li_task_reminder AS r INNER JOIN tl_li_task AS t ON r.toTask = t.id WHERE deadline >= ?")->execute(strtotime(date('d.m.Y')));
		while ($objReminder->next())
		{
			if ($objReminder->remindOnce)
			{
				if (date('d.m.Y', $objReminder->remindDate) == date('d.m.Y'))
				{
					$this->prepareTaskReminder($objReminder);
				}
			}
			if ($objReminder->remindRepeatedly)
			{
				$objTask = $this->Database->prepare("SELECT deadline FROM tl_li_task WHERE id = ?")->limit(1)->execute($objReminder->toTask);
				if ($objReminder->remindInterval == 'daily')
				{
					$this->prepareTaskReminder($objReminder);
				}
				elseif ($objReminder->remindInterval == 'weekly' && date('w', $objTask->deadline) == date('w'))
				{
					$this->prepareTaskReminder($objReminder);
				}
				elseif ($objReminder->remindInterval == 'monthly' && date('j', $objTask->deadline) == date('j'))
				{
					$this->prepareTaskReminder($objReminder);
				}
				elseif ($objReminder->remindInterval == 'yearly' && date('z', $objTask->deadline) == date('z'))
				{
					$this->prepareTaskReminder($objReminder);
				}
			}
		}
	}

	private function prepareTaskReminder($reminder)
	{
		$arrReminder = array();

		$objTask = $this->Database->prepare("SELECT title, toUser, deadline FROM tl_li_task WHERE id = ?")->limit(1)->execute($reminder->toTask);

		$arrReminder['from'] = $GLOBALS['TL_CONFIG']['li_crm_task_reminder_from'];
		$arrReminder['fromName'] = $GLOBALS['TL_CONFIG']['li_crm_task_reminder_fromName'];
		$arrReminder['subject'] = $GLOBALS['TL_LANG']['tl_li_task_reminder']['subject']." - ".$objTask->title;
		$arrReminder['deadline'] = date('d.m.Y', $objTask->deadline);

		$objUser = $this->Database->prepare("SELECT username, email FROM tl_user WHERE id = ?")->limit(1)->execute($objTask->toUser);

		$receiver = array();
		$receiver[] = $objUser->email;
		$arrReminder['receiver'] = $receiver;

		$arrReminder['text'] = $this->getFormatedTextForTask($reminder, $objTask);
		$arrReminder['html'] = $this->getFormatedHTMLForTask($reminder, $objTask);

		$this->sendReminder($arrReminder);
	}

	private function getFormatedTextForTask($reminder, $objTask)
	{
		$text = $GLOBALS['TL_LANG']['tl_li_task_reminder']['subject']."\n\n";
		$text .= sprintf($GLOBALS['TL_LANG']['tl_li_task_reminder']['text'], $objTask->title, date($GLOBALS['TL_CONFIG']['dateFormat'], $objTask->deadline));
		if ($reminder->toCustomer != 0)
		{
			$objCustomer = $this->Database->prepare("SELECT customerNumber, customerName FROM tl_member WHERE id = ?")->limit(1)->execute($reminder->toCustomer);
			$text .= "\n".sprintf($GLOBALS['TL_LANG']['tl_li_task_reminder']['customerRemark'], $objCustomer->customerNumber, $objCustomer->customerName);
		}
		return $text;
	}

	private function getFormatedHTMLForTask($reminder, $objTask)
	{
		$text = "<h1>".$GLOBALS['TL_LANG']['tl_li_task_reminder']['subject']."</h1>";
		$text .= "<p>".sprintf($GLOBALS['TL_LANG']['tl_li_task_reminder']['text'], $objTask->title, date($GLOBALS['TL_CONFIG']['dateFormat'], $objTask->deadline))."</p>";
		if ($reminder->toCustomer != 0)
		{
			$objCustomer = $this->Database->prepare("SELECT customerNumber, customerName FROM tl_member WHERE id = ?")->limit(1)->execute($reminder->toCustomer);
			$text .= "<p>".sprintf($GLOBALS['TL_LANG']['tl_li_task_reminder']['customerRemark'], $objCustomer->customerNumber, $objCustomer->customerName)."</p>";
		}
		return $text;
	}

	private function prepareInvoiceReminder($reminder)
	{
		$arrReminder = array();

		$objInvoice = $this->Database->prepare("SELECT title, invoiceDate FROM tl_li_invoice WHERE id = ?")->limit(1)->execute($reminder->toInvoice);

		$arrReminder['from'] = $GLOBALS['TL_CONFIG']['li_crm_invoice_reminder_from'];
		$arrReminder['fromName'] = $GLOBALS['TL_CONFIG']['li_crm_invoice_reminder_fromName'];
		$arrReminder['subject'] = $GLOBALS['TL_LANG']['tl_li_invoice_reminder']['subject']." - ".$objInvoice->title;
		$arrReminder['invoiceDate'] = date('d.m.Y', $objInvoice->invoiceDate);

		$arrUserIds = deserialize($GLOBALS['TL_CONFIG']['li_crm_invoice_reminder_receiver']);
		$receiver = array();
		foreach ($arrUserIds as $userId)
		{
			$objUser = $this->Database->prepare("SELECT username, email FROM tl_user WHERE id = ?")->limit(1)->execute($userId);
			$receiver[] = $objUser->email;
		}
		$arrReminder['receiver'] = $receiver;

		$arrReminder['text'] = $this->getFormatedTextForInvoice($reminder, $objInvoice);
		$arrReminder['html'] = $this->getFormatedHTMLForInvoice($reminder, $objInvoice);

		$this->sendReminder($arrReminder);
	}

	private function getFormatedTextForInvoice($reminder, $objInvoice)
	{
		$text = $GLOBALS['TL_LANG']['tl_li_invoice_reminder']['subject']."\n\n";
		$text .= sprintf($GLOBALS['TL_LANG']['tl_li_invoice_reminder']['text'], $objInvoice->title, date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate));
		if ($reminder->toCustomer != 0)
		{
			$objCustomer = $this->Database->prepare("SELECT customerNumber, customerName FROM tl_member WHERE id = ?")->limit(1)->execute($reminder->toCustomer);
			$text .= "\n".sprintf($GLOBALS['TL_LANG']['tl_li_invoice_reminder']['customerRemark'], $objCustomer->customerNumber, $objCustomer->customerName);
		}
		return $text;
	}

	private function getFormatedHTMLForInvoice($reminder, $objInvoice)
	{
		$text = "<h1>".$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['subject']."</h1>";
		$text .= "<p>".sprintf($GLOBALS['TL_LANG']['tl_li_invoice_reminder']['text'], $objInvoice->title, date($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate))."</p>";
		if ($reminder->toCustomer != 0)
		{
			$objCustomer = $this->Database->prepare("SELECT customerNumber, customerName FROM tl_member WHERE id = ?")->limit(1)->execute($reminder->toCustomer);
			$text .= "<p>".sprintf($GLOBALS['TL_LANG']['tl_li_invoice_reminder']['customerRemark'], $objCustomer->customerNumber, $objCustomer->customerName)."</p>";
		}
		return $text;
	}

	private function sendReminder($arrReminder)
	{
		try
		{
			$objEmail = new Email();
			$objEmail->from = $arrReminder['from'];
			$objEmail->fromName = $arrReminder['fromName'];
			$objEmail->subject = $arrReminder['subject'];
			$objEmail->text = $arrReminder['text'];
			$objEmail->html = $arrReminder['html'];

			$objEmail->sendTo($arrReminder['receiver']);
		}
		catch( Exception $e )
		{
			$this->log('Reminder error: '.$e->getMessage(), __METHOD__, TL_ERROR);
		}
	}
}

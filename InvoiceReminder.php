<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

/**
 * Class InvoiceReminder
 */
class InvoiceReminder extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }

    public function getCustomerOptions($dc)
    {
        $customers = array();
        $objCustomers = $this->Database->prepare("
        	SELECT id, customerNumber, customerName
        	FROM tl_member AS m
        	WHERE disable = ''
        		AND (
        				SELECT COUNT(b.id)
        				FROM tl_li_invoice AS b
        				WHERE b.toCustomer = m.id
        			) > 0
        ")->execute();
        while ($objCustomers->next())
        {
            $customers[$objCustomers->id] = $objCustomers->customerNumber . " " . $objCustomers->customerName;
        }
        if (count($customers) == 0) {
            $customers[0] = "Kein Kunde";
        }
        return $customers;
    }

    public function getInvoiceOptions($dc)
    {
        $invoices = array();
        $objInvoices = $this->Database->prepare("SELECT id, title FROM tl_li_invoice WHERE toCustomer = ?")->execute($dc->activeRecord->toCustomer);
        while ($objInvoices->next())
        {
            $invoices[$objInvoices->id] = $objInvoices->title;
        }
        return $invoices;
    }

    public function getRemindDate($value, $dc)
    {
        if (true) {
            $objInvoice = $this->Database->prepare("SELECT invoiceDate FROM tl_li_invoice WHERE id = ?")->limit(1)->execute($dc->activeRecord->toInvoice);
            return $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objInvoice->invoiceDate);
        }
        else
        {
            return '';
        }
    }

    public function renderLabel($row, $label)
    {
        $objInvoice = $this->Database->prepare("SELECT title FROM tl_li_invoice WHERE id = ?")->limit(1)->execute($row['toInvoice']);
        if ($row['toCustomer'] == '0') {
            return $GLOBALS['TL_LANG']['tl_li_invoice_reminder']['noCustomer'] . " - " . $objInvoice->title;
        }
        else
        {
            $objCustomer = $this->Database->prepare("SELECT customerNumber, customerName FROM tl_member WHERE id = ?")->limit(1)->execute($row['toCustomer']);
            return $objCustomer->customerNumber . " " . $objCustomer->customerName . " - " . $objInvoice->title;
        }
    }
}

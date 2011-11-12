<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_invoice_settings']['invoice_data_legend'] = 'Invoice data';
$GLOBALS['TL_LANG']['tl_li_invoice_settings']['invoice_number_legend']= 'Invoice number';

$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_maturity'] = array('Maturity', 'Enter the amount of days the customer has left to pay the invoice.');
$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation']= array('Invoice number creation', 'Please enter a combination of text and insert tags that can be used to generate an invoice number. {{countInvoices::x}} returns the current amount of invoices. x determines how many zeroes are used to pad the number.');
$GLOBALS['TL_LANG']['tl_li_invoice_settings']['li_crm_invoice_number_generation_start']= array('Start value', 'Please enter a value that is set as a start value for generating invoice numbers. This way, invoice numbers can start at e.g. 100 instead of 1.');

$GLOBALS['TL_LANG']['tl_li_invoice_settings']['edit']= 'Edit invoice settings';
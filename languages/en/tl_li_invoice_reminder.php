<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * PHP version 5
 * @copyright  Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author     Christian Kolb <info@liplex.de>
 * @license    MIT (see /LICENSE.txt for further information)
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['toCustomer']       = array('Customer', 'Please choose a customer.');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['toInvoice']        = array('Invoice', 'Please choose a invoice.');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindOnce']       = array('Remind once', 'Should the remind be send once?');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindDate']       = array('Remind date', 'Please enter the date the remind should be send.');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindRepeatedly'] = array('Remind repeatedly', 'Should the remind be send repeatedly?');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']   = array('Interval', 'Please choose an iterval.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['reminder_legend']   = 'Reminder';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['once_legend']       = 'Once';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['repeatedly_legend'] = 'Repeatedly';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['noCustomer']                = 'No Customer';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['daily']   = 'Daily';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['weekly']  = 'Weekly';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['monthly'] = 'Monthly';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['remindInterval']['yearly']  = 'Yearly';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['subject']                   = 'Invoice reminder';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['text']                      = 'Invoice reminder for the invoice "%s" from %s.';
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['customerRemark']            = 'The invoice belongs to the customer "%s %s".';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['new']    = array('New reminder', 'Create a new reminder');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['edit']   = array('Edit reminder', 'Edit the reminder with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['copy']   = array('Copy reminder', 'Copy the reminder with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['delete'] = array('Delete reminder', 'Delete the reminder with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_reminder']['show']   = array('Show details of the reminder', 'Show the details of the reminder with the ID %s');

?>
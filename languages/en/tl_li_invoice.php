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
$GLOBALS['TL_LANG']['tl_li_invoice']['toCustomer']  = array('Customer', 'Please choose a customer.');
$GLOBALS['TL_LANG']['tl_li_invoice']['toCategory']  = array('Invoice category', 'Please choose a category.');
$GLOBALS['TL_LANG']['tl_li_invoice']['title']       = array('Title', 'Please enter a title.');
$GLOBALS['TL_LANG']['tl_li_invoice']['alias']       = array('Alias', 'Please enter a alias.');
$GLOBALS['TL_LANG']['tl_li_invoice']['price']       = array('Price', 'Please enter a price.');
$GLOBALS['TL_LANG']['tl_li_invoice']['invoiceDate'] = array('Billing date', 'Please enter the date of the bill.');
$GLOBALS['TL_LANG']['tl_li_invoice']['file']        = array('Invoice', 'Please choose the invoice.');
$GLOBALS['TL_LANG']['tl_li_invoice']['isOut']       = array('Outgoing invoice?', 'Is the invoice a outgoing one?');
$GLOBALS['TL_LANG']['tl_li_invoice']['isSingular']  = array('Singular invoice?', 'Is the invoice a singular one?');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_legend']  = 'Invoice';
$GLOBALS['TL_LANG']['tl_li_invoice']['pdf_legend']      = 'PDF file';
$GLOBALS['TL_LANG']['tl_li_invoice']['settings_legend'] = 'Settings';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_li_invoice']['income']         = 'Income';
$GLOBALS['TL_LANG']['tl_li_invoice']['expense']        = 'Expense';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_li_invoice']['new']    = array('New invoice', 'Create new invoice');
$GLOBALS['TL_LANG']['tl_li_invoice']['edit']   = array('Edit invoice', 'Edit the invoice with the id %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['copy']   = array('Copy invoice', 'Copy the invoice with the id %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['delete'] = array('Delete invoice', 'Delete the invoice with the id %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['show']   = array('Show invoice details', 'Show details of the invoice with the id %s');

$GLOBALS['TL_LANG']['tl_li_invoice']['reminder'] = array('Invoice reminder', 'Manage invoice reminder');

?>
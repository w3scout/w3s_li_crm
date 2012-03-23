<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_invoice_generation']['invoice_legend'] = 'Invoice';
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['generation_legend'] = 'Creation';
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['settings_legend'] = 'Settings';

$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toCustomer'] = array('Customer', 'Please choose a customer.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toCategory'] = array('Invoice category', 'Please choose an invoice category.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['title'] = array('Title', 'Please enter a title.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['alias'] = array('Alias', 'Please enter an alias.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['currency'] = array('Currency', 'Please choose the currency.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['maturity'] = array('Maturity', 'Enter the amount of days the customer has left to pay the invoice, if it differs from the standard and template settings.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['headline'] = array('Headline', 'Please enter a headline.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toTemplate'] = array('Invoice template', 'Please choose an invoice template.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['toAddress'] = array('Invoice address', 'Please choose an invoice address.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['descriptionBefore'] = array('Description', 'Please enter the description before the positions.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['servicePositions'] = array('Services', 'Please choose the service positions.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['productPositions'] = array('Products', 'Please choose the product positions.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['hourPositions'] = array('Hours', 'Please choose the hour positions.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['descriptionAfter'] = array('Description', 'Please enter the description after the positions.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['discount'] = array('Discount', 'Please enter the discount.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['publishImmediately'] = array('Publish invoice', 'Publish invoice immediately after creation.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['sendImmediately'] = array('Send invoice', 'Send the invoice immediately after creation.');

$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_quantity'] = array('Quantity', 'Please enter the quantity for this position.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_unit'] = array('Unit', 'Please choose the unit for this position.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_item'] = array('Reference', 'Please choose the reference in the crm.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_label'] = array('Label', 'Please enter the label for this position.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_unit_price'] = array('Unit price', 'Please enter the unit price for this position.');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['position_total_price'] = 'Total price';

$GLOBALS['TL_LANG']['tl_li_invoice_generation']['new'] = array('New invoice generation', 'Create a new invoice generation');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['edit'] = array('Edit invoice generation', 'Edit the invoice generation with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['copy'] = array('Duplicate invoice generation', 'Duplicate the invoice generation with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['delete'] = array('Delete invoice generation', 'Delete the invoice generation with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['show'] = array('Show invoice generation', 'Show the invoice generation with the ID %s');

$GLOBALS['TL_LANG']['tl_li_invoice_generation']['discountOptions']['percent'] = '%';
$GLOBALS['TL_LANG']['tl_li_invoice_generation']['discountOptions']['value'] = 'Value';
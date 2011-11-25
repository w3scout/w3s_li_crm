<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_legend'] = 'Invoice';
$GLOBALS['TL_LANG']['tl_li_invoice']['pdf_legend'] = 'PDF-File';
$GLOBALS['TL_LANG']['tl_li_invoice']['settings_legend'] = 'Settings';
$GLOBALS['TL_LANG']['tl_li_invoice']['generation_legend'] = 'Creation';

$GLOBALS['TL_LANG']['tl_li_invoice']['toCustomer'] = array('Customer', 'Please choose a customer.');
$GLOBALS['TL_LANG']['tl_li_invoice']['toCategory'] = array('Invoice category', 'Please choose an invoice category.');
$GLOBALS['TL_LANG']['tl_li_invoice']['title'] = array('Title', 'Please enter a title.');
$GLOBALS['TL_LANG']['tl_li_invoice']['alias'] = array('Alias', 'Please enter an alias.');
$GLOBALS['TL_LANG']['tl_li_invoice']['invoiceDate'] = array('Invoice date', 'Please enter the invoice date.');
$GLOBALS['TL_LANG']['tl_li_invoice']['performanceDate'] = array('Performance date', 'Please enter the performance date.');
$GLOBALS['TL_LANG']['tl_li_invoice']['price'] = array('Price', 'Please enter the price.');
$GLOBALS['TL_LANG']['tl_li_invoice']['currency'] = array('Currency', 'Please choose the currency.');
$GLOBALS['TL_LANG']['tl_li_invoice']['maturity'] = array('Maturity', 'Enter the amount of days the customer has left to pay the invoice, if it differs from the standard and template settings.');
$GLOBALS['TL_LANG']['tl_li_invoice']['file'] = array('Invoice', 'Please choose an invoice.');
$GLOBALS['TL_LANG']['tl_li_invoice']['isOut'] = array('Outgoing', 'Is the invoice outgoing?');
$GLOBALS['TL_LANG']['tl_li_invoice']['isSingular'] = array('Singular', 'Is the invoice singular?');
$GLOBALS['TL_LANG']['tl_li_invoice']['enableGeneration'] = array('Activate creation', 'Activate automatic creation.');
$GLOBALS['TL_LANG']['tl_li_invoice']['headline'] = array('Headline', 'Please enter a headline.');
$GLOBALS['TL_LANG']['tl_li_invoice']['toTemplate'] = array('Invoice template', 'Please choose an invoice template.');
$GLOBALS['TL_LANG']['tl_li_invoice']['toAddress'] = array('Invoice address', 'Please choose an invoice address.');
$GLOBALS['TL_LANG']['tl_li_invoice']['descriptionBefore'] = array('Description', 'Please enter the description before the positions.');
$GLOBALS['TL_LANG']['tl_li_invoice']['descriptionAfter'] = array('Description', 'Please enter the description after the positions.');

$GLOBALS['TL_LANG']['tl_li_invoice']['new'] = array('New invoice', 'Create a new invoice');
$GLOBALS['TL_LANG']['tl_li_invoice']['edit'] = array('Edit invoice', 'Edit the invoice with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['copy'] = array('Duplicate invoice', 'Duplicate the invoice with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['delete'] = array('Delete invoice', 'Delete the invoice with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['show'] = array('Show invoice', 'Show the invoice with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['generate'] = array('Generate invoice', 'Generate the invoice with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch'] = array('Dispatch invoice', 'Dispatch the invoice with the ID %s to the customer');
$GLOBALS['TL_LANG']['tl_li_invoice']['reports'] = array('Reports', 'Show the reports for the invoices');
$GLOBALS['TL_LANG']['tl_li_invoice']['reminder'] = array('Reminders', 'Manage invoice reminders');
$GLOBALS['TL_LANG']['tl_li_invoice']['showFile'] = array('Show invoice file', 'Show the invoice file with the ID %s');
$GLOBALS['TL_LANG']['tl_li_invoice']['downloadFile'] = array('Download invoice', 'Download the invoice with the ID %s');

$GLOBALS['TL_LANG']['tl_li_invoice']['report_month'] = 'Invoiceprocess - Month overview';
$GLOBALS['TL_LANG']['tl_li_invoice']['report_year'] = 'Invoiceprocess - Year overview';
$GLOBALS['TL_LANG']['tl_li_invoice']['report_income'] = 'Income';
$GLOBALS['TL_LANG']['tl_li_invoice']['report_expenses'] = 'Expenses';

$GLOBALS['TL_LANG']['tl_li_invoice']['income'] = 'Income';
$GLOBALS['TL_LANG']['tl_li_invoice']['expense'] = 'Expense';
$GLOBALS['TL_LANG']['tl_li_invoice']['tax_number'] = 'Tax number';
$GLOBALS['TL_LANG']['tl_li_invoice']['date'] = 'Date';
$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_number'] = 'Invoice number';
$GLOBALS['TL_LANG']['tl_li_invoice']['introduction_male'] = 'Dear Mr. %s<br />for your order we charge the following services.';
$GLOBALS['TL_LANG']['tl_li_invoice']['introduction_female'] = 'Dear Ms. %s<br />for your order we charge the following services.';
$GLOBALS['TL_LANG']['tl_li_invoice']['servicePositions'] = array('Services', 'Please choose the service positions.');
$GLOBALS['TL_LANG']['tl_li_invoice']['productPositions'] = array('Products', 'Please choose the product positions.');
$GLOBALS['TL_LANG']['tl_li_invoice']['hourPositions'] = array('Hours', 'Please choose the hour positions.');
$GLOBALS['TL_LANG']['tl_li_invoice']['position_quantity'] = array('Quantity', 'Please enter the quantity for this position.');
$GLOBALS['TL_LANG']['tl_li_invoice']['position_unit'] = array('Unit', 'Please choose the unit for this position.');
$GLOBALS['TL_LANG']['tl_li_invoice']['position_item'] = array('Reference', 'Please choose the reference in the crm.');
$GLOBALS['TL_LANG']['tl_li_invoice']['position_label'] = array('Label', 'Please enter the label for this position.');
$GLOBALS['TL_LANG']['tl_li_invoice']['position_total_price'] = 'Total price';
$GLOBALS['TL_LANG']['tl_li_invoice']['performance_is_invoice_date'] = 'The invoice date is the performance date.';
$GLOBALS['TL_LANG']['tl_li_invoice']['performance_date_at'] = 'Performance date: %s';
$GLOBALS['TL_LANG']['tl_li_invoice']['account_data'] = 'Account';
$GLOBALS['TL_LANG']['tl_li_invoice']['account_number'] = 'Account number';
$GLOBALS['TL_LANG']['tl_li_invoice']['bank_code'] = 'Bank code';
$GLOBALS['TL_LANG']['tl_li_invoice']['bank'] = 'Bank name';
$GLOBALS['TL_LANG']['tl_li_invoice']['maturity_remark'] = 'Please transfer the invoice total within the next %s days.';
$GLOBALS['TL_LANG']['tl_li_invoice']['greeting'] = 'Sincerely,<br />%s';

$GLOBALS['TL_LANG']['tl_li_invoice']['service'] = 'Services';
$GLOBALS['TL_LANG']['tl_li_invoice']['products'] = 'Products';
$GLOBALS['TL_LANG']['tl_li_invoice']['hours'] = 'Hours';

$GLOBALS['TL_LANG']['tl_li_invoice']['total_netto'] = 'Total cost (net)';
$GLOBALS['TL_LANG']['tl_li_invoice']['total_brutto'] = 'Total cost (gross)';
$GLOBALS['TL_LANG']['tl_li_invoice']['tax'] = 'Tax';

$GLOBALS['TL_LANG']['tl_li_invoice']['units']['unit'] = 'Unit';
$GLOBALS['TL_LANG']['tl_li_invoice']['units']['hour'] = 'Hour';
$GLOBALS['TL_LANG']['tl_li_invoice']['units']['month'] = 'Month';
$GLOBALS['TL_LANG']['tl_li_invoice']['units']['year'] = 'Year';

$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_generation'] = 'Invoice creation';
$GLOBALS['TL_LANG']['tl_li_invoice']['generation_success'] = 'The invoice was successfully created.';
$GLOBALS['TL_LANG']['tl_li_invoice']['back_overview'] = 'Back to the overview';

$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_subject'] = 'Invoice';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_male'] = 'Dear Mr. %s,\n\nattached the invoice of %s.\n\nBest regards\n%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_text_female'] = 'Dear Mrs. %s,\n\nattached the invoice of %s.\n\nBest regards\n%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_male'] = 'Dear Mr. %s,<br /><br />attached the invoice of %s.<br /><br />Best regards<br />%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_html_female'] = 'Dear Mrs. %s,<br /><br />attached the invoice of%s.<br /><br />Best regards<br />%s';
$GLOBALS['TL_LANG']['tl_li_invoice']['invoice_dispatch'] = 'Invoice dispatch';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_successful'] = 'The invoice was delivered successful.';
$GLOBALS['TL_LANG']['tl_li_invoice']['dispatch_failed'] = 'The invoice could not be delivered successful. For more information view the system log.';
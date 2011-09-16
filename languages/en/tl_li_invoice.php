<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_invoice'] = array(
    'toCustomer'        => array('Customer', 'Please choose a customer.'),
    'toCategory'        => array('Invoice category', 'Please choose an invoice category.'),
    'title'             => array('Title', 'Please enter a title.'),
    'alias'             => array('Alias', 'Please enter an alias.'),
    'invoiceDate'       => array('Invoice date', 'Please enter the invoice date.'),
    'performanceDate'   => array('Performance date', 'Please enter the performance date.'),
    'price'             => array('Price', 'Please enter the price.'),
    'file'              => array('Invoice', 'Please choose an invoice.'),
    'isOut'             => array('Outgoing', 'Is the invoice outgoing?'),
    'isSingular'        => array('Singular', 'Is the invoice singular?'),
    'enableGeneration'  => array('Activate creation', 'Activate automatic creation.'),
    'toTemplate'        => array('Invoice template', 'Please choose an invoice template.'),
    'toAddress'         => array('Invoice address', 'Please choose an invoice address.'),
    
    'invoice_legend'    => 'Invoice',
    'pdf_legend'        => 'PDF-File',
    'settings_legend'   => 'Settings',
    'generation_legend' => 'Creation',
    
    'income'                => 'Income',
    'expense'               => 'Expense',
    'tax_number'            => 'Tax number',
    'date'                  => 'Date',
    'invoice_number'        => 'Invoice number',
    'introduction_male'     => 'Dear Mr. %s<br />for your order we charge the following services.',
    'introduction_female'   => 'Dear Ms. %s<br />for your order we charge the following services.',
    'position_quantity'     => 'Amount',
    'position_unit'         => 'Unit',
    'position_label'        => 'Label',
    'position_tax'          => 'Tax',
    'position_unit_price'   => 'Unit price',
    'position_total_price'  => 'Total price',
    'service_remark'        => 'The invoice date is the performance date.',
    'transfer_remark'       => 'Please transfer the amount to the following account within the next two weeks.',
    'account_data'          => 'Account',
    'account_number'        => 'Account number',
    'bank_code'             => 'Bank code',
    'bank'                  => 'Bank name',
    'greeting'              => 'Sincerely,<br />%s',
    
    'total_netto'   => 'Total cost (net)',
    'total_brutto'  => 'Total cost (gross)',
    'tax'           => 'VAT',
    
    'units' => array(
        'unit'  => 'Unit',
        'hour'  => 'Hour',
        'month' => 'Month',
        'year'  => 'Year',
    ),
    
    'invoice_generation'    => 'Invoice creation',
    'path_introduction'     => 'The invoice was successfully created and saved at the given path.',
    'path'                  => 'Path',
    'back_overview'         => 'Back to the overview',
    
    'new'       => array('New invoice', 'Create new invoice'),
    'edit'      => array('Edit invoice', 'Edit invoice %s'),
    'copy'      => array('Duplicate invoice', 'Duplicate invoice %s'),
    'delete'    => array('Delete invoice', 'Delete invoice %s'),
    'show'      => array('Show invoice', 'Show invouce %s'),
    
    'reminder' => array('Invoice reminder', 'Manage invoice reminder'),
);

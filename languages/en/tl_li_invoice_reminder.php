<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_invoice_reminder'] = array(
    'toCustomer'        => array('Customer', 'Please choose a customer.'),
    'toInvoice'         => array('Invoice', 'Please choose an invoice.'),
    'remindOnce'        => array('Remind once', 'Create a single reminder.'),
    'remindDate'        => array('Remind date', 'Please choose a date when the reminder should be sent.'),
    'remindRepeatedly'  => array('Remind repeatedly', 'Create a repeated reminder.'),
    'remindInterval'    => array('Interval', 'Please choose an interval.'),
    
    'reminder_legend'   => 'Reminder',
    'once_legend'       => 'Once',
    'repeatedly_legend' => 'Repeatedly',
    
    'noCustomer'    => 'No customer',
    
    'remindInterval' => array(
        'daily'     => 'Daily',
        'weekly'    => 'Weekly',
        'monthly'   => 'Monthly',
        'yearly'    => 'Yearly',
    ),
    
    'subject'           => 'Invoice reminder',
    'text'              => 'Invoice reminder for invoice "%s" form %s.',
    'customerRemark'    => 'The invoce is for "%s %s".',
    
    'new'       => array('New reminder', 'Create a new reminder'),
    'edit'      => array('Edit reminder', 'Edit reminder %s'),
    'copy'      => array('Duplicate reminder', 'Duplicate reminder %s'),
    'delete'    => array('Delete reminder', 'Delete reminder %s'),
    'show'      => array('Show reminder', 'Show reminder %s'),
);

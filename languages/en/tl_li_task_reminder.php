<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_task_reminder'] = array(
    'noProject'     => 'No project',
    'noCustomer'    => 'No customer',
    
    'toCustomer'        => array('Customer', 'Please choose a customer.'),
    'toTask'            => array('Task', 'Please choose a task. (Tasks whos deadline has passed will not be shown!)'),
    'remindOnce'        => array('Remind once', 'Create a single reminder'),
    'remindDate'        => array('Remind date', 'Please choose a date when the reminder should be sent.'),
    'remindRepeatedly'  => array('Remind repeatedly', 'Create a repeated reminder.'),
    'remindInterval'    => array('Interval', 'Please choose an interval.'),
    
    'reminder_legend'   => 'Reminder',
    'once_legend'       => 'Once',
    'repeatedly_legend' => 'Repeatedly',
    
    'remindInterval' => array(
        'daily'     => 'Daily',
        'weekly'    => 'Weekly',
        'monthly'   => 'Monthly',
        'yearly'    => 'Yearly',
    ),
    'subject'           => 'Task reminder',
    'text'              => 'Task reminder for "%s", due on %s.',
    'customerRemark'    => 'The task is for "%s %s".',
    
    'new'       => array('Create reminder', 'Create a new task reminder'),
    'edit'      => array('Edit reminder', 'Edit reminder %s'),
    'copy'      => array('Duplicate reminder', 'Duplicate reminder %s'),
    'delete'    => array('Delete reminder', 'Delete reminder %s'),
    'show'      => array('Show reminder', 'Show reminder %s'),
);

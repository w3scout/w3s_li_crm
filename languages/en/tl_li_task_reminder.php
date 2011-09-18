<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */

$GLOBALS['TL_LANG']['tl_li_task_reminder']['reminder_legend'] = 'Reminder';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['once_legend'] = 'Once';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['repeatedly_legend'] = 'Repeatedly';

$GLOBALS['TL_LANG']['tl_li_task_reminder']['toCustomer'] = array('Customer', 'Please choose a customer.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['toTask'] = array('Task', 'Please choose a task. (Tasks whos deadline has passed will not be shown!)');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindOnce'] = array('Remind once', 'Create a single reminder');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindDate'] = array('Remind date', 'Please choose a date when the reminder should be sent.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindRepeatedly'] = array('Remind repeatedly', 'Create a repeated reminder.');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval'] = array('Interval', 'Please choose an interval.');

$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['daily'] = 'Daily';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['weekly'] = 'Weekly';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['monthly'] = 'Monthly';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['remindInterval']['yearly'] = 'Yearly';

$GLOBALS['TL_LANG']['tl_li_task_reminder']['new'] = array('Create reminder', 'Create a new task reminder');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['edit'] = array('Edit reminder', 'Edit the reminder with the ID %s');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['copy'] = array('Duplicate reminder', 'Duplicate the reminder with the ID %s');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['delete'] = array('Delete reminder', 'Delete the reminder with the ID %s');
$GLOBALS['TL_LANG']['tl_li_task_reminder']['show'] = array('Show reminder', 'Show the reminder with the ID %s');

$GLOBALS['TL_LANG']['tl_li_task_reminder']['noProject'] = 'No project';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['noCustomer'] = 'No customer';

$GLOBALS['TL_LANG']['tl_li_task_reminder']['subject'] = 'Task reminder';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['text'] = 'Task reminder for "%s", due on %s.';
$GLOBALS['TL_LANG']['tl_li_task_reminder']['customerRemark'] = 'The task is for "%s %s".';
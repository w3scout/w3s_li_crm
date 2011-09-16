<?php
if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

/**
 * @copyright   Liplex Webprogrammierung und -design Christian Kolb 2011
 * @author      Christian Kolb <info@liplex.de>
 * @author      ApoY2k <apoy2k@gmail.com>
 * @license     MIT (see /LICENSE.txt for further information)
 */
$GLOBALS['TL_LANG']['tl_li_contact'] = array(
    'title'         => array('Title', 'Please enter a title.'),
    'category'      => array('Category', 'Please choose a category.'),
    'startDate'     => array('Start date', 'Please enter a start date according to the global date format.'),
    'startTime'     => array('Start time', 'Please enter a start time.'),
    'addEnd'        => array('Add end', 'Add end date and time to the contact.'),
    'endDate'       => array('End date', 'Leave the field empty to create a one-day contact.'),
    'endTime'       => array('End time', 'Enter the same time as start time to create a contact with an open end.'),
    'result'        => array('Result', 'Please choose a result.'),
    'direction'     => array('Direction', 'Please choose a direction.'),
    'note'          => array('Note', 'Please enter a note.'),
    'addAttachment' => array('Add attachment', 'Add an attachment to the contact.'),
    'attachment'    => array('Attachment', 'Please choose an attachment.'),
    
    'contact_legend'    => 'Contact',
    'date_legend'       => 'Date and time',
    'note_legend'       => 'Note',
    'attachment_legend' => 'Attachment',
    
    'categorys' => array(
        'phone'     => 'Phone',
        'email'     => 'E-Mail',
        'mail'      => 'Mail',
        'fax'       => 'Fax',
        'direct'    => 'Visit',
    ),
    'results' => array(
        'reached'       => 'Reached',
        'not_reached'   => 'Not reached',
    ),
    'directions' => array(
        'incoming'  => 'Incoming',
        'outgoing'  => 'Outgoing',
    ),
    
    'new'       => array('New contact', 'Create a new contact'),
    'edit'      => array('Edit contact', 'Edit contact %s'),
    'copy'      => array('Duplicate contact', 'Duplicate contact %s'),
    'delete'    => array('Delete contact', 'Delete contact %s'),
    'show'      => array('Show contact', 'Show details of contact %s'),
);
